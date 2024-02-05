<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->
<head>
    <title>Login | Able Pro Dashboard Template</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Able Pro is trending dashboard template made using Bootstrap 5 design framework. Able Pro is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies.">
    <meta name="keywords" content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard">
    <meta name="author" content="Phoenixcoded">

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('assets/back/images/favicon.svg') }}" type="image/x-icon"> <!-- [Font] Family -->
    <link rel="stylesheet" href="{{ asset('assets/back/fonts/inter/inter.css') }}" id="main-font-link" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/back/fonts/tabler-icons.min.css') }}" >
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/back/fonts/feather.css') }}" >
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/back/fonts/fontawesome.css') }}" >
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/back/fonts/material.css') }}" >
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('assets/back/css/style.css') }}" id="main-style-link" >
    <link rel="stylesheet" href="{{ asset('assets/back/css/style-preset.css') }}" >

    <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};</script>
</head>
<!-- [Head] end -->

<!-- [Body] Start -->
<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="light">
<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<!-- [ Pre-loader ] End -->

<div class="auth-main">
    <div class="auth-wrapper v2">
        <div class="auth-sidecontent">
            <img src="{{ asset('assets/back/images/authentication/img-auth-sideimg.jpg') }}" alt="images"
                 class="img-fluid img-auth-side">
        </div>
        <div class="auth-form">
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card my-5">
                <div class="card-body">
                    <div class="text-center">
                        <a href="{{ route('index') }}"><img src="{{ asset('assets/back/images/logo-dark.svg') }}" alt="img"></a>
                    </div>

                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->
<!-- Required Js -->
<script src="{{ asset('assets/back/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/back/js/plugins/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/back/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/back/js/fonts/custom-font.js') }}"></script>
<script src="{{ asset('assets/back/js/pcoded.js') }}"></script>
<script src="{{ asset('assets/back/js/plugins/feather.min.js') }}"></script>

</body>
<!-- [Body] end -->
</html>