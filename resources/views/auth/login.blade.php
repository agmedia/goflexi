@extends('back.layouts.auth')

@section('content')

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <h4 class="text-center f-w-500 my-3">Login with your email</h4>
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email">
        </div>
        <div class="form-group mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Lozinka">
        </div>
        <div class="d-flex mt-1 justify-content-between align-items-center">
            <div class="form-check">
                <input class="form-check-input input-primary" name="remember" type="checkbox" id="remember" checked="">
                <label class="form-check-label text-muted" for="remember">{{ __('Zapamti me') }}</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    <h6 class="text-secondary f-w-400 mb-0">{{ __('Zaboravili ste lozinku?') }}</h6>
                </a>
            @endif
        </div>
        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
        <div class="d-flex justify-content-between align-items-end mt-4">
            <h6 class="f-w-500 mb-0">Nemate račun?</h6>
            <a href="{{ route('register') }}" class="link-primary">{{ __('Registrirajte se') }}</a>
        </div>
    </form>

@endsection
