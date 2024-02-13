<?php

use App\Http\Controllers\Back\Catalog\ProductController;
use App\Http\Controllers\Back\Catalog\WidgetController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\Marketing\FaqController;
use App\Http\Controllers\Back\Sales\CalendarController;
use App\Http\Controllers\Back\Settings\App\CurrencyController;
use App\Http\Controllers\Back\Settings\App\GeoZoneController;
use App\Http\Controllers\Back\Settings\App\LanguagesController;
use App\Http\Controllers\Back\Settings\App\OrderStatusController;
use App\Http\Controllers\Back\Settings\App\PaymentController;
use App\Http\Controllers\Back\Settings\App\TaxController;
use App\Http\Controllers\Back\Settings\HistoryController;
use App\Http\Controllers\Back\Settings\OptionController;
use App\Http\Controllers\Back\Settings\QuickMenuController;
use App\Http\Controllers\Back\Settings\System\ApplicationController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Route;

/**
 * BACK ROUTES LOCALIZED
 */
Route::group(
    [
        'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function() {

    Route::middleware(['auth:sanctum', 'no.customers'])->prefix('admin')->group(function () {
        // DASHBOARD
        Route::match(['get', 'post'], '/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // CATALOG
        Route::prefix('catalog')->group(function () {
            // PRODUCTS
            Route::prefix('products')->group(function () {
                Route::get('/', [ProductController::class, 'index'])->name('products');
                Route::get('create', [ProductController::class, 'create'])->name('product.create');
                Route::post('/', [ProductController::class, 'store'])->name('product.store');
                Route::get('{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
                Route::patch('{product}', [ProductController::class, 'update'])->name('product.update');
            });
            // WIDGETS
            Route::prefix('widgets')->group(function () {
                Route::get('/', [WidgetController::class, 'index'])->name('widgets');
                Route::get('create', [WidgetController::class, 'create'])->name('widget.create');
                Route::post('/', [WidgetController::class, 'store'])->name('widget.store');
                Route::get('{widget}/edit', [WidgetController::class, 'edit'])->name('widget.edit');
                Route::patch('{widget}', [WidgetController::class, 'update'])->name('widget.update');
            });
        });

        // SALES
        Route::prefix('sales')->group(function () {
            // KALENDAR
            Route::get('calendar', [CalendarController::class, 'index'])->name('calendar');
            Route::get('calendar/create', [CalendarController::class, 'create'])->name('calendar.create');
        });

        // MARKETING
        Route::prefix('marketing')->group(function () {
            // FAQ
            Route::get('faqs', [FaqController::class, 'index'])->name('faqs');
            Route::get('faq/create', [FaqController::class, 'create'])->name('faqs.create');
            Route::post('faq', [FaqController::class, 'store'])->name('faqs.store');
            Route::get('faq/{faq}/edit', [FaqController::class, 'edit'])->name('faqs.edit');
            Route::patch('faq/{faq}', [FaqController::class, 'update'])->name('faqs.update');
            Route::delete('faq/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');
        });

        // KORISNICI
        Route::get('users', [UserController::class, 'index'])->name('users');
        Route::get('user/create', [UserController::class, 'create'])->name('users.create');
        Route::post('user', [UserController::class, 'store'])->name('users.store');
        Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::patch('user/{user}', [UserController::class, 'update'])->name('users.update');

        // POSTAVKE
        Route::prefix('settings')->group(function () {

            // SISTEM
            Route::prefix('system')->group(function () {
                // APPLICATION SETTINGS
                Route::get('application', [ApplicationController::class, 'index'])->name('application.settings');
            });

            // LOCALE SETTINGS
            Route::prefix('application')->group(function () {
                // LANGUAGES
                Route::get('languages', [LanguagesController::class, 'index'])->name('languages');
                // TAXEX
                Route::get('taxes', [TaxController::class, 'index'])->name('taxes');
                // CURRENCY
                Route::get('currencies', [CurrencyController::class, 'index'])->name('currencies');
                // GEO ZONES
                Route::get('geo-zones', [GeoZoneController::class, 'index'])->name('geozones');
                Route::get('geo-zone/create', [GeoZoneController::class, 'create'])->name('geozones.create');
                Route::post('geo-zone', [GeoZoneController::class, 'store'])->name('geozones.store');
                Route::get('geo-zone/{geozone}/edit', [GeoZoneController::class, 'edit'])->name('geozones.edit');
                Route::patch('geo-zone/{geozone}', [GeoZoneController::class, 'store'])->name('geozones.update');
                Route::delete('geo-zone/{geozone}', [GeoZoneController::class, 'destroy'])->name('geozones.destroy');
                // ORDER STATUSES
                Route::get('order-statuses', [OrderStatusController::class, 'index'])->name('order.statuses');
                // PAYMENTS
                Route::get('payments', [PaymentController::class, 'index'])->name('payments');
            });

            // DIFFERENT APPLICATION SETTINGS
            Route::get('/clean/cache', [QuickMenuController::class, 'cache'])->name('cache.clean');
        });

    });
});

/**
 * API Routes
 */
Route::prefix('api')->group(function () {
    // SETTINGS
    Route::post('maintenance/mode', [QuickMenuController::class, 'maintenanceMode'])->name('maintenance.mode');
    // PRODUCTS
    Route::post('destroy', [ProductController::class, 'destroy'])->name('product.api.destroy');
    // WIDGET
    Route::prefix('widget')->group(function () {
        Route::post('destroy', [WidgetController::class, 'destroy'])->name('widget.destroy');
        Route::get('get-links', [WidgetController::class, 'getLinks'])->name('widget.api.get-links');
    });

    // SETTINGS
    Route::prefix('settings')->group(function () {
        // SYSTEM
        Route::prefix('system')->group(function () {
            // APPLICATION
            Route::prefix('application')->group(function () {
                Route::post('basic/store', [ApplicationController::class, 'basicInfoStore'])->name('api.application.basic.store');
                Route::post('maps-api/store', [ApplicationController::class, 'storeGoogleMapsApiKey'])->name('api.application.google-api.store.key');
            });
        });

        // LOCAL SETTINGS
        Route::prefix('application')->group(function () {
            // LANGUAGES
            Route::prefix('languages')->group(function () {
                Route::post('store', [LanguagesController::class, 'store'])->name('api.languages.store');
                Route::post('store/main', [LanguagesController::class, 'storeMain'])->name('api.languages.store.main');
                Route::post('destroy', [LanguagesController::class, 'destroy'])->name('api.languages.destroy');
            });
            // CURRENCIES
            Route::prefix('currencies')->group(function () {
                Route::post('store', [CurrencyController::class, 'store'])->name('api.currencies.store');
                Route::post('store/main', [CurrencyController::class, 'storeMain'])->name('api.currencies.store.main');
                Route::post('destroy', [CurrencyController::class, 'destroy'])->name('api.currencies.destroy');
            });
            // TAXES
            Route::prefix('taxes')->group(function () {
                Route::post('store', [TaxController::class, 'store'])->name('api.taxes.store');
                Route::post('destroy', [TaxController::class, 'destroy'])->name('api.taxes.destroy');
            });
            // GEO ZONE
            Route::prefix('geo-zones')->group(function () {
                Route::post('get-state-zones', 'Back\Settings\Store\GeoZoneController@getStateZones')->name('geo-zone.get-state-zones');
                Route::post('store', 'Back\Settings\Store\GeoZoneController@store')->name('geo-zone.store');
                Route::post('destroy', 'Back\Settings\Store\GeoZoneController@destroy')->name('geo-zone.destroy');
            });
            // ORDER STATUS
            Route::prefix('order-statuses')->group(function () {
                Route::post('store', [OrderStatusController::class, 'store'])->name('api.order.status.store');
                Route::post('destroy', [OrderStatusController::class, 'destroy'])->name('api.order.status.destroy');
                Route::post('change', [OrderController::class, 'api_status_change'])->name('api.order.status.change');
            });
            // PAYMENTS
            Route::prefix('payment')->group(function () {
                Route::post('store', [PaymentController::class, 'store'])->name('api.payment.store');
                Route::post('destroy', [PaymentController::class, 'destroy'])->name('api.payment.destroy');
            });

        });
    });
});


/**
 * FRONT ROUTES LOCALIZED
 */
Route::group(
    [
        'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function() {

    /**
     * FRONT ROUTES
     */
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('faq', [HomeController::class, 'faq'])->name('faq');
    Route::get('/kontakt', [HomeController::class, 'contact'])->name('kontakt');
    Route::post('/kontakt/posalji', [HomeController::class, 'sendContactMessage'])->name('poruka');

    /**
     *
     */
    Route::fallback(function () {
        return view('errors.404');
    });

});

/**
 *  TESTING ROUTES
 */
/*Route::get('/phpinfo', function () {
    return phpinfo();
})->name('phpinfo');*/
