<?php

namespace HDSSolutions\Finpar\DataTables\Base;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

abstract class DataTable extends \Yajra\DataTables\Services\DataTable {

    protected array $with = [];

    protected array $orderBy = [];

    public function __construct(
        protected string $resource,
        protected string $route,
    ) {}

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public final function dataTable($query) {
        // return datatable class for current eloquent model
        return datatables()->eloquent($query);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Resource $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public final function query() {
        // return new query for current eloquent model
        $query = (new $this->resource)->newQuery();
        //
        if (count($this->with) > 0)
            //
            $query->with( $this->with );
        //
        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public final function html() {
        // return builder with custom columns
        return $this->builder()
                    ->setTableId( class_basename($this->resource).'-datatable')
                    ->autoWidth(false)
                    ->addTableClass('table-bordered table-sm table-hover')
                    ->columns($this->getColumns())
                    ->minifiedAjax( $this->route )
                    ->searchDelay(150)
                    // TODO: FIX: order by
                    // ->orderBy( $this->orderBy )
                    /*->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload'),
                    )*/;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected abstract function getColumns();

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected final function filename() {
        return class_basename( $this->resource ).'_' . date('YmdHis');
    }

}
