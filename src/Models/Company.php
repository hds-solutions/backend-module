<?php

namespace HDSSolutions\Finpar\Models;

use App\Models\Base\Model;

class Company extends Model {

    protected $fillable = [
        'name',
    ];

    protected $nullable = [
    ];

    protected static $createRules = [
        'name'  => [ 'required' ],
    ];

    protected static $updateRules = [
        'name'  => [ 'required' ],
    ];

}
