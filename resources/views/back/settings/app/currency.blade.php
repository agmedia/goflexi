@extends('back.layouts.admin')

@push('css_before')
@endpush

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-header-title">
                        <h2 class="mb-0">Currency list</h2>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <a href="javascript: void(0);" onclick="event.preventDefault(); openMainModal();" class="btn btn-secondary">
                        <i class="ti ti-plus f-18"></i> Select Default Currency
                    </a>
                    <a href="javascript: void(0);" onclick="event.preventDefault(); openModal();" class="btn btn-primary">
                        <i class="ti ti-plus f-18"></i> Add New Currency
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-body">
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
                                    <td><span class="h6 m-r-15">{{ ( ! is_string($item->title)) ? $item->title->{current_locale()} : $item->title }}</span>
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
                                                <a href="javascript:void(0)" class="avtar avtar-xs btn-link-danger btn-pc-default" onclick="event.preventDefault(); deleteSettingsItem({{ $item->id }}, '{{ route('api.currencies.destroy') }}');">
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
    </div>

@endsection

@push('modals')
    <div id="currency-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="currency-modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="currency-modalTitle">{{ __('back/app.currency.title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center mb-3">
                        <div class="col-md-10 position-relative">
                            @include('back.layouts.translations.input', ['title' => 'Naslov', 'tab_title' => 'currency-title', 'input_name' => 'title'])

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
                <div class="modal-footer">
                    <a class="btn btn-light-secondary float-start" data-bs-dismiss="modal" aria-label="Close">
                        {{ __('back/app.payments.cancel') }} <i class="fa fa-times m-l-10"></i>
                    </a>
                    <button type="button" class="btn btn-primary" onclick="event.preventDefault(); createCurrency();">
                        {{ __('back/app.payments.save') }} <i class="fa fa-arrow-right m-l-10"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="main-currency-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="main-currency-modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="main-currency-modalTitle">{{ __('back/app.currency.select_main') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center mb-3">
                        <div class="col-md-10">
                            <select class="js-select2 form-control" id="currency-main-select" name="currency_main_select" style="width: 100%;" data-placeholder="Odaberite glavnu valutu">
                                <option></option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}" {{ ((isset($main)) and ($main->id == $item->id)) ? 'selected' : '' }}>
                                        {{ ( ! is_string($item->title)) ? $item->title->{current_locale()} : $item->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light-secondary float-start" data-bs-dismiss="modal" aria-label="Close">
                        {{ __('back/app.payments.cancel') }} <i class="fa fa-times m-l-10"></i>
                    </a>
                    <button type="button" class="btn btn-primary" onclick="event.preventDefault(); storeMainCurrency();">
                        {{ __('back/app.payments.save') }} <i class="fa fa-arrow-right m-l-10"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('js_after')
    <script>
        $(() => {

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
                notificationResponse(response, 'currency-modal');
            });
        }

        /**
         *
         */
        function storeMainCurrency() {
            let item = { main: $('#currency-main-select').val() };

            axios.post("{{ route('api.currencies.store.main') }}", { data: item })
            .then(response => {
                notificationResponse(response, 'currency');
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
