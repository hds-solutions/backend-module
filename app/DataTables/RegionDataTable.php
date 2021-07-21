<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Region as Resource;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class RegionDataTable extends Base\DataTable {

    protected array $orderBy = [
        'name'  => 'asc',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.regions'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('backend::region.id.0') )
                ->hidden(),

            Column::make('name')
                ->title( __('backend::region.name.0') ),

            Column::computed('actions'),
        ];
    }

}
