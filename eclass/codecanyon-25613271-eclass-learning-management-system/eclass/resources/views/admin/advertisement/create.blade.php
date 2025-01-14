@extends('admin/layouts.master')
@section('title', 'Create Advertisements - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Create Advertisement';
$data['title'] = 'Front Settings';
$data['title1'] = 'Advertisements';
$data['title2'] = 'Create Advertisement';
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
          <h5 class="card-title">{{ __('Create Advertisement') }}</h5>
          @can('front-settings.advertisement.create')
          <div>
          <div class="widgetbar">
          <a href="{{url('advertisement')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
        </div>
        </div>
        @endcan
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" action="{{url('advertisement/')}}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}                    
            <div class="row">                        
              <div class="form-group col-md-3">
                <label for="exampleInputTit1e">{{ __('Image') }}:<sup class="text-danger">*</sup></label><br>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                  </div>
                  <div class="custom-file">
                    <input accept="image/*" type="file" name="image1" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                  </div>
                </div>
                <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Recommended Size') }} (1375 x 409PX)</small>
              </div>
              <div class="form-group col-md-4">
                <label for="exampleInputDetails">{{ __('Enter URL') }}:</label>
                  <input type="title" class="form-control" name="url1" id="exampleInputTitle" placeholder="{{ __('EnterURL') }}" >

              </div>
              <div class="form-group col-md-3">
                <label for="exampleInputDetails">{{ __('Position') }}:<sup class="redstar">*</sup></label>
                  <select class="select2-single form-control"  name="position">
                  </option>
                  <option value="belowslider">{{ __('Below Slider') }}</option>
                  <option value="belowrecent">{{ __('Below Recent Courses') }}</option>
                  <option value="belowbundle">{{ __('Below Bundle Courses') }}</option>
                  <option value="belowtestimonial">{{ __('Below Testimonial') }}</option>
                </select>
              </div>            
              <div class="form-group col-md-6">
                <label for="exampleInputDetails">{{ __('Status') }}:</label><br>                
                <input type="hidden"  name="free" value="0" for="status" id="status" />
                <input id="status" type="checkbox" name="status"  class="custom_toggle" checked/>
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
