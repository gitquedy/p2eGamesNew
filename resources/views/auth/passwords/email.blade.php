@extends('layouts.authLayout')
@section('title', 'Forgot Password')
@section('content')
<h4 class="card-title mb-1">
  Forgot Password? 🔒
</h4>
<p class="card-text mb-2">
  Enter your email and we'll send you instructions to reset your password
</p>
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
<span>
    <form class="auth-login-form mt-2" method="POST" action="{{ route('password.email') }}">
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
        <button type="submit" class="btn btn-primary w-100">{{ __('Send Password Reset Link') }}</button>
    </form>
</span> 
<p class="text-center mt-2">
    <a href="{{ route('login') }}" class="" target="_self">
        <svg xmlns="http://www.w3.org/2000/svg" width="14px" height="14px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg> Back to login
  </a>
</p>
@endsection
