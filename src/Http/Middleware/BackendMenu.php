<?php

namespace HDSSolutions\Finpar\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class BackendMenu {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
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
                'icon'  => 'cogs',
            ])
            ->data('priority', 1800);

        return $this
            // append items to submenu
            ->users($sub)
            ->regions($sub)
            ->cities($sub)
            ->companies($sub)
            ->branches($sub);
    }

    private function extra() {
        // create a submenu
        $sub = backend()->menu()
            ->add(__('backend::extras.nav'), [
                'icon'  => 'cogs',
            ]);

        return $this
            // append items to submenu
            ->files($sub);
    }

    private function users(&$menu) {
        // add users/admins routes
        if (Route::has('backend.admins') && Route::has('backend.users')) {
            // add menu container
            $menu->add(__('backend::users.nav'),  [
                'icon'      => 'cog'
            ])->divide();
            // add menu subitems
            $menu->usuarios->add(__('backend::admins.nav'), [ 'route' => 'backend.admins' ]);
            $menu->usuarios->add(__('backend::users.nav'),  [ 'route' => 'backend.users' ]);
        } else
            if (Route::has('backend.admins'))
                $menu->add(__('backend::admins.nav'), [
                    // 'header'    => 'Configuraciones',
                    'route'     => 'backend.admins',
                    'icon'      => 'user-shield',
                ]);
            elseif (Route::has('backend.users'))
                $menu->add(__('backend::users.nav'), [
                    // 'header'    => 'Configuraciones',
                    'route'     => 'backend.users',
                ]);

        return $this;
    }

    private function regions(&$menu) {
        if (Route::has('backend.regions'))
            $menu->add(__('backend::regions.nav'), [
                'route'     => 'backend.regions',
                'icon'      => 'cogs'
            ]);

        return $this;
    }

    private function cities(&$menu) {
        if (Route::has('backend.cities'))
            $menu->add(__('backend::cities.nav'), [
                'route'     => 'backend.cities',
                'icon'      => 'cogs'
            ]);

        return $this;
    }

    private function companies(&$menu) {
        if (Route::has('backend.companies'))
            $menu->add(__('backend::companies.nav'), [
                'route'     => 'backend.companies',
                'icon'      => 'cogs'
            ]);

        return $this;
    }

    private function branches(&$menu) {
        if (Route::has('backend.branches'))
            $menu->add(__('backend::branches.nav'), [
                'route'     => 'backend.branches',
                'icon'      => 'cogs'
            ]);

        return $this;
    }

    private function files(&$menu) {
        if (Route::has('backend.files'))
            $menu->add(__('backend::files.nav'), [
                'route'     => 'backend.files',
                'icon'      => 'files'
            ]);

        return $this;
    }

}
