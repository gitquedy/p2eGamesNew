@inject('request', 'Illuminate\Http\Request')
@foreach($reviews as $review)
  @include('content.game.partials.review', ['review' => $review])
@endforeach
<script src="{{ asset('js/scripts/game/reviews.js') }}"></script>

