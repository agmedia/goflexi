@extends('back.layouts.auth')

@section('content')

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <h4 class="text-center f-w-500 my-3">Sign up with your work email.</h4>

        <div class="form-group mb-3">
            <input type="text" class="form-control" id="name" name="name" placeholder="Korisničko ime" value="{{ old('name') }}">
        </div>
        <div class="form-group mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
        </div>
        <div class="form-group mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Lozinka">
        </div>
        <div class="form-group mb-3">
            <input type="password" class="form-control" id="password-confirmation" name="password_confirmation" placeholder="Potvrdite Lozinku">
        </div>
        <div class="d-flex mt-1 justify-content-between">
            <div class="form-check">
                <input class="form-check-input input-primary" name="terms" type="checkbox" id="terms" checked="">
                <label class="form-check-label text-muted" for="terms">Slažem se sa svim...</label>
            </div>
        </div>
        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary">{{ __('Registrirajte se') }}</button>
        </div>
        <div class="d-flex justify-content-between align-items-end mt-4">
            <h6 class="f-w-500 mb-0">Već ste registrani?</h6>
            <a href="{{ route('login') }}" class="link-primary">Prijavite se</a>
        </div>
    </form>

@endsection
