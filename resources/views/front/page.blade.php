@extends('front.layouts.app')

@section ( 'title', 'Goflexi' )

@push('css_after')
    <style>
     .desc ul{margin-left:25px}
    </style>
@endpush




@section('content')

    <div class=" bg-white pt-4 mt-4 pb-3">
        <div class="container mt-5 d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>{{ __('front/common.home') }}</a></li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ $page->translation->title }}</li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                <h1 class="h3 text-dark">{{ $page->translation->title }}</h1>
            </div>
        </div>
    </div>
    <div class="full-row bg-white pt-3 pb-5">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 desc">



                                    {!! $page->translation->description !!}



                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
