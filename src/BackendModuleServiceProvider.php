<?php

namespace HDSSolutions\Finpar;

use HDSSolutions\Finpar\Commands\Mix;
use HDSSolutions\Laravel\Modules\ModuleServiceProvider;

class BackendModuleServiceProvider extends ModuleServiceProvider {

    private $commands = [
        Mix::class,
    ];

    public function bootEnv():void {
        // enable config override
        $this->publishes([
            backend_path('config/backend.php') => config_path('backend.php'),
        ], 'backend.config');

        // load routes
        $this->loadRoutesFrom( backend_path('routes/backend.php') );
        // load views
        $this->loadViewsFrom( backend_path('resources/views'), 'backend' );
        // load translations
        $this->loadTranslationsFrom( module_path('resources/lang'), 'backend' );
        // load migrations
        $this->loadMigrationsFrom( backend_path('database/migrations') );
        // load seeders
        $this->loadSeedersFrom( backend_path('database/seeders') );
    }

    public function register() {
        // register helpers
        if (file_exists($helpers = realpath(__DIR__.'/helpers.php')))
            //
            require_once $helpers;
        // register singleton
        app()->singleton('backend', fn() => new Backend);
        // register commands
        $this->commands( $this->commands );
        // merge configuration
        $this->mergeConfigFrom( backend_path('config/backend.php'), 'backend' );
        // merge datatables configuration
        $this->mergeConfigFrom( backend_path('config/datatables.php'), 'datatables-html' );
    }

}
