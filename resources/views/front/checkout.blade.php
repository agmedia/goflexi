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



    <!-- Content
    ============================================= -->
    <section id="content">
        <div class="content-wrap pt-3 pt-md-6">
            <form action="{{ route('pay-reservation') }}" method="post">
                @csrf

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
                            {{ $checkout->listing->toJson() }}

                            <input type="hidden" name="listing" value="{{ $checkout->listing->id }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h4 class="text-secondary my-4 mt-4">Selected Options</h4>
                            @foreach ($checkout->options as $option)
                                {{ $option->toJson() }}

                                <input type="hidden" name="option[{{ $option->id }}]" value="{{ $option->id }}">
                            @endforeach
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h4 class="text-secondary my-4 mt-4">{{ __('front/checkout.personal_info') }}</h4>
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" id="name" name="firstname" class="form-control bg-gray mb-3" placeholder="{{ __('front/checkout.name') }}" value="{{ $customer['firstname'] }}" required>
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" id="lastname" name="lastname" class="form-control bg-gray mb-3" placeholder="{{ __('front/checkout.surname') }}" value="{{ $customer['lastname'] }}" required>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <input type="text" id="phone" name="phone" class="form-control bg-gray" placeholder="{{ __('front/checkout.mobile_number') }}" value="{{ $customer['phone'] }}" required>
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" id="email" name="email" class="form-control bg-gray mb-3" placeholder="{{ __('front/checkout.email_address') }}" value="{{ $customer['email'] }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="cf-message">{{ __('front/common.message') }}:</label>
                                    <textarea class="form-control bg-gray" id="cf-message" rows="6" placeholder="" name="message"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h4 class="text-secondary my-4 mt-4">Available Payments</h4>
                            @foreach ($checkout->payments_list as $payment)
                                {{ json_encode($payment) }}

                                <div class="form-check mb-2  ">
                                    <input class="form-check-input" type="radio" value="{{ $payment->code }}" name="payment" @if(isset($checkout->payment->code) && $checkout->payment->code == $payment->code) checked @endif>
                                    <label class="form-check-label" for="courier"></label>
                                </div>

                            @endforeach

                            <h4 class="text-secondary my-4 mt-4">Default Payment</h4>
                            {{ json_encode($checkout->payment) }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-auto pe-lg-0 d-flex justify-content-between">
                            <button type="submit" class="btn bg-color text-white fw-semibold w-100 mt-0">{{ __('front/checkout.preview') }}</button>
                        </div>

                        <input type="hidden" name="additional_person" value="{{ $checkout->additional_person }}">
                        <input type="hidden" name="additional_child" value="{{ $checkout->additional_child }}">
                    </div>

                </div>
            </form>
        </div>
    </section><!-- #content end -->


@endsection

@push('js_after')
    <script>
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
