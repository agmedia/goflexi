@extends('back.layouts.admin')

@push('css_before')

@endpush

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Order Status list</h2>
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
                            <i class="ti ti-plus f-18"></i> Add New Order Status
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="pc-dt-simple">
                            <thead>
                            <tr>
                                <th style="width: 5%;">ID</th>
                                <th>Title</th>
                                <th class="text-center">Style</th>
                                <th class="text-center">Sort Order</th>
                                <th class="text-end" style="width: 10%;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        <h6>{{ isset($item->title->{current_locale()}) ? $item->title->{current_locale()} : $item->title }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill bg-{{ isset($item->color) && $item->color ? $item->color : 'light' }} f-12">{{ isset($item->title->{current_locale()}) ? $item->title->{current_locale()} : $item->title }}</span>
                                    </td>
                                    <td class="text-center">{{ $item->sort_order }}</td>
                                    <td class="text-end">
                                        <ul class="list-inline me-auto mb-0">
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                                <a href="javascript:void(0)" class="avtar avtar-xs btn-link-success btn-pc-default" onclick="event.preventDefault(); openModal({{ json_encode($item) }});">
                                                    <i class="ti ti-edit-circle f-18"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Delete">
                                                <a href="javascript:void(0)" class="avtar avtar-xs btn-link-danger btn-pc-default" onclick="event.preventDefault(); deleteSettingsItem({{ $item->id }}, '{{ route('api.order.status.destroy') }}');">
                                                    <i class="ti ti-trash f-18"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="5">Nema upisanih statusaa...</td>
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
    <div id="status-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="status-modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="status-modalTitle">Order Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center mb-3">
                        <div class="col-md-10">
                            <div class="form-group">

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
                                            <input type="text" class="form-control" id="status-title-{{ $lang->code }}" name="title[{{ $lang->code }}]" placeholder="{{ $lang->code }}"  >
                                        </div>
                                    @endforeach
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="status-price">Sort Order</label>
                                <input type="text" class="form-control" id="status-sort-order" name="sort_order">
                            </div>

                            <div class="form-group">
                                <label for="status-color-select">Color</label>
                                <select class="js-select2 form-control" id="status-color-select" name="status" style="width: 100%;" data-placeholder="-- Odaberite stil --">
                                    <option value="primary">Primary</option>
                                    <option value="secondary">Secondary</option>
                                    <option value="success">Success</option>
                                    <option value="info">Info</option>
                                    <option value="light">Light</option>
                                    <option value="danger">Danger</option>
                                    <option value="warning">Warning</option>
                                    <option value="dark">Dark</option>
                                </select>
                            </div>

                            <input type="hidden" id="status-id" name="id" value="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light-secondary float-start" data-bs-dismiss="modal" aria-label="Close">
                        Cancel <i class="fa fa-times m-l-10"></i>
                    </a>
                    <button type="button" class="btn btn-primary" onclick="event.preventDefault(); createStatus();">
                        Save <i class="fa fa-arrow-right m-l-10"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

@endpush

@push('js_after')

    <script>
        $(() => {
            $('#status-color-select').select({
                /*minimumResultsForSearch: Infinity,
                templateResult: formatColorOption,
                templateSelection: formatColorOption*/
            });
        });

        /**
         *
         * @param state
         * @return string
         */
        function formatColorOption(state) {
            if (!state.id) { return state.text; }

            let html = $(
                '<span class="badge badge-pill badge-' + state.element.value + '"> ' + state.text + ' </span>'
            );
            return html;
        }

        /**
         *
         * @param item
         * @param type
         */
        function openModal(item = {}) {
            $('#status-modal').modal('show');
            editStatus(item);
        }

        /**
         *
         */
        function createStatus() {
            let values = {};

            {!! ag_lang() !!}.forEach(function(item) {
                values[item.code] = document.getElementById('status-title-' + item.code).value;
            });

            let item = {
                id: $('#status-id').val(),
                title: values,
                sort_order: $('#status-sort-order').val(),
                color: $('#status-color-select').val()
            };

            axios.post("{{ route('api.order.status.store') }}", {data: item})
            .then(response => {
                //console.log(response.data)
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
        function editStatus(item) {
            $('#status-id').val(item.id);
            $('#status-sort-order').val(item.sort_order);

            {!! ag_lang() !!}.forEach((lang) => {
                if (item.title !== undefined && item.title[lang.code] !== undefined) {
                    $('#status-title-' + lang.code).val(item.title[lang.code]);
                } else {
                    $('#status-title-' + lang.code).val(item.title);
                }
            });

            $('#status-color-select').val(item.color);
            $('#status-color-select').trigger('change');
        }
    </script>
@endpush
