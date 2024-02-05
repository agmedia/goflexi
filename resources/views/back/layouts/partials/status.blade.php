@if(isset($simple) && $simple)
    @if($status)
        <i class="fa fa-fw fa-check text-success"></i>
    @else
        <i class="fa fa-fw fa-times text-danger"></i>
    @endif
@else
    @if($status)
        <span class="badge bg-light-success f-12">Aktivan</span>
    @else
        <span class="badge bg-light-danger f-12">Neaktivan</span>
    @endif
@endif
