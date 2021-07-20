<?php

namespace HDSSolutions\Laravel\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CompanyScope implements Scope {

    public function apply(Builder $builder, Model $model) {
        // filter admins
        if (backend()->company()) $builder->where($model->getTable().'.company_id', backend()->company()->getKey());
        //
        else $builder->whereNull($model->getTable().'.company_id');
    }

}
