<?php

namespace App\Models\Back\Catalog;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductTranslation extends Model
{

    /**
     * @var string
     */
    protected $table = 'product_translations';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * @param Request $request
     * @param Page    $page
     *
     * @return bool
     */
    public static function saveTranslations(Request $request, Product $product): bool
    {
        self::query()->where('product_id', $product->id)->delete();

        foreach (ag_lang() as $lang) {
            $slug = Str::slug($request['title'][$lang->code]);
            $url  = '/' . $slug;

            $id = self::query()->insertGetId([
                'product_id'       => $product->id,
                'lang'             => $lang->code,
                'title'            => $request['title'][$lang->code],
                'description'      => $request['description'][$lang->code],
                'meta_title'       => $request['title'][$lang->code],
                'meta_description' => $request['description'][$lang->code],
                'slug'             => $slug,
                'url'              => $url,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now()
            ]);

            if ( ! $id) {
                return false;
            }
        }

        return true;
    }
}