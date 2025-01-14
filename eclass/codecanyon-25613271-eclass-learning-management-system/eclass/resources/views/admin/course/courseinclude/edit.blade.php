@extends('admin.layouts.master')
@section('title','Edit Course-include')
@section('maincontent')
<?php
$data['heading'] = 'Edit Course-include';
$data['title'] = 'Edit Course-include';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar bardashboard-card">
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-box">{{ __('Edit') }} {{ __('Course Include') }}</h5>
          <div class="widgetbar">
            <a href="{{ url('course/create/'. $cate->courses->id) }}" class="float-right btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
          </div>
        </div>
        <div class="card-body ml-2">
         <!-- form start -->
         <form id="demo-form" method="post" action="{{url('courseinclude/'.$cate->id)}}"data-parsley-validate class="form-horizontal form-label-left">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
                        <input  type="hidden" class="form-control" name="user_id" value="{{ Auth::User()->id }}" >
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
                                                    
                                                     <!-- SelectCourse -->
                                                     <div class="col-md-6 d-none">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('SelectCourse') }} :</label>
                                                            <select name="course_id" class="select2 form-control">
                                                              @foreach($courses as $cou)
                                                                <option  value="{{ $cou->id }}" {{$cate->courses->id == $cou->id  ? 'selected' : ''}}>{{ $cou->title}}</option>
                                                              @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- SelectCourse -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Icon') }} : <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control iconvalue" name="icon" value="{{$cate->icon}}">
                                                                <span class="input-group-append">
                                                                    <button  type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                      <!-- Detail -->
                                                      <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Detail') }} : <span class="text-danger">*</span></label>
                                                            <textarea rows="1" name="detail" class="form-control" >{!! $cate->detail !!}</textarea>
                                                        </div>
                                                    </div>
                                                    <!-- status -->
                                                    <div class="form-group col-md-3">
                                                      <label class="text-dark" for="exampleInputDetails">{{ __('Status') }} :</label><br>
                                                      <label class="switch">
                                                        <input class="slider" type="checkbox" name="status" {{ $cate->status == '1' ? 'checked' : '' }} />
                                                        <span class="knob"></span>
                                                      </label>
                                                    </div>
                                                   
                                                                      
                                                    <!-- create and close button -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                                            {{ __("Update")}}</button>
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
    
      </div>
    </div>
  </div>
</div>
@endsection