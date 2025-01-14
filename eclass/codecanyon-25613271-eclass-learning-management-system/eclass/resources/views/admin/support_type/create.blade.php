@extends('admin.layouts.master')
@section('title', 'Support Type')
@section('maincontent')
<?php
$data['heading'] = 'Support Type';
$data['title'] = 'Support Type';
$data['title1'] = 'Create';

?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    <div class="row">
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $error)
            <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close"
                    title="{{ __('Close') }}">
                    <span aria-hidden="true" style="color:red;">&times;</span></button></p>
            @endforeach
        </div>
        @endif
        <!-- row started -->
        <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box"> {{ __('Add Support Type') }}</h5>
                    <div>
                        <div class="widgetbar">
                            <a href="{{route('supporttype.show')}}" class="btn btn-primary-rgba" title="{{ __('Back') }}"><i
                                    class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                        </div>
                    </div>
                </div>
                <!-- card body started -->
                <div class="card-body">
                    <!-- form start -->
                    <form action="{{ route('supporttype.store') }}" class="form" method="POST" novalidate enctype="multipart/form-data">
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

                                                    <!-- Title -->
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Name') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" value="{{ old('title') }}" autofocus=""
                                                                class="form-control @error('title') is-invalid @enderror"
                                                                placeholder="{{ __('Enter Name') }}" name="name"
                                                                required="">
                                                            @error('title')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- create and close button -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="reset" class="btn btn-danger-rgba mr-1"
                                                                title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{
                                                                __("Reset")}}</button>
                                                            <button type="submit" class="btn btn-primary-rgba"
                                                                title="{{ __('Create') }}"><i
                                                                    class="fa fa-check-circle"></i>
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
@endsection