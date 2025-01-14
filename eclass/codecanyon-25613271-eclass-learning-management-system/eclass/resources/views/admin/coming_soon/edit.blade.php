@extends('admin.layouts.master')
@section('title', 'Coming Soon Page - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Coming Soon Page';
$data['title'] = 'Front Settings';
$data['title'] = 'Coming Soon Page';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    <div class="row">
@if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close')}}">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
  <!-- row started -->
    <div class="col-lg-12">
		<div class="card dashboard-card m-b-30">
        	 <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Coming Soon Page') }}</h5>
                </div> 
               <!-- card body started -->
                <div class="card-body">
                <!-- form for coming soon start -->
				<form action="{{ action('ComingSoonController@update') }}" method="POST" enctype="multipart/form-data">
		                {{ csrf_field() }}
		                {{ method_field('PUT') }}
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">

									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<!-- Heading -->
												<div class="col-md-2">
													<div class="form-group">
														<label class="text-dark">{{ __('Heading') }} : <span class="text-danger">*</span></label>
														<input type="text" value="{{ optional($comingsoon)->heading }}" autofocus="" class="form-control @error('heading') is-invalid @enderror" placeholder="{{ __('Enter Heading') }}" name="heading" required="">
														@error('heading')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>
												</div>												
													<!-- ButtonText -->
													<div class="col-md-2">
														<div class="form-group">
															<label class="text-dark">{{ __('Button Text') }} : <span class="text-danger">*</span></label>
															<input type="text" value="{{ optional($comingsoon)->btn_text }}" autofocus="" class="form-control @error('btn_text') is-invalid @enderror" placeholder="{{ __('Enter Button Text') }}" name="btn_text" required="">
															@error('btn_text')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
													</div>													
													<div class="col-md-2">
														<div class="form-group">
															<label class="text-dark" for="count_one">{{ __('Counter One') }} <span class="text-danger">*</span></label>
															<input value="{{ optional($comingsoon)->count_one }}" autofocus="" type="text" name="count_one" class="form-control @error('count_one') is-invalid @enderror" placeholder="{{ __('Enter Counter One Value') }}" required>
															@error('count_one')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
													</div>
													<!-- CounterTwo -->
													<div class="col-md-2">
														<div class="form-group">
															<label class="text-dark" for="count_two">{{ __('Counter Two') }} <span class="text-danger">*</span></label>
															<input value="{{ optional($comingsoon)->count_two }}" autofocus="" type="text" name="count_two" class="form-control @error('count_one') is-invalid @enderror" placeholder="{{ __('Enter Counter Two Value') }}" required>
														</div>
													</div>
													<!-- CounterThree -->
													<div class="col-md-2">
														<label class="text-dark" for="count_three">{{ __('Counter Three') }} <span class="text-danger">*</span></label>
														<input value="{{ optional($comingsoon)->count_three }}" type="text" name="count_three" class="form-control" placeholder="{{ __('Enter Counter Three Value') }}" required>
													</div>
													<!-- CounterFour -->
													<div class="col-md-2">
														<div class="form-group">
															<label class="text-dark" for="count_four">{{ __('Counter Four') }} <span class="text-danger">*</span></label>
															<input type="text" name="count_four" class="form-control" value="{{ optional($comingsoon)->count_four }}" placeholder="{{ __('Enter Counter Four Value') }}" required/>	
															@error('count_four')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
													</div>   
											</div>
										</div>
									</div>
									<hr>
										<div class="row">
											<!-- CounterOne Text -->
											<div class="col-md-3">
												<div class="form-group">
													<label class="text-dark" for="text_one">{{ __('Counter One') }} {{ __('Text') }} <span class="text-danger">*</span></label>
													<input type="text" name="text_one" class="form-control" value="{{ optional($comingsoon)->text_one }}" placeholder="{{ __('Enter Counter One Text') }}" required/>
													@error('text_one')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div> 
											<!-- CounterTwo Text -->
											<div class="col-md-3">
												<div class="form-group">
													<label class="text-dark" for="text_two">{{ __('Counter Two') }} {{ __('Text') }} <span class="text-danger">*</span></label>
													<input value="{{ optional($comingsoon)->text_two }}" name="text_two" type="text" class="form-control" placeholder="{{ __('Enter Counter Two Text') }}" required/>
													@error('text_two')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>   
											<!-- CounterThree Text -->
											<div class="col-md-3">
												<div class="form-group">
													<label class="text-dark" for="text_three">{{ __('Counter Three') }} {{ __('Text') }}<span class="text-danger">*</span></label>
													<input value="{{ optional($comingsoon)->text_three }}" name="text_three" type="text" class="form-control" placeholder="{{ __('Enter Counter Three Text') }}" required/>
													@error('text_three')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>   
											<!-- CounterFour Text -->
											<div class="col-md-3">
												<div class="form-group">
													<label class="text-dark" for="text_four">{{ __('Counter Four') }} {{ __('Text') }} <span class="text-danger">*</span></label>
													<input value="{{ optional($comingsoon)->text_four }}" name="text_four" type="text" class="form-control" placeholder="{{ __('Enter Counter Four Text') }}" required/>
													@error('text_four')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>  
										</div>
									<!-- ============================ -->
									<hr>
										<div class="row">
											<!-- IP Address -->
											<div class="col-md-4">
												<div class="form-group">
													<label class="text-dark" for="url">{{ __("Enter IP Address to allowed while Maintenance Mode is Enabled (ex: 172.16.254.1)") }} <span class="text-danger">*</span></label>
													<select class="select2-multi-select form-control" name="allowed_ip[]" multiple="multiple">													
														@if(is_array(optional($comingsoon)->allowed_ip) || is_object(optional($comingsoon)->allowed_ip)) 
															@foreach(optional($comingsoon)->allowed_ip as $cat)
															<option value="{{ $cat }}" {{in_array($cat, $comingsoon['allowed_ip'] ?: []) ? "selected": ""}} >{{ $cat }}
															</option>
															@endforeach
														@endif
													</select>
												</div>
											</div>  
											<div class="form-group col-md-3">
												<label class="text-dark" for="exampleInputDetails">{{ __('Enable Maintenance Mode') }} :</label><br>
												<input type="checkbox" class="custom_toggle" name="enable" {{ optional($comingsoon)['enable'] == '1' ? 'checked' : '' }} />
												<input type="hidden"  name="free" value="0" for="status" id="status"><br>
												<small></small>
											</div>
											<!-- image -->
											<div class="form-group col-md-3">
												<label class="text-dark">{{ __('Image') }}:<span class="text-danger">*</span></label><br>
												<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
												</div>
												<div class="custom-file">
													<input accept="image/*" type="file" class="custom-file-input" id="inputGroupFile01" name="bg_image" aria-describedby="inputGroupFileAddon01">
													<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose File') }}</label>
												</div>
												</div>
												@if($image = @file_get_contents('../public/images/comingsoon/'.$comingsoon->bg_image))
												<img src="{{ url('/images/comingsoon/'.$comingsoon->bg_image) }}" class="image_size"/>
												@endif
											</div>											
											<!-- enable -->		
											<div class="col-md-12">
												<div class="form-group">
													<button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
													<button type="submit" class="btn btn-primary-rgba" title="{{ __('Save')}}"><i class="fa fa-check-circle"></i>
													{{ __("Save")}}</button>
												</div>
											</div>				
										</div>
								</div>
							</div>
						</div>
					</div>
				</form>
				<!-- form for comming soon end -->
                </div>
				<!-- card body end -->
        </div><!-- col end -->
    </div>
</div>
</div><!-- row end -->
    <br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain javacsript start -->
@section('script')
<!-- css for coming soon start -->
<style>
	.image_size{
	    height: 80px;
	    width: 200px;
	}
</style>
<!-- css for coming soon end -->
@endsection
<!-- This section will contain javacsript end -->
