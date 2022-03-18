{{-- <style>
    .owl-carousel .owl-stage {
      display: flex;
      height: 300px;
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
</style> --}}
<div class="row my-2">
  <div class="col-12">
    <div class="d-flex align-items-start overflow-hidden">
      <a href="{{ route('user.profile', $review->user) }}">
        <div class="avatar me-75">
          <img src="{{ $review->user->profileUrl() }}" width="38" height="38" alt="Avatar" />
        </div>
      </a>
      <div class="author-info w-100">
        <a href="{{ route('user.profile', $review->user) }}">
          <h6 class="fw-bolder mb-25" data-toggle="tooltip" title="{{ $review->user->eth_address }}">
            {{ $review->user->displayName() }}
          </h6>
          <p class="fw-bolder"><i class="far fa-edit"></i> {{ $review->user->reviews->count() }} reviews</p>
        </a>
        <p class="card-text"><small><div class="read-only-ratings review-detail-rating" data-rateyo-rating="{{ $review->rating }}" data-rateyo-read-only="true"></div></small></p>
        <p class="fw-bolder">{{ $review->subject }}</p>

        <span class="card-text">
          {{ $review->description }}
        </span>

        @if($review->screenshots)
          <div class="w-100 py-1 owl-carousel owl-cgamereview modal_button" data-action="{{ route('game.review.screenshots', $review) }}" style="cursor:pointer;">
            @foreach(explode(',', $review->screenshots) as $reviewScreenshot)
              <img class="img-thumbnail" src="{{ $review->screenshotUrl($reviewScreenshot) }}" alt="Review Screenshot">
            @endforeach
          </div>
        @endif

        <p class="card-text">{{ App\Models\Utilities::format_date($review->created_at, 'F d, Y') }}</p>
        @if($request->user())
          @if($review->user->id != $request->user()->id)
            <button class="btn usefulBtn {{ $request->user()->useful->where('review_id', $review->id)->count() ? 'btn-outline-success' : '' }}" id="usefulBtn_{{ $review->id }}" data-action="{{ route('useful.useful', $review) }}"><span id="usefulCount_{{ $review->id}}" class="pe-1">{{ $review->useful->count() }}</span> <i class="far fa-thumbs-up"></i> Useful</button>
          @else
            <button class="btn"><span id="usefulCount_{{ $review->id}}" class="pe-1">{{ $review->useful->count() }}</span> <i class="far fa-thumbs-up"></i> Useful</button>
          @endif
        @else
          <button class="btn loginFirst"><span id="usefulCount_{{ $review->id}}" class="pe-1">{{ $review->useful->count() }}</span> <i class="far fa-thumbs-up"></i> Useful</button>
        @endif
        <hr/>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function(){
      $(".owl-carousel.owl-cgamereview").owlCarousel({
        lazyLoad:true,
        loop:false,
        margin:5,
        nav:false,
        dots:false,
        autoplay:false,
        smartSpeed:2000,
        responsiveClass:false,
        responsive:{
            0:{
                nav:false,
                items:1
            },
            300:{
                nav:false,
                items:2
            },
            600:{
                nav:false,
                items:3
            },
            900:{
                nav:false,
                items:5
            },
            1280:{
                nav:false,
                items:7
            }
        }
      });
  });
</script>