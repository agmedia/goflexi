<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'pagination' => [
        'front' => 40,
        'back' => 10
    ],

    'search_keyword' => 'pojam',
    'admin_input_currency' => 'EUR',
    'default_admin_id' => 1,
    'admin_email' => 'info@agmedia.hr',

    'images_domain' => '#',
    'image_size_ratio' => '1440x960',
    'thumb_size_ratio' => '800x534',
    'default_apartment_image' => 'media/default_img.jpg',

    'sorting_list' => [
        0 => [
            'title' => 'Najnovije',
            'value' => 'novi'
        ]
    ],

    'product_select_status' => ['active', 'inactive'/*, 'with_action', 'without_action'*/],
    'product_select_sort' => ['new', 'old', 'price_up', 'price_down'/*, 'az', 'za'*/],

    'calendar_colors' => ['3c90df', '2177C7', 'DF8B3C' , '3CDFDC'],

    'order' => [
        'made_text' => 'Narudžba napravljena.',
        'status' => [
            'new' => 1,
            'canceled' => 5,
            'unfinished' => 8,
            'declined' => 7,
            'paid' => 3,
            'pending' => 2
        ],
        'origin' => [
            0 => 'all',
            1 => \Illuminate\Support\Str::slug(env('APP_NAME'))
        ],
        'sort' => ['new', 'old', 'active', 'inactive'],
    ],

    'payment' => [
        'default' => 'stripe',
        'providers' => [
            'bank' => \App\Models\Front\Checkout\Payment\Bank::class,
            //'pickup' => \App\Models\Front\Checkout\Payment\Pickup::class,
            //'wspay' => \App\Models\Front\Checkout\Payment\Wspay::class,
            //'payway' => \App\Models\Front\Checkout\Payment\Payway::class,
            'stripe' => \App\Models\Front\Checkout\Payment\Stripe::class,
            //'keks' => \App\Models\Front\Checkout\Payment\Keks::class,
            //'cod' => \App\Models\Front\Checkout\Payment\Cod::class
        ]
    ],

    'option_references' => [
        1 => [
            'title' => [
                'en' => 'Additional Person',
                'hr' => 'Dodatna Osoba',
            ],
            'id' => 1,
            'reference' => 'person'
        ],
        2 => [
            'title' => [
                'en' => 'Transport',
                'hr' => 'Transport',
            ],
            'id' => 2,
            'reference' => 'transport'
        ],
        3 => [
            'title' => [
                'en' => 'Comfort & Luxury',
                'hr' => 'Konfort i Luksuz',
            ],
            'id' => 3,
            'reference' => 'comfort'
        ],
        4 => [
            'title' => [
                'en' => 'Other',
                'hr' => 'Ostalo',
            ],
            'id' => 4,
            'reference' => 'other'
        ]
    ],

    'days_of_week' => ['Ponedeljak', 'Utorak', 'Srijeda', 'Četvrtak', 'Petak', 'Subota', 'Neddelja'],

    // listing options ID mapping
    'options' => [
        'child_seat' => 1,
        'baggage' => 2
    ]

];
