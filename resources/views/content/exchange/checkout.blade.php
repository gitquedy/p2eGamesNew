@inject('request', 'Illuminate\Http\Request')
@extends('layouts/contentLayoutMaster')

@section('title', 'Checkout')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset('css/base/pages/app-ecommerce.css') }}">
@endsection

@section('content')
<section id="checkout">
  <form action="{{ route('order.store') }}" method="POST" class="form" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="coin_id" value="{{$cart['coin_id']}}" >
    <div class="row">
      <div class="col-md-8 col-sm-12">
        <div class="card">
          <div class="card-header flex-column align-items-start">
            <h4 class="card-title">Billing Details</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <div class="row mb-2"> {{-- input-group --}}
                  <div class="col-12 mt-1 text-left">
                    <label for="eth_address">Wallet Address</label>
                    <input type="text" class="form-control" name="eth_address" placeholder="Metamask Address (0x)" value="{{ $request->user() ? $request->user()->eth_address : '' }}">
                  </div>
                  {{-- <div class="col-sm-4 mt-1 text-center">
                    @if (!Auth::check())
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#quickLoginModal">
                        Sign in
                      </button>
                      <div class="divider">
                          <div class="divider-text">
                          or
                          </div>
                      </div>
                    @endif
                    <show-metamask>
                        {{ $request->user() && $request->user()->eth_address ? 'Switch Account' : 'Connect Metamask' }}
                    </show-metamask>
                  </div> --}}
                </div>

              </div>
            </div>
            <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="mb-2">
                    <label class="form-label" cfor="checkout-apt-number">Full Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Full Name" value="{{ $request->user() ? $request->user()->name : '' }}">
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="mb-2">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" name="phone_number" value="{{ $request->user() ? $request->user()->phone_number : '' }}">
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                  <div class="mb-2">
                    <label class="form-label">Email Address</label>
                    <input type="text" class="form-control" name="email" placeholder="Email Address" value="{{ $request->user() ? $request->user()->email : '' }}">
                  </div>
                </div>

                <div class="col-md-6 col-sm-12">
                  <div class="mb-2">
                    <label class="form-label">Payment Method</label>
                    <select class="form-control select2" name="payment_method_id">
                      @foreach($paymentMethods as $paymentMethod)
                        <option value="{{ $paymentMethod->id }}" data-image="{{ $paymentMethod->imageUrl() }}" data-price="1" {{ $cart['paymentmethod']->id == $paymentMethod->id ? 'selected' : '' }}>{{ $paymentMethod->provider }}</option>
                    @endforeach
                    </select>
                  </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <div class="mb-2">
                  <label class="form-label">Order Notes:</label>
                  <textarea class="form-control" name="notes" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-12">
        <div class="card">
          <div class="card-body">
            <div class="card-header">
              <h4 class="card-title">Your Order</h4>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                  <li>
                    <a data-action="reload" id="refresh"><i data-feather="rotate-cw"></i></a>
                  </li>
                </ul>
              </div>
            </div>
              <div class="coupons input-group input-group-merge px-1">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Coupons"
                  aria-label="Coupons"
                  aria-describedby="input-coupons"
                />
                <span class="input-group-text text-primary ps-1" id="input-coupons">Apply</span>
              </div>
            <hr />
            <div class="table-responsive" id="productTable">
            </div>

            @if($request->user())
              <input type="submit" class="btn btn-primary w-100 place-order btn_save" value="Place Order">
            @endif
          </div>
        </div>
      </div>
    </form>

</section>
<!-- Modal -->
<div class="modal fade" id="quickLoginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form id="quickLogin" class="auth-login-form mt-2" method="POST" action="{{ route('login') }}">
            @csrf
            <input type="hidden" name="redirect" value="back">
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
            <div class="text-center">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('vendor-script')
<script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
@endsection

@section('page-script')
<script type="text/javascript">
  var reload_table = "{{ route('exchange.checkOut') }}";
</script>
<script src ="{{ asset('js/scripts/exchange/checkout.js') }}"></script>
<script type="text/javascript">


</script>

@endsection


