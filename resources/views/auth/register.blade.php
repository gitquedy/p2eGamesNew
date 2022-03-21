@extends('layouts.authLayout')
@section('title', 'Register')
@section('content')
<h4 class="card-title mb-1">
  Adventure starts here 🚀
</h4>
<p class="card-text mb-2">
  Make your app management easy and fun!
</p>
<span>
    <form class="auth-login-form mt-2" method="POST" action="{{ route('register') }}" >
        @csrf
        <div role="group" class="form-group my-1">
            <label for="email" class="d-block">{{ __('Name') }}</label>
            <div>
                <span>
                    <input id="name" name="name" type="text" placeholder="Name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <small class="text-danger">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </span>
            </div>
        </div>
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
                    <input id="password_confirmation" name="password_confirmation" required type="password" placeholder="************" class="form-control-merge form-control @error('password') is-invalid @enderror">
                    @error('password_confirmation')
                        <small class="text-danger">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </span>
            </div>
        </div> 
        <div role="group" class="form-group my-1">
            <div class="custom-control custom-checkbox">
                <input id="register-privacy-policy" type="checkbox" name="agree" class="custom-control-input" value="true" required>
                <label for="register-privacy-policy" class="custom-control-label">
                    I agree to <a href="#" target="_self" class="">privacy policy &amp; terms</a>
                </label>
            </div>
        </div> 
        <button id="register_btn" type="submit" class="btn btn-primary w-100" disabled>{{ __('Register') }}</button>
    </form>
</span> 
<p class="text-center mt-2">
    <span>Already have an account?</span>
    <a href="{{route('login')}}" class="" target="_self">
        <span>&nbsp;Sign in instead</span>
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
</div>
@endsection

@section('scripts')
<script>
    $(document).on('click', "#register-privacy-policy", function() {
        $("#register_btn").attr('disabled', true);
        console.log($(this).is(':checked'));
        if($(this).is(':checked') == true) {
            $("#register_btn").attr('disabled', false);
        }
    });
</script>
@endsection
