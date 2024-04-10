<?php

namespace App\Models\Front\Checkout;

use App\Models\Front\Catalog\Option;
use App\Models\Front\Catalog\Product;
use Illuminate\Http\Request;

/**
 * Class Checkout
 * @package App\Models\Front\Checkout
 */
class Checkout
{

    public $listing;

    public $options;

    public $available_options;

    public $additional_person = 0;

    public $additional_child = 0;

    public $payments_list;

    public $payment = null;

    public $total;

    public $request;


    /**
     * @param Request $request
     *                        ['from', 'to', 'listing']
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->getTrip($this->request->input('listing'))
             ->getAvailableOptions()
             ->hasSelectableOptions()
             ->hasAdditionalPerson()
             ->hasAdditionalChild()
             ->getPaymentMethodsList()
             ->setTotal();

        // get payments methods
    }


    /**
     * @param string|null $payment
     *
     * @return null
     */
    public function setPayment(string $payment = null)
    {
        if ($payment) {
            $this->payment = $this->payments_list->where('code', $payment)->first();
        } else {
            if (isset($this->request->payment_type)) {
                $this->payment = $this->payments_list->where('code', $this->request->payment_type)->first();
            }
        }

        if ( ! $this->payment && ! isset($this->payment->code)) {
            $this->payment = $this->payments_list->where('code', config('settings.payment.default'))->first();
        }

        return $this->payment->code ?: null;
    }


    public function resolveCustomer()
    {
        if ( ! auth()->guest()) {
            $user = auth()->user();

            return [
                'firstname' => $user->detail->fname,
                'lastname'  => $user->detail->lname,
                'phone'     => $user->detail->phone,
                'email'     => $user->email,
            ];
        }

        return [
            'firstname' => '',
            'lastname'  => '',
            'phone'     => '',
            'email'     => '',
        ];
    }


    /**
     * @param int|null $id
     *
     * @return $this
     */
    private function getTrip(int $id = null)
    {
        $this->listing = Product::query()->where('id', $id)->first();

        return $this;
    }


    private function hasAdditionalPerson()
    {
        if ($this->request->has('quantity_adult')) {
            if ($this->request->input('quantity_adult') > 1) {
                $this->additional_person = $this->request->input('quantity_adult') - 1;
            }
        }

        return $this;
    }


    private function hasAdditionalChild()
    {
        if ($this->request->has('quantity_child') && $this->request->input('quantity_child')) {
            $this->additional_child = $this->request->input('quantity_child');
        }

        return $this;
    }


    private function hasSelectableOptions()
    {
        if ($this->request->has('option')) {
            foreach ($this->request->input('option') as $option_id) {
                $this->options[] = Option::query()->where('status', 1)->where('id', $option_id)->first();
            }
        }


        return $this;
    }


    public function getAvailableOptions()
    {
        $this->available_options = Option::query()->where('status', 1)->orderBy('sort_order')->get();

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
     * @param string $state
     *
     * @return $this
     */
    private function getPaymentMethodsList(string $state = 'Croatia')
    {
        $geo = (new GeoZone())->findState($state);

        $this->payments_list = (new PaymentMethod())->findGeo($geo->id)->resolve();

        if ($this->payments_list) {
            $this->setPayment($this->request->payment_type);
        }

        return $this;
    }


}
