@extends('admin.layouts.master')
@section('title', 'Video Section - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Video Section';
$data['title'] = 'Front Settings';
$data['title1'] = 'Video Section';
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
                <h5 class="card-title">{{ __('Video Section') }}</h5>
            </div>
            <div class="card-body">
                <form class="form" action="{{ route('videosetting.update') }}" method="POST" novalidate
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="text-dark">{{ __('URL') }}:</label>
                            <input name="url" value="{{ $videosetting->url }}" autofocus="" type="url"
                                class="{{ $errors->has('url') ? ' is-invalid' : '' }} form-control"
                                placeholder="{{ __('Enter URL')}}" required="">
                            <div class="invalid-feedback">
                                {{ __('Please enter URL!') }}.
                            </div>
                            <small class="text-info"><i class="fa fa-question-circle"></i> {{__('Only work with YouTube embedded URL.</')}}</small>
                        </div> 
                        <div class="form-group col-md-4">
                            <label class="text-dark">{{ __('Tittle') }}:</label>
                            <input name="tittle" value="{{ $videosetting->tittle }}" autofocus="" type="text"
                                class="{{ $errors->has('text') ? ' is-invalid' : '' }} form-control"
                                placeholder="Enter Tittle" required="">
                            <div class="invalid-feedback">
                                {{ __('Please enter tittle!') }}.
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-dark">{{ __('Descriptions') }}:</label>
                            <input name="description" value="{{ $videosetting->description }}" autofocus="" type="text"
                                class="{{ $errors->has('description') ? ' is-invalid' : '' }} form-control"
                                placeholder="{{ __('Enter descriptions')}}" required="">
                            <div class="invalid-feedback">
                                {{ __('Please enter description!') }}.
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="text-dark" for="exampleInputSlug">{{ __('Image') }}:
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
                                        for="inputGroupFile01">{{ __('Choose File') }}</label>
                                </div>
                            </div>
                            @if($videosetting['image'] !== NULL && $videosetting['image'] !== '')
                            <img src="{{ url('/images/videosetting/'.$videosetting->image) }}" height="100px;" width="100px;" />
                            @else
                            <img src="{{ Avatar::create($videosetting->tittle)->toBase64() }}" alt="course"
                                class="img-fluid">
                            @endif
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