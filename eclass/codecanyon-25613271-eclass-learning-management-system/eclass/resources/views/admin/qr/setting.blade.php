@extends('admin.layouts.master')
@section('title', 'QR Code Settings')
@section('maincontent')
<?php
$data['heading'] = 'QR Code Settings';
$data['title'] = 'QR Code Settings';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      @foreach($errors->all() as $error)
      <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
          <span aria-hidden="true" class="text-danger">&times;</span></button></p>
      @endforeach
    </div>
    @endif
    <div class="row">
    <div class="col-lg-12">
        <div class="card dashboard-card m-b-30">
            <div class="card-header">
                <h5 class="card-title">{{ __('QR Code Settings') }}</h5>
            </div>
            <div class="card-body">
                <form class="form" action="{{ route('mobileqr.update') }}" method="POST" novalidate
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row m-b-20">
                        <div class="col-lg-12">
                            <div class="alert alert-primary">
                                <i class="feather icon-alert-circle"></i> {{__('Qr Setting is used for landing page. ')}}
                            </div>
                        </div>
                    </div>
                    <div class="row m-b-20">
                        <div class="form-group col-md-4">
                            <label class="text-dark" for="exampleInputSlug">{{ __('Users APP QR') }}:
                            </label>
                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                        id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                </div>
                                <div class="custom-file">

                                    <input accept="image/*" type="file" name="image" class="custom-file-input" id="img"
                                        aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label"
                                        for="inputGroupFile01">{{ __('Choose file') }}</label>
                                </div>
                            </div>
                            <img src="{{ url('/images/qr/'.$qrsetting->image) }}" height="100px;" width="100px;" />
                        </div>
                        <div class="form-group col-md-4">
                            <label class="text-dark" for="exampleInputSlug">{{ __('Instructors APP QR') }}:
                            </label>
                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                        id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                </div>
                                <div class="custom-file">

                                    <input type="file" name="image2" class="custom-file-input" id="img2"
                                        aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label"
                                        for="inputGroupFile01">{{ __('Choose file') }}</label>
                                </div>
                            </div>
                            <img src="{{ url('/images/qr/'.$qrsetting->image2) }}" height="100px;" width="100px;" />
                        </div>
                        <div class="form-group col-md-4">
                            <label class="text-dark" for="exampleInputSlug">{{ __('Demo Image') }}:
                            </label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                        id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="demo_image" class="custom-file-input" id="demo"
                                        aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label"
                                        for="inputGroupFile01">{{ __('Choose file') }}</label>
                                </div>
                            </div>
                            <img src="{{ url('/images/qr/'.$qrsetting->demo_image) }}" height="100px;" width="100px;" />
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