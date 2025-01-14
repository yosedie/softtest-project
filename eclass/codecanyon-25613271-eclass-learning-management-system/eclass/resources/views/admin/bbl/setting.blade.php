@extends('admin.layouts.master')
@section('title', 'Big Blue Settings- Admin')
@section('maincontent')
<?php
$data['heading'] = 'Big Blue Settings';
$data['title'] = 'Setting';
$data['title1'] = 'Big Blue Settings';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  @if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
  @endforeach  
  </div>
  @endif
<div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Update BigBlue Button Salt Key and Server URL : ') }}</h5>
        </div>
        <div class="card-body">

          <form action="{{ route('bbl.update.setting') }}" method="POST">
            @csrf

            <div class="row">
            

              <div class="form-group col-md-6">
                <label>{{ __('BBL SALT KEY:') }}<sup
                  class="redstar text-danger">*</sup></label>
                  <div class="input-group mb-3">
                    <input id="password-field" value="{{ env('BBB_SECURITY_SALT') }}" type="password"  name="BBB_SECURITY_SALT" class="form-control" placeholder="enter bigbluebutton salt key">
                    <div class="input-group-prepend text-center">
                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password eye-icon-pass"></span></i></span>
                    </div>
                  </div>
              </div>


              
                    
                  <div class="form-group col-md-6">
                    <label for="exampleInputSlug">{{ __('BBB SERVER BASE URL:') }}<sup
                        class="redstar text-danger">*</sup></label>
                        <input class="form-control" type="text" value="{{ env('BBB_SERVER_BASE_URL') }}" name="BBB_SERVER_BASE_URL" required="" placeholder="enter your BigBlue Button server URL">
                  </div>



              
            </div>
            <div class="form-group">
							<button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
							<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
							{{ __("Update")}}</button>
						</div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection