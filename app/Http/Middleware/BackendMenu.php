<?php

namespace HDSSolutions\Laravel\Http\Middleware;

use Closure;
use HDSSolutions\Laravel\Models\User;
use Illuminate\Support\Facades\Route;

class BackendMenu extends Base\Menu {

    public function handle($request, Closure $next) {
        // register menu items
        $this
            ->dashboard()
            ->configs()
            ->extra();

        // continue witn next middleware
        return $next($request);
    }

    private function dashboard() {
        // add main dashboard route
        backend()->menu()
            ->add(__('backend::dashboard.nav'), [
                'route' => 'backend.dashboard',
                'icon'  => 'tachometer-alt'
            ])
            ->data('priority', 1900)
            ->divide();

        return $this;
    }

    private function configs() {
        // create a submenu
        $sub = backend()->menu()
            ->add(__('backend::configs.nav'), [
                'nickname'  => 'configs',
                'icon'      => 'cogs',
            ])
            ->data('priority', 1800);

        return $this
            // append items to submenu
            ->companies($sub)
            ->branches($sub)

            ->roles($sub)
            ->users($sub)

            ->regions($sub)
            ->cities($sub)
            ;
    }

    private function extra() {
        // create a submenu
        $sub = backend()->menu()
            ->add(__('backend::extras.nav'), [
                'nickname'  => 'extras',
                'icon'      => 'cogs',
            ]);

        return $this
            // append items to submenu
            ->files($sub);
    }

    private function roles(&$menu) {
        if (Route::has('backend.roles') && $this->can('roles'))
            $menu->add(__('backend::roles.nav'), [
                // 'header'    => 'Configuraciones',
                'route'     => 'backend.roles',
                'icon'      => 'briefcase'
            ]);

        return $this;
    }

    private function users(&$menu) {
        if (Route::has('backend.users') && $this->can('users'))
            $menu->add(__('backend::users.nav'), [
                // 'header'    => 'Configuraciones',
                'route'     => 'backend.users',
                'icon'      => 'users'
            ]);

        return $this;
    }

    private function regions(&$menu) {
        if (Route::has('backend.regions') && $this->can('regions'))
            $menu->add(__('backend::regions.nav'), [
                'route'     => 'backend.regions',
                'icon'      => 'globe-americas'
            ]);

        return $this;
    }

    private function cities(&$menu) {
        if (Route::has('backend.cities') && $this->can('cities'))
            $menu->add(__('backend::cities.nav'), [
                'route'     => 'backend.cities',
                'icon'      => 'city'
            ]);

        return $this;
    }

    private function companies(&$menu) {
        if (Route::has('backend.companies') && $this->can('companies'))
            $menu->add(__('backend::companies.nav'), [
                'route'     => 'backend.companies',
                'icon'      => 'university'
            ]);

        return $this;
    }

    private function branches(&$menu) {
        if (Route::has('backend.branches') && $this->can('branches'))
            $menu->add(__('backend::branches.nav'), [
                'route'     => 'backend.branches',
                'icon'      => 'store'
            ]);

        return $this;
    }

    private function files(&$menu) {
        if (Route::has('backend.files') && $this->can('files'))
            $menu->add(__('backend::files.nav'), [
                'route'     => 'backend.files',
                'icon'      => 'files'
            ]);

        return $this;
    }

}
