<?php

use HDSSolutions\Finpar\Http\Controllers\Auth\LoginController;
use HDSSolutions\Finpar\Http\Controllers\BackendController;
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

    Route::resource('users',    UserController::class,  $name_prefix)
        ->parameters([ 'users' => 'resource' ])
        ->name('index', 'backend.users');

});