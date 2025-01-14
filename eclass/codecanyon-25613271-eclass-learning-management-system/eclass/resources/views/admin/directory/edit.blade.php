@extends('admin.layouts.master')
@section('title', 'Edit SEO Directory - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Edit SEO Directory';
$data['title'] = 'Front Settings';
$data['title1'] = 'SEO Directory';
$data['title2'] = 'Edit SEO Directory';
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
          <h5 class="card-title">{{ __('Edit SEO Directory') }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{url('directory')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>          
            </div>
          </div>
        </div>
        <div class="card-body">
          <form id="demo-form" method="post"  action="{{url('directory/'.$show->id)}}
            "data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
              <div class="form-group col-md-3">
                <label for="exampleInputTit1e">{{ __('City') }}:<sup class="redstar">*</sup></label>
                <input type="text" class="form-control" name="heading" id="exampleInputTitle" value="{{$show->city}}">

              </div>
              <div class="form-group col-md-12">
                <label for="exampleInputTit1e">{{ __('Details') }}:<sup class="redstar">*</sup></label>
                <textarea type="text" id="detail" rows="3" class="form-control" name="detail" id="exampleInputTitle">{{$show->detail}}</textarea>
              </div>
              <div class="d-none">
                <label for="exampleInputDetails">{{ __('Status') }}:</label>
                <input  id="status" type="checkbox" name="status" class="custom_toggle" />
                <input type="hidden"  name="free" value="0" for="status" id="status">                    
              </div>              
              <div class="form-group col-md-2">
                <label for="exampleInputDetails">{{ __('Search on Slider') }}:
                    </label>
                <input id="search_toggle" type="checkbox"  name="status" class="custom_toggle"  {{ $show->status == '1' ? 'checked' : '' }} />
                <input type="hidden"  name="free" value="0" for="status" id="status">
              </div>
            </div>
            <div class="form-group">
							<button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
							<button type="submit" class="btn btn-primary-rgba" title="{{ __('Update')}}"><i class="fa fa-check-circle"></i>
							{{ __("Update")}}</button>
						</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
