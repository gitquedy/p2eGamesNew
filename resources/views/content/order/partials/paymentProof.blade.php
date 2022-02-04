@inject('request', 'Illuminate\Http\Request')
<div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Payment Screenshot</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
                <div class="swiper-autoplay swiper-container modal-swiper">
                  <div class="swiper-wrapper">
                    @if($order->payment_proof)
                        <div class="swiper-slide">
                          <img class="img-fluid" src="{{  $order->paymentUrl() }}" alt="Payment Screenshot" />
                        </div>
                    @endif
                  </div>
                  <div class="swiper-pagination"></div>
                  <div class="swiper-button-next"></div>
                  <div class="swiper-button-prev"></div>
                </div>
            </div>
          </div>
        </div>
      </div>
</div>

<script type="text/javascript">
  setTimeout(function() {
var modal_swiper = new Swiper('.modal-swiper', {
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
}, 500);
</script>
