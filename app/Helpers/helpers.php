<?php

if (! function_exists('is_active')) {
    /**
     * Checks if the current request path matches the given routes.
     *
     * @param string|array $routes The route pattern(s) to check against.
     * @param string $output The string to return on match, defaults to 'active'.
     * @return string
     */
    function is_active(string | array $routes, string $output = 'active bg-sky-500/100 text-white font-semibold'): string
    {
        if (is_array($routes)) {
            foreach ($routes as $route) {
                if (request()->is($route)) {
                    return $output;
                }
            }
        } else {
            if (request()->is($routes)) {
                return $output;
            }
        }
        return '';
    }
}
