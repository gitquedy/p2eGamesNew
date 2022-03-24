 @inject('request', 'Illuminate\Http\Request')
<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Review Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @include('content.game.partials.review', ['review' => $review])
      </div>
    </div>
</div>

<script type="text/javascript">
  $('.review-detail-rating').rateYo({
      starWidth: "14px",
    });
</script>
