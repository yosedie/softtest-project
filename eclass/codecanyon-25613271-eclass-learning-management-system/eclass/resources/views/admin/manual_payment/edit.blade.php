@extends('admin.layouts.master')
@section('title', 'Edit Manual Payment Gateway - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Edit Manual Payment Gateway';
$data['title'] = 'Payment Settings';
$data['title1'] = 'Manual Payment Gateways';
$data['title2'] = 'Edit Manual Payment Gateway';
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
                    <h5 class="card-box">{{ __('Edit Manual Payment Gateway') }}</h5>
                    <div>
                        <div class="widgetbar">
                        <a href="{{url('manualpayment')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                        </div>
                      </div>
                </div>                
                <!-- card body started -->
                <div class="card-body">
                    <!-- form to edit manualpayment start -->
                    <form action="{{url('manualpayment/'.$payment->id)}}" class="form" method="POST" novalidate enctype="multipart/form-data">
                      {{ csrf_field() }}
                      {{ method_field('PUT') }}

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                          <div class="row">
                                                <div class="col-md-12">
                                                  <div class="row">
                                                      <!-- Name -->
                                                      <div class="col-md-12">
                                                          <div class="form-group">
                                                          <label class="text-dark">{{ __('Gateway Name') }} :<span class="text-danger">*</span></label>
                                                            <input value="{{ $payment->name }}" autofocus="" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Please Enter Gateway Name')}}" name="name" required="">
                                                            @error('name')
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
                                                <!-- Detail -->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                            <label class="text-dark">{{ __('Details') }} : <span class="text-danger">*</span></label>
                                                            <textarea id="detail" name="detail" class="@error('detail') is-invalid @enderror" placeholder="{{ __('Please Enter Details')}}" required="">{{ $payment->detail }}</textarea>
                                                            @error('detail')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="text-dark" for="exampleInputSlug">{{ __('Logo') }}: </label>
                                                    <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                      {{ __('Recommended size') }} {{__('410 x 410px')}}</small>
                                                    <div class="input-group mb-3">
                                                      <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload')}}</span>
                                                      </div>
                                                      <div class="custom-file">
                                                        <input accept="image/*" type="file" name="image" class="custom-file-input" id="user_img_one" aria-describedby="inputGroupFileAddon01" onchange="readURL(this);">
                                                        <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file')}}</label>
                                                      </div>
                                                    </div>
                                                    <div class="thumbnail-img-block mb-3">
                                                        @if($image = @file_get_contents('../public/images/manualpayment/'.$payment->image))
                                                        <div class="edit-user-img">
                                                            <img src="{{ url('/images/manualpayment/'.$payment->image) }}" class="image_size" id="image"/>
                                                        </div>
                                                      @else
                                                      <div class="edit-user-img">
                                                        <img src="{{ asset('images/default/user.jpg')}}"  alt="User Image"  id="image" class="img-responsive img-circle">
                                                      </div>
                                                      @endif                 
                                                       </div>   
                                                  </div>
                                                <!-- Status -->
                                                <div class="form-group col-md-2">
                                                    <label class="text-dark" for="exampleInputDetails">{{ __('Status') }}:</label><br>
                                                    <input type="checkbox" class="custom_toggle" name="status" {{ $payment->status == '1' ? 'checked' : '' }} />
                                                    <input type="hidden"  name="free" value="0" for="status" id="status">
                                                </div>

                                                <div class="col-md-12">
                                                    <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                    <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update')}}"><i class="fa fa-check-circle"></i>
                                                        {{ __("Update")}}</button>
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
<style>
    .image_size{
    height:80px;
    width:200px;
}
</style>
@endsection
<!-- This section will contain javacsript end -->