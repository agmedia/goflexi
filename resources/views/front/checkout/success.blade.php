@extends('front.layouts.app')

@section('content')

    @if (isset($data['google_tag_manager']))
        @section('google_data_layer')
            <script>
                window.dataLayer = window.dataLayer || [];
                dataLayer.push(<?php echo json_encode($data['google_tag_manager']); ?>);
            </script>
        @endsection
    @endif



    <div class="container pb-5 mt-5 mb-sm-4">
        <div class="pt-5 mt-5">
            <div class="card py-3 mt-sm-3">
                <div class="card-body text-center">
                    <h2 class="h4 pb-3">{{ __('front/success.success_sub_title') }}</h2>
{{--                    <p> {!!  __('front/success.success_text_line') !!} </p>--}}
                        @if (isset($order))
                            @if ($order->payment_code == 'bank')
                                <p>{{ __('front/success.success_text') }} {{ $order->id }} .</p>
                            {!!   __('front/success.success_html_text') !!}
                                <p>{{ __('front/success.payment_text') }}  {{ $order->total_text }}<br>
                                   IBAN: HR4723900011101317916<br>
                                   MODEL: 00 {{ __('front/success.reference_number') }}: {{ $order->id }}-{{date('ym')}}</p>
                                <p>{{ __('front/success.scant_text') }}</p>
                                <p class="text-center"><img src="{{ asset('media/img/qr/'.$order->id) }}.png" style="max-width:320px"></p>
                            @endif
                        @endif
                    <a class="tn bg-color text-white fw-semibold mt-3 me-3" href="{{ route('index') }}">{{ __('front/success.success_btn') }}</a>
                </div>
            </div>
        </div>
    </div>



@endsection
