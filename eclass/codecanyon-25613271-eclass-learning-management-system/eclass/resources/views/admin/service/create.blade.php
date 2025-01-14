@extends('admin.layouts.master')
@section('title', 'Create Service - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Create Service';
$data['title'] = 'Front Settings';
$data['title1'] = 'Services';
$data['title2'] = 'Create Service';
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
                    <h5 class="card-box"> {{ __('Add Service') }}</h5>
                    <div>
                        <div class="widgetbar">
                            <a href="{{url('service')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                        </div>
                    </div>
                </div>
                <!-- card body started -->
                <div class="card-body">
                    <!-- form start -->
                    <form action="{{action('ServicesController@store')}}" class="form" method="POST" novalidate
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="user_id" value="{{ Auth::User()->id }}">
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
                                                    <!-- Heading -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Service') }} : <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" value="{{ old('title') }}" autofocus=""
                                                                class="form-control @error('title') is-invalid @enderror"
                                                                placeholder="{{ __('Enter Service Title') }}"
                                                                name="title" required="">
                                                            @error('heading')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <!-- image -->
                                                    <div class="col-md-4">
                                                        <label class="text-dark">{{ __('Image') }}:<span
                                                                class="text-danger">*</span></label><br>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"
                                                                    id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                                            </div>
                                                            <div class="custom-file">
                                                                <input accept="image/*" type="file" class="custom-file-input"
                                                                    name="image" id="inputGroupFile01"
                                                                    aria-describedby="inputGroupFileAddon01" required>
                                                                <label class="custom-file-label"
                                                                    for="inputGroupFile01">{{ __('Choose File') }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Description -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Details') }}: <span
                                                                    class="text-danger">*</span></label>
                                                            <textarea id="detail" name="detail"
                                                                class="@error('detail') is-invalid @enderror"
                                                                placeholder="{{ __('Enter Details') }}"
                                                                required="">{{ old('detail') }}</textarea>
                                                            @error('detail')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <!-- status -->
                                                    <div class="form-group col-md-3">
                                                        <label class="text-dark"
                                                            for="exampleInputDetails">{{ __('Status') }}
                                                            :</label><br>
                                                        <input type="checkbox" class="custom_toggle" name="status"
                                                            checked />
                                                        <input type="hidden" name="free" value="0" for="status"
                                                            id="status">
                                                    </div>
                                                        <!-- create and close button -->
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <button type="reset" class="btn btn-danger-rgba mr-1"><i
                                                                        class="fa fa-ban" title="{{ __('Reset')}}"></i> {{ __("Reset")}}</button>
                                                                <button type="submit" class="btn btn-primary-rgba"><i
                                                                        class="fa fa-check-circle" title="{{ __('Create')}}"></i>
                                                                    {{ __("Create")}}</button>
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
                </div><!-- card body end -->
            </div><!-- col end -->
        </div>
    </div>
</div><!-- row end -->
<br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain javacsript start -->
<!-- This section will contain javacsript end -->
