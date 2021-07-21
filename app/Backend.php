<?php

namespace HDSSolutions\Laravel;

use HDSSolutions\Laravel\Models\Company;
use HDSSolutions\Laravel\Models\Branch;
use HDSSolutions\Laravel\Models\Warehouse;
use HDSSolutions\Laravel\Models\Currency;
use HDSSolutions\Laravel\Models\CashBook;
use HDSSolutions\Laravel\Models\Scopes\CompanyScope;
use Illuminate\Support\Collection;
use Lavary\Menu\Builder as MenuBuilder;
use Lavary\Menu\Facade as Menu;

class Backend {

    private Collection $companies;
    private ?Company $company;
    private ?Branch $branch;
    private ?Warehouse $warehouse;

    private Collection $cashBooks;
    private ?CashBook $cashBook;

    private Collection $currencies;
    private ?Currency $currency;

    public function menu():MenuBuilder {
        // check instance
        if (!Menu::get(self::class)) Menu::makeOnce(self::class, fn($menu) => null);
        // return Laravy/Menu instance
        return Menu::get(self::class);
    }

    public function setCompany(int|Company|null $company):?Company {
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

    public function setBranch(int|Branch|null $branch):?Branch {
        // check if is null
        if ($branch === null) {
            // remove branch
            session()->forget( 'backend.branch');
            // replace branch
            return $this->loadBranch();
        }
        // save branch
        $this->branch = $branch instanceof Branch ? $branch : Branch::findOrFail($branch);
        // save to session
        session([ 'backend.branch' => $this->branch->getKey() ]);
        // return branch
        return $this->branch;
    }

    public function setWarehouse(int|Warehouse|null $warehouse):?Warehouse {
        // check if is null
        if ($warehouse === null) {
            // remove warehouse
            session()->forget( 'backend.warehouse');
            // replace warehouse
            return $this->loadWarehouse();
        }
        // save warehouse
        $this->warehouse = $warehouse instanceof Warehouse ? $warehouse : Warehouse::findOrFail($warehouse);
        // save to session
        session([ 'backend.warehouse' => $this->warehouse->getKey() ]);
        // return warehouse
        return $this->warehouse;
    }

    public function setCurrency(int|Currency|null $currency):?Currency {
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

    public function setCashBook(int|CashBook|null $cash_book):?CashBook {
        // check if is null
        if ($cash_book === null) {
            // remove cash_book
            session()->forget( 'backend.cash_book');
            // replace cash_book
            return $this->loadCashBook();
        }
        // save cash_book
        $this->cash_book = $cash_book instanceof CashBook ? $cash_book : CashBook::findOrFail($cash_book);
        // save to session
        session([ 'backend.cash_book' => $this->cash_book->getKey() ]);
        // return cash_book
        return $this->cash_book;
    }

    public function companies():Collection {
        // TODO: return only companies that user has access to
        return $this->companies ??= Company::with([
            'logo',
            'branches'  => fn($branch) => $branch->withoutGlobalScope(new CompanyScope)->with([
                'warehouses' => fn($warehouse) => $warehouse->withoutGlobalScope(new CompanyScope),
            ]),
        ])->get()->transform(fn($company) => $company
            // override loaded branches, add relation to parent manually
            ->setRelation('branches', $company->branches->transform(fn($branch) => $branch
                // set Branch.company relation manually to avoid more queries
                ->setRelation('company', $company)
                // override loaded warehouses, add relation to parent manually
                ->setRelation('warehouses', $branch->warehouses->transform(fn($warehouse) => $warehouse
                    // set Warehouse.branch relation manually to avoid more queries
                    ->setRelation('branch', $branch)
                ))
            ))
        );
    }

    public function companyScoped():bool {
        // return if a company is set
        return session('backend.company') !== null;
    }

    public function company():?Company {
        // return current company
        return $this->company ??= $this->loadCompany();
    }

    private function loadCompany():?Company {
        // load company from session
        return $this->company = $this->companies()->firstWhere('id', session('backend.company'));
    }

    public function branches():Collection {
        // TODO: return only branches that user has access to
        return $this->companies()->pluck('branches')->flatten();
    }

    public function branchScoped():bool {
        // return if a branch is set
        return session('backend.branch') !== null;
    }

    public function branch():?Branch {
        // return current branch
        return $this->branch ??= $this->loadBranch();
    }

    private function loadBranch():?Branch {
        // load branch from session
        return $this->branch = $this->company()?->branches?->firstWhere('id', session('backend.branch'));
    }

    public function warehouses():Collection {
        // TODO: return only warehouses that user has access to
        return $this->branches()->pluck('warehouses')->flatten();
    }

    public function warehouse():?Warehouse {
        // return current warehouse
        return $this->warehouse ??= $this->loadWarehouse();
    }

    private function loadWarehouse():?Warehouse {
        // load warehouse from session
        return $this->warehouse = $this->branch()?->warehouses?->firstWhere('id', session('backend.warehouse'));
    }

    public function currencies():Collection {
        // return currencies
        return $this->currencies ??= Currency::all();
    }

    public function currency():?Currency {
        // return current currency
        return $this->currency ??= $this->loadCurrency();
    }

    private function loadCurrency():?Currency {
        // load currency from session
        return $this->currency = $this->currencies()->firstWhere('id', session('backend.currency') );
    }

    public function cashBooks():Collection {
        // return cashBooks
        return $this->cashBooks ??= CashBook::withoutGlobalScope(new CompanyScope)->get();
    }

    public function cashBook():?CashBook {
        // return current cash_book
        return $this->cash_book ??= $this->loadCashBook();
    }

    private function loadCashBook():?CashBook {
        // load cash_book from session
        return $this->cash_book = $this->cashBooks()->firstWhere('id', session('backend.cash_book') );
    }

}
