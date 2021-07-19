<?php

namespace HDSSolutions\Finpar\Models;

abstract class X_Company extends Base\Model {

    protected $fillable = [
        'name',
        'logo_id',
    ];

    protected $nullable = [
    ];

    protected static $rules = [
        'name'      => [ 'required' ],
        'logo_id'   => [ 'sometimes', 'nullable' ],
    ];

    public function getIsCurrentAttribute():bool {
        // return if this company is the current in use
        return $this->id == backend()->company()?->getKey();
    }

}
