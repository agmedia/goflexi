<?php

use App\Http\Controllers\Back\Catalog\ProductController;
use App\Http\Controllers\Back\Catalog\OptionController;
use App\Http\Controllers\Back\Catalog\PageController;
use App\Http\Controllers\Back\Catalog\WidgetController;
use App\Http\Controllers\Back\Sales\OrderController;
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
                Route::get('store-predefined-list', [ProductController::class, 'storeList'])->name('product.create.list');
            });
            // OPTIONS: PRODUCT ADDITIONAL PAYMENTS
            Route::get('options', [OptionController::class, 'index'])->name('options');
            Route::get('option/create', [OptionController::class, 'create'])->name('options.create');
            Route::post('option', [OptionController::class, 'store'])->name('options.store');
            Route::get('option/{option}/edit', [OptionController::class, 'edit'])->name('options.edit');
            Route::patch('option/{option}', [OptionController::class, 'update'])->name('options.update');
            Route::delete('option/{option}', [OptionController::class, 'destroy'])->name('options.destroy');
            // WIDGETS
            Route::prefix('widgets')->group(function () {
                Route::get('/', [WidgetController::class, 'index'])->name('widgets');
                Route::get('create', [WidgetController::class, 'create'])->name('widget.create');
                Route::post('/', [WidgetController::class, 'store'])->name('widget.store');
                Route::get('{widget}/edit', [WidgetController::class, 'edit'])->name('widget.edit');
                Route::patch('{widget}', [WidgetController::class, 'update'])->name('widget.update');
            });
            // PAGES
            Route::prefix('pages')->group(function () {
                Route::get('/', [PageController::class, 'index'])->name('pages');
                Route::get('create', [PageController::class, 'create'])->name('page.create');
                Route::post('/', [PageController::class, 'store'])->name('page.store');
                Route::get('{page}/edit', [PageController::class, 'edit'])->name('page.edit');
                Route::patch('{page}', [PageController::class, 'update'])->name('page.update');
            });
        });

        // SALES
        Route::prefix('sales')->group(function () {
            // ORDERS
            Route::get('orders', [OrderController::class, 'index'])->name('orders');
            Route::get('order/create', [OrderController::class, 'create'])->name('orders.create');
            Route::post('order', [OrderController::class, 'store'])->name('orders.store');
            Route::get('order/{order}', [OrderController::class, 'show'])->name('orders.show');
            Route::get('order/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
            Route::patch('order/{order}', [OrderController::class, 'update'])->name('orders.update');
            Route::get('order/{order}/delete', [OrderController::class, 'destroy'])->name('orders.destroy');
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
                Route::prefix('geo-zones')->group(function () {
                    Route::get('/', [GeoZoneController::class, 'index'])->name('geozones');
                    Route::get('/create', [GeoZoneController::class, 'create'])->name('geozones.create');
                    Route::post('', [GeoZoneController::class, 'store'])->name('geozones.store');
                    Route::get('/{geozone}/edit', [GeoZoneController::class, 'edit'])->name('geozones.edit');
                    Route::patch('/{geozone}', [GeoZoneController::class, 'store'])->name('geozones.update');
                    Route::delete('/{geozone}', [GeoZoneController::class, 'destroy'])->name('geozones.destroy');
                });
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
    Route::post('maintenance/mode', [QuickMenuController::class, 'setTemplateMode'])->name('template.mode');
    // PRODUCTS
    Route::post('product/available/get', [HomeController::class, 'getApiAvailableProducts'])->name('product.api.get');
    Route::post('product/destroy', [ProductController::class, 'destroy'])->name('product.api.destroy');
    // OPTIONS
    Route::post('/options/destroy/api', [OptionController::class, 'destroyApi'])->name('options.destroy.api');
    // ORDERS
    Route::post('/order/new', [OrderController::class, 'store_new'])->name('api.order.new');
    // WIDGET
    Route::prefix('widget')->group(function () {
        Route::post('destroy', [WidgetController::class, 'destroy'])->name('widget.destroy');
        Route::get('get-links', [WidgetController::class, 'getLinks'])->name('widget.api.get-links');
    });
    // PAGES
    Route::post('page/destroy', [PageController::class, 'destroy'])->name('page.api.destroy');

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
    Route::get('info/{page}', [HomeController::class, 'page'])->name('route.page');
    Route::post('view/reservation', [HomeController::class, 'viewReservation'])->name('view-reservation');
    Route::post('checkout', [HomeController::class, 'checkout'])->name('checkout');
    Route::post('pay/reservation', [HomeController::class, 'payReservation'])->name('pay-reservation');
    Route::get('/success', [HomeController::class, 'success'])->name('checkout.success');
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
