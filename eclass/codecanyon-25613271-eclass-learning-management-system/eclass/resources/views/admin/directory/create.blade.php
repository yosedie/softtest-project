@extends('admin.layouts.master')
@section('title', 'Create SEO Directory- Admin')
@section('maincontent')
<?php
$data['heading'] = 'Create SEO Directory';
$data['title'] = 'Front Settings';
$data['title1'] = 'SEO Directory';
$data['title2'] = 'Create SEO Directory';
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
          <h5 class="card-title">{{ __('Add SEO Directory') }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{url('directory')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>          
            </div>
          </div>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" action="{{url('directory/')}}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="form-group col-md-3">
                <label for="exampleInputTit1e">{{ __('City') }}:<sup class="redstar">*</sup></label>
                <input class="form-control" type="text" name="city" placeholder="{{ __('Enter City') }}">

              </div>
              <div class="form-group col-md-12">
                <label for="exampleInputDetails">{{ __('Details') }}:<sup class="redstar">*</sup></label>
                <textarea name="detail" id="detail" rows="3" class="form-control" placeholder="{{ __('Enter Details') }}"></textarea>
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputDetails">{{ __('Status') }}:</label>
                <input  id="status" type="checkbox" name="status" class="custom_toggle" checked/>
                <input type="hidden"  name="free" value="0" for="status" id="status">                    
              </div>              
              <div class="form-group col-md-6">
                <label for="exampleInputDetails">{{ __('Search on Slider') }}:
                  </label>
                <input id="search_toggle" type="checkbox" name="search_enable" class="custom_toggle" checked/>
                <input type="hidden" name="free" value="0" for="search_enable" id="search_enable">
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