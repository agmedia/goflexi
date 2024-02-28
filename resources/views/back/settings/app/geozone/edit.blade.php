@extends('back.layouts.admin')

@push('css_before')
@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('back/app.geozone.main_title') }}</h1>

                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('geozones') }}">{{ __('back/app.geozone.title') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('back/app.geozone.main_title') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content content-full content-boxed">
        @include('back.layouts.partials.session')

        <form action="{{ isset($geo_zone) ? route('geozones.update', ['geozone' => $geo_zone->id]) : route('geozones.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($geo_zone))
                {{ method_field('PATCH') }}
            @endif
            <div class="block">
                <div class="block-header block-header-default">
                    <a class="btn btn-light" href="{{ back()->getTargetUrl() }}">
                        <i class="fa fa-arrow-left mr-1"></i> {{ __('back/app.geozone.back') }}
                    </a>
                    <div class="block-options">
                        <div class="custom-control custom-switch custom-control-success">
                            <input type="checkbox" class="custom-control-input" id="geozone-switch" name="status"{{ (isset($geo_zone->status) and $geo_zone->status) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="geozone-switch">Status</label>
                        </div>
                    </div>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center push">
                        <div class="col-md-12 position-relative">
                            @include('back.layouts.translations.input', [
                                                'title' => 'Naslov',
                                                'tab_title' => 'input-title',
                                                'input_name' => 'title',
                                                'value' => isset($geo_zone->title) ? $geo_zone->title : old('description')
                                                ])
                        </div>
                        <div class="col-md-12 position-relative">
                            @include('back.layouts.translations.textarea', [
                                                'title' => __('back/app.geozone.description') . ' <span class="small text-gray">' . __('back/app.geozone.description_if_needed') . '</span>',
                                                'tab_title' => 'geo-description',
                                                'input_name' => 'description',
                                                'rows' => 4,
                                                'max_length' => 0,
                                                'simple' => 1,
                                                'value' => isset($geo_zone->description) ? $geo_zone->description : old('description')
                                                ])
                        </div>
                        <div class="col-md-12 position-relative">
                            @livewire('back.settings.states-addition', ['states' => isset($geo_zone) ? $geo_zone->state : []])
                        </div>
                        <input type="hidden" name="id" value="{{ isset($geo_zone) ? $geo_zone->id : 0 }}">
                    </div>
                </div>
                <div class="block-content bg-body-light">
                    <div class="row justify-content-center push">
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-hero-success">
                                <i class="fas fa-save mr-1"></i> {{ __('back/layout.btn.save') }}
                            </button>
                            @if (isset($geo_zone))
                                <a href="{{ route('geozones.destroy', ['geozone' => $geo_zone->id]) }}" type="submit" class="btn btn-hero-danger my-2 js-tooltip-enabled float-right" data-toggle="tooltip" title="" data-original-title="{{ __('back/layout.btn.delete') }}" onclick="event.preventDefault(); document.getElementById('delete-geozone-form{{ $geo_zone->id }}').submit();">
                                    <i class="fa fa-trash-alt"></i> {{ __('back/layout.btn.delete') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @if (isset($geo_zone))
            <form id="delete-geozone-form{{ $geo_zone->id }}" action="{{ route('geozones.destroy', ['geozone' => $geo_zone->id]) }}" method="POST" style="display: none;">
                @csrf
                {{ method_field('DELETE') }}
            </form>
        @endif
    </div>
@endsection

@push('js_after')
    <script>
        $(() => {
            /*$('#countries-select').select2({
                placeholder: "{{ __('back/app.geozone.select_country') }}"
            });*/
        });

        function addState() {
            let selected = $('#countries-select').val();

            console.log(selected);
        }
    </script>

@endpush
