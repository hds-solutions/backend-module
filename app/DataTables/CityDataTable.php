<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\City as Resource;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class CityDataTable extends Base\DataTable {

    protected array $with = [
        'region'
    ];

    protected array $orderBy = [
        'region.name'   => 'asc',
        'name'          => 'asc',
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

    protected function joins(Builder $query):Builder {
        // add custom JOIN to regions
        return $query->join('regions', 'regions.id', 'cities.region_id');
    }

    protected function orderRegionName(Builder $query, string $order):Builder {
        // order by Region.name
        return $query->orderBy('regions.name', $order);
    }

    protected function filterRegion(Builder $query, $region_id):Builder {
        // filter only from region
        return $query->where('region_id', $region_id);
    }

}
