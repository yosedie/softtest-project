@extends('admin.layouts.master')
@section('title', 'Add Feature Course - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Add Feature Course';
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
                        <a href="{{url('featurecourse')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                        </div>
                      </div>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                    <div class="row align-items-center">
                            <div class="col-9">
                                <p class="mb-0 text-primary font-14">{{ __('Course :') }} {{ $featured->courses->title }} </p>
                                <p class="mb-0 text-primary font-14">{{ __('User :') }} {{ $featured->user->fname }}</p>
                                <p class="mb-0 text-primary font-14">{{ __('Transaction id :') }} {{ $featured->transaction_id }}</p>
                                <p class="mb-0 text-primary font-14">{{ __('PaymentMethod :') }} {{ $featured->payment_method }}</p>
                                <p class="mb-0 text-primary font-14">{{ __('Amount :') }} <i class="fa {{ $currency->icon }}"></i> {{ $featured->total_amount }}</p>
                                <p class="mb-0 text-primary font-14">{{ __('Currency :') }} {{ $featured->currency }}</p>
                                
                            </div>
                            <div class="col-3">
                            <img style="width: 162px;" src="{{ asset('images/course/'.$featured->courses->preview_image) }}" class="img-fluid sun-img" alt="sun">
                            </div>
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