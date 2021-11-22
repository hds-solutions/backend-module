<?php

namespace HDSSolutions\Laravel\DataTables\Base;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

abstract class DataTable extends \Yajra\DataTables\Services\DataTable {

    protected array $with = [];

    protected array $withCount = [];

    protected array $withoutScopes = [];

    protected array $orderBy = [];

    private array $filters = [];

    public function __construct(
        protected string $resource,
        protected string $route,
    ) {
        // check if request has order specified
        if (request()->has('order'))
            // prepend request order columns before default order
            $this->orderBy = $this->getRequestOrder() + $this->orderBy;
        // check if request has filters
        if (request()->has('filters'))
            // save filters
            $this->filters = request('filters');
    }

    public final function dataTable($query) {
        // disable scopes
        foreach ($this->withoutScopes as $scope)
            // remove global scope
            $query = $query->withoutGlobalScope(new $scope);
        // add custom JOINs
        if (method_exists($this, 'joins')) $query = $this->joins($query);
        // add custom global filters
        if (method_exists($this, 'filters')) $query = $this->filters($query);
        // get datatable class for current eloquent model query
        $datatable = datatables()->of( $query )
            // redirect order by
            ->order(fn(Builder $query) => $this->order($query));

        // foreach registered columns
        foreach ($this->getColumns() as $column) {
            // get search method name for current column
            $searchMethod = $this->searchMethod( $column['name'] );
            // ignore column if method doesn't exists
            if (!method_exists($this, $searchMethod)) continue;
            // register custom search method for column
            $datatable->filterColumn($column['name'], fn($query, $value) => $this->$searchMethod($query, $value));
        }

        // custom filters
        $datatable->filter(function($query) {
            // foreach filters
            foreach ($this->filters as $filter => $value) {
                // get filter method name for current filter
                $filterMethod = $this->filterMethod( $filter );
                // check if method exists
                if (method_exists($this, $filterMethod))
                    // execure custom method and return
                    $query = $this->$filterMethod($query, $value);
            }
            // return filtered query
            return $query;
        // register global filtering
        }, true);

        // return configured datatable
        return $datatable;
    }

    public final function query():Builder {
        // get query builder
        $query = $this->newQuery();
        // append with's to query builder
        if (count($this->with) > 0) $query->with( $this->with );
        // append withCount's to query builder
        if (count($this->withCount) > 0) $query->withCount( $this->withCount );
        // return query
        return $query;
    }

    protected function newQuery():Builder {
        // return new query for current eloquent model
        return ($resource = new $this->resource)->newQuery()
            // select only resource table data (custom joins breaks data)
            ->select("{$resource->getTable()}.*");
    }

    protected function getTableId():string {
        return class_basename($this->resource).'-datatable';
    }

    protected function parameters():array {
        return [];
    }

    public final function html() {
        // get builder for current DataTable
        $builder = $this->builder()
            ->setTableId( $this->getTableId() )
            ->autoWidth(false)
            ->addTableClass('table-bordered table-sm table-hover')
            ->columns( $this->getColumns() )
            ->minifiedAjax( $this->route )
            ->searchDelay(150);
        // custom parameters
        $builder->parameters( $this->parameters() + [
            // load datatables translations
            'language' => __('backend::datatables')
        ] );

        // load registered columns
        $columns = collect($this->getColumns());
        // foreach default orderBy columns
        foreach ($this->orderBy as $column => $order) {
            // find column in registered ones
            $tableColumn = $columns->firstWhere('name', $column);
            // special case for document_status
            if ($column === 'document_status' && $tableColumn === null)
                // find alias column
                $tableColumn = $columns->firstWhere('name', 'document_status_pretty');

            // ignore if column isn't registered
            if ($tableColumn === null) continue;

            // add column as default order
            $builder->orderBy($columns->search($tableColumn), $order);
        }

        // return configured builder
        return $builder;
    }

    protected abstract function getColumns();

    protected final function filename() { return class_basename( $this->resource ).'_' . date('YmdHis'); }

    private function getRequestOrder():array {
        // get registered columns
        $columns = $this->getColumns();
        $newOrder = [];

        // parse request[order] values
        foreach (request('order') as $order) {
            // check if column is on default list
            if (array_key_exists(($column = $columns[ $order['column'] ])['name'], $this->orderBy))
                // remove from array
                unset($this->orderBy[ $column['name'] ]);

            // special case for document_status
            if (in_array($column['name'], [ 'document_status', 'document_status_pretty' ])) {
                // remove from array
                unset($this->orderBy[ 'document_status' ]);
                unset($this->orderBy[ 'document_status_pretty' ]);
                // override colum name
                $column['name'] = 'document_status';
            }

            // add column with order direction
            $newOrder[ $column['name'] ] = $order['dir'];
        }

        // return new order
        return $newOrder;
    }

    private function order(Builder $query):Builder {
        // foreach selected columns to order by
        foreach ($this->orderBy as $column => $order) {
            // build method name
            $orderMethod = $this->orderMethod( $order->column['name'] ?? $column );
            // check if method exists
            if (method_exists($this, $orderMethod))
                // execure custom method and return
                $query = $this->$orderMethod($query, $order->order ?? $order);
            else
                // order by column name
                $query->orderBy($order->column['name'] ?? $column, $order->order ?? $order);
        }
        // return query with orderBy's
        return $query;
    }

    private function columnMethod(string $columnName, string $type):string {
        // return posible method name for column
        return $type.Str::studly( str_replace('.', '_', $columnName) );
    }

    private function orderMethod(string $columnName):string {
        // return method name for ordering
        return $this->columnMethod($columnName, 'order');
    }

    private function searchMethod(string $columnName):string {
        // return method name for ordering
        return $this->columnMethod($columnName, 'search');
    }

    private function filterMethod(string $columnName):string {
        // return method name for ordering
        return $this->columnMethod($columnName, 'filter');
    }

}
