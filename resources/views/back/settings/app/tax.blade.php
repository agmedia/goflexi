@extends('back.layouts.admin')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-header-title">
                        <h2 class="mb-0">Tax list</h2>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <a href="javascript: void(0);" onclick="event.preventDefault(); openModal();" class="btn btn-primary">
                        <i class="ti ti-plus f-18"></i> Add New Tax
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
                                                <a href="javascript:void(0)" class="avtar avtar-xs btn-link-danger btn-pc-default" onclick="event.preventDefault(); deleteSettingsItem({{ $item->id }}, '{{ route('api.taxes.destroy') }}');">
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
    </div>

@endsection

@push('modals')
    <div id="tax-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="tax-modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tax-modalTitle">{{ __('back/app.tax.main_title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center mb-3">
                        <div class="col-md-10 position-relative">
                            @include('back.layouts.translations.input', ['title' => 'Naslov', 'tab_title' => 'tax-title', 'input_name' => 'title'])

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
                <div class="modal-footer">
                    <a class="btn btn-light-secondary float-start" data-bs-dismiss="modal" aria-label="Close">
                        {{ __('back/app.payments.cancel') }} <i class="fa fa-times m-l-10"></i>
                    </a>
                    <button type="button" class="btn btn-primary" onclick="event.preventDefault(); createTax();">
                        {{ __('back/app.payments.save') }} <i class="fa fa-arrow-right m-l-10"></i>
                    </button>
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
                notificationResponse(response, 'tax-modal');
            });
        }

        /**
         *
         * @param item
         */
        function editTax(item) {
            $('#tax-id').val(item.id);
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
