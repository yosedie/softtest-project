@extends('admin.layouts.master')
@section('title', 'Create Fact - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Create Fact';
$data['title'] = 'Front Settings';
$data['title1'] = 'Facts';
$data['title2'] = 'Create Fact';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)
        <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close')}}">
                <span aria-hidden="true" style="color:red;">&times;</span></button></p>
        @endforeach
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Add Facts') }}</h5>
                    <div>
                        <div class="widgetbar">
                            <a href="{{url('fact')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                                </div>
                                </div>
                </div>
                <div class="card-body">
                    <form action="{{route('fact.store')}}" class="form" method="POST" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputTit1e">{{ __('Fact') }}:<sup
                                        class="redstar text-danger">*</sup></label>
                                <input class="form-control" type="text" name="title"
                                    placeholder="{{ __('Enter Fact') }}">

                            </div>
                            <div class="form-group col-md-4">
                                <label class="text-dark" for="exampleInputSlug">{{ __('Image') }}:<sup
                                    class="redstar text-danger">*</sup>
                                </label>
                                <div class="input-group mb-3">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                    </div>
                                    <div class="custom-file">
                                        <input accept="image/*" type="file" name="image" class="custom-file-input" id="image"
                                            aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose File') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="exampleInputSlug">{{ __('Number') }}:<sup
                                    class="redstar text-danger">*</sup></label>
                                <input type="number" name="number" class="form-control" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-dark"
                                    for="exampleInputDetails">{{ __('Descriptions') }}:<sup
                                    class="redstar text-danger">*</sup></label>
                                <textarea name="description" rows="1" class="form-control"
                                    placeholder="{{ __('Please Enter descriptions') }} "></textarea>
                            </div>                            
                            <div class="form-group col-md-2">
                                <label class="text-dark" for="exampleInputDetails">{{ __('Status') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" name="status" checked />
                            </div>
                            <div class="form-group col-md-12">
                                <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i>
                                    {{ __("Reset")}}</button>
                                <button type="submit" class="btn btn-primary-rgba" title="{{ __('Create')}}"><i class="fa fa-check-circle"></i>
                                    {{ __("Create")}}</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
