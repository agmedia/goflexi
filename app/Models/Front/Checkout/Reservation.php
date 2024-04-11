<?php

namespace App\Models\Front\Checkout;

use App\Models\Front\Catalog\Option;
use App\Models\Front\Catalog\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * Class Checkout
 * @package App\Models\Front\Checkout
 */
class Reservation
{

    public $listing;

    public $options;

    public $time;

    public $seats;

    public $request;


    /**
     * @param Request $request
     *                        ['from', 'to', 'listing']
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->getListing($this->request->input('listing'))
             ->getAvailableOptions()
             ->getAvailableSeats()
             ->getTime();
    }


    public function getAvailableOptions()
    {
        $this->options = Option::query()->where('status', 1)->orderBy('sort_order')->get();

        return $this;
    }


    public function getAvailableSeats()
    {
        $this->seats = $this->listing->quantity;

        return $this;
    }


    public function getTime()
    {
        $start = Carbon::make($this->listing->start_time);
        $end = Carbon::make($this->listing->end_time);
        $of = current_locale() == 'hr' ? '' : 'of ';

        $this->time = [
            'date' => $start->format('l jS ' . $of . 'F Y'),
            //'date' => $start->format('l jS \\of F Y h:i:s A'),
            'start_time' => $start->format('h:i a'),
            'end_time' => $end->format('h:i a'),
            'duration' => $end->shortAbsoluteDiffForHumans($start)
        ];

        return $this;
    }


    /**
     * @param int|null $id
     *
     * @return $this
     */
    private function getListing(int $id = null)
    {
        $this->listing = Product::query()->where('id', $id)->first();

        return $this;
    }

}
