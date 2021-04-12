<?php

namespace HDSSolutions\Finpar\Models;

abstract class X_Region extends Base\Model {

    protected $orderBy = [
        'name'      => 'ASC',
    ];

    protected $fillable = [
        'name',
    ];

    protected static $createRules = [
        'name'          => [ 'required', 'min:4' ],
    ];

    protected static $updateRules = [
        'name'          => [ 'required', 'min:4' ],
    ];

}
