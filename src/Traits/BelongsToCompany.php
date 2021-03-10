<?php

namespace HDSSolutions\Finpar\Traits;

use HDSSolutions\Finpar\Models\Company;
use HDSSolutions\Finpar\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

trait BelongsToCompany {

    protected function getArrayableItems(array $values) {
        // hide company ID from visible attributes
        if (!in_array('company_id', $this->hidden)) $this->hidden[] = 'company_id';
        //
        return parent::getArrayableItems($values);
    }

    public static function bootBelongsToCompany() {
        // regiter global scope
        self::addGlobalScope(new CompanyScope);
        // capture saving event
        self::saving(function(Model $model) {
            // set company value
            $model->company()->associate( backend()->company() );
        });
    }

    public function company() {
        // return company instance
        return $this->belongsTo(Company::class);
    }

}
