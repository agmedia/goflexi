<?php

namespace App\Providers;

use App\Models\Back\Settings\Settings;
use App\Models\Front\Catalog\Page;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $mode = Settings::getCached('app', 'mode');
        View::share('mode', $mode);

        $uvjeti = Page::query()->where('subgroup', 'Uvjeti kupnje')->get();
        View::share('uvjeti_kupnje', $uvjeti);
        
        Paginator::useBootstrap();
    }
}
