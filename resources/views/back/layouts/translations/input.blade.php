<div class="position-relative">
<ul class="nav nav-pills position-absolute langimg mb-2 me-0" id="{{ $tab_title }}-tab" role="tablist" >


    @foreach(ag_lang() as $lang)
        <li class="nav-item">
            <a class="btn btn-icon btn-sm btn-link-primary ms-2  @if ($lang->code == current_locale()) active @endif" id="{{ $tab_title }}-{{ $lang->code }}-tab" data-bs-toggle="pill" href="#{{ $tab_title }}-{{ $lang->code }}-view" role="tab" aria-controls="{{ $tab_title }}-{{ $lang->code }}-view" aria-selected="true">
                <img src="{{ asset('assets/flags/' . $lang->code . '.png') }}" />
            </a>
        </li>
    @endforeach
</ul>

<div class="tab-content mb-4" id="{{ $tab_title }}-tabContent">
    @foreach(ag_lang() as $lang)
        <div class="tab-pane fade show @if ($lang->code == current_locale()) active @endif" id="{{ $tab_title }}-{{ $lang->code }}-view" role="tabpanel" aria-labelledby="{{ $tab_title }}-{{ $lang->code }}-tab">
            <div class="form-group">
                <label  class="mb-2" for="{{ $tab_title }}-{{ $lang->code }}">{!! $title !!} </label>
                <input type="text" class="form-control" id="{{ $tab_title }}-{{ $lang->code }}" name="{{ $input_name }}[{{ $lang->code }}]" placeholder="{{ $lang->code }}" @if(isset($value) && ! empty($value)) value="{{ $value->{$lang->code} }}" @endif>



            </div>
        </div>
    @endforeach
</div>
</div>
