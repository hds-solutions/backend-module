<?php

namespace HDSSolutions\Finpar;

use HDSSolutions\Laravel\Modules\ModuleServiceProvider;
use Illuminate\Support\Facades\Blade;

class BackendModuleServiceProvider extends ModuleServiceProvider {

    protected array $globalMiddlewares = [
        \HDSSolutions\Finpar\Http\Middleware\HttpsProtocol::class,
        \HDSSolutions\Finpar\Http\Middleware\SetLocale::class,
        \HDSSolutions\Finpar\Http\Middleware\SettingsLoader::class,
    ];

    protected array $middlewares = [
        \HDSSolutions\Finpar\Http\Middleware\CompanySelector::class,
        \HDSSolutions\Finpar\Http\Middleware\BackendMenu::class,
        \HDSSolutions\Finpar\Http\Middleware\HideDebugBar::class,
    ];

    private array $commands = [
        \HDSSolutions\Finpar\Commands\Mix::class,
    ];

    private array $components = [
        \HDSSolutions\Finpar\View\Components\FormText::class,
        \HDSSolutions\Finpar\View\Components\FormNumber::class,
        \HDSSolutions\Finpar\View\Components\FormEmail::class,
        \HDSSolutions\Finpar\View\Components\FormTextarea::class,
        \HDSSolutions\Finpar\View\Components\FormSelect::class,
        \HDSSolutions\Finpar\View\Components\FormBoolean::class,
        \HDSSolutions\Finpar\View\Components\FormForeign::class,
        \HDSSolutions\Finpar\View\Components\FormHidden::class,
        \HDSSolutions\Finpar\View\Components\FormImage::class,
        \HDSSolutions\Finpar\View\Components\FormAmount::class,
        \HDSSolutions\Finpar\View\Components\FormCoords::class,
        \HDSSolutions\Finpar\View\Components\FormControls::class,
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
        // load view components
        $this->loadViewComponentsAs('backend', $this->components);
        // load translations
        $this->loadTranslationsFrom( module_path('resources/lang'), 'backend' );
        // load migrations
        $this->loadMigrationsFrom( backend_path('database/migrations') );
        // load seeders
        $this->loadSeedersFrom( backend_path('database/seeders') );

        // register blade directives
        Blade::directive('onlyform', fn($exp) => "<?php if (request()->has('only-form')): ?><input type=\"hidden\" name=\"only-form\" value=\"true\" /><?php endif; ?>");
        Blade::directive('gmap', fn($exp) => "<script src=\"https://maps.googleapis.com/maps/api/js?v=3&key=".config('services.google.maps.key')."&ftype=.js\"></script>");
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
