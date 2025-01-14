@extends('admin.layouts.master')
@section('title', 'Widget Settings - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Widget Settings';
$data['title'] = 'Front Settings';
$data['title1'] = 'Widget Settings';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
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
					<h5 class="card-title">{{ __('Widget Settings') }}</h5>
				</div>
				<div class="card-body">
					<form action="{{action('WidgetController@update')}}" method="POST">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="row">
							<div class="update-password">
								<div class="form-group col-md-12">
									<label for="">{{ __('Enable Widgets') }}: </label>
									<input class="custom_toggle" class="custom_toggle" type="checkbox" id="myCheck"
										name="widget_enable" {{ optional($show)->widget_enable == 1 ? 'checked' : '' }}
										onclick="myFunction()" />
								</div>
							</div>
						</div>
						<div style="{{ optional($show)->widget_enable == 0 ? 'display: none' : '' }}" id="update-password">
    <div class="row">
        <div class="form-group col-md-3">
            <label for="heading">{{ __('Widget One Title') }}<sup class="redstar text-danger">*</sup></label>
            <input value="{{ optional($show)->widget_one }}" autofocus name="widget_one" type="text" class="form-control" placeholder="{{ __('Enter Widget One Title')}}" required />
        </div>
        <div class="form-group col-md-3">
            <label for="">{{ __('Enable About Us') }}: </label><br>
            <input id="status_toggle" class="custom_toggle" type="checkbox" name="about_enable" {{ optional($show)->about_enable == 1 ? 'checked' : '' }} />
        </div>
        <div class="form-group col-md-6">
            <label for="">{{ __('Enable Contact Us') }}: </label><br>
            <input id="status_toggle" class="custom_toggle" type="checkbox" name="contact_enable" {{ optional($show)->contact_enable == 1 ? 'checked' : '' }} />
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label for="heading">{{ __('Widget Two Title') }}<sup class="redstar text-danger">*</sup></label>
            <input value="{{ optional($show)->widget_two }}" autofocus name="widget_two" type="text" class="form-control" placeholder="{{ __('Enter Widget Two Title')}}" required />
        </div>
        <div class="form-group col-md-3">
            <label for="">{{ __('Enable Career') }}: </label><br>
            <input id="status_toggle" class="custom_toggle" type="checkbox" name="career_enable" {{ optional($show)->career_enable == 1 ? 'checked' : '' }} />
        </div>
        <div class="form-group col-md-3">
            <label for="">{{ __('Enable Blog') }}: </label><br>
            <input id="status_toggle" class="custom_toggle" type="checkbox" name="blog_enable" {{ optional($show)->blog_enable == 1 ? 'checked' : '' }} />
        </div>
        <div class="form-group col-md-3">
            <label for="">{{ __('Enable Help & Support') }}: </label><br>
            <input id="status_toggle" class="custom_toggle" type="checkbox" name="help_enable" {{ optional($show)->help_enable == 1 ? 'checked' : '' }} />
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label for="heading">{{ __('Widget Three Title') }}<sup class="redstar">*</sup></label>
            <input value="{{ optional($show)->widget_three }}" autofocus name="widget_three" type="text" class="form-control" placeholder="{{ __('Enter Widget Three Title')}}" required />
        </div>
    </div>
</div>

							<div class="form-group">
							<button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i>
								{{ __("Reset")}}</button>
							<button type="submit" class="btn btn-primary-rgba" title="{{ __('Save')}}"><i class="fa fa-check-circle"></i>
								{{ __("Save")}}</button>
						</div>
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
	"use strict";
	$(function () {
		$('#myCheck').change(function () {
			if ($('#myCheck').is(':checked')) {
				$('#update-password').show('fast');
			} else {
				$('#update-password').hide('fast');
			}
		});

	})(jQuery);
</script>
@endsection