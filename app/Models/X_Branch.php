<?php

namespace HDSSolutions\Finpar\Models;

use App\Models\Base\Model;
use HDSSolutions\Finpar\Traits\BelongsToCompany;

abstract class X_Branch extends Base\Model {
    use BelongsToCompany;

    protected $fillable = [
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

    protected static $createRules = [
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

    protected static $updateRules = [
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
