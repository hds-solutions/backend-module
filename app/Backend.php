<?php

namespace HDSSolutions\Finpar;

use HDSSolutions\Finpar\Models\Company;
use Illuminate\Support\Collection;
use Lavary\Menu\Builder as MenuBuilder;
use Lavary\Menu\Facade as Menu;

class Backend {

    private Collection $companies;
    private Company $company;

    private function loadCompany():Company  {
        // load company from session
        return $this->company = Company::find(session(self::class.'.company', null)) ?? new Company;
    }

    public function setCompany(int|Company|null $company):Company {
        // check if is null
        if ($company === null) {
            // remove company
            session([ self::class.'.company' => null ]);
            // replace company
            return $this->loadCompany();
        }
        // save company
        $this->company = $company instanceof Company ? $company : Company::findOrFail($company);
        // save to session
        session([ self::class.'.company' => $this->company->getKey() ]);
        // return company
        return $this->company;
    }

    public function company():Company {
        // return current company
        return $this->company ??= $this->loadCompany();
    }

    public function companies():Collection {
        // TODO: return only companies that user has access to
        return $this->companies ??= Company::all();
    }

    public function menu():MenuBuilder {
        // check instance
        if (!Menu::get(self::class)) Menu::makeOnce(self::class, function($menu) {});
        // return Laravy/Menu instance
        return Menu::get(self::class);
    }

}
