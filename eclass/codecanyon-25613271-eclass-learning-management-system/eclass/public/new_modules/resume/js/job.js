/*==================================================================
                           job.js
====================================================================*/
"use Strict";

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(function () {

  $('a[data-toggle="pill"]').on('show.bs.tab', function (e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
  });

  var activeTab = localStorage.getItem('activeTab');

  if (activeTab) {
    $('#v-pills-tab a[href="' + activeTab + '"]').tab('show');
  }

  $('.status').on('change', function () {
    var status = $(this).prop('checked') == true ? 1 : 0;

    var id = $(this).data('id');


    $.ajax({
      type: "POST",
      dataType: "json",
      url: url + '/admin/jobstatus',
      data: {
        status: status,
        id: id
      },
      success: function (data) {
        // success function
      }
    });
  });

  $('.approved').on('change', function () {
    var approved = $(this).prop('checked') == true ? 1 : 0;

    var id = $(this).data('id');


    $.ajax({
      type: "POST",
      dataType: "json",
      url: url + '/admin/jobapproved',
      data: {
        approved: approved,
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
      url: url + '/admin/jobverified',
      data: {
        verified: verified,
        id: id
      },
      success: function (data) {
        // success function
      }
    });
  });


  $('.custom-control-input').on('change', function () {

    var status = $(this).prop('checked') == true ? 1 : 0;
    var id = $(this).data('id');

    $.ajax({
      type: "POST",
      dataType: "json",
      url: url + '/job/userstatus',
      data: {
        status: status,
        id: id
      },
      success: function (data) {
        // success function
      }
    });
  });

});

