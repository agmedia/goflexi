<?php

namespace App\Livewire\Back\Sales;

use App\Models\Back\Catalog\Product;
use App\Models\Back\Orders\Order;
use App\Models\Back\Settings\Settings;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class OrdersList extends Component
{
    /**
     * @var array
     */
    public $list = [];

    public $drives = [];

    public $customers = [];

    public $customer = null;

    /**
     * @var string
     */
    public $search_orders = '';

    /**
     * @var Collection
     */
    public $statuses;


    /**
     * @return void
     */
    public function mount()
    {
        if ( ! empty($this->list)) {
            $this->statuses = Settings::get('order', 'statuses');
            $this->drives = $this->getDrives();
        }
    }


    public function selectDrive($key)
    {
        if (isset($this->list[$key])) {
            $this->customers = $this->getCustomers($key);
        }

        $this->dispatch('drives_selected');
    }


    public function selectOrder($order)
    {
        $this->customer = $order;
    }


    public function destroyCustomer(int $order_id)
    {
        $order = Order::query()->where('id', $order_id)->first();

        if ($order) {
            $product_id = $order->product_id;

            $order->completeDelete();

            $this->customers = $this->getCustomers($product_id);
        }
    }


    public function updatingSearchCustomers(string $value)
    {
        $this->customers = Order::query()->where(function ($query) use ($value) {
            $query->where('id', 'like', '%' . $value . '%')
                  ->orWhere('payment_fname', 'like', '%' . $value . '%')
                  ->orWhere('payment_lname', 'like', '%' . $value . '%')
                  ->orWhere('payment_email', 'like', '%' . $value . '%');
        })
                             ->where('order_status_id', config('settings.order.status.paid'))
                             ->get();
    }


    public function updatingSearchDrives(string $value)
    {
        $this->drives = Product::query()->where(function ($query) use ($value) {
            $query->whereHas('translations', function ($subquery) use ($value) {
                $subquery->where('title', 'like', '%' . $value . '%');
            });
        })->get();
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.back.sales.orders-list', [
            'list' => $this->list,
            'statuses' => $this->statuses,
            'drives' => $this->drives,
            'customers' => $this->customers,
            'customer' => $this->customer
        ]);
    }


    private function getCustomers(int $product_id)
    {
        return Order::query()->where('product_id', $product_id)
                             ->where('order_status_id', config('settings.order.status.paid'))
                             ->get();
    }


    private function getDrives()
    {
        return Product::query()->where('quantity', '<', 8)->where('start_time', '>', now())->get();
    }

}
