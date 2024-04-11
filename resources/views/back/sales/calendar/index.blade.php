@extends('back.layouts.admin')

@push('css_before')
@endpush

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Orders</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('back.sales.orders-list', ['list' => $drives])

@endsection

@push('modals')
@endpush

@push('js_after')
    <script>
        // scroll-block
        /*var tc = document.querySelectorAll('.scroll-block');
        for (var t = 0; t < tc.length; t++) {
            new SimpleBar(tc[t], { autoHide:true });
        }*/

        $(() => {
            /*Livewire.on('drives_selected', () => {
                var tc = document.querySelectorAll('.scroll-block');
                for (var t = 0; t < tc.length; t++) {
                    new SimpleBar(tc[t], { autoHide:true });
                }

                console.log(tc, 'je ut')
            });*/
        })
    </script>
@endpush
