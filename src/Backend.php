<?php

namespace HDSSolutions\Finpar;

use HDSSolutions\Finpar\Models\Company;
use Illuminate\Support\Collection;

class Backend {

    public function company():Company {
        // TODO: return current company
        return Company::first();
    }

    public function companies():Collection {
        // TODO: return only companies that user has access to
        return Company::all();
    }

}
