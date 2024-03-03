<div class="position-relative">
<ul class="nav nav-pills position-absolute langimg me-0 mb-2" id="{{ $tab_title }}-tab" role="tablist" >
    @foreach(ag_lang() as $lang)
        <li class="nav-item">
            <a class="btn btn-icon btn-sm btn-link-primary ms-2 @if ($lang->code == current_locale()) active @endif" id="{{ $tab_title }}-{{ $lang->code }}-tab" data-bs-toggle="pill" href="#{{ $tab_title }}-{{ $lang->code }}-view" role="tab" aria-controls="{{ $tab_title }}-{{ $lang->code }}-view" aria-selected="true">
                <img src="{{ asset('assets/flags/' . $lang->code . '.png') }}" />
            </a>
        </li>
    @endforeach
</ul>

@if (isset($simple) && $simple)
    <div class="tab-content mb-4" id="{{ $tab_title }}-tabContent">
        @foreach(ag_lang() as $lang)
            <div class="tab-pane fade show @if ($lang->code == current_locale()) active @endif" id="{{ $tab_title }}-{{ $lang->code }}-view" role="tabpanel" aria-labelledby="{{ $tab_title }}-{{ $lang->code }}-tab">
                <div class="form-group">
                    <label class="mb-2" for="{{ $tab_title }}-{{ $lang->code }}">{!! $title !!} </label>

                    <textarea class="js-maxlength form-control" id="{{ $tab_title }}-{{ $lang->code }}" name="{{ $input_name }}[{{ $lang->code }}]" rows="{{ $rows ?: 2 }}" @if($max_length)maxlength="{{ $max_length }}"@endif data-always-show="true" data-placement="top">{!! isset($value->{$lang->code}) ? $value->{$lang->code} : '' !!} </textarea>
                    @if ($max_length)
                        <small class="form-text text-muted">
                            {{ $max_length }} znakova max
                        </small>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="tab-content" id="{{ $tab_title }}-tabContent">
        @foreach(ag_lang() as $lang)
            <div class="tab-pane fade show @if ($lang->code == current_locale()) active @endif" id="{{ $tab_title }}-{{ $lang->code }}-view" role="tabpanel" aria-labelledby="{{ $tab_title }}-{{ $lang->code }}-tab">
                <div class="form-group">
                    <label for="{{ $tab_title }}-{{ $lang->code }}">{!! $title !!} </label>

                    <textarea class="js-maxlength form-control" id="{{ $tab_title }}-{{ $lang->code }}" name="data['{{ $input_name }}'][{{ $lang->code }}]" rows="{{ $rows ?: 2 }}" @if($max_length)maxlength="{{ $max_length }}"@endif data-always-show="true" data-placement="top"></textarea>
                    @if ($max_length)
                        <small class="form-text text-muted">
                            {{ $max_length }} znakova max
                        </small>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif
</div>
