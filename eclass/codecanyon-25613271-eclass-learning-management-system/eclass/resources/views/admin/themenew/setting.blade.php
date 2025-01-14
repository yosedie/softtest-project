@extends('admin.layouts.master')
@section('title', 'Select Theme - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Select Theme';
$data['title'] = 'Front Settings';
$data['title1'] = 'Select Theme';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      @foreach($errors->all() as $error)
      <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close')}}">
          <span aria-hidden="true" class="text-danger" >&times;</span></button></p>
      @endforeach
    </div>
    @endif
    <div class="row">
    <div class="col-lg-12">
        <div class="card dashboard-card m-b-30">
            <div class="card-header">
                <h5 class="card-title">{{ __('Select Theme') }}</h5>
            </div>
            <div class="card-body">
                <form class="form" action="{{ route('themenew.update') }}" method="POST" novalidate
                    enctype="multipart/form-data">
                    @csrf
                    <div class ="row">
                        <div class="col-lg-6">
                            <div class="shadow-sm border theme-card">
                                <div class="theme-img">
                                    <img src="{{ url('images/theme/1.png') }}" class="img-fluid" alt="{{ __('theme-img')}}">
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="theme" {{ $setting->theme == 1 ? 'checked' : '' }} id="exampleRadios1" value="1" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Theme One
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="shadow-sm border theme-card">
                                <div class="theme-img">
                                    <img src="{{ url('images/theme/3.png') }}" class="img-fluid" alt="{{ __('theme-img')}}">
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="theme" {{ $setting->theme == 0 ? 'checked' : '' }} id="exampleRadios2" value="0">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Theme Two
                                    </label>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="form-group">
                        <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i>
                            {{ __("Reset")}}</button>
                        <button type="submit" class="btn btn-primary-rgba" title="{{ __('Save')}}"><i class="fa fa-check-circle"></i>
                            {{ __("Save")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection