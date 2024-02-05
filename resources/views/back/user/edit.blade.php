@extends('back.layouts.admin')

@push('css_before')
@endpush

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">User Edit</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @include('back.layouts.partials.session')

        <div class="col-md-12">
            <form action="{{ isset($user) ? route('users.update', ['user' => $user]) : route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($user))
                    {{ method_field('PATCH') }}
                @endif

                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <a class="btn btn-light" href="{{ route('users') }}">
                            <i class="fa fa-arrow-left mr-1"></i> {{ __('back/user.back') }}
                        </a>
                        <div class="block-options">
                            <div class="custom-control custom-switch custom-control-success">
                                <input type="checkbox" class="custom-control-input" id="switch-status" name="status" {{ (isset($user->detail->status) and $user->detail->status) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="switch-status">{{ __('back/user.publish') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="block-content">
                        <h2 class="content-heading pt-0">
                            <i class="fa fa-fw fa-user-circle text-muted mr-1"></i> {{ __('back/user.user_profile') }}
                        </h2>
                        <div class="row push">
                            <div class="col-lg-4">
                                <p class="text-muted">
                                    {{ __('back/user.user_profile_label') }}
                                </p>
                            </div>
                            <div class="col-lg-8 col-xl-5">
                                <div class="form-group">
                                    <label for="input-username">{{ __('back/user.user_name') }}</label>
                                    <input type="text" class="form-control" id="input-username" name="username" placeholder="" value="{{ isset($user) ? $user->name : old('username') }}">
                                </div>

                                <div class="form-group">
                                    <label for="input-email">{{ __('back/user.email') }}</label>
                                    <input type="email" class="form-control" id="input-email" name="email" placeholder="" value="{{ isset($user) ? $user->email : old('email') }}">
                                </div>

                                <div class="form-group">
                                    <label for="input-phone">{{ __('back/user.user_phone') }}</label>
                                    <input type="text" class="form-control" id="input-phone" name="phone" placeholder="" value="{{ isset($user->detail->phone) ? $user->detail->phone : old('phone') }}">
                                </div>
                            </div>
                        </div>

                        @if (auth()->user()->can('*'))
                            <h2 class="content-heading pt-0">
                                <i class="fa fa-fw fa-asterisk text-muted mr-1"></i> Promjena lozinke
                            </h2>
                            <div class="row push">
                                <div class="col-lg-4">
                                    <p class="text-muted">
                                        Resetirajte lozinku kupca
                                    </p>
                                </div>
                                <div class="col-lg-8 col-xl-5">
                                    <div class="form-group">
                                        <label for="input-old-password">Trenutna lozinka</label>
                                        <input type="password" class="form-control" id="input-old-password" name="old_password">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <label for="dm-profile-edit-password-new">Nova lozinka</label>
                                            <input type="password" class="form-control" id="input-password" name="password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <label for="dm-profile-edit-password-new-confirm">Potvrdite novu lozinku</label>
                                            <input type="password" class="form-control" id="input-password-confirmation" name="password_confirmation">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <h2 class="content-heading pt-0">
                            <i class="fa fa-fw fa-user-circle text-muted mr-1"></i> {{ __('back/user.user_shipping_address') }}
                        </h2>
                        <div class="row push">
                            <div class="col-lg-4">
                                <p class="text-muted">{{ __('back/user.user_shipping_address_label') }}
                                </p>
                            </div>
                            <div class="col-lg-8 col-xl-5">
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label for="input-fname">{{ __('back/user.user_first_name') }}</label>
                                        <input type="text" class="form-control" id="input-fname" name="fname" value="{{ isset($user) ? $user->detail->fname : old('fname') }}">
                                    </div>
                                    <div class="col-6">
                                        <label for="input-lname">{{ __('back/user.user_last_name') }}</label>
                                        <input type="text" class="form-control" id="input-lname" name="lname" value="{{ isset($user) ? $user->detail->lname : old('lname') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-address">{{ __('back/user.user_address') }}</label>
                                    <input type="text" class="form-control" id="input-address" name="address" value="{{ isset($user) ? $user->detail->address : old('address') }}">
                                </div>
                                <div class="form-group">
                                    <label for="input-city">{{ __('back/user.user_city') }}</label>
                                    <input type="text" class="form-control" id="input-city" name="city" value="{{ isset($user) ? $user->detail->city : old('city') }}">
                                </div>
                                <div class="form-group">
                                    <label for="input-zip">{{ __('back/user.user_zip') }}</label>
                                    <input type="text" class="form-control" id="input-zip" name="zip" value="{{ isset($user) ? $user->detail->zip : old('zip') }}">
                                </div>
                                <div class="form-group">
                                    <label for="input-state">{{ __('back/user.user_country') }}</label>
                                    <input type="text" class="form-control" id="input-state" name="state" value="{{ isset($user) ? $user->detail->state : old('state') }}">
                                </div>
                            </div>
                        </div>

                        <h2 class="content-heading pt-0">
                            <i class="fa fa-fw fa-user-circle text-muted mr-1"></i> {{ __('back/user.user_role_change') }}
                        </h2>
                        <div class="row push">
                            <div class="col-lg-4">
                                <p class="text-muted">{{ __('back/user.user_role_label') }}
                                </p>
                            </div>
                            <div class="col-lg-8 col-xl-5">
                                <div class="form-group row">
                                    <label for="price-input">{{ __('back/user.user_role') }}</label>
                                    <select class="js-select2 form-control" id="role-select" name="role" style="width: 100%;" data-placeholder="{{ __('back/user.user_role_select') }}">
                                        <option></option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" {{ ((isset($user)) and ($user->detail->role == $role->name)) ? 'selected' : '' }}>{{ $role->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-content bg-body-light">
                        <div class="row justify-content-center push">
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-hero-success my-2">
                                    <i class="fas fa-save mr-1"></i> {{ __('back/user.save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('js_after')

    <script>
        $(() => {

        });
    </script>
@endpush
