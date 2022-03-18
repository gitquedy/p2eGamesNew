@extends('layouts/contentLayoutMaster')

@section('title', 'Account')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel='stylesheet' href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
  <link rel='stylesheet' href="{{ asset('vendors/css/animate/animate.min.css') }}">
  <link rel='stylesheet' href="{{ asset('vendors/css/extensions/sweetalert2.min.css') }}">
@endsection
@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-sweet-alerts.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-validation.css') }}">
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
      <!-- Account -->
      <li class="nav-item" role="presentation">
        <button class="nav-link {{ ($errors->has('old_password') || $errors->has('password') || $errors->has('password_confirmation')) ? '' : 'active' }}" id="pills-account-tab" data-bs-toggle="pill" data-bs-target="#pills-account" type="button" role="tab">
          <i data-feather="user" class="font-medium-3 me-50"></i>
          <span class="fw-bold">Account</span>
        </button>
      </li>
      <!-- security -->
      <li class="nav-item" role="presentation">
        <button class="nav-link {{ ($errors->has('old_password') || $errors->has('password') || $errors->has('password_confirmation')) ? 'active' : '' }}" id="pills-security-tab" data-bs-toggle="pill" data-bs-target="#pills-security" role="tab">
          <i data-feather="lock" class="font-medium-3 me-50"></i>
          <span class="fw-bold">Security</span>
        </button>
      </li>
      <!-- connection -->
      {{-- <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-connections-tab" data-bs-toggle="pill" data-bs-target="#pills-connections" role="tab">
          <i data-feather="link" class="font-medium-3 me-50"></i>
          <span class="fw-bold">Connections</span>
        </button>
      </li> --}}
    </ul>



    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade {{ ($errors->has('old_password') || $errors->has('password') || $errors->has('password_confirmation')) ? '' : 'show active' }}" id="pills-account" role="tabpanel" aria-labelledby="pills-account-tab">
            <!-- profile -->
            <div class="card">
              <div class="card-header border-bottom">
                <h4 class="card-title">Profile Details</h4>
              </div>
              <div class="card-body py-2 my-25">
                <!-- form -->
                <form class="auth-login-form mt-2" method="POST" action="{{ route('profile.update', 'account') }}" enctype="multipart/form-data">
                  @csrf
                  <!-- header section -->
                  <div class="d-flex">
                    <a href="#" class="me-25">
                      <img
                        src="{{Auth::user()->profileUrl()}}"
                        id="account-upload-img"
                        class="uploadedAvatar rounded-circle me-50"
                        alt="profile image"
                        height="100"
                        width="100"
                      />
                    </a>
                    <!-- upload and reset button -->
                    <div class="d-flex align-items-end mt-75 ms-1">
                      <div>
                        <label for="account-upload" class="btn btn-sm btn-primary mb-75 me-75">Upload</label>
                        <input type="file" id="account-upload" name="picture" hidden accept="image/*" onchange="readURL(this)"/>
                        <button type="button" id="account-reset" class="btn btn-sm btn-outline-secondary mb-75" data-original="{{Auth::user()->profileUrl()}}">Reset</button>
                        <p class="mb-0">Allowed file types: png, jpg, jpeg.</p>
                      </div>
                    </div>
                    <!--/ upload and reset button -->
                  </div>
                  <!--/ header section -->
                  <div class="row">
                    <div class="col-12 col-sm-6 mb-1">
                      <label class="form-label" for="accountName">Name</label>
                      <input
                        type="text"
                        class="form-control"
                        id="accountName"
                        name="name"
                        placeholder="Name"
                        value="{{old('name')?old('name'):Auth::user()->name}}"
                        data-msg="Please enter Name"
                      />
                      @error('name')
                          <small class="text-danger">
                              <strong>{{ $message }}</strong>
                          </small>
                      @enderror
                    </div>
                    <div class="col-12 col-sm-6 mb-1">
                      <label class="form-label" for="accountEmail">Email</label>
                      <input
                        type="email"
                        class="form-control"
                        id="accountEmail"
                        name="email"
                        placeholder="Email"
                        value="{{old('email')?old('email'):Auth::user()->email}}"
                      />
                      @error('email')
                          <small class="text-danger">
                              <strong>{{ $message }}</strong>
                          </small>
                      @enderror
                    </div>
                    <div class="col-12 col-sm-6 mb-1">
                      <label class="form-label" for="accountPhoneNumber">Phone Number</label>
                      <input
                        type="text"
                        class="form-control account-number-mask"
                        id="accountPhoneNumber"
                        name="phone_number"
                        placeholder="Phone Number"
                        value="{{old('phone_number')?old('phone_number'):Auth::user()->phone_number}}"
                      />
                      @error('phone_number')
                          <small class="text-danger">
                              <strong>{{ $message }}</strong>
                          </small>
                      @enderror
                    </div>
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary mt-1 me-1">Save changes</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
      </div>
      <div class="tab-pane fade {{ ($errors->has('old_password') || $errors->has('password') || $errors->has('password_confirmation')) ? 'show active' : '' }}" id="pills-security" role="tabpanel" aria-labelledby="pills-security-tab">
        <!-- security -->
            <div class="card">
              <div class="card-header border-bottom">
                <h4 class="card-title">Security Details</h4>
              </div>
              <div class="card-body py-2 my-25">
                <form class="auth-login-form mt-2" method="POST" action="{{ route('profile.update', 'password') }}" >
                  @csrf
                  <div role="group" class="form-group my-1">
                      <label for="login-password">{{ __('Old Password') }}</label>
                      <div> 
                          <span>
                              <input id="old_password" name="old_password" required type="password" placeholder="************" class="form-control-merge form-control @error('old_password') is-invalid @enderror">
                              @error('old_password')
                                  <small class="text-danger">
                                      <strong>{{ $message }}</strong>
                                  </small>
                              @enderror
                          </span>
                      </div>
                  </div> 
                  <hr>
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
                  <button type="submit" class="btn btn-primary mt-1 me-1">Change Password</button>
                </form>
              </div>
            </div>
      </div>
      <div class="tab-pane fade" id="pills-connections" role="tabpanel" aria-labelledby="pills-connections-tab">
        <!-- connections -->
            <div class="card">
              <div class="card-header border-bottom">
                <h4 class="card-title">Connections Details</h4>
              </div>
              <div class="card-body py-2 my-25">
                <form class="auth-login-form mt-2" method="POST" action="{{ route('profile.update', 'connections') }}" >
                  @csrf
                </form>
              </div>
            </div>
      </div>
    </div>



    <!-- deactivate account  -->
    {{-- <div class="card">
      <div class="card-header border-bottom">
        <h4 class="card-title">Delete Account</h4>
      </div>
      <div class="card-body py-2 my-25">
        <div class="alert alert-warning">
          <h4 class="alert-heading">Are you sure you want to delete your account?</h4>
          <div class="alert-body fw-normal">
            Once you delete your account, there is no going back. Please be certain.
          </div>
        </div>

        <form id="formAccountDeactivation" class="validate-form" onsubmit="return false">
          <div class="form-check">
            <input
              class="form-check-input"
              type="checkbox"
              name="accountActivation"
              id="accountActivation"
              data-msg="Please confirm you want to delete account"
            />
            <label class="form-check-label font-small-3" for="accountActivation">
              I confirm my account deactivation
            </label>
          </div>
          <div>
            <button type="submit" class="btn btn-danger deactivate-account mt-1">Deactivate Account</button>
          </div>
        </form>
      </div>
    </div> --}}
    <!--/ profile -->
  </div>
</div>
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
  <script src="{{ asset('vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/cleave/cleave.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/cleave/addons/cleave-phone.us.js') }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset('js/scripts/pages/page-account-settings-account.js') }}"></script>
@endsection
@section('scripts')
<script>
  $("#account-reset").click(function(){ 
    alert("test");
  });


  function readURL(input, showTarget = "account-upload-img") {
            var file = input.files[0];
            if (file.type != "image/jpeg" && file.type != "image/png") {
                input.value = '';
                alert('Please only select images in JPG- or PNG-format.');
                return;
            }

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#'+showTarget).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>
@endsection
