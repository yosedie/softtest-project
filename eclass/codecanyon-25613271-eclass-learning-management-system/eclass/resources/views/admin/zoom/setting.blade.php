@extends('admin.layouts.master')
@section('title', 'Zoom Setting')
@section('maincontent')
<?php
$data['heading'] = 'Zoom Settings';
$data['title'] = 'Meetings';
$data['title1'] = 'Zoom Meetings';
$data['title2'] = 'Zoom Settings';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  @if ($errors->any())
  <div class="alert alert-danger" role="alert">
    @foreach($errors->all() as $error)
    <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
        <span aria-hidden="true" style="color:red;">&times;</span></button></p>
    @endforeach
  </div>
  @endif
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Zoom Meetings Settings') }}</h5>
        </div>
        <div class="card-body">

          <form action="{{ route('updateToken') }}" method="POST">
            @csrf

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>{{ __('ZOOM_ACCOUNT_ID') }}:</label>
                  <input id="password-field" value="{{ env('ZOOM_ACCOUNT_ID') }}" type="password" name="ZOOM_ACCOUNT_ID"
                    class="form-control" placeholder="Please Enter ZOOM Login Email ">
                  <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span></i></span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>{{ __('ZOOM_EMAIL') }}:</label>
                  <input id="password-secret" value="{{ env('ZOOM_EMAIL') }}" type="text" name="ZOOM_EMAIL"
                    class="form-control" placeholder="Please Enter zoom email">
                </div>
              </div>
              <div class="form-group col-md-6">
                <label>{{ __('ZOOM_CLIENT_KEY') }}:</label>
                <input id="password-field1" value="{{ env('ZOOM_CLIENT_KEY') }}" type="password" name="ZOOM_CLIENT_KEY"
                  class="form-control" placeholder="Please Enter zoom api key ">
                  <span toggle="#password-field1"
                    class="fa fa-fw fa-eye field-icon toggle-password"></span></i></span>
              </div>
              <div class="form-group col-lg-6">
                <label>{{ __('ZOOM_CLIENT_SECRET') }}:</label>
                <input id="password-field2" value="{{ env('ZOOM_CLIENT_SECRET') }}" type="password"
                  name="ZOOM_CLIENT_SECRET" class="form-control" placeholder="Please Enter zoom api key ">
                  <span toggle="#password-field2"
                    class="fa fa-fw fa-eye field-icon toggle-password"></span></i></span>
              </div>
            </div>

    <div class="form-group">
      <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i>
        {{ __("Reset")}}</button>
      <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update') }}"><i class="fa fa-check-circle"></i>
        {{ __("Update")}}</button>
    </div>

    </form>









  </div>
</div>
</div>
</div>
</div>



@endsection