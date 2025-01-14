@extends('admin.layouts.master')
@section('title','Edit User')
@section('maincontent')
<?php
$data['heading'] = 'Edit User';
$data['title'] = 'Setting';
$data['title1'] = 'Mobile Setting';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  <div class="row">
    @if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('Edit User') }}</h5>
          <div class="widgetbar">
            <a href="{{ route('user.index') }}" class="float-right btn btn-primary-rgba mr-2" title="{{ __('Back') }}"><i
                class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
          </div>
        </div>
        <div class="card-body ml-2">
          <form action="{{ route('user.update',$user->id) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="bg-info-rgba p-4 mb-4">
              <h4 class="pb-4">{{ __('Personal Details') }}</h4>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fname">
                      {{ __('First Name') }}:
                      <sup class="text-danger">*</sup>
                    </label>
                    <input value="{{ $user->fname }}" autofocus required name="fname" type="text" class="form-control"
                      placeholder="{{ __('Please Enter First Name') }}" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="lname">
                      {{ __('Last Name') }}:
                      <sup class="text-danger">*</sup>
                    </label>
                    <input value="{{ $user->lname }}" required name="lname" type="text" class="form-control"
                      placeholder="{{ __('Enter Last Name') }}" />
                  </div>
                </div>
                <div class="col-md-3">            
                  <div class="form-group">
                    <label for="mobile">{{ __('Email') }}:<sup class="text-danger">*</sup> </label>
                    <input value="{{ $user->email }}" required type="email" name="email"
                      placeholder="{{ __('Enter Email') }}"
                      class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="mobile"> {{ __('Mobile') }}:</label>
                    <input value="{{ $user->mobile }}" type="text" name="mobile"
                      placeholder="{{ __('Enter Mobile') }}"
                      class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="role">{{ __('Select Role') }}:</label>
                    @if(Auth::User()->role=="admin")
                    <select class="form-control select2" name="role">
                      <option value="">{{  __("Please select role") }}</option>
                      @foreach($roles as $role)
                      <option {{ $user->getRoleNames()->contains($role->name) ? 'selected' : "" }}
                        value="{{ $role->name }}">{{ $role->name }}</option>
                      @endforeach
                    </select>
                    @endif
                    @if(Auth::User()->role=="instructor")
                    <select class="form-control select2" name="role">
                      <option {{ $user->role == 'user' ? 'selected' : ''}} value="user">{{ __('User') }}
                      </option>
                      <option {{ $user->role == 'instructor' ? 'selected' : ''}} value="instructor">
                        {{ __('Instructor') }}</option>
                    </select>
                    @endif
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="detail">{{ __('Detail') }}:<sup class="text-danger">*</sup></label>
                    <textarea id="detail" name="detail" class="form-control" rows="5"
                      placeholder="{{ __('Enter Detail') }}"
                      value="">{{ $user->detail }}</textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-info-rgba p-4 mb-4">
              <h4 class="pb-4">{{ __('Address') }}</h4>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="address">{{ __('Address') }}: </label>
                    <textarea name="address" class="form-control" rows="1"
                      placeholder="{{ __('Enter Adderss') }}" value="">{{ $user->address }}</textarea>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                      <label class="text-dark" for="city_id">{{ __('City') }}: </label>
                      <input type="text" class="form-control" placeholder="{{ __('Please') }} {{ __('Enter City') }}" onchange="get_state_country(this.value)" value="{{$cities?$cities->name:''}}">
                      <input type="hidden" name="city_id" value="{{$user->id}}" class="city_id"> 
                      <span class="error text-danger"></span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="text-dark" for="state_id">{{ __('State') }}: </label>
                    <input type="text" class="form-control state" placeholder="{{ __('Please Enter State') }}" value="{{$states?$states->name:''}}" readonly>     
                    <input type="hidden" name="state_id" value="{{$user->state_id}}" class="state_id"> 
                  </div>
                </div>
                <div class="col-md-3">
                 <div class="form-group">
                    <label class="text-dark" for="city_id">{{ __('Country') }}: </label> 
                    <input type="text" class="form-control country" placeholder="{{ __('Please Enter Country') }}" value="{{$countries?$countries->name:''}}" readonly>     
                    <input type="hidden" name="country_id" value="{{$user->country_id}}" class="country_id"> 
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="pin_code">{{ __('Pincode') }}:</label>
                    <input value="{{ $user->pin_code }}"
                      placeholder="{{ __('Enter Pincode') }}" type="text"
                      name="pin_code" class="form-control">
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
                        <input type="file" name="user_img" class="custom-file-input" id="user_img_one" aria-describedby="inputGroupFileAddon01" onchange="readURL(this);">
                        <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                      </div>
                    </div>
                    <div class="thumbnail-img-block mb-3">
                      @if($user->user_img != null || $user->user_img !='')
                      <div class="edit-user-img">
                        <img src="{{ url('/images/user_img/'.$user->user_img) }}"  alt="User Image"  id="user_img" class="img-responsive image_size">
                      </div>
                      @else
                      <div class="edit-user-img">
                        <img src="{{ asset('images/default/user.jpg')}}"  alt="User Image"  id="user_img" class="img-responsive img-circle">
                      </div>
                      @endif                 
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
                    <label for="fb_url">
                      {{ __('Facebook URL') }}:
                    </label>
                    <input autofocus name="fb_url" value="{{ $user->fb_url }}" type="text" class="form-control"
                      placeholder="Facebook.com/" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="youtube_url">
                      {{ __('YouTube URL') }}:
                    </label>
                    <input autofocus name="youtube_url" value="{{ $user->youtube_url }}" type="text" class="form-control"
                      placeholder="youtube.com/" />
                    </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="twitter_url">
                      {{ __('Twitter URL') }}:
                    </label>
                    <input autofocus name="twitter_url" value="{{ $user->twitter_url }}" type="text" class="form-control"
                      placeholder="Twitter.com/" />
                  </div>
                </div>
                <div class="col-md-3">
                   <div class="form-group">
                    <label for="linkedin_url">
                      {{ __('LinkedIn URL') }}:
                    </label>
                    <input autofocus name="linkedin_url" value="{{ $user->linkedin_url }}" type="text"
                      class="form-control" placeholder="Linkedin.com/" />
                  </div>
              </div>              
              <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputDetails">{{ __('Verified') }}:<sup class="redstar text-danger">*</sup></label><br>
                    <input id="verified" type="checkbox" class="custom_toggle" name="verified" {{  $user->email_verified_at != NULL ? 'checked' : '' }} />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputTit1e">{{ __('Status') }}:<sup
                        class="text-danger">*</sup></label><br>
                    <input type="checkbox" class="custom_toggle" name="status"
                      {{ $user->status == '1' ? 'checked' : '' }} />

                  </div>
              </div>
              <div class="col-md-4">                                
                <div class="form-group">                  

                  <div class="row">
                    <div class="col-md-12">
                      <div class="update-password">
                        <label for="box1"> {{ __('Update Password') }}:</label>
                        <br>
                        <input type="checkbox" id="myCheck" name="update_pass" class="custom_toggle" onclick="myFunction()">
                      </div>
                    </div>
                  </div>
                  <div style="display: none" id="update-password">
                  <div class="form-group">
                    <label>{{ __('Password') }} <sup class="text-danger">*</sup></label>
                    <input type="password" name="password" class="form-control"
                      placeholder="{{ __('Enter') }} {{ __('Password') }}">
                  </div>            
              
                <div class="form-group" >
                  <label>{{ __('Confirm Password') }} <sup class="text-danger">*</sup></label>
                  <input type="password" name="confirmpassword" class="form-control"
                    placeholder="{{ __('Confirm Password') }}">
                </div>
              </div>               
              </div>               
              </div>
            </div>
            </div>           
            <div class="form-group">
              <button type="reset" class="btn btn-danger-rgba" title="{{ __('Reset') }}"><i class="fa fa-ban"></i>
                {{ __('Reset') }}</button>
              <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update') }}"><i class="fa fa-check-circle"></i>
                {{ __('Update') }}</button>
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

    $(function () {
      $("#dob,#doa").datepicker({
        changeYear: true,
        yearRange: "-100:+0",
        dateFormat: 'yy/mm/dd',
      });
    });
    $('#married_status').change(function () {

      if ($(this).val() == 'Married') {
        $('#doaboxxx').show();
      } else {
        $('#doaboxxx').hide();
      }
    });

    $(function () {
      var urlLike = '{{ url('
      country / dropdown ') }}';
      $('#country_id').change(function () {
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
      country / gcity ') }}';
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


<script>
  (function($) {
    "use strict";
    $(function(){
        $('#myCheck').change(function(){
          if($('#myCheck').is(':checked')){
            $('#update-password').show('fast');
          }else{
            $('#update-password').hide('fast');
          }
        });
        
    });
  })(jQuery);
  </script>

  <script>
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