<?php

namespace App\Http\Controllers\Back\Settings\App;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Back\Settings\Faq;
use App\Models\Back\Settings\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkForNewFiles();

        $items = $this->getActivePayments();
        $geo_zones = Settings::getList('geo_zone', 'list', false);

        return view('back.settings.app.payment.payment', compact('items', 'geo_zones'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info($request->toArray());

        $updated = Settings::setListItem('payment', 'list.' . $request->data['code'], $request->data);

        if ($updated) {
            Cache::forget('payment_list');

            return response()->json(['success' => 'Način plaćanja je uspješno snimljen.']);
        }

        return response()->json(['message' => 'Server error! Pokušajte ponovo ili kontaktirajte administratora!']);
    }


    /**
     * Check for new files in payment/modals directory.
     * Install payment if new files exist.
     */
    private function checkForNewFiles(): void
    {
        $files    = new \DirectoryIterator('./../resources/views/back/settings/app/payment/modals');

        foreach ($files as $file) {
            if (strpos($file, 'blade.php') !== false) {
                $filename = str_replace('.blade.php', '', $file);
                $exist = false;

                $payment = collect(Settings::get('payment', 'list.' . $filename));

                if ($payment) {
                    $exist = $payment->where('code', $filename)->first();
                }

                if ( ! $exist) {
                    $default_value = [
                        'title' => $filename,
                        'code' => $filename,
                        'data' => [
                            'description' => ''
                        ],
                        'sort_order' => 0,
                        'status' => 0
                    ];

                    Settings::set('payment', 'list.' . $filename, $default_value);
                }

            }
        }
    }


    /**
     * @return array|false|\Illuminate\Support\Collection
     */
    private function getActivePayments()
    {
        $payments = Settings::getList('payment', 'list.%', false)->sortBy('title.' . current_locale());
        $codes = collect(config('settings.payment.providers'))->keys()->toArray();

        foreach ($payments as $key => $payment) {
            if ( ! in_array($payment->code, $codes)) {
                $payments->offsetUnset($key);
            }
        }

        return $payments;
    }
}
