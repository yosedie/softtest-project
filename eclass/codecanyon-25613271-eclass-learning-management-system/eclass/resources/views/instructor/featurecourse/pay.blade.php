@extends('admin.layouts.master')
@section('title', 'Feature Course - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Pay to Featured Course';
$data['title'] = 'Featured Course';
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
                      <a href="{{route('featurecourse.create')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                      </div>
                    </div>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">

                <div class="row">
               <!-- first start -->
                <div class="col-lg-4">
                  <div class="card m-b-30">
                    <div class="card-body">
                      <div class="accordion accordion-outline" id="accordionoutline1">
                        <div class="card">
                        <div class="card-header" id="headingOneoutline">
                          <h2 class="mb-0">
                          <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOneoutline1" aria-expanded="false" aria-controls="collapseOneoutline">{{ __('View Course Detail') }}</button>
                          </h2>
                        </div>
                        <div id="collapseOneoutline1" class="collapse" aria-labelledby="headingOneoutline" data-parent="#accordionoutline1" style="">
                          <div class="card-body">
                        <!-- ==================== -->
                         <!-- ====================== -->
                         @if($course['preview_image'] !== NULL && $course['preview_image'] !== '')
                                <img style="width: 140px;" src="images/course/<?php echo $course['preview_image'];  ?>" class="img-fluid sun-img" />
                            @else
                                <img style="width: 140px;" src="{{ Avatar::create($course->title)->toBase64() }}" class="img-fluid sun-img" >
                            @endif
                            <br><br>
                            {{ $course->title }}
                            <br><br>
                            
                            
                            <label for="total_amount">{{__('Amount to be paid to feature a course:')}}</sup></label>&nbsp;
                            <b><i class="{{ $currency->icon }}"></i>&nbsp;{{ $gsetting->feature_amount }}</b>
                            <!-- ======================= -->
                        <!-- ====================== -->
                          </div>
                        </div>
                        </div>
                        
                      </div> 
                    </div>
                  </div>
                </div>
                <!-- first end -->
                <!-- =========== second start================== -->
                <div class="col-lg-4">
                  <div class="card m-b-30">
                    <div class="card-body">
                      <div class="accordion accordion-outline" id="accordionoutline2">
                        <div class="card">
                        <div class="card-header" id="headingOneoutline">
                          <h2 class="mb-0">
                          <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOneoutline2" aria-expanded="false" aria-controls="collapseOneoutline">{{ __('Pay With Paytm') }}</button>
                          </h2>
                        </div>
                        <div id="collapseOneoutline2" class="collapse" aria-labelledby="headingOneoutline" data-parent="#accordionoutline2" style="">
                          <div class="card-body">
                            <!-- form start -->
                            <form action="{{ url('/paywithpaytm') }}" class="form" method="POST" novalidate enctype="multipart/form-data">
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
                                                                            
                                                                            <!-- Name -->
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="text-dark">{{ __('Name :') }}</label>
                                                                                    <input type="text" name="name" class="form-control" value="{{Auth::User()->fname}}" required>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Mobile Number -->
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="text-dark">{{ __('Mobile Number :') }}</label>
                                                                                    <input type="text" name="mobile" class="form-control" placeholder="Enter Mobile Number" value="{{Auth::User()->mobile}}" required autocomplete="off">
                                                                                </div>
                                                                            </div>

                                                                            <!-- Email Id -->
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="text-dark">{{ __('Email Id :') }}</label>
                                                                                    <input type="email" name="email" class="form-control" value="{{Auth::User()->email}}" placeholder="Enter Email id" required>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Amount to pay -->
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="text-dark">{{ __('Amount to pay :') }}</label>
                                                                                    <input type="text" name="amount" class="form-control" placeholder="" value="{{ $payment->total_amount }}" readonly="">
                                                                                </div>
                                                                            </div>
                          
                                                                            <!-- create and close button -->
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                                                                                    {{ __("Pay")}}</button>
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
                    </div>
                  </div>
                </div>
                <!-- =========== second end================== -->

                <!-- =========== three start================== -->
                <div class="col-lg-4">
                  <div class="card m-b-30">
                    <div class="card-body">
                      <div class="accordion accordion-outline" id="accordionoutline3">
                        <div class="card">
                        <div class="card-header" id="headingOneoutline">
                          <h2 class="mb-0">
                          <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOneoutline3" aria-expanded="false" aria-controls="collapseOneoutline">{{ __('Pay with Paypal') }}</button>
                          </h2>
                        </div>
                        <div id="collapseOneoutline3" class="collapse" aria-labelledby="headingOneoutline" data-parent="#accordionoutline3" style="">
                          <div class="card-body">
                                  @php        
                                      $secureamount = Crypt::encrypt($payment->total_amount);
                                  @endphp
                                  <!-- form start -->
                                  <form action="{{ route('featuredWithpaypal') }}" method="POST" autocomplete="off">
                                    @csrf
                                                    
                                  <input type="hidden" name="amount" value="{{ $secureamount  }}"/>
                                  {{-- <input type="hidden" name="course_id" value="{{ $cart->courses->id }}"/> --}}
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                                        {{ __("Proceed")}}</button>
                                    </div>
                                    
                                  </form>
                                  <!-- form end -->
                          </div>
                        </div>
                        </div>
                        
                      </div> 
                    </div>
                  </div>
                </div>
                <!-- =========== three end================== -->
                </div>

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