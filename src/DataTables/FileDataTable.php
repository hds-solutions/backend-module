<?php

namespace HDSSolutions\Finpar\DataTables;

use HDSSolutions\Finpar\Models\File as Resource;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FileDataTable extends DataTable {
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query) {
        // return datatable class for current eloquent model
        return datatables()->eloquent($query);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Resource $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Resource $model) {
        // return new query for current eloquent model
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html() {
        // return builder with custom columns
        return $this->builder()
                    // ->setTableId('user-table')
                    ->columns($this->getColumns())
                    // ->postAjax( route('backend.users') );
                    // ->dom('Bfrtip')
                    ->orderBy(1);
                    // ->buttons(
                    //     Button::make('create'),
                    //     Button::make('export'),
                    //     Button::make('print'),
                    //     Button::make('reset'),
                    //     Button::make('reload'),
                    // );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns() {
        return [
            Column::make('id')->title( __('backend/user.id.0') )->hidden(),
            Column::make('name')->title( __('backend/user.name.0') ),
            Column::make('actions'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename() {
        return basename(Resource::class).'_' . date('YmdHis');
    }

}
