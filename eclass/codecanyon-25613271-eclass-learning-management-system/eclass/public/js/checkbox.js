"use Strict";

$(".permissionTable").on('click', '.selectall', function () {
    
    if ($(this).is(':checked')) {
        $(this).closest('tr').find('[type=checkbox]').prop('checked', true);
       
    } else {
        $(this).closest('tr').find('[type=checkbox]').prop('checked', false);
        
    }

    calcu_allchkbox();

});

$(".permissionTable").on('click', '.grand_selectall', function () {
    if ($(this).is(':checked')) {
        $('.selectall').prop('checked', true);
        $('.permissioncheckbox').prop('checked', true);
    } else {
        $('.selectall').prop('checked', false);
        $('.permissioncheckbox').prop('checked', false);
    }
});

$(function () {

    calcu_allchkbox();
    selectall();

});

function selectall(){
    
    $('.selectall').each(function (i) {

        var allchecked = new Array();

        $(this).closest('tr').find('.permissioncheckbox').each(function (index) {
            if ($(this).is(":checked")) {
                allchecked.push(1);
            } else {
                allchecked.push(0);
            }
        });

        if ($.inArray(0, allchecked) != -1) {
            $(this).prop('checked', false);
        } else {
            $(this).prop('checked', true);
        }

    });
}

function calcu_allchkbox(){

    var allchecked = new Array();

    $('.selectall').each(function (i) {

    
        $(this).closest('tr').find('.permissioncheckbox').each(function (index) {
            if ($(this).is(":checked")) {
                allchecked.push(1);
            } else {
                allchecked.push(0);
            }
        });


    });

    if ($.inArray(0, allchecked) != -1) {
        $('.grand_selectall').prop('checked', false);
    } else {
        $('.grand_selectall').prop('checked', true);
    }

}



$('.permissionTable').on('click', '.permissioncheckbox', function () {

    var allchecked = new Array;

    $(this).closest('tr').find('.permissioncheckbox').each(function (index) {
        if ($(this).is(":checked")) {
            allchecked.push(1);
        } else {
            allchecked.push(0);
        }
    });

    if ($.inArray(0, allchecked) != -1) {
        $(this).closest('tr').find('.selectall').prop('checked', false);
    } else {
        $(this).closest('tr').find('.selectall').prop('checked', true);
        
    }

    calcu_allchkbox();

});