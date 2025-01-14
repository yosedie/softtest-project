@extends('admin.layouts.master')
@section('title', 'Admin Customizations - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Admin Customizations';
$data['title'] = 'Site Setting';
$data['title1'] = 'Admin Customizations';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
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
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Admin Customizations') }}</h5>
                </div>
                <!-- card body started -->
                <div class="card-body">
                    <!-- form start -->
                    <form action="{{url('admincustomisation/update')}}" method="POST" enctype="multipart/form-data">
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
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="text-dark" for="bg_grey_color">{{ __('Background Grey Color') }}:</label>
                                                            <input name="bg_grey_color" class="form-control" type="color"
                                                                value="{{ optional($color)['bg_grey_color'] }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="text-dark" for="bg_white_color">{{ __('Background White color') }}:</label>
                                                            <input name="bg_white_color" class="form-control" type="color"
                                                                value="{{ optional($color)['bg_white_color'] }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="text-dark" for="text-grey-color">{{ __('Text Grey Color') }}:</label>
                                                            <input name="text-grey-color" class="form-control" type="color"
                                                                value="{{ optional($color)['text-grey-color'] }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="text-dark" for="text_dark_color">{{ __('Text Dark Color') }}:</label>
                                                            <input name="text_dark_color" class="form-control" type="color"
                                                                value="{{ optional($color)['text_dark_color'] }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="text-dark" for="text_white_color">{{ __('Text White Color') }}:</label>
                                                            <input name="text_white_color" class="form-control" type="color"
                                                                value="{{ optional($color)['text_white_color'] }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="text-dark" for="text_blue_color">{{ __('Text Blue Color') }}:</label>
                                                            <input name="text_blue_color" class="form-control" type="color"
                                                                value="{{ optional($color)['text_blue_color'] }}" />
                                                        </div>
                                                    </div>
                                                </div><!-- card body end -->
                                                <div class="col-md-12">
                                                    <a href="{{ route('admincustomisation.reset') }}" type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</a>
                                                    <button type="submit" class="btn btn-primary-rgba" title="{{ __('Save')}}"><i class="fa fa-check-circle"></i>
                                                        {{ __("Save")}}</button>
                                                </div>
                                            </div><!-- card end -->
                                        </div><!-- col end -->
                                    </div><!-- row end -->
                    </form>
                    <!-- form end -->
                </div><!-- card body end -->

            </div><!-- col end -->
        </div>
       
    </div>
    </div>
</div><!-- row end -->
<br><br>
@endsection
<!-- main content section ended -->