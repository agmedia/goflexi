<div class="modal fade" id="payment-modal-pickup" tabindex="-1" role="dialog" aria-labelledby="modal-payment-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
        <div class="modal-content rounded">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="status-modalTitle">Pickup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="row mb-3">
                            <div class="col-md-8 position-relative">
                                @include('back.layouts.translations.input', ['title' => 'Naslov', 'tab_title' => 'pickup-title', 'input_name' => 'title'])
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pickup-min">{{ __('back/app.payments.min_order_amount') }}</label>
                                    <input type="text" class="form-control" id="pickup-min" name="min">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pickup-price">{{ __('back/app.payments.fee_amount') }}</label>
                                    <input type="text" class="form-control bg" id="pickup-price" name="data['price']">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label for="pickup-geo-zone">{{ __('back/app.payments.geo_zone') }} <span class="small text-gray">{{ __('back/app.payments.geo_zone_label') }}</span></label>
                                <select class="js-select2 form-control" id="pickup-geo-zone" name="geo_zone" style="width: 100%;" data-placeholder="">
                                    <option></option>
                                    @foreach ($geo_zones as $geo_zone)
                                        <option value="{{ $geo_zone->id }}">{{ ( ! is_string($geo_zone->title)) ? $geo_zone->title->{current_locale()} : $geo_zone->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12 position-relative">
                                <div class="form-group">
                                    @include('back.layouts.translations.textarea', [
                                                'title' => __('back/app.payments.short_desc') . ' <span class="small text-gray">' . __('back/app.payments.short_desc_label') . '</span>',
                                                'tab_title' => 'pickup-short-description',
                                                'input_name' => 'data',
                                                'rows' => 3,
                                                'max_length' => 160
                                                ])
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pickup-price">{{ __('back/app.payments.sort_order') }}</label>
                                    <input type="text" class="form-control" id="pickup-sort-order" name="sort_order">
                                </div>
                            </div>
                            <div class="col-md-6 text-right" style="padding-top: 37px;">
                                <div class="form-group">
                                    <label class="css-control css-control-sm css-control-success css-switch res">
                                        <input type="checkbox" class="css-control-input" id="pickup-status" name="status">
                                        <span class="css-control-indicator"></span> {{ __('back/app.payments.status_title') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="pickup-code" name="code" value="pickup">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-light-secondary float-start" data-bs-dismiss="modal" aria-label="Close">
                    {{ __('back/app.payments.cancel') }} <i class="fa fa-times m-l-10"></i>
                </a>
                <button type="button" class="btn btn-primary" onclick="event.preventDefault(); create_pickup();">
                    {{ __('back/app.payments.save') }} <i class="fa fa-arrow-right m-l-10"></i>
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
        function create_pickup() {
            let titles = {};
            let short = {};

            {!! ag_lang() !!}.forEach(function(lang) {
                titles[lang.code] = document.getElementById('pickup-title-' + lang.code).value;
                short[lang.code] = document.getElementById('pickup-short-description-' + lang.code).value;
            });

            let item = {
                title: titles,
                code: $('#pickup-code').val(),
                min: $('#pickup-min').val(),
                data: {
                    price: $('#pickup-price').val(),
                    short_description: short
                },
                geo_zone: $('#pickup-geo-zone').val(),
                status: $('#pickup-status')[0].checked,
                sort_order: $('#pickup-sort-order').val()
            };

            axios.post("{{ route('api.payment.store') }}", {data: item})
            .then(response => {
                notificationResponse(response, 'payment-modal-pickup');
            });
        }

        /**
         *
         * @param item
         */
        function edit_pickup(item) {
            $('#pickup-min').val(item.min);
            $('#pickup-price').val(item.data.price);
            $('#pickup-sort-order').val(item.sort_order);
            $('#pickup-code').val(item.code);

            {!! ag_lang() !!}.forEach((lang) => {
                if (typeof item.title[lang.code] !== undefined) {
                    $('#pickup-title-' + lang.code).val(item.title[lang.code]);
                }
                if (typeof item.data.short_description[lang.code] !== undefined) {
                    $('#pickup-short-description-' + lang.code).val(item.data.short_description[lang.code]);
                }
            });

            if (item.status) {
                $('#pickup-status')[0].checked = item.status ? true : false;
            }
            if (item.geo_zone) {
                document.getElementById('pickup-geo-zone').value = item.geo_zone;
            }
        }
    </script>
@endpush
