<?php

namespace App\Models\Back\Catalog;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{

    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    private $request;


    /**
     * @param Request $request
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $this->setRequest($request);

        return $this;
    }


    /**
     * @return mixed
     */
    public function store()
    {
        $id = $this->insertGetId($this->getModelArray());

        return $this->find($id);
    }


    /**
     * @return false
     */
    public function edit()
    {
        $updated = $this->update($this->getModelArray(false));

        if ($updated) {
            return $this;
        }

        return false;
    }

    /*******************************************************************************
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    *******************************************************************************/

    /**
     * @param bool $insert
     *
     * @return array
     */
    private function getModelArray(bool $insert = true): array
    {
        $from = $this->request->from_longitude . '-' . $this->request->from_latitude;
        $to = $this->request->to_longitude . '-' . $this->request->to_latitude;
        $start = $this->request->start_date . ' ' . $this->request->start_time;
        $end = $this->request->end_date . ' ' . $this->request->end_time;

        $response = [
            'hash'             => Str::random(),
            'from_city'        => $this->request->from_city,
            'from_coordinates' => $from,
            'to_city'          => $this->request->to_city,
            'to_coordinates'   => $to,
            'start_time'       => Carbon::make($start),
            'end_time'         => Carbon::make($end),
            'price'            => $this->request->price,
            'price_child'      => $this->request->price_child,
            'quantity'         => $this->request->quantity,
            'image'            => 'media/van.jpg',
            'tax_id'           => 2,
            'sort_order'       => 0,
            'featured'         => 1,
            'status'           => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'updated_at'       => Carbon::now()
        ];

        if ($insert) {
            $response['created_at'] = Carbon::now();
        }

        return $response;
    }


    /**
     * Set Product Model request variable.
     *
     * @param $request
     */
    private function setRequest($request)
    {
        $this->request = $request;
    }

}