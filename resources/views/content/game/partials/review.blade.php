<div class="row my-2">
  <div class="col-12">
    <div class="d-flex align-items-start">
      <a href="{{ route('user.profile', $review->user) }}">
        <div class="avatar me-75">
          <img src="{{ $review->user->profileUrl() }}" width="38" height="38" alt="Avatar" />
        </div>
      </a>
      <div class="author-info">
        <a href="{{ route('user.profile', $review->user) }}">
          <h6 class="fw-bolder mb-25" data-toggle="tooltip" title="{{ $review->user->eth_address }}">
            {{ App\Models\Utilities::limitString($review->user->eth_address, 12) }}
          </h6>
          <p class="fw-bolder"><i class="far fa-edit"></i> {{ $review->user->reviews->count() }} reviews</p>
        </a>
        <p class="card-text"><small><div class="read-only-ratings review-detail-rating" data-rateyo-rating="{{ $review->rating }}" data-rateyo-read-only="true"></div></small></p>
        <p class="fw-bolder">{{ $review->subject }}</p>

        <span class="card-text">
          {{ $review->description }}
        </span>

        @if($review->screenshots)
          <div class="col-12 py-1 modal_button" data-action="{{ route('game.review.screenshots', $review) }}" style="cursor:pointer;">
            @foreach(explode(',', $review->screenshots) as $reviewScreenshot)
              <img class="img-thumbnail px-2" src="{{ $review->screenshotUrl($reviewScreenshot) }}" alt="Review Screenshot" / style="height:100px">
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


