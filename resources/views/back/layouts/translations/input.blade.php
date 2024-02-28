<ul class="nav nav-pills position-absolute langimg me-2" id="{{ $tab_title }}-tab" role="tablist" >
    @foreach(ag_lang() as $lang)
        <li class="nav-item">
            <a class="btn btn-icon btn-sm btn-link-primary me-1  @if ($lang->code == current_locale()) active @endif" id="{{ $tab_title }}-{{ $lang->code }}-tab" data-bs-toggle="pill" href="#{{ $tab_title }}-{{ $lang->code }}-view" role="tab" aria-controls="{{ $tab_title }}-{{ $lang->code }}-view" aria-selected="true">
                <img src="{{ asset('assets/flags/' . $lang->code . '.png') }}" />
            </a>
        </li>
    @endforeach
</ul>

<div class="tab-content" id="{{ $tab_title }}-tabContent">
    @foreach(ag_lang() as $lang)
        <div class="tab-pane fade show @if ($lang->code == current_locale()) active @endif" id="{{ $tab_title }}-{{ $lang->code }}-view" role="tabpanel" aria-labelledby="{{ $tab_title }}-{{ $lang->code }}-tab">
            <div class="form-group">
                <label for="{{ $tab_title }}-{{ $lang->code }}">{!! $title !!} </label>
                <input type="text" class="form-control" id="{{ $tab_title }}-{{ $lang->code }}" name="{{ $input_name }}[{{ $lang->code }}]" placeholder="{{ $lang->code }}" @if(isset($value) && ! empty($value)) value="{{ $value->{$lang->code} }}" @endif>
            </div>
        </div>
    @endforeach
</div>