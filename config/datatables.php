<?php

use HDSSolutions\Laravel\DataTables\Base\DataTableEngine;
use Yajra\DataTables\{ QueryDataTable, CollectionDataTable, ApiResourceDataTable };

return [

    'engines'        => [
        // define custom for eloquent DataTables
        'eloquent'   => DataTableEngine::class,

        // fallback to defaults
        'query'      => QueryDataTable::class,
        'collection' => CollectionDataTable::class,
        'resource'   => ApiResourceDataTable::class,
    ],

];
