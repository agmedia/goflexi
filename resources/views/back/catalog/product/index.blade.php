@extends('back.layouts.admin')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-header-title">
                        <h2 class="mb-0">Products</h2>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('product.create.list') }}" class="btn btn-light-warning m-l-20">
                        <i class="ti ti-plus f-18"></i> Add New Products List
                    </a>
                    <a href="{{ route('product.create') }}" class="btn btn-primary m-l-20">
                        <i class="ti ti-plus f-18"></i> Add New Product
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
                        <th>From - To</th>
                        <th class="text-end">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td class="text-center">{{ $product->id }}</td>
                            <td>
                                <div class="row">
                                    <div class="col-auto">
                                        <img src="{{ asset($product->image) }}" alt="user-image"
                                             class="wid-40 rounded-circle">
                                    </div>
                                    <div class="col">
                                        <h6 class="mb-0">
                                            <a href="{{ route('product.edit', ['product' => $product]) }}">{{ $product->from_city }} - {{ $product->to_city }}</a>
                                        </h6>
                                        <p class="text-muted f-12 mb-0">Start: {{ \Illuminate\Support\Carbon::make($product->start_time) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">{{ number_format($product->price, 2) }} / {{ number_format($product->price_child, 2) }}</td>
                            <td class="text-center">{{ $product->quantity }}</td>
                            <td class="text-center">@include('back.layouts.partials.status', ['status' => $product->status])</td>
                            <td class="text-end">
                                <ul class="list-inline me-auto mb-0">
                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="View Sales">
                                        <a href="{{ route('calendar') }}" class="avtar avtar-xs btn-link-secondary btn-pc-default">
                                            <i class="ti ti-eye f-18"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                        <a href="{{ route('product.edit', ['product' => $product]) }}" class="avtar avtar-xs btn-link-success btn-pc-default">
                                            <i class="ti ti-edit-circle f-18"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Delete">
                                        <a href="javascript:void(0)" class="avtar avtar-xs btn-link-danger btn-pc-default" onclick="event.preventDefault(); deleteSettingsItem({{ $product->id }}, '{{ route('product.api.destroy') }}');">
                                            <i class="ti ti-trash f-18"></i>
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center"><a href="{{ route('product.create') }}">Make some products..!</a></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $products->links() }}
            </div>
            <!-- [ sample-page ] end -->
        </div>
    </div>

@endsection

@push('js_after')

@endpush
