<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ __('Warning !') }}</title>
	<link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">
</head>
<body>
	<br>
	<div class="container-xl">
		<h3 class="text-danger"><i class="fa fa-warning"></i> {{ __('Warning') }}</h3>
		<hr>
		<p class="text-info">{{ __('You tried to update the domain which is invalid !') }} 
		<h4>{{ __('You can use this project only in single domain for multiple domain please check License standard') }} <a href="https://codecanyon.net/licenses/standard" target="_blank" >{{ __('here') }}</a>.</h4>
		<hr>
			<form class="needs-validation" action="{{ url('/change-domain') }}" method="POST" novalidate>
				@csrf
				<div class="form-group">
					<label>
						{{ __('Enter the new domain where you want to move the license')}} : <span class="text-danger">*</span>
					</label>
					<input required class="form-control @error('domain') is-invalid @enderror" type="text" name="domain" value="{{ old('domain') }}" placeholder="eg:example.com"/>
					@if ($errors->has('domain'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('domain') }}</strong>
						</span>
				 	@endif
					<small class="text-muted">
						<i class="fa fa-question-circle"></i> {{ __('IF in some cases on current domain if you face the error you can re-update the domain by entering here')}}.
					</small>
					<br>
					<small class="text-muted">
						<i class="fa fa-question-circle"></i> {{ __('IF still facing the access denied error please contact')}} <a href="https://codecanyon.net/item/eclass-learning-management-system/25613271/support" target="_blank" title="{{ __('Support') }}">{{ __('Support') }}</a> {{ __('for update  domain.') }}.
					</small>
				</div>	
				<div class="form-group">
					<button type="submit" class="btn btn-md btn-danger">
					 	<i class="fa fa-globe"></i>	{{ __('Change domain')}}
					</button>
				</div>
			</form>
		<hr>	
		<div class="text-muted text-center">&copy; {{ date('Y') }} | {{ __('All rights reserved') }} | {{ config('app.name') }}</div>
	</div>	
	<script src="{{url('js/jquery.min.js')}}"></script><!-- jQuery -->	
	<script src="{{url('js/bootstrap.bundle.min.js')}}"></script><!-- Bootstrap JS -->
	<script>
		(function() {
		  'use strict';
		  window.addEventListener('load', function() {			
			var forms = document.getElementsByClassName('needs-validation');			
			var validation = Array.prototype.filter.call(forms, function(form) {
			  form.addEventListener('submit', function(event) {
				if (form.checkValidity() === false) {
				  event.preventDefault();
				  event.stopPropagation();
				}
				form.classList.add('was-validated');
			  }, false);
			});
		  }, false);
		})();
	</script>
</body>
</html>
