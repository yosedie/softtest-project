@extends('admin.layouts.master')
@section('title', 'Update Currency')
@section('maincontent')
<?php
$data['heading'] = 'Update Currency';
$data['title'] = 'Currency';
$data['title1'] = 'Update Currency';
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
						<h5 class="card-title">{{ __("Update Currency")}} </h5>
					</div>
					<div class="card-body">
						
						<form action="{{ action('CurrencyController@update') }}" method="POST" enctype="multipart/form-data">
		                {{ csrf_field() }}
		                {{ method_field('PUT') }}
						
						<div class="row">
							<div class="form-group col-md-6">
								
								<label for="icon">{{ __('Icon') }}:<sup class="redstar">*</sup></label>
								<div class="input-group">
									<input id="iconvalue" name="icon" type="text" class="form-control" required value="{{ $show['icon'] }}">
									<span class="input-group-append">
									<button role="iconpicker" id="iconpick" type="button" class="btn btn-outline-secondary"></button>
									</span>
								</div>
								
							</div>
					
							<div class="form-group col-md-6">
								<label class="text-dark">{{ __("Currency") }} <span class="text-danger">*</span></label>
								<input value="{{ $show['currency'] }}" name="currency" type="text" class="form-control" placeholder="Ex:INR" autocomplete="off" />
							</div>
						</div>
						<div class="form-group">
							<button type="reset" class="btn btn-danger mr-2" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
							<button type="submit" class="btn btn-primary" title="{{ __('Update') }}"><i class="fa fa-check-circle"></i>
								{{ __("Update")}}</button>
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
		

				var iconpickerpresent = $("button").is('#iconpick');

				if (iconpickerpresent) {

				$('#iconpick').iconpicker()
					.iconpicker('setAlign', 'center')
					.iconpicker('setCols', 5)
					.iconpicker('setArrowPrevIconClass', 'fa fa-angle-left')
					.iconpicker('setArrowNextIconClass', 'fa fa-angle-right')
					.iconpicker('setIconset', {
					iconClass: 'fa',
					iconClassFix: 'fa-',
					icons: [

						'inr', 'bitcoin', 'btc', 'cny', 'dollar', 'eur', 'ngn', 'cedi', 'rial', 'dinar', 'tugrik',
						'brazilian-real', 'idr', 'shillings', 'gg-circle', 'gg', 'ils', 'try', 'krw', 'gbp', 'zar', 'rs',
						'pula', 'aud', 'egy', 'taka', 'mal', 'rub', 'brl', 'zwl', 'ngr', 'eutho', 'sgd',
						'lkr', 'mad', 'thai', 'jod', 'tsh', 'da', 'dzd', 'rwf', 'laos', 'tnd', 'bcb', 'aoa'
					]
					})
					.iconpicker('setIcon', '{{ substr($show["icon"],3) }}')
					.iconpicker('setSearch', false)
					.iconpicker('setFooter', true)
					.iconpicker('setHeader', true)
					.iconpicker('setSearchText', 'Type text')
					.iconpicker('setSelectedClass', 'btn-warning')
					.iconpicker('setUnselectedClass', 'btn-primary');

				$('#iconpick').on('change', function (e) {
					$('#iconvalue').val('fa ' + e.icon);
				});
			}

				
	</script>

@endsection


