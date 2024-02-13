<!DOCTYPE html>
<html dir="ltr" lang="{{ config('app.locale') }}">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="author" content="AG media">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <base href="{{ config('app.url') }}">
    <!-- Font Imports -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/image/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('media/image/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('media/image/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('media/image/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('media/image/safari-pinned-tab.svg') }}" color="#ff006d">
    <link rel="shortcut icon" href="{{ asset('media/image/favicon.ico') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-config" content="{{ asset('media/image/browserconfig.xml') }}">
    <meta name="theme-color" content="#ffffff">

    @stack('meta_tags')
    <!-- Core Style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Font Icons -->
    <link rel="stylesheet" href="{{ asset('css/font-icons.css') }}">
    <!-- Plugins/Components CSS -->
    <link rel="stylesheet" href="{{ asset('css/components/daterangepicker.css') }}"><!-- DatePicker CSS -->

    @stack('css_after')

    <style>
        [v-cloak] { display:none !important; }
    </style>
</head>

<!-- Body-->
<body class="stretched">
    <div id="wrapper">

        @include('front.layouts.partials.header')

        @yield('content')

        @include('front.layouts.partials.footer')

        <div id="gotoTop" class="uil uil-angle-up bg-primary"></div>
    </div>

    <!-- Javascript Files -->
    <script src="{{ asset('js/plugins.min.js') }}"></script>
    <script src="{{ asset('js/functions.bundle.js') }}"></script>
    <script src="{{ asset('js/components/daterangepicker.js') }}"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery('#search-input').on('keyup', (e) => {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    jQuery('search-form').submit();
                }
            })

            jQuery('.cleaning-date').daterangepicker({
                "buttonClasses": "button button-rounded button-mini text-transform-none ls-0 fw-semibold",
                "applyClass": "button-color m-0 ms-1",
                "cancelClass": "bg-black m-0 text-light",
                singleDatePicker: true,
                startDate: moment().startOf('hour'),
                minDate: moment().startOf('date'),
                timePicker: false,
                timePickerSeconds: false,
                locale: {
                    format: 'DD/MM/YYYY',
                    applyLabel: 'Potvrdi',
                    cancelLabel: 'Odustani',
                    daysOfWeek: [
                        "Ne",
                        "Po",
                        "Ut",
                        "Sr",
                        "Če",
                        "Pe",
                        "Su"
                    ],
                    monthNames: [
                        "Siječanj",
                        "Veljača",
                        "Ožujak",
                        "Travanj",
                        "Svibanj",
                        "Lipanj",
                        "Srpanj",
                        "Kolovoz",
                        "Rujan",
                        "Listopad",
                        "Studeni",
                        "Prosinac"
                    ],


                },
                isInvalidDate: function(date) {
                    return (date.day() == 0 || date.day() == 1 || date.day() == 3 || date.day() == 5 );
                },
                timePickerIncrement: 10
            });

            jQuery('.cleaning-date').val('Odaberite datum polaska');

            jQuery('.form-cleaning').on( 'formSubmitSuccess', function(){
                jQuery('.cleaning-date').val('Odaberite datum polaska');
            });
        });
    </script>

@stack('js_after')

</body>
</html>
