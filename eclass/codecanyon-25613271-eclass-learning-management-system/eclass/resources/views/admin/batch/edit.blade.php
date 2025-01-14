@extends('admin.layouts.master')
@section('title','Edit Batch')
@section('maincontent')
<?php
$data['heading'] = 'Edit Batch';
$data['title'] = 'Courses';
$data['title1'] = 'Batches';
$data['title1'] = 'Edit Batch';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-box">{{ __('Edit Batch') }}</h5>
          <div class="widgetbar">
            <a href="{{ url('batch') }}" class="float-right btn btn-primary mr-2" title="{{ __('Back') }}"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
          </div>
        </div>
        <div class="card-body ml-2">
          <form action="{{route('batch.update',$cor->id)}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="form-group col-md-3">
                  <label for="exampleInputTit1e">{{ __('Batch Name') }}:<sup class="redstar">*</sup></label>
                  <input type="text" class="form-control" name="title" id="exampleInputTitle" value="{{ $cor->title }}">
                </div>
                <div class="form-group col-md-3">
                  <label>{{ __('Image') }}:<sup class="redstar">*</sup></label>
                  <small class="text-muted"><i class="fa fa-question-circle"></i>
                    {{ __('Recommended Size') }} (1375 x 409px)</small>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                    </div>
                    <div class="custom-file">
                      <input accept="image/*" type="file" class="custom-file-input" id="image" name="image"
                        aria-describedby="inputGroupFileAddon01">
                      <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  @if($cor['preview_image'] !== NULL && $cor['preview_image'] !== '')
                  <img src="{{ url('/images/batch/'.$cor->preview_image) }}" class="image_size"/>
                  @else
                  <img src="{{ Avatar::create($cor->title)->toBase64() }}" alt="course" class="img-fluid">
                  @endif
                </div>
                <div class="form-group col-md-3">
                  <label>{{ __('Select Course') }}: <span class="redstar">*</span></label>
                  <select id="course_id" class="form-control js-example-basic-single" name="allowed_courses"
                    size="5" row="5" placeholder="{{ __('Select Courses') }}">

                    @foreach ($courses as $cat)
                    @if($cat->status == 1)
                    <option value="{{ $cat->id }}"
                      {{ $cat->allowed_courses == $cat->allowed_courses ? 'selected' : ''}}>
                      {{ $cat->title }}
                    </option>                 
                    @endif

                    @endforeach

                  </select>
                </div>

                <div class="form-group col-md-3">
                  <label>{{ __('Select Users') }}: <span
                      class="redstar">*</span></label>
                  <select id="upload_id" class="form-control js-example-basic-single" name="allowed_users[]" multiple="multiple"
                    size="5" row="5" placeholder="{{ __('Select Users') }}">

                    @foreach ($users as $user)
                    @if($user->status == 1)
                    <option value="{{ $user->id }}"
                      {{in_array($user->id, $cor['allowed_users'] ?: []) ? "selected": ""}}>{{ $user->fname }}
                    </option>
                    @endif

                    @endforeach

                  </select>
                </div>
                <div class="form-group col-md-12">
                  <div class="form-group">
                    <label for="exampleInputDetails">{{ __('Details') }}:<sup
                        class="redstar">*</sup></label>
                    <textarea name="detail" rows="3" class="form-control">{!! $cor->detail !!}</textarea>
                  </div>
                </div>

              
                <div class="form-group col-md-3">
                  @if(Auth::User()->role == "admin")
                  <label for="exampleInputTit1e">{{ __('Status') }}</label>
                  <input type="checkbox" class="custom_toggle" name="status"  {{ $cor->status==1 ? 'checked' : '' }}/>
                 
                @endif                
                </div>
              </div>
 

             

                <div class="form-group">
                  <button type="reset" class="btn btn-danger" title="{{ __('Reset') }}"><i class="fa fa-ban"></i>
                    {{ __('Reset') }}</button>
                  <button type="submit" class="btn btn-primary" title="{{ __('Update') }}"><i class="fa fa-check-circle"></i>
                    {{ __('Update') }}</button>
                </div>
                <div class="clear-both"></div>

            </div>
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


    $(function () {
      $('.js-example-basic-single').select2();
    });

    $(function () {
      $('#cb1').change(function () {
        $('#f').val(+$(this).prop('checked'))
      })
    })

    $(function () {
      $('#cb3').change(function () {
        $('#test').val(+$(this).prop('checked'))
      })
    })

    $(function () {

      $('#murl').change(function () {
        if ($('#murl').val() == 'yes') {
          $('#doab').show();
        } else {
          $('#doab').hide();
        }
      });

    });

    $(function () {

      $('#murll').change(function () {
        if ($('#murll').val() == 'yes') {
          $('#doabb').show();
        } else {
          $('#doab').hide();
        }
      });

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

  })(jQuery);
</script>

@endsection