<?php

namespace App\Models\Back\Orders;

use App\Helpers\Helper;
use App\Models\Back\Apartment\Apartment;
use App\Models\Back\Catalog\Product;
use App\Models\Back\Settings\Settings;
use App\Models\Back\Users\Client;
use App\Models\Front\Checkout\Checkout;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class Order extends Model
{

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var string[]
     */
    protected $appends = ['checkout'];

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Checkout
     */
    protected $checkout;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


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
    public function history()
    {
        return $this->hasMany(OrderHistory::class, 'order_id')->orderBy('created_at', 'desc');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function totals()
    {
        return $this->hasMany(OrderTotal::class, 'order_id')->orderBy('sort_order');
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopePaid($query)
    {
        return $query->where('order_status_id', 3)->orWhere('order_status_id', 4);
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeLast($query, $count = 9)
    {
        return $query->whereIn('order_status_id', Helper::getValidReservationOrderStatuses())->orderBy('created_at', 'desc')->limit($count);
    }


    /**
     * @param       $query
     * @param array $params
     *
     * @return mixed
     */
    public function scopeChartData(Builder $query, array $params)
    {
        return $query
            ->whereBetween('date_to', [$params['from'], $params['to']])
            ->orWhereBetween('date_from', [$params['from'], $params['to']])
            ->orderBy('date_to')
            ->get()
            ->groupBy(function ($val) use ($params) {
                return \Illuminate\Support\Carbon::parse($val->date_to)->format($params['group']);
            });
    }


    /**
     * @return mixed
     */
    public function getStatusAttribute()
    {
        return Settings::get('order', 'statuses')->where('id', $this->order_status_id)->first();
    }


    /**
     * @return mixed
     */
    public function getCheckoutAttribute()
    {
        return unserialize($this->options);
    }


    /**
     * @param Request $request
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname'  => 'required',
            'phone'     => 'required',
            'email'     => 'required',
        ]);

        if ( ! $request->input('apartment_id')) {
            $request->merge(['apartment_id' => $this->apartment_id]);
        }

        $this->request = $request;

        return $this;
    }


    /**
     * @param Request $request
     *
     * @return $this
     */
    public function validateSpecialRequest(Request $request)
    {
        $request->validate([
            'apartment_id' => 'required',
            'dates'        => 'required',
            'payment_type' => 'required',
            'firstname'    => 'required',
            'lastname'     => 'required',
            'email'        => 'required',
            'adults'       => 'required'
        ]);

        if ( ! $request->input('phone')) {
            $request->merge(['phone' => '000']);
        }

        if ($request->input('babies')) {
            $request->merge(['baby' => $request->input('babies')]);
        }

        $this->request = $request;

        return $this;
    }


    /**
     * @return bool
     */
    public function isApartmentAvailable()
    {
        $dates = explode(' - ', $this->request->input('dates'));

        $orders = Order::query()
                       ->where('apartment_id', $this->request->input('apartment_id'))
                       ->where(function ($query) use ($dates) {
                           $query->where([
                               ['date_from', '<', date($dates[0])],
                               ['date_to', '>=', date($dates[0])]
                           ])->orWhere([
                               ['date_from', '>', date($dates[1])],
                               ['date_to', '<=', date($dates[1])]
                           ]);
                       })
                       ->get();

        if ($orders->count()) {
            return false;
        }

        return true;
    }


    /**
     * @return $this
     */
    public function checkDates()
    {
        if ( ! $this->request->dates) {
            $this->request->merge(['dates' => Carbon::make($this->date_from)->format('Y-m-d') . ' - ' . Carbon::make($this->date_to)->format('Y-m-d')]);
        }

        return $this;
    }


    /**
     * @param Checkout $checkout
     *
     * @return $this
     */
    public function setCheckoutData(Checkout $checkout)
    {
        $this->checkout = $checkout;

        return $this;
    }


    /**
     * @param null $id
     *
     * @return bool
     */
    public function store($id = null)
    {
        $order = $id ? $this->updateData($id) : $this->storeData();

        if ( ! $id && $order) {
            $id = $order->id;
        }

        if ($order) {
            OrderTotal::where('order_id', $id)->delete();

            foreach ($this->checkout->total['total'] as $key => $total) {
                OrderTotal::insertRow($id, $total['code'], $total['total'], $key);
            }

            $this->resolveForcedTotal($id);
            $this->resolveHash($id);

            return $this;
        }

        return false;
    }


    /**
     * @param Request $request
     *
     * @return Builder
     */
    public function filter(Request $request): Builder
    {
        $query = $this->newQuery();

        if ($request->has('status')) {
            $query->where('order_status_id', '=', $request->input('status'));
        } else {
            $query->where('order_status_id', '!=', config('settings.order.status.unfinished'));
        }

        if ($request->has('search') && ! empty($request->input('search'))) {
            $query->where(function ($query) use ($request) {
                $query->where('id', 'like', '%' . $request->input('search') . '%')
                      ->orWhere('payment_fname', 'like', '%' . $request->input('search') . '%')
                      ->orWhere('payment_lname', 'like', '%' . $request->input('search') . '%')
                      ->orWhere('payment_email', 'like', '%' . $request->input('search') . '%');
            });

            /*$query->orWhere(function ($query) use ($request) {
                $query->whereHas('product', function ($subquery) use ($request) {
                    $subquery->whereHas('translation_search', function ($sub_subquery) use ($request) {
                        $sub_subquery->where('title', 'like', '%' . $request->input('search') . '%');
                    });
                });
            });*/
        }

        if ($request->has('dates') && ! empty($request->input('dates'))) {
            $dates = explode(' - ', $request->input('dates'));

            $query->where('date_from', '>=', Carbon::make($dates[0]))->where('date_to', '<=', Carbon::make($dates[1]));
        }

        if ($request->has('from') && ! empty($request->input('from'))) {
            $query->where('date_from', '=', Carbon::make($request->input('from')));
        }
        if ($request->has('to') && ! empty($request->input('to'))) {
            $query->where('date_to', '=', Carbon::make($request->input('to')));
        }

        if ($request->has('origin') && ! empty($request->input('origin')) && $request->input('origin') != 'all') {
            if ($request->input('origin') == 'selfcheckins') {
                $query->whereNotIn('payment_fname', ['Booking', 'Airbnb']);
            } else {
                $query->where('payment_fname', 'like', '%' . $request->input('origin'));
            }
        }

        // Sort Order
        if ($request->has('sort') && ! empty($request->input('sort'))) {
            $sort = $request->input('sort');

            if ($sort == 'in') {
                $query->orderBy('date_from', 'desc');
            }
            if ($sort == 'out') {
                $query->orderBy('date_to', 'desc');
            }
            if ($sort == 'old') {
                $query->orderBy('created_at');
            }
            if ($sort == 'new') {
                $query->orderBy('created_at', 'desc');
            }
        }

        // Sort Order
        if ( ! $request->has('sort')) {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }


    /**
     * @return mixed
     */
    public function completeDelete()
    {
        OrderTotal::where('order_id', $this->id)->delete();
        OrderHistory::where('order_id', $this->id)->delete();
        Transaction::where('order_id', $this->id)->delete();

        return self::where('id', $this->id)->delete();
    }

    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * @param string $target
     * @param array  $event
     * @param int    $apartment_id
     *
     * @return false|Order
     */
    public static function storeSyncData(string $target, array $event, int $apartment_id)
    {
        // Escape Airbnb 3 month advance constant reservation.
        if (Carbon::make($event['start'])->addDays(3) > now()->addMonths(3)) {
            return 1;
        }

        $existing_order = self::where('sync_uid', $event['uid'])->where('apartment_id', $apartment_id)->first();

        // If order exist and status is paid. (not canceled)
        if ($existing_order && $existing_order->order_status_id != config('settings.order.status.canceled')) {
            // Check if dates have changed
            if (carbon($existing_order->date_from)->ne(carbon($event['start'])) || carbon($existing_order->date_to)->ne(carbon($event['end']))) {
                $checkout = new Checkout(Helper::setCheckoutSyncRequest($event, $apartment_id));

                $existing_order->update([
                    'total'      => $checkout->total_amount,
                    'date_from'  => Carbon::make($event['start']),
                    'date_to'    => Carbon::make($event['end']),
                    'options'    => serialize(Helper::returnCheckoutCleanData($event, $checkout)),
                    'updated_at' => Carbon::now()
                ]);
            }

            return 1;
        }

        // If existing order has been paid.
        if ($existing_order && $existing_order->order_status_id == config('settings.order.status.canceled')) {
            return $existing_order->update([
                'order_status_id' => config('settings.order.status.paid')
            ]);
        }

        $checkout = new Checkout(Helper::setCheckoutSyncRequest($event, $apartment_id));

        $id = self::insertGetId([
            'apartment_id'     => $apartment_id,
            'user_id'          => 0,
            'affiliate_id'     => 0,
            'order_status_id'  => config('settings.order.status.paid'),
            'invoice'          => '',
            'total'            => $checkout->total_amount,
            'date_from'        => Carbon::make($event['start']),
            'date_to'          => Carbon::make($event['end']),
            'payment_fname'    => ($target == 'airbnb') ? 'Airbnb' : 'Booking',
            'payment_lname'    => 'Sync',
            'payment_email'    => ($target == 'airbnb') ? 'info@airbnb.com' : 'info@booking.com',
            'payment_method'   => 'card',
            'payment_code'     => 'corvus',
            'company'          => '',
            'oib'              => '',
            'options'          => serialize(Helper::returnCheckoutCleanData($event, $checkout)),
            'comment'          => (($target == 'airbnb') ? 'Airbnb' : 'Booking') . ' synchronized order.',
            'sync_uid'         => $event['uid'],
            'approved'         => '',
            'approved_user_id' => '',
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        if ($id) {
            return static::storeOrderSyncData($id, $checkout);
        }

        return false;
    }

    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * @param int      $id
     * @param Checkout $checkout
     *
     * @return mixed
     */
    private function storeOrderSyncData(int $id, Checkout $checkout)
    {
        OrderHistory::store($id);

        OrderTotal::where('order_id', $id)->delete();

        foreach ($checkout->total['total'] as $key => $total) {
            OrderTotal::insertRow($id, $total['code'], $total['total'], $key);
        }

        return self::find($id);
    }


    /**
     * @return false
     */
    private function storeData()
    {
        $id = $this->insertGetId([
            'apartment_id'    => $this->checkout->apartment->id,
            'user_id'         => 0,
            'order_status_id' => config('settings.order.status.new'),
            'invoice'         => 'special',
            'total'           => $this->checkout->total_amount,
            'date_from'       => $this->checkout->from,
            'date_to'         => $this->checkout->to,
            'payment_fname'   => $this->checkout->firstname,
            'payment_lname'   => $this->checkout->lastname,
            'payment_address' => '',
            'payment_zip'     => '',
            'payment_city'    => '',
            'payment_phone'   => $this->checkout->phone,
            'payment_email'   => $this->checkout->email,
            'payment_method'  => $this->checkout->payment->code,
            'payment_code'    => $this->checkout->payment->code,
            'company'         => isset($this->request->company) ? $this->request->company : '',
            'oib'             => isset($this->request->oib) ? $this->request->oib : '',
            'options'         => serialize($this->checkout->cleanData()),
            'created_at'      => Carbon::now(),
            'updated_at'      => Carbon::now()
        ]);

        if ($id) {
            return $this->find($id);
        }

        return false;
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    private function updateData($id)
    {
        if ( ! $this->checkout->lastname == 'Service') {
            $this->where('id', $id)->where('invoice', '!=', 'special')->update([
                'invoice' => '',
            ]);
        }

        return $this->where('id', $id)->update([
            'apartment_id'    => $this->checkout->apartment->id,
            'total'           => $this->checkout->total_amount,
            'date_from'       => $this->checkout->from,
            'date_to'         => $this->checkout->to,
            'payment_fname'   => $this->checkout->firstname,
            'payment_lname'   => $this->checkout->lastname,
            'payment_address' => '',
            'payment_zip'     => '',
            'payment_city'    => '',
            'payment_phone'   => $this->checkout->phone,
            'payment_email'   => $this->checkout->email,
            'payment_method'  => $this->checkout->payment->code,
            'payment_code'    => $this->checkout->payment->code,
            'company'         => isset($this->request->company) ? $this->request->company : null,
            'oib'             => isset($this->request->oib) ? $this->request->oib : null,
            'options'         => serialize($this->checkout->cleanData()),
            'updated_at'      => Carbon::now()
        ]);
    }


    /**
     * @param $id
     *
     * @return $this
     */
    private function resolveForcedTotal($id)
    {
        if ($this->checkout->force_paid_amount) {
            $this->where('id', $id)->update(['total' => $this->checkout->force_paid_amount]);
        }

        return $this;
    }


    /**
     * @param $id
     *
     * @return $this
     */
    private function resolveHash($id)
    {
        $this->where('id', $id)->update([
            'hash' => Helper::encryptor(now()->toISOString())
        ]);

        return $this;
    }
}
