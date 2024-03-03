@extends('back.layouts.admin')

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">FAQ Edit</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @include('back.layouts.partials.session')

        <div class="col-md-12">
            <div class="card table-card">
                <div class="card-body">

                    <form action="{{ isset($faq) ? route('faqs.update', ['faq' => $faq]) : route('faqs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (isset($faq))
                            {{ method_field('PATCH') }}
                        @endif

                        <div class="row justify-content-center mb-2 mt-5">
                            <div class="col-md-10 position-relative mb-3">
                                @include('back.layouts.translations.input', [
                                            'title' => 'Question',
                                            'tab_title' => 'title-input',
                                            'input_name' => 'title',
                                            'value' => isset($faq) ? $faq->translation($lang->code)->title : old('title.*')
                                            ])
                            </div>
                            <div class="col-md-10 position-relative">
                                @include('back.layouts.translations.textarea', [
                                                    'title' => 'Answer',
                                                    'tab_title' => 'input-description',
                                                    'input_name' => 'description',
                                                    'rows' => 4,
                                                    'max_length' => 0,
                                                    'simple' => 1,
                                                    'value' => isset($faq) ? $faq->translation($lang->code)->description : old('description.*')
                                                    ])
                            </div>
                        </div>

                        <div class="row justify-content-center push mb-3">
                            <div class="col-md-5">
                                <button type="submit" class="btn btn-success my-2">
                                    {{ __('Save') }} <i class="ti ti-check ml-1"></i>
                                </button>
                            </div>
                            <div class="col-md-5 text-end">
                                @if (isset($faq))
                                    <a href="{{ route('faqs.destroy', ['faq' => $faq]) }}" type="submit" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-faq-form{{ $faq->id }}').submit();">
                                        {{ __('Delete') }} <i class="ti ti-trash ml-1"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    @if (isset($faq))
                        <form id="delete-faq-form{{ $faq->id }}" action="{{ route('faqs.destroy', ['faq' => $faq]) }}" method="POST" style="display: none;">
                            @csrf
                            {{ method_field('DELETE') }}
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_after')
    <script>
        $(() => {
            {!! ag_lang() !!}.forEach(function(item) {
                ClassicEditor.create(document.querySelector('#description-editor-' + item.code))
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });
            });

        })
    </script>
@endpush
