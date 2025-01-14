@extends('admin.layouts.master')
@section('title', 'Add Page')
@section('maincontent')
<?php
$data['heading'] = 'Add Page';
$data['title'] = 'Pages';
$data['title1'] = 'Add Page';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
<div class="row">
@if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
  <!-- row started -->
    <div class="col-lg-12">
        <div class="card dashboard-card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Add Pages') }}</h5>
                    <div>
                        <div class="widgetbar">
                        <a href="{{url('page')}}" class="btn btn-primary-rgba" title="{{ __('Back') }}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                        </div>
                      </div>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">

                <!-- form start -->
                <form action="{{url('page/')}}" class="form" method="POST" novalidate enctype="multipart/form-data">
                        @csrf
                        <!-- row start -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- card start -->
                                <div class="card">
                                    <!-- card body start -->
                                    <div class="card-body">
                                        <!-- row start -->
                                          <div class="row">
                                              
                                              <div class="col-md-12">
                                                  <!-- row start -->
                                                  <div class="row">
                                                    
                                                    <!-- Title -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Title') }} <span class="text-danger">*</span></label>
                                                            <input id="title" type="text" value="{{ old('title') }}" autofocus="" class="form-control @error('title') is-invalid @enderror" placeholder="{{ __('Enter Page Title') }}" name="title" required="">
                                                            @error('title')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- slug -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Slug') }}:</label>
                                                            <input id="slug" type="text" pattern="[/^\S*$/]+" value="{{ old('slug') }}" autofocus="" class="form-control @error('title') is-invalid @enderror" placeholder="{{ __('Enter Slug') }}" name="slug" required="">
                                                            @error('title')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="page_type" class="form-control">{{ __('Page Type') }}<span class="required">*</span></label>
                                                        <select class="form-select" aria-label=" " name="page_type">
                                                            <option selected="" disabled=""> {{ __('Select Page Type') }}</option>
                                                            <option value="tc">{{ __(' Terms And Conditions') }}
                                                            </option>
                                                            <option value="pp"> {{ __('Privacy Policy') }}</option>
                                                            <option value="retp">{{ __('Return Policy') }} </option>
                                                            <option value="refp">{{ __('Refund Policy ') }}</option>
                                                            <option value="ap">{{ __('Affiliate Policy') }} </option>
                                                            <option value="gp">General Policy </option>
                                                            <option value="au">About Us </option>
                                                            <option value="sp">Shipping Policy </option>
                                                            <option value="tp">Terms And Use Policy
                                                            </option>
                                                            <option value="cp">Cookiee Policy </option>
                                                            <option value="op">Other Pages </option>
                                                        </select>
                                                        <div class="form-control-icon"><i class="flaticon-pages"></i></div>
                                                    </div>
                                                    </div>
                                                    <!-- Description -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Details') }}: <span class="text-danger">*</span></label>
                                                            <textarea id="detail" name="details" class="@error('details') is-invalid @enderror" placeholder="{{ __('Please Enter Description') }}" required="">{{ old('details') }}</textarea>
                                                            @error('description')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                  
                                                     <!-- Status -->
                                                     <div class="form-group col-md-2">
                                                        <label for="exampleInputDetails">{{ __('Status') }} :</label><br>
                                                        <input type="checkbox" class="custom_toggle" name="status" checked />
                                                        <input type="hidden"  name="free" value="0" for="status" id="status">
                                                    </div>
                                                                  
                                                    <!-- create and close button -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                            <button type="submit" class="btn btn-primary-rgba" title="{{ __('Create') }}"><i class="fa fa-check-circle"></i>
                                                            {{ __("Create")}}</button>
                                                        </div>
                                                    </div>

                                                  </div><!-- row end -->
                                              </div><!-- col end -->
                                          </div><!-- row end -->

                                    </div><!-- card body end -->
                                </div><!-- card end -->
                            </div><!-- col end -->
                        </div><!-- row end -->
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
@section('script')
@endsection
<!-- This section will contain javacsript end -->