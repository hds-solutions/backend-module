<?php

namespace HDSSolutions\Finpar;

use HDSSolutions\Finpar\Models\Company;
use HDSSolutions\Finpar\Models\Currency;
use Illuminate\Support\Collection;
use Lavary\Menu\Builder as MenuBuilder;
use Lavary\Menu\Facade as Menu;

class Backend {

    private Company $company;
    private Collection $companies;

    private Currency $currency;
    private Collection $currencies;

    public function menu():MenuBuilder {
        // check instance
        if (!Menu::get(self::class)) Menu::makeOnce(self::class, function($menu) {});
        // return Laravy/Menu instance
        return Menu::get(self::class);
    }

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

    private function loadCompany():Company {
        // load company from session
        return $this->company = $this->companies()->firstWhere('id', session('backend.company')) ?? new Company;
    }

    public function setCurrency(int|Currency|null $currency):Currency {
        // check if is null
        if ($currency === null) {
            // remove currency
            session()->forget( 'backend.currency');
            // replace currency
            return $this->loadCurrency();
        }
        // save currency
        $this->currency = $currency instanceof Currency ? $currency : Currency::findOrFail($currency);
        // save to session
        session([ 'backend.currency' => $this->currency->getKey() ]);
        // return currency
        return $this->currency;
    }

    public function currency():Currency {
        // return current currency
        return $this->currency ??= $this->loadCurrency();
    }

    public function currencies():Collection {
        // return currencies
        return $this->currencies ??= Currency::all();
    }

    private function loadCurrency():Currency {
        // load currency from session
        return $this->currency = $this->currencies()->firstWhere('id', session('backend.currency') ) ?? new Currency;
    }

}
