<?php

namespace HDSSolutions\Finpar\DataTables;

use HDSSolutions\Finpar\Models\File as Resource;
use Yajra\DataTables\Html\Column;

class FileDataTable extends Base\DataTable {

    protected array $orderBy = [
        'created_at',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.files'),
        );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('backend/file.id.0') )
                ->hidden(),

            Column::computed('url')
                ->title( __('backend/file.url.0') )
                ->renderRaw('image:url'),

            Column::make('name')
                ->title( __('backend/file.name.0') ),

            Column::computed('created_at')
                ->title( __('backend/file.created_at.0') )
                ->hidden(),

            Column::computed('actions'),
        ];
    }

}
