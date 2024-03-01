<div>
    <div class="form-group mb-4" wire:ignore>
        <label for="countries-select">{{ __('back/app.geozone.countries') }}</label>
        <select class="js-select2 form-select" id="countries-select" style="width: 100%;">
            <option></option>
            @foreach ($countries as $country)
                <option value="{{ $country['name'] }}">{{ $country['name'] }}</option>
            @endforeach
        </select>
    </div>





    @if ( ! empty($states))
        <div class="table-border-style mt-5">
            <div class="table-responsive">
        <table class="table ">
            <thead class="thead-light">
            <tr>
                <th style="width: 80%;">{{ __('back/app.geozone.list_countries') }} </th>
                <th class="text-end">{{ __('back/app.geozone.delete') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($states as $key => $state)
                <tr>
                    <td>
                        {{ $state }}
                        <input type="hidden" name="state[{{ $key + 1 }}]" value="{{ $state }}">
                    </td>
                    <td class="text-end font-size-sm">

                        <ul class="list-inline me-auto mb-0">

                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Delete">
                                <a wire:click="deleteState('{{ $state }}')" class="avtar avtar-xs btn-link-danger btn-pc-default">
                                    <i class="ti ti-trash f-18"></i>
                                </a>
                            </li>
                        </ul>



                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
            </div>
        </div>
    @endif

</div>

@push('js_after')
    <script>
        $(() => {
            $('#countries-select').on('change', function (e) {
                var data = document.getElementById('countries-select').value;
                @this.stateSelected(data);
            });
        });

        Livewire.on('success_alert', () => {

        });

        Livewire.on('error_alert', () => {

        });
    </script>
@endpush
