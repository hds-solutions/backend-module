<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Company as Resource;
use Yajra\DataTables\Html\Column;

class CompanyDataTable extends Base\DataTable {

    protected array $withCount = [
        'branches',
    ];

    protected array $with = [
        'logo',
    ];

    protected array $orderBy = [
        'name'  => 'asc',
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
                ->title( __('backend::company.id.0') )
                ->hidden(),

            Column::computed('logo')
                ->title( __('backend::company.logo_id.0') )
                ->renderRaw('image:logo.url'),

            Column::make('ftid')
                ->title( __('backend::company.ftid.0') ),

            Column::make('name')
                ->title( __('backend::company.name.0') ),

            // Column::computed('branches')
            //     ->title( __('backend::company.branches.0') )
            //     ->renderRaw('view:company')
            //     ->data( view('backend::companies.datatable.branches')->render() )
            //     ->class('w-150px'),

            Column::computed('actions'),
        ];
    }

}
