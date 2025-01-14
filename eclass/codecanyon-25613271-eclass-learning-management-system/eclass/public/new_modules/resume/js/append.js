/*==================================================================
                           append.js
====================================================================*/
"use Strict";

var i = 0;

$("#addacademic").on('click', function () {
    ++i;
    $(".dynamicTable").append('<div class=" ml-md-0 mr-1  row aceadd">' +
        '<input type="hidden" name="user_id[]"  value="' + user + '">' +
        '<div class="form-group col-md-6">' +
        ' <label class="control-label">Course/Degree <span class="text-danger">*</span></label>' +
        ' <input type="text" name="course[]" required="required" class="form-control" placeholder="Course/Degree"/>' +
        '  </div>' +
        ' <div class="form-group col-md-6">' +
        '  <label class="control-label">School/College/University Name <span class="text-danger">*</span></label>' +
        '<input  type="text"  name="school[]" required="required" class="form-control"  placeholder="School/College/University Name"/>' +
        ' </div>' +
        '<div class="form-group col-md-6" >' +
        '<label class="control-label">Marks/CGPA <span class="text-danger">*</span></label>' +
        '<input  type="text"  name="marks[]" class="form-control input_cgpa"  placeholder="Marks/CGPA"/>' +
        ' </div>' +
        ' <div class="form-group col-md-6"  id="existingCustomer1">' +
        ' <label class="control-label">Year of passing <span class="text-danger">*</span></label>' +
        ' <input  type="date" name="yearofpassing[]"  class="form-control"  placeholder="Year Of passing"/>' +
        '</div>' +
        '<div class="col-md-12">' +
        ' <div class="form-group">' +
        '<button type="button"  id="addacademic" class="remove-tr action-button btn btn-outline-danger rounded">Remove</button>' +
        '</div>' +
        '</div>' +
        '</div>'

    );
});

$(document).on('click', '.remove-tr', function () {
    $(this).closest('div.aceadd').remove();
});

$("#addwork").on('click', function () {
    ++i;

    $(".workinghistory").append('<div class="row ml-md-0 mr-1 addwork">' +
        '<input type="hidden" name="job[' + i + '][user_id]"  value="' + user + '"></input>' +
        '<div class="form-group col-md-6">' +
        '<label class="control-label">Job Title <span class="text-danger">*</span></label>' +
        '<input  type="text"  name="jobtitle[]" required="required" class="form-control"  placeholder="Job Title"/>' +
        '</div>' +
        '<div class="form-group col-md-6">' +
        '<label class="control-label">Employer <span class="text-danger">*</span></label>' +
        ' <input  type="text"  name="employer[]" required="required" class="form-control"  placeholder="Employer" />' +
        ' </div>' +
        ' <div class="form-group col-md-6">' +
        '<label class="control-label">City <span class="text-danger">*</span></label>' +
        '<input  type="text" name="city[]" required="required" class="form-control"    placeholder="city"/>' +
        '</div>' +
        '<div class="form-group col-md-6">' +
        '<label class="control-label">State <span class="text-danger">*</span></label>' +
        '<input  type="text" name="state[]" required="required" class="form-control"   placeholder="state"/>' +
        '</div>' +
        '<div class="form-group col-md-6">' +
        ' <label class="control-label">Start Date <span class="text-danger">*</span></label>' +
        '<input  type="date" name="startdate[]" required="required" class="form-control"    placeholder="Select"/>' +
        '</div>' +
        '<div class="form-group col-md-6">' +
        '<label class="control-label">End Date <span class="text-danger">*</span></label><br>' +
        '<input  type="date" name="enddate[]"  class="form-control answer" placeholder="Select"/>' +
        '</div>' +
        '<div class="col-md-12 form-group">' +
        '<button type="button"  id="addacademic" class="removework action-button btn btn-outline-danger rounded">Remove</button>' +
        '</div>' +
        '</div>'
    );
});

$(document).on('click', '.removework', function () {
    $(this).closest('div.addwork').remove();
});

$("#addproject").on('click', function () {

    ++i;

    $(".project").append('<div class="row ml-md-0 mr-1 removeproject">' +
        '<input type="hidden" name="project[' + i + '][user_id]"  value="' + user + '"></input>' +
        '<div class="form-group col-md-6">' +
        ' <label class="control-label">Project Title <span class="text-danger">*</span></label>' +
        '<input  type="text" name="projecttitle[]" required="required" class="form-control"  placeholder="Project Title"/>' +
        '</div>' +
        '<div class="form-group col-md-6">' +
        '<label class="control-label">Role <span class="text-danger">*</span></label>' +
        '<input  type="text" name="role[]" required="required" class="form-control"    placeholder="Role"/>' +
        '</div>' +
        '<div class="form-group col-md-12">' +
        '<label class="control-label">Description <span class="text-danger">*</span></label>' +
        '<input  type="text" name="description[]" required="required" class="form-control"  placeholder="description" />' +
        '</div>' +
        '<div class="col-md-12 form-group">' +
        '<button type="button"  id="addacademic" class="removeproj action-button btn btn-outline-danger rounded">Remove</button>' +
        '</div>' +
        '</div>');


});

$(document).on('click', '.removeproj', function () {
    $(this).closest('div.removeproject').remove();
});

$('#dynamic_field').on('click', '.add', function () {
    i++;
    $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"> <td>' +
        '<input type="text" name="course[]" class="" ></td>' +
        '<td><input type="text" class="" name="school[]"></td>' +
        '<td><input type="text"name="marks[]" ></td>' +
        '<td><input class="w-50" type="text" name="yearofpassing">' +
        '<button type="button" name="remove" id="' + i + '" class="btn btn-outline-danger btn-rounded btn-sm btn_remove ml-1">X</button></td></tr>');
});


$(document).on('click', '.btn_remove', function () {
    var button_id = $(this).attr("id");
    $('#row' + button_id + '').remove();
});


$(document).on('ready', function () {

    var i = 1;

    $('#dynamic_field1').on('click', '.add1', function () {
        i++;
        $('#dynamic_field1').append('<tr id="row' + i + '" class="dynamic-added1">' +
            '<td><input type="text" name="startdate[]" class="w-100" ></td>' +
            '<td><input type="text" class="" class="w-100" name="enddate[]" ></td>' +

            '<td ><input type="text" class="w-100"  name="city[]" ></td>' +
            '<td ><input type="text"  class="w-100" name="state[]"  ></td>' +
            '<td ><input type="text"  class="w-100"  name="jobtitle[]" ></td>' +

            '<td><input type="text" class="w-50" name="employer[]" >' +

            '<button type="button" name="remove" id="' + i + '" class="btn btn-outline-danger btn-rounded btn-sm btn_remove1 ml-1">X</button></td></tr>');
    });


    $(document).on('click', '.btn_remove1', function () {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });

});


$(document).on('ready', function () {

    var i = 1;

    $('#dynamic_field2').on('click', '.add2', function () {
        i++;
        $('#dynamic_field2').append('<tr id="row' + i + '" class="dynamic-added2">' +
            ' <td><input type="text" class="w-100" name="projecttitle[]"></td>' +
            '<td><input type="text"  class="w-100" name="role[]"></td>' +
            ' <td><textarea  class="w-100 form-con mt-1"  name="description[]"></textarea></td>' +
            '<td><button type="button" name="remove" id="' + i + '" class="btn btn-outline-danger btn-rounded btn-sm btn_remove1 ml-1">X</button></td></tr>');
    });


    $(document).on('click', '.btn_remove1', function () {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });

});


$(function () {
    
    $(".fresher").on('click', function () {
        if ($(this).is(":checked")) {
            $(".exp").hide();
        } else {
            $(".exp").show();
        }
    });

    $(".job").on('click', function () {
        if ($(this).is(":checked")) {
            $(".upload_resume").hide();
        } else {
            $(".upload_resume").show();
        }
    });

});