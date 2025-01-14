@extends('admin.layouts.master')
@section('title', 'Setting - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Setting';
$data['title'] = 'Setting';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Add Google Calendar Setting') }}</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <form action="{{ route('googlecalendar.notification') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>{{ __('Google Calendar Id :') }}</label>
                    <!-- ---------- -->
                    <input id="google_cal_id"  placeholder="Please Enter Google Calendar Id" class="form-control" type="password" name="GOOGLE_CALENDAR_ID" value="{{ $env_files['GOOGLE_CALENDAR_ID'] }}">
                    <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                    <!-- ---------- -->
                    <!-- <input type="text"  name="GOOGLE_CALENDAR_ID" value="{{ $env_files['GOOGLE_CALENDAR_ID'] }}" class="form-control"> -->
                </div>
                <!-- Status -->
                <div class="form-group">
                    <label for="exampleInputDetails">{{ __('Status :') }}</label><br>
                    <input type="checkbox" class="custom_toggle" name="notification_enable" {{ $setting->notification_enable == '1' ? 'checked' : '' }} />
                    <input type="hidden"  name="free" value="0" for="status" id="status">
                </div>
    
                <div class="form-group">
                  <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                  <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                  {{ __("Update")}}</button>
                </div>
    
              </form>
            </div>
    
            <div class="col-md-6">
              <h4 style="color: black"><i class="fa fa-question-circle"></i> {{ __('How to obtain the Google Calendar Id :') }}</h4>
              <hr>
              <div class="panel panel-default">
                <div class="panel-body">
                  <ul>
                    <li>{{ __("Sign in to the") }} <b>{{ __("Google account")}}</b> {{ __("that is associated with the calendar. From the G-mail interface, click the Apps icon.")}}</li>
                    <li>{{ __("Click on the") }} <b>{{ __("Calendar")}}</b> {{ __("option.")}}</li>
                    <li>{{ __("Click on") }} <b>{{ __("Settings.")}}</b></li>
                    <li>{{ __("Click on") }} <b>{{ __("Add Calendar")}}</b> {{ __("dropdown form the left menu.")}}</li>
                    <li>{{ __("Click on") }} <b>{{ __("Create New Calendar.") }}</b> {{ __("Once you get one form after clicking on it just enter your calendar name and click on") }} <b>{{ __("Create Calendar.") }}</b></li>
                    <li>{{ __("Once you have created your calendar successfully. You calendar will be visible in the left menu.") }} </li>
                    <li>{{ __("Click on your") }} <b>{{ __("calendar") }}</b> {{ __("which you have create and which is visible on the left menu and scroll down will get your") }}  <b>{{ __("google calendar id.") }}</b></li>
                    <li>{{ __("Enter your") }} <b>{{ __("google calendar id.") }}</b></li>
                  </ul>
                </div>
              </div>
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
$(document).on('click', '.toggle-password', function() {

$(this).toggleClass("fa-eye fa-eye-slash");

var input = $("#google_cal_id");
input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});
</script>
@endsection


