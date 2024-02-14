@extends('back.layouts.admin')

@push('css_before')
@endpush

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-4">Page</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <form action="{{ isset($page) ? route('page.update', ['page' => $page]) : route('page.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @if (isset($page))
            {{ method_field('PATCH') }}
        @endif
        <div class="row">
            @include('back.layouts.partials.session')
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Generel Info</h5>
                    <div class="card-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            @foreach(ag_lang() as $lang)
                                <li class="nav-item">
                                    <a class="nav-link @if ($lang->code == current_locale()) active @endif" id="pills-{{ $lang->code }}-tab" data-bs-toggle="pill" href="#pills-{{ $lang->code }}" role="tab" aria-controls="pills-{{ $lang->code }}" aria-selected="true">
                                        <img src="{{ asset('assets/flags/' . $lang->code . '.png') }}" />
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            @foreach(ag_lang() as $lang)
                                <div class="tab-pane fade show @if ($lang->code == current_locale()) active @endif" id="pills-{{ $lang->code }}" role="tabpanel" aria-labelledby="pills-{{ $lang->code }}-tab">
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <label for="title-{{ $lang->code }}">Title @include('back.layouts.partials.required')</label>
                                            <input type="text" class="form-control" id="title-{{ $lang->code }}" name="title[{{ $lang->code }}]" placeholder="{{ $lang->code }}" value="{{ isset($page) ? $page->translation($lang->code)->title : old('title.*') }}" />
                                        </div>
                                        <div class="col-12 mt-5">
                                            <label for="short-description-{{ $lang->code }}">Short Description</label>
                                            <textarea id="short-description-{{ $lang->code }}" class="form-control" rows="4" name="short_description[{{ $lang->code }}]" placeholder="{{ $lang->code }}">{{ isset($page) ? $page->translation($lang->code)->short_description : old('short_description.*') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Page Setup</h5>
                    <div class="card-body">
                        <div class="form-group row mb-5">
                            <div class="col-md-6">
                                <label for="page-group-select">Select Page Group</label>
                                <select class="form-control" name="page_group" id="page-group-select">
                                    <option value="">Choose a group</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ ag_slug($group) }}" @if (isset($page) and $page->group == $group) selected @endif>{{ ag_slug()->ucFirst($group) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="new-page-group-input">Or enter a new one</label>
                                <input type="text" class="form-control" id="new-page-group-input" name="new_page_group" placeholder="Enter new page group..." />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 pt-3 text-end">
                                <label for="publish-date">Publish date</label>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group date">
                                    <input type="text" class="form-control" placeholder="Enter publish date if needed..." id="publish-date" name="publish_date" value="{{ isset($page) ? ag_date($page->publish_date)->format('m/d/Y') : old('publish_date') }}" />
                                    <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 mt-4 mb-3 m-l-20">
                                <div class="form-check form-switch custom-switch-v1">
                                    <input type="checkbox" class="form-check-input input-success" id="status-swich" name="status" @if (isset($page) and $page->status) checked @endif>
                                    <label class="form-check-label" for="status-swich"> Status</label>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4 mb-2 m-l-20">
                                <div class="form-check form-switch custom-switch-v1">
                                    <input type="checkbox" class="form-check-input input-success" id="featured-swich" name="featured" @if (isset($page) and $page->featured) checked @endif>
                                    <label class="form-check-label" for="featured-swich"> Featured</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">Page Content</h5>
                    <div class="card-body">
                        <ul class="nav nav-pills mb-3" id="desc-tab" role="tablist">
                            @foreach(ag_lang() as $lang)
                                <li class="nav-item">
                                    <a class="nav-link @if ($lang->code == current_locale()) active @endif" id="desc-{{ $lang->code }}-tab" data-bs-toggle="pill" href="#desc-{{ $lang->code }}" role="tab" aria-controls="desc-{{ $lang->code }}" aria-selected="true">
                                        <img src="{{ asset('assets/flags/' . $lang->code . '.png') }}" />
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content" id="desc-tabContent">
                            @foreach(ag_lang() as $lang)
                                <div class="tab-pane fade show @if ($lang->code == current_locale()) active @endif" id="desc-{{ $lang->code }}" role="tabpanel" aria-labelledby="desc-{{ $lang->code }}-tab">
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <label for="description-{{ $lang->code }}">Description</label>
                                            <textarea id="description-{{ $lang->code }}" class="form-control" data-always-show="true" name="description[{{ $lang->code }}]" placeholder="{{ $lang->code }}" data-placement="top">{{ isset($page) ? $page->translation($lang->code)->description : old('description.*') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">Page SEO</h5>
                    <div class="card-body">
                        <ul class="nav nav-pills mb-3" id="seo-tab" role="tablist">
                            @foreach(ag_lang() as $lang)
                                <li class="nav-item">
                                    <a class="nav-link @if ($lang->code == current_locale()) active @endif" id="seo-{{ $lang->code }}-tab" data-bs-toggle="pill" href="#seo-{{ $lang->code }}" role="tab" aria-controls="seo-{{ $lang->code }}" aria-selected="true">
                                        <img src="{{ asset('assets/flags/' . $lang->code . '.png') }}" />
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content" id="seo-tabContent">
                            @foreach(ag_lang() as $lang)
                                <div class="tab-pane fade show @if ($lang->code == current_locale()) active @endif" id="seo-{{ $lang->code }}" role="tabpanel" aria-labelledby="seo-{{ $lang->code }}-tab">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label for="meta-title-{{ $lang->code }}">Meta Title</label>
                                                    <input type="text" class="form-control" id="meta-title-{{ $lang->code }}" name="meta_title[{{ $lang->code }}]" placeholder="{{ $lang->code }}" value="{{ isset($page) ? $page->translation($lang->code)->meta_title : old('meta_title.*') }}" />
                                                </div>
                                                <div class="col-12 mt-5">
                                                    <label for="meta-description-{{ $lang->code }}">Meta Description</label>
                                                    <textarea id="meta-description-{{ $lang->code }}" class="form-control" rows="4" data-always-show="true" name="meta_description[{{ $lang->code }}]" placeholder="{{ $lang->code }}" data-placement="top">{{ isset($page) ? $page->translation($lang->code)->meta_description : old('meta_description.*') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label for="slug-{{ $lang->code }}">SEO Slug <small class="m-l-30 fw-light">Best leave it alone on auto update by title</small></label>
                                                    <input type="text" class="form-control" id="slug-{{ $lang->code }}" name="slug[{{ $lang->code }}]" placeholder="{{ $lang->code }}" value="{{ isset($page) ? $page->translation($lang->code)->slug : old('slug.*') }}" />
                                                </div>
                                                <div class="col-12 mt-5">
                                                    <label for="keywords-{{ $lang->code }}">Keywords <small class="m-l-30 fw-light">Up to 5 keyword for each language</small></label>
                                                    <input class="form-control" id="keywords-{{ $lang->code }}" type="text" name="keywords[{{ $lang->code }}]" value="{{ isset($page) ? $page->translation($lang->code)->keywords : old('keywords.*') }}" placeholder="Enter something {{ $lang->code }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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

    <script>
        $(() => {
            {!! ag_lang() !!}.forEach(function(item) {
                ClassicEditor
                .create(document.querySelector('#description-' + item.code))
                .then(editor => {
                    editor.rows = 4;
                })
                .catch(error => {
                    //console.error(error);
                });

                new Choices('#keywords-' + item.code, {
                    delimiter: ',',
                    editItems: true,
                    maxItemCount: 5,
                    removeItemButton: true
                });
            });

            let singleNoSearch = new Choices('#page-group-select', {
                searchEnabled: false,
                removeItemButton: true
            });

            let start_date = new Datepicker(document.querySelector('#publish-date'), {
                buttonClass: 'btn'
            });

            /*singleNoSearch.passedElement.element.addEventListener('change', function (e) {
                console.log(e, e.detail.value);
            });*/
        });
    </script>

@endpush
