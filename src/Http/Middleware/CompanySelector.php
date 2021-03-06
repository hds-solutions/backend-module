<?php

namespace HDSSolutions\Finpar\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompanySelector {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        // save company from request
        if ($request->has('set-company'))
            // update selected company
            backend()->setCompany($request->input('set-company') !== 'null' ? $request->input('set-company') : null);

        //
        return $next($request);
    }
}
