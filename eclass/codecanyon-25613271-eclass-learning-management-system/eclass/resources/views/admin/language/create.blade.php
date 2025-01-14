@extends('admin.layouts.master')
@section('title', 'Create Language')
@section('maincontent')
<?php
$data['heading'] = 'Create Language';
$data['title'] = 'Site Setting';
$data['title1'] = 'Language';
$data['title2'] = 'Create Language';
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
                    <h5 class="card-box">{{ __('Create Language') }}</h5>
                    <div>
                      <div class="widgetbar">
                      <a href="{{route('show.lang')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                      </div>
                    </div>
                </div>                
                <!-- card body started -->
                <div class="card-body">
                 <!-- form start -->
                 <form id="demo-form2" method="post" action="{{action('LanguageController@store')}}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                          <!-- Local -->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="text-dark" for="local">{{ __('Local') }} : <span class="text-danger">*</span></label>
                              <input class="form-control @error('local') is-invalid @enderror" value="{{ old('local') }}" type="text" name="local" placeholder="{{ __('Please enter language local name')}}" required>
                            </div>
                          </div>
                          <!-- Name -->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="text-dark" for="name">{{ __('Name') }} : <span class="text-danger">*</span></label>
                              <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" id="sub_heading" placeholder="{{ __('Please enter language name')}} eg:English" required>
                            </div>
                          </div>
                          <!-- SetDefault -->
                          <div class="form-group col-md-2">
                              <label for="exampleInputDetails">{{ __('Set Default') }} :</label><br>
                              <input type="checkbox" class="custom_toggle" name="def" checked />
                              <input type="hidden"  name="free" value="0" for="status" id="status">
                          </div>                
                    </div>                   
                    <div class="form-group">
                        <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                        <button type="submit" class="btn btn-primary-rgba" title="{{ __('Create')}}"><i class="fa fa-check-circle"></i>
                        {{ __("Create")}}</button>
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