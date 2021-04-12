<?php

namespace HDSSolutions\Finpar\Models;

class X_Setting extends Base\Model {

    protected $fillable = [
        'name',
        'value',
    ];

    protected $nullable = [
        'value'
    ];

    protected static $createRules = [
        'name'  => [ 'required' ],
        'value' => [ 'sometimes', 'nullable' ],
    ];

    protected static $updateRules = [
        'value' => [ 'nullable' ],
    ];

    public function setValueAttribute($value = '') {
        switch ($this->type) {
            case 'boolean':
                // cast value to boolean
                $value = $value == 'true';
        }
        // save
        $this->attributes['value'] = $value;
    }

}
