@extends('admin.layouts.master')
@section('title', 'Certificate Verification - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Certificates Verifications';
$data['title'] = 'Certificates';
$data['title1'] = 'Certificates Verifications';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
	<div class="row">
		<div class="col-lg-12">
			@if (session()->has('fail'))
			<div class="alert alert-danger" role="alert">
				<p>{{ session()->get('fail') }}<button type="button" class="close" data-dismiss="alert"
						aria-label="Close" title="{{ __('Close') }}">
						<span aria-hidden="true">&times;</span></button></p>
			</div>
			@endif
			<div class="card dashboard-card m-b-30">
				<div class="card-header">
					<h5 class="card-title">{{ __('Certificates Verifications') }}</h5>
					<div class="widgetbar">
						<button type="reset" class="btn btn-danger-rgba reset-btn"><i class="fa fa-ban"></i> {{ __('Reset') }}</button>
					</div>
				</div>
				<div class="card-body">
					<form action="{{ action('CertificateController@verification') }}" method="GET"
						enctype="multipart/form-data">

						<div class="row">
							<div class="form-group col-md-12">
								<label>{{ __('Enter Certificate Serial Number') }}:<span
										class="redstar">*</span></label>
								<div class="row">
									<div class="col-lg-4">
										<input type="text" class="form-control" id="skillifyTheme" name="title" value="{{ $posts }}" required>
									</div>
									<div class="col-lg-4">
										<button type="submit" class="btn btn-primary-rgba" title="{{ __('Verify') }}">
											<i class="fa fa-check-circle"></i>
											{{ __("Verify")}}
										</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>


				@if (isset($posts))

				<a href="{{ url('certificate'.'/'.$posts) }}" target="blank">
					<h4> {{$posts}} </h4>
				</a>

				<div class="button-list">
					<a href="{{ url('certificate'.'/'.$posts) }}" target="blank"
						class="btn btn-success-rgba btn-lg btn-block" title="{{ __('View Certificate') }}">{{ __('View Certificate') }}</a>
				</div>

				@endif

			</div>
		</div>
	</div>
</div>
@endsection


@section('script')

<script>
	$(document).ready(function () {

		$(".reset-btn").click(function () {
			var uri = window.location.toString();

			if (uri.indexOf("?") > 0) {

				var clean_uri = uri.substring(0, uri.indexOf("?"));

				window.history.replaceState({}, document.title, clean_uri);

			}

			// location.reload();
		});
	});
</script>
<!-- script to change status end -->
@endsection