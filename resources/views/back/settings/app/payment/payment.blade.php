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
                        <h2 class="mb-0">Payment methods list</h2>
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
                    <div class="table-responsive">
                        <table class="table table-hover" id="pc-dt-simple">
                            <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th>Title</th>
                                <th class="text-center">Code</th>
                                <th class="text-center">Sort Order</th>
                                <th class="text-center">Status</th>
                                <th class="text-end" style="width: 10%;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><span class="h6 m-r-15">{{ isset($item->title->{current_locale()}) ? $item->title->{current_locale()} : $item->title }}</span>
                                        @if (isset($item->main) && $item->main)
                                            <i data-feather="check-circle" class="text-success">
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $item->code }}</td>
                                    <td class="text-center">{{ $item->sort_order }}</td>
                                    <td class="text-center">@include('back.layouts.partials.status', ['status' => $item->status])</td>
                                    <td class="text-end">
                                        <ul class="list-inline me-auto mb-0">
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                                <a href="javascript:void(0)" class="avtar avtar-xs btn-link-success btn-pc-default" onclick="event.preventDefault(); edit({{ json_encode($item) }}, '{{ $item->code }}');">
                                                    <i class="ti ti-edit-circle f-18"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="5">Nema upisanih metoda plaćanja...</td>
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
    <!-- Pop Out Block Modal -->
    @foreach($items as $item)
        @include('back.settings.app.payment.modals.' . $item->code)
    @endforeach
@endpush

@push('js_after')
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        /**
         *
         * @param item
         * @param type
         */
        function edit(item, type) {
            $('#payment-modal-' + type).modal('show');
            // Call to individual edit function.
            // As. edit_flat (item) {}
            window["edit_" + type](item);
        }
    </script>

    @stack('payment-modal-js')
@endpush
