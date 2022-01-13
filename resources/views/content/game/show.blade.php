@extends('layouts/contentLayoutMaster')

@section('title', 'Game Details')

@section('vendor-style')
  {{-- Vendor Css files --}}
  <link rel="stylesheet" href="{{ asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/extensions/swiper.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/extensions/jquery.rateyo.min.css')}}">
  <link rel="stylesheet" href="{{ asset('vendors/css/extensions/swiper.min.css') }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('css/base/pages/app-ecommerce-details.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-number-input.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-toastr.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-swiper.css') }}">
@endsection

@section('content')
<!-- app e-commerce details start -->
<section class="app-ecommerce-details">
  <div class="card">
    <!-- Product Details starts -->
    <div class="card-body">
      <div class="row my-2">
        <div class="col-12 col-md-5 d-flex align-items-center justify-content-center mb-2 mb-md-0">
          <!-- <div class="d-flex align-items-center justify-content-center"> -->
            <!-- <img
              src="{{ $game->imageUrl() }}"
              class="img-fluid product-img"
              alt="product image"
            /> -->
            <div class="swiper-autoplay swiper-container">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <img class="img-fluid" src="{{ $game->imageUrl() }}" alt="banner" />
                </div>
                @foreach(explode(',', $game->screenshots) as $screenshot)
                  <div class="swiper-slide">
                    <img class="img-fluid" src="{{ $game->screenshotUrl($screenshot) }}" alt="banner" />
                  </div>
                @endforeach
              </div>
              <!-- Add Pagination -->
              <div class="swiper-pagination"></div>
              <!-- Add Arrows -->
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
          <!-- </div> -->
        </div>
        <div class="col-12 col-md-7">
          <h4>{{ $game->name }}</h4>
          <span class="card-text item-company">{{ $game->short_description }}</span>
          <div class="ecommerce-details-price d-flex flex-wrap mt-1">
            <h4 class="item-price me-1">{!! $game->getStatusDisplay() !!}</h4>
            <div class="read-only-ratings rating" data-rateyo-rating="{{ $game->avgRating }}" data-rateyo-read-only="true"></div>
            <h4>&nbsp; {{ $game->avgRating }}/5</h4><small> &nbsp; out of {{ $game->reviews()->count() }} reviews</small>
          </div>
          <p class="card-text">
            {{ $game->description }}
          </p>
          <hr />
          <div>
            {!! $game->getBlockChainDisplay() !!}
          </div><br>
          <ul class="product-features list-unstyled">
            <li></li>
            <li><i data-feather="list"></i> Genres: <span>
              @foreach($game->genres() as $genre)
                {{ $genre->name }}
              @endforeach
            </span></li>
            <li><i data-feather="smartphone"></i> Devices: <span>
              @foreach(explode(',', $game->device) as $device)
                {{ $device }}
              @endforeach
            </span></li>
            <li><span>-</span></li>
            <li>
              <span>{!! $game->getF2pDisplay() !!}</span>
            </li>
          </ul>
          <hr />
        </div>
      </div>
    </div>
    <!-- Product Details ends -->
  </div>
  <div class="col-12 mt-1" id="blogComment">
      <h6 class="section-label mt-25">Reviews</h6>
      <div class="card">
        @foreach($game->reviews()->orderBy('created_at', 'desc')->get() as $review)
          <div class="card-body">
            <div class="d-flex align-items-start">
              <div class="avatar me-75">
                <img src="{{asset('images/portrait/small/avatar-s-9.jpg')}}" width="38" height="38" alt="Avatar" />
              </div>
              <div class="author-info">
                <h6 class="fw-bolder mb-25">Chad Alexander</h6>
                <p class="card-text">&nbsp {{ $review->rating }}/5<div class="read-only-ratings rating" data-rateyo-rating="{{ $review->rating }}" data-rateyo-read-only="true"></div> </p>
                <p class="card-text">{{ App\Models\Utilities::format_date($review->created_at, 'F d, Y') }} | {{ $review->subject }}</p>
                <p class="card-text">
                  {{ $review->description }}
                </p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    @if(Auth::user())
    <div class="col-12 mt-1">
      <h6 class="section-label mt-25">Leave a Review</h6>
      <div class="card">
        <div class="card-body">
          <form action="{{ route('review.store') }}" method="POST" class="form" enctype="multipart/form-data">
            @csrf
            <input type="text" name="game_id" value="{{ $game->id }}" hidden>
            <div class="row">
              <div class="col-12">
                <div class="col-md d-flex flex-column align-items-start">
                  <div class="onChange-event-ratings"></div>
                  <div class="counter-wrapper mt-1">
                    <strong>Ratings:</strong>
                    <input type="text" name="rating" id="rating" hidden>
                    <span class="counter"></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6 col-12">
                <div class="mb-2">
                  <label>Subject:</label>
                  <input type="text" class="form-control" name="subject" placeholder="Subject" />
                </div>
              </div>
              <div class="col-sm-6 col-12">
                <div class="mb-2">
                  <label>Screenshots:</label>
                  <input type="file" class="form-control" name="screenshots[]" placeholder="screenshots" />
                </div>
              </div>
              <div class="col-12">
                <textarea class="form-control mb-2" rows="4" placeholder="Description" name="description"></textarea>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary" value="save">Post Review</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    @endif

</section>
<!-- app e-commerce details end -->
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') }}"></script>
  <script src="{{ asset('vendors/js/extensions/swiper.min.js') }}"></script>
  <script src="{{ asset('vendors/js/extensions/toastr.min.js') }}"></script>
  <script src="{{ asset('vendors/js/extensions/jquery.rateyo.min.js') }}"></script>
  <script src="{{ asset('vendors/js/extensions/swiper.min.js') }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset('js/scripts/pages/app-ecommerce-details.js') }}"></script>
  <script src="{{ asset('js/scripts/forms/form-number-input.js') }}"></script>
  <script src="{{ asset('js/scripts/forms-validation/form-normal.js') }}"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      $('.onChange-event-ratings')
      .rateYo()
      .on('rateyo.change', function (e, data) {
        var rating = data.rating;
        $('[name="rating"]').val(rating);
        $(this).parent().find('.counter').text(rating);
      });
    });

    $('.rating').rateYo();

    var mySwiper10 = new Swiper('.swiper-autoplay', {
    spaceBetween: 30,
    centeredSlides: true,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    }
  });

  </script>
@endsection
