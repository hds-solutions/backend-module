<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\User as Resource;
use Yajra\DataTables\Html\Column;

class UserDataTable extends Base\DataTable {

    protected array $orderBy = [
        'lastname'  => 'asc',
        'firstname' => 'asc',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.users'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('backend::user.id.0') )
                ->hidden(),

            Column::make('firstname')
                ->title( __('backend::user.firstname.0') ),

            Column::make('lastname')
                ->title( __('backend::user.lastname.0') ),

            Column::make('email')
                ->title( __('backend::user.email.0') ),

            Column::computed('actions'),
        ];
    }

}
