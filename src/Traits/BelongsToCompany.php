<?php

namespace HDSSolutions\Finpar\Traits;

use App\Models\Base\Model;
use HDSSolutions\Finpar\Backend\Facade as Backend;
use HDSSolutions\Finpar\Models\Company;
use HDSSolutions\Finpar\Models\Scopes\CompanyScope;

trait BelongsToCompany {

    public static function bootBelongsToCompany() {
        // regiter global scope
        self::addGlobalScope(new CompanyScope);
        // capture saving event
        self::saving(function(Model $model) {
            // set company value
            $model->company()->associate( Backend::company() );
        });
    }

    public function company() {
        // return company instance
        return $this->belongsTo(Company::class);
    }

}
