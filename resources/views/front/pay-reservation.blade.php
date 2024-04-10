@extends('front.layouts.app')

@push('css_after')

@endpush

@push('meta_tags')
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="GOFLEXI - Brza i ugodna piutovanje putničkim vozilima"/>
    <meta property="og:image" content="https://goflexi.agmedia.rocks/image/Naslovna.jpg"/>
    <meta property="og:site_name" content="GOFLEXI - Brza i ugodna piutovanje putničkim vozilima"/>
    <meta property="og:url" content="https://www.goflexi.eu/"/>
    <meta property="og:description" content="Brza i ugodna putovanja putničkim kombi vozilima.Do Zagreba, Rijeke i Splita u pola klika!"/>
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="" />
    <meta name="twitter:title" content="GOFLEXI - Brza i ugodna piutovanje putničkim vozilima" />
    <meta name="twitter:description" content="Brza i ugodna putovanja putničkim kombi vozilima.Do Zagreba, Rijeke i Splita u pola klika!" />
    <meta name="twitter:image" content="https://goflexi.agmedia.rocks/image/Naslovna.jpg" />
@endpush

@section('content')

    <!-- Content -->
    <section id="content">
        <div class="content-wrap pt-3 pt-md-6">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg mt-3">
                        <h3 class="mb-3 color">Your Info Data</h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h4 class="text-warning my-4 mt-4" id="listing-timer"></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h4 class="text-secondary my-4 mt-4">Selected Product <small>Listing</small></h4>
                        {{ $order->listing->toJson() }}

                        <input type="hidden" name="listing" value="{{ $order->listing->id }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h4 class="text-secondary my-4 mt-4">Selected Options</h4>
                        @foreach ($order->options as $option)
                            {{ $option->toJson() }}

                            <input type="hidden" name="option[{{ $option->id }}]" value="{{ $option->id }}">
                        @endforeach
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h4 class="text-secondary my-4 mt-4">Order data... Unfinished</h4>
                        {{ $order->order->toJson() }}

                        <input type="hidden" name="listing" value="{{ $order->order->id }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h4 class="text-secondary my-4 mt-4">Total amount</h4>
                        {{ $order->total }}

                        <input type="hidden" name="listing" value="{{ $order->order->id }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h4 class="text-secondary my-4 mt-4">Available Payments</h4>
                        @foreach ($order->payments_list as $payment)
                            {{ json_encode($payment) }}

                            <div class="form-check mb-2  ">
                                <input class="form-check-input" type="radio" value="{{ $payment->code }}" name="payment" @if(isset($order->payment->code) && $order->payment->code == $payment->code) checked @endif>
                                <label class="form-check-label" for="courier"></label>
                            </div>

                        @endforeach

                        <h4 class="text-secondary my-4 mt-4">Default Payment</h4>
                        {{ json_encode($order->payment) }}
                    </div>
                </div>


                <div class="row mt-4">
                    <div class="col-12">
                        {!! $payment_form !!}
                    </div>
                </div>


            </div>
        </div>
    </section>

    <div class="modal fade bs-example-modal-centered" id="time-short" tabindex="-1" role="dialog" aria-labelledby="centerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Pozor!</h4>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Dovršite rezervaciju ili će se stranica obnoviti i možda izgubite mjesto a time i Vašu rezervaciju u ovoj vožnji...</p>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js_after')
    <script>
        const time_modal = new bootstrap.Modal(document.getElementById('time-short'));

        jQuery(document).ready(function() {
            setTimeout(() => {
                time_modal.show();
            }, 20000);
        });
    </script>
@endpush
