<?php

namespace HDSSolutions\Finpar\Models\Scopes;

use HDSSolutions\Finpar\Backend\Facade as Backend;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CompanyScope implements Scope {
    public function apply(Builder $builder, Model $model) {
        // filter admins
        $builder->where('company_id', Backend::company()->getKey());
    }
}