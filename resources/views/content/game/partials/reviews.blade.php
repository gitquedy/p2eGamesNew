@foreach($reviews as $review)
  <div class="row my-2">
    <div class="col-12">
      <div class="d-flex align-items-start">
        <div class="avatar me-75">
          <img src="{{ $review->user->profileUrl() }}" width="38" height="38" alt="Avatar" />
        </div>
        <div class="author-info">
          <h6 class="fw-bolder mb-25" data-toggle="tooltip" title="{{ $review->user->eth_address }}">{{ App\Models\Utilities::limitString($review->user->eth_address, 12) }}</h6>
          <p class="card-text"><small><div class="read-only-ratings review-detail-rating" data-rateyo-rating="{{ $review->rating }}" data-rateyo-read-only="true"></div></small></p>
          <p class="card-text">{{ $review->subject }}</p>

          <span class="card-text">
            {{ $review->description }}
          </span>

          @if($review->screenshots)
            <div class="col-12 p-3 modal_button" data-action="{{ route('game.review.screenshots', $review) }}" style="cursor:pointer;">
              @foreach(explode(',', $review->screenshots) as $reviewScreenshot)
                  <img class="img-thumbnail px-2" src="{{ $review->screenshotUrl($reviewScreenshot) }}" alt="banner" / style="height:120px;width:120px;">
              @endforeach
            </div>
          @endif

          <p class="card-text">{{ App\Models\Utilities::format_date($review->created_at, 'F d, Y') }}</p>
          <hr/>
        </div>
      </div>
    </div>


  </div>
@endforeach

<script type="text/javascript">
  $(document).ready(function(){
    $('.review-detail-rating').rateYo({
      starWidth: "14px",
    });
  });
</script>
