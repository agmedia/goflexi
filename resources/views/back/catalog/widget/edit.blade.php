@extends('back.layouts.admin')

@push('css_before')
@endpush

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-4">Widget</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <form action="{{ isset($widget) ? route('widget.update', ['widget' => $widget]) : route('widget.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @if (isset($widget))
            {{ method_field('PATCH') }}
        @endif
        <div class="row">
            @include('back.layouts.partials.session')
            <div class="col-md-7">
                <div class="card">
                    <h5 class="card-header">Generel Info</h5>
                    <div class="card-body">
                        <div class="form-group row items-push mb-3">
                            <div class="col-md-8">
                                <label for="title-input">Widget Title @include('back.layouts.partials.required')</label>
                                <input type="text" class="form-control" id="title-input" name="title" placeholder="Enter widget title" value="{{ isset($widget) ? $widget->title : old('title') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="resource-select">Widget Group @include('back.layouts.partials.required')</label>
                                <select class="form-control" id="resource-select" name="resource">
                                    <option></option>
                                    @foreach ($resources as $key => $resource)
                                        <option value="{{ $key }}" {{ (isset($widget) and $key == $widget->resource) ? 'selected="selected"' : '' }}>{{ $resource }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row items-push mt-4">
                            <div class="col-md-12">
                                <label for="title-input">Widget id</label>
                                <input type="text" class="form-control" id="slug-input" name="slug" placeholder="Upišite oznaku widgeta" value="{{ isset($widget) ? $widget->slug : old('slug') }}">
                            </div>
                        </div>

                        <div class="form-check form-switch custom-switch-v1 mt-4">
                            <input type="checkbox" class="form-check-input input-success" id="status-swich" name="status" @if (isset($widget) and $widget->status) checked @endif>
                            <label class="form-check-label" for="status-swich"> Status</label>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <h5 class="card-header">Widget Items</h5>
                    <div class="card-body">
                        @if (isset($widget))
                            @livewire('back.marketing.action-group-list', ['group' => $widget->resource, 'list' => $resource_data['items_list'] ?: []])
                        @else
                            @livewire('back.marketing.action-group-list', ['group' => ''])
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">Editor</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="add" id="add-check" name="query_data" {{ (isset($resource_data['query_data']) && $resource_data['query_data'] == 'add') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="add-check"> Add to query </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="replace" id="replace-check" name="query_data" {{ (isset($resource_data['query_data']) && $resource_data['query_data'] == 'replace') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="replace-check"> Replace query </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="text" class="form-control" id="query-input" name="query_string" placeholder="Custom upit u bazu ako je potrebno..." value="{{ isset($resource_data['query']) ? $resource_data['query'] : '' }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <textarea style="visibility: hidden; height: 12px" id="ace-input" name="data"></textarea>
                                <pre id="editor-blade" style="height: 500px; width: 100%;">{{ (isset($data)) ? $data : '' }}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-success my-2">
                            {{ __('Save') }} <i class="ti ti-check ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection


@push('js_after')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.30.0/ace.js" type="text/javascript" charset="utf-8"></script>

    <script>
        var editor = ace.edit("editor-blade");
        editor.setTheme("ace/theme/monokai");
        editor.session.setMode("ace/mode/php_laravel_blade");

        let input = document.getElementById('ace-input');
        editor.getSession().on("change", function () {
            input.value = editor.getSession().getValue();
        });
    </script>

    <script>
        $(() => {
            $('#resource-select').on('change', function (e) {
                Livewire.emit('groupUpdated', e.currentTarget.value);
            });

            Livewire.on('list_full', () => {
                console.log('istina')
                $('#resource-select').attr("disabled", true);
            });
            Livewire.on('list_empty', () => {
                console.log('nije istina')
                $('#resource-select').attr("disabled", false);
            });

            @if (isset($widget) && ! empty($resource_data['items_list']))
            $('#resource-select').attr("disabled", true);
            @endif
        });
    </script>

@endpush
