@extends('layouts.authLayout')
@section('title', 'Reset Password')
@section('content')
<div class="px-xl-2 mx-auto col-sm-8 col-md-6 col-lg-12">
    <h4 class="card-title mb-1">
      Reset Password? 🔒
    </h4>
    <p class="card-text mb-2">
      Enter your email and new password
    </p>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <span>
        <form class="auth-login-form mt-2" method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
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
            <div role="group" class="form-group my-1">
                <label for="login-password">{{ __('Password') }}</label>
                <div> 
                    <span>
                        <input id="password" name="password" required type="password" placeholder="************" class="form-control-merge form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <small class="text-danger">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </span>
                </div>
            </div> 
            <div role="group" class="form-group my-1">
                <label for="login-password">{{ __('Confirm Password') }}</label>
                <div> 
                    <span>
                        <input id="password" name="password_confirmation" required type="password" placeholder="************" class="form-control-merge form-control @error('password') is-invalid @enderror">
                        @error('password_confirmation')
                            <small class="text-danger">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </span>
                </div>
            </div> 
            <button type="submit" class="btn btn-primary w-100">{{ __('Reset Password') }}</button>
        </form>
    </span> 
</div>
@endsection
