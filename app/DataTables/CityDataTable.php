<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\City as Resource;
use Yajra\DataTables\Html\Column;

class CityDataTable extends Base\DataTable {

    protected array $with = [
        'region'
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.cities'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('backend::city.id.0') )
                ->hidden(),

            Column::make('region.name')
                ->title( __('backend::city.region_id.0') ),

            Column::make('name')
                ->title( __('backend::city.name.0') ),

            Column::make('actions'),
        ];
    }

}
