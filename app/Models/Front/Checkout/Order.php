<?php

namespace App\Models\Front\Checkout;

use App\Helpers\Helper;
use App\Models\Back\Orders\OrderHistory;
use App\Models\Back\Orders\OrderTotal;
use App\Models\Front\Catalog\Option;
use App\Models\Front\Catalog\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Order
{

    /**
     * @var \App\Models\Back\Orders\Order
     */
    public $order;

    public $listing;

    public $options;

    public $customer;

    public $additional_person = 0;

    public $additional_child = 0;

    public $child_seat = 0;

    public $child_seat_type = '';

    public $baggage = 0;

    public $customer_message;

    public $payments_list;

    public $payment = null;

    public $total;

    public $request;


    public function __construct(Request $request = null)
    {
        if ($request) {
            $this->setRequest($request);
        }
    }


    public function setRequest(Request $request)
    {
        $this->request = $request;

        $this->additional_person = $this->request->input('additional_person');
        $this->additional_child = $this->request->input('additional_child');
        $this->customer_message = $this->request->input('message');
        $this->child_seat_type = $this->request->input('data-plans-selected');

        $this->setListing()
             ->setPayment($this->request->input('payment'))
             ->setCustomer()
             ->setOptions()
             ->setTotal();
    }


    private function setListing(int $id = null)
    {
        if ( ! $id) {
            $id = $this->request->listing;
        }

        $this->listing = Product::query()->where('id', $id)->first();

        return $this;
    }


    private function setPayment(string $payment = 'stripe', string $state = 'Croatia')
    {
        $geo = (new GeoZone())->findState($state);

        $this->payments_list = (new PaymentMethod())->findGeo($geo->id)->resolve();
        $this->payment = $this->payments_list->where('code', $payment)->first();

        return $this;
    }


    private function setCustomer()
    {
        $this->customer = [
            'firstname' => $this->request->input('firstname'),
            'lastname'  => $this->request->input('lastname'),
            'phone'     => $this->request->input('phone'),
            'email'     => $this->request->input('email'),
            'comment'     => $this->request->input('message'),
        ];

        return $this;
    }


    private function setOptions()
    {
        if ($this->request->has('option')) {
            foreach ($this->request->input('option') as $option_id) {
                $this->options[] = Option::query()->where('status', 1)->where('id', $option_id)->first();

                if ($option_id == config('settings.options.child_seat')) {
                    $this->child_seat = 1;
                }

                if ($option_id == config('settings.options.baggage')) {
                    $this->baggage = 1;
                }
            }
        }

        return $this;
    }


    private function setTotal()
    {
        $this->total = $this->listing->price;

        if ($this->additional_person) {
            $this->total += ($this->listing->price * $this->additional_person);
        }

        if ($this->additional_child) {
            $this->total += ($this->listing->price_child * $this->additional_child);
        }

        if ( ! empty($this->options)) {
            foreach ($this->options as $option) {
                $this->total += $option->price;
            }
        }

        return $this;
    }


    /**
     * @param array $data
     *
     * @return bool
     */
    public function create(int $status = null)
    {
        if ( ! $status) {
            $status = config('settings.order.status.unfinished');
        }

        $user_id = auth()->user() ? auth()->user()->id : 0;

        $order_id = \App\Models\Back\Orders\Order::insertGetId([
            'product_id'          => $this->listing->id,
            'user_id'             => $user_id,
            'affiliate_id'        => 0,
            'order_status_id'     => $status,
            'invoice'             => '',
            'total'               => $this->total,
            'adults'              => 1 + $this->additional_person,
            'children'            => $this->additional_child,
            'type'                => 'oneway',
            'child_seat'          => $this->child_seat,
            'baggage'             => $this->baggage,
            'payment_fname'       => $this->customer['firstname'],
            'payment_lname'       => $this->customer['lastname'],
            'payment_address'     => '',
            'payment_zip'         => '',
            'payment_city'        => '',
            'payment_phone'       => $this->customer['phone'],
            'payment_email'       => $this->customer['email'],
            'payment_method'      => $this->payment->title->{current_locale()},
            'payment_code'        => $this->payment->code,
            'payment_card'        => '',
            'payment_installment' => 0,
            'hash'                => 0,
            'company'             => '',
            'oib'                 => '',
            'approved'            => 0,
            'approved_user_id'    => 0,
            'created_at'          => Carbon::now(),
            'updated_at'          => Carbon::now()
        ]);

        if ($order_id) {
            // HISTORY
            OrderHistory::insert([
                'order_id'   => $order_id,
                'user_id'    => $user_id,
                'comment'    => config('settings.order.made_text'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $this->updateTotal($order_id);

            $this->order = \App\Models\Back\Orders\Order::where('id', $order_id)->first();
        }

        return $this;
    }


    /**
     * @param int $order_id
     */
    private function updateTotal(int $order_id)
    {
        OrderTotal::where('order_id', $order_id)->delete();

        // SUBTOTAL
        OrderTotal::insert([
            'order_id'   => $order_id,
            'code'       => 'subtotal',
            'title'      => __('front/checkout.subtotal'),
            'value'      => $this->listing->price,
            'sort_order' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $sort_order = 1;

        // CONDITIONS on Total
        if ($this->additional_person) {
            OrderTotal::insert([
                'order_id'   => $order_id,
                'code'       => 'option',
                'title'      => __('front/checkout.option_additional_person'),
                'value'      => ($this->additional_person * $this->listing->price),
                'sort_order' => $sort_order,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $sort_order++;
        }

        if ($this->additional_child) {
            OrderTotal::insert([
                'order_id'   => $order_id,
                'code'       => 'option',
                'title'      => __('front/checkout.option_additional_child'),
                'value'      => ($this->additional_child * $this->listing->price_child),
                'sort_order' => $sort_order,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $sort_order++;
        }

        if ( ! empty($this->options)) {
            foreach ($this->options as $option) {
                OrderTotal::insert([
                    'order_id'   => $order_id,
                    'code'       => 'option',
                    'title'      => $option->title,
                    'value'      => $option->price,
                    'sort_order' => $sort_order,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                $sort_order++;
            }
        }

        // TOTAL
        OrderTotal::insert([
            'order_id'   => $order_id,
            'code'       => 'total',
            'title'      =>  __('front/checkout.total'),
            'value'      => $this->total,
            'sort_order' => $sort_order,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }


    /**
     * @return mixed|null
     */
    public function resolvePaymentForm()
    {
        if ($this->isCreated()) {
            $method = new PaymentMethod($this->order->payment_code);

            return $method->resolveForm($this->order);
        }

        return null;
    }


    /**
     * @param Request $request
     *
     * @return mixed|null
     */
    public function finish(Request $request)
    {
        if ($this->isCreated()) {
            $method = new PaymentMethod($this->oc_data['payment_code']);

            return $method->finish($this->oc_data, $request);
        }

        return null;
    }


    /**
     * @return bool
     */
    public function isCreated(): bool
    {
        if (isset($this->order->id)) {
            return true;
        }

        return false;
    }


    /**
     * @return bool
     */
    public function paymentNotRequired(): bool
    {
        if (isset($this->order->id)) {
            if (in_array($this->order->payment_code, ['cod', 'bank'])) {
                return true;
            }
        }

        return false;
    }
}
