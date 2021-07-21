<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Branch as Resource;
use HDSSolutions\Laravel\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class BranchDataTable extends Base\DataTable {

    protected array $with = [
        'company',
    ];

    protected array $orderBy = [
        'company.name'  => 'asc',
        'name'          => 'asc',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.branches'),
        );
        // remove CompanyScope if we are on global scope
        if (!backend()->companyScoped()) $this->withoutScopes[] = CompanyScope::class;
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('backend::branch.id.0') )
                ->hidden(),

            Column::make('company.name')
                ->title( __('backend::branch.company_id.0') ),

            Column::make('name')
                ->title( __('backend::branch.name.0') ),

            Column::computed('actions'),
        ];
    }

    protected function joins(Builder $query):Builder {
        // add custom JOIN to companies
        return $query->join('companies', 'companies.id', 'branches.company_id');
    }

    protected function orderCompanyName(Builder $query, string $order):Builder {
        // order by Company.name
        return $query->orderBy('companies.name', $order);
    }

    protected function filterCompany(Builder $query, $company_id):Builder {
        // filter only from company
        return $query->where('company_id', $company_id);
    }

}
