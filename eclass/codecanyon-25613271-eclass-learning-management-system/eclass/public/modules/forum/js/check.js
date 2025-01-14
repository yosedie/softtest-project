"use Strict";

$(function () {
    $('.slider').on('change', function () {

        var status = $(this).prop('checked') == true ? 1 : 0;

        var user_id = $(this).data('id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            dataType: "json",
            url: url,
            data: {
                status: status,
                user_id: user_id
            },
            success: function (data) {
                // no code
            }
        });
    });

    $('#customSwitch1').on('change', function () {

        if ($('#customSwitch1').is(':checked')) {
            $('#section_one').show('fast');
        } else {
            $('#section_one').hide('fast');
        }
    
    });
    
});

