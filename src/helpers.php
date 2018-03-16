<?php

if (!function_exists('theme')) {
    /**
     * @return \DarthSoup\Theme\ThemeManager
     */
    function theme()
    {
        return app('darthsoup.themes');
    }
}

if (! function_exists('asset_theme')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool    $secure
     * @return string
     */
    function asset_theme($path, $secure = null)
    {
        return app('darthsoup.themes')->asset($path, $secure);
    }
}

if (!function_exists('property_theme')) {
    /**
     * Get / set the specified configuration value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string $key
     * @param  mixed $default
     * @return mixed
     */
    function property_theme($key = null, $default = null)
    {
        if (null === $key) {
            return app('darthsoup.themes')->property();
        }

        return app('darthsoup.themes')->property($key, $default);
    }
}

if (!function_exists('config_theme')) {
    /**
     * Get / set the specified configuration value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string $key
     * @param  mixed $default
     * @return mixed
     */
    function config_theme($key = null, $default = null)
    {
        if (null === $key) {
            return app('darthsoup.themes')->config();
        }

        return app('darthsoup.themes')->config($key, $default);
    }
}

if (!function_exists('active_theme')) {

    /**
     * @return \DarthSoup\Theme\Theme|null
     */
    function active_theme()
    {
        return app('darthsoup.themes')->active();
    }
}
