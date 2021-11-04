<?php

use HDSSolutions\Laravel\Backend;

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

if (!function_exists('str_increment')) {
    function str_increment($value):string {
        $value = 'A_'.$value;
        return substr(++$value, 2);
    }
}

if (! function_exists('warn')) {
    function warn($message = null, array $context = []) {
        if (is_null($message)) return app('log');
        return app('log')->warning($message, $context);
    }
}

if (! function_exists('error')) {
    function error($message = null, array $context = []) {
        if (is_null($message)) return app('log');
        return app('log')->error($message, $context);
    }
}
