<?php

namespace HDSSolutions\Finpar;

use HDSSolutions\Finpar\Models\Company;
use Illuminate\Support\Collection;
use Lavary\Menu\Builder as MenuBuilder;
use Lavary\Menu\Facade as Menu;

class Backend {

    private $companies;
    private $company;

    public function __construct() {
        // load company from session
        $this->company = Company::find(session(self::class.'.company', null)) ?? new Company;
    }

    public function setCompany(int|Company $company):void {
        // save company
        $this->company = $company instanceof Company ? $company : Company::findOrFail($company);
        // save to session
        session([ self::class.'.company' => $this->company->getKey() ]);
    }

    public function company():Company {
        // return current company
        return $this->company;
    }

    public function companies():Collection {
        // TODO: return only companies that user has access to
        return $this->companies ??= Company::all();
    }

    public function menu():MenuBuilder {
        // check instance
        if (!Menu::get(self::class)) Menu::make(self::class, function($menu) {});
        // return Laravy/Menu instance
        return Menu::get(self::class);
    }

}
