<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\BelongsToCompany;

abstract class X_Branch extends Base\Model {
    use BelongsToCompany;

    protected $orderBy = [
        'name'  => 'ASC',
    ];

    protected $fillable = [
        'company_id',
        'name',
        'code',
        'region_id',
        'city_id',
        'district',
        'address',
        'phone',
        'latitude',
        'longitude',
    ];

    protected static $rules = [
        'name'      => [ 'required', 'min:5' ],
        'code'      => [ 'sometimes', 'nullable' ],
        'region_id' => [ 'required' ],
        'city_id'   => [ 'required' ],
        'district'  => [ 'sometimes', 'nullable', 'min:4' ],
        'address'   => [ 'required', 'min:8' ],
        'phone'     => [ 'sometimes', 'nullable' ],
        'latitude'  => [ 'sometimes', 'nullable', 'numeric' ],
        'longitude' => [ 'sometimes', 'nullable', 'numeric' ],
    ];

}
