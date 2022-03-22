@extends('layouts.authLayout')
@section('title', 'Login')
@section('content')
<h4 class="card-title mb-1">
    Welcome to P2E Gmaes PH! 👋
</h4>
<p class="card-text mb-2">
    Please sign-in to your account and start the adventure
</p> <span>
    <form class="auth-login-form mt-2" method="POST" action="{{ route('login') }}">
        @csrf
        <div role="group" class="form-group my-1">
            <label for="email" class="d-block">{{ __('E-Mail Address') }}</label>
            <div>
                <span>
                    <input id="email" name="email" type="text" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </span>
            </div>
        </div>
        <fieldset class="form-group my-1">
            <div>
                <div class="d-flex justify-content-between">
                    <label for="login-password">{{ __('Password') }}</label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="" target="_self">
                        <small>{{ __('Forgot Your Password?') }}</small>
                    </a>
                    @endif
                </div> 
                <span>
                    <div role="group" class="input-group input-group-merge">
                        <input id="password" name="password" required autocomplete="current-password" type="password" placeholder="Password" class="form-control-merge form-control @error('password') is-invalid @enderror">
                    </div> 
                    @error('password')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </span>
            </div>
        </fieldset> 
        <fieldset class="form-group my-1">
            <div class="form-check custom-checkbox">
                <input name="remember" id="remember" type="checkbox" class="form-check-input"  {{ old('remember') ? 'checked' : '' }}>
                <label for="remember" class="form-check-label">{{ __('Remember Me') }}</label>
            </div>
        </fieldset> 
        <button type="submit" class="btn btn-primary w-100">{{ __('Login') }}</button>
    </form>
</span>
<p class="card-text text-center mt-2">
    <span>New on our platform? </span>
    <a href="{{ route('register') }}" class="" target="_self">
        <span>Create an account</span>
    </a>
</p>
<div class="divider my-2">
    <div class="divider-text">
        or
    </div>
</div>
<div class="auth-footer-btn d-flex justify-content-center">
    <button class="btn bg-metamask text-light w-100">
        <metamask-login />
    </button>
</div>
@endsection
