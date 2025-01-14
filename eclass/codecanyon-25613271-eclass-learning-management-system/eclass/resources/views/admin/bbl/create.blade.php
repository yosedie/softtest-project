@extends('admin.layouts.master')
@section('title', 'Create a new meeting - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Create a new meeting';
$data['title'] = 'Big Blue Meeting';
$data['title1'] = 'Create a new meeting';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">

  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        
        <div class="card-header">
          <h5 class="card-title">{{ __('Create a new meeting') }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{url("bigblue/meetings")}}" class="btn btn-primary-rgba"><i
                  class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

            </div>
          </div>
        </div>
        <div class="card-body">

          <form action="{{ route('bbl.store') }}" method="POST">
            @csrf
            <div class="row">
              <div class="form-group col-md-4">
                <label for="exampleInputDetails">{{ __('Link By Course') }}:</label><br>
                {{-- <input id="TextPosition" class="custom_toggle" type="checkbox" name="link_by" /> --}}
                <input type="checkbox" id="myCheck" name="link_by" class="custom_toggle" onclick="myFunction()">
                {{-- <input type="hidden" name="free" value="0" for="opp" id="link_by"> --}}
                <div style="display: none" id="update-password">
                  <label>{{ __('Courses') }}:<span class="redstar">*</span></label>
                  <select name="course_id" id="course_id" class="select2-single form-control">
                    @php
                    $course = App\Course::where('status', '1')->where('user_id', Auth::user()->id)->get();
                    @endphp
                    @foreach($course as $cor)
                    <option value="{{$cor->id}}">{{$cor->title}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group col-md-4">
                <label for="exampleInputDetails">{{ __('Presenter Name') }}: <sup class="redstar">*</sup></label>
                <input value="{{ old('presen_name') }}" type="text" name="presen_name" class="form-control" required=""
                  placeholder="enter presenter name">
              </div>

              <div class="form-group col-md-4">
                <label>{{ __('MeetingID') }}: <sup class="redstar">*</sup></label>
                <input value="{{ old('meetingid') }}" type="text" name="meetingid" class="form-control" required=""
                  placeholder="enter meeting id">

              </div>
              <div class="form-group col-md-4">
                <label> {{ __('Meeting') }} {{ __('Name') }}: <sup class="redstar">*</sup></label>
                <input value="{{ old('meetingname') }}" type="text" name="meetingname" class="form-control" required=""
                  placeholder="enter meeting name">
              </div>

              <div class="form-group col-md-4">
                <label>{{ __('Meeting') }} {{ __('Duration') }}: <sup class="redstar">*</sup> <small
                    class="text-muted">{{__('It will be count in minutes')}}</small> </label>
                <input value="{{ old('duration') }}" type="text" name="duration" class="form-control" required=""
                  placeholder="enter meeting duration eg. 40">

              </div>


              <div class="form-group col-md-4">
                <label>
                  {{ __('StartTime') }}:<sup class="redstar">*</sup>
                </label>

                <div class="input-group" id='datetimepicker1'>
                  <input type="text" name="start_time" id="time-format" class="form-control"
                    placeholder="dd/mm/yyyy - hh:ii aa" aria-describedby="basic-addon5" />
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon5"><i class="feather icon-calendar"></i></span>
                  </div>
                </div>
              </div>


              <div class="form-group col-md-4">
                <label> {{ __('Moderator Password') }}:</label>
                <div class="input-group mb-3">

                  <input id="password-field" type="password" name="modpw" class="form-control"
                    placeholder="enter moderator password">
                  <div class="input-group-prepend text-center">
                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password eye-icon-pass"></span></i></span>
                  </div>
                </div>

              </div>


              <div class="form-group col-md-4">
                <label>{{ __('Attandee Password') }}: <small class="text-muted"><br>
                    (<b>{{__('Tip !')}}</b> {{__('Share your attendee password to students using social handling
                    networks.')}})</small></label>

                <input required id="attendeepw" value="" type="password" name="attendeepw" class="form-control"
                  placeholder="enter attandee password">

                <small class="text-muted">{{__('Should be diffrent from')}} <b>{{__('Moderator')}}</b>
                  {{__('password')}}</small>

              </div>

              <div class="form-group col-md-4">
                <label>{{__('Set Welcome Message:')}}</label>
                <input value="{{ old('welcomemsg') }}" type="text" class="form-control" name="welcomemsg"
                  placeholder="enter welcome message">

              </div>
              <div class="form-group col-md-3">
                <label>{{__('Set Max Participants:')}}</label>
                <input value="{{ old('setMaxParticipants') }}" type="number" min="-1" class="form-control"
                  name="setMaxParticipants"
                  placeholder="enter maximum participant no., leave blank if want unlimited participant" />

              </div>
              <div class="form-group col-md-3">
                <label>{{__('Set Mute on Start:')}}</label><br>
                <input class="custom_toggle" type="checkbox" name="setMuteOnStart" />
              </div>
              <div class="form-group col-md-3">
                <label>{{__('Allow Record:')}}</label><br>
                <input class="custom_toggle" type="checkbox" ame="allow_record" />

              </div>
              <div class="form-group col-md-3">
                <label for="paidMeetingToggle">{{ __('Paid Meeting') }}:</label><br>
                <input type="checkbox" id="paidMeetingToggle" name="paid_meeting_toggle" class="custom_toggle"
                  value="1">
                <div id="paidMeetingPrice">
                  <label for="paidMeetingPrice">{{ __('Paid Meeting Price') }}:</label>
                  <input type="text" name="paid_meeting_price" class="form-control" placeholder="{{ __('Enter price') }}">
                </div>
              </div>

              
            </div>
            <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{__('Reset')}}</button>
            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
              {{__('Create')}}</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection
@section('script')

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
  document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('paidMeetingToggle');
        const priceInput = document.getElementById('paidMeetingPrice');
    
        // Function to toggle the visibility of the input box
        function toggleVisibility() {
            if (toggle.checked) {
                priceInput.style.display = 'block';
            } else {
                priceInput.style.display = 'none';
            }
        }
    
        // Add event listener to toggle switch
        toggle.addEventListener('change', toggleVisibility);
    
        // Initialize visibility based on toggle state
        toggleVisibility();
    });
</script>
@endsection