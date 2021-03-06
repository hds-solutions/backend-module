<?php

use HDSSolutions\Finpar\Http\Controllers\Auth\LoginController;
use HDSSolutions\Finpar\Http\Controllers\BackendController;
use HDSSolutions\Finpar\Http\Controllers\BranchController;
use HDSSolutions\Finpar\Http\Controllers\CityController;
use HDSSolutions\Finpar\Http\Controllers\CompanyController;
use HDSSolutions\Finpar\Http\Controllers\FileController;
use HDSSolutions\Finpar\Http\Controllers\RegionController;
use HDSSolutions\Finpar\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'        => config('backend.prefix'),
    'middleware'    => [ 'web' ]
], function() {
    // backend login endpoints
    Route::get('login',     [ LoginController::class, 'showLoginForm' ])    ->name( config('backend.login') );
    Route::post('login',    [ LoginController::class, 'login' ]);
    Route::post('logout',   [ LoginController::class, 'logout'])            ->name('backend.logout');
});

Route::group([
    'prefix'        => config('backend.prefix'),
    'middleware'    => [ 'web', 'auth:'.config('backend.guard') ],
], function() {
    // name prefix
    $name_prefix = [ 'as' => 'backend' ];

    // Backend home
    Route::get('/',             [ BackendController::class, 'index' ])      ->name('backend');
    Route::get('dashboard',     [ BackendController::class, 'dashboard' ])  ->name('backend.dashboard');

    Route::resource('users',        UserController::class,      $name_prefix)
        ->parameters([ 'users' => 'resource' ])
        ->name('index', 'backend.users');

    Route::resource('regions',      RegionController::class,    $name_prefix)
        ->parameters([ 'regions' => 'resource' ])
        ->name('index', 'backend.regions');

    Route::resource('cities',       CityController::class,      $name_prefix)
        ->parameters([ 'cities' => 'resource' ])
        ->name('index', 'backend.cities');

    Route::resource('companies',    CompanyController::class,   $name_prefix)
        ->parameters([ 'companies' => 'resource' ])
        ->name('index', 'backend.companies');

    Route::resource('branches',     BranchController::class,    $name_prefix)
        ->parameters([ 'branches' => 'resource' ])
        ->name('index', 'backend.branches');

    Route::resource('files',        FileController::class,      $name_prefix)
        ->parameters([ 'files' => 'resource' ])
        ->name('index', 'backend.files');

});