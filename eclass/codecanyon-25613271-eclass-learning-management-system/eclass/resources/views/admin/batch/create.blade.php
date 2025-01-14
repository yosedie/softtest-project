@extends('admin.layouts.master')
@section('title','Create a new batch')
@section('maincontent')
<?php
$data['heading'] = 'Add Batch';
$data['title'] = 'Courses';
$data['title1'] = 'Batches';
$data['title1'] = 'Add Batch';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  @if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
<div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-box">{{ __('Add Batch') }}</h5>
          <div class="widgetbar">
            <a href="{{ url('batch') }}" class="float-right btn btn-primary mr-2" title="{{ __('Back') }}"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
          </div>
        </div>
        <div class="card-body">
          <form action="{{url('batch/')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
             
                <div class="form-group col-md-3">
                  <label for="exampleInputTit1e">{{ __('Batch Name') }}: <sup class="text-danger">*</sup></label>
                  <input type="title" class="form-control" name="title" id="exampleInputTitle"
                    placeholder="{{ __('Enter Batch Name') }}" value="" required>

                </div>
                  
                <div class="form-group col-md-3">
                  <label>{{ __('Image') }}:<sup class="redstar">*</sup></label>              
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                    </div>
                    <div class="custom-file">
                      <input accept="image/*" type="file" class="custom-file-input" id="inputGroupFile01" name="preview_image" aria-describedby="inputGroupFileAddon01">
                      <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                      
                    </div>

                  </div>
                  <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('Recommended size') }} (1375 x 409px)</small>

                </div> 

                <div class="form-group col-md-3">
                  <label>{{ __('Select Course') }}: <span
                      class="text-danger">*</span></label>
                  <select id="course_id"class="form-control select2" name="allowed_courses" 
                    size="5" row="5"
                    placeholder="{{ __('Select Course') }}">


                    @foreach ($courses as $cat)
                    @if($cat->status == 1)
                    <option value="{{ $cat->id }}">{{ $cat->title }}
                    </option>
                    @endif

                    @endforeach

                  </select>
                </div>


                <div class="form-group col-md-3">
                  <label>{{ __('Select Users') }}: <span
                      class="text-danger">*</span></label>
                  <select id="upload_id" class="form-control select2" name="allowed_users[]" multiple="multiple"
                    size="5" row="5" placeholder="{{ __('Select Users') }}">


                    @foreach ($users as $user)
                    @if($user->status == 1)
                    <option value="{{ $user->id }}">{{ $user->fname }}
                    </option>
                    @endif

                    @endforeach

                  </select>
                </div>

               

                <div class="row">
                  <div class="col-md-12">
                    <label for="exampleInputTit1e">{{ __('Details') }}: <sup
                        class="text-danger">*</sup></label>
                        <textarea  name="detail" rows="1"  class="form-control" placeholder="{{ __('Enter Detail') }}" ></textarea>
                  </div>
                </div>
                    <div class="form-group col-md-6">
                      @if(Auth::User()->role == "admin")
                      <label for="exampleInputDetails">{{ __('Status') }}:</label><br>
                      <input id="status_toggle" type="checkbox" class="custom_toggle" name="status" checked/>
                   
                      @endif
                    </div>
               
                <div class="form-group col-md-6">
                  <button type="reset" class="btn btn-danger" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __('Reset') }}</button>
                  <button type="submit" class="btn btn-primary" title="{{ __('Create') }}"><i class="fa fa-check-circle"></i>
                    {{ __('Create') }}</button>
                </div>

                <div class="clear-both"></div>
      
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@section('script')
<script>
//  $(document).on('change','#course_id',function(){
  $(document.body).on('change','#course_id',function(){

        var up = $('#upload_id').empty();
        var cat_id = jQuery('#course_id').val();

        
       
        if (cat_id) {
          //alert(cat_id);
          $.ajax({
            type: "GET",
            url: @json(url('dropdowns')),
            data: {
              catId: cat_id
            },
            success: function (data) {
              // up.append('<option value="0">Please Choose</option>');
                $.each(data, function(key,value) {
                  console.log(value);

                  $('#upload_id')
                    .append($("<option></option>")
                    .attr("value", value.id)
                    .text(value.user.fname)); 

                // up.append($('<option>', {
                //   value: value.id
                //   text: 'hello'
                // }));
                  // $.each( value, function( index2, sub_record ) {
                    
                  // });
                }); 

              // var data = JSON.parse(data);
              // console.log(data);
        //       up.append('<option value="0">Please Choose</option>');
        //       $.each(data, function (key,val) {
        //         console.log(val);
        //         up.append($('<option>', {
        //           value: '1'
        //           text: 'hello'
        //         }));
        //       });
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
            }
          });
        }
      });

</script>


<script>
  (function ($) {
    "use strict";

alert("hello");
    $(function () {
      $('.js-example-basic-single').select2();
    });

    $(function () {
      $('#cb1').change(function () {
        $('#j').val(+$(this).prop('checked'))
      })
    })

    $(function () {
      $('#cb3').change(function () {
        $('#test').val(+$(this).prop('checked'))
      })
    })

    $('#cb111').on('change', function () {

      if ($('#cb111').is(':checked')) {
        $('#pricebox').show('fast');

        $('#priceMain').prop('required', 'required');

      } else {
        $('#pricebox').hide('fast');

        $('#priceMain').removeAttr('required');
      }

    });

    $('#preview').on('change', function () {

      if ($('#preview').is(':checked')) {
        $('#document1').show('fast');
        $('#document2').hide('fast');
      } else {
        $('#document2').show('fast');
        $('#document1').hide('fast');
      }

    });

    $("#cb3").on('change', function () {
      if ($(this).is(':checked')) {
        $(this).attr('value', '1');
      } else {
        $(this).attr('value', '0');
      }
    });

    $(function () {

      $('#ms').change(function () {
        if ($('#ms').val() == 'yes') {
          $('#doabox').show();
        } else {
          $('#doabox').hide();
        }
      });

    });

    $(function () {

      $('#ms').change(function () {
        if ($('#ms').val() == 'yes') {
          $('#doaboxx').show();
        } else {
          $('#doaboxx').hide();
        }
      });

    });

    $(function () {

      $('#msd').change(function () {
        if ($('#msd').val() == 'yes') {
          $('#doa').show();
        } else {
          $('#doa').hide();
        }
      });

    });

    $(function () {
      var urlLike = '{{ url('
      admin / dropdown ') }}';
      $('#category_id').change(function () {
        var up = $('#upload_id').empty();
        var cat_id = $(this).val();
        if (cat_id) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: urlLike,
            data: {
              catId: cat_id
            },
            success: function (data) {
              console.log(data);
              up.append('<option value="0">Please Choose</option>');
              $.each(data, function (id, title) {
                up.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
            }
          });
        }
      });
    });

    $(function () {
      var urlLike = '{{ url('
      admin / gcat ') }}';
      $('#upload_id').change(function () {
        var up = $('#grand').empty();
        var cat_id = $(this).val();
        if (cat_id) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: urlLike,
            data: {
              catId: cat_id
            },
            success: function (data) {
              console.log(data);
              up.append('<option value="0">Please Choose</option>');
              $.each(data, function (id, title) {
                up.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
            }
          });
        }
      });
    });
  })(jQuery);
</script>
@endsection