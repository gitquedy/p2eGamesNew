@extends('layouts.authLayout')
@section('title', 'Login')
@section('content')
<div class="d-flex bg-white  align-items-center auth-bg px-2 p-lg-5 col-lg-4">
    <div class="px-xl-2 mx-auto col-sm-8 col-md-6 col-lg-12">
        <h2 class="card-title mb-1 font-weight-bold">
            Welcome to P2EGames! 👋
        </h2> 
        <p class="card-text mb-2">
          Please sign-in to your account and start the adventure
        </p> 
        <span>
            <form class="auth-login-form mt-2" method="POST" action="{{ route('login') }}">
                @csrf
                <div role="group" class="form-group my-1">
                    <label for="email" class="d-block">{{ __('E-Mail Address') }}</label>
                    <div>
                        <span>
                            <input id="email" name="email" type="text" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <small class="text-danger">
                                    <strong>{{ $message }}</strong>
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
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </span>
                    </div>
                </fieldset> 
                <fieldset class="form-group my-1">
                    <div class="custom-control custom-checkbox">
                        <input name="remember" id="remember" type="checkbox" class="custom-control-input"  {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="custom-control-label">{{ __('Remember Me') }}</label>
                    </div>
                </fieldset> 
                <button type="submit" class="btn btn-primary w-100">{{ __('Login') }}</button>
            </form>
        </span> 
        <p class="card-text text-center mt-2">
            <span>New on our platform? </span>
            <a href="{{ route('register') }}" class="" target="_self">
                <span>&nbsp;Create an account</span>
            </a>
        </p> 
        <div class="divider my-2">
            <div class="divider-text">
            or
            </div>
        </div>
        <div class="auth-footer-btn d-flex justify-content-center">
            <button class="btn btn-secondary w-100">
                <metamask-login />
            </button>
            {{-- <a href="javascript:void(0)" target="_self" class="btn btn-facebook">
                <svg xmlns="http://www.w3.org/2000/svg" width="14px" height="14px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
            </a> 
            <a href="javascript:void(0)" target="_self" class="btn btn-twitter">
                <svg xmlns="http://www.w3.org/2000/svg" width="14px" height="14px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
            </a>
            <a href="javascript:void(0)" target="_self" class="btn btn-google">
                <svg xmlns="http://www.w3.org/2000/svg" width="14px" height="14px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            </a> 
            <a href="javascript:void(0)" target="_self" class="btn btn-github"><svg xmlns="http://www.w3.org/2000/svg" width="14px" height="14px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
            </a> --}}
        </div>
    </div>
</div>
@endsection
