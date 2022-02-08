@inject('request', 'Illuminate\Http\Request')
<div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Game Screenshots</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
                <div class="swiper-autoplay swiper-container modal-swiper">
                  <div class="swiper-wrapper">
                    @if($game->screenshots)
                      @if($default)
                        <div class="swiper-slide">
                          <img class="img-fluid" src="{{ $game->screenshotUrl($default) }}" alt="banner" />
                        </div>
                      @endif
                      @foreach(explode(',', $game->screenshots) as $screenshot)
                        @if($default)
                          @if($screenshot == $default)
                            @continue
                          @endif
                        @endif
                        <div class="swiper-slide">
                          <img class="img-fluid" src="{{ $game->screenshotUrl($screenshot) }}" alt="banner" />
                        </div>
                      @endforeach
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
