@extends('admin.layouts.master')
@section('title', 'Edit Reported Questions - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Edit Reported Question';
$data['title'] = 'courses';
$data['title1'] = 'Reported Questions';
$data['title2'] = 'Edit Reported Question';
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
			<div class="card dashboard-card m-b-30">
				<div class="card-header">
					<h5 class="card-title">{{ __("Edit Reported Question")}} </h5>
					<div>
						<div class="widgetbar">
						  <a href="{{ url('user/question/report')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
					</div>
					  </div>
				</div>
				<div class="card-body">					
					<form action="{{url('user/question/report/'.$show->id)}}" method="POST">
		                {{ csrf_field() }}
		                {{ method_field('PUT') }}
					
					<div class="row">
						<div class="form-group col-md-6">
							<label for="title" class="text-dark">{{ __('Issue') }}<sup class="redstar text-danger">*</sup></label>
		                    <input value="{{ $show->title }}" autofocus required name="title" type="text" class="form-control" placeholder="{{ __('Enter Issue') }}"/>
							
						</div>
						<div class="form-group col-md-3">
							<label for="email"  class="text-dark">{{ __('Email') }}<sup class="redstar text-danger">*</sup></label>
		                    <input value="{{ $show->email }}" autofocus required name="email" type="email" class="form-control" placeholder="{{ __('Enter Email') }}"/>
						</div>
						<div class="form-group col-md-12">
							<label for="detail"  class="text-dark">{{ __('Details') }}<sup class="redstar text-danger">*</sup></label>
		                    <textarea name="detail" value="" rows="4"  class="form-control" placeholder="">{{ $show->detail }}</textarea>
						</div>
					</div>
					
						<div class="form-group">
							<button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
							<button type="submit" class="btn btn-primary-rgba" title="{{ __('Update') }}"><i class="fa fa-check-circle"></i>
							{{ __("Update")}}</button>
						</div>
	
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
