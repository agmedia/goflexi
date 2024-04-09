<?php

namespace App\Helpers;


use App\Models\Back\Catalog\Product;
use App\Models\Back\Catalog\ProductTranslation;
use App\Models\Back\Settings\Settings;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductHelper
{

    /**
     * @param Carbon $day
     *
     * @return void
     */
    public static function create_ZGSP_listing(Carbon $day)
    {
        $start = Carbon::make($day)->setHour(10)->setMinute(00)->setSecond(00);
        $end = Carbon::make($day)->setHour(16)->setMinute(00)->setSecond(00);
        $backend = Carbon::make($day)->setHour(22)->setMinute(00)->setSecond(00);
        // Zagreb Split
        $product_id = Product::query()->insertGetId([
            'hash'             => Str::random(),
            'from_city'        => 'Zagreb',
            'from_coordinates' => '45.8010156-15.9769545',
            'to_city'          => 'Split',
            'to_coordinates'   => '43.5206858-16.4453669',
            'start_time'       => $start,
            'end_time'         => $end,
            'price'            => 70,
            'price_child'      => 55,
            'quantity'         => 8,
            'image'            => 'media/van.jpg',
            'tax_id'           => 2,
            'sort_order'       => 0,
            'featured'         => 1,
            'status'           => 1,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        foreach (ag_lang() as $lang) {
            $slug = Str::slug(__('back/product.title_zgsp') . '-' . $day->format('d-m-Y-h-i'));
            $url  = '/' . $slug;

            $id = ProductTranslation::query()->insertGetId([
                'product_id'       => $product_id,
                'lang'             => $lang->code,
                'title'            => __('back/product.title_zgsp'),
                'description'      => __('back/product.description_zgsp'),
                'meta_title'       => __('back/product.title_zgsp'),
                'meta_description' => __('back/product.description_zgsp'),
                'slug'             => $slug,
                'url'              => $url,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now()
            ]);
        }

        // Split Zagreb
        $product_id = Product::query()->insertGetId([
            'hash'             => Str::random(),
            'from_city'        => 'Split',
            'from_coordinates' => '43.5206858-16.4453669',
            'to_city'          => 'Zagreb',
            'to_coordinates'   => '45.8010156-15.9769545',
            'start_time'       => $end,
            'end_time'         => $backend,
            'price'            => 70,
            'price_child'      => 55,
            'quantity'         => 8,
            'reserved'         => 0,
            'image'            => 'media/van.jpg',
            'tax_id'           => 2,
            'sort_order'       => 0,
            'featured'         => 1,
            'status'           => 1,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        foreach (ag_lang() as $lang) {
            $slug = Str::slug(__('back/product.title_spzg') . '-' . $day->format('d-m-Y-h-i'));
            $url  = '/' . $slug;

            $id = ProductTranslation::query()->insertGetId([
                'product_id'       => $product_id,
                'lang'             => $lang->code,
                'title'            => __('back/product.title_spzg'),
                'description'      => __('back/product.description_spzg'),
                'meta_title'       => __('back/product.title_spzg'),
                'meta_description' => __('back/product.description_spzg'),
                'slug'             => $slug,
                'url'              => $url,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now()
            ]);
        }
    }


    /**
     * @param Carbon $day
     *
     * @return void
     */
    public static function create_ZGRI_listing(Carbon $day)
    {
        $start = Carbon::make($day)->setHour(10)->setMinute(00)->setSecond(00);
        $end = Carbon::make($day)->setHour(12)->setMinute(00)->setSecond(00);
        $backend = Carbon::make($day)->setHour(14)->setMinute(00)->setSecond(00);

        // Zagreb Split
        $product_id = Product::query()->insertGetId([
            'hash'             => Str::random(),
            'from_city'        => 'Zagreb',
            'from_coordinates' => '45.8010156-15.9769545',
            'to_city'          => 'Rijeka',
            'to_coordinates'   => '43.5206858-14.4412363',
            'start_time'       => $start,
            'end_time'         => $end,
            'price'            => 70,
            'price_child'      => 55,
            'quantity'         => 8,
            'reserved'         => 0,
            'image'            => 'media/van.jpg',
            'tax_id'           => 2,
            'sort_order'       => 0,
            'featured'         => 1,
            'status'           => 1,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        foreach (ag_lang() as $lang) {
            $slug = Str::slug(__('back/product.title_zgri') . '-' . $day->format('d-m-Y-h-i'));
            $url  = '/' . $slug;

            $id = ProductTranslation::query()->insertGetId([
                'product_id'       => $product_id,
                'lang'             => $lang->code,
                'title'            => __('back/product.title_zgri'),
                'description'      => __('back/product.description_zgri'),
                'meta_title'       => __('back/product.title_zgri'),
                'meta_description' => __('back/product.description_zgri'),
                'slug'             => $slug,
                'url'              => $url,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now()
            ]);
        }

        // Split Zagreb
        $product_id = Product::query()->insertGetId([
            'hash'             => Str::random(),
            'from_city'        => 'Rijeka',
            'from_coordinates' => '43.5206858-14.4412363',
            'to_city'          => 'Zagreb',
            'to_coordinates'   => '45.8010156-15.9769545',
            'start_time'       => $end,
            'end_time'         => $backend,
            'price'            => 70,
            'price_child'      => 55,
            'quantity'         => 8,
            'image'            => 'media/van.jpg',
            'tax_id'           => 2,
            'sort_order'       => 0,
            'featured'         => 1,
            'status'           => 1,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        foreach (ag_lang() as $lang) {
            $slug = Str::slug(__('back/product.title_rizg') . '-' . $day->format('d-m-Y-h-i'));
            $url  = '/' . $slug;

            $id = ProductTranslation::query()->insertGetId([
                'product_id'       => $product_id,
                'lang'             => $lang->code,
                'title'            => __('back/product.title_rizg'),
                'description'      => __('back/product.description_rizg'),
                'meta_title'       => __('back/product.title_rizg'),
                'meta_description' => __('back/product.description_rizg'),
                'slug'             => $slug,
                'url'              => $url,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now()
            ]);
        }
    }

}
