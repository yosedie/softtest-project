/*==================================================================
                           status.js
====================================================================*/
"use Strict";

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(function () {

  $('.status').on('change', function () {

    var status = $(this).prop('checked') == true ? 1 : 0;
    var id = $(this).data('id');
   
    $.ajax({
      type: "POST",
      dataType: "json",
      url: url,
      data: {
        status: status,
        id: id
      },
      success: function (data) {
        // success function
      }
    });
  });


  $('.verified').on('change', function () {
    
    var verified = $(this).prop('checked') == true ? 1 : 0;
    var id = $(this).data('id');

    $.ajax({
      type: "POST",
      dataType: "json",
      url: verify,
      data: {
        verified: verified,
        id: id
      },
      success: function (data) {
       // success function
      }
    });
  });

});