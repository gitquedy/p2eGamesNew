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
      min-height: 100%;
      object-fit: cover;
    }

    .btn-xs {
      padding: 0.3rem 0.5rem;
      font-size: 0.8rem;
      border-radius: 0.358rem;
    }


    .outer { 
      margin:0 auto;
    }
    .owl-theme .owl-nav [class*='owl-'] { 
      -webkit-transition: all .3s ease; 
      transition: all .3s ease; 
    }
    .owl-theme .owl-nav [class*='owl-'].disabled:hover { 
      background-color: #D6D6D6; 
    }
    #big.owl-theme { 
      position: relative; 
    }
    #big.owl-theme .owl-next, #big.owl-theme .owl-prev {
      width: 22px; 
      line-height:40px; 
      height: 40px;
      margin-top: -20px; 
      position: absolute; 
      text-align:center; 
      top: 50%; 
    }
    #big.owl-theme .owl-prev { 
      left: 10px; 
    }
    #big.owl-theme .owl-next { 
      right: 10px; 
    }
    /*#thumbs.owl-theme .owl-next, #thumbs.owl-theme .owl-prev { background:#333; }*/
  </style>
@endsection

@section('content')
<!-- app e-commerce details start -->
<section class="app-ecommerce-details">
  <div class="row">
    <div class="col-md-4 order-md-1">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-4 col-md-12 col-lg-4 mb-1">
              <div class="d-flex ">
                <img class="img-fluid" src="{{ $game->imageUrl() }}" alt="banner" style="height:140px; max-width: 140px" />
              </div>
            </div>
            <div class="col-sm-8 col-md-12 col-lg-8 mb-1">
              <div class="row">
                <div class="d-flex align-items-center">
                  <h4 class="d-flex align-items-center">{{ $game->name }}</h4>
                  <small class="ms-1">{!! $game->getStatusDisplay() !!}</small>
                </div>
                <div class="d-flex align-items-center">
                  <div class="read-only-ratings rating" data-rateyo-rating="{{ $game->avgRating }}" data-rateyo-read-only="true"></div>
                  {{ $game->avgRating }}/5 <small class="d-none ms-1 d-sm-block" > out of {{ $game->reviews()->count() }} reviews</small>
                </div>
              </div>
              <div class="py-1">
                {!! $game->get3rdPartyDisplay() !!}
              </div>
            </div>
          </div>
          @if($game->governance_token)
              <div class="d-flex my-1 mx-0">
                <div class="me-1 d-flex align-items-center">
                  {!! $game->getCoinDisplay($governance_coin) !!}
                </div>
                <div class="mb-25 fw-bolder"> {{ $governance_coin['name'] }} ({{ strtoupper($governance_coin['symbol']) }}) 
                  <div class="d-flex">
                    <p class="fw-bolder mb-0 me-1">₱ {{ rtrim(sprintf('%f',floatval($governance_coin['market_data']['current_price']['php'])),'0') }}</p>
                    <span class="badge badge-sm badge-light-secondary">
                      <i class="text-{{ $governance_coin['market_data']['price_change_percentage_24h'] < 0 ? 'danger' : 'success'}} font-small-3" data-feather="arrow-{{ $governance_coin['market_data']['price_change_percentage_24h'] < 0 ? 'down' : 'up'}}"></i>
                      <span class="align-middle">{{ number_format($governance_coin['market_data']['price_change_percentage_24h'], 2) }}%</span>
                    </span>
                  </div>
                </div>
              </div>
          @endif
          @if($game->rewards_token)
              <div class="d-flex my-1 mx-0">
                <div class="me-1 d-flex align-items-center">
                  {!! $game->getCoinDisplay($rewards_coin) !!}
                </div>
                <div class="mb-25 fw-bolder"> {{ $rewards_coin['name'] }} ({{ strtoupper($rewards_coin['symbol']) }}) 
                  <div class="d-flex">
                    <p class="fw-bolder mb-0 me-1">₱ {{ rtrim(sprintf('%f',floatval($rewards_coin['market_data']['current_price']['php'])),'0') }}</p>
                    <span class="badge badge-sm badge-light-secondary">
                      <i class="text-{{ $rewards_coin['market_data']['price_change_percentage_24h'] < 0 ? 'danger' : 'success'}} font-small-3" data-feather="arrow-{{ $rewards_coin['market_data']['price_change_percentage_24h'] < 0 ? 'down' : 'up'}}"></i>
                      <span class="align-middle">{{ number_format($rewards_coin['market_data']['price_change_percentage_24h'], 2) }}%</span>
                    </span>
                  </div>
                </div>
              </div>
          @endif
          <div class="row">
            <div class="col">
              <br>
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
            </div>
          </div>
          <a href="#comment_section"><button class="btn btn-success btn-lg d-block w-100 text-uppercase"> Write a Review </button></a>
          <br>
          <a href="{{$game->website}}" target="_blank"><button class="btn btn-success btn-lg d-block w-100 text-uppercase"> Play Game </button></a>
        </div>
      </div>
      <div class="m-2 text-center">
        {{-- Ads Here --}}
        {{-- <img class="img-fluid mb-2" src="https://via.placeholder.com/300x250"> --}}
        <img class="img-fluid" src="{{asset('images/home/banner/full_dd809e130df04b45bfbc13ad2b5534d1260645ec.png')}}">
      </div>
    </div>
    <div class="col-md-8 order-md-12">
      <div class="card">
        <div class="card-body">
          @isset($game->screenshots)
            <div class="outer">
              <div id="big" class="owl-carousel owl-theme">
                @foreach(explode(',', $game->screenshots) as $screenshot)
                  <img class="item" src="{{ $game->screenshotUrl($screenshot) }}" data-action="{{ route('game.screenshots', ['game' => $game, 'default' => $screenshot]) }}" alt="Game Screenshot">
                @endforeach
              </div>
            </div>
            <div id="thumbs" class="owl-carousel owl-cgame owl-theme mb-1" style="cursor:pointer;">
              @foreach(explode(',', $game->screenshots) as $screenshot)
                <img class="img-thumbnail" src="{{ $game->screenshotUrl($screenshot) }}" data-action="{{ route('game.screenshots', ['game' => $game, 'default' => $screenshot]) }}" alt="Game Screenshot">
              @endforeach
            </div>
          @endif
          <div class="row">
            <div class="col-12">
              <p class="card-text">
                {{ $game->description }}
              </p>
            </div>
            <div class="col-12 mt-3">
              <!-- Governance Token -->
              @if($game->governance_token)
                @include('content.game.partials.coin-chart', ['game' => $game, 'coin' => $governance_coin, 'chart_name' => 'governance_market_chart'])
              @endif
              <!-- Governance token -->
            </div>
            <div class="col-12">
               <!-- Rewards Token -->
              @if($game->rewards_token)
                @include('content.game.partials.coin-chart', ['game' => $game, 'coin' => $rewards_coin, 'chart_name' => 'rewards_market_chart'])
              @endif
              <!-- Rewards token -->
            </div>
            <div class="d-flex justify-content-left align-items-center">
              <div class="fb-share-button pe-1" data-href="{{ route('game.show', $game) }}" data-layout="button" data-size="large">
                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ route('game.show', $game) }};src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a>
              </div>
                <a class="btn btn-info btn-sm" data-size="large"
              href="https://twitter.com/intent/tweet?text=Check this awesome NFT play-to-earn Game!&url={{ route('game.show', $game) }}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="f-icon" data-e="twitter"></i> Tweet</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    @if($game->reviews()->count() > 0)
    <!-- x -->
      <div class="col-12 mt-1" id="blogComment">
        <h6 class="section-label mt-25">Reviews</h6>
        <div class="card">
          <div class="card-body">
            <div class="row mb-1 custom-options-checkable g-1 text-center pt-3">
              <div class="col-md-3 col-lg-2 col-xl-3">
                <h3 class="text-primary">{{ $game->avgRating }} out of 5</h3>
                <div class="read-only-ratings rating" style="margin-left: auto;margin-right:auto;" data-rateyo-rating="{{ $game->avgRating }}" data-rateyo-read-only="true"></div>
                <small> &nbsp; out of {{ $game->reviews()->count() }} reviews</small>
              </div>
              <div class="col-md-9 col-lg-6">
                <div class="btn-group btn-group-sm flex-column flex-sm-row pt-1 py-0 py-sm-1" role="group">
                  <input type="radio" class="btn-check" name="ratings_filter" id="allStar" value="all" checked/>
                  <label class="btn btn-outline-primary" for="allStar">All Ratings</label>
                  <input type="radio" class="btn-check" name="ratings_filter" id="5star" value="5"/>
                  <label class="btn btn-outline-primary" for="5star">5 Star ({{ $game->reviews()->where('rating', 5)->count() }})</label>
                  <input type="radio" class="btn-check" name="ratings_filter" id="4star" value="4"/>
                  <label class="btn btn-outline-primary" for="4star">4 Star ({{ $game->reviews()->where('rating', 4)->count() }})</label>
                  <input type="radio" class="btn-check" name="ratings_filter" id="3star" value="3"/>
                  <label class="btn btn-outline-primary" for="3star">3 Star ({{ $game->reviews()->where('rating', 3)->count() }})</label>
                  <input type="radio" class="btn-check" name="ratings_filter" id="2star" value="2"/>
                  <label class="btn btn-outline-primary" for="2star">2 Star ({{ $game->reviews()->where('rating', 2)->count() }})</label>
                  <input type="radio" class="btn-check" name="ratings_filter" id="1star" value="1"/>
                  <label class="btn btn-outline-primary" for="1star">1 Star ({{ $game->reviews()->where('rating', 1)->count() }})</label>
                </div>
              </div>
              @if(Auth::user())
                @if($game->reviews()->where('user_id', Auth::user()->id)->count() < 1)
                  <div class="col-md-12 col-lg-4 col-xl-3 d-flex">
                    <div class="pt-1 pt-1 py-0 py-sm-1 m-auto my-0">
                      <a href="#wreview"><button class="btn btn-info btn-block">Write a Review</button></a>
                    </div>
                  </div>
                @endif
                @else
                  <div class="col-md-12 col-lg-4 col-xl-3 d-flex">
                    <div class="pt-1 pt-1 py-0 py-sm-1 m-auto my-0">
                      <h4>Please login to write a review.</h4>
                      {{-- <button class="btn btn-success btn-block" onclick="$('#metamaskLogin').click()">Connect Metamask to Login.</button> --}}
                      <a href="{{route('game.show.login', $game)}}">
                          <button class="btn btn-success">Click here to login.</button>
                        </a>
                    </div>
                  </div>
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
                  <h4 class="text-center">Yay! Be the first to review this game</h4>
                  @if(! $request->user())
                  <a href="{{route('game.show.login', $game)}}">
                    <button class="btn btn-success">Click here to login.</button>
                  </a>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif
    <!-- reviews -->
    </div>

    <div id="comment_section">
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
      var bigimage = $("#big");
      var thumbs = $("#thumbs");
      //var totalslides = 10;
      var syncedSecondary = true;

      bigimage
        .owlCarousel({
        items: 1,
        slideSpeed: 2000,
        nav: true,
        autoplay: true,
        dots: false,
        loop: true,
        responsiveRefreshRate: 200,
        navText: [
          '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
          '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
        ]
      })
        .on("changed.owl.carousel", syncPosition);

      thumbs
        .on("initialized.owl.carousel", function() {
        thumbs
          .find(".owl-item")
          .eq(0)
          .addClass("current");
      })
        .owlCarousel({
          lazyLoad:true,
          loop:false,
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
                  items:2
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
        })
        .on("changed.owl.carousel", syncPosition2);

      function syncPosition(el) {
        //if loop is set to false, then you have to uncomment the next line
        //var current = el.item.index;

        //to disable loop, comment this block
        var count = el.item.count - 1;
        var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

        if (current < 0) {
          current = count;
        }
        if (current > count) {
          current = 0;
        }
        //to this
        thumbs
          .find(".owl-item")
          .removeClass("current")
          .eq(current)
          .addClass("current");
        var onscreen = thumbs.find(".owl-item.active").length - 1;
        var start = thumbs
        .find(".owl-item.active")
        .first()
        .index();
        var end = thumbs
        .find(".owl-item.active")
        .last()
        .index();

        if (current > end) {
          thumbs.data("owl.carousel").to(current, 100, true);
        }
        if (current < start) {
          thumbs.data("owl.carousel").to(current - onscreen, 100, true);
        }
      }

      function syncPosition2(el) {
        if (syncedSecondary) {
          var number = el.item.index;
          bigimage.data("owl.carousel").to(number, 100, true);
        }
      }

      thumbs.on("click", ".owl-item", function(e) {
        e.preventDefault();
        var number = $(this).index();
        bigimage.data("owl.carousel").to(number, 300, true);
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
