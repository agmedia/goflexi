<?php

/**
 *
 */

use App\Models\Back\Settings\Settings;
use Illuminate\Support\Facades\Cache;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

if ( ! function_exists('current_locale')) {
    /**
     * @param bool $native
     *
     * @return string
     */
    function current_locale(bool $native = false): string
    {
        $current = LaravelLocalization::getCurrentLocale();

        if ($native) {
            return config('laravellocalization.supportedLocales.' . $current . '.regional');
        }

        return $current;
    }
}

/**
 *
 */
if ( ! function_exists('ag_lang')) {
    /**
     * @param bool $main
     *
     * @return mixed
     */
    function ag_lang(bool $main = false)
    {
        if ($main) {
            return Cache::rememberForever('lang' . LaravelLocalization::getCurrentLocale(), function () {
                return Settings::get('language', 'list')
                               ->where('status', true)
                               ->where('code', LaravelLocalization::getCurrentLocale())
                               ->first();
            });
        }

        return Cache::rememberForever('langs', function () {
            return Settings::get('language', 'list')->where('status', true)->sortBy('sort_order');
        });
    }
}
