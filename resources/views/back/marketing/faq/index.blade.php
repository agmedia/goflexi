@extends('back.layouts.admin')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-header-title">
                        <h2 class="mb-0">FAQ's</h2>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <a class="btn btn-success my-2" href="{{ route('faqs.create') }}">
                        <i class="ti ti-file-plus"></i>Dodaj Novi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
        @include('back.layouts.partials.session')

            <div class="card table-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="pc-dt-simple">
                            <thead>
                            <tr>
                                <th style="width: 5%;">ID</th>
                                <th>Pitanje</th>
                                <th class="text-center">Status</th>
                                <th class="text-end" style="width: 10%;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($faqs as $faq)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <h6><a href="{{ route('faqs.edit', ['faq' => $faq]) }}">{{ $faq->title }}</a></h6>
                                    </td>
                                    <td class="text-center">
                                        @include('back.layouts.partials.status', ['status' => $faq->status])
                                    </td>
                                    <td class="text-end">
                                        <ul class="list-inline me-auto mb-0">
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                                <a href="{{ route('faqs.edit', ['faq' => $faq]) }}" class="avtar avtar-xs btn-link-success btn-pc-default">
                                                    <i class="ti ti-edit-circle f-18"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="4">No data...</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $faqs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js_after')

@endpush
