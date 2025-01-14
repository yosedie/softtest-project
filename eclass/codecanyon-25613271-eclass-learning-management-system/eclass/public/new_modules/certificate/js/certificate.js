"use strict";

$(function () {

    
    $('.my-colorpicker1').colorpicker({
        format: 'auto'
     });

    $('.my-colorpicker2').colorpicker();
     

    $('#logo_enable').change(function () {
        if ($('#logo_enable').is(':checked')) {
            $('#logo_one').show('fast');
        } else {
            $('#logo_one').hide('fast');
        }

    });

    $('#background_image_enable').change(function () {
        if ($('#background_image_enable').is(':checked')) {
            $('#background_one').show('fast');
        } else {
            $('#background_one').hide('fast');
        }

    });

    $('#date_enable').change(function () {
        if ($('#date_enable').is(':checked')) {
            $('#date_one').show('fast');
        } else {
            $('#date_one').hide('fast');
        }

    });

});