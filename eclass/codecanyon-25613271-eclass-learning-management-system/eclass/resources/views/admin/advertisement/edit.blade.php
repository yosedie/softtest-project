@extends('admin/layouts.master')
@section('title', 'Edit Advertisement - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Edit Advertisement';
$data['title'] = 'Front Settings';
$data['title1'] = 'Advertisements';
$data['title2'] = 'Edit Advertisement';
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
          <h5 class="card-title">{{ __('Edit Advertisement') }}</h5>
          <div class="">
            <div class="widgetbar">
              <a href="{{url('advertisement')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>          
            </div>
          </div>
        </div>
        <div class="card-body">
          <form id="demo-form" method="post" action="{{url('advertisement/'.$advs->id)}}
            "data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}                    
            <div class="row">
              <div class="form-group col-md-3">
                <label for="exampleInputTit1e">{{ __('Image') }}:<sup class="redstar">*</sup></label><br>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                  </div>
                  <div class="custom-file">
                    <input accept="image/*" type="file" name="image1" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Back') }}{{ __('Choose file') }}</label>
                  </div>
                </div>
                <img src="{{ url('/images/advertisement/'.$advs->image1) }}" class="image_size" alt="{{ __('Advertisement')}}"/><br>
                <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Recommended Size') }} (1375 x 409PX)</small>
              </div>
              <div class="form-group col-md-4">
                <label for="exampleInputDetails">{{ __('Enter URL') }}:</label>
                <input type="title" class="form-control" name="url1" id="exampleInputTitle" value="{{ $advs->url1 }}" placeholder="{{ __('Enter URL') }}" >
              </div>
              <div class="form-group col-md-3">
                <label for="exampleInputDetails">{{ __('Position') }}:<sup class="redstar">*</sup></label>
                          <select class="select2-single form-control"  name="position">
                          </option>
                          <option {{ $advs->position == 'belowslider' ? 'selected' : ''}} value="belowslider">{{ __('Below Slider') }}</option>

                          <option {{ $advs->position == 'belowrecent' ? 'selected' : ''}} value="belowrecent">{{ __('Below Recent Courses') }}</option>
      
                          <option {{ $advs->position == 'belowbundle' ? 'selected' : ''}} value="belowbundle">{{ __('Below Bundle Courses') }}</option>
      
                          <option {{ $advs->position == 'belowtestimonial' ? 'selected' : ''}} value="belowtestimonial">{{ __('Below Testimonial') }}</option>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                <label for="exampleInputDetails">{{ __('Status') }}:</label><br>
                <input type="hidden"  name="free" value="0" for="status" id="status">
                <input id="status" type="checkbox" name="status" {{ $advs->status == '1' ? 'checked' : '' }} class="custom_toggle" />
              </div>
                </div>
          <div class="form-group">
            <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
            <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update')}}"><i class="fa fa-check-circle"></i>
            {{ __("Update")}}</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>  
@endsection
