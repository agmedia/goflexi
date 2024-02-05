@extends('back.layouts.admin')

@push('css_before')

@endpush

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">System Settings</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @include('back.layouts.partials.session')

        <div class="col-sm-12">
            <div class="card">
                <div class="card-body py-0">
                    <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general-tab-panel" role="tab"
                               aria-selected="true">
                                <i class="ti ti-info-circle me-2"></i>General Info
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="services-tab" data-bs-toggle="tab" href="#services-tab-panel" role="tab"
                               aria-selected="true">
                                <i class="ti ti-route me-2"></i>Services
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="settings-tab" data-bs-toggle="tab" href="#settings-tab-panel" role="tab"
                               aria-selected="true">
                                <i class="ti ti-settings me-2"></i>Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane show active" id="general-tab-panel" role="tabpanel" aria-labelledby="general-tab">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Shop basic information</h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Title @include('back.layouts.partials.required')</label>
                                                <input type="text" class="form-control" id="title-input" name="title" placeholder="" value="{{ isset($data['basic']) ? $data['basic']->title : '' }}">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Address @include('back.layouts.partials.required')</label>
                                                <input type="text" class="form-control" id="address-input" name="address" placeholder="" value="{{ isset($data['basic']) ? $data['basic']->address : '' }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Zip @include('back.layouts.partials.required')</label>
                                                <input type="text" class="form-control" id="zip-input" name="zip" placeholder="" value="{{ isset($data['basic']) ? $data['basic']->zip : '' }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">City @include('back.layouts.partials.required')</label>
                                                <input type="text" class="form-control" id="city-input" name="city" placeholder="" value="{{ isset($data['basic']) ? $data['basic']->city : '' }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">State @include('back.layouts.partials.required')</label>
                                                <input type="text" class="form-control" id="state-input" name="state" placeholder="" value="{{ isset($data['basic']) ? $data['basic']->state : '' }}">
                                            </div>
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label">Phone @include('back.layouts.partials.required')</label>
                                                <input type="text" class="form-control" id="phone-input" name="phone" placeholder="" value="{{ isset($data['basic']) ? $data['basic']->phone : '' }}">
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <label class="form-label">Email @include('back.layouts.partials.required')</label>
                                                <input type="text" class="form-control" id="email-input" name="email" placeholder="" value="{{ isset($data['basic']) ? $data['basic']->email : '' }}">
                                            </div>
                                            <div class="col-12 mt-4 mb-1">
                                                <button type="button" class="btn btn-success" onclick="event.preventDefault(); storeBasicInfo();">
                                                    {{ __('Save') }} <i class="ti ti-check ml-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="services-tab-panel" role="tabpanel" aria-labelledby="services-tab">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Select Main currency</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">Language</label>
                                                <select class="form-control" id="currency-main-select" name="currency_main_select" style="width: 100%;" data-placeholder="Odaberite glavnu valutu">
                                                    <option></option>
                                                    @foreach ($data['currencies'] as $item)
                                                        <option value="{{ $item->id }}" {{ ((isset($data['currency_main'])) and ($data['currency_main']->id == $item->id)) ? 'selected' : '' }}>
                                                            {{ isset($item->title->{current_locale()}) ? $item->title->{current_locale()} : $item->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-4 mb-1">
                                            <button type="button" class="btn btn-success" onclick="event.preventDefault(); storeMainCurrency();">
                                                {{ __('Save') }} <i class="ti ti-check ml-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="settings-tab-panel" role="tabpanel" aria-labelledby="settings-tab">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Cache switch... ...</h5>
                                </div>
                                <div class="card-body">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>

@endsection

@push('modals')

@endpush

@push('js_after')
    <script>
        $(() => {

        });

        /**
         *
         */
        function storeMainCurrency() {
            let item = {main: $('#currency-main-select').val()};

            axios.post("{{ route('api.currencies.store.main') }}", {data: item})
            .then(response => {
                console.log(response.data)
                if (response.data.success) {
                    return showSuccess(response.data.success);
                } else {
                    return showError(response.data.message);
                }
            });
        }

        /**
         *
         */
        function storeGoogleMapsApiKey() {
            let item = {key: $('#api-key-input').val()};

            axios.post("{{ route('api.application.google-api.store.key') }}", {data: item})
            .then(response => {
                console.log(response.data)
                if (response.data.success) {
                    return showSuccess(response.data.success);
                } else {
                    return showError(response.data.message);
                }
            });
        }

        /**
         *
         */
        function storeBasicInfo() {
            let item = {
                title:   document.getElementById('title-input').value,
                address: document.getElementById('address-input').value,
                zip:     document.getElementById('zip-input').value,
                city:    document.getElementById('city-input').value,
                state:   document.getElementById('state-input').value,
                phone:   document.getElementById('phone-input').value,
                email:   document.getElementById('email-input').value
            };

            axios.post("{{ route('api.application.basic.store') }}", item)
            .then(response => {
                if (response.data.success) {
                    return showSuccess(response.data.success);
                } else {
                    return showError(response.data.message);
                }
            });
        }

    </script>
@endpush
