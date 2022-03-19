@extends('layouts.authLayout')
@section('title', 'Confirm Password')
@section('content')
<div class="px-xl-2 mx-auto col-sm-8 col-md-6 col-lg-12">
    <h4 class="card-title mb-1">
      {{ __('Confirm Password') }} 🔒
    </h4>
    <p class="card-text mb-2">
        {{ __('Please confirm your password before continuing.') }}
    </p>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <span>
        <form class="auth-login-form mt-2" method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <div role="group" class="form-group my-1">
                <label for="login-password">{{ __('Password') }}</label>
                <fieldset class="form-group my-1" id="">
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
            </div> 
            <button type="submit" class="btn btn-primary w-100">{{ __('Confirm Password') }}</button>
        </form>
    </span> 
</div>
@endsection
