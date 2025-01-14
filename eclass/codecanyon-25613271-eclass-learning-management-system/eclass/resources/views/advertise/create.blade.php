@extends('admin.layouts.master')
@section('title', 'Create Advertise - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Create Advertise';
$data['title'] = 'Advertise';
$data['title1'] = 'Create Advertise';
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
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Create Advertise') }}</h5>
        </div>
		<div>
			<div class="widgetbar">
			  <a href="{{url('admin/ads')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
		  
			</div>
		  </div>
        <div class="card-body">
          
			<form style="margin-top:-15px;" enctype="multipart/form-data" method="POST" action="{{ route('ad.store') }} ">
				<br>
					{{ csrf_field() }}
          
          <div class="row">
            <div class="form-group col-md-12">
				<label for="ad_location">{{ __("Ad Location:")}}</label>
				<select name="ad_location" id="test" class="select2-single form-control">
					<option value="popup">{{ __("Popup")}}</option>
					<option value="onpause">{{ __("Onpause")}}</option>
					<option id="skipad" value="skip">{{ __("SkipAd")}}</option>
				</select>
            </div>
            <div id="s_img" class="form-group{{ $errors->has('ad_image') ? ' has-error' : '' }} col-md-6">
				<label for="ad_image">{{ __("Ad Image")}}</label><br>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
					  <span class="input-group-text" id="inputGroupFileAddon01">{{__('Upload')}}</span>
					</div>
					<div class="custom-file">
					  <input accept="image/*" type="file" name="ad_image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
					  <label class="custom-file-label" for="inputGroupFile01">{{__('Choose file')}}</label>
					</div>
				  </div>
				  
				
				<span class="help-block">
				  <strong>{{ $errors->first('ad_image') }}</strong>
				</span>
            </div>

            <div  class="form-group col-md-12" style="display: none;"  id="type">
				<input  type="radio" value="upload" checked name="checkType" id="ch1"> {{ __("Upload")}}
				<input  type="radio" value="url" name="checkType" id="ch2"> {{ __("URL")}}
				<br>
			</div>

			<div  class="form-group col-md-12">

				<input class="form-control" style="display: none;" placeholder="http://" type="text" name="ad_url" id="ad_url">
			</div>
			
			
            

			
			<div id="s_video" style="display: none;" class="form-group col-md-6">
				<div class="form-group{{ $errors->has('ad_video') ? ' has-error' : '' }}">
				<label for="ad_image">{{ __("Ad Video")}}</label><br>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
					  <span class="input-group-text" id="inputGroupFileAddon01">{{__('Upload')}}</span>
					</div>
					<div class="custom-file">
					  <input type="file" name="ad_video" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
					  <label class="custom-file-label" for="inputGroupFile01">{{__('Choose file')}}</label>
					</div>
				  </div>
				  
				
				<span class="help-block">
					<strong>{{ $errors->first('ad_video') }}</strong>
				</span>
			</div>
		
			</div>
		

            <div class="form-group col-md-6">
				<label for="">{{ __("Enter Ad Target :")}}<sup class="redstar">*</sup></label>
				<input type="text" class="form-control" placeholder="Enter Ad Target URL: http://" name="ad_target" required>
            </div>
          
            <div class="form-group col-md-6"  id="forpopup1">
				<label for="">{{ __("Enter Start Time :")}}</label>
				<input type="text" class="form-control" name="time" placeholder="ex. 00:00:10" name="time">
              
            </div>

			<div class="form-group col-md-6">

				<div style="display: none;" id="ad_hold_time">

					<label for="ad_hold">{{ __("Ad Hold Time:")}}</label>
					<input type="text" class="form-control" placeholder="eg. 5" name="ad_hold">
				</div>

			</div>

            <div class="form-group col-md-12">
				<div id="forpopup">
             <label for="">Enter End Time :</label>
					<input type="text" class="form-control" name="endtime" placeholder="ex. 00:00:20" name="end_time">
            </div>
            </div>

             
            
           
          </div>
        

		<div class="form-group">
			<button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
			<button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
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
	<script type="text/javascript">
		$('#test').change(function() {
    if($(this).val() == 'skip')
    {
    	$('#s_video').show();
    	$('#s_img').hide();
    	$('#type').show();
    	$('#forpopup1').show();
    	$('#forpopup').hide();
    	$('#ad_hold_time').show();
    }

    	else
    {
    	$('#s_video').hide();
    	$('#s_img').show();
    	$('#type').hide();
    	$('#ad_hold_time').hide();

    }

    if($(this).val() == 'popup')
    {
    	$('#s_video').hide();
    	$('#s_img').show();
    	$('#forpopup1').show();
    	$('#forpopup').show();
    	$('#type').hide();
    	$('#ad_hold_time').hide();
    }

     if($(this).val() == 'onpause')
    {
    	$('#s_video').hide();
    	$('#s_img').show();
    	$('#forpopup').hide();
    	$('#forpopup1').hide();
    	$('#type').hide();
    	$('#ad_hold_time').hide();
    }
        
	});

		$('#ch2').click(function(){
			$('#s_video').hide();
			$('#ad_url').show();
		});

		$('#ch1').click(function(){
			$('#s_video').show();
			$('#ad_url').hide();
		});

		
  

	</script>

	<script>
  $(function() {
    $('#toggle-event').change(function() {
      $('#url').val(+ $(this).prop('checked'))
    })
  })
</script>
@endsection