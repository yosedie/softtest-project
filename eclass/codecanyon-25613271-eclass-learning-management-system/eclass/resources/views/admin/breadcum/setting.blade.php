@extends('admin.layouts.master')
@section('title', 'Breadcrumb - Setting')
@section('maincontent')
<?php
$data['heading'] = 'Breadcrumb';
$data['title'] = 'Front Settings';
$data['title1'] = 'Breadcrumb';
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
                    <h5 class="card-title">{{ __('Breadcrumb') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form" action="{{ route('breadcum.update') }}" method="POST" novalidate
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="text-dark" for="exampleInputSlug">{{ __('Image') }}:
                                </label>
                                <div class="input-group mb-3">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                    </div>
                                    <div class="custom-file">

                                        <input accept="image/*" type="file" name="img" class="custom-file-input" id="img"
                                            aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label"
                                            for="inputGroupFile01">{{ __('Choose File') }}</label>
                                    </div>
                                </div>
                                @if($setting['img'] !== NULL && $setting['img'] !== '')
                                <img src="{{ url('/images/breadcum/'.$setting->img) }}" height="100px;" width="100px;" />
                                @else
                                <img src="{{ Avatar::create($setting->text)->toBase64() }}" alt="course"
                                    class="img-fluid">
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label class="text-dark">{{ __('Breadcrumb Text') }}:</label>
                                <input name="text" value="{{ $setting->text }}" autofocus="" type="text"
                                    class="{{ $errors->has('text') ? ' is-invalid' : '' }} form-control"
                                    placeholder="{{ __('Enter Breadcrumb Text')}}" required="">
                                <div class="invalid-feedback">
                                    {{ __('Please enter text!') }}.
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