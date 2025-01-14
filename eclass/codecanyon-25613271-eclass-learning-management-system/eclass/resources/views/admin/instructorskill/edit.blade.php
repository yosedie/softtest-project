@extends('admin.layouts.master')
@section('title', 'Edit Instructor skills - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Edit Instructor skills';
$data['title'] = 'Instructor skills';
$data['title1'] = 'Edit Instructor skills';
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
                    <h5 class="card-box">{{ __('Edit Instructro skills') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">

                <!-- form start -->
                <form id="demo-form2" method="post" action="{{url('instructor/skills',$instructor->id)}}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
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
                                                <div class="form-group col-md-12">
                                                    <label>{{__("Select Instructor:")}} <span
                                                            class="text-danger">*</span></label>
                                                    <select required="" class="form-control select2"
                                                        name="instructor_id">
                                                        @foreach($data as $datas)
                                                        <option {{ $instructor->instructor_id == $datas->id ? 'selected' : "" }} value="{{$datas->id }}">{{ $datas->fname }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Description -->

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="text-dark">{{ __('Skills') }}: <span
                                                                class="text-danger">*</span></label>
                                                        <textarea id="detail" name="skills" 
                                                            class="@error('skills') is-invalid @enderror"
                                                            placeholder="Please Enter Skills"
                                                            required="">{{ old('skills') }}
                                                            <input value="{{ $instructor->skills }}">
                                                        </textarea>
                                                        @error('skills')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                                  
                                                    <!-- create and close button -->
                                                    <div class="col-md-12">
                                                        <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                        <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                                            {{ __("Update")}}</button>
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