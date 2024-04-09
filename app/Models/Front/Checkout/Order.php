<?php

namespace App\Models\Front\Checkout;

use App\Helpers\Helper;
use App\Models\Back\Orders\OrderHistory;
use App\Models\Back\Orders\OrderProduct;
use App\Models\Back\Orders\OrderTotal;
use App\Models\Back\Settings\Settings;
use App\Models\Front\Catalog\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Order extends Model
{

    /**
     * @var string[]
     */
    protected $fillable = ['order_status_id'];

    /**
     * @var array
     */
    public $order = [];

    public $listing;

    public $options;

    public $customer;

    public $additional_person = 0;

    public $additional_child = 0;

    public $customer_message;

    public $payments_list;

    public $payment = null;

    public $total;

    public $request;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function totals()
    {
        return $this->hasMany(OrderTotal::class, 'order_id')->orderBy('sort_order');
    }


    public function setRequest(Request $request)
    {
        $this->request = $request;
        $this->additional_person = $request->input('additional_person');
        $this->additional_child = $request->input('additional_child');
        $this->customer_message = $request->input('message');

        $this->setPayment($request->input('payment'));
    }


    /**
     * @param string $state
     *
     * @return Collection
     */
    private function setPayment(string $payment, string $state = 'Croatia')
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
        ];

        return $this;
    }


    /**
     * @param array $data
     *
     * @return bool
     */
    public function create(array $data = [])
    {
        if ( ! empty($data)) {
            $this->order = $data;
        }

        if ( ! empty($this->order) && isset($this->order['cart'])) {
            $user_id = auth()->user() ? auth()->user()->id : 0;



            $order_id = \App\Models\Back\Orders\Order::insertGetId([
                'product_id' => 0,
                'user_id'          => $user_id,
                'affiliate_id'     => 0,
                'order_status_id'  => 1,
                'invoice'          => '',
                'total'            => $this->order['cart']['total'],
                'invoice'          => '',
                'invoice'          => '',
                'invoice'          => '',
                'invoice'          => '',
                'invoice'          => '',
                'payment_fname'    => $this->order['address']['fname'],
                'payment_lname'    => $this->order['address']['lname'],
                'payment_address'  => $this->order['address']['address'],
                'payment_zip'      => $this->order['address']['zip'],
                'payment_city'     => $this->order['address']['city'],
                'payment_phone'    => $this->order['address']['phone'] ?: null,
                'payment_email'    => $this->order['address']['email'],
                'payment_method'   => $this->order['payment']->title->{current_locale()},
                'payment_code'     => $this->order['payment']->code,
                'payment_card'     => '',
                'payment_installment' => '',
                'hash' => 0,
                'company'          => $this->order['address']['company'],
                'oib'              => $this->order['address']['oib'],
                'approved' => 0,
                'approved_user_id' => 0,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now()
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

                $this->updateProducts($order_id);
                $this->updateTotal($order_id);

                $this->oc_data = \App\Models\Back\Orders\Order::where('id', $order_id)->first();
            }
        }

        return $this;
    }


    /**
     * @param array $data
     *
     * @return $this|null
     */
    public function updateData(array $data)
    {
        if ( ! empty($data)) {
            $this->order = $data;
        }

        $updated = \App\Models\Back\Orders\Order::where('id', $data['id'])->update([
            'payment_fname'    => $this->order['address']['fname'],
            'payment_lname'    => $this->order['address']['lname'],
            'payment_address'  => $this->order['address']['address'],
            'payment_zip'      => $this->order['address']['zip'],
            'payment_city'     => $this->order['address']['city'],
            'payment_state'    => $this->order['address']['state'],
            'payment_phone'    => $this->order['address']['phone'] ?: null,
            'payment_email'    => $this->order['address']['email'],
            'payment_method'   => $this->order['payment']->title->{current_locale()},
            'payment_code'     => $this->order['payment']->code,
            'payment_card'     => '',
            'payment_installment' => '',
            'shipping_fname'   => $this->order['address']['fname'],
            'shipping_lname'   => $this->order['address']['lname'],
            'shipping_address' => $this->order['address']['address'],
            'shipping_zip'     => $this->order['address']['zip'],
            'shipping_city'    => $this->order['address']['city'],
            'shipping_state'   => $this->order['address']['state'],
            'shipping_phone'   => $this->order['address']['phone'] ?: null,
            'shipping_email'   => $this->order['address']['email'],
            'shipping_method'  => $this->order['shipping']->title->{current_locale()},
            'shipping_code'    => $this->order['shipping']->code,
            'company'          => $this->order['address']['company'],
            'oib'              => $this->order['address']['oib'],
            'updated_at'       => Carbon::now()
        ]);

        if ($updated) {
            $this->updateTotal($data['id']);

            return $this->setData($data['id']);
        }

        return null;
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
            'title'      => __('front/cart.ukupno'),
            'value'      => $this->order['cart']['subtotal'],
            'sort_order' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        // CONDITIONS on Total
        foreach ($this->order['cart']['conditions'] as $name => $condition) {
            if ($condition->getType() == 'payment') {
                OrderTotal::insert([
                    'order_id'   => $order_id,
                    'code'       => 'payment',
                    'title'      => $name,
                    'value'      => $condition->parsedRawValue,
                    'sort_order' => $condition->getOrder(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        }

        // TOTAL
        OrderTotal::insert([
            'order_id'   => $order_id,
            'code'       => 'total',
            'title'      =>  __('front/cart.sveukupno'),
            'value'      => $this->order['cart']['total'],
            'sort_order' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        \App\Models\Back\Orders\Order::where('id', $order_id)->update([
            'total' => $this->order['cart']['total']
        ]);
    }


    /**
     * @return mixed|null
     */
    public function resolvePaymentForm()
    {
        if ($this->isCreated()) {
            $method = new PaymentMethod($this->oc_data['payment_code']);

            return $method->resolveForm($this->oc_data);
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
        return true;
    }


    /**
     * @return bool
     */
    public function paymentNotRequired(): bool
    {
        if (in_array($this->oc_data->payment_code, ['cod', 'bank'])) {
            return true;
        }

        return false;
    }
}
