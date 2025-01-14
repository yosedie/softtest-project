@extends('admin.layouts.master')
@section('title', 'Create Fact Slider - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Create Facts Slider';
$data['title'] = 'Front Settings';
$data['title1'] = 'Facts Slider';
$data['title2'] = 'Create Fact Slider';
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
          <h5 class="card-title">{{ __('Add Fact Slider') }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{url('facts')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
            </div>                        
          </div>
        </div>
        <div class="card-body">          
          <form id="demo-form2" method="post" action="{{action('SliderfactsController@store')}}"vdata-parsley-validate 
          class="form-horizontal form-label-left"enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="row">
            <div class="form-group col-md-3">
              <label for="icon">{{ __('Icon') }}:<sup class="redstar text-danger">*</sup></label>
             <div class="input-group">
                  <input type="text" class="form-control iconvalue" name="icon" value="Choose icon">
                  <span class="input-group-append">
                      <button  type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                  </span>
              </div>
              
            </div>
            <div class="form-group col-md-4">
              <label for="heading">{{ __('Heading') }}:<sup class="redstar text-danger">*</sup></label>
              <input class="form-control" type="text" name="heading" placeholder="{{ __('Please Enter Your Heading') }}">
            </div>

            <div class="form-group col-md-4">
              <label for="sub_heading">{{ __('Sub Heading') }}:<sup class="redstar text-danger">*</sup></label>
              <input type="text" class="form-control" name="sub_heading" id="sub_heading" placeholder="{{ __('Please Enter Your Sub Heading') }}">
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
