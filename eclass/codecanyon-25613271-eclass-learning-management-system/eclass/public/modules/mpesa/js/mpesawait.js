"use Strict";

setTimeout(() => {
    location.href = orderreviewUrl;
}, 70000);

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var myVar;

myVar = setInterval(function () {

    $.ajax({

        type: 'POST',
        dataType: 'json',
        url: verifypaymentUrl,
        success: function (data) {

            if (data.resultCode == 0) {
                clearInterval(myVar);
                $('.payment_status').html(data.msg);
                setTimeout(function () {
                    location.href = ordersuccessUrl + data.order_id;
                }, 2500);

            } else {
                clearInterval(myVar);
                $('.payment_status').html(data.msg).removeClass('text-primary').addClass('text-danger');
                setTimeout(function () {
                    location.href = orderreviewUrl;
                }, 2500);


            }

        }

    });

}, 3000);