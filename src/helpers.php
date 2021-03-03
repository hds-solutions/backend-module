<?php

use HDSSolutions\Finpar\Backend;

if (!function_exists('backend')) {
    function backend():Backend {
        return app('backend');
    }
}

if (!function_exists('backend_path')) {
    function backend_path(string $path = ''):string {
        return realpath(__DIR__.'/../'.$path);
    }
}

if (!function_exists('module_path')) {
    function module_path(string $path = ''):string {
        // get caller path
        $caller = realpath(dirname(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0]['file']));
        // get root path
        $root = explode(DIRECTORY_SEPARATOR, $caller)[0] ?: '/';
        // go back until composer.json is found
        while (!file_exists($caller.DIRECTORY_SEPARATOR.'composer.json') && $caller !== $root) $caller = dirname($caller);
        // return realpath
        return $caller.DIRECTORY_SEPARATOR.$path;
    }
}
