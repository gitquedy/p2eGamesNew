@inject('request', 'Illuminate\Http\Request')
@extends('layouts/contentLayoutMaster')

@section('title', 'User Profile')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/jquery.rateyo.min.css')}}">
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/swiper.min.css') }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-swiper.css') }}">
@endsection

@section('content')
<section class="">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="d-flex justify-content-left align-items-center">
                         <div class="bg-light-red me-1">
                            <img src="{{ $user->profileUrl() }}" alt="Avatar" width="64" height="64">
                         </div>
                         <div class="d-flex flex-column" >
                            <h6 class="emp_name text-truncate fw-bold text-wrap" >{{ $user->eth_address }}</h6>
                            <small class="emp_post text-truncate text-muted">{{ $user->name }}</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-1">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="d-flex flex-column align-items-center">
                         <span class="text-truncate fw-bold ">{{ $user->reviews->count() }}</span>
                         <span class="text-truncate fw-bold text-primary"><i class="f-icon" data-feather="edit"></i> Review</span>
                        </div>
                    </div>
              </div>

              <div class="col-md-1">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="d-flex flex-column align-items-center">
                         <span class="text-truncate fw-bold">{{ $user->reviews()->withCount('useful')->get()->sum('useful_count') }}</span>
                         <span class="text-truncate fw-bold text-success"><i class="f-icon" data-feather="thumbs-up"></i> Useful</span>
                        </div>
                    </div>
              </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-8">
            @foreach($user->reviews as $review)
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('game.show', $review->game) }}"><h4 class="card-title text-primary">{{ $review->game->name }}</h4></a>
                </div>
                <div class="card-body">
                    @include('content.game.partials.review', ['review' => $review])
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <img class="img-fluid" src="https://via.placeholder.com/300x250">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <img class="img-fluid" src="https://via.placeholder.com/300x250">
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection



@section('vendor-script')
<script src="{{ asset('vendors/js/extensions/jquery.rateyo.min.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/swiper.min.js') }}"></script>
@endsection
@section('page-script')
    <script src="{{ asset('js/scripts/game/reviews.js') }}"></script>
@endsection
