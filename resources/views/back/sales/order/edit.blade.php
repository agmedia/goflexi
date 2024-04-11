@extends('back.layouts.admin')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.0/dist/index.umd.min.js"></script>
@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                @if (isset($order))
                    <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('back/app.order.edit') }} <small class="font-weight-light">#_</small><strong>{{ $order->id }}</strong></h1>
                    <h4 class="mb-1"><span class="badge rounded-pill bg-{{ $order->status->color }}">{{ $order->status->title->{current_locale()} ?? $order->status->title }}</span></h4>
                @else
                    <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('back/app.order.new') }}</h1>
                @endif
            </div>
        </div>
    </div>


    <!-- Page Content -->
    <div class="content">
        @include('back.layouts.partials.session')

        <form action="{{ isset($order) ? route('orders.update', ['order' => $order]) : route('orders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($order))
                {{ method_field('PATCH') }}
            @endif

            <!-- Products -->
            <div class="row">
                <div class="col-sm-7">
                    <div class="block block-rounded" id="ag-order-products-app">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{ __('back/app.order.info') }}</h3>
                        </div>
                        <div class="block-content">
                            <div class="row justify-content-center push">
                                <div class="col-md-5">
                                    <img class="img-thumbnail" src="{{ asset($order->product->image) }}" alt="">
                                </div>
                                <div class="col-md-7">
                                    <h3 class="mb-0">{{ $order->product->translation()->title }}</h3>
                                    <p>
                                        {{ $order->product->address }}, {{ $order->product->city }}
                                    </p>

                                    <table class="table-borderless" style="width: 100%;">
                                        <tr>
                                            <td class="font-weight-bold" style="width: 30%;">{{ __('back/app.order.customer') }}:<br><br><br><br></td>
                                            <td>{{ $order->payment_fname }} {{ $order->payment_lname }}<br>
                                                {{ $order->payment_email }}<br>
                                                {{ $order->payment_phone }}<br><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">{{ __('back/app.order.persons') }}:</td>
                                            <td>{{ $order->adults }} {{ __('back/app.order.adults') }},<br>
                                                {{ $order->children }} {{ __('back/app.order.children') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">{{ __('back/app.order.date') }}:<br><br><br></td>
                                            <td>{{ \Illuminate\Support\Carbon::make($order->product->start_time)->format('d.m.Y') }}<br><br><br></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold" colspan="2">{{ __('back/app.order.change_date') }}:<br>
                                                <div class="input-group mt-2 mb-3">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                                    <input class="form-control" id="checkindate" name="dates" placeholder="Check-in -> Checkout" type="text">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-5">
                    <!-- Billing Address -->
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{ __('back/app.order.customer') }}</h3>
                            <div class="block-options">
                                @if (isset($order) && $order->user_id)
                                    <span class="small text-gray mr-3">{{ __('back/app.order.customer_registered') }}</span><i class="fa fa-user text-success"></i>
                                @else
                                    <span class="small font-weight-light mr-3">{{ __('back/app.order.customer_not_registered') }}</span><i class="fa fa-user text-danger-light"></i>
                                @endif
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="row justify-content-center push">
                                <div class="col-md-11">
                                    <div class="form-group row items-push mb-0">
                                        <div class="col-md-6">
                                            <label for="fname-input">{{ __('back/app.order.name') }} @include('back.layouts.partials.required')</label>
                                            <input type="text" class="form-control" id="fname-input" name="firstname" placeholder="{{ __('back/app.order.name') }}" value="{{ isset($order) ? $order->payment_fname : old('fname') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lname-input">{{ __('back/app.order.lastname') }} @include('back.layouts.partials.required')</label>
                                            <input type="text" class="form-control" id="lname-input" name="lastname" placeholder="{{ __('back/app.order.lastname') }}" value="{{ isset($order) ? $order->payment_lname : old('lname') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email-input">{{ __('back/app.order.email') }} @include('back.layouts.partials.required')</label>
                                            <input type="text" class="form-control" id="email-input" name="email" placeholder="{{ __('back/app.order.email') }}" value="{{ isset($order) ? $order->payment_email : old('email') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone-input">{{ __('back/app.order.phone') }} @include('back.layouts.partials.required')</label>
                                            <input type="text" class="form-control" id="phone-input" name="phone" placeholder="{{ __('back/app.order.phone') }}" value="{{ isset($order) ? $order->payment_phone : old('phone') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="adults-input">{{ __('back/app.order.adults') }} <small>({{ $order->product->quantity }})</small></label>
                                            <input type="number" class="form-control" id="adults-input" name="adults" value="{{ isset($order) ? $order->adults : old('adults') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="children-input">{{ __('back/app.order.children') }} <small>({{ $order->product->quantity }})</small></label>
                                            <input type="number" class="form-control" id="children-input" name="children" value="{{ isset($order) ? $order->children : old('children') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Payments -->
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{ __('back/app.payments.title') }}</h3>
                        </div>
                        <div class="block-content">
                            <div class="row mb-5 mt-2">
                                <div class="col-md-12">
                                    <label for="payment-select">{{ __('back/app.order.payments') }}</label>
                                    <select class="js-select2 form-control" id="payment-select" name="payment_type" style="width: 100%;" data-placeholder="{{ __('back/app.order.select_payments') }}">
                                        <option></option>
                                        @foreach ($payments as $payment)
                                            <option value="{{ $payment->code }}" {{ ((isset($order)) and ($order->payment_code == $payment->code)) ? 'selected' : '' }}>{{ $payment->title->{current_locale()} ?? $payment->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="block block-rounded" id="ag-order-products-app">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{ __('back/app.order.items_title') }}</h3>
                        </div>
                        <div class="block-content">
                            <div class="row justify-content-center push">
                                <div class="col-md-11">
                                    <table class="table" style="width: 100%;">
                                        @foreach ($order->totals()->get() as $item)
                                            <!-- Items -->
                                            @if ($item['code'] != 'option')
                                                <tr style="height: 36px;">
                                                    <td style="width: 4%;"></td>
                                                    <td>{{ $item['title'] }}</td>
                                                    <td class="text-right">{{ $item['value'] }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- History Messages -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('back/app.order.history') }}</h3>
                    <div class="block-options">
                        <div class="dropdown">
                            <button type="button" class="btn btn-alt-secondary" id="btn-add-comment">
                                {{ __('back/app.order.add_comment') }}
                            </button>
                            <button type="button" class="btn btn-light" id="dropdown-ecom-filters" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('back/app.order.change_status') }}
                                <i class="fa fa-angle-down ml-1"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-ecom-filters">
                                @foreach ($statuses as $status)
                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:setStatus({{ $status->id }});">
                                        <span class="badge badge-pill badge-{{ $status->color }}">{{ $status->title->{current_locale()} ?? $status->title }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="block-content">
                    <table class="table table-borderless table-striped table-vcenter font-size-sm">
                        <tbody>
                        @foreach ($order->history as $record)
                            <tr>
                                <td class="font-size-base">
                                    @if ($record->status)
                                        <span class="badge badge-pill badge-{{ $record->status->color }}">{{ $record->status->title->{current_locale()} ?? $record->status->title }}</span>
                                    @else
                                        <small>{{ __('back/app.order.comment') }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="font-w600">{{ \Illuminate\Support\Carbon::make($record->created_at)->locale(current_locale(true))->diffForHumans() }}</span> /
                                    <span class="font-weight-light">{{ \Illuminate\Support\Carbon::make($record->created_at)->format('d.m.Y - h:i') }}</span>
                                </td>
                                <td>
                                    <a href="javascript:void(0)">{{ $record->user ? $record->user->name : $record->order->payment_fname . ' ' . $record->order->payment_lname }}</a>
                                </td>
                                <td>{{ $record->comment }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="block">
                <div class="block-content">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-hero-success mb-3">
                                <i class="fas fa-save mr-1"></i> {{ __('back/layout.btn.save') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
    <!-- END Page Content -->

@endsection


@push('modals')
    <div class="modal fade" id="comment-modal" tabindex="-1" role="dialog" aria-labelledby="comment--modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">{{ __('back/app.order.add_comment') }}</h3>
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
                                    <label for="status-select">{{ __('back/app.order.change_status') }}</label>
                                    <select class="js-select2 form-control" id="status-select" name="status" style="width: 100%;" data-placeholder="{{ __('back/app.order.change_status') }}..">
                                        <option value="0">{{ __('back/app.order.no_change_status') }}...</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->title->{current_locale()} ?? $status->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="comment-input">{{ __('back/app.order.comment') }}</label>
                                    <textarea class="form-control" name="comment" id="comment-input" rows="7"></textarea>
                                </div>

                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            {{ __('back/layout.btn.discard') }} <i class="fa fa-times ml-2"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" onclick="event.preventDefault(); changeStatus();">
                            {{ __('back/layout.btn.save') }} <i class="fa fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('js_after')
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(() => {
            $('#payment-select').select2({});
            $('#apartment-select').select2({});
            $('#status-select').select2({});

            $('#btn-add-comment').on('click', () => {
                $('#comment-modal').modal('show');
                $('#status-select').val(0);
                $('#status-select').trigger('change');
            });
        })

        /**
         *
         * @param status
         */
        function setStatus(status) {
            $('#comment-modal').modal('show');
            $('#status-select').val(status);
            $('#status-select').trigger('change');
        }

        /**
         *
         * @param tag_id
         * @returns {*}
         */
        function copyToClipboard(tag_id = 'url-input') {
            let text = document.getElementById(tag_id);

            if (window.isSecureContext) {
                navigator.clipboard.writeText(text.innerText)

                return successToast.fire('OK');
            }

            return warningToast.fire('Whoops.!!');
        }

        /**
         *
         */
        function changeStatus() {
            let item = {
                order_id: {{ $order->id }},
                comment:  $('#comment-input').val(),
                status:   $('#status-select').val()
            };

            axios.post("{{ route('api.order.status.change') }}", item)
            .then(response => {
                console.log(response.data)
                if (response.data.message) {
                    $('#comment-modal').modal('hide');

                    successToast.fire({
                        timer: 1500,
                        text:  response.data.message,
                    }).then(() => {
                        location.reload();
                    })

                } else {
                    return errorToast.fire(response.data.error);
                }
            });
        }
    </script>

@endpush
