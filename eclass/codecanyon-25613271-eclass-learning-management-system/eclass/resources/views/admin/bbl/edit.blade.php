@extends('admin.layouts.master')
@section('title', 'Edit meeting - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Edit meeting';
$data['title'] = 'Edit meeting';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  @if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
  @endforeach  
  </div>
  @endif
<div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title"> {{ __('Edit') }} {{ __('Meeting') }} : #{{ $meeting->meetingid }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{url("bigblue/meetings")}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
          
            </div>
          </div>
        </div>
        <div class="card-body">

          <form action="{{ route('bbl.update',$meeting->id) }}" method="POST">
            @csrf

            <div class="row">
              <div class="form-group col-md-4">
                <label for="exampleInputDetails">{{ __('Link By Course') }}:</label><br>
                <input type="checkbox" id="myCheck" name="link_by" {{ $meeting->link_by == 'course' ? 'checked' : '' }} class="custom_toggle" onclick="myFunction()">
                <div style="{{ $meeting['link_by'] == 'course' ? '' : 'display:none' }}" id="update-password">

                  <label>{{ __('Courses') }}:</label>
                  <select name="course_id" id="course_id" class="form-control select2">
                            
                      @php
                        $course = App\Course::where('status', '1')->where('user_id', Auth::user()->id)->get();
                      @endphp
          
                      @foreach($course as $caat)
                        <option {{ optional($meeting)['course_id'] == $caat->id ? 'selected' : "" }} value="{{ $caat->id }}">{{ $caat->title }}</option>
                      @endforeach 
                  </select>
                </div>
              </div>               

              <div class="form-group col-md-4">
                <label  for="exampleInputDetails">{{ __('Presenter Name') }}: <sup class="redstar">*</sup></label>
                <input readonly="" value="{{ $meeting->meetingid }}" type="text" name="meetingid" class="form-control" required="" placeholder="enter meeting id">
              </div>

              <div class="form-group col-md-4">
                <label>{{ __('Meeting   ID') }}: <sup class="redstar">*</sup></label>
                <input value="{{ $meeting->presen_name }}" type="text" name="presen_name" class="form-control" required="" placeholder="enter presenter name">
               
              </div>
              <div class="form-group col-md-4">
                <label> {{ __('Meeting') }} {{ __('Name') }}: <sup class="redstar">*</sup></label>
                <input value="{{ $meeting->meetingname }}" type="text" name="meetingname" class="form-control" required="" placeholder="enter meeting name">
              </div>

              <div class="form-group col-md-4">
                <label>{{ __('Meeting') }} {{ __('Duration') }}: <sup class="redstar">*</sup>   <small class="text-muted">{{__('It will be count in minutes')}}</small> </label>
                <input value="{{ $meeting->duration }}" type="text" name="duration" class="form-control" required="" placeholder="enter meeting duration eg. 40">
                
              </div>
              <div class="form-group col-md-4">
                <label> {{ __('Moderator Password') }}:</label>
                <div class="input-group mb-3">
                  
                  <input id="password-field" value="{{ $meeting->modpw }}" type="password"  name="modpw" class="form-control" placeholder="enter moderator password">
                  <div class="input-group-prepend text-center">
                  <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password eye-icon-pass"></span></i></span>
                  </div>
                </div>
               
              </div>


              <div class="form-group col-md-4">
                <label>{{ __('Attandee Password') }}: <small class="text-muted"><br>
                  (<b>{{__('Tip !')}}</b> {{__('Share your attendee password to students using social handling networks.')}})</small></label>
                
                <input required id="attendeepw" value="{{ $meeting->attendeepw }}" type="password" name="attendeepw" class="form-control" placeholder="enter attandee password">
                
                 <small class="text-muted">{{__('Should be diffrent from')}} <b>{{__('Moderator')}}</b> {{__('password')}}</small>


              </div>
              <div class="form-group col-md-4">
                <label>{{__('Set Welcome Message:')}}</label>
                <input value="{{ $meeting->welcomemsg }}" type="text" class="form-control" name="welcomemsg" placeholder="enter welcome message">

              </div>
              <div class="form-group col-md-4">
                <label>{{__('Set Max Participants:')}}</label>
              <input value="{{ $meeting->setMaxParticipants }}" type="number" min="-1" class="form-control" name="setMaxParticipants" placeholder="enter maximum participant no., leave blank if want unlimited participant"/>

              </div>
              <div class="form-group col-md-4">
                <label>{{__('Set Mute on Start:')}}</label><br>
                <input {{ $meeting->setMuteOnStart == 1 ? "checked" : "" }} class="custom_toggle" type="checkbox" name="setMuteOnStart" />

              </div>

              <div class="form-group col-md-4">
                <label>{{__('Allow Record:')}}</label><br>
                <input {{ $meeting->allow_record == '1' ? "checked" : "" }} class="custom_toggle" type="checkbox" ame="allow_record" />

              </div>

              <div class="form-group col-md-4">
                <label for="paidMeetingToggle">{{ __('Paid Meeting') }}:</label><br>
                <input type="checkbox" id="paidMeetingToggle" name="paid_meeting_toggle" class="custom_toggle" value="1" 
                {{ $meeting->paid_meeting_toggle ? 'checked' : '' }}>
                <div class="row">
                  <div class="form-group col-md-12" id="paidMeetingPrice" style="{{ $meeting->paid_meeting_toggle ? '' : 'display:none;' }}">
                    <label for="paidMeetingPrice">{{ __('Paid Meeting Price') }}:</label>
                    <input type="text" name="paid_meeting_price" class="form-control" placeholder="{{ __('Enter price') }}" 
                    value="{{ $meeting->paid_meeting_price }}">
                  </div>
                </div>
              </div>
              
              
            </div>
            <div class="form-group">
              <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
                {{__('Reset')}}</button>
              <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                {{__('Update')}}</button>
            </div>

            <div class="clear-both"></div>
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