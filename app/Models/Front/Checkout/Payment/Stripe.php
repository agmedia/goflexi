<?php

namespace App\Models\Front\Checkout\Payment;

use App\Models\Back\Orders\Order;
use App\Models\Back\Orders\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\StripeClient;

/**
 * Class Payway
 * @package App\Models\Front\Checkout\Payment
 */
class Stripe
{

    /**
     * @var Order
     */
    private $order;

    /**
     * @var string[]
     */
    private $url = [
        'test' => 'https://formtest.wspay.biz/Authorization.aspx',
        'live' => 'https://form.wspay.biz/Authorization.aspx'
    ];


    /**
     * Payway constructor.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }


    /**
     * @param Collection|null $payment_method
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function resolveFormView(Collection $payment_method = null)
    {
        if ( ! $payment_method) {
            return '';
        }

        $payment_method = $payment_method->first();

        $secret = $payment_method->data->secret_key;
        $key = $payment_method->data->public_key;

        if ( ! $payment_method->data->test) {
            $secret = $payment_method->data->secret_key;
            $key = $payment_method->data->public_key;
        }

        $total = number_format($this->order->total,2, ',', '');
        $total = str_replace( ',', '', $total);

        $stripe = new StripeClient($secret);

        $session = $stripe->checkout->sessions->create([
            'cancel_url' => route('pay-reservation'),
            'success_url' => route('checkout.success'),
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $this->order->product->title ?? $this->order->product->translation()->title,
                        ],
                        'unit_amount' => $total
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
        ]);

        $data['url'] = $session->url;

        Log::info($session->toArray());
        Log::info($data);

        return view('front.checkout.payment.stripe', compact('data'));
    }


    /**
     * @param Order $order
     * @param null  $request
     *
     * @return bool
     */
    public function finishOrder(Order $order, Request $request): bool
    {
        $status = $request->input('Success') ? config('settings.order.status.paid') : config('settings.order.status.declined');

        $order->update([
            'order_status_id' => $status
        ]);



        if ($request->input('Success')) {
            Transaction::insert([
                'order_id' => $order->id,
                'success' => 1,
               /* 'amount' => $request->input('Amount'),
                'signature' => $request->input('Signature'),
                'payment_type' => $request->input('PaymentType'),
                'payment_plan' => $request->input('PaymentPlan'),
                'payment_partner' => $request->input('Partner'),
                'datetime' => $request->input('DateTime'),
                'approval_code' => $request->input('ApprovalCode'),
                'pg_order_id' => $request->input('WsPayOrderId'),
                'lang' => $request->input('Lang'),
                'stan' => $request->input('STAN'),
                'error' => $request->input('ErrorMessage'),*/
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            return true;
        }

        Transaction::insert([
            'order_id' => $order->id,
            'success' => 0,
           /* 'amount' => $request->input('Amount'),
            'signature' => $request->input('Signature'),
            'payment_type' => $request->input('PaymentType'),
            'payment_plan' => $request->input('PaymentPlan'),
            'payment_partner' => null,
            'datetime' => $request->input('DateTime'),
            'approval_code' => $request->input('ApprovalCode'),
            'pg_order_id' => null,
            'lang' => $request->input('Lang'),
            'stan' => null,
            'error' => $request->input('ErrorMessage'),*/
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return false;
    }

}
