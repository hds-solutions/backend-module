<?php

namespace HDSSolutions\Finpar;

use HDSSolutions\Finpar\Commands\Mix;
use Illuminate\Support\ServiceProvider;

class BackendModuleServiceProvider extends ServiceProvider {

    private $commands = [
        Mix::class,
    ];

    /**
    * Publishes configuration file.
    *
    * @return  void
    */
    public function boot() {
        // enable config override
        $this->publishes([
            backend_path('config/backend.php') => config_path('backend.php'),
        ], 'backend.config');

        // load routes
        $this->loadRoutesFrom( backend_path('routes/backend.php') );
        // load views
        $this->loadViewsFrom( backend_path('views'), 'backend' );
        // load migrations
        $this->loadMigrationsFrom( backend_path('database/migrations') );
    }

    /**
    * Make config publishment optional by merging the config from the package.
    *
    * @return  void
    */
    public function register() {
        // register helpers
        if (file_exists($helpers = realpath(__DIR__.'/../../helpers.php')))
            //
            require_once $helpers;
        // register singleton
        app()->singleton('backend', fn() => new Backend);
        // register commands
        $this->commands( $this->commands );
        // merge configuration
        $this->mergeConfigFrom( backend_path('config/backend.php'), 'backend' );
    }

}
