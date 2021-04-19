<?php

namespace HDSSolutions\Finpar\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facade as Debugbar;

class HideDebugBar {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        // check if request is only form
        if (class_exists(Debugbar::class) && $request->has('only-form'))
            // disable debugbar
            Debugbar::disable();

        //
        return $next($request);
    }
}
