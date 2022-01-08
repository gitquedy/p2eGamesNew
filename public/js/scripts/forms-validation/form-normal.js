$(function() {
  var button = 'save';
  $('input[type="submit"]').on('click', function(){
       button = this.name;
  });
  $(".form").submit(function(e) {
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
          console.log(result);
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
          // $(".select").val(null).trigger("change");
          if(button == 'save_with_reload_table'){
            $('.form')[0].reset();
            $('#' + table_id).DataTable().ajax.reload();
          }else if(button == 'save'){
            setTimeout(function(){
                window.location.replace(result.redirect);
            }, 1500);
          }else{
            $('.form')[0].reset();
          }
          }else{
            if(result.msg){
              toastr.error(result.msg);
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
