<?php

namespace HDSSolutions\Finpar\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CompanyScope implements Scope {
    public function apply(Builder $builder, Model $model) {
        // filter admins
        $builder->where($model->getTable().'.company_id', backend()->company()->getKey());
    }
}