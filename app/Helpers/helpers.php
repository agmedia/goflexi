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

/**
 *
 */
if ( ! function_exists('ag_log')) {
    /**
     * @param             $value
     * @param string      $level [debug, test, error]
     * @param string|null $title
     *
     * @return null
     */
    function ag_log($value, string $level = 'debug', string $title = null): void
    {
        if (in_array($level, ['d', 'debug'])) {
            if ($title) \Illuminate\Support\Facades\Log::channel('debug')->info($title);

            \Illuminate\Support\Facades\Log::channel('debug')->debug($value);
        }

        if (in_array($level, ['t', 'test'])) {
            if ($title) \Illuminate\Support\Facades\Log::channel('test')->info($title);

            \Illuminate\Support\Facades\Log::channel('test')->debug($value);
        }

        if (in_array($level, ['e', 'error'])) {
            if ($title) \Illuminate\Support\Facades\Log::channel('error')->info($title);

            \Illuminate\Support\Facades\Log::channel('error')->debug($value);
        }

        \Illuminate\Support\Facades\Log::info($value);
    }
}

/**
 *
 */
if ( ! function_exists('ag_slug')) {
    /**
     * @param string|null $text
     *
     * @return string|\Illuminate\Support\Str
     */
    function ag_slug(string $text = null): string|\Illuminate\Support\Str
    {
        if ($text) {
            return \Illuminate\Support\Str::slug($text);
        }

        return new \Illuminate\Support\Str();
    }
}

/**
 *
 */
if ( ! function_exists('ag_date')) {
    /**
     * @param string|null $date
     *
     * @return string|\Illuminate\Support\Carbon
     */
    function ag_date(string $date = null): string|\Illuminate\Support\Carbon
    {
        if ($date) {
            return \Illuminate\Support\Carbon::make($date);
        }

        return new \Illuminate\Support\Carbon();
    }
}
