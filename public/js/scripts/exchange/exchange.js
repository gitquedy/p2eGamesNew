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

function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function applyPrices(type = "total", tab = "b"){
    var coinAmount = $("#"+tab+"_coin_amount");
    var totalAmount = $("#"+tab+"_totalAmount");
    var selectedCoin = $("#"+tab+"_coin").find(":selected");

    var price = selectedCoin.data('price');

    var coinAmountValue = 0;
    var totalAmountValue = 0;
    var qty = coinAmount.val();


    if(type == "total"){
        totalAmountValue = price * qty;
        totalAmount.val(addCommas(totalAmountValue.toFixed(2)));
    }else if(type == "coin"){
        coinAmountValue =  totalAmount.val() /  price;
        coinAmount.val(addCommas(coinAmountValue.toFixed(8)));
    }
}

$(document).ready(function(){
    var tab = $('.nav-link.active').data('script-tag');
    applyPrices("total", tab);

    $('#myTab a').on('shown.bs.tab', function () {
      tab = $('.nav-link.active').data('script-tag');
      applyPrices("total", tab);
    })

    $(".trigger_coin_amount").on('keyup', function(){
        applyPrices("total", tab);
    });

    $(".trigger_totalAmount").on('keyup', function(){
        applyPrices("coin", tab);
    });
    $(".trigger_coin").on('change', function(){
        $("#"+tab+"_coin_amount").val($("#"+tab+"_coin").find(":selected").data('value'));
        $("#"+tab+"_coin_amount").prop("step", $("#"+tab+"_coin").find(":selected").data('step'));
        applyPrices("total", tab);
    });

    $(".trigger_minus").on('click', function(){
        var step = $("#"+tab+"_coin").find(":selected").data('step');
        var value = $("#"+tab+"_coin_amount").val();

        value =  parseFloat(value) - parseFloat(step);
        if(value > 0){
            $("#"+tab+"_coin_amount").val(parseFloat(value.toFixed(4)));
            applyPrices("total", tab);
        }
    });

    $(".trigger_plus").on('click', function(){
        var step = $("#"+tab+"_coin").find(":selected").data('step');
        var value = $("#"+tab+"_coin_amount").val();

        value =  parseFloat(value) + parseFloat(step);
        $("#"+tab+"_coin_amount").val(parseFloat(value.toFixed(4)));
        applyPrices("total", tab);
    });
    $(".trigger_coin").trigger('change');
});
