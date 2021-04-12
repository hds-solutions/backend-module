<?php

namespace HDSSolutions\Finpar\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator as Validator_Factory;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator;

trait HasValidationRules {

    // validator errors
    private $validation_errors;

    public static function bootHasValidationRules() {
        // capture creating
        self::creating(function($model) {
            // create a Validator with createRules
            $validator = Validator_Factory::make($model::getAllAttributes($model), $model::createRules());
            // check if rules fails
            if ($validator->fails()) {
                // save errors
                $model->validation_errors = $validator->errors();
                // return false
                return false;
            }
            // execute beforeSave
            $model->beforeSave($validator);
            // save errors
            $model->validation_errors = $validator->errors()->any() ? $validator->errors() : null;
            // save model attributes that aren't in database
            $model->saveNotInDatabase();
            // return validator
            return !$validator->errors()->any();
        });
        // capture updating
        self::updating(function($model) {
            // create a Validator with updateRules
            $validator = Validator_Factory::make($model->getAllAttributes($model), $model::updateRules($model->id));
            // check if rules fails
            if ($validator->fails()) {
                // save errors
                $model->validation_errors = $validator->errors();
                // return false
                return false;
            }
            // execute beforeSave
            $model->beforeSave($validator);
            // save errors
            $model->validation_errors = $validator->errors()->any() ? $validator->errors() : null;
            // save model attributes that aren't in database
            $model->saveNotInDatabase();
            // return validator result
            return !$validator->errors()->any();
        });
        // capture saved
        self::saved(function($model) {
            // restore attributes that aren't in database
            foreach ($model->not_in_database as $key => $value)
                // re-appent value to model
                $model->$key = $value;
            // empty array
            $model->not_in_database = [];
        });
    }

    private $table_columns;
    private function getTableColumns() {
        // load columns for table
        $this->table_columns = $this->table_columns ?? $this->getConnection()->getSchemaBuilder()->getColumnListing( $this->getTable() );
        // return table columns
        return $this->table_columns;
    }

    private $not_in_database = [];
    private function saveNotInDatabase() {
        // remove not in database
        foreach ($this->getAttributes() as $key => $value)
            // check if exists in database
            if (!in_array($key, array_values( $this->getTableColumns() ) )) {
                // save to local array
                $this->setAttribute($key, $value);
                // remove from model
                unset($this->$key);
            }
    }

    /**
     * Errors generated from Validator or custom Model.beforeSave() validations
     */
    public final function errors() {
        // check for HasIdentity trait
        if (uses_trait($this, HasIdentity::class))
            // append errors to identity errors
            return $this->identity->errors()->merge( $this->validation_errors ?? [] );
        // return saved errors
        return $this->validation_errors ?? new MessageBag;
    }

    /**
     * Custom validations beforeSave
     */
    protected function beforeSave(Validator $validator) {}

    /**
     * Returns all resource attributes,
     * appends null to inexistent ones
     */
    private static function getAllAttributes($model) {
        // get current attributes
        $attributes = $model->getAttributes();
        // foreach fillable columns
        foreach ($model->getFillable() as $column)
            // check if isn't in attributes yet
            if (!array_key_exists($column, $attributes))
                // append with null value
                $attributes[$column] = null;
        // return attributes
        return $attributes;
    }

    private static function createRules(bool $onlykeys = false) {
        // get rules
        $rules = static::$createRules ?? [];
        // return keys or rules
        return $onlykeys ? array_keys($rules) : $rules;
    }

    private static function updateRules($id, bool $onlykeys = false) {
        // get rules
        $rules = static::$updateRules ?? static::$createRules ?? [];
        // foreach rules
        foreach ($rules as $idx => $rule)
            // check if is array of rules
            if (gettype($rule) == 'array')
                // foreach rules array
                foreach ($rule as $rule_idx => $rule_value)
                    // replace {id}
                    $rules[$idx][$rule_idx] = str_replace('{id}', $id, $rule_value);
            else
                // replace {id}
                $rules[$idx] = str_replace('{id}', $id, $rule);
        // return keys or rules
        return $onlykeys ? array_keys($rules) : $rules;
    }

}
