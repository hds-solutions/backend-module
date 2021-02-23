<?php

namespace HDSSolutions\Finpar\Models;

use App\Models\Base\Model;
use HDSSolutions\Finpar\Backend\Facade as Backend;

class X_Company extends Model {

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

    public function getIsCurrentAttribute():bool {
        // return if this company is the current in use
        return $this->id == Backend::company()->getKey();
    }

}
