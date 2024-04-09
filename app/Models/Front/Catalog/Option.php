<?php

namespace App\Models\Front\Catalog;

use App\Models\Back\Catalog\Option\Category;
use App\Models\Back\Catalog\Option\OptionProduct;
use App\Models\Back\Catalog\Option\OptionTranslation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Option extends Model
{

    /**
     * @var string
     */
    protected $table = 'options';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var string[]
     */
    protected $appends = ['title', 'description'];

    /**
     * @var string
     */
    protected $locale = 'en';


    /**
     * Gallery constructor.
     *
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
            return $this->hasOne(OptionTranslation::class, 'option_id')->where('lang', $lang)->first();
        }

        if ($all) {
            return $this->hasMany(OptionTranslation::class, 'option_id');
        }

        return $this->hasOne(OptionTranslation::class, 'option_id')->where('lang', $this->locale)->first();
    }


    /**
     * @return string
     */
    public function getTitleAttribute()
    {
        return $this->translation()->title;
    }


    /**
     * @return string
     */
    public function getDescriptionAttribute()
    {
        return $this->translation()->description;
    }
}
