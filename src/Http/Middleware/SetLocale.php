<?php

namespace HDSSolutions\Finpar\Http\Middleware;

use Closure;

class SetLocale {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        // save locale from request
        if ($request->has('locale'))
            // save locale on session
            session([ 'locale' =>
                // validate locale
                in_array(strtolower($request->locale), [ 'en', 'es' ]) ? $request->locale :
                // fallback to en
                'en' ]);

        // set locale from session
        if (session()->has('locale')) app()->setLocale(session('locale'));

        //
        return $next($request);
    }

}
