@extends('back.layouts.admin')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-header-title">
                        <h2 class="mb-0">Languages list</h2>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <a href="javascript: void(0);" onclick="event.preventDefault(); openModal();" class="btn btn-primary">
                        <i class="ti ti-plus f-18"></i> Add New Language
                    </a>
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
                                                <a href="javascript:void(0)" class="avtar avtar-xs btn-link-danger btn-pc-default" onclick="event.preventDefault(); deleteSettingsItem({{ $item->id }}, '{{ route('api.languages.destroy') }}');">
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

    <div id="language-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="language-modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="language-modalTitle">{{ __('back/app.languages.table_title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center mb-3">
                        <div class="col-md-10 position-relative">
                            @include('back.layouts.translations.input', ['title' => 'Naslov', 'tab_title' => 'language-title', 'input_name' => 'title'])

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
                <div class="modal-footer">
                    <a class="btn btn-light-secondary float-start" data-bs-dismiss="modal" aria-label="Close">
                        {{ __('back/app.payments.cancel') }} <i class="fa fa-times m-l-10"></i>
                    </a>
                    <button type="button" class="btn btn-primary" onclick="event.preventDefault(); createLanguage();">
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
            $('#language-modal').modal('show');
            editLanguage(item);
        }

        /**
         *
         */
        function createLanguage() {
            let values = {};

            {!! ag_lang() !!}.forEach(function(item) {
                values[item.code] = document.getElementById('language-title-' + item.code).value;
            });

            let item = {
                id: $('#language-id').val(),
                title: values,
                code: $('#language-code').val(),
                status: $('#language-status')[0].checked,
            };

            axios.post("{{ route('api.languages.store') }}", { data: item })
            .then(response => {
                notificationResponse(response, 'language-modal');
            });
        }

        /**
         *
         * @param item
         */
        function editLanguage(item) {
            $('#language-id').val(item.id);
            $('#language-code').val(item.code);

            {!! ag_lang() !!}.forEach((lang) => {
                if (typeof item.title[lang.code] !== undefined) {
                    $('#language-title-' + lang.code).val(item.title[lang.code]);
                }
            });

            if (item.status) {
                $('#language-status')[0].checked = item.status ? true : false;
            }

        }
    </script>
@endpush
