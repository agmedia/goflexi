@extends('back.layouts.admin')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-header-title">
                        <h2 class="mb-0">Widgets</h2>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <a class="btn btn-primary" href="{{ route('widget.create') }}">
                        <i class="ti ti-file-plus"></i> Add New Widget
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @include('back.layouts.partials.session')

        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="pc-dt-simple">
                            <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th>Title</th>
                                <th>ID</th>
                                <th class="text-center">Status</th>
                                <th class="text-end" style="width: 10%;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($widgets as $widget)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <h6><a class="font-w600" href="{{ route('widget.edit', ['widget' => $widget]) }}">{{ $widget->title }}</a></h6>
                                    </td>
                                    <td>++{{ $widget->slug }}++</td>
                                    <td class="text-center font-size-sm">
                                        @include('back.layouts.partials.status', ['status' => $widget->status])
                                    </td>
                                    <td class="text-end">
                                        <ul class="list-inline me-auto mb-0">
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                                <a href="{{ route('widget.edit', ['widget' => $widget]) }}" class="avtar avtar-xs btn-link-success btn-pc-default">
                                                    <i class="ti ti-edit-circle f-18"></i>
                                                </a>
                                                <button class="btn btn-sm btn-alt-danger" onclick="event.preventDefault(); deleteItem({{ $widget->id }}, '{{ route('widget.destroy') }}');">
                                                    <i class="fa fa-fw fa-trash-alt"></i>
                                                </button>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="6">Nema upisanih widgeta...</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $widgets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js_after')

@endpush
