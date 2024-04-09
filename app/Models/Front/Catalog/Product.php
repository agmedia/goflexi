<?php

namespace App\Models\Front\Catalog;

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

        return $this->hasOne(ProductTranslation::class, 'product_id')->where('lang', $this->locale);
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



}