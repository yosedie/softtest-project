@extends('admin.layouts.master')
@section('title', 'Edit Language Translation - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Edit Language Translation';
$data['title'] = 'Site Setting';
$data['title1'] = 'Language Translation';
$data['title1'] = 'Edit Language Translation';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  <div class="row">
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      @foreach($errors->all() as $error)
      <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close')}}">
          <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach
    </div>
    @endif
    <!-- row started -->
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <!-- Card header will display you the heading -->
        <div class="card-header">
          <h5 class="card-box">{{ __('Edit Language Translation') }}</h5>
        </div>
        <div class="widgetbar">
          <a href="{{url('change/words')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
        </div>
        <!-- card body started -->
        <div class="card-body">
          <form action="{{ action('ChangewordController@update') }}" method="POST" enctype="multipart/form-data">
            @csrf
          <input type="hidden" name="langcode" value="{{  $langCode }}">
          <textarea name="content" cols="30" rows="15" class="form-control">{{ $jsonContents}}</textarea>
          <div class="row mt-4">
            <div class="col-lg-12 col-md-12">
              <div class="form-group">
                <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update')}}"><i class="fa fa-check-circle"></i>
                  {{ __("Update")}}</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection