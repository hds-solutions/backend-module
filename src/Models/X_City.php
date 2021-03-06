<?php

namespace HDSSolutions\Finpar\Models;

use App\Models\Base\Model;

abstract class X_City extends Model {

    protected $sortBy = 'name';

    protected $fillable = [
        'region_id',
        'name',
    ];

    protected static $createRules = [
        'region_id'     => [ 'required' ],
        'name'          => [ 'required', 'min:4' ],
    ];

    protected static $updateRules = [
        'region_id'     => [ 'required' ],
        'name'          => [ 'required', 'min:4' ],
    ];

}
