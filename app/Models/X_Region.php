<?php

namespace HDSSolutions\Finpar\Models;

abstract class X_Region extends Base\Model {

    protected $orderBy = [
        'name'  => 'ASC',
    ];

    protected $fillable = [
        'name',
    ];

    protected static $rules = [
        'name'  => [ 'required', 'min:4' ],
    ];

}
