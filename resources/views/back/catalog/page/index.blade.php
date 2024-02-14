@extends('back.layouts.admin')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-header-title">
                        <h2 class="mb-0">Pages</h2>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('page.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus f-18"></i> Add New Page
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @include('back.layouts.partials.session')

        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Title</th>
                        <th>Group</th>
                        <th class="text-center">Viewed</th>
                        <th class="text-center">Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($pages as $page)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <div class="row">
                                    <div class="col-auto">
                                        <img src="{{ asset($page->image) }}" alt="user-image"
                                             class="wid-40 rounded-circle">
                                    </div>
                                    <div class="col">
                                        <h6 class="mb-0">
                                            <a href="{{ route('page.edit', ['page' => $page]) }}">{{ $page->translation()->title }}</a>
                                        </h6>
                                        <p class="text-muted f-12 mb-0">Publish date: {{ \Illuminate\Support\Carbon::make($page->publish_date) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ \Illuminate\Support\Str::ucfirst($page->group) }}</td>
                            <td class="text-center">{{ $page->viewed }}</td>
                            <td class="text-center">@include('back.layouts.partials.status', ['status' => $page->status])</td>
                            <td class="text-end">
                                <ul class="list-inline me-auto mb-0">
                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                        <a href="{{ route('page.edit', ['page' => $page]) }}" class="avtar avtar-xs btn-link-success btn-pc-default">
                                            <i class="ti ti-edit-circle f-18"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Delete">
                                        <a href="javascript:void(0)" class="avtar avtar-xs btn-link-danger btn-pc-default" onclick="event.preventDefault(); deleteSettingsItem({{ $page->id }}, '{{ route('page.api.destroy') }}');">
                                            <i class="ti ti-trash f-18"></i>
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center"><a href="{{ route('page.create') }}">Make some pages..!</a></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <!-- [ sample-page ] end -->
        </div>
    </div>

@endsection

@push('js_after')

@endpush
