<?php

namespace HDSSolutions\Finpar\Models;

use App\Models\Base\Model;

class Setting extends Model {

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

    public static function forName(string $name) {
        //
        return self::where('name', $name)->first() ?? new self;
    }

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
