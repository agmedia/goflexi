@extends('back.layouts.admin')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Tax list</h2>
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
                        <a href="javascript: void(0);" onclick="event.preventDefault(); openModal();" class="btn btn-primary">
                            <i class="ti ti-plus f-18"></i> Add New Tax
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="pc-dt-simple">
                            <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th>Title</th>
                                <th class="text-center">Percentage</th>
                                <th class="text-center">Sort Order</th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        <h6>{{ isset($item->title->{current_locale()}) ? $item->title->{current_locale()} : $item->title }}</h6>
                                    </td>
                                    <td class="text-center">{{ $item->rate }} %</td>
                                    <td class="text-center">{{ $item->sort_order }}</td>
                                    <td class="text-end">
                                        <ul class="list-inline me-auto mb-0">
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                                <a href="javascript:void(0)" class="avtar avtar-xs btn-link-success btn-pc-default" onclick="event.preventDefault(); openModal({{ json_encode($item) }});">
                                                    <i class="ti ti-edit-circle f-18"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Delete">
                                                <a href="javascript:void(0)" class="avtar avtar-xs btn-link-danger btn-pc-default" onclick="event.preventDefault(); deleteTax({{ $item->id }}););">
                                                    <i class="ti ti-trash f-18"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="5">Nema upisanih poreza...</td>
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
    <div class="modal fade" id="tax-modal" tabindex="-1" role="dialog" aria-labelledby="tax--modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">{{ __('back/app.tax.main_title') }}</h3>
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
                                    <label for="status-title" class="w-100">{{ __('back/app.statuses.input_title') }}
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
                                                <input type="text" class="form-control" id="tax-title-{{ $lang->code }}" name="title[{{ $lang->code }}]" placeholder="{{ $lang->code }}"  >
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tax-rate">%</label>
                                            <input type="text" class="form-control" id="tax-rate" name="rate">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tax-sort-order">{{ __('back/app.tax.sort_order') }}</label>
                                            <input type="text" class="form-control" id="tax-sort-order" name="sort_order">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="css-control css-control-sm css-control-success css-switch res">
                                        <input type="checkbox" class="css-control-input" id="tax-status" name="status">
                                        <span class="css-control-indicator"></span> {{ __('back/app.tax.status_title') }}
                                    </label>
                                </div>

                                <input type="hidden" id="tax-id" name="id" value="0">
                                <input type="hidden" id="tax-geo-zone" name="geo_zone" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            {{ __('back/app.tax.cancel') }} <i class="fa fa-times ml-2"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" onclick="event.preventDefault(); createTax();">
                            {{ __('back/app.tax.save') }} <i class="fa fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-tax-modal" tabindex="-1" role="dialog" aria-labelledby="tax--modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">{{ __('back/app.tax.delete_tax') }}</h3>
                        <div class="block-options">
                            <a class="text-muted font-size-h3" href="#" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-10">
                                <h4>{{ __('back/app.tax.delete_shure') }}</h4>
                                <input type="hidden" id="delete-tax-id" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            {{ __('back/app.tax.cancel') }} <i class="fa fa-times ml-2"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="event.preventDefault(); confirmDelete();">
                            {{ __('back/app.tax.delete') }}  <i class="fa fa-trash-alt ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('js_after')
    <script>
        /**
         *
         * @param item
         * @param type
         */
        function openModal(item = {}) {
            $('#tax-modal').modal('show');
            editTax(item);
        }

        /**
         *
         */
        function createTax() {
            let values = {};

            {!! ag_lang() !!}.forEach(function(item) {
                values[item.code] = document.getElementById('tax-title-' + item.code).value;
            });

            let item = {
                id: $('#tax-id').val(),
                geo_zone: $('#tax-geo-zone').val(),
                title: values,
                rate: $('#tax-rate').val(),
                sort_order: $('#tax-sort-order').val(),
                status: $('#tax-status')[0].checked,
            };

            axios.post("{{ route('api.taxes.store') }}", {data: item})
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
        function deleteTax(id) {
            $('#delete-tax-modal').modal('show');
            $('#delete-tax-id').val(id);
        }

        /**
         *
         */
        function confirmDelete() {
            let item = {
                id: $('#delete-tax-id').val()
            };

            axios.post("{{ route('api.taxes.destroy') }}", {data: item})
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
        function editTax(item) {
            $('#tax-id').val(item.id);
            //$('#tax-geo-zone').val(item.geo_zone);
            $('#tax-rate').val(item.rate);
            $('#tax-sort-order').val(item.sort_order);

            {!! ag_lang() !!}.forEach((lang) => {
                if (typeof item.title[lang.code] !== undefined) {
                    $('#tax-title-' + lang.code).val(item.title[lang.code]);
                }
            });

            if (item.status) {
                $('#tax-status')[0].checked = item.status ? true : false;
            }
        }
    </script>
@endpush
