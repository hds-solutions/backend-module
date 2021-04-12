<?php

namespace HDSSolutions\Finpar\Models;

abstract class X_City extends Base\Model {

    protected $sortBy = 'name';

    protected $fillable = [
        'region_id',
        'name',
    ];

    protected static $rules = [
        'region_id'     => [ 'required' ],
        'name'          => [ 'required', 'min:4' ],
    ];

}
