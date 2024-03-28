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
                        <th class="cart-product-price bg-light">Price</th>
                        <th class="cart-product-quantity bg-light">Seats Available</th>
                        <th class="cart-product-subtotal bg-light">Features</th>
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
                                        <small class="d-flex justify-content-between p-2 p-md-0"><span class="primary color">11:00 AM</span><span>3h : 45 min</span><span class="primary color">14:45 PM</span></small>

                                        <small class="d-flex justify-content-between p-2 p-md-0"><span class="primary">Zagreb</span><span><i class="bi-arrow-right"></i></span><span class="primary ">Split</span></small>
                                    </td>
                                    <td class="cart-product-name">
                                        <small> <span class="d-inline-block d-md-none p-1 p-md-0">Price:</span> <span class="amount p-1 p-md-0">40 €</span></small>
                                    </td>
                                    <td class="cart-product-name">
                                        <small>  <span class="d-inline-block d-md-none p-1 p-md-0">Seats Available:</span> <span class="amount p-1 p-md-0">8-8</span></small>
                                    </td>
                                    <td class="cart-product-name">
                                        <small>  <span class="d-inline-block d-md-none p-1 p-md-0">Features:</span> </small>  <span class="amount color p-1 p-md-0"><i class="fa-solid fa-wifi"></i> <i class="bi-snow"></i></span>
                                    </td>
                             </tr>
                    </tbody>
                </table>
                    <div class="card bg-light border-0 p-3">
                        <div class="card-body">
                            <div class="row col-mb-30  ">
                                <div class="col-lg-6">
                                    <p>
                                        <small>
                                            <strong>Boarding Point:</strong> Zagreb <br>
                                            <strong>Dropping Point:</strong> Split <br>
                                            <strong>Type:</strong> One-way <br>
                                            <strong>Date:</strong> Monday 8th of June 2024<br>
                                            <strong>Start time:</strong> 11:00 <br>
                                            <strong>End time:</strong> 14:45 <br>
                                            <strong>Duration:</strong> 3 hours 45 minutes <br>
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
                                                <input type="text" name="quantity_adult" value="1" class="qty">
                                                <input type="button" value="+" class="plus">
                                            </div>
                                        </td>
                                        <td class="cart-product-name bg-light">
                                            <small>   <span class="amount">40 €</span> </small>
                                        </td>
                                    </tr>
                                    <tr class="cart_item  bg-light">
                                        <td class="bg-light">
                                            <small><span>Child</span> </small>
                                        </td>
                                        <td class="cart-product-quantity bg-light">
                                            <div class="quantity">
                                                <input type="button" value="-" class="minus">
                                                <input type="text" name="quantity_child" value="1" class="qty">
                                                <input type="button" value="+" class="plus">
                                            </div>
                                        </td>
                                        <td class="cart-product-name bg-light">
                                            <small>  <span class="amount">40 €</span> </small>
                                        </td>
                                    </tr>
                                    <tr class="cart_item">
                                        <td colspan="2" class="cart-product-name bg-light">
                                            <strong>SubTotal</strong>
                                        </td>
                                        <td  class="cart-product-name bg-light">
                                             <span class="amount color lead"><strong> 80 € </strong></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                                    <div class="col-lg-auto pe-lg-0 d-flex justify-content-between">
                                        <a href="shop.html" class="btn bg-color text-white fw-semibold w-100 mt-0  ">Proceed to Checkout</a>
                                    </div>

                                 </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </section><!-- #content end -->


@endsection

@push('js_after')

@endpush
