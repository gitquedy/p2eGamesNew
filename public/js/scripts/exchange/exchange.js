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

function applyPrices(type = "total"){
    console.log(type);
    var coinAmount = $('#coin_amount');
    var totalAmount = $('#totalAmount');

    var selectedCoin = $('#coin').find(":selected");

    var price = selectedCoin.data('price');
    var minimumPrice = selectedCoin.data('minimum-price');
    var markupPrice = selectedCoin.data('markup-price');

    // var exchangeFixPrice = {{ $exchangeFixPrice }};

    var usePrice = 0;
    var coinAmountValue = 0;
    var totalAmountValue = 0;
    var qty = coinAmount.val();

    if(price < minimumPrice){
        usePrice = minimumPrice;
    }else{
        usePrice = price;
    }

    if(type == "total"){
        totalAmountValue = ((usePrice * (markupPrice / 100) + usePrice) * qty);
        totalAmount.val(addCommas(totalAmountValue.toFixed(2)));
    }else if(type == "coin"){
        coinAmountValue =  totalAmount.val() /  ((usePrice * (markupPrice / 100) + usePrice));
        coinAmount.val(addCommas(coinAmountValue.toFixed(8)));
    }
}

$(document).ready(function(){
    applyPrices("total");
    $("#coin_amount").on('keyup', function(){
        applyPrices("total");
    });

    $("#totalAmount").on('keyup', function(){
        applyPrices("coin");
    });
    $('#coin').on('change', function(){
        $('#coin_amount').val(1);
        applyPrices("total");
    });
});
