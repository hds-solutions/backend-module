<?php

namespace HDSSolutions\Finpar\DataTables;

use HDSSolutions\Finpar\Models\Branch as Resource;
use Yajra\DataTables\Html\Column;

class BranchDataTable extends Base\DataTable {

    protected array $with = [
        'company',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.branches'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('backend::branch.id.0') )
                ->hidden(),

            Column::computed('company.name')
                ->title( __('backend::branch.company_id.0') ),

            Column::make('name')
                ->title( __('backend::branch.name.0') ),

            Column::computed('actions'),
        ];
    }

}
