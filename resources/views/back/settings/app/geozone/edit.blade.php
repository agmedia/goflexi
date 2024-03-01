@extends('back.layouts.admin')

@push('css_before')
@endpush

@section('content')


    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">

                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('geozones') }}">{{ __('back/app.geozone.title') }}</a></li>

                        <li class="breadcrumb-item" aria-current="page">{{ __('back/app.geozone.main_title') }}</li>
                    </ul>
                </div>

                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-4">{{ __('back/app.geozone.main_title') }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>




        @include('back.layouts.partials.session')

        <form action="{{ isset($geo_zone) ? route('geozones.update', ['geozone' => $geo_zone->id]) : route('geozones.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($geo_zone))
                {{ method_field('PATCH') }}
            @endif


                    <div class="row ">
                        <div class="col-md-12 position-relative">
                            <div class="card">

                                <div class="d-flex card-header align-items-center justify-content-between">
                                    <h5 class="mb-0">General Info</h5>

                                    <div class="form-check form-switch custom-switch-v1 mb-2">
                                        <input type="checkbox" class="form-check-input input-success" id="geozone-switch" name="status"{{ (isset($geo_zone->status) and $geo_zone->status) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="customswitchv2-3">Status</label>
                                    </div>

                                </div>
                                <div class="card-body">
                                     @include('back.layouts.translations.input', [
                                                'title' => 'Naslov',
                                                'tab_title' => 'input-title',
                                                'input_name' => 'title',
                                                'value' => isset($geo_zone->title) ? $geo_zone->title : old('description')
                                                ])

                                    @include('back.layouts.translations.textarea', [
                                      'title' => __('back/app.geozone.description') . ' <span class="small text-gray">' . __('back/app.geozone.description_if_needed') . '</span>',
                                      'tab_title' => 'geo-description',
                                      'input_name' => 'description',
                                      'rows' => 4,
                                      'max_length' => 0,
                                      'simple' => 1,
                                      'value' => isset($geo_zone->description) ? $geo_zone->description : old('description')
                                      ])


                                    @livewire('back.settings.states-addition', ['states' => isset($geo_zone) ? $geo_zone->state : []])

                                    <input type="hidden" name="id" value="{{ isset($geo_zone) ? $geo_zone->id : 0 }}">

                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary me-2"> <i class="fas fa-save mr-1"></i> {{ __('back/layout.btn.save') }}</button>
                                    @if (isset($geo_zone))
                                        <a href="{{ route('geozones.destroy', ['geozone' => $geo_zone->id]) }}" type="submit" class="btn btn-secondary" data-toggle="tooltip" title="" data-original-title="{{ __('back/layout.btn.delete') }}" onclick="event.preventDefault(); document.getElementById('delete-geozone-form{{ $geo_zone->id }}').submit();">
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
