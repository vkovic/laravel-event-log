<?php

namespace Vkovic\LaravelEventLog;

if (!function_exists('package_path')) {
    /**
     * Get the path to the package folder
     *
     * @param  string $path
     *
     * @return string
     */
    function package_path($path = '')
    {
        $packagePath = rtrim(__DIR__, DIRECTORY_SEPARATOR);

        return $packagePath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}