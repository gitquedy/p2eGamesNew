@extends('layouts/contentLayoutMaster')

@section('title', 'Exchange')


@section('vendor-style')
<link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
@endsection

@section('content')

<section id="exchange">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">

                <div class="card-content">
                    <div class="card">
                        <div class="card-body">
                          <!-- Nav tabs -->
                          <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="buy-tab-fill" data-script-tag="b" data-bs-toggle="tab" href="#buy-fill" role="tab" aria-controls="buy-fill" aria-selected="true">Buy</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="sell-tab-fill" data-script-tag="s" data-bs-toggle="tab" href="#sell-fill" role="tab" aria-controls="sell-fill" aria-selected="false">Sell</a>
                            </li>
                          </ul>

                          <!-- Tab panes -->
                          <div class="tab-content pt-1">
                            <div class="tab-pane active" id="buy-fill" role="tabpanel" aria-labelledby="buy-tab-fill">
                                <form action="{{ route('exchange.saveCart') }}" method="POST" class="form" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="transaction" value="buy">
                                    <div class="row mb-2 align-items-center justify-content-center text-center">
                                        <img class="img_thumbnail" src="{{ asset('images/logo/p2exchange-logo.png') }}" style="max-height: 150px; max-width: 150px">
                                    </div>
                                    <div class="row mb-2 align-items-center justify-content-center">
                                        <div class="col-sm-3">
                                            <label>Buy Crypto</label>

                                            <select class="form-control select2 trigger_coin" name="coin_id" id="b_coin">
                                                @foreach($coins as $coin)
                                                    <option value="{{ $coin->id }}" data-image="{{ $coin->imageUrl() }}" data-value="{{ $coin->default }}" data-step="{{ $coin->step }}" data-price="{{ $coin->usePrice }}" {{ $coin->isDefault ? 'selected' : '' }}>{{ $coin->name . ' ($'. $coin->short_name . ')' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label></label>
                                            <div class="input-group">
                                            <button class="btn btn-outline-info btn-sm round trigger_minus" id="b_minus" type="button"><i class="feather" data-feather="minus"></i></button>
                                            <input type="number" class="form-control changeAmount trigger_coin_amount" name="qty" value="1" id="b_coin_amount" min="0"  step="1">
                                            <button class="btn btn-outline-info btn-sm round trigger_plus" id="b_plus" type="button"><i class="feather" data-feather="plus"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-2 align-items-center justify-content-center">
                                        <div class="col-sm-3">
                                            <label>Payment Method</label>
                                            <select class="form-control select2" name="paymentmethod_id">
                                                @foreach($paymentMethods as $paymentMethod)
                                                    <option value="{{ $paymentMethod->id }}" data-image="{{ $paymentMethod->imageUrl() }}" data-price="1" {{ $paymentMethod->isDefault ? 'selected' : '' }}>{{ $paymentMethod->provider }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label></label>
                                            <input type="text" class="form-control rounded-pill changeAmount trigger_totalAmount" value="0.00" id="b_totalAmount">
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center justify-content-center">
                                        <div class="col-sm-7">
                                            <button type="submit" class="btn btn-success w-100 btn_save" value="Save">Buy Crypto</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="sell-fill" role="tabpanel" aria-labelledby="sell-tab-fill">
                                <form action="{{ route('exchange.saveCart') }}" method="POST" class="form" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="transaction" value="sell">
                                    <div class="row mb-2 align-items-center justify-content-center text-center">
                                        <img class="img_thumbnail" src="{{ asset('images/logo/p2exchange-logo.png') }}" style="max-height: 150px; max-width: 150px">
                                    </div>
                                    <div class="row mb-2 align-items-center justify-content-center">
                                        <div class="col-sm-3">
                                            <label>Sell Crypto</label>

                                            <select class="form-control select2 trigger_coin" name="coin_id" id="s_coin">
                                                @foreach($coins as $coin)
                                                    <option value="{{ $coin->id }}" data-image="{{ $coin->imageUrl() }}" data-value="{{ $coin->default }}" data-step="{{ $coin->step }}" data-price="{{ $coin->sellPrice }}" {{ $coin->isDefault ? 'selected' : '' }}>{{ $coin->name . ' ($'. $coin->short_name . ')' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label></label>
                                            <div class="input-group">
                                            <button class="btn btn-outline-info btn-sm round trigger_minus" id="s_minus" type="button"><i class="feather" data-feather="minus"></i></button>
                                            <input type="number" class="form-control changeAmount trigger_coin_amount" name="qty" value="1" id="s_coin_amount" min="0"  step="1">
                                            <button class="btn btn-outline-info btn-sm round trigger_plus" id="s_plus" type="button"><i class="feather" data-feather="plus"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-2 align-items-center justify-content-center">
                                        <div class="col-sm-3">
                                            <label>Payment Method</label>
                                            <select class="form-control select2" name="paymentmethod_id">
                                                @foreach($paymentMethods as $paymentMethod)
                                                    <option value="{{ $paymentMethod->id }}" data-image="{{ $paymentMethod->imageUrl() }}" data-price="1" {{ $paymentMethod->isDefault ? 'selected' : '' }}>{{ $paymentMethod->provider }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label></label>
                                            <input type="text" class="form-control rounded-pill changeAmount trigger_totalAmount" value="0.00" id="s_totalAmount">
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center justify-content-center">
                                        <div class="col-sm-7">
                                            <button type="submit" class="btn btn-danger w-100 btn_save" value="Save">Sell Crypto</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection

@section('vendor-script')
<script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
@endsection

@section('page-script')
<script src ="{{ asset('js/scripts/exchange/exchange.js') }}"></script>
<script src="{{ asset('js/scripts/forms-validation/form-normal.js') }}"></script>
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
