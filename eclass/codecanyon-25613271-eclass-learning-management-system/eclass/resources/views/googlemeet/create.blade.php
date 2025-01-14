@extends('admin.layouts.master')
@section('title', 'Create a new meeting - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Create New Google Meeting';
$data['title'] = 'Meetings';
$data['title1'] = 'Google Meetings';
$data['title2'] = 'Create New Google Meeting';
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
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Create a New Google Meeting') }}</h5>
		  <div>
			<div class="widgetbar">
			  <a href="{{url('googlemeet/dashboard')}}" class="btn btn-primary-rgba" title="{{ __('Back') }}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
		  
			</div>
		  </div>
        </div>
        <div class="card-body">
          
			<form autocomplete="off" action="{{ route('googlemeet.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
          
          <div class="row">

            <div class="form-group col-md-4">
				<label for="image">{{ __('Image') }}:</label><br>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
					<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload')}}</span>
				  </div>
				  <div class="custom-file">
					<input type="file" type="file" name="image" id="image" class="custom-file-input" aria-describedby="inputGroupFileAddon01">
					<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file')}}</label>
				  </div>
				</div>
			</div>
            	
              
            <div class="form-group col-md-4">
				<label for="exampleInputDetails">{{ __('Link By Course') }}:</label><br>
				<input type="checkbox" id="myCheck" name="link_by" class="custom_toggle" onclick="myFunction()">
				{{-- <input type="hidden" name="free" value="0" for="opp" id="link_by"> --}}
				<div style="display: none" id="update-password">
					<label>{{ __('Courses') }}:<span class="redstar">*</span></label>
					<select name="course_id" id="course_id" class="select2-single form-control">
						@foreach($course as $cor)
						  <option value="{{$cor->id}}">{{$cor->title}}</option>
						@endforeach
					</select>
				</div>
            </div>
            <div class="form-group col-md-4">
				<label>
					{{ __('Meeting Topic') }}:<sup class="redstar">*</sup>
				</label>
				<input type="text" name="topic" placeholder="{{ __('Example: My Meeting')}}" class="form-control" required>
              </div>
              
            
            <div class="form-group col-md-4" id="sec4_four">
				<label>
					{{ __('Start Time') }} :<sup class="redstar">*</sup>
				</label>
				<div class="input-group" id='datetimepicker1'>
					<input type="text" name="start_time"   id="time-format" class="form-control" placeholder="dd/mm/yyyy - hh:ii aa" aria-describedby="basic-addon5" />
					<div class="input-group-append">
						<span class="input-group-text" id="basic-addon5"><i class="feather icon-calendar"></i></span>
					</div>
             
                </div>
            </div>             
            
            <div class="form-group col-md-4"  id="sec5_four">
				<label>
					{{ __('End Time') }}:<sup class="redstar">*</sup>
				</label>
				<div class="input-group" id='datetimepicker1'>
					<input type="text" name="end_time"   id="time-format1" class="form-control" placeholder="dd/mm/yyyy - hh:ii aa" aria-describedby="basic-addon5" />
					<div class="input-group-append">
						<span class="input-group-text" id="basic-addon5"><i class="feather icon-calendar"></i></span>
					</div>
                
				</div>
			</div>
              
            <div class="form-group col-md-4"  id="sec3_three">
            	<label>
					{{ __('Duration') }}:<sup class="redstar">*</sup>
				</label>

				<input placeholder="enter in mins eg 60" type="number" min="1" name="duration" class="form-control">
            
            </div>
            <div class="form-group col-md-4"  id="sec3_three">
				<label>
					{{ __('Meeting Agenda') }}:<sup class="redstar">*</sup>
				</label>

				<input type="text" name="agenda" placeholder="Meeting Agenda" class="form-control" required>
            
            </div>
			<div class="form-group col-md-4">
				<label for="paidMeetingToggle">{{ __('Paid Meeting') }}:</label><br>
				<input type="checkbox" id="paidMeetingToggle" name="paid_meeting_toggle" class="custom_toggle" value="1">
				<div id="paidMeetingPrice">
					<label for="paidMeetingPrice">{{ __('Paid Meeting Price') }}:</label>
					<input type="text" name="paid_meeting_price" class="form-control" placeholder="{{ __('Enter price') }}">
				</div>
			  </div>
			
			
            <div class="form-group col-md-4"  id="sec3_three">
				<label>{{ __('Time Zone') }}:</label>


				<select class="select2-single form-control" name="timezone">
					  <option value="None">{{__('Use Your Account Timezone')}}</option>
					  <option value="Pacific/Midway">{{__('Midway Island, Samoa')}}</option>
					  <option value="Pacific/Pago_Pago">{{__('Pago Pago')}}</option>
					  <option value="Pacific/Honolulu">{{__('Hawaii')}}</option>
					  <option value="America/Anchorage">{{__('Alaska')}}</option>
					  <option value="America/Vancouver">{{__('Vancouver')}}</option>
					  <option value="America/Los_Angeles">{{__('Pacific Time US and Canada')}}</option>
					  <option value="America/Tijuana">{{__('Tijuana')}}</option>
					  <option value="America/Edmonton">{{__('Edmonton')}}</option>
					  <option value="America/Denver">{{__('Mountain Time US and Canada')}}</option>
					  <option value="America/Phoenix">{{__('Arizona')}}</option>
					  <option value="America/Mazatlan">{{__('Mazatlan')}}</option>
					  <option value="America/Winnipeg">{{__('Winnipeg')}}</option>
					  <option value="America/Regina">{{__('Saskatchewan')}}</option>
					  <option value="America/Chicago">{{__('Central Time US and Canada')}}</option>
					  <option value="America/Mexico_City">{{__('Mexico City')}}</option>
					  <option value="America/Guatemala">{{__('Guatemala')}}</option>
					  <option value="America/El_Salvador">{{__('El Salvador')}}</option>
					  <option value="America/Managua">{{__('Managua')}}</option>
					  <option value="America/Costa_Rica">{{__('Costa Rica')}}</option>
					  <option value="America/Montreal">{{__('Montreal')}}</option>
					  <option value="America/New_York">{{__('Eastern Time US and Canada')}}</option>
					  <option value="America/Indianapolis">{{__('Indiana East')}}</option>
					  <option value="America/Panama">{{__('Panama')}}</option>
					  <option value="America/Bogota">{{__('Bogota')}}</option>
					  <option value="America/Lima">{{__('Lima')}}</option>
					  <option value="America/Halifax">{{__('Halifax')}}</option>
					  <option value="America/Puerto_Rico">{{__('Puerto Rico')}}</option>
					  <option value="America/Caracas">{{__('Caracas')}}</option>
					  <option value="America/Santiago">{{__('Santiago')}}</option>
					  <option value="America/St_Johns">{{__('Newfoundland and Labrador')}}</option>
					  <option value="America/Montevideo">{{__('Montevideo')}}</option>
					  <option value="America/Araguaina">{{__('Brasilia')}}</option>
					  <option value="America/Argentina/Buenos_Aires">{{__('Buenos Aires, Georgetown')}}</option>
					  <option value="America/Godthab">{{__('Greenland')}}</option>
					  <option value="America/Sao_Paulo">{{__('Sao Paulo')}}</option>
					  <option value="Atlantic/Azores">{{__('Azores')}}</option>
					  <option value="Canada/Atlantic">{{__('Atlantic Time Canada')}}</option>
					  <option value="Atlantic/Cape_Verde">{{__('Cape Verde Islands')}}</option>
					  <option value="UTC">{{__('Universal Time UTC')}}</option>
					  <option value="Etc/Greenwich">{{__('Greenwich Mean Time')}}</option>
					  <option value="Europe/Belgrade">{{__('Belgrade, Bratislava, Ljubljana')}}</option>
					  <option value="CET">{{__('Sarajevo, Skopje, Zagreb')}}</option>
					  <option value="Atlantic/Reykjavik">{{__('Reykjavik')}}</option>
					  <option value="Europe/Dublin">{{__('Dublin')}}</option>
					  <option value="Europe/London">{{__('London')}}</option>
					  <option value="Europe/Lisbon">{{__('Lisbon')}}</option>
					  <option value="Africa/Casablanca">{{__('Casablanca')}}</option>
					  <option value="Africa/Nouakchott">{{__('Nouakchott')}}</option>
					  <option value="Europe/Oslo">{{__('Oslo')}}</option>
					  <option value="Europe/Copenhagen">{{__('Copenhagen')}}</option>
					  <option value="Europe/Brussels">{{__('Brussels')}}</option>
					  <option value="Europe/Berlin">{{__('Amsterdam, Berlin, Rome, Stockholm, Vienna')}}</option>
					  <option value="Europe/Helsinki">{{__('Helsinki')}}</option>
					  <option value="Europe/Amsterdam">{{__('Amsterdam')}}</option>
					  <option value="Europe/Rome">{{__('Rome')}}</option>
					  <option value="Europe/Stockholm">{{__('Stockholm')}}</option>
					  <option value="Europe/Vienna">{{__('Vienna')}}</option>
					  <option value="Europe/Luxembourg">{{__('Luxembourg')}}</option>
					  <option value="Europe/Paris">{{__('Paris')}}</option>
					  <option value="Europe/Zurich">{{__('Zurich')}}</option>
					  <option value="Europe/Madrid">{{__('Madrid')}}</option>
					  <option value="Africa/Bangui">{{__('West Central Africa')}}</option>
					  <option value="Africa/Algiers">{{__('Algiers')}}</option>
					  <option value="Africa/Tunis">{{__('Tunis')}}</option>
					  <option value="Africa/Harare">{{__('Harare, Pretoria')}}</option>
					  <option value="Africa/Nairobi">{{__('Nairobi')}}</option>
					  <option value="Europe/Warsaw">{{__('Warsaw')}}</option>
					  <option value="Europe/Prague">{{__('Prague Bratislava')}}</option>
					  <option value="Europe/Budapest">{{__('Budapest')}}</option>
					  <option value="Europe/Sofia">{{__('Sofia')}}</option>
					  <option value="Europe/Istanbul">{{__('Istanbul')}}</option>
					  <option value="Europe/Athens">{{__('Athens')}}</option>
					  <option value="Europe/Bucharest">{{__('Bucharest')}}</option>
					  <option value="Asia/Nicosia">{{__('Nicosia')}}</option>
					  <option value="Asia/Beirut">{{__('Beirut')}}</option>
					  <option value="Asia/Damascus">{{__('Damascus')}}</option>
					  <option value="Asia/Jerusalem">{{__('Jerusalem')}}</option>
					  <option value="Asia/Amman">{{__('Amman')}}</option>
					  <option value="Africa/Tripoli">{{__('Tripoli')}}</option>
					  <option value="Africa/Cairo">{{__('Cairo')}}</option>
					  <option value="Africa/Johannesburg">{{__('Johannesburg')}}</option>
					  <option value="Europe/Moscow">{{__('Moscow')}}</option>
					  <option value="Asia/Baghdad">{{__('Baghdad')}}</option>
					  <option value="Asia/Kuwait">{{__('Kuwait')}}</option>
					  <option value="Asia/Riyadh">{{__('Riyadh')}}</option>
					  <option value="Asia/Bahrain">{{__('Bahrain')}}</option>
					  <option value="Asia/Qatar">{{__('Qatar')}}</option>
					  <option value="Asia/Aden">{{__('Aden')}}</option>
					  <option value="Asia/Tehran">{{__('Tehran')}}</option>
					  <option value="Africa/Khartoum">{{__('Khartoum')}}</option>
					  <option value="Africa/Djibouti">{{__('Djibouti')}}</option>
					  <option value="Africa/Mogadishu">{{__('Mogadishu')}}</option>
					  <option value="Asia/Dubai">{{__('Dubai')}}</option>
					  <option value="Asia/Muscat">{{__('Muscat')}}</option>
					  <option value="Asia/Baku">{{__('Baku, Tbilisi, Yerevan')}}</option>
					  <option value="Asia/Kabul">{{__('Kabul')}}</option>
					  <option value="Asia/Yekaterinburg">{{__('Yekaterinburg')}}</option>
					  <option value="Asia/Tashkent">{{__('Islamabad, Karachi, Tashkent')}}</option>
					  <option value="Asia/Calcutta">{{__('India')}}</option>
					  <option value="Asia/Kathmandu">{{__('Kathmandu')}}</option>
					  <option value="Asia/Novosibirsk">{{__('Novosibirsk')}}</option>
					  <option value="Asia/Almaty">{{__('Almaty')}}</option>
					  <option value="Asia/Dacca">{{__('Dacca')}}</option>
					  <option value="Asia/Krasnoyarsk">{{__('Krasnoyarsk')}}</option>
					  <option value="Asia/Dhaka">{{__('Astana, Dhaka')}}</option>
					  <option value="Asia/Bangkok">{{__('Bangkok')}}</option>
					  <option value="Asia/Saigon">{{__('Vietnam')}}</option>
					  <option value="Asia/Jakarta">{{__('Jakarta')}}</option>
					  <option value="Asia/Irkutsk">{{__('Irkutsk, Ulaanbaatar')}}</option>
					  <option value="Asia/Shanghai">{{__('Beijing, Shanghai')}}</option>
					  <option value="Asia/Hong_Kong">{{__('Hong Kong')}}</option>
					  <option value="Asia/Taipei">{{__('Taipei')}}</option>
					  <option value="Asia/Kuala_Lumpur">{{__('Kuala Lumpur')}}</option>
					  <option value="Asia/Singapore">{{__('Singapore')}}</option>
					  <option value="Australia/Perth">{{__('Perth')}}</option>
					  <option value="Asia/Yakutsk">{{__('Yakutsk')}}</option>
					  <option value="Asia/Seoul">{{__('Seoul')}}</option>
					  <option value="Asia/Tokyo">{{__('Osaka, Sapporo, Tokyo')}}</option>
					  <option value="Australia/Darwin">{{__('Darwin')}}</option>
					  <option value="Australia/Adelaide">{{__('Adelaide')}}</option>
					  <option value="Asia/Vladivostok">{{__('Vladivostok')}}</option>
					  <option value="Pacific/Port_Moresby">{{__('Guam, Port Moresby')}}</option>
					  <option value="Australia/Brisbane">{{__('Brisbane')}}</option>
					  <option value="Australia/Sydney">{{__('Canberra, Melbourne, Sydney')}}</option>
					  <option value="Australia/Hobart">{{__('Hobart')}}</option>
					  <option value="Asia/Magadan">{{__('Magadan')}}</option>
					  <option value="SST">{{__('Solomon Islands')}}</option>
					  <option value="Pacific/Noumea">{{__('New Caledonia')}}</option>
					  <option value="Asia/Kamchatka">{{__('Kamchatka')}}</option>
					  <option value="Pacific/Fiji">{{__('Fiji Islands, Marshall Islands')}}</option>
					  <option value="Pacific/Auckland">{{__('Auckland, Wellington')}}</option>
					  <option value="Asia/Kolkata">{{__('Mumbai, Kolkata, New Delhi')}}</option>
					  <option value="Europe/Kiev">{{__('Kiev')}}</option>
					  <option value="America/Tegucigalpa">{{__('Tegucigalpa')}}</option>
					  <option value="Pacific/Apia">{{__('Independent State of Samoa')}}</option>
				</select>

					<small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Set to None if you want to use your account timezone')}}.</small>
            
            </div>

			
          </div>
          <div class="form-group">
            <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
            <button type="submit" class="btn btn-primary-rgba" title="{{ __('Create') }}"><i class="fa fa-check-circle"></i>
            {{ __("Create")}}</button>
          </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection


@section('script')
	<script>
		 $('#datetimepicker1').datetimepicker({
		    format: 'YYYY-MM-DD H:m:s',
		  });
		  $('#datetimepicker2').datetimepicker({
		    format: 'YYYY-MM-DD H:m:s',
		  });

		
	</script>

	<script>
	(function($) {
	  "use strict";

	  $(function(){

	      $('#link_by').change(function(){
	        if($('#link_by').is(':checked')){
	          $('#sec1_one').show('fast');
	        }else{
	          $('#sec1_one').hide('fast');
	        }

	      });


	      $('#recurring_meeting').change(function(){
	        if($('#recurring_meeting').is(':checked')){
	          $('#sec4_four').hide('fast');
			  $('#sec5_four').hide('fast');
	          $('#sec3_three').hide('fast');
	        }else{
	          $('#sec4_four').show('fast');
			  $('#sec5_four').show('fast');
	          $('#sec3_three').show('fast');
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