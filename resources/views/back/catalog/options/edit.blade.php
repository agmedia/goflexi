@extends('back.layouts.admin')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endpush

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-4">{{ __('back/options.title_edit') }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ isset($option) ? route('options.update', ['option' => $option]) : route('options.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($option))
            {{ method_field('PATCH') }}
        @endif
        <div class="row">
            @include('back.layouts.partials.session')
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">Generel Info</h5>
                    <div class="card-body">
                        <div class="position-relative">
                            <ul class="nav nav-pills position-absolute langimg me-0 mb-2" id="pills-tab" role="tablist">
                                @foreach(ag_lang() as $lang)
                                    <li class="nav-item">
                                        <a class="btn btn-icon btn-sm btn-link-primary ms-2 @if ($lang->code == current_locale()) active @endif" id="pills-{{ $lang->code }}-tab" data-bs-toggle="pill" href="#pills-{{ $lang->code }}" role="tab" aria-controls="pills-{{ $lang->code }}" aria-selected="true">
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
                                                <input type="text" class="form-control" id="title-{{ $lang->code }}" name="title[{{ $lang->code }}]" placeholder="{{ $lang->code }}" value="{{ isset($option) ? $option->translation($lang->code)->title : old('title.*') }}" />
                                            </div>
                                            <div class="col-12 mt-5">
                                                <label for="short-description-{{ $lang->code }}">Short Description</label>
                                                <textarea id="short-description-{{ $lang->code }}" class="form-control" rows="4" name="description[{{ $lang->code }}]" placeholder="{{ $lang->code }}">{{ isset($option) ? $option->translation($lang->code)->description : old('description.*') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group row mt-5">
                            <div class="col-md-4">
                                <label for="page-group-select">Option Reference</label>
                                <select class="form-control" id="reference-select" name="reference">
                                    {{--<option value="other" {{ (isset($option) and 'other' == $option->reference) ? 'selected="selected"' : '' }}>Other</option>--}}
                                    @foreach (config('settings.option_references') as $item)
                                        <option value="{{ $item['reference'] }}" {{ (isset($option) and $item['reference'] == $option->reference) ? 'selected="selected"' : '' }}>{{ $item['title'][current_locale()] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="group-select">Extra Group <span class="text-danger">*</span></label>
                                <select class="form-control" id="group-select" name="group">
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}" {{ (isset($option) and $group->id == $option->group) ? 'selected="selected"' : '' }}>{{ $group->title }}</option>
                                    @endforeach
                                    <option value="all" {{ (isset($option) and 'all' == $option->group) ? 'selected="selected"' : '' }}>All Listings</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="group-select">Price Per</label>
                                <select class="form-control" id="price-per-select" name="price_per">
                                    <option value="onetime" {{ (isset($option) and 'onetime' == $option->price_per) ? 'selected="selected"' : '' }}>One Time Payment</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mt-5">
                            <div class="col-md-6">
                                <label for="price-input">{{ __('back/options.title_price') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="price-input" name="price" value="{{ isset($option) ? $option->price : old('price') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="discount-append-badge">EUR</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 mt-4 mb-3 ">
                                <div class="form-check form-switch custom-switch-v1">
                                    <input type="checkbox" class="form-check-input input-success" id="status-swich" name="status" @if (isset($option) and $option->status) checked @endif>
                                    <label class="form-check-label" for="status-swich"> Status</label>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4 mb-2 ">
                                <div class="form-check form-switch custom-switch-v1">
                                    <input type="checkbox" class="form-check-input input-success" id="featured-swich" name="featured" @if (isset($option) and $option->featured) checked @endif>
                                    <label class="form-check-label" for="featured-swich"> Featured</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
{{--            <div class="col-md-5" id="action-list-view">--}}
{{--                @if (isset($option))--}}
{{--                    @livewire('back.marketing.action-group-list', ['group' => $option->group, 'list' => json_decode($option->links)])--}}
{{--                @else--}}
{{--                    @livewire('back.marketing.action-group-list', ['group' => 'apartment'])--}}
{{--                @endif--}}
{{--            </div>--}}
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-success my-2">
                            {{ __('Save') }} <i class="ti ti-check ml-1"></i>
                        </button>
                        @if (isset($option))
                            <a href="{{ route('options.destroy', ['option' => $option]) }}" type="submit" class="btn btn-hero-danger my-2 js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="{{ __('back/action.delete') }}" onclick="event.preventDefault(); document.getElementById('delete-action-form{{ $option->id }}').submit();">
                                <i class="fa fa-trash-alt"></i> {{ __('back/action.delete') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>

    @if (isset($option))
        <form id="delete-action-form{{ $option->id }}" action="{{ route('options.destroy', ['option' => $option]) }}" method="POST" style="display: none;">
            @csrf
            {{ method_field('DELETE') }}
        </form>
    @endif

@endsection

@push('js_after')
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>

        /**
         *
         * @param reference
         * @param target
         */
        function showAutoInsert(reference, target) {
            if (reference == 'person') {
                target.hide();
            } else {
                target.show();
            }
        }

        $(() => {

            showAutoInsert($('#reference-select').val(), $('#show-insert-switch'));
            /**
             *
             */
            $('#price-per-select').select2({
                minimumResultsForSearch: Infinity
            });

            $('#group-select').select2({
                minimumResultsForSearch: Infinity
            });
            $('#group-select').on('change', function (e) {
                Livewire.emit('groupUpdated', e.currentTarget.value);
            });

            $('#reference-select').select2({
                minimumResultsForSearch: Infinity
            });

            $('#reference-select').on('change', e => {
                showAutoInsert(e.currentTarget.value, $('#show-insert-switch'));
            })


            Livewire.on('list_full', () => {
                $('#group-select').attr("disabled", true);
            });
            Livewire.on('list_empty', () => {
                $('#group-select').attr("disabled", false);
            });

            @if (isset($option) && $option->group != 'all')
                $('#group-select').attr("disabled", true);
            @endif
        })
    </script>

@endpush
