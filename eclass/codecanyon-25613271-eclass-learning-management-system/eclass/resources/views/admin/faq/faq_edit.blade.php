@extends('admin.layouts.master')
@section('title', 'Edit FAQs Students')
@section('maincontent')
<?php
$data['heading'] = 'Edit FAQs Students';
$data['title'] = 'FAQs';
$data['title1'] = 'FAQs Students';
$data['title2'] = 'Edit FAQs Students';
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
                    <h5 class="card-box"> {{ __('Edit FAQs Students') }}</h5>
                    <div>
                        <div class="widgetbar">
                        <a href="{{url('faq')}}" class="btn btn-primary-rgba" title="{{ __('Back') }}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                        </div>
                      </div>
                </div>
                <!-- card body started -->
                <div class="card-body">
                    <!-- form start -->
            <form action="{{url('faq/'.$find->id)}}" class="form" method="POST" novalidate enctype="multipart/form-data">
                  {{ csrf_field() }}
                  {{method_field('PATCH')}}
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
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Question') }}: <span class="text-danger">*</span></label>
                                                            <input type="text" value="{{$find->title}}" autofocus="" class="form-control @error('title') is-invalid @enderror" placeholder="{{ __('Enter Question') }}" name="title" required="">
                                                            @error('title')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- details -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Answer') }}: <span class="text-danger">*</span></label>
                                                            <textarea id="detail" name="details" class="@error('details') is-invalid @enderror" placeholder="Please Enter Answer" required="">{{$find->details}}</textarea>
                                                            @error('details')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    
                                                   <!-- Status -->
                                                   <div class="form-group col-md-2">
                                                        <label class="text-dark" for="exampleInputDetails">{{ __('Status') }} :</label><br>
                                                        <input type="checkbox" class="custom_toggle" name="status" {{ $find->status == '1' ? 'checked' : '' }} />
                                                        <input type="hidden"  name="free" value="0" for="status" id="status">
                                                    </div>
                                                                      
                                                    <!-- update and reset button -->
                                                    <div class="col-md-12">
                                                        <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                        <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update') }}"><i class="fa fa-check-circle"></i>
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