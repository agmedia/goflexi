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
                        <h2 class="mb-0">Languages list</h2>
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
                        <a href="../application/ecom_product-add.html" class="btn btn-primary">
                            <i class="ti ti-plus f-18"></i> Add New Language
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="pc-dt-simple">
                            <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th>Language Name</th>
                                <th class="text-center">Code</th>
                                <th class="text-center">Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td><span class="h6 m-r-15">{{ $item->title->{current_locale()} }}</span>
                                        @if (current_locale() == $item->code)
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
                                    <td colspan="5">{{ __('back/app.languages.empty_list') }}</td>
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
    <div class="modal fade" id="language-modal" tabindex="-1" role="dialog" aria-labelledby="language-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">{{ __('back/app.languages.table_title') }}</h3>
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
                                    <label for="language-title" class="w-100">{{ __('back/app.languages.input_title') }} <span class="text-danger">*</span>
                                        <ul class="nav nav-pills float-right">
                                            @foreach(ag_lang() as $lang)
                                                <li @if (current_locale() == $lang->code) class="active" @endif>
                                                    <a class="btn btn-sm btn-outline-secondary ml-2 @if (current_locale() == $lang->code) active @endif " data-toggle="pill" href="#{{ $lang->code }}">
                                                        <img src="{{ asset('media/flags/' . $lang->code . '.png') }}" />
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </label>

                                    <div class="tab-content">
                                        @foreach(ag_lang() as $lang)
                                            <div id="{{ $lang->code }}" class="tab-pane @if (current_locale() == $lang->code) active @endif">
                                                <input type="text" class="form-control" id="language-title-{{ $lang->code }}" name="title[{{ $lang->code }}]" placeholder="{{ $lang->code }}" value="">
                                                @error('title.*')
                                                <span class="text-danger font-italic">Greška. Niste unijeli naslov.</span>
                                                @enderror
                                            </div>
                                        @endforeach
                                    </div>

                                </div>

                                <div class="form-group mb-4">
                                    <label for="language-code">{{ __('back/app.languages.code_title') }}</label>
                                    <input type="text" class="form-control" id="language-code" name="code">
                                </div>

                                <div class="form-group">
                                    <label class="css-control css-control-sm css-control-success css-switch res">
                                        <input type="checkbox" class="css-control-input" id="language-status" name="status">
                                        <span class="css-control-indicator"></span> {{ __('back/app.languages.status_title') }}
                                    </label>
                                </div>

                                <input type="hidden" id="language-id" name="id" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            {{ __('back/layout.btn.discard') }} <i class="fa fa-times ml-2"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" onclick="event.preventDefault(); createCurrency();">
                            {{ __('back/layout.btn.save') }} <i class="fa fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-language-modal" tabindex="-1" role="dialog" aria-labelledby="language-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">Obriši jezik</h3>
                        <div class="block-options">
                            <a class="text-muted font-size-h3" href="#" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-10">
                                <h4>Jeste li sigurni da želite obrisati jezik?</h4>
                                <input type="hidden" id="delete-language-id" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            Odustani <i class="fa fa-times ml-2"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="event.preventDefault(); confirmDelete();">
                            Obriši <i class="fa fa-trash-alt ml-2"></i>
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
            $('#language-main-select').select2({
                minimumResultsForSearch: Infinity
            });
        });
        /**
         *
         * @param item
         * @param type
         */
        function openModal(item = {}) {
            $('#language-modal').modal('show');
            editCurrency(item);
        }

        /**
         *
         * @param item
         * @param type
         */
        function openMainModal(item = {}) {
            $('#main-language-modal').modal('show');
        }

        /**
         *
         */
        function createCurrency() {
            let values = {};

            {!! $items !!}.forEach(function(item) {
                values[item.code] = document.getElementById('language-title-' + item.code).value;
            });

            let item = {
                id: $('#language-id').val(),
                title: values,
                code: $('#language-code').val(),
                status: $('#language-status')[0].checked,
                //main: $('#language-main')[0].checked,
            };

            axios.post("{{ route('api.languages.store') }}", { data: item })
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
            let item = { main: $('#language-main-select').val() };

            axios.post("{{ route('api.languages.store.main') }}", { data: item })
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
            $('#delete-language-modal').modal('show');
            $('#delete-language-id').val(id);
        }

        /**
         *
         */
        function confirmDelete() {
            let item = { id: $('#delete-language-id').val() };

            axios.post("{{ route('api.languages.destroy') }}", { data: item })
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
            $('#language-id').val(item.id);
            $('#language-code').val(item.code);

            Object.keys(item.title).forEach((key) => {
                $('#language-title-' + key).val(item.title[key]);
            });

            if (item.status) {
                $('#language-status')[0].checked = item.status ? true : false;
            }

        }
    </script>
@endpush
