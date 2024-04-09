<div class="modal fade" id="payment-modal-stripe" tabindex="-1" role="dialog" aria-labelledby="modal-payment-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
        <div class="modal-content rounded">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="status-modalTitle">Stripe Quick Checkout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-md-10">

                        <div class="row mb-3">
                            <div class="col-md-8">
                                @include('back.layouts.translations.input', ['title' => 'Naslov', 'tab_title' => 'stripe-title', 'input_name' => 'title'])
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="stripe-min">{{ __('back/app.payments.min_order_amount') }}</label>
                                    <input type="text" class="form-control" id="stripe-min" name="min">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label for="stripe-geo-zone">{{ __('back/app.payments.geo_zone') }} <span class="small text-gray">{{ __('back/app.payments.geo_zone_label') }}</span></label>
                                <select class="js-select2 form-control" id="stripe-geo-zone" name="geo_zone" style="width: 100%;" data-placeholder="">
                                    <option></option>
                                    @foreach ($geo_zones as $geo_zone)
                                        <option value="{{ $geo_zone->id }}">{{ ( ! is_string($geo_zone->title)) ? $geo_zone->title->{current_locale()} : $geo_zone->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="stripe-price">{{ __('back/app.payments.fee_amount') }}</label>
                                    <input type="text" class="form-control bg" id="stripe-price" name="data['price']">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            @include('back.layouts.translations.textarea', [
                                            'title' => __('back/app.payments.short_desc') . ' <span class="small text-gray">' . __('back/app.payments.short_desc_label') . '</span>',
                                            'tab_title' => 'stripe-short-description',
                                            'input_name' => 'data',
                                            'rows' => 3,
                                            'max_length' => 160
                                            ])
                        </div>

                        <div class="block block-themed block-transparent my-4">
                            <div class="block-content bg-body py-3">
                                <div class="row justify-content-center">
                                    <div class="col-md-11">
                                        <div class="form-group">
                                            <label for="stripe-secret-key">SecretKey:</label>
                                            <input type="text" class="form-control" id="stripe-secret-key" name="data['secret_key']">
                                        </div>
                                        <div class="form-group">
                                            <label for="stripe-public-key">PublicKey:</label>
                                            <input type="text" class="form-control" id="stripe-public-key" name="data['public_key']">
                                        </div>
                                        <div class="form-group">
                                            <label for="stripe-callback">CallbackURL: </label>
                                            <input type="text" class="form-control" id="stripe-callback" name="data['callback']" value="{{ url('/') }}">
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="d-block">Test mod.</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="custom-control custom-radio custom-control-inline custom-control-success custom-control-lg">
                                                        <input type="radio" class="custom-control-input" id="stripe-test-on" name="test" checked="" value="1">
                                                        <label class="custom-control-label" for="stripe-test-on">On</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger custom-control-lg">
                                                        <input type="radio" class="custom-control-input" id="stripe-test-off" name="test" value="0">
                                                        <label class="custom-control-label" for="stripe-test-off">Off</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stripe-price">{{ __('back/app.payments.sort_order') }}</label>
                                    <input type="text" class="form-control" id="stripe-sort-order" name="sort_order">
                                </div>
                            </div>
                            <div class="col-md-6 text-right" style="padding-top: 37px;">
                                <div class="form-group">
                                    <label class="css-control css-control-sm css-control-success css-switch res">
                                        <input type="checkbox" class="css-control-input" id="stripe-status" name="status">
                                        <span class="css-control-indicator"></span> {{ __('back/app.payments.status_title') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="stripe-code" name="code" value="stripe">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                    {{ __('back/app.payments.cancel') }} <i class="fa fa-times ml-2"></i>
                </a>
                <button type="button" class="btn btn-sm btn-primary" onclick="event.preventDefault(); create_stripe();">
                    {{ __('back/app.payments.save') }} <i class="fa fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>

    </div>
</div>

@push('payment-modal-js')
    <script>
        $(() => {

        });
        /**
         *
         */
        function create_stripe() {
            let titles = {};
            let short = {};

            @json(ag_lang()).forEach(function(lang) {
                titles[lang.code] = document.getElementById('stripe-title-' + lang.code).value;
                short[lang.code] = document.getElementById('stripe-short-description-' + lang.code).value;
            });

            let item = {
                title: titles,
                code: $('#stripe-code').val(),
                min: $('#stripe-min').val(),
                data: {
                    price: $('#stripe-price').val(),
                    short_description: short,
                    public_key: $('#stripe-public-key').val(),
                    secret_key: $('#stripe-secret-key').val(),
                    type: $('#stripe-type').val(),
                    callback: $('#stripe-callback').val(),
                    test: $("input[name='test']:checked").val(),
                },
                geo_zone: $('#stripe-geo-zone').val(),
                status: $('#stripe-status')[0].checked,
                sort_order: $('#stripe-sort-order').val()
            };

            axios.post("{{ route('api.payment.store') }}", {data: item})
            .then(response => {
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
        function edit_stripe(item) {
            $('#stripe-min').val(item.min);
            $('#stripe-price').val(item.data.price);

            $('#stripe-public-key').val(item.data.public_key);
            $('#stripe-secret-key').val(item.data.secret_key);
            $('#stripe-callback').val(item.data.callback);

            $("input[name=test][value='" + item.data.test + "']").prop("checked",true);

            $('#stripe-type').val(item.data.type);
            $('#stripe-type').trigger('change');
            $('#stripe-geo-zone').val(item.geo_zone);
            $('#stripe-geo-zone').trigger('change');

            $('#stripe-sort-order').val(item.sort_order);
            $('#stripe-code').val(item.code);

            @json(ag_lang()).forEach((lang) => {
                if (typeof item.title[lang.code] !== undefined) {
                    $('#stripe-title-' + lang.code).val(item.title[lang.code]);
                }
                if (item.data.short_description && typeof item.data.short_description[lang.code] !== undefined) {
                    $('#stripe-short-description-' + lang.code).val(item.data.short_description[lang.code]);
                }
            });

            if (item.status) {
                $('#stripe-status')[0].checked = item.status ? true : false;
            }
        }
    </script>
@endpush
