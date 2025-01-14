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
    console.log(status);

    $.ajax({
      type: "POST",
      dataType: "json",
      url: url + '/homework/status',
      data: {
        'status': status,
        'id': id
      },
      success: function (data) {
        // success function
      }
    });
  });

  $('.compulsory').on('change', function () {
    var compulsory = $(this).prop('checked') == true ? 1 : 0;

    var id = $(this).data('id');


    $.ajax({
      type: "POST",
      dataType: "json",
      url: url + '/homework/compulsory',
      data: {
        'compulsory': compulsory,
        'id': id
      },
      success: function (data) {
        console.log(data)
      }
    });
  })

});