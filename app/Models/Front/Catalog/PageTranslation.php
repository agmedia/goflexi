<?php

namespace App\Models\Back\Catalog;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PageTranslation extends Model
{

    /**
     * @var string
     */
    protected $table = 'page_translations';

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
    public static function saveTranslations(Request $request, Page $page): bool
    {
        self::query()->where('page_id', $page->id)->delete();

        foreach (ag_lang() as $lang) {
            $slug = $request['slug'][$lang->code] ? Str::slug($request['slug'][$lang->code]) : Str::slug($request['title'][$lang->code]);

            $id = self::query()->insertGetId([
                'page_id'           => $page->id,
                'lang'              => $lang->code,
                'title'             => $request['title'][$lang->code],
                'short_description' => $request['short_description'][$lang->code],
                'description'       => $request['description'][$lang->code],
                'meta_title'        => $request['meta_title'][$lang->code],
                'meta_description'  => $request['meta_description'][$lang->code],
                'slug'              => $slug,
                'keywords'          => $request['keywords'][$lang->code],
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]);

            if ( ! $id) {
                return false;
            }
        }

        return true;
    }
}