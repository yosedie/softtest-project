@extends('admin.layouts.master')
@section('title', 'Add Manual Payment Gateway - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Add Manual Payment Gateway';
$data['title'] = 'Payment Settings';
$data['title1'] = 'Manual Payment Gateways';
$data['title2'] = 'Add Manual Payment Gateway';
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
                    <h5 class="card-box">{{ __('Add Manual Payment Gateway') }}</h5>
                    <div>
                        <div class="widgetbar">
                        <a href="{{url('manualpayment')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                        </div>
                      </div>
                </div>                
                <!-- card body started -->
                <div class="card-body">
               <!-- form to create manualpayment start -->
<form action="{{url('manualpayment/')}}" class="form" method="POST" novalidate enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="card">          
                <div class="card-body">
                      <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                   <!-- Name -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-dark">{{ __('Gateway Name') }} :<span class="text-danger">*</span></label>
                                            <input value="{{ old('name') }}" autofocus="" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Please Enter Gateway Name')}}" name="name" required="">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- image -->
                            <div class="form-group col-md-4">
                                <label class="text-dark" for="exampleInputSlug">{{ __('Logo') }}: </label>
                                <small class="text-muted"><i class="fa fa-question-circle"></i>
                                  {{ __('Recommended size') }} (410 x 410px)</small>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload')}}</span>
                                  </div>
                                  <div class="custom-file">
                                    <input accept="image/*" type="file" name="image" class="custom-file-input" id="user_img_one" aria-describedby="inputGroupFileAddon01" onchange="readURL(this);">
                                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose File')}}</label>
                                  </div>
                                </div>
                                <div class="thumbnail-img-block mb-3">
                                  <img src="{{ url('images/user_img/user.jpg')}}" id="image" class="img-fluid" alt="{{ __('Gateway Logo')}}">
                                </div>   
                              </div>
                      </div>
                      <hr>
                        <div class="row">
                            <!-- Detail -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-dark">{{ __('Details') }} : <span class="text-danger">*</span></label>
                                    <textarea id="detail" name="detail" class="@error('detail') is-invalid @enderror" placeholder="Please Enter Detail" required="">{{ old('detail') }}</textarea>
                                    @error('detail')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>                            
                             <!-- Status -->
                             <div class="form-group col-md-6">
                                <label for="exampleInputDetails">{{ __('Status') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" name="status" checked />
                                <input type="hidden"  name="free" value="0" for="status" id="status">
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba" title="{{ __('Create')}}"><i class="fa fa-check-circle"></i>
                                    {{ __("Create")}}</button>
                                </div>
                            </div>
  
                        </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- form to create manualpayment end -->
                </div><!-- card body end -->
            
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