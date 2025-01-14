@extends('admin.layouts.master')
@section('title', 'APP Secret Key')
@section('maincontent')
<?php
$data['heading'] = 'APP Secret Key';
$data['title'] = 'APP Secret Key';
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
                    <h5 class="card-box">{{ __('APP Secret Key') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                <!-- form start -->
                <form action="{{ route('apikey.create') }}" method="POST">
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
                                                    
                                                    <!-- Client Secret KEY -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Client Secret Key :') }}</label>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></span>
                                                                    </div>
                                                                    <input  value="{{ $key ? $key->secret_key : "" }}" type="text" name="apikey" class="form-control" placeholder="API KEY" aria-label="Username" aria-describedby="basic-addon1">
                                                                </div>
                                                               
                                                        </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="text-dark">{{ __('Purchase Code :') }}</label>
                                                                <input id="pass_log_id6" type="password" placeholder="Please enter valid purchase code" class="form-control"  name="purchase_code" value="{{ old('purchase_code') }}" >
                                                                <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password6"></span>
                                                                
                                                                <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('Enter envato mobile app purchase code') }}.</small>
                                                            </div>
                                                        </div>
         
                                                    <!-- update and close button -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                            <button type="submit" class="btn btn-primary-rgba" title="{{ __('RE-GENREATE KEY') }}"><i class="fa fa-check-circle"></i>
                                                            {{ $key ? "RE-GENREATE KEY" : "GET YOUR KEY" }}</button>
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
<script>
$(document).on('click', '.toggle-password6', function() {
$(this).toggleClass("fa-eye fa-eye-slash");
var input = $("#pass_log_id6");
input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});
</script>
<style>
.field_icon {
  float: right;
  margin-left: -25px;
  margin-top: -25px;
  position: relative;
  z-index: 2;
}
</style>
@endsection
<!-- This section will contain javacsript end -->