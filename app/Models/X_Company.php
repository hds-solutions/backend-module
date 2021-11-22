<?php

namespace HDSSolutions\Laravel\Models;

abstract class X_Company extends Base\Model {

    protected $orderBy = [
        'name'  => 'ASC',
    ];

    protected $fillable = [
        'name',
        'ftid',
        'logo_id',
    ];

    protected $nullable = [
    ];

    protected static $rules = [
        'name'      => [ 'required' ],
        'ftid'      => [ 'required' ],
        'logo_id'   => [ 'sometimes', 'nullable' ],
    ];

    public function getIsCurrentAttribute():bool {
        // return if this company is the current in use
        return $this->id == backend()->company()?->getKey();
    }

}
