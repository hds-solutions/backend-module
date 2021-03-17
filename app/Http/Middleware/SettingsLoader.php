<?php

namespace HDSSolutions\Finpar\Http\Middleware;

use Closure;
use HDSSolutions\Finpar\Models\Setting;
use Illuminate\Http\Request;

class SettingsLoader {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        // custom settings
        config([
            // load settings from database
            'settings' => Setting::all([ 'name', 'type', 'value' ])
                 // key every setting by its name
                ->keyBy('name')
                // return only the value
                ->transform(function ($setting) {
                    switch ($setting->type) {
                        case 'string': return $setting->value;
                        case 'integer': return $setting->value !== null ? (int)$setting->value : null;
                        case 'float': return $setting->value !== null ? (float)$setting->value : null;
                        case 'boolean': return $setting->value == 1;
                    }
                    // fallback
                    return $setting->value;
                })
                // make it an array
                ->toArray(),
        ]);
        //
        return $next($request);
    }
}
