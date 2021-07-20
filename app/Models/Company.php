<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Models\Scopes\CompanyScope;

class Company extends X_Company {

    public function logo() {
        return $this->belongsTo(File::class)
            ->withoutGlobalScope(new CompanyScope)
            ->withTrashed();
    }

    public function branches() {
        return $this->hasMany(Branch::class);
    }

}
