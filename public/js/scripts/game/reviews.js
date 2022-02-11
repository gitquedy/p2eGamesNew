$(document).ready(function(){
    $('.review-detail-rating').rateYo({
      starWidth: "14px",
    });

    feather.replace({
      width: 14,height: 14
    });

    $(document).on('click', '.usefulBtn', function(){
      $.ajax({
          url: $(this).data('action'),
          method: "POST",
          success:function(result)
          {
            if(result.addClass){
              $(result.btn).addClass(result.class);
              $(result.usefulCount).html(result.count);
            }else{
              $(result.btn).removeClass(result.class);
              $(result.usefulCount).html(result.count);
            }

          }
      });
    });
    $(document).on('click', '.loginFirst', function(){
      Swal.fire({
        icon: 'info',
        title: 'Please login first.',
        showConfirmButton: false,
        timer: 1500,
        showClass: {
          popup: 'animate__animated animate__fadeIn'
        },
      });
    })
});
