@extends('admin.layouts.master')
@section('title', 'Bank Detail - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Bank Details';
$data['title'] = 'Payment Settings';
$data['title1'] = 'Bank Details';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    <div class="row">
        <!-- row started -->
    <div class="col-lg-12">
        @if ($errors->any())  
        <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)     
        <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close')}}">
        <span aria-hidden="true" style="color:red;">&times;</span></button></p>
        @endforeach  
        </div>
        @endif
        <div class="card dashboard-card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Bank Details') }}</h5>
                </div>                
                <!-- card body started -->
                <div class="card-body">
                <!-- form start -->
				<form action="{{ action('BankTransferController@update') }}" class="form" method="POST" novalidate enctype="multipart/form-data">
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
                                                    
                                                    <!-- Account Holder Name -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Account Holder Name') }}<span class="text-danger">*</span></label>
                                                            <input name="account_holder_name" type="text" value="{{ optional($show)->account_holder_name }}" class="form-control" placeholder="{{ __('Enter Account Holder Name') }}" required>
                                                            @error('account_holder_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                     <!-- Bank Name -->
                                                     <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Bank Name') }}<span class="text-danger">*</span></label>
                                                            <input name="bank_name" type="text" value="{{ optional($show)->bank_name }}" class="form-control @error('bank_name') is-invalid @enderror" placeholder="{{ __('Enter BankName') }}" required>
                                                            @error('bank_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- Account Number -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Account Number') }}<span class="text-danger">*</span></label>
                                                            <input name="account_number" type="text" value="{{ optional($show)->account_number }}" class="form-control @error('account_number') is-invalid @enderror" placeholder="{{ __('Enter') }} {{ __('Account Number') }}" required>
                                                            @error('account_number')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

													<!-- IFCS Code -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('IFCS Code') }} :</label>
                                                            <input name="ifcs_code" type="text" value="{{ optional($show)->ifcs_code }}" class="form-control @error('ifcs_code') is-invalid @enderror" placeholder="{{ __('Enter IFCS Code') }}">
                                                            @error('ifcs_code')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

													<!-- Swift Code -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Swift Code ') }} :</label>
                                                            <input name="swift_code" type="text" value="{{ optional($show)->swift_code }}" class="form-control @error('swift_code') is-invalid @enderror" placeholder="{{ __('Enter Swift Code') }}">
                                                            @error('ifcs_code')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                
                                                   <!-- Bank Enable -->
                                                   <div class="form-group col-md-6">
                                                        <label class="text-dark" for="exampleInputDetails">{{ __('Bank Enable') }} :</label><br>
                                                        <input type="checkbox" class="custom_toggle" name="bank_enable" {{ optional($show)['bank_enable'] == '1' ? 'checked' : '' }} />
                                                        <input type="hidden"  name="free" value="0" for="status" id="status">
                                                    </div>
           
                                                    <!-- create and close button -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                            <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update')}}"><i class="fa fa-check-circle"></i>
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