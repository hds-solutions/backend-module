<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Models\Scopes\CompanyScope;

class Company extends X_Company {

    public function logo() {
        return $this->belongsTo(File::class)
            ->withoutGlobalScope(new CompanyScope)
            ->withTrashed();
    }

}
