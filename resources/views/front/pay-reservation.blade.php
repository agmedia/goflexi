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

                <div class="row gutter-40">
                    <div class="col-xl-12">
                        <input type="hidden" name="listing" value="{{ $order->listing->id }}">
                        <input type="hidden" name="listing" value="{{ $order->order->id }}">
                        <div class="row d-none">
                            <div class="col-12">
                                <h4 class="text-secondary my-4 mt-4">Available Payments</h4>
                                @foreach ($order->payments_list as $payment)
                                    {{-- json_encode($payment) --}}

                                    <div class="form-check mb-2  ">
                                        <input class="form-check-input" type="radio" value="{{ $payment->code }}" name="payment" @if(isset($order->payment->code) && $order->payment->code == $payment->code) checked @endif>
                                        <label class="form-check-label" for="courier"></label>
                                    </div>

                                @endforeach

                                <h4 class="text-secondary my-4 mt-4">Default Payment</h4>
                                {{ json_encode($order->payment) }}
                            </div>
                        </div>
                        <input class="form-check-input" type="hidden" value="{{ $order->payment->code }}" name="payment">
                        <div class="row">
                            <div class="col-12 col-lg mt-3 d-flex flex-row justify-content-between">
                                <h3 class="h5 color flex-grow-1">Your Reservation</h3> <i class="bi-clock-history me-2"></i> <span class=" countdown-amount fw-bold fs-6" id="listing-timer">  </span>
                            </div>
                        </div>
                        <div class="row col-mb-30">
                            <div class="col-12">
                                <div class="grid-inner bg-color bg-opacity-10 p-4 rounded-6">
                                    <h5 class="fs-6 font-body mb-1 fw-bold"> {{ __('front/checkout.personal_info') }}</h5>
                                    <div class="card mb-3 border-0">
                                        <div class="card-body ">
                                            <p class="card-text mb-2">
                                                <i class="fa-solid fa-user me-2"></i> Your Name: {{ $order->order->payment_fname }} {{ $order->order->payment_lname }}<br>
                                                <i class="bi-phone-fill me-2"></i> Phone: {{ $order->order->payment_phone }}<br>
                                                <i class="bi-envelope-fill me-2"></i> Email: {{ $order->order->payment_email }}
                                            </p>
                                            @if($order->customer['comment'])
                                                <p class="card-text mb-2">
                                                    <i class="fa-solid fa-comment me-2"></i> Your Comment: {{$order->customer['comment']}}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <h5 class="fs-6 font-body mb-1 fw-bold"> {{ \Carbon\Carbon::parse($order->listing->start_time)->format('D,d. M. ')}}</h5>
                                    <div class="card mb-3 border-0">
                                        <div class="card-body ">
                                            <p class="card-text"><i class="bi-clock me-2"></i> Start: {{ \Carbon\Carbon::parse($order->listing->start_time)->format('H:i')}} <i class="bi-arrow-right-short"></i> {{ $order->listing->from_city }}<br>
                                                <i class="bi-clock-history me-2"></i> End:  {{ \Carbon\Carbon::parse($order->listing->end_time)->format('H:i')}} <i class="bi-arrow-right-short"></i> {{ $order->listing->to_city }}</p>
                                        </div>
                                    </div>

                                    <div class="table-responsive rounded-2">
                                        <table class="table cart cart-totals">
                                            <tbody>
                                            <tr class="cart_item">
                                                <td class="cart-product-name">
                                                    Person x {{ $order->additional_person + 1 }}:
                                                </td>
                                                <td class="cart-product-name text-end">
                                                    <span class="amount">{{  number_format(($order->listing->price * ($order->additional_person + 1)), 2)}}€ </span>
                                                </td>
                                            </tr>
                                            <tr class="cart_item">
                                                <td class="cart-product-name">
                                                    Children x {{ $order->additional_child }}:
                                                </td>
                                                <td class="cart-product-name text-end">
                                                    <span class="amount">{{  number_format(($order->listing->price_child * $order->additional_child), 2)}}€ </span>
                                                </td>
                                            </tr>
                                            @if($order->options)
                                                @foreach ($order->options as $option)
                                                    <tr class="cart_item">
                                                        {{-- $option->toJson() --}}
                                                        <td class="cart-product-name">
                                                            {{ $option->title }}:
                                                        </td>
                                                        <td class="cart-product-name text-end">
                                                            <span class="amount">{{  number_format($option->price, 2)}}€ </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr class="cart_item">
                                                <td class="cart-product-name">
                                                    Total:
                                                </td>

                                                <td class="cart-product-name text-end">
                                                    <span class="amount color lead fw-bold"> {{  number_format($order->total, 2)}}€ </span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                {!! $payment_form !!}
                            </div>
                        </div>

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

        // Set the date we're counting down to
        var countDownDate = new Date(new Date().getTime() + (10* 60000)).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

// Display the result in the element with id="demo"
            document.getElementById("listing-timer").innerHTML = minutes + "m " + seconds + "s ";

// If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("listing-timer").innerHTML = "EXPIRED";
            }
        }, 1000);

    </script>
@endpush
