@extends('back.layouts.admin')

@push('css_before')
@endpush

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-4">Product</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <form action="{{ isset($product) ? route('product.update', ['product' => $product]) : route('product.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @if (isset($product))
            {{ method_field('PATCH') }}
        @endif
        <div class="row">
            @include('back.layouts.partials.session')
            <div class="col-md-7">
                <div class="card">
                    <h5 class="card-header">Generel Info</h5>
                    <div class="card-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            @foreach(ag_lang() as $lang)
                                <li class="nav-item">
                                    <a class="nav-link @if ($lang->code == current_locale()) active @endif" id="pills-{{ $lang->code }}-tab" data-bs-toggle="pill" href="#pills-{{ $lang->code }}" role="tab" aria-controls="pills-{{ $lang->code }}" aria-selected="true">
                                        <img src="{{ asset('assets/flags/' . $lang->code . '.png') }}" />
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            @foreach(ag_lang() as $lang)
                                <div class="tab-pane fade show @if ($lang->code == current_locale()) active @endif" id="pills-{{ $lang->code }}" role="tabpanel" aria-labelledby="pills-{{ $lang->code }}-tab">
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <label for="title-{{ $lang->code }}">Title @include('back.layouts.partials.required')</label>
                                            <input type="text" class="form-control" id="title-{{ $lang->code }}" name="title[{{ $lang->code }}]" placeholder="{{ $lang->code }}" value="{{ isset($product) ? $product->translation($lang->code)->title : old('title.*') }}" />
                                        </div>
                                        <div class="col-12 mt-5">
                                            <label for="description-{{ $lang->code }}">Description</label>
                                            <textarea id="description-{{ $lang->code }}" class="form-control" rows="4" data-always-show="true" name="description[{{ $lang->code }}]" placeholder="{{ $lang->code }}" data-placement="top">{{ isset($product) ? $product->translation($lang->code)->description : old('description.*') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-check form-switch custom-switch-v1 mt-5 mb-4">
                            <input type="checkbox" class="form-check-input input-success" id="status-swich" name="status" @if (isset($product) and $product->status) checked @endif>
                            <label class="form-check-label" for="status-swich"> Status</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card">
                    <h5 class="card-header">From - To data</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="from-city">From City</label>
                                <input type="text" class="form-control" id="from-city" name="from_city" value="{{ isset($product) ? $product->from_city : old('from_city') }}" />
                            </div>
                            <div class="col-6 mt-3">
                                <label for="from-longitude">From Longitude</label>
                                <input type="text" class="form-control" id="from-longitude" name="from_longitude" value="{{ isset($product) ? $product->from_longitude : old('from_longitude') }}" />
                            </div>
                            <div class="col-6 mt-3">
                                <label for="from-latitude">Latitude</label>
                                <input type="text" class="form-control" id="from-latitude" name="from_latitude" value="{{ isset($product) ? $product->from_latitude : old('from_latitude') }}" />
                            </div>
                        </div>
                        <div class="form-group row mt-5">
                            <div class="col-12">
                                <label for="to-city">To City</label>
                                <input type="text" class="form-control" id="to-city" name="to_city" value="{{ isset($product) ? $product->to_city : old('to_city') }}" />
                            </div>
                            <div class="col-6 mt-3">
                                <label for="to-longitude">To Longitude</label>
                                <input type="text" class="form-control" id="to-longitude" name="to_longitude" value="{{ isset($product) ? $product->to_longitude : old('to_longitude') }}" />
                            </div>
                            <div class="col-6 mt-3">
                                <label for="to-latitude">Latitude</label>
                                <input type="text" class="form-control" id="to-latitude" name="to_latitude" value="{{ isset($product) ? $product->to_latitude : old('to_latitude') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <h5 class="card-header">Datum i Vrijeme polaska/dolaska</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-6 mb-3">
                                <label for="start-date">Datum polaska</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" placeholder="Datum polaska..." id="start-date" name="start_date" value="{{ isset($product) ? ag_date($product->start_time)->format('m/d/Y') : old('publish_date') }}">
                                    <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="start-time">Vrijeme polaska</label>
                                <div class="input-group timepicker">
                                    <input class="form-control" id="start-time" placeholder="Select time" type="text" name="start_time" value="{{ isset($product) ? ag_date($product->start_time)->format('h:i') : old('publish_date') }}">
                                    <span class="input-group-text"><i class="feather icon-clock"></i></span>
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <label for="end-date">Datum dolaska</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" placeholder="Datum dolaska..." id="end-date" name="end_date" value="{{ isset($product) ? ag_date($product->end_time)->format('m/d/Y') : old('publish_date') }}">
                                    <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <label for="end-time">Vrijeme dolaska</label>
                                <div class="input-group timepicker">
                                    <input class="form-control" id="end-time" placeholder="Select time" type="text" name="end_time" value="{{ isset($product) ? ag_date($product->end_time)->format('h:i') : old('publish_date') }}">
                                    <span class="input-group-text"><i class="feather icon-clock"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <h5 class="card-header">Cijene i Količina</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-6 mb-3">
                                <label for="price-input">Cijena Odrasli</label>
                                <input type="text" class="form-control" id="price-input" name="price" value="{{ isset($product) ? $product->price : old('price') }}"/>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="price-child-input">Cijena Djete</label>
                                <input type="text" class="form-control" id="price-child-input" name="price_child" value="{{ isset($product) ? $product->price_child : old('price_child') }}" />
                            </div>
                            <div class="col-12 mt-3">
                                <label for="quantity-input">Količina</label>
                                <input type="text" class="form-control" id="quantity-input" name="quantity" value="{{ isset($product) ? $product->quantity : old('quantity') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-success my-2">
                            {{ __('Save') }} <i class="ti ti-check ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection


@push('js_after')

    <script>
        $(() => {
            {!! ag_lang() !!}.forEach(function(item) {
                ClassicEditor
                .create(document.querySelector('#description-' + item.code))
                .then(editor => {
                    editor.rows = 4;
                })
                .catch(error => {
                    //console.error(error);
                });
            });

            let start_date = new Datepicker(document.querySelector('#start-date'), {
                buttonClass: 'btn',
                orientation: 'top right'
            });
            let start_time = document.querySelector('#start-time').flatpickr({
                enableTime: true,
                noCalendar: true
            });

            let end_date = new Datepicker(document.querySelector('#end-date'), {
                buttonClass: 'btn',
                orientation: 'top right'
            });
            let end_time = document.querySelector('#end-time').flatpickr({
                enableTime: true,
                noCalendar: true
            });

        });
    </script>

@endpush
