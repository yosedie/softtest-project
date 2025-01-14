@extends('admin.layouts.master')
@section('title','Edit Instructor')
@section('maincontent')
@component('components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __('Admin') }}
@endslot

@slot('menu2')
{{ __(' Edit Instructor') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <a href="{{ url('user') }}" class="float-right btn btn-primary-rgba mr-2"><i
      class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
</div>
@endslot

@endcomponent
<div class="contentbar dashboard-card">
  <div class="row">
    @if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('Edit') }} {{ __('Instructor') }}</h5>
        </div>
        <div class="card-body ml-2">
          <form action="{{ route('allinstructor.update',$user->id) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fname">
                    {{ __('FirstName') }}:
                    <sup class="text-danger">*</sup>
                  </label>
                  <input value="{{ $user->fname }}" autofocus required name="fname" type="text" class="form-control"
                    placeholder="{{ __('Please') }} {{ __('Enter') }} {{ __('First Name') }}" />
                </div>
                <div class="form-group">
                  <label for="lname">
                    {{ __('LastName') }}:
                    <sup class="text-danger">*</sup>
                  </label>
                  <input value="{{ $user->lname }}" required name="lname" type="text" class="form-control"
                    placeholder=" {{ __('Please') }} {{ __('Enter') }} {{ __('Last Name') }}" />
                </div>

                <div class="form-group">
                  <label for="mobile"> {{ __('Mobile') }}:</label>
                  <input value="{{ $user->mobile }}" type="text" name="mobile"
                    placeholder="{{ __('Please') }} {{ __('Enter') }} {{ __('Mobile') }}"
                    class="form-control">
                </div>
                <div class="form-group">
                  <label for="mobile">{{ __('Email') }}:<sup class="text-danger">*</sup> </label>
                  <input value="{{ $user->email }}" required type="email" name="email"
                    placeholder="{{ __('Please') }} {{ __('Enter') }} {{ __('Email') }}"
                    class="form-control">
                </div>
                <div class="form-group">
                  <label for="address">{{ __('Address') }}: </label>
                  <textarea name="address" class="form-control" rows="1"
                    placeholder="{{ __('Please') }} {{ __('Enter') }} adderss" value="">{{ $user->address }}</textarea>
                </div>
                
                <div class="form-group">
                  

                  <div class="row">
                    <div class="col-md-12">
                      <div class="update-password">
                        <label for="box1"> {{ __('UpdatePassword') }}:</label>
                        <input type="checkbox" id="myCheck" name="update_pass" class="custom_toggle" onclick="myFunction()">
                      </div>
                    </div>
                  </div>


                  <div style="display: none" id="update-password">
                  <div class="form-group">
                    <label>{{ __('Password') }}</label>
                    <input type="password" name="password" class="form-control"
                      placeholder="{{ __('Please') }} {{ __('Enter') }} {{ __('Password') }}">
                  </div>
               
              
                <div class="form-group" >
                  <label>{{ __('ConfirmPassword') }}</label>
                  <input type="password" name="confirmpassword" class="form-control"
                    placeholder="{{ __('Please') }} {{ __('Confirm Password') }}">
                </div>

              </div>
               
              </div>
               
                <div class="form-group">
                  <label for="twitter_url">
                    {{ __('Twitter Url') }}:
                  </label>
                  <input autofocus name="twitter_url" value="{{ $user->twitter_url }}" type="text" class="form-control"
                    placeholder="https://twitter.com" />
                </div>
                <div class="form-group">
                  <label for="linkedin_url">
                    {{ __('LinkedIn Url') }}:
                  </label>
                  <input autofocus name="linkedin_url" value="{{ $user->linkedin_url }}" type="text"
                    class="form-control" placeholder="https://linkedin.com" />
                </div>
              </div>
              <input name="role" type="hidden" value="instructor">

               <div class="form-group">
                  <label for="detail">{{ __('Detail') }}:<sup class="text-danger">*</sup></label>
                  <textarea id="detail" name="detail" class="form-control" rows="5"
                    placeholder="{{ __('Please') }} {{ __('Enter') }} {{ __('Detail') }}"
                    value="">{{ $user->detail }}</textarea>
                </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                  <label for="exampleInputDetails">{{ __('Verified') }}:<sup
                      class="redstar text-danger">*</sup></label><br>
                  <input id="verified" type="checkbox" class="custom_toggle" name="verified"
                    {{  $user->email_verified_at != NULL ? 'checked' : '' }} />
                

                </div>
                <div class="form-group">
                  <label for="exampleInputTit1e">{{ __('Status') }}:<sup
                      class="text-danger">*</sup></label><br>
                  <input type="checkbox" class="custom_toggle" name="status"
                    {{ $user->status == '1' ? 'checked' : '' }} />

                 
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
                    {{ __('Reset') }}</button>
                  <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
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

@endsection