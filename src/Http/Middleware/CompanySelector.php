<?php

namespace HDSSolutions\Finpar\Http\Middleware;

use Closure;
use HDSSolutions\Finpar\Backend\Facade as Backend;
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
            Backend::setCompany($request->input('set-company'));

        //
        return $next($request);
    }
}
