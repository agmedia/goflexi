<?php

namespace App\Helpers;

use App\Models\Front\Catalog\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class BookingHelper
{

    /**
     * @param string  $type
     * @param Request $request
     *
     * @return array|string
     */
    public static function resolveCities(string $type, Request $request): array|string
    {
        $response = [];

        if ($type == 'from') {
            $response = ['Zagreb', 'Split', 'Rijeka'];

            if ($request->has('from') && $request->input('from')) {
                return $request->input('from');
            }

            if ($request->has('to') && $request->input('to')) {
                if ($request->input('to') == 'Zagreb') {
                    $response = ['Split', 'Rijeka'];
                }
                if ($request->input('from') == 'Split' || $request->input('from') == 'Rijeka') {
                    $response = ['Zagreb'];
                }
            }
        }

        if ($type == 'to') {
            $response = ['Zagreb', 'Split', 'Rijeka'];

            if ($request->has('to') && $request->input('to')) {
                return $request->input('to');
            }

            if ($request->has('from') && $request->input('from')) {
                if ($request->input('from') == 'Zagreb') {
                    $response = ['Split', 'Rijeka'];
                }
                if ($request->input('from') == 'Split' || $request->input('from') == 'Rijeka') {
                    $response = ['Zagreb'];
                }
            }
        }

        return $response;
    }


    /**
     * @param Request $request
     *
     * @return array
     */
    public static function resolveDatesList(Request $request): array
    {
        $response = [];

        if ($request->has('from') && $request->input('from') && $request->has('to') && $request->input('to')) {
            $items = Product::query()
                          ->where('from_city', $request->input('from'))
                          ->where('to_city', $request->input('to'))
                          ->take(15)
                          ->get();

            foreach ($items as $item) {
                $date = Carbon::make($item->start_time)->format('d.m l');

                $response[] = [
                    'id' => $item->id,
                    'title' => $date,
                    'subtitle' => $item->translation->title
                ];
            }
        }

        return $response;
    }

}
