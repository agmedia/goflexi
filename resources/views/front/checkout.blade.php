@extends('front.layouts.app')

@push('css_after')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/css/intlTelInput.css" rel="stylesheet" />

    <style>
        .intl-tel-input {
            display: block;
        }</style>
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

                    <div class="row gutter-40">
                        <div class="col-xl-9">



                            {{--dd($checkout)

                            {{ $checkout->listing->toJson() }}--}}




                            <div class="row mb-3 ">
                                <input type="hidden" name="listing" value="{{ $checkout->listing->id }}">
                                <h3 class=" h5 color my-2 mt-4">  <i class="fa-solid text-black fa-clipboard-user"></i> {{ __('front/checkout.personal_info') }}</h3>
                                <small class="mb-4 text-muted"> <span class="color">*</span> Dovoljan je unos imena i prezimena samo osobe tko unosi podatke, bez obzira putuje li jedna, ili više osoba.</small>


                                <div class="col-lg-6 form-group mb-2">
                                    <label for="template-contactform-name">Name <small>*</small></label>
                                    <input type="text" id="name" name="firstname" class="form-control mb-2 " placeholder="{{ __('front/checkout.name') }}" value="" required>
                                </div>
                                <div class="col-lg-6 form-group mb-2">
                                    <label for="template-contactform-name">Surname <small>*</small></label>
                                    <input type="text" id="lastname" name="lastname" class="form-control mb-2 " placeholder="{{ __('front/checkout.surname') }}" value="" required>
                                </div>
                                <div class="col-lg-6 mb-3 form-group mb-2">
                                    <label for="template-contactform-name">Phone <small>*</small></label>
                                    <input type="text" id="phone" name="phone" class="form-control w-100 mb-1" placeholder="{{ __('front/checkout.mobile_number') }}" value="" required>
                                    <small id="phoneHelp" class="form-text text-muted"><span class="color mb-1"> *</span> Koristi se isključivo za obavijesti o kašnjenjima i promjenama u voznom redu.</small>
                                </div>

                                <div class="col-lg-6 form-group mb-2">
                                    <label for="template-contactform-name">Email <small>*</small></label>
                                    <input type="text" id="email" name="email" class="form-control  mb-1" placeholder="{{ __('front/checkout.email_address') }}" value="" required>
                                    <small id="emailHelp" class="form-text text-muted"><span class="color mb-1"> *</span> Vaša vozna karta i informacije o vožnji će biti dostavljeni na ovaj email.</small>

                                </div>
                                <div class="w-100"></div>
                                <div class="col-lg-12 form-group mb-2">
                                    <label class="form-label" for="cf-message">{{ __('front/common.message') }}:</label>
                                    <textarea class="form-control " id="cf-message" rows="2" cols="30" placeholder="" name="message"></textarea>
                                </div>

                                <input  type="hidden" value="{{ $checkout->payment->code }}" name="payment" >
                            </div>

                            {{--  <div class="row">
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
                              </div> --}}



                            <div class="row mb-3">
                                <h3 class=" h5 color my-2 mt-4"><i class="bi-luggage-fill text-black "></i> {{ __('Prtljaga') }}</h3>
                                <small class="mb-4 text-muted"> <span class="color">*</span> Možemo preuzeti onoliko prtljage koliko je naznačeno u rezervaciji. Obratite pažnju na maksimalne dimenzije!</small>
                                <div class="col-5">
                                    <h3 class=" fs-6 my-2 mt-0">{{ __('Uključeno po osobi') }}</h3>

                                    <ul class="list-group mb-2 mt-2">

                                        <li class="list-group-item mb-0 text-transform-none fw-normal ls-0 p-3 text-size-xs"><i class="bi-check-lg"></i> 1 Ručna prtljaga | 7 kg · 42×30×18 cm</li>
                                        <li class="list-group-item mb-0 text-transform-none fw-normal ls-0 p-3 text-size-xs "><i class="bi-check-lg"></i> 1 Predana prtljaga | 20 kg · 80×50×30 cm</li>

                                    </ul>


                                </div>
                                @if($checkout->available_options)
                                        <div class="col-md-7">
                                            <h3 class=" fs-6 my-2 mt-0">{{ __('Dodatna prtljaga') }}</h3>
                                            <div class="list-group mb-2 mt-2">
                                                @foreach ($checkout->available_options as $option)
                                                    @if($option->reference == 'other')
                                                    <label class="list-group-item mb-0 text-transform-none fw-normal ls-0 p-3 text-size-xs">
                                                        <input type="checkbox" value="{{ $option->id }}" name="option[{{ $option->id }}]"> {{ $option->title }} - {{  number_format($option->price, 2)}}€
                                                        @if($option->description)
                                                            <small id="option[{{ $option->id }}]" class="form-text text-muted">{{ $option->description}}</small>
                                                        @endif
                                                    </label>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                @endif
                            </div>

                            @if($checkout->additional_child)
                                <div class="row">
                                    <h3 class=" h5 color my-2 mt-4"><i class="uil uil-kid text-black "></i> {{ __('Odaberite dječja sjedala') }}</h3>
                                    <small class="mb-4 text-muted"> <span class="color">*</span> Dječje sjedalice su besplatne, odnosno uračunate su u cijenu vozne karte.</small>
                                    <label for="hpojas" class="col-sm-6 col-md-3">
                                        <div class="pricing-box text-center shadow-none border">
                                            <input type="radio" name="data-plans-selected" class="required mt-3" id="hpojas"  value="Dječja sjedalica sa H-pojasom">
                                            <div class="pricing-title bg-transparent">
                                                <p class="text-transform-none  text-size-xs ls-0">Dječja sjedalica sa H-pojasom</p>

                                                <img src="{{ asset('media/image/prva.svg') }}" alt="Dječja sjedalica sa H-pojasom" class="p-4" style="max-height: 200px;"/>
                                            </div>

                                            <div class="pricing-features border-0 bg-transparent">
                                                <ul>
                                                    <li class="text-transform-none text-size-xs ls-0 fw-normal"><strong>bebe - od 9 do 18 kg</strong> </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </label>

                                    <label for="sigurnosno" class="col-sm-6 col-md-3">
                                        <div class="pricing-box text-center shadow-none border">
                                            <input type="radio" name="data-plans-selected" class="required mt-3" id="sigurnosno"  value="Dječje sigurnosno sjedalo">
                                            <div class="pricing-title bg-transparent">
                                                <p class="text-transform-none text-size-xs ls-0">Dječje sigurnosno sjedalo</p>

                                                <img src="{{ asset('media/image/druga.svg') }}" alt="Dječje sigurnosno sjedalo" class="p-4" style="max-height: 200px;"/>
                                            </div>

                                            <div class="pricing-features border-0 bg-transparent">
                                                <ul>
                                                    <li class="text-transform-none text-size-xs ls-0 fw-normal"><strong>djeca - od 15 do 38 kg</strong> </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </label>

                                    <label for="booster" class="col-sm-6 col-md-3">
                                        <div class="pricing-box text-center shadow-none border">
                                            <input type="radio" name="data-plans-selected" class="required mt-3" id="booster"  value="Booster autosjedalica">
                                            <div class="pricing-title bg-transparent">
                                                <p class="text-transform-none text-size-xs ls-0">Booster autosjedalica</p>

                                                <img src="{{ asset('media/image/booster2.svg') }}" alt="Booster autosjedalica" class="p-4" style="max-height: 200px;"/>
                                            </div>

                                            <div class="pricing-features border-0 bg-transparent">
                                                <ul>
                                                    <li class="text-transform-none text-size-xs ls-0 fw-normal"><strong>djeca - od 22 do 36 kg</strong> </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </label>

                                    <label for="nista" class="col-sm-6 col-md-3">
                                        <div class="pricing-box text-center shadow-none border">
                                            <input type="radio" name="data-plans-selected" class="required mt-3" id="nista"  value="Bez sjedalice">
                                            <div class="pricing-title bg-transparent">
                                                <p class="text-transform-none text-size-xs ls-0">Bez sjedalice</p>

                                                <img src="{{ asset('media/image/nijedna.svg') }}" alt="Bez sjedalice" class="p-4" style="max-height: 200px;"/>
                                            </div>

                                            <div class="pricing-features border-0 bg-transparent">
                                                <ul>
                                                    <li class="text-transform-none ls-0  text-size-xs fw-normal"><strong>Ne treba mi dječja sjedalica</strong> </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </label>






                                </div>
                            @endif


                            <div class="row">
                                <input type="hidden" name="additional_person" value="{{ $checkout->additional_person }}">
                                <input type="hidden" name="additional_child" value="{{ $checkout->additional_child }}">
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="row">
                                <div class="col-12 col-lg mt-3 d-flex flex-row justify-content-between">
                                    <h3 class="h5 color flex-grow-1">Your Reservation</h3> <i class="bi-clock-history me-2"></i> <span class=" countdown-amount fw-bold fs-6" id="listing-timer">  </span>
                                </div>
                            </div>

                            <div class="row col-mb-30">
                                <div class="col-12">
                                    <div class="grid-inner bg-color bg-opacity-10 p-4 rounded-6">


                                        <h5 class="fs-6 font-body mb-1 fw-bold"> {{ \Carbon\Carbon::parse($checkout->listing->start_time)->format('D,d. M. ')}}</h5>

                                        <div class="card mb-3 border-0">

                                            <div class="card-body ">
                                                <p class="card-text"><i class="bi-clock me-2"></i> Start: {{ \Carbon\Carbon::parse($checkout->listing->start_time)->format('H:i')}} <i class="bi-arrow-right-short"></i> {{ $checkout->listing->from_city }}<br>
                                                    <i class="bi-clock-history me-2"></i> End:  {{ \Carbon\Carbon::parse($checkout->listing->end_time)->format('H:i')}} <i class="bi-arrow-right-short"></i> {{ $checkout->listing->to_city }}</p>
                                            </div>
                                        </div>


                                        <div class="table-responsive rounded-2">
                                            <table class="table cart cart-totals">
                                                <tbody>
                                                <tr class="cart_item">
                                                    <td class="cart-product-name">
                                                        Person x {{ $checkout->additional_person + 1 }}:
                                                    </td>

                                                    <td class="cart-product-name text-end">
                                                        <span class="amount">{{  number_format(($checkout->listing->price * ($checkout->additional_person + 1)), 2)}}€ </span>
                                                    </td>
                                                </tr>

                                                <tr class="cart_item">
                                                    <td class="cart-product-name">
                                                        Children x {{ $checkout->additional_child }}:
                                                    </td>

                                                    <td class="cart-product-name text-end">
                                                        <span class="amount">{{  number_format(($checkout->listing->price_child * $checkout->additional_child), 2)}}€ </span>
                                                    </td>
                                                </tr>

                                                <tr class="cart_item">
                                                    <td class="cart-product-name">
                                                        Total:
                                                    </td>

                                                    <td class="cart-product-name text-end">
                                                        <span class="amount color lead fw-bold"> {{  number_format($checkout->total, 2)}}€ </span>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <div class="col-lg-auto pe-lg-0 d-flex justify-content-between">
                                                <button type="submit" class="btn button text-light m-0 w-100 text-center">{{ __('front/checkout.preview') }}</button>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </section><!-- #content end -->


@endsection

@push('js_after')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.7/js/intlTelInput.js"></script>
    <script>

        jQuery(document).ready(function() {
            jQuery("input[name='phone']").intlTelInput({
                initialCountry: "auto",
                geoIpLookup: callback => {
                    fetch("https://ipapi.co/json")
                        .then(res => res.json())
                        .then(data => callback(data.country_code))
                        .catch(() => callback("us"));
                },
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
            });
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
