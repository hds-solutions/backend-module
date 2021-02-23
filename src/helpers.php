<?php

if (!function_exists('backend_path')) {
    function backend_path(string $path = ''):string {
        return realpath(__DIR__.'/../'.$path);
    }
}

if (!function_exists('module_path')) {
    function module_path(string $path = ''):string {
        dd(__DIR__);
        return realpath(__DIR__.'/../'.$path);
    }
}