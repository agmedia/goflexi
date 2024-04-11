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
     * @var string[]
     */
    protected $appends = [
        'from_longitude',
        'from_latitude',
        'to_longitude',
        'to_latitude'
    ];

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var Request
     */
    private $request;


    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->locale = current_locale();
    }


    /**
     * @param null  $lang
     * @param false $all
     *
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\HasOne|object|null
     */
    public function translation($lang = null, bool $all = false)
    {
        if ($lang) {
            return $this->hasOne(ProductTranslation::class, 'product_id')->where('lang', $lang)->first();
        }

        if ($all) {
            return $this->hasMany(ProductTranslation::class, 'product_id');
        }

        return $this->hasOne(ProductTranslation::class, 'product_id')->where('lang', $this->locale)->first();
    }


    public function translations()
    {
        return $this->hasMany(ProductTranslation::class, 'product_id');
    }

    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    public function getFromLongitudeAttribute($value)
    {
        return explode('-', $this->from_coordinates)[0];
    }
    public function getFromLatitudeAttribute($value)
    {
        return explode('-', $this->from_coordinates)[1];
    }
    public function getToLongitudeAttribute($value)
    {
        return explode('-', $this->to_coordinates)[0];
    }
    public function getToLatitudeAttribute($value)
    {
        return explode('-', $this->to_coordinates)[1];
    }

    /*******************************************************************************
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    *******************************************************************************/

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate([
            'title.*' => 'required',
            'from_city' => 'required',
            'from_longitude' => 'required',
            'from_latitude' => 'required',
            'to_city' => 'required',
            'to_longitude' => 'required',
            'to_latitude' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);

        $this->setRequest($request);

        return $this;
    }


    /**
     * @return Product|null
     */
    public function store(): Product|null
    {
        if ( ! $this->request) return null;

        $id = $this->insertGetId($this->getModelArray());

        if ($id) {
            $product = $this->find($id);

            ProductTranslation::saveTranslations($this->request, $product);

            return $product;
        }

        return null;
    }


    /**
     * @return Product|$this|null
     */
    public function edit(): Product|null
    {
        if ( ! $this->request) return null;

        $updated = $this->update($this->getModelArray(false));

        if ($updated) {
            ProductTranslation::saveTranslations($this->request, $this);

            return $this;
        }

        return null;
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
        $start = now();
        $end = now();

        if ($this->request->start_date) {
            $start = Carbon::make($this->request->start_date . ' ' . ($this->request->start_time ?: '12:00:00'));
        }
        if ($this->request->start_time) {
            $end = Carbon::make($this->request->end_date . ' ' . ($this->request->end_time ?: '12:00:00'));
        }

        $response = [
            'hash'             => Str::random(),
            'from_city'        => $this->request->from_city,
            'from_coordinates' => $from,
            'to_city'          => $this->request->to_city,
            'to_coordinates'   => $to,
            'start_time'       => $start,
            'end_time'         => $end,
            'price'            => $this->request->price ?: 0,
            'price_child'      => $this->request->price_child,
            'quantity'         => $this->request->quantity,
            'reserved'         => $this->reserved ?? 0,
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
     *
     * @return void
     */
    private function setRequest($request): void
    {
        $this->request = $request;
    }

}