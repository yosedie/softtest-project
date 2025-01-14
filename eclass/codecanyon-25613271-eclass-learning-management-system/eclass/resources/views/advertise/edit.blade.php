@extends('admin.layouts.master')
@section('title', 'Edit Advertise - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Edit Advertise';
$data['title'] = 'Player Settings';
$data['title1'] = 'Advertise';
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
		@if($ad->ad_location == "onpause" || $ad->ad_location=="popup")
		<div class="card-header">
				<h5 class="card-title">{{__('Edit AD')}}: {{ $ad->id }} | {{__('Location')}}: <span class="adl">{{ $ad->ad_location }}</span></h5>
			</div>
			<div>
				<div class="widgetbar">
				  <a href="{{url('admin/ads')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
			  
				</div>
			  </div>
			<div class="card-body">
			<form enctype="multipart/form-data" action="{{ route('ad.update.solo',$ad->id) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<div class="form-group{{ $errors->has('ad_image') ? ' has-error' : '' }} col-md-6">
				<label for="ad_image">@if($ad->ad_location == 'popup') {{ __("Edit Popup Image")}} @else
					{{ __("Edit Image")}} @endif
				</label><br>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
					  <span class="input-group-text" id="inputGroupFileAddon01">{{__('Upload')}}</span>
					</div>
					<div class="custom-file">
					  <input accept="image/*" type="file"  name="ad_image"  class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
					  <label class="custom-file-label" for="inputGroupFile01">{{__('Choose file')}}</label>
					</div>
				  </div>
				  
				
				 <span class="help-block">
		                  <strong>{{ $errors->first('ad_image') }}</strong>
		          </span>
				</div>

				<div class="form-group col-md-12">
					<label class="form-group">{{ __("Current Image:")}}</label>
					<img src="{{ asset('adv_upload/image/'.$ad->ad_image)}}" alt="{{ $ad->ad_target }}" width="100px" class="img-responsive">
					  
					
				  </div>
				  <div class="form-group col-md-12">
					<label for="ad_target"> {{ __("Edit Ad Target: (Click on ad where to redirect user)")}}</label>
				    <input class="form-control" type="text" name="ad_target" placeholder="http://" value="{{ $ad->ad_target }} ">
					  
					
				  </div>
				
				
				

				<div class="form-group col-md-12">
					<button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
					<button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
						{{ __("Update")}}</button>
				</div>
			</form>
		</div>
		@elseif($ad->ad_location == "skip")
		<div class="card-header">
			<h5 class="card-title">{{__('Edit AD')}}: {{ $ad->id }} | {{__('Location')}}: <span class="adl">{{ $ad->ad_location }}</span></h5>
		</div>
			
		<div class="card-body">

			
			<form action="{{ route('ad.update.video',$ad->id) }}" enctype="multipart/form-data" method="POST">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
				
					
				@if($ad->ad_video !="no")
				<div class="form-group{{ $errors->has('ad_video') ? ' has-error' : '' }} col-md-12">
					<label for="ad_video">{{ __("Change AD Video :")}}</label><br>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
						  <span class="input-group-text" id="inputGroupFileAddon01">{{__('Upload')}}</span>
						</div>
						<div class="custom-file">
						  <input type="file"   name="ad_video" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
						  <label class="custom-file-label" for="inputGroupFile01">{{__('Choose file')}}</label>
						</div>
					  </div>
					  
					
					<span class="help-block">
						<strong>{{ $errors->first('ad_video') }}</strong>
					</span>
				</div>

				<div class="form-group col-md-12">
					<label class="form-group">{{ __("Current Video : ")}}</label><br>
					<video width="320" height="240" controls>

						<source src="{{ asset('adv_upload/video/'.$ad->ad_video) }}" type="video/mp4">
						
					  </video>
					  
					
				  </div>

				
				
				@else

				<div class="form-group col-md-12">
					<label class="form-group">{{ __("AD URL :")}}</label>
					<input class="form-control" type="text" name="ad_url" value="{{ $ad->ad_url }}">
				</div>
					  
					
				

				
				
				@endif
				<div class="form-group col-md-12">
					<label for="ad_target">{{__('Edit Ad Target: Click on ad where to redirect user')}}</label>
					<input class="form-control" type="text" value="{{ $ad->ad_target }}" name="ad_target" placeholder="http://">
				</div>
					  
					
				<div class="form-group col-md-12">
				  <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
				  <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
					  {{ __("Update")}}</button>
			    </div>

			</form>
		</div>
			
		@endif
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