<?php

namespace HDSSolutions\Finpar\DataTables;

use HDSSolutions\Finpar\Models\Company as Resource;
use Yajra\DataTables\Html\Column;

class CompanyDataTable extends Base\DataTable {

    protected array $with = [
        'logo',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.companies'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('backend/company.id.0') )
                ->hidden(),

            Column::computed('logo')
                ->title( __('backend/company.logo.0') )
                ->renderRaw('image:logo.url'),

            Column::make('name')
                ->title( __('backend/company.name.0') ),

            Column::computed('actions'),
        ];
    }

}
