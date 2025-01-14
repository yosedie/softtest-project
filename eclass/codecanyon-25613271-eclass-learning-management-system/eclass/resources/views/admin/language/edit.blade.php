@extends('admin.layouts.master')
@section('title', 'Edit Language')
@section('maincontent')
<?php
$data['heading'] = 'Edit Language';
$data['title'] = 'Site Setting';
$data['title1'] = 'Language';
$data['title2'] = 'Edit Language';
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
                    <h5 class="card-box">{{ __('Edit Language') }}</h5>
					<div>
						<div class="widgetbar">
						<a href="{{route('show.lang')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
						</div>
					  </div>
                </div>                
                	<!-- card body started -->
                	<div class="card-body">
                   		<!-- form start -->
						<form id="demo-form2" method="post" action="{{route('languages.update',$language->id)}}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
							{{ csrf_field() }}
							{{ method_field('PUT') }}					
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label class="text-dark" for="local">{{ __('Local') }} : <span class="text-danger">*</span></label>
										<input class="form-control @error('local') is-invalid @enderror" type="text" name="local" placeholder="{{ __('Please enter language local name')}}" value="{{ $language->local }}" required>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="text-dark" for="name">{{ __('Name') }} : <span class="text-danger">*</span></label>
										<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="sub_heading" value="{{ $language->name }}" placeholder="{{ __('Please enter language name')}} eg:English" required>
									</div>
								</div>
								<div class="form-group col-md-2">
									<label class="text-dark" for="exampleInputDetails">{{ __('Set Default') }} :</label><br>
									<input type="checkbox" class="custom_toggle" name="def" {{ $language->def==1 ? "checked" : "" }}/>
									<input type="hidden"  name="free" value="0" for="status" id="status">
								</div>
							</div>							
							<div class="form-group">
								<button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
								<button type="submit" class="btn btn-primary-rgba" title="{{ __('Update')}}"><i class="fa fa-check-circle"></i>
								{{ __("Update")}}</button>
							</div>				
						</form>
						<!-- form end -->
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
@endsection
<!-- This section will contain javacsript end -->