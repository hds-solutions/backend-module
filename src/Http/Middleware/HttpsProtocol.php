<?php

namespace HDSSolutions\Finpar\Http\Middleware;

use Closure;

class HttpsProtocol {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        // check if prod and not SSL
        if (app()->environment() === 'production' && !$request->secure())
            // force SSL
            return redirect()->secure($request->getRequestUri());
        //
        return $next($request);
    }
}
