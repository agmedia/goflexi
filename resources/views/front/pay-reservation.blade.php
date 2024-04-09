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
            <form id="form-cleaning" name="form-cleaning" action="{{ route('checkout') }}" method="post" class="row form-cleaning mb-0 mb-md-1">
                @csrf

                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg mt-3">
                            <h3 class="mb-3 color">Your Reservation</h3>
                        </div>
                    </div>
                    <table class="table bg-light cart mb-4">
                        <thead>
                        <tr class="bg-light">
                            <th class="cart-product-thumbnail bg-light">GoFlexi</th>
                            <th class="cart-product-name bg-light">Bus Name</th>
                            <th class="cart-product-schedule bg-light">Schedule</th>
                            <th class="cart-product-name bg-light">Price</th>
                            <th class="cart-product-name bg-light">Seats Available</th>
                            <th class="cart-product-name bg-light">Features</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="cart_item  border-0 mb-0">
                            <td class="  text-center text-md-start">
                                <img width="100" height="100" class="border-0" src="{{ asset('media/image/thumb_van.jpg') }}" alt="GoFlexi">
                            </td>
                            <td class="cart-product-name">
                                <small> <span>GoFlexi</span></small>
                            </td>
                            <td class="cart-product-name  " >
                                <small class="d-flex justify-content-between p-2 p-md-0"><span class="primary color">{{ $reservation->time['start_time'] }}</span><span>{{ $reservation->time['duration'] }}</span><span class="primary color">{{ $reservation->time['end_time'] }}</span></small>

                                <small class="d-flex justify-content-between p-2 p-md-0"><span class="primary">{{ $reservation->listing->from_city }}</span><span><i class="bi-arrow-right"></i></span><span class="primary ">{{ $reservation->listing->to_city }}</span></small>
                            </td>
                            <td class="cart-product-name">
                                <small> <span class="d-inline-block d-md-none p-1 p-md-0">Price:</span> <span class="amount p-1 p-md-0">{{ $reservation->listing->price }} €</span></small>
                            </td>
                            <td class="cart-product-name">
                                <small>  <span class="d-inline-block d-md-none p-1 p-md-0">Seats Available:</span> <span class="amount p-1 p-md-0">{{ $reservation->seats }}-8</span></small>
                            </td>
                            <td class="cart-product-name">
                                <small>  <span class="d-inline-block d-md-none p-1 p-md-0">Features:</span> </small>  <span class="amount color p-1 p-md-0"><i class="fa-solid fa-wifi"></i> <i class="bi-snow"></i></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="card bg-light border-0 p-3">
                        <div class="card-body">
                            <div class="row col-mb-30">
                                <div class="col-lg-6">
                                    <p>
                                        <small>
                                            <strong>Boarding Point:</strong> {{ $reservation->listing->from_city }} <br>
                                            <strong>Dropping Point:</strong> {{ $reservation->listing->to_city }} <br>
                                            <strong>Type:</strong> One-way <br>
                                            <strong>Date:</strong> {{ $reservation->time['date'] }}<br>
                                            <strong>Start time:</strong> {{ $reservation->time['start_time'] }} <br>
                                            <strong>End time:</strong> {{ $reservation->time['end_time'] }} <br>
                                            <strong>Duration:</strong> {{ $reservation->time['duration'] }} <br>
                                        </small>
                                    </p>
                                </div>
                                <div class="col-lg-6">
                                    <table class="table cart-totals ">
                                        <thead>
                                        <tr>
                                            <th class="cart-product-thumbnail bg-light">Type</th>
                                            <th class="cart-product-thumbnail text-center bg-light">Quantity</th>
                                            <th class="cart-product-thumbnail bg-light">Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="cart_item">
                                            <td class="bg-light cart-product-name ">
                                                <small>   <span>Adult</span> </small>
                                            </td>
                                            <td class="cart-product-quantity bg-light">
                                                <div class="quantity">
                                                    <input type="button" value="-" class="minus">
                                                    <input type="text" name="quantity_adult" value="1" class="qty" id="qty-adult">
                                                    <input type="button" value="+" class="plus">
                                                </div>
                                            </td>
                                            <td class="cart-product-name bg-light">
                                                <small>   <span class="amount" id="adult-price"></span> </small>
                                            </td>
                                        </tr>
                                        <tr class="cart_item  bg-light">
                                            <td class="bg-light">
                                                <small><span>Child</span> </small>
                                            </td>
                                            <td class="cart-product-quantity bg-light">
                                                <div class="quantity">
                                                    <input type="button" value="-" class="minus">
                                                    <input type="text" name="quantity_child" value="0" class="qty">
                                                    <input type="button" value="+" class="plus">
                                                </div>
                                            </td>
                                            <td class="cart-product-name bg-light">
                                                <small>  <span class="amount" id="child-price">{{ $reservation->listing->price_child }} €</span> </small>
                                            </td>
                                        </tr>
                                        <tr class="cart_item">
                                            <td colspan="2" class="cart-product-name bg-light">
                                                <strong>SubTotal</strong>
                                            </td>
                                            <td  class="cart-product-name bg-light">
                                                <span class="amount color lead" id="total-price"><strong></strong></span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div class="col-lg-auto pe-lg-0 d-flex justify-content-between">
                                        <button type="submit" class="btn bg-color text-white fw-semibold w-100 mt-0">{{ __('front/checkout.preview') }}</button>
                                    </div>

                                    <input type="hidden" name="listing" value="{{ $reservation->listing->id }}">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card bg-light border-0 p-3">
                        <div class="card-body">
                            <div class="row col-mb-30">
                                <div class="col-lg-6">
                                    OPTIONS:<br><br>
                                    @foreach ($reservation->options as $option)
                                        <label for="option">{{ $option->title }}</label>
                                        <input type="checkbox" value="{{ $option->id }}" name="option[{{ $option->id }}]">
                                        <p>{{ $option->toJson() }}</p>
                                    @endforeach
                                </div>
                                <div class="col-lg-6">

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </form>
        </div>
    </section><!-- #content end -->

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
        const price_adult = {{ jQueryreservation->listing->price }};
        const price_child = {{ jQueryreservation->listing->price_child }};
        const time_modal = new bootstrap.Modal(document.getElementById('time-short'));

        jQuery(document).ready(function() {
            document.getElementById('adult-price').innerText = price_adult.toFixed(2) + ' €';
            document.getElementById('child-price').innerText = price_child.toFixed(2) + ' €';
            document.getElementById('total-price').innerText = price_adult.toFixed(2) + ' €';

            console.log(price_adult, price_child)

            jQuery('#qty-adult').on('change', (ev) => {
                let qty = ev.currentTarget.value;

                document.getElementById('adult-price').innerText = (price_adult * qty).toFixed(2) + ' €';
                document.getElementById('total-price').innerText = ((price_adult * qty)/* + (price_child * qty)*/).toFixed(2) + ' €';
            });

            setTimeout(() => {
                time_modal.show();
            }, 10000);
        });
    </script>
@endpush
