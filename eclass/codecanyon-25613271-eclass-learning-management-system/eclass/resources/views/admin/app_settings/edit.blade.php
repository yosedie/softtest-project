@extends('admin.layouts.master')
@section('title', 'API Setting - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Dashboard';
$data['title'] = 'API Setting';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    <div class="row">
@if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
  <!-- row started -->
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('APPSetting') }}</h5>
                </div> 
               <!-- card body started -->
                <div class="card-body">
                  <!-- form start -->
                  <form action="{{ route('appsettings.update') }}" method="POST">
		                {{ csrf_field() }}
		                {{ method_field('POST') }}
                     <div class="col-md-12">
                      <div class="form-group">
                        <label class="text-dark" for="s_enable">{{ __('GOOGLE PAYMENT') }}</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch1" name="googlepay_enable" {{ $gsetting->googlepay_enable==1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="status" id="customSwitch1">
                      </div>
                    </div>
                    <div class="form-group">
							<button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
							<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
								{{ __("Update")}}</button>
						</div>

		          	</form>
                  <!-- form end -->
                </div><!-- card body end -->
            
        </div><!-- col end -->
    </div>
</div>
</div><!-- row end -->
    <br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain javacsript start -->
