@extends('admin.layouts.master')
@section('title', 'Add Feature Course - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Add Feature Course';
$data['title'] = 'Feature Course';
$data['title1'] = 'Add Feature Course';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
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
        @include('admin.message')
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box"> {{ __('Feature Course') }}</h5>
                    <div>
                        <div class="widgetbar">
                        <a href="{{url('featurecourse')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                        </div>
                      </div>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">

                    <!-- form start -->
                    <form action="{{route('featurecourse.store')}}" class="form" method="POST" novalidate enctype="multipart/form-data">
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
                                                    
                                                    <!-- Select Course -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('SelectCourse') }} : <span class="text-danger">*</span></label>
                                                             <select class="select2 form-control" id="course_id" name="course_id" required>
                                                              <option value="">{{ __('SelectanOption') }}</option>
                                                              @foreach($courses as $course)
                                                                <option value="{{$course->id}}">{{$course->title}}</option>
                                                              @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                      <!-- User -->
                                                      <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('User') }} :</label>
                                                            <select class="select2 form-control" name="user_id">
                                                              <option value="{{Auth::user()->id}}">{{Auth::user()->fname}}</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 display-none"> 
                                                      <label for="total_amount"></sup></label>
                                                      <input value="{{ $gsetting->feature_amount }}" type="hidden" name="total_amount" class="form-control" readonly="">
                                                    </div>

                                                     <!-- User -->
                                                   
                                                   
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                    <label class="text-dark" for="total_amount">{{__('Amount to be paid to feature a course:')}}</sup></label>&nbsp;
                                                    <i class="{{ $currency->icon }}"></i>&nbsp;{{ $gsetting->feature_amount }}
                                                    </div>
                                                    </div>

                                                    <!-- create and reset button -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                                                            {{ __("Pay to feature course")}}</button>
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