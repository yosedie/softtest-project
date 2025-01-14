@extends('admin.layouts.master')
@section('title', 'Get Started - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Get Started';
$data['title'] = 'Front Settings';
$data['title1'] = 'Get Started';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
	@if ($errors->any())  
	<div class="alert alert-danger" role="alert">
	@foreach($errors->all() as $error)     
	<p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close')}}">
	<span aria-hidden="true" style="color:red;">&times;</span></button></p>
		@endforeach  
	</div>
	@endif
	<div class="row">
	  <div class="col-lg-12">
		<div class="card dashboard-card m-b-30">
		  <div class="card-header">
			<h5 class="card-title">{{ __('Get Started') }}</h5>
		  </div>
		  <div class="card-body">
			<form action="{{ action('GetstartedController@update') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
			<div class="row">
			  <div class="form-group col-md-3">
				<label for="heading">{{ __('Heading') }}</label>
				<input value="{{ optional($show)['heading'] }}" autofocus name="heading" type="text" class="form-control" placeholder="{{ __('Enter Heading') }}"/>
			</div>
			  <div class="form-group col-md-3">
				<label for="sub_heading">{{ __('Sub Heading') }}</label>
				<input value="{{$show->sub_heading ?? '' }}" autofocus name="sub_heading" type="text" class="form-control" placeholder="{{ __('Enter SubHeading') }}"/>
			</div>
			  <div class="form-group col-md-3">
				<label for="button_txt">{{ __('Button Text') }}</label>
				<input value="{{ optional($show)['button_txt'] }}" autofocus name="button_txt" type="text" class="form-control" placeholder="{{ __('Enter Button Text') }}"/>
			</div>
			  <div class="form-group col-md-3">
				<label for="button_txt">{{ __('Button Link') }}</label>
				<input value="{{ optional($show)['link'] }}" name="link" type="text" class="form-control" placeholder="{{ __('Enter Button Link') }}"/>
			</div>
			  <div class="form-group col-md-3">
				  
				<label for="image">{{ __('Background Image') }}<sup class="redstar text-danger">*</sup></label><br>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
					  <span class="input-group-text" id="inputGroupFileAddon01">{{ __("Upload")}}</span>
					</div>
					<div class="custom-file">
					  <input accept="image/*" type="file" name="image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
					  <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose File")}}</label>
					</div>
				  </div>
				<img src="{{ url('/images/getstarted/'.optional($show)['image']) }}" class="img-responsive image_size" alt="Background Image"/>
			</div>			  
		</div>		
		<div class="form-group">
			<button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
			<button type="submit" class="btn btn-primary-rgba" title="{{ __('Save')}}"><i class="fa fa-check-circle"></i>
			{{ __("Save")}}</button>
		</div>
		</form>
	  </div>
	</div>
  </div>
</div>
</div>
@endsection
	



