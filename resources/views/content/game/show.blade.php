@inject('request', 'Illuminate\Http\Request')
@extends('layouts/contentLayoutMaster')

@section('title', $game->name)
@section('og-image', $game->imageUrl())

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

    .owl-carousel .owl-stage {
      display: flex;
    }

    .owl-carousel .owl-item {
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden
    }

   .owl-carousel .owl-item img {
      flex-shrink: 0;
      min-width: 100%;
      min-height: 100%
    }
  </style>
@endsection

@section('content')
<!-- app e-commerce details start -->
<section class="app-ecommerce-details">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3 py-1 px-0 text-center">
          <img class="img-fluid" src="{{ $game->imageUrl() }}" alt="banner" style="height:250px; max-width: 235px" />
        </div>
        <div class="col-sm-12 col-md-8 col-lg-8 col-xl-9">
          <div class="row">
            <div class="col-lg-8 col-sm-6 text-center text-sm-start">
              <h4>{{ $game->name }} </h4>
            </div>
            <div class="col-lg-4 col-sm-6 align-items-end text-end d-flex justify-content-center justify-content-sm-end p-0">
              {!! $game->get3rdPartyDisplay() !!}
            </div>
          </div>
          <div class="ecommerce-details-price d-flex flex-wrap mt-1 justify-content-center justify-content-sm-start">
            <h4 class="item-price me-1">{!! $game->getStatusDisplay() !!}</h4>
            <div class="read-only-ratings rating" data-rateyo-rating="{{ $game->avgRating }}" data-rateyo-read-only="true"></div>
            <h4>&nbsp; {{ $game->avgRating }}/5</h4><small class="d-none d-sm-block" > &nbsp; out of {{ $game->reviews()->count() }} reviews</small>
          </div>
          <p class="card-text">
            {{ $game->description }}
          </p>
          @isset($game->screenshots)
            <div class="owl-carousel owl-theme" style="cursor:pointer;">
              @foreach(explode(',', $game->screenshots) as $screenshot)
                <img class="img-thumbnail modal_button" src="{{ $game->screenshotUrl($screenshot) }}" data-action="{{ route('game.screenshots', ['game' => $game, 'default' => $screenshot]) }}" alt="Game Screenshot">
              @endforeach
            </div>
          @endif
          <div class="row">
            <div class="col-sm-7">
              <h4>Game Info</h4>
              <div class="table-responsive mb-2">
                <table class="table align-items-start text-start table-bordered">
                  <tbody>
                    <tr>
                      <th>Genre:</th>
                      <td>
                        @foreach($game->genres() as $genre)
                          <a href="#">{{ $genre->name }}{{ $loop->last ? '' : ',' }} </a>
                        @endforeach
                      </td>
                    </tr>
                    <tr>
                      <th>Platforms:</th>
                      <td>
                        @foreach(explode(',', $game->device) as $devices)
                          <a href="#">{{ $devices }}{{ $loop->last ? '' : ',' }} </a>
                        @endforeach
                      </td>
                    </tr>
                    <tr>
                      <th>Blockchains:</th>
                      <td>
                        @foreach($game->blockchains() as $blockchain)
                          <a href="#">{{ $blockchain->name }}{{ $loop->last ? '' : ',' }} </a>
                        @endforeach</td>
                    </tr>
                    <tr>
                      <th>Token:</th>
                      <td>@if($game->governance_token)${{ strtoupper($governance_coin['symbol']) }}@endif</td>
                    </tr>
                    <tr>
                      <th>Minimum Investment:</th>
                      <td>₱{{ number_format($game->minimum_investment, 2) }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            <!--   <h4>Upcoming Events</h4>
              <div class="table-responsive mb-2">
                <table class="table align-items-start text-start table-bordered">
                  <tbody>
                    <tr>
                      <th>February 19, 2022</th>
                      <td></td>
                    </tr>
                    <tr>
                      <th>All day</th>
                      <td>Event Title</td>
                    </tr>
                    <tr>
                      <th>February 20, 2022</th>
                      <td></td>
                    </tr>
                    <tr>
                      <th>All day</th>
                      <td>Event Title</td>
                    </tr>
                    <tr>
                      <th>February 20, 2022</th>
                      <td></td>
                    </tr>
                    <tr>
                      <th>All day</th>
                      <td>Event Title</td>
                    </tr>
                  </tbody>
                </table>
              </div> -->
              <div class="d-flex justify-content-left align-items-center">
                <div class="fb-share-button pe-1" data-href="{{ route('game.show', $game) }}" data-layout="button" data-size="large">
                  <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ route('game.show', $game) }};src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a>
                </div>
                  <a class="btn btn-info btn-sm" data-size="large"
                href="https://twitter.com/intent/tweet?text=Check this awesome NFT play-to-earn Game!&url={{ route('game.show', $game) }}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="f-icon" data-e="twitter"></i> Tweet</a>
              </div>

            </div>
            <div class="col-sm-5 pt-1 text-center">
              <!-- <img class="img-fluid mb-2" src="https://via.placeholder.com/300x250"> -->
              <img class="img-fluid" src="https://via.placeholder.com/300x250">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

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

    <!-- x -->
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
              @if(Auth::user())
                @if($game->reviews()->where('user_id', Auth::user()->id)->count() < 1)
                  <div class="col-md-2">
                    <a href="#wreview"><button class="btn btn-info btn-lg">Write a Review</button></a>
                  </div>
                @endif
              @endif
            </div>
          </div>
          <hr/>
          <div class="card-body" id="reviewsCard">

          </div>
        </div>
      </div>

      @else

      <div class="col-12 mt-1">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-12 align-items-center justify-content-center">
                <div class="d-flex align-items-center justify-content-center flex-column">
                  <h4>Yay! Be the first to review this game</h4>
                  @if(! $request->user())
                  <button class="btn btn-success" onclick="$('#metamaskLogin').click()">Connect Metamask to Login.</button>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    @endif
    <!-- reviews -->

    @if(Auth::user())
      @if($game->allReviews()->where('user_id', Auth::user()->id)->count() < 1)
      <div class="col-12 mt-1" id="wreview">
        <h6 class="section-label mt-25">Leave a Review</h6>
        <div class="card">
          <div class="card-body">
            <form action="{{ route('review.store') }}" method="POST" class="form" enctype="multipart/form-data">
              @csrf
              <input type="text" name="game_id" value="{{ $game->id }}" hidden>
              <input type="text" name="game_slug" value="{{ $game->slug }}" hidden>
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
      $(".owl-carousel").owlCarousel({
        lazyLoad:true,
        loop:true,
        margin:5,
        nav:false,
        dots:false,
        autoplay:false,
        autoplayTimeout:5000,
        smartSpeed:2000,
        autoHeight:true,
        autoplayHoverPause: true,
        responsiveClass:false,
        responsive:{
            0:{
                nav:false,
                items:1
            },
            768:{
                nav:false,
                items:2
            },
            900:{
                nav:false,
                items:3
            },
            1280:{
                nav:false,
                items:4
            }
        }
      });

      $('.onChange-event-ratings')
      .rateYo()
      .on('rateyo.change', function (e, data) {
        var rating = data.rating;
        $('[name="rating"]').val(rating);
        $(this).parent().find('.counter').text(rating);
      });
      $('.review-detail-rating').rateYo({
        starWidth: "14px",
      });

    $('.rating').rateYo({
      starWidth: "28px",
    });



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
});

</script>

<script type="text/javascript">
  var options = {
        series: [{
        name: '',
        data: {}
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
            val = val.toFixed(2);
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
    @if($game->governance_token)
    var governance_market_chart = @json($game->governance_market_chart['prices']);
    options.series[0].name = '{{ $game->governance_token }}';
    options.series[0].data = governance_market_chart;

    var governance_chart = new ApexCharts(document.querySelector("#governance_market_chart"), options);
    governance_chart.render();

    function updateGovernanceChart(){
      var checked = $('input[name="filterChart_governance_market_chart"]:checked');
      var type = $('input[name="filterChartType_governance_market_chart"]:checked').val();
      value = checked.val();
      chart = checked.data('chart');
      $.ajax({
          url: "{{ route('game.getChart', $game) }}",
          data: {
            value: value,
            chart: chart,
            type: type,
          },
          method: "POST",
          success:function(result)
          {
            governance_chart.updateOptions({
            series: [{
              data: result
            }],
            yaxis: {
              labels: {
                formatter: function (val) {
                  val = val.toFixed(2);
                  return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                },
              },
              title: {
                text: type
              },
            },
          })
          }
      });
    }
    $('input[name="filterChart_governance_market_chart"]').on('change', function(){
      updateGovernanceChart();
    });
    $('input[name="filterChartType_governance_market_chart"]').on('change', function(){
      updateGovernanceChart();
    });
    @endif

    @if($game->rewards_token)
      var rewards_market_chart = @json($game->rewards_market_chart['prices']);
      options.series[0].name = '{{ $game->rewards_token }}';
      options.series[0].data = rewards_market_chart;

      var rewards_chart = new ApexCharts(document.querySelector("#rewards_market_chart"), options);
      rewards_chart.render();
      function updateRewardsChart(){
        var checked = $('input[name="filterChart_rewards_market_chart"]:checked');
        var type = $('input[name="filterChartType_rewards_market_chart"]:checked').val();
        value = checked.val();
        chart = checked.data('chart');
        $.ajax({
            url: "{{ route('game.getChart', $game) }}",
            data: {
              value: value,
              chart: chart,
              type: type,
            },
            method: "POST",
            success:function(result)
            {
            rewards_chart.updateOptions({
              series: [{
                data: result
              }],
              yaxis: {
                labels: {
                  formatter: function (val) {
                    val = val.toFixed(2);
                    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                  },
                },
                title: {
                  text: type
                },
              },
            })
            }
        });
      }
      $('input[name="filterChart_rewards_market_chart"]').on('change', function(){
        updateRewardsChart();
      });
      $('input[name="filterChartType_rewards_market_chart"]').on('change', function(){
        updateRewardsChart();
      });
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
      $(document).ready(function(){
        $('input[type=radio][name=ratings_filter]').change(function() {
          getRatings();
      });
      getRatings();
      });
    @endif

</script>


@endsection
