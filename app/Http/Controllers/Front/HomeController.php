<?php

namespace App\Http\Controllers\Front;

use App\Helpers\BookingHelper;
use App\Helpers\Helper;
use App\Helpers\LanguageHelper;
use App\Helpers\Recaptcha;
use App\Helpers\Session\CheckoutSession;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontBaseController;
use App\Imports\ProductImport;
use App\Mail\ContactFormMessage;
use App\Models\Back\Settings\Settings;
use App\Models\Front\Apartment\Apartment;
use App\Models\Front\Catalog\Page;
use App\Models\Front\Checkout\Checkout;
use App\Models\Front\Checkout\Order;
use App\Models\Front\Checkout\Reservation;
use App\Models\Front\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HomeController extends FrontBaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('front.home');
    }


    public function viewReservation(Request $request)
    {
        $reservation = new Reservation($request);

        return view('front.view-reservation', compact('reservation'));
    }


    public function checkout(Request $request)
    {
        $checkout = new Checkout($request);
        $customer = $checkout->resolveCustomer();

        return view('front.checkout', compact('checkout', 'customer'));
    }


    public function payReservation(Request $request)
    {
        //dd($request->toArray());

        $order = new Order($request);

        $order->create(config('settings.order.status.unfinished'));

        $payment_form = $order->resolvePaymentForm();

        //dd($request->toArray(), $order);

        return view('front.pay-reservation', compact('order', 'payment_form'));
    }


    public function success(Request $request)
    {
        Log::info('public function success(Request $request) ::::: $request->toArray()');
        Log::info($request->toArray());

        return view('front.checkout.success');
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getApiAvailableProducts(Request $request)
    {
        $from = BookingHelper::resolveCities('from', $request);
        $to = BookingHelper::resolveCities('to', $request);
        $items = BookingHelper::resolveDatesList($request);

        $response = [
            'from' => $from,
            'to' => $to,
            'items' => $items
        ];

        return response()->json($response);
    }


    /**
     * @param Faq $faq
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function faq()
    {
        $faqs = Faq::where('status', 1)->orderBy('sort_order')->get();

        return view('front.faq', compact('faqs'));
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function contact(Request $request)
    {
        $owner = Helper::getBasicInfo();

        return view('front.contact', compact('owner'));
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function sendContactMessage(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'email'   => 'required|email',
            'phone'   => 'required',
            'message' => 'required',
        ]);

        // Recaptcha
        $recaptcha = (new Recaptcha())->check($request->toArray());

        if ( ! $recaptcha->ok()) {
            return back()->withErrors(['error' => __('front/common.recapta_error')]);
        }

        $message = $request->toArray();

        dispatch(function () use ($message) {
            Mail::to(Helper::getBasicInfo()->email)->send(new ContactFormMessage($message));
        });

        return redirect()->back()->with(['success' => __('front/common.message_success')]);
    }

}
