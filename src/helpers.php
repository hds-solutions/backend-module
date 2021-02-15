<?php

if (!function_exists('backend_path')) {
    function backend_path(string $path = ''):string {
        return realpath(__DIR__.'/../'.$path);
    }
}