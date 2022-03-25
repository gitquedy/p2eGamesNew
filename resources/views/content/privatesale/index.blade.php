@inject('request', 'Illuminate\Http\Request')
@extends('layouts/contentLayoutMaster')

@section('title', 'PTE Private Sale')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset('css/base/pages/app-ecommerce.css') }}">
@endsection

@section('content')
<section id="checkout">
  <form action="{{ route('privateSale.submit') }}" method="POST" class="form" enctype="multipart/form-data">
  @csrf
    <div class="row">
      <div class="col-md-8 col-sm-12">
        <div class="card">
          <div class="card-header flex-column align-items-start">
            <h4 class="card-title">Private Sale Form</h4>
          </div>
          <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="mb-2">
                        <label class="form-label" cfor="checkout-apt-number">Full Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Full Name" value="{{ $request->user() ? $request->user()->name : '' }}">
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="mb-2">
                    <label class="form-label">Email Address</label>
                    <input type="text" class="form-control" name="email" placeholder="Email Address" value="{{ (old('email')) ? old('email') : ($request->user() ? $request->user()->email : '') }}">
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                  <div class="mb-2">
                    <label class="form-label">Would you like to join the $PTE private sale round?</label>
                    <div class="form-check m-1">
                      <input class="form-check-input" type="radio" name="join_private_sale_round" value="1" id="join_private_sale_round_yes">
                      <label class="form-check-label" for="join_private_sale_round_yes">
                        Yes
                      </label>
                    </div>
                    <div class="form-check m-1">
                      <input class="form-check-input" type="radio" name="join_private_sale_round" value="0" id="join_private_sale_round_no">
                      <label class="form-check-label" for="join_private_sale_round_no">
                        No
                      </label>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="mb-2">
                    <label class="form-label">How much will you contribute? Enter the amount in BNB</label>
                    <label class="form-label">(Min. 1 BNB, Max 20 BNB)</label>
                    <input type="number" min="1" max="20" step="0.000000001" name="contribute" class="form-control">
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                  <div class="mb-2">
                    <label class="form-label">What's your BSC wallet address?</label>
                    <input type="text" name="bsc_wallet" class="form-control" value="{{ $request->user() ? $request->user()->eth_address : '' }}">
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="mb-2">
                    <label class="form-label">What's your username on Telegram?</label>
                    <input type="text" name="telegram" class="form-control">
                  </div>
                </div>
            </div>
            <div class="text-center">
                <input type="submit" name="save" class="btn btn-primary place-order btn_save" value="Submit">
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-12">
        <div class="card">
          <div class="card-body">
            <h3>PTE Private Sale</h3>
            <p><b>Pricing</b></p>
            <p>Private Sale</p>
            <p>1 BNB = 3,000 $PTE</p>
            <br>
            <p>Public Sale</p>
            <p>1 BNB = 1,500 $PTE</p>
            <br>
            <p><b>Eligibility</b></p>
            <p>You must have atleast 10 airdrop referrals</p>
            <br>
            <p><b>Limit (Min-Max Buy)</b></p>
            <p>Private Sale</p>
            <p>1-20 BNB</p>
            <br>
            <p>Public Sale</p>
            <p>0.10-2 BNB</p>
            <br>
            <p>For more details please visit read our whitepaper</p>
            <p><a href="https://docs.p2egames.ph/" target="_new">https://docs.p2egames.ph/</a></p>
          </div>
        </div>
      </div>
    </form>

</section>
@endsection

@section('vendor-script')
<script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
@endsection

@section('page-script')
  <script src="{{ asset('js/scripts/forms-validation/form-normal.js') }}"></script>
  <script src="{{ asset('js/scripts/forms-validation/form-confirmation.js') }}"></script>
@endsection

