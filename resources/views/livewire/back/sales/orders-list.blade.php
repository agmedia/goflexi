<div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-sm-12">
        <div class="chat-wrapper">
            <div class="offcanvas-xxl offcanvas-start chat-offcanvas" tabindex="-1" id="offcanvas_User_list">
                <div class="offcanvas-header">
                    <button class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvas_User_list"
                            aria-label="Close"></button>
                </div>
                <div class="offcanvas-body p-0">
                    <div id="chat-user_list" class="show collapse collapse-horizontal">
                        <div class="chat-user_list">
                            <div class="card overflow-hidden">
                                <div class="card-body">
                                    <h5 class="mb-4">Drives <span class="avtar avtar-xs bg-light-primary rounded-circle">{{ count($list) }}</span></h5>
                                    <div class="form-search">
                                        <i class="ti ti-search"></i>
                                        <input type="search" class="form-control" placeholder="Search Drives">
                                    </div>
                                </div>
                                <div class="scroll-block">
                                    <div class="card-body p-0">
                                        <div class="list-group list-group-flush">
                                            @foreach ([1, 2, 3, 4] as $user)
                                                @foreach ($list as $key => $item)
                                                    <a href="javascript:void(0)" wire:click="selectDrive({{ $key }})" class="list-group-item list-group-item-action p-3">
                                                        <div class="media align-items-center">
                                                            <div class="chat-avtar">
                                                                <img class="rounded-circle img-fluid wid-40" src="{{ asset($item['listing']->image) }}"
                                                                     alt="User image">
                                                                <div class="bg-success chat-badge"></div>
                                                            </div>
                                                            <div class="media-body mx-2">
                                                                <h6 class="mb-0">{{ $item['listing']->translation()->title }} <span class="float-end text-sm text-muted f-w-400">2h ago</span></h6>
                                                                <span class="text-sm text-muted">{{ \Illuminate\Support\Carbon::make($item['listing']->start_time)->format('d.m.Y h:i a') }}
                                                                <span class="float-end">
                                                                    <span class="chat-badge-status bg-primary text-white">{{ count($item['items']) }}</span>
                                                                </span>
                                                            </span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chat-content">
                <div class="card mb-0">
                    <div class="card-header p-3">
                        <div class="d-flex align-items-center">
                            <ul class="list-inline me-auto mb-0">
                                <li class="list-inline-item align-bottom">
                                    <a href="#" class="d-xxl-none avtar avtar-s btn-link-secondary" data-bs-toggle="offcanvas"
                                       data-bs-target="#offcanvas_User_list">
                                        <i class="ti ti-menu-2 f-18"></i>
                                    </a>
                                    <a href="#" class="d-none d-xxl-inline-flex avtar avtar-s btn-link-secondary"
                                       data-bs-toggle="collapse" data-bs-target="#chat-user_list">
                                        <i class="ti ti-menu-2 f-18"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <div class="media align-items-center">
                                        <div class="media-body mx-3 d-none d-sm-inline-block">
                                            <h5>Customers <span class="avtar avtar-xs bg-light-primary rounded-circle">{{ count($drives) }}</span></h5>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <ul class="list-inline ms-auto mb-0" style="display: block !important;">
                                <li class="list-inline-item">
                                    <div class="form-search">
                                        <i class="ti ti-search"></i>
                                        <input type="search" wire:model.live="search_orders" class="form-control" placeholder="Search Orders & Customers">
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="scroll-block chat-message">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-vcenter font-size-sm">
                                    <thead>
                                    <tr>
                                        <th class="text-center" style="width: 36px;">{{ __('back/layout.br') }}</th>
                                        <th>{{ __('back/app.order.customer') }}</th>
                                        <th>Email</th>
                                        <th class="text-center">{{ __('back/layout.status') }}</th>
                                        <th class="text-end">{{ __('back/app.order.details') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($drives as $order)
                                        <tr>
                                            <td class="text-center">
                                                <strong>{{ $order->id }}</strong>
                                            </td>
                                            <td>{{ $order->payment_fname }} {{ $order->payment_lname }}</td>
                                            <td>{{ $order->payment_email }}</td>
                                            <td class="text-center">
                                                    <span class="badge rounded-pill bg-{{ $statuses->where('id', $order->order_status_id)->first()->color ?: 'light-dark' }} f-12">
                                                        {{ $statuses->where('id', $order->order_status_id)->first()->title->{current_locale()} ?? $statuses->where('id', $order->order_status_id)->first()->title }}
                                                    </span>
                                            </td>
                                            <td class="text-end">
                                                <a href="javascript:void(0)" wire:click="selectOrder({{ $order }})" class="avtar avtar-s btn-link-secondary">
                                                    <i class="ti ti-info-circle f-18"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas-xxl offcanvas-end chat-offcanvas" tabindex="-1" id="offcanvas_User_info">
                <div class="offcanvas-header">
                    <button class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvas_User_info"
                            aria-label="Close"></button>
                </div>
                <div class="offcanvas-body p-0">
                    <div id="chat-user_info" class="show collapse collapse-horizontal">
                        <div class="chat-user_info">
                            <div class="card">
                                <div class="text-center card-body position-relative pb-0">
                                    @if ($customer)
                                        <h5 class="text-start">Customer Info</h5>
                                        <div class="position-absolute end-0 top-0 p-3 d-none d-xxl-inline-flex">
                                            <a href="#" class="avtar avtar-xs btn-link-danger btn-pc-default" data-bs-toggle="collapse"
                                               data-bs-target="#chat-user_info">
                                                <i class="ti ti-x f-16"></i>
                                            </a>
                                        </div>
                                        <h5 class="mb-0 mt-4">{{ $customer['payment_fname'] }} {{ $customer['payment_lname'] }}</h5>
                                        <p class="text-muted text-sm">{{ $customer['payment_email'] }}</p>
                                        <div class="d-flex align-items-center justify-content-center mb-0">
                                            <i class="chat-badge bg-{{ $statuses->where('id', $customer['order_status_id'])->first()->color ?: 'light-dark' }} me-2"></i>
                                            <span class="badge bg-light-success">{{ $statuses->where('id', $order->order_status_id)->first()->title->{current_locale()} ?? $statuses->where('id', $order->order_status_id)->first()->title }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="scroll-block">
                                    <div class="card-body">
                                        @if ($customer)
                                            <hr class="mb-3 mt-0 border border-secondary-subtle">
                                            <a class="btn border-0 p-0 text-start w-100" data-bs-toggle="collapse"
                                               href="#filtercollapse1">
                                                <div class="float-end"><i class="ti ti-chevron-down"></i></div>
                                                <h5 class="mb-0">Information</h5>
                                            </a>
                                            <div class="collapse show" id="filtercollapse1">
                                                <div class="py-3">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="mb-0">Name</p>
                                                        <p class="mb-0 text-muted">{{ $customer['payment_fname'] }} {{ $customer['payment_lname'] }}</p>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="mb-0">Email</p>
                                                        <p class="mb-0 text-muted">{{ $customer['payment_email'] }}</p>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="mb-0">Phone</p>
                                                        <p class="mb-0 text-muted">{{ $customer['payment_phone'] }}</p>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="mb-0">Adults</p>
                                                        <p class="mb-0 text-muted">{{ $customer['adults'] }}</p>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="mb-0">Children</p>
                                                        <p class="mb-0 text-muted">{{ $customer['children'] }}</p>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="mb-0">Child seat</p>
                                                        <p class="mb-0 text-muted">{{ $customer['child_seat'] }}</p>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="mb-0">Baggage</p>
                                                        <p class="mb-0 text-muted">{{ $customer['baggage'] }}</p>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <p class="mb-0">Order made</p>
                                                        <p class="mb-0 text-muted">{{ \Illuminate\Support\Carbon::make($customer['created_at'])->format('d.m.Y h:i a') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="my-3 border border-secondary-subtle">
                                            <a href="javascript:void(0)" wire:click="destroyCustomer({{ $customer['id'] }})" class="btn btn-danger d-flex align-items-center justify-content-center">
                                                <i class="ti ti-plus f-18"></i> Remove Order
                                            </a>
                                            <a href="{{ route('orders.edit', ['order' => $customer['id']]) }}" class="btn btn-primary d-flex align-items-center justify-content-center mt-3">
                                                <i class="ti ti-plus f-18"></i> Edit Order
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ sample-page ] end -->
</div>

