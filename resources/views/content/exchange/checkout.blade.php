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
  @if ($cart['transaction'] == "buy")
    <form action="{{ route('order.store') }}" method="POST" class="form" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="coin_id" value="{{$cart['coin_id']}}" >
      <input type="hidden" name="transaction" value="{{$cart['transaction']}}" >
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
      </div>
    </form>
  @elseif($cart['transaction'] == "sell")
  <form action="{{ route('order.store') }}" method="POST" class="form" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="coin_id" value="{{$cart['coin_id']}}" >
      <input type="hidden" name="transaction" value="{{$cart['transaction']}}" >
      <div class="row">
        <div class="col-md-8 col-sm-12">
          <div class="card">
            <div class="card-header flex-column align-items-start">
              <h4 class="card-title">Payout Details</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="row mb-2"> {{-- input-group --}}
                    <div class="col-12 mt-1 text-left">
                      <label for="eth_address">Wallet Address</label>
                      <input type="text" class="form-control" name="eth_address" placeholder="Metamask Address (0x)" value="{{ $request->user() ? $request->user()->eth_address : '' }}">
                    </div>
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
                    <label class="form-label">Payment Details:</label>
                    <textarea class="form-control" name="notes" placeholder="Gcash Number, Bank Details, etc."></textarea>
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
      </div>
    </form>
  @endif
    
</section>
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
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/61e30274b84f7301d32b3148/1fpfc36i5';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>

@endsection


