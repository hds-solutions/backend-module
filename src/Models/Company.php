<?php

namespace HDSSolutions\Finpar\Models;

use App\Models\Base\Model;
use HDSSolutions\Finpar\Backend\Facade as Backend;

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

    public function getIsCurrentAttribute():bool {
        // TODO: check if this company is currently
        return $this->id == Backend::company()->getKey();
    }

}
