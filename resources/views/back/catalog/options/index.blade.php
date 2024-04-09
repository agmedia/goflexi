@extends('back.layouts.admin')

@push('css_before')
@endpush

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-header-title">
                        <h2 class="mb-0">{{ __('back/options.title') }}</h2>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('options.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus f-18"></i> {{ __('back/options.write_new') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @include('back.layouts.partials.session')

        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th class="text-left">{{ __('back/action.title') }}</th>
                        <th>{{ __('back/options.title_value') }}</th>
                        <th class="text-center font-size-sm">{{ __('back/options.title_featured') }}</th>
                        <th class="text-center font-size-sm">{{ __('back/action.status') }}</th>
                        <th class="text-right" style="width: 10%;">{{ __('back/action.edit') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($options as $option)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td class="font-size-sm">
                                <a class="font-w600" href="{{ route('options.edit', ['option' => $option]) }}">{{ $option->title }}</a>
                            </td>
                            <td class="font-size-sm">{{ $option->price }}</td>
                            <td class="text-center font-size-sm">
                                @include('back.layouts.partials.status', ['status' => $option->featured, 'simple' => true])
                            </td>
                            <td class="text-center font-size-sm">
                                @include('back.layouts.partials.status', ['status' => $option->status, 'simple' => true])
                            </td>
                            <td class="text-right font-size-sm">
                                <a class="btn btn-sm btn-alt-secondary" href="{{ route('options.edit', ['option' => $option]) }}">
                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                </a>
                                <button class="btn btn-sm btn-alt-danger" onclick="event.preventDefault(); deleteItem({{ $option->id }}, '{{ route('options.destroy.api') }}');"><i class="fa fa-fw fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="font-size-sm text-center" colspan="6">
                                <label for="">{{ __('back/options.no_options') }}</label>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{ $options->links() }}
        </div>
    </div>

@endsection

@push('js_after')
@endpush
