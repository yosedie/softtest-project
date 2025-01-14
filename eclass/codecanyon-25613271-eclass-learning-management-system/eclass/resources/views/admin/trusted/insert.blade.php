@extends('admin.layouts.master')
@section('title', 'Create Trusted Slider - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Create Trusted Slider';
$data['title'] = 'Front Settings';
$data['title1'] = 'Trusted Sliders';
$data['title2'] = 'Create Trusted Slider';
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
          <h5 class="card-title">{{ __('Add Trusted Slider') }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{url('trusted')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" action="{{url('trusted/')}}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}          
            <div class="row">
              <div class="form-group col-md-4">
                <label for="exampleInputTit1e">{{ __('URL') }}:<sup class="redstar">*</sup></label>
                    <input class="form-control" required type="url" name="url" placeholder="{{ __('Please Enter Your Trusted URL') }}">
              </div>
              <div class="form-group col-md-4">
                <label for="exampleInputSlug">{{ __('Image') }}:<sup class="redstar">*</sup></label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                  </div>
                  <div class="custom-file">
                    <input accept="image/*" type="file"name="image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                  </div>
                </div>
              </div>
              <div  class="form-group col-md-6">
                <label for="exampleInputDetails">{{ __('Status') }}:</label>
                <input  id="status" type="checkbox" name="status" class="custom_toggle" checked />
                <input type="hidden"  name="free" value="0" for="status" id="status">               
              </div>
            </div>
            <div class="form-group">
							<button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
							<button type="submit" class="btn btn-primary-rgba" title="{{ __('Create')}}"><i class="fa fa-check-circle"></i>
							{{ __("Create")}}</button>
						</div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
