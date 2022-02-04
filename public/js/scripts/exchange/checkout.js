$(document).ready(function(){
    reloadPrices();
    function reloadPrices($action){
        $.ajax({
          url:  reload_table,
          method: "GET",
          success:function(result)
          {
              $('#productTable').html(result);
          }
      });
    }

    $('#refresh').click(function(){
        reloadPrices();
    })

    $(".select2").select2({
        templateResult: formatState,
        templateSelection: formatState
    });

    function formatState (opt) {
        if (!opt.id) {
            return opt.text.toUpperCase();
        }

        var optimage = $(opt.element).attr('data-image');
        if(!optimage){
           return opt.text.toUpperCase();
        } else {
            var $opt = $(
               '<span><img src="' + optimage + '" width="25px" /> ' + opt.text.toUpperCase() + '</span>'
            );
            return $opt;
        }
    }


  $(".form").submit(function(e) {
    var button = 'save';
    e.preventDefault();
    if($('.btn_save').prop('disabled') == true){
      return false;
    }
     $('.btn_save').prop('disabled', true);
      $.ajax({
        url : $(this).attr('action'),
        type : 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function(result){
          if(result.success == true){
          Swal.fire({
            icon: 'success',
            title: result.msg,
            showConfirmButton: false,
            timer: 1500,
            showClass: {
              popup: 'animate__animated animate__fadeIn'
            },
          });
          $('.error').remove();
          $('.form')[0].reset();
            setTimeout(function(){
                window.location.replace(result.redirect);
            }, 1500);
          }else{
            if(result.msg){
              $('#refresh').click();
            }
            $('.error').remove();
              $.each(result.error, function(index, val){
                var elem = $('[name="'+ index +'"]');
                elem.after('<label class="text-danger error">' + val + '</label>');
              });
          }
          $('.btn_save').prop('disabled', false);
        },
        error: function(jqXhr, json, errorThrown){
          console.log(jqXhr);
          console.log(json);
          console.log(errorThrown);
          $('.btn_save').prop('disabled', false);
        }
      });
  });
});
