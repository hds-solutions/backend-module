<?php

namespace HDSSolutions\Laravel\Traits;

use HDSSolutions\Laravel\Models\Company;
use HDSSolutions\Laravel\Models\Scopes\CompanyScope;
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
        // set company value when saving model
        self::saving(fn(Model $model) => $model->company()->associate( backend()->company() ));
    }

    public function company() {
        // return company instance
        return $this->belongsTo(Company::class);
    }

}
