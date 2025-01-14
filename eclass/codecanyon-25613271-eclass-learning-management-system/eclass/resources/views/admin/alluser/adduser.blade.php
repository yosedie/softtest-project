@extends('admin.layouts.master')
@section('title','Create a new student')
@section('maincontent')
<?php
$data['heading'] = 'Create A New Student';
$data['title'] = 'Create A New Student';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  @if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="box-tittle">{{ __('Create A New Student') }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{url('user')}}" class="float-right btn btn-primary-rgba mr-2" title="{{ __('Back') }}"><i
                  class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a> </div>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="bg-info-rgba p-4 mb-4">
              <h4 class="pb-4">{{ __('Personal Details') }}</h4>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="text-dark" for="fname">
                      {{ __('First Name') }}:<sup class="text-danger">*</sup>
                    </label>
                    <input value="{{ old('fname') }}" autofocus required name="fname" type="text" class="form-control"
                      placeholder="{{ __('Please Enter First Name') }}" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="text-dark" for="lname">
                      {{ __('Last Name') }}:<sup class="text-danger">*</sup>
                    </label>
                    <input value="{{ old('lname')}}" required name="lname" type="text" class="form-control"
                      placeholder="{{ __('Please Enter Last Name') }}" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="text-dark" for="mobile">{{ __('Email') }}: <sup
                        class="text-danger">*</sup></label>
                    <input value="{{ old('email')}}" required type="email" name="email"
                      placeholder=" {{ __('Please Enter Email') }}"
                      class="form-control">
                  </div>
                </div>
                <div class="col-md-3">                
                  <div class="form-group">
                    <label class="text-dark" for="mobile">{{ __('Mobile') }}: <sup
                        class="text-danger">*</sup></label>
                    <input value="{{ old('mobile')}}" required type="text" name="mobile"
                      placeholder="{{ __('Please Enter Mobile') }}"
                      class="form-control">
                  </div>                   
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="text-dark" for="mobile">{{ __('Password') }}: <sup
                        class="text-danger">*</sup> </label>
                    <input required type="password" name="password"
                      placeholder="{{ __('Please Enter Password') }}"
                      class="form-control">
                  </div>
                </div> 
                <div class="col-md-12">
                <div class="form-group">
                  <label class="text-dark" for="exampleInputDetails">{{ __('Detail') }}:</label>
                  <textarea id="detail" name="detail" rows="3" class="form-control"
                    placeholder="{{ __('Please Enter Detail') }}"></textarea>
                </div>
                </div>     
              </div>
            </div>

            <div class="bg-info-rgba p-4 mb-4">
              <h4 class="pb-4">{{ __('Address') }}</h4>
              <div class="row">
                <div class="col-md-3">
                  <input name="role" type="hidden" value="user">
                  <div class="form-group">
                    <label class="text-dark" for="exampleInputDetails">{{ __('Address') }}:</label>
                    <textarea name="address" rows="1" class="form-control"
                      placeholder="{{ __('Please Enter Address') }} "></textarea>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="text-dark" for="city_id">{{ __('City') }}: </label>
                    <input type="text" class="form-control" placeholder="{{ __('Please Enter City') }}" onchange="get_state_country(this.value)" required>
                    <input type="hidden" name="city_id" class="city_id"> 
                    <span class="error text-danger"></span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="text-dark" for="state_id">{{ __('State') }}: </label>
                    <input type="text" class="form-control state" placeholder="{{ __('Please Enter State') }} " readonly>     
                    <input type="hidden" name="state_id" class="state_id"> 
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="text-dark" for="city_id">{{ __('Country') }}: </label> 
                    <input type="text" class="form-control country" placeholder="{{ __('Please Enter Country') }}" readonly>     
                    <input type="hidden" name="country_id" class="country_id">          
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label class="text-dark" for="pin_code">{{ __('Pincode') }}:</sup></label>
                    <input value="{{ old('pin_code')}}" placeholder="{{ __('Please Enter pincode') }}"
                      type="text" name="pin_code" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="text-dark" for="exampleInputSlug">{{ __('Image') }}: </label>
                    <small class="text-muted"><i class="fa fa-question-circle"></i>
                      {{ __('Recommended size') }} (410 x 410px)</small>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                      </div>
                      <div class="custom-file">
                        <input accept="image/*" type="file" name="user_img" class="custom-file-input" id="user_img_one" aria-describedby="inputGroupFileAddon01" onchange="readURL(this);">
                        <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                      </div>
                    </div>
                    <div class="thumbnail-img-block mb-3">
                      <img src="{{ url('images/user_img/user.jpg')}}" id="user_img" class="img-fluid" alt="{{ __('')}}">
                    </div>   
                  </div>
                </div>
              </div>
            </div>

            <div class="bg-info-rgba p-4 mb-4">
              <h4 class="pb-4">{{ __('Social Profile') }}</h4>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="text-dark" for="fb_url">
                      {{ __('Facebook URL') }}:
                    </label>
                    <input autofocus name="fb_url" type="text" class="form-control" placeholder="https://facebook.com/" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="text-dark" for="youtube_url">
                      {{ __('YouTube URL') }}:
                    </label>
                    <input autofocus name="youtube_url" type="text" class="form-control" placeholder="https://youtube.com/" />
                  </div>

                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="text-dark" for="twitter_url">
                        {{ __('Twitter URL') }}:
                    </label>
                    <input autofocus name="twitter_url" type="text" class="form-control" placeholder="https://twitter.com/" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="text-dark" for="linkedin_url">
                        {{ __('LinkedIn URL') }}:
                    </label>
                    <input autofocus name="linkedin_url" type="text" class="form-control" placeholder="https://linkedin.com/" />
                  </div>
                </div>
              </div>
            </div>         
            
            <div class="form-group">
              <label for="exampleInputDetails">{{ __('Status') }}</label><br>
              <input id="status_toggle" type="checkbox" class="custom_toggle" name="status" checked />
            

            </div>
            <div class="form-group">
              <button type="reset" class="btn btn-danger-rgba" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __('Reset') }}</button>
              <button type="submit" class="btn btn-primary-rgba" title="{{ __('Create') }}"><i class="fa fa-check-circle"></i>
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
  (function ($) {
    "use strict";

    $('#married_status').change(function () {

      if ($(this).val() == 'Married') {
        $('#doaboxxx').show();
      } else {
        $('#doaboxxx').hide();
      }
    });

    $(function () {
      $("#dob,#doa").datepicker({
        changeYear: true,
        yearRange: "-100:+0",
        dateFormat: 'yy/mm/dd',
      });
    });
    $(function () {
      $('#country_id').change(function () {
        var up = $('#upload_id').empty();
        var cat_id = $(this).val();
        
        if (cat_id) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: @json(url('country/dropdown')),
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

      $('#upload_id').change(function () {
        var up = $('#grand').empty();
        var cat_id = $(this).val();
        if (cat_id) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: @json(url('country/gcity')),
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
  function get_state_country(params) {
    if(params){
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: @json(url('get/state/country')),
        data: {
          city: params
        },
        success: function (data) {
          if(data.status=='True'){
              $('.city_id').val(data.city_id);
              $('.state').val(data.state);
              $('.state_id').val(data.state_id);
              $('.country').val(data.country);
              $('.country_id').val(data.country_id);
              $('.error').hide();
          } else {
              $('.city_id').val('');
              $('.state').val('');
              $('.state_id').val('');
              $('.country').val('');
              $('.country_id').val('');
              $('.error').show();
              $('.error').text(data.msg);
          }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
        }
      });
    }
  }
</script>

@endsection