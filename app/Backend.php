<?php

namespace HDSSolutions\Finpar;

use HDSSolutions\Finpar\Models\Company;
use Illuminate\Support\Collection;
use Lavary\Menu\Builder as MenuBuilder;
use Lavary\Menu\Facade as Menu;

class Backend {

    private Collection $companies;
    private Company $company;

    public function setCompany(int|Company|null $company):Company {
        // check if is null
        if ($company === null) {
            // remove company
            session()->forget( 'backend.company');
            // replace company
            return $this->loadCompany();
        }
        // save company
        $this->company = $company instanceof Company ? $company : Company::findOrFail($company);
        // save to session
        session([ 'backend.company' => $this->company->getKey() ]);
        // return company
        return $this->company;
    }

    public function company():Company {
        // return current company
        return $this->company ??= $this->loadCompany();
    }

    public function companies():Collection {
        // TODO: return only companies that user has access to
        return $this->companies ??= Company::with([ 'logo' ])->get();
    }

    public function menu():MenuBuilder {
        // check instance
        if (!Menu::get(self::class)) Menu::makeOnce(self::class, function($menu) {});
        // return Laravy/Menu instance
        return Menu::get(self::class);
    }

    private function loadCompany():Company  {
        // load company from session
        return $this->company = Company::findOrNew( session('backend.company') );
    }

}
