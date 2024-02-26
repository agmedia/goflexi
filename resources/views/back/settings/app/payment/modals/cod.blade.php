<div class="modal fade" id="payment-modal-cod" tabindex="-1" role="dialog" aria-labelledby="modal-payment-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
        <div class="modal-content rounded">

            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="status-modalTitle">Gotovinom prilikom pouzeća</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-md-10">

                            <div class="row mb-3">
                                <div class="col-md-8 position-relative">

                                    <ul class="nav nav-pills position-absolute me-2" id="cod-title-tab" role="tablist" style="right:5px;top:-5px">
                                        @foreach(ag_lang() as $lang)
                                            <li class="nav-item">
                                                <a class="btn btn-icon btn-sm btn-link-primary me-1  @if ($lang->code == current_locale()) active @endif" id="cod-title-{{ $lang->code }}-tab" data-bs-toggle="pill" href="#cod-title-{{ $lang->code }}" role="tab" aria-controls="cod-title-{{ $lang->code }}" aria-selected="true">
                                                    <img src="{{ asset('assets/flags/' . $lang->code . '.png') }}" />
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="tab-content" id="cod-title-tabContent">
                                        @foreach(ag_lang() as $lang)
                                            <div class="tab-pane fade show @if ($lang->code == current_locale()) active @endif" id="cod-title-{{ $lang->code }}" role="tabpanel" aria-labelledby="cod-title-{{ $lang->code }}-tab">
                                                <div class="form-group">
                                                    <label for="cod-title-{{ $lang->code }}">Naslov </label>
                                                    <input type="text" class="form-control" id="cod-title-{{ $lang->code }}" name="title[{{ $lang->code }}]" placeholder="{{ $lang->code }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cod-min">Min. iznos narudžbe</label>
                                        <input type="text" class="form-control" id="cod-min" name="min">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cod-price">Iznos naknade</label>
                                        <input type="text" class="form-control" id="cod-price" name="data['price']">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label for="cod-geo-zone">Geo zona <span class="small text-gray">(Geo zona na koju se odnosi dostava..)</span></label>
                                    <select class="js-select2 form-control" id="cod-geo-zone" name="geo_zone" style="width: 100%;" data-placeholder="Odaberite geo zonu">
                                        <option></option>
                                        @foreach ($geo_zones as $geo_zone)
                                            <option value="{{ $geo_zone->id }}" {{ ((isset($payment)) and ($payment->geo_zone == $geo_zone->id)) ? 'selected' : '' }}>{{ $geo_zone->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="cod-short-description">Kratki opis <span class="small text-gray">(Prikazuje se prilikom odabira plaćanja.)</span></label>
                                <textarea class="js-maxlength form-control" id="cod-short-description" name="data['short_description']" rows="2" maxlength="160" data-always-show="true" data-placement="top"></textarea>
                                <small class="form-text text-muted">
                                    160 znakova max
                                </small>
                            </div>

                            <div class="form-group mb-4">
                                <label for="cod-description">Detaljni opis <span class="small text-gray">(Ako je potreban. Prikazuje se ako je plaćanje odabrano prilikom kupnje.)</span></label>
                                <textarea class="form-control" id="cod-description" name="data['description']" rows="4"></textarea>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cod-price">Poredak</label>
                                        <input type="text" class="form-control" id="cod-sort-order" name="sort_order">
                                    </div>
                                </div>
                                <div class="col-md-6 text-right" style="padding-top: 37px;">
                                    <div class="form-group">
                                        <label class="css-control css-control-sm css-control-success css-switch res">
                                            <input type="checkbox" class="css-control-input" id="cod-status" name="status">
                                            <span class="css-control-indicator"></span> Status načina plaćanja
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="cod-code" name="code" value="cod">
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
                <a class="btn btn-light-secondary float-start" data-bs-dismiss="modal" aria-label="Close">
                    Cancel <i class="fa fa-times m-l-10"></i>
                </a>
                <button type="button" class="btn btn-primary" onclick="event.preventDefault(); createStatus();">
                    Save <i class="fa fa-arrow-right m-l-10"></i>
                </button>
            </div>
        </div>

        </div>
    </div>
</div>

@push('payment-modal-js')
    <script>
        $(() => {
            $('#cod-geo-zone').select2({
                minimumResultsForSearch: Infinity,
                allowClear: true
            });
        });
        /**
         *
         */
        function create_cod() {
            let item = {
                title: $('#cod-title').val(),
                code: $('#cod-code').val(),
                min: $('#cod-min').val(),
                data: {
                    price: $('#cod-price').val(),
                    short_description: $('#cod-short-description').val(),
                    description: $('#cod-description').val(),
                },
                geo_zone: $('#cod-geo-zone').val(),
                status: $('#cod-status')[0].checked,
                sort_order: $('#cod-sort-order').val()
            };

            axios.post("{{ route('api.payment.store') }}", {data: item})
            .then(response => {
                console.log(response.data)
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
        function edit_cod(item) {
            $('#cod-title').val(item.title);
            $('#cod-min').val(item.min);
            $('#cod-price').val(item.data.price);
            $('#cod-short-description').val(item.data.short_description);
            $('#cod-description').val(item.data.description);
            $('#cod-sort-order').val(item.sort_order);
            $('#cod-code').val(item.code);

            if (item.status) {
                $('#cod-status')[0].checked = item.status ? true : false;
            }
        }
    </script>
@endpush
