<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Role as Resource;
use Yajra\DataTables\Html\Column;

class RoleDataTable extends Base\DataTable {

    protected array $orderBy = [
        'name'  => 'asc',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.roles'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('backend::role.id.0') )
                ->hidden(),

            Column::make('name')
                ->title( __('backend::role.name.0') ),

            Column::computed('actions'),
        ];
    }

}
