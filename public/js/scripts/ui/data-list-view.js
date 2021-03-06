/*=========================================================================================
    File Name: data-list-view.js
    Description: List View
    ----------------------------------------------------------------------------------------
    Item name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
var table = '';
if (typeof(order) === 'undefined') {
  var order = [];
}
$(document).ready(function () {
  "use strict";
    table = $(".data-list-view").DataTable({
        processing: true,
        serverSide: true,
        ajax: table_route,
        columns: columnns,
        createdRow: created_row_function,
        drawCallback: (typeof draw_callback_function === "function")  ? draw_callback_function : function(){},
        responsive: !1,
        columnDefs: [{
            orderable: false,
            targets: 0,
            checkboxes: {
                selectRow: !0
            },
        }],
        dom: '<"top"<"actions action-btns"B><"action-filters"lf>><"clear">rt<"bottom"<"actions">p>',
        oLanguage: {
            sLengthMenu: "_MENU_",
            sSearch: ""
        },
        aLengthMenu: aLengthMenu,
        select: {
            selector: "first-child",
            style: "multi",
        },
        bInfo: typeof BInfo !== 'undefined' ? BInfo : true,
        bFilter: typeof bFilter !== 'undefined' ? bFilter : true,
        pageLength: pageLength,
        "aaSorting": [],
        order: order,
        buttons: buttons,
        initComplete: function(t, e) {
            $(".dt-buttons .btn").removeClass("btn-secondary");
        }
    });

    $(document).on('change', '.selectFilter', function() {
        table.ajax.reload();
      });

    $(document).on('keyup', '.inputSearch', function() {
        table.ajax.reload();
      });

    $(document).on("click",".confirm",function() {
      if($(this).data('method')){
        var method = $(this).data('method');
      }
      else {
        var method = "GET";
      }
      Swal.fire({
      title: $(this).data('title'),
      text: $(this).data('text'),
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirm',
      confirmButtonClass: 'btn btn-primary',
      cancelButtonClass: 'btn btn-danger ml-1',
      input: $(this).data('input'),
      inputPlaceholder: $(this).data('placeholder'),
      inputAttributes: {
        'aria-label': $(this).data('placeholder')
      },
      buttonsStyling: false,
        }).then((result) => {
        if (result.value) {
          $.ajax({
            method: method,
            url: $(this).data('href'),
            data: {'input': result.value},
            dataType: "json",
            success: function(result){
              if(result.success == true){
                toastr.success(result.msg);
                table.ajax.reload();
              }else{
                if(result.msg){
                  toastr.error(result.msg);
                }
              }
            },
            error: function(jqXhr, json, errorThrown){
            console.log(jqXhr);
            console.log(json);
            console.log(errorThrown);
            toastr.error('Sorry, Something went wrong. Please try again later.');
          }
          });
        }
      });
    });

    $(document).on("click",".ajax",function() {
      if($(this).data('method')){
        var method = $(this).data('method');
      }
      else {
        var method = "GET";
      }
          $.ajax({
            method: method,
            url: $(this).data('href'),
            // data: {'input': result.value},
            dataType: "json",
            success: function(result){
              if(result.success == true){
                toastr.success(result.msg);
                table.ajax.reload();
              }else{
                if(result.msg){
                  toastr.error(result.msg);
                }
              }
            },
            error: function(jqXhr, json, errorThrown){
            console.log(jqXhr);
            console.log(json);
            console.log(errorThrown);
            toastr.error('Sorry, Something went wrong. Please try again later.');
          }
          });
    });

    $('.view_modal').on('hidden.bs.modal', function () {
        $(this).html('');
        table.ajax.reload();
    });

    $(document).on('click', '.massAction', function(){
        var ids = [];
        var table_name = $(this).data('tablename');
        if(confirm("Are you sure you want to " + $(this).html()  + "?"))
        {
            $('tr.selected').each(function(){
                ids.push($(this).data('id'));
            });
            if(ids.length > 0)
            {
                $.ajax({
                    url: $(this).data('action'),
                    method: "POST",
                    data: {ids:ids,table:table_name},
                    success:function(result)
                    {
                        if(result.success == true){
                            toastr.success(result.msg);
                        }
                        else{
                          if(result.msg){
                            toastr.error(result.msg);
                          }
                        }
                        table.ajax.reload();
                    },
                    error: function(jqXhr, json, errorThrown){
                      console.log(jqXhr);
                      console.log(json);
                      console.log(errorThrown);
                    }
                });
            }
            else
            {
                alert("Please select atleast one checkbox");
            }
        }
  });


  $(document).on('click', '.order_view_details', function() {
    console.log($(this).data('order_id'));
    console.log($(this).data('action'));
      $.ajax({
          url: $(this).data('action'),
          method: "POST",
          data: {data:$(this).data('order_id')},
          success:function(result)
          {
              $('.view_modal').html(result).modal();
          }
      });
  });

  // $(".data-list-view").on("dblclick", "tbody tr", function () {
  //   var id = $(this).data('id');
  //   $.ajax({
  //       url: $(this).data('action'),
  //       method: "POST",
  //       data: {data:$(this).data('id')},
  //       success:function(result)
  //       {
  //         if(typeof id !== 'undefined'){
  //           $('.view_modal').html(result).modal();
  //         }
  //       }
  //   });
  // });

  $(".column-select").on('change', function () {
    var value = $(this).find('option:selected').val();
    var column = $(this).data('column');
    table.column(column).search(value, false, false, false).draw();
  });

  // To append actions dropdown before add new button
  var actionDropdown = $(".actions-dropodown")
  actionDropdown.insertBefore($(".top .actions .dt-buttons"))
  var columnFilter = $(".column-filter")
  columnFilter.insertAfter($(".top .actions .dt-buttons"))

  // to check and uncheck checkboxes on click of <td> tag
  // $(".data-list-view, .data-thumb-view").on("click", "tbody td", function () {
  //   var dtCheckbox = $(this).parent("tr").find(".dt-checkboxes-cell .dt-checkboxes")
  //   $(this).closest("tr").toggleClass("selected");
  //   dtCheckbox.prop("checked", !dtCheckbox.prop("checked"))
  // });

  $(".dt-checkboxes").on("click", function () {
      if($(this).prop('checked')==true){
          $(this).closest("tr").addClass("selected");
      }else{
          $(this).closest("tr").removeClass("selected");
      }
  });

  $(".data-list-view, .data-thumb-view").on("click", "tbody td", function () {
    var dtCheckbox = $(this).parent("tr").find(".dt-checkboxes-cell .dt-checkboxes")
    $(this).closest("tr").toggleClass("selected");
    if($(this).closest("tr").hasClass("selected")==true){
        dtCheckbox.prop("checked",true);
    }else{
        dtCheckbox.prop("checked",false);
    }
  });

  $(".dt-checkboxes-select-all input").on("click", function () {
      if($(this).prop('checked')==true){
          $(".data-list-view").find("tbody tr").addClass("selected");
          $(".data-thumb-view").find("tbody tr").addClass("selected");
          $('.dt-checkboxes').prop('checked',true);
      }else{
          $(".data-list-view").find("tbody tr").removeClass("selected");
          $(".data-thumb-view").find("tbody tr").removeClass("selected");
          $('.dt-checkboxes').prop('checked',false);
      }
  });
  // Scrollbar
  if ($(".data-items").length > 0) {
    new PerfectScrollbar(".data-items", { wheelPropagation: false });
  }

  // Close sidebar
  $(".hide-data-sidebar, .cancel-data-btn").on("click", function () {
    $(".add-new-data").removeClass("show");
    $(".overlay-bg").removeClass("show");
    $("#data-name, #data-price").val("");
    $("#data-category, #data-status").prop('selectedIndex', 0);
  });

  // mac chrome checkbox fix
  if (navigator.userAgent.indexOf('Mac OS X') != -1) {
    $(".dt-checkboxes-cell input, .dt-checkboxes").addClass("mac-checkbox");
  }

  $(document).on('click', '.chip-closeable',function() {
    var target = $(this).data('target');
    if($(this).data('type') == "multiple") {
      var value = $("#"+target).val().split(',');
      const index = value.indexOf($(this).data('value').toString());
      if (index > -1) {
        value.splice(index, 1);
      }
      $("#"+target).val(value.join(',')).trigger('change');
    }
    else {
      $("#"+target).val('').trigger('change');
    }
  });

  $(document).on('click', '.filter_btn', function(event) {
      event.preventDefault();
      var target = $(this).data('target');
      if($(this).data('type') == "multiple") {
        if($("#"+target).val()==""){
          $("#"+target).val($(this).data('value')).trigger('change');
          $('#chip_area_'+target).append('<div class="chip chip-primary"><div class="chip-body"><span class="chip-text">'+$(this).html()+'</span><div class="chip-closeable" data-target="'+target+'" data-type="'+$(this).data('type')+'" data-value="'+$(this).data('value')+'"><i class="feather icon-x"></i></div></div></div>');
        }
        else {
          var value = $("#"+target).val().split(',');
          if($.inArray($(this).data('value').toString(), value) === -1){
            value.push($(this).data('value'));
            $("#"+target).val(value.join(',')).trigger('change');
            $('#chip_area_'+target).append('<div class="chip chip-primary"><div class="chip-body"><span class="chip-text">'+$(this).html()+'</span><div class="chip-closeable" data-target="'+target+'" data-type="'+$(this).data('type')+'" data-value="'+$(this).data('value')+'"><i class="feather icon-x"></i></div></div></div>');
          }
        }
      }
      else {
        $('#chip_area_'+target).html('<div class="chip chip-primary"><div class="chip-body"><span class="chip-text">'+$(this).html()+'</span><div class="chip-closeable" data-target="'+target+'" data-type="'+$(this).data('type')+'" data-value="'+$(this).data('value')+'"><i class="feather icon-x"></i></div></div></div>');
        $("#"+target).val($(this).data('value')).trigger('change');
      }
  });
});
