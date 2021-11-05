<?php

namespace HDSSolutions\Laravel;

use HDSSolutions\Laravel\Modules\ModuleServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;

class BackendModuleServiceProvider extends ModuleServiceProvider {

    protected array $globalMiddlewares = [
        \HDSSolutions\Laravel\Http\Middleware\HttpsProtocol::class,
        \HDSSolutions\Laravel\Http\Middleware\SetLocale::class,
        \HDSSolutions\Laravel\Http\Middleware\SettingsLoader::class,
        \Spatie\LaravelImageOptimizer\Middlewares\OptimizeImages::class,
    ];

    protected array $middlewares = [
        \HDSSolutions\Laravel\Http\Middleware\BackendMenu::class,
        \HDSSolutions\Laravel\Http\Middleware\HideDebugBar::class,
    ];

    private array $commands = [
        \HDSSolutions\Laravel\Commands\Mix::class,
    ];

    private array $components = [
        'form'      => [
            \HDSSolutions\Laravel\View\Components\Row::class,
            \HDSSolutions\Laravel\View\Components\RowGroup::class,
            \HDSSolutions\Laravel\View\Components\InputGroup::class,
            \HDSSolutions\Laravel\View\Components\Label::class,
            \HDSSolutions\Laravel\View\Components\Input::class,
            \HDSSolutions\Laravel\View\Components\TextArea::class,
            \HDSSolutions\Laravel\View\Components\Boolean::class,
            \HDSSolutions\Laravel\View\Components\Date::class,
            \HDSSolutions\Laravel\View\Components\Time::class,
            \HDSSolutions\Laravel\View\Components\Datetime::class,
            \HDSSolutions\Laravel\View\Components\Amount::class,
            \HDSSolutions\Laravel\View\Components\Select::class,
            \HDSSolutions\Laravel\View\Components\Foreign::class,
            \HDSSolutions\Laravel\View\Components\Multiple::class,
        ],
        'backend'   => [
            \HDSSolutions\Laravel\View\Components\FormText::class,
            \HDSSolutions\Laravel\View\Components\FormNumber::class,
            \HDSSolutions\Laravel\View\Components\FormEmail::class,
            \HDSSolutions\Laravel\View\Components\FormDate::class,
            \HDSSolutions\Laravel\View\Components\FormTime::class,
            \HDSSolutions\Laravel\View\Components\FormDatetime::class,
            \HDSSolutions\Laravel\View\Components\FormTextarea::class,
            \HDSSolutions\Laravel\View\Components\FormSelect::class,
            \HDSSolutions\Laravel\View\Components\FormOptions::class,
            \HDSSolutions\Laravel\View\Components\FormBoolean::class,
            \HDSSolutions\Laravel\View\Components\FormForeign::class,
            \HDSSolutions\Laravel\View\Components\FormHidden::class,
            \HDSSolutions\Laravel\View\Components\FormImage::class,
            \HDSSolutions\Laravel\View\Components\FormAmount::class,
            \HDSSolutions\Laravel\View\Components\FormCoords::class,
            \HDSSolutions\Laravel\View\Components\FormMultiple::class,
            \HDSSolutions\Laravel\View\Components\FormControls::class,
        ],
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
        foreach ($this->components as $group => $components)
            $this->loadViewComponentsAs($group, $components);
        // load translations
        $this->loadTranslationsFrom( module_path('resources/lang'), 'backend' );
        // load migrations
        $this->loadMigrationsFrom( backend_path('database/migrations') );
        // load seeders
        $this->loadSeedersFrom( backend_path('database/seeders') );

        // register blade directives
        Blade::directive('onlyform', fn($exp) => "<?php if (request()->has('only-form')): ?><input type=\"hidden\" name=\"only-form\" value=\"true\" /><?php endif; ?>");
        Blade::directive('gmap', fn($exp) => "<script src=\"https://maps.googleapis.com/maps/api/js?v=3&key=".config('services.google.maps.key')."&ftype=.js\"></script>");

        // get Lambda flag
        $isRunningInLambda = isset($_SERVER['LAMBDA_TASK_ROOT']);
        // The rest below is specific to AWS Lambda
        if (!$isRunningInLambda) return;

        // update Laravel Excel temporary path
        Config::set('excel.temporary_files.local_path', '/tmp/storage/framework/laravel-excel');
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
        // merge spatie/permission configuration
        $this->mergeConfigFrom( backend_path('config/permission.php'), 'permission' );
    }

}
