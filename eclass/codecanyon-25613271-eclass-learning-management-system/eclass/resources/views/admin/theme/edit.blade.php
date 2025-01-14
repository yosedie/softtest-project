@extends('admin.layouts.master')
@section('title', 'Front Theme Settings')
@section('maincontent')
<?php
$data['heading'] = 'Front Theme Settings';
$data['title'] = 'Front Theme Settings';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar bardashboard-card">
	@php
	    $key = \DB::table('api_keys')
        	  ->where('id', '2')
        	  ->first()
	@endphp

	@if(Module::has('Blizzard'))	
		@if(!Module::find('Blizzard')->isEnabled())
			<div class="alert alert-danger">
				<p class="alert-text">
					{{ __('Please active Blizzard from configure')}}
				</p>
			</div>
		@endif
	@endif

	@if(Module::has('Blizzard'))
	  @if(env('MIX_THEME_FOLDER') == '' || !$key)
		<div class="alert alert-danger">
			<p class="alert-text">
				{{__("Please configure Blizzard theme before using it.")}}
			</p>
		</div>
	  @endif
	@endif
							
                          
	<div class="row">
	  <div class="col-lg-12">
		@if ($errors->any())  
		<div class="alert alert-danger" role="alert">
		@foreach($errors->all() as $error)     
		<p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
		<span aria-hidden="true">&times;</span></button></p>
			@endforeach  
		</div>
		@endif
		<div class="card m-b-30">
		  <div class="card-header">
			<h5 class="card-title">{{ __('Front Theme Settings') }}</h5>
			<div>
				<div class="widgetbar">
					@can('themes.manage')
					<a href="{{ route('add.theme')}}" class="float-right btn btn-primary-rgba mr-2" title="{{ __('Add Theme') }}">
						<i class="feather icon-plus mr-2"></i>
						{{ __('Add Theme') }}
					</a>
					@endcan
				</div>
			</div>
		</div>
		  <div class="card-body">
			<form action="{{ action('ThemeController@update') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
				
				<div class="row">

					<div class="shadow-sm border card col-md-6" style="width: 18rem;">
						<img src="{{ url('images/theme/1.png') }}" class="card-img-top" alt="Classic">
						<div class="card-body">
						    <h5 class="card-title">{{ __('Classic') }}</h5>
						    <p class="card-text">{{ __('Classic Theme') }}.</p>
						    <div class="custom-radio-button mt-3">
						    	<div class="form-check-inline radio-primary">
			                      	<section class="mt-2">
										<input type="radio" id="classicTheme" name="default_theme" value="classic" required {{ $env_files['DEFAULT_THEME'] == 'classic' ? 'checked' : '' }}>
			                      		<label for="classicTheme" class="">
			                      			&nbsp;&nbsp;&nbsp;{{ __("Select Theme") }}
			                      		</label>
									</section>
									<div class=""><div class=""></div></div>
			                    </div>
			                
							<a href="{{ url('admin/coloroption')}}" class="btn btn-md btn-info-rgba mr-2">
								<i class="feather icon-settings"></i> {{__("Color Setting")}}
							  </a>
							</div>
						</div>
					</div>

					@if(Module::has('Blizzard'))
					<!-- Blizzard Configuration -->
					<div class="shadow-sm border card col-md-6" style="width: 18rem;">
						<img src="{{ url('images/theme/2.png') }}" class="card-img-top" alt="Classic">
						<div class="card-body">
						    <h5 class="card-title">
								{{ __('Blizzard')}}
							</h5>
						    <p class="card-text">
								{{ __('Blizzard VUE SPA Theme.')}}
							</p>
						    <div class="custom-radio-button mt-3">
						    	<div class="form-check-inline radio-danger">

								  <!-- Radio Button -->
			                      <section class="mt-2">
									<input type="radio" id="skillifyTheme" name="default_theme" value="blizzard" required {{ $env_files['DEFAULT_THEME'] == 'blizzard' ? 'checked' : '' }}>
									<label for="skillifyTheme" class="mr-3">
										&nbsp;&nbsp;&nbsp;{{ __("Select Theme") }}
									</label>
								  </section>
								  
								  <!-- Configure Button -->
								  <a href="{{ route('configuration.show','Blizzard')}}" class="btn btn-md btn-info-rgba mr-2">
									<i class="feather icon-settings"></i> {{__("Configure")}}
								  </a>
								  
								  <!-- Delete Button -->
								  <a href="" class="btn btn-md btn-danger-rgba" data-toggle="modal" data-target="#deleteBlizzard">
									<i class="feather icon-trash"></i> {{__("Delete")}}
								  </a>
			                    </div>

								<br>
								<br>
								<!-- Warning Message -->
								<span class="alert alert-danger">
									<i class="feather icon-alert-triangle mr-2"></i>
									{{ __('Please keep theme status disable from configure if you are not using it.')}}
								</span>
			                </div>
						</div>
					</div>

					@endif

					<!-- Apply theme button -->
					<div class="mt-3 col-md-12">
						<div class="form-group">
							<button type="submit" class="btn btn-primary-rgba" title="{{ __('Apply Theme') }}">
								<i class="fa fa-check-circle"></i>
								{{ __("Apply Theme")}}
							</button>
						</div>
					</div>
	            
            	</div>
		
			
		</form>

		<!-- delete Modal start -->
		<div class="modal fade bd-example-modal-sm" id="deleteBlizzard" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleSmallModalLabel">
							{{ __('Delete') }}
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Delete') }}">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
							<h4>{{ __('Are You Sure ?')}}</h4>
							<p>{{ __('Do you really want to delete')}} <b>{{ __('Blizzard') }}</b> ? {{ __('This process cannot be undone.')}}</p>
					</div>
					<div class="modal-footer">
						<form method="post" action="{{ route('theme.delete','Blizzard')}}" class="pull-right">
							{{ csrf_field() }}
							<button type="reset" class="btn btn-secondary" data-dismiss="modal">
								{{ __('No') }}
							</button>
							<button type="submit" class="btn btn-primary">
								{{ __('Yes') }}
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- delete Model ended -->
	  </div>
	</div>
  </div>
</div>
</div>
@endsection