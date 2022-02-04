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
                <div class="card-header">
                    <div class="card-title">P2E Exchange</div>
                </div>
                <div class="card-content">
                    <form action="{{ route('exchange.saveCart') }}" method="POST" class="form" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2 align-items-center justify-content-center">
                                    <div class="col-sm-2">
                                        <label>Buy</label>

                                        <select class="form-control select2" name="coin_id" id="coin">
                                            @foreach($coins as $coin)
                                                <option value="{{ $coin->id }}" data-image="{{ $coin->imageUrl() }}" data-price="{{ $coin->coingecko['market_data']['current_price']['php'] }}" data-minimum-price="{{ $coin->minimum_price }}" data-markup-price="{{ $coin->markup_price }}">{{ $coin->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label></label>
                                        <input type="number" class="form-control rounded-pill changeAmount" name="qty" value="1.00" id="coin_amount" min="0" max="10000" step="any">
                                    </div>
                                </div>

                                <div class="row mb-2 align-items-center justify-content-center">
                                    <div class="col-sm-2">
                                        <label>To</label>
                                        <select class="form-control select2" name="paymentmethod_id">
                                            @foreach($paymentMethods as $paymentMethod)
                                                <option value="{{ $paymentMethod->id }}" data-image="{{ $paymentMethod->imageUrl() }}" data-price="1">{{ $paymentMethod->provider }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label></label>
                                        <input type="text" class="form-control rounded-pill changeAmount" value="0.00" id="totalAmount">
                                    </div>
                                </div>
                                <div class="row mb-2 align-items-center justify-content-center">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary w-100 btn_save" value="Save">Checkout</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

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
<!-- var exchangeFixPrice = {{ $exchangeFixPrice }}; -->
<script src ="{{ asset('js/scripts/exchange/exchange.js') }}"></script>
<script src="{{ asset('js/scripts/forms-validation/form-normal.js') }}"></script>

@endsection
