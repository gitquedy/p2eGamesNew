@extends('layouts/contentLayoutMaster')

@section('title', 'Game Details')

@section('vendor-style')
  {{-- Vendor Css files --}}
  <link rel="stylesheet" href="{{ asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/extensions/swiper.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/extensions/jquery.rateyo.min.css')}}">
  <link rel="stylesheet" href="{{ asset('vendors/css/extensions/swiper.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/pickers/flatpickr/flatpickr.min.css') }}">

@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('css/base/pages/app-ecommerce-details.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-number-input.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-toastr.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-swiper.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/charts/chart-apex.css') }}">
  <style type="text/css">
    .game-links{
      padding-right:  10px;
    }
  </style>
@endsection

@section('content')
<!-- app e-commerce details start -->
<section class="app-ecommerce-details">
  <div class="card">
    <!-- Product Details starts -->
    <div class="card-body">
      <div class="row my-2">
        <div class="col-12 col-md-5 d-flex align-items-center justify-content-center mb-2 mb-md-0">
            <div class="swiper-autoplay swiper-container">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <img class="img-fluid" src="{{ $game->imageUrl() }}" alt="banner" />
                </div>
                @isset($game->screenshots)
                  @foreach(explode(',', $game->screenshots) as $screenshot)
                    <div class="swiper-slide">
                      <img class="img-fluid" src="{{ $game->screenshotUrl($screenshot) }}" alt="banner" />
                    </div>
                  @endforeach
                @endisset
              </div>
              <div class="swiper-pagination"></div>
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
          <!-- </div> -->
        </div>
        <div class="col-12 col-md-7">
          <div class="row">
            <div class="col-lg-8 col-sm-6">
              <h4>{{ $game->name }} </h4>
            </div>
            <div class="col-lg-4 col-sm-6 align-items-end text-end d-flex flex-row-reverse">
              <a class="btn btn-info btn-sm " data-size="large"
                href="https://twitter.com/intent/tweet?text=Check this awesome NFT play-to-earn Game!&url={{ route('game.show', $game) }}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="f-icon" data-feather="twitter"></i> Tweet</a>
              <div class="fb-share-button " data-href="{{ route('game.show', $game) }}" data-layout="button" data-size="large">
                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ route('game.show', $game) }};src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a>
              </div>
            </div>
          </div>

       <!--    <div class="align-items-end text-end">

          </div> -->


<!--           <span class="card-text item-company">{{ $game->short_description }}</span> -->
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
            <li><i data-feather="dollar-sign"></i> Minimum Investment: <span>
              {{ $game->minimum_investment ? '₱ ' . number_format($game->minimum_investment, 2) : '--' }}
            </span></li>
            <br>
            <li>
              <span>{!! $game->getF2pDisplay() !!}</span>
            </li>
          </ul>
          <hr />

          <div class="d-flex justify-content-left align-items-center">
              {!! $game->get3rdPartyDisplay() !!}
            </div>
        </div>
      </div>
    </div>
  </div>
   <!-- Product Details ends -->

  <!-- Governance Token -->
    @if($game->governance_token)
      @include('content.game.partials.coin-chart', ['game' => $game, 'coin' => $governance_coin, 'chart_name' => 'governance_market_chart'])
    @endif
    <!-- Governance token -->

     <!-- Rewards Token -->
    @if($game->rewards_token)
      @include('content.game.partials.coin-chart', ['game' => $game, 'coin' => $rewards_coin, 'chart_name' => 'rewards_market_chart'])
    @endif
    <!-- Rewards token -->
    @if($game->reviews()->count() > 0)

    <!-- reviews -->
    <div class="col-12 mt-1" id="blogComment">
        <h6 class="section-label mt-25">Reviews</h6>
        <div class="card">
          <div class="card-body">
            <div class="row mb-1 custom-options-checkable g-1 text-center pt-3">
              <div class="col-md-4">
                <h3 class="text-primary">{{ $game->avgRating }} out of 5</h3>
                <div class="read-only-ratings rating" style="margin-left: auto;margin-right:auto;" data-rateyo-rating="{{ $game->avgRating }}" data-rateyo-read-only="true"></div>
                <small> &nbsp; out of {{ $game->reviews()->count() }} reviews</small>
              </div>
              <div class="col-md-1">
                <input class="custom-option-item-check" type="radio" name="ratings_filter" id="allStar" value="all" checked="true"/>
                <label class="custom-option-item p-1" for="allStar">
                  <span class="d-flex justify-content-between flex-wrap mb-50">
                    <span class="fw-bolder">All Ratings</span>
                  </span>
                </label>
              </div>
              <div class="col-md-1">
                <input class="custom-option-item-check" type="radio" name="ratings_filter" id="5star" value="5"/>
                <label class="custom-option-item p-1" for="5star">
                  <span class="d-flex justify-content-between flex-wrap mb-50">
                    <span class="fw-bolder">5 Star ({{ $game->reviews()->where('rating', 5)->count() }})</span>
                  </span>
                </label>
              </div>
              <div class="col-md-1">
                <input class="custom-option-item-check" type="radio" name="ratings_filter" id="4star" value="4"/>
                <label class="custom-option-item p-1" for="4star">
                  <span class="d-flex justify-content-between flex-wrap mb-50">
                    <span class="fw-bolder">4 Star ({{ $game->reviews()->where('rating', 4)->count() }})</span>
                  </span>
                </label>
              </div>
              <div class="col-md-1">
                <input class="custom-option-item-check" type="radio" name="ratings_filter" id="3star" value="3"/>
                <label class="custom-option-item p-1" for="3star">
                  <span class="d-flex justify-content-between flex-wrap mb-50">
                    <span class="fw-bolder">3 Star ({{ $game->reviews()->where('rating', 3)->count() }})</span>
                  </span>
                </label>
              </div>
              <div class="col-md-1">
                <input class="custom-option-item-check" type="radio" name="ratings_filter" id="2star" value="2"/>
                <label class="custom-option-item p-1" for="2star">
                  <span class="d-flex justify-content-between flex-wrap mb-50">
                    <span class="fw-bolder">2 Star ({{ $game->reviews()->where('rating', 2)->count() }})</span>
                  </span>
                </label>
              </div>
              <div class="col-md-1">
                <input class="custom-option-item-check" type="radio" name="ratings_filter" id="1star" value="1"/>
                <label class="custom-option-item p-1" for="1star">
                  <span class="d-flex justify-content-between flex-wrap mb-50">
                    <span class="fw-bolder">1 Star ({{ $game->reviews()->where('rating', 1)->count() }})</span>
                  </span>
                </label>
              </div>
            </div>
          </div>
          <hr/>
          <div class="card-body" id="reviewsCard">

          </div>
        </div>
      </div>
    @endif
    <!-- reviews -->

    @if(Auth::user())
      @if($game->reviews()->where('user_id', Auth::user()->id)->count() < 1)
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
                    <div class="onChange-event-ratings" data-rateyo-full-star="true"></div>
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
                    <input type="file" class="form-control" name="screenshots[]" placeholder="screenshots" multiple="multiple" />
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
  <script src="{{ asset('vendors/js/charts/apexcharts.min.js') }}"></script>
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
      delay: 3000,
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

<script type="text/javascript">
    @if($game->governance_token)
    var governance_market_chart = @json($game->governance_market_chart['prices']);

    var options = {
        series: [{
        name: '{{ $game->governance_token }}',
        data: governance_market_chart
      }],
        chart: {
        type: 'area',
        stacked: false,
        height: 350,
        zoom: {
          type: 'x',
          enabled: true,
          autoScaleYaxis: true
        },
        toolbar: {
          autoSelected: 'zoom'
        }
      },
      dataLabels: {
        enabled: false
      },
      markers: {
        size: 0,
      },
      title: {
        text: '',
        align: 'left'
      },
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          inverseColors: false,
          opacityFrom: 0.5,
          opacityTo: 0,
          stops: [0, 90, 100]
        },
      },
      yaxis: {
        labels: {
          formatter: function (val) {
            return val.toFixed(0);
          },
        },
        title: {
          text: 'Price'
        },
      },
      xaxis: {
        type: 'datetime',
      },
      tooltip: {
        shared: false,
        y: {
          formatter: function (val) {
            return val.toFixed(2);
          }
        }
      }
    };

    var governance_chart = new ApexCharts(document.querySelector("#governance_market_chart"), options);
    governance_chart.render();
    @endif

    @if($game->rewards_token)
      var rewards_market_chart = @json($game->rewards_market_chart['prices']);
      options.series[0].name = '{{ $game->rewards_token }}';
      options.series[0].data = rewards_market_chart;

      var rewards_chart = new ApexCharts(document.querySelector("#rewards_market_chart"), options);
      rewards_chart.render();
    @endif

    function copyToClipboard(string, target){
      navigator.clipboard.writeText(string)
      $(target).prop("data-toggle", "tooltip");
      $(target).prop("title", "Copied!");
    }

    @if($game->reviews()->count() > 0)

    function getRatings(){
      $.ajax({
          url: "{{ route('game.reviews', $game) }}",
          method: "GET",
          data: {
              "rating": $('input[name="ratings_filter"]:checked').val(),
          },
          success:function(result)
          {
              $('#reviewsCard').html(result);
          }
        });
    }
    // $('#reviewsCard');
      $(document).ready(function(){
        $('input[type=radio][name=ratings_filter]').change(function() {
          getRatings();
      });
      getRatings();
      });
    @endif

</script>


@endsection
