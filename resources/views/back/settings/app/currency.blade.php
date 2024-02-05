@extends('back.layouts.admin')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Currency list</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row">
        @include('back.layouts.partials.session')
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-body">
                    <div class="text-end p-4">
                        <a href="javascript: void(0);" onclick="event.preventDefault(); openMainModal();" class="btn btn-secondary">
                            <i class="ti ti-plus f-18"></i> Select Default Currency
                        </a>
                        <a href="javascript: void(0);" onclick="event.preventDefault(); openModal();" class="btn btn-primary">
                            <i class="ti ti-plus f-18"></i> Add New Currency
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="pc-dt-simple">
                            <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th>Name</th>
                                <th class="text-center">Code</th>
                                <th class="text-center">Status</th>
                                <th class="text-end" style="width: 10%;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td><span class="h6 m-r-15">{{ isset($item->title->{current_locale()}) ? $item->title->{current_locale()} : $item->title }}</span>
                                        @if (isset($item->main) && $item->main)
                                            <i data-feather="check-circle" class="text-success">
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $item->code }}</td>
                                    <td class="text-center">@include('back.layouts.partials.status', ['status' => $item->status])</td>
                                    <td class="text-end">
                                        <ul class="list-inline me-auto mb-0">
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                                <a href="javascript:void(0)" class="avtar avtar-xs btn-link-success btn-pc-default" onclick="event.preventDefault(); openModal({{ json_encode($item) }});">
                                                    <i class="ti ti-edit-circle f-18"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Delete">
                                                <a href="javascript:void(0)" class="avtar avtar-xs btn-link-danger btn-pc-default" onclick="event.preventDefault(); deleteCurrency({{ $item->id }});">
                                                    <i class="ti ti-trash f-18"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="5">Nema upisanih valuta...</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>

@endsection

@push('modals')
    <div class="modal fade" id="currency-modal" tabindex="-1" role="dialog" aria-labelledby="currency-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">Valuta Edit</h3>
                        <div class="block-options">
                            <a class="text-muted font-size-h3" href="#" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-10">
                                <div class="form-group mb-4">
                                    <label for="status-title" class="w-100">{{ __('back/app.currency.input_title') }}
                                        <ul class="nav nav-pills float-right">
                                            @foreach(ag_lang() as $lang)
                                                <li @if ($lang->code == current_locale()) class="active" @endif ">
                                                <a class="btn btn-sm btn-outline-secondary ml-2 @if ($lang->code == current_locale()) active @endif " data-toggle="pill" href="#title-{{ $lang->code }}">
                                                    <img src="{{ asset('media/flags/' . $lang->code . '.png') }}" />
                                                </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </label>
                                    <div class="tab-content">
                                        @foreach(ag_lang() as $lang)
                                            <div id="title-{{ $lang->code }}" class="tab-pane @if ($lang->code == current_locale()) active @endif">
                                                <input type="text" class="form-control" id="currency-title-{{ $lang->code }}" name="title[{{ $lang->code }}]" placeholder="{{ $lang->code }}"  >
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="currency-code">{{ __('back/app.currency.code') }}</label>
                                            <input type="text" class="form-control" id="currency-code" name="code">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="currency-value">{{ __('back/app.currency.value') }}</label>
                                            <input type="text" class="form-control" id="currency-value" name="value">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="currency-symbol-left">{{ __('back/app.currency.symbol_left') }}</label>
                                            <input type="text" class="form-control" id="currency-symbol-left" name="symbol_left">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="currency-symbol-right">{{ __('back/app.currency.symbol_right') }}</label>
                                            <input type="text" class="form-control" id="currency-symbol-right" name="symbol_right">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="currency-decimal-places">{{ __('back/app.currency.decimal') }}</label>
                                            <input type="text" class="form-control" id="currency-decimal-places" name="decimal_places">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sort-order-value">{{ __('back/app.currency.sort_order') }}</label>
                                            <input type="text" class="form-control" id="sort-order-value" name="sort_order">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="css-control css-control-sm css-control-success css-switch res">
                                        <input type="checkbox" class="css-control-input" id="currency-status" name="status">
                                        <span class="css-control-indicator"></span> {{ __('back/app.currency.status_title') }}
                                    </label>
                                </div>

                                <input type="hidden" id="currency-main" name="main">
                                <input type="hidden" id="currency-id" name="id" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            {{ __('back/app.currency.cancel') }} <i class="fa fa-times ml-2"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" onclick="event.preventDefault(); createCurrency();">
                            {{ __('back/app.currency.save') }} <i class="fa fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="main-currency-modal" tabindex="-1" role="dialog" aria-labelledby="main-currency-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">{{ __('back/app.currency.select_main') }}</h3>
                        <div class="block-options">
                            <a class="text-muted font-size-h3" href="#" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-10 mt-3">
                                <div class="form-group">
                                    <select class="js-select2 form-control" id="currency-main-select" name="currency_main_select" style="width: 100%;" data-placeholder="Odaberite glavnu valutu">
                                        <option></option>
                                        @foreach ($items as $item)
                                            <option value="{{ $item->id }}" {{ ((isset($main)) and ($main->id == $item->id)) ? 'selected' : '' }}>
                                                {{ isset($item->title->{current_locale()}) ? $item->title->{current_locale()} : $item->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            {{ __('back/app.currency.cancel') }} <i class="fa fa-times ml-2"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" onclick="event.preventDefault(); storeMainCurrency();">
                            {{ __('back/app.currency.save') }} <i class="fa fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-currency-modal" tabindex="-1" role="dialog" aria-labelledby="currency-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">{{ __('back/app.currency.delete_tax') }}</h3>
                        <div class="block-options">
                            <a class="text-muted font-size-h3" href="#" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-10">
                                <h4>{{ __('back/app.currency.delete_shure') }}</h4>
                                <input type="hidden" id="delete-currency-id" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            {{ __('back/app.currency.cancel') }} <i class="fa fa-times ml-2"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="event.preventDefault(); confirmDelete();">
                            {{ __('back/app.currency.delete') }} <i class="fa fa-trash-alt ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('js_after')
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(() => {
            $('#currency-main-select').select2({
                minimumResultsForSearch: Infinity
            });
        });
        /**
         *
         * @param item
         * @param type
         */
        function openModal(item = {}) {
            $('#currency-modal').modal('show');
            editCurrency(item);
        }

        /**
         *
         * @param item
         * @param type
         */
        function openMainModal(item = {}) {
            $('#main-currency-modal').modal('show');
        }

        /**
         *
         */
        function createCurrency() {
            let values = {};

            {!! ag_lang() !!}.forEach(function(item) {
                values[item.code] = document.getElementById('currency-title-' + item.code).value;
            });

            let item = {
                id: $('#currency-id').val(),
                title: values,
                code: $('#currency-code').val(),
                symbol_left: $('#currency-symbol-left').val(),
                symbol_right: $('#currency-symbol-right').val(),
                value: $('#currency-value').val(),
                decimal_places: $('#currency-decimal-places').val(),
                sort_order: $('#sort-order-value').val(),
                status: $('#currency-status')[0].checked,
                main: $('#currency-main').val(),
            };

            axios.post("{{ route('api.currencies.store') }}", { data: item })
            .then(response => {
                if (response.data.success) {
                    location.reload();
                } else {
                    return errorToast.fire(response.data.message);
                }
            });
        }

        /**
         *
         */
        function storeMainCurrency() {
            let item = { main: $('#currency-main-select').val() };

            axios.post("{{ route('api.currencies.store.main') }}", { data: item })
            .then(response => {
                console.log(response.data)
                if (response.data.success) {
                    location.reload();
                } else {
                    return errorToast.fire(response.data.message);
                }
            });
        }

        /**
         *
         */
        function deleteCurrency(id) {
            $('#delete-currency-modal').modal('show');
            $('#delete-currency-id').val(id);
        }

        /**
         *
         */
        function confirmDelete() {
            let item = { id: $('#delete-currency-id').val() };

            axios.post("{{ route('api.taxes.destroy') }}", { data: item })
            .then(response => {
                if (response.data.success) {
                    location.reload();
                } else {
                    return errorToast.fire(response.data.message);
                }
            });
        }

        /**
         *
         * @param item
         */
        function editCurrency(item) {
            $('#currency-id').val(item.id);
            $('#currency-code').val(item.code);
            $('#currency-symbol-left').val(item.symbol_left);
            $('#currency-symbol-right').val(item.symbol_right);
            $('#currency-value').val(item.value);
            $('#currency-decimal-places').val(item.decimal_places);
            $('#sort-order-value').val(item.sort_order);
            $('#currency-main').val(item.main);

            {!! ag_lang() !!}.forEach((lang) => {
                if (typeof item.title[lang.code] !== undefined) {
                    $('#currency-title-' + lang.code).val(item.title[lang.code]);
                }
            });

            if (item.status) {
                $('#currency-status')[0].checked = item.status ? true : false;
            }
        }
    </script>
@endpush
