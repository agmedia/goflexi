<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<!-- [Head] start -->

<head>
    <title>GoFlexi Dashboard</title>
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
    <!-- notification css -->
    <link rel="stylesheet" href="{{ asset('assets/back/css/plugins/notifier.css') }}">
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
    <link rel="stylesheet" href="{{ asset('assets/back/css/plugins/datepicker-bs5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/back/css/plugins/flatpickr.min.css') }}">
    <!-- Custom CSS-->
    @livewireStyles
   {{-- <link rel="stylesheet" href="{{ asset('assets/back/js/plugins/select2/css/select2.min.css') }}" >--}}
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};
    </script>

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="{{ $mode }}">
<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>

@include('back.layouts.partials.sidebar')

@include('back.layouts.partials.topbar')

<div class="pc-container">
    <div class="pc-content">

        @yield('content')

    </div>
</div>

@stack('modals')

@stack('js_before')
<!-- Required Js -->
<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.7/axios.min.js" integrity="sha512-NQfB/bDaB8kaSXF8E77JjhHG5PM6XVRxvHzkZiwl3ddWCEPBa23T76MuWSwAJdMGJnmQqM0VeY9kFszsrBEFrQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('assets/back/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/back/js/plugins/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/back/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/back/js/fonts/custom-font.js') }}"></script>
<script src="{{ asset('assets/back/js/pcoded.js') }}"></script>
<script src="{{ asset('assets/back/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('assets/back/js/plugins/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/back/js/plugins/notifier.js') }}"></script>
<script src="{{ asset('assets/back/js/plugins/ckeditor/classic/ckeditor.js') }}"></script>
<script src="{{ asset('assets/back/js/plugins/datepicker-full.min.js') }}"></script>
<script src="{{ asset('assets/back/js/plugins/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/back/js/plugins/choices.min.js') }}"></script>

@livewireScripts
{{--<script src="{{ asset('assets/back/js/plugins/component.js') }}"></script>--}}
{{--<script src="{{ asset('assets/back/js/plugins/select2/js/select2.full.min.js') }}"></script>--}}

<script>
    const API_PATH = window.location.origin + '/api/';
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    window.axios.defaults.baseURL = API_PATH;

    /**
     *
     * @param id
     * @param url
     */
    function deleteSettingsItem(id, url) {
        Swal.fire({
            title: 'Delete..!',
            text: "Are you sure to delete the item?",
            icon: 'warning',
            showConfirmButton: false,
            showDenyButton: true,
            showCancelButton: true,
            denyButtonText: `Delete`
        }).then((result) => {
            if (result.isDenied) {
                axios.post(url, {id: id})
                .then(response => {
                    if (response.data.success) {
                        location.reload();
                    } else {
                        Swal.fire('Changes are not saved!', '', 'danger');
                    }
                });


            }
        });
    }

    /**
     *
     * @param title
     * @param message
     * @param type
     */
    function showSuccess(message = null, time = null, title = null, type = null) {
        message = message ? message : 'Action is successfully completed!';
        time = time ? time : 3000;
        title = title ? title : 'Success!';
        type = type ? type : 'success';

        notifier.show(
            title,
            message,
            type,
            '{{ asset('assets/back/images/notification/ok-48.png') }}',
            time
        );
    }

    /**
     *
     * @param title
     * @param message
     * @param type
     */
    function showError(message = null, time = null, title = null, type = null) {
        message = message ? message : 'Error completing action!';
        time = time ? time : 3000;
        title = title ? title : 'Error!';
        type = type ? type : 'danger';

        notifier.show(
            title,
            message,
            type,
            '{{ asset('assets/back/images/notification/high_priority-48.png') }}',
            time
        );
    }

    /**
     *
     * @param response
     * @param modal
     */
    function notificationResponse(response, modal = null) {
        if (modal) {
            $('#' + modal).modal('hide');
        }

        if (response.data.success) {
            showSuccess();
            setTimeout(() => { location.reload(); }, 1500);
        } else {
            showError();
        }
    }
</script>

@stack('js_after')

<script>
    layout_change('{{ $mode }}');
    layout_theme_contrast_change('false');
    change_box_container('false');
    layout_caption_change('true');
    layout_rtl_change('false');
    preset_change("preset-1");
</script>

</body>
<!-- [Body] end -->
</html>
