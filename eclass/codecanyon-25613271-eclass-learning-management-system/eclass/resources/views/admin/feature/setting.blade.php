@extends('admin.layouts.master')
@section('title', 'Feature Settings - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Feature Settings';
$data['title'] = 'Front Settings';
$data['title1'] = 'Feature Settings';
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
                <h5 class="card-title">{{ __('Feature Settings') }}</h5>
            </div>
            <div class="card-body">
                <form class="form" action="{{ route('featuresetting.update') }}" method="POST" novalidate
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="text-dark">{{ __('Tittle') }}:</label>
                            <input name="title" value="{{$feasetting->title}}" autofocus="" type="text"
                                class="{{ $errors->has('text') ? ' is-invalid' : '' }} form-control"
                                placeholder="{{ __('Enter Tittle')}}" required="">
                            <div class="invalid-feedback">
                                {{ __('Please enter tittle!') }}.
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="text-dark">{{ __('Descriptions') }}:</label>
                            <input name="detail" value="{{$feasetting->detail}}" autofocus="" type="text"
                                class="{{ $errors->has('detail') ? ' is-invalid' : '' }} form-control"
                                placeholder="{{ __('Enter Descriptions')}}" required="">
                            <div class="invalid-feedback">
                                {{ __('Please enter descriptions!') }}.
                            </div>
                        </div>
                        <div class="form-group col-md-4">
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
                            @if($feasetting['image'] !== NULL && $feasetting['image'] !== '')
                            <img src="{{ url('/images/feature/'.$feasetting->image) }}" height="100px;" width="100px;" />
                            @else
                            <img src="{{ Avatar::create($feasetting->tittle)->toBase64() }}" alt="{{ __('Image')}}"
                                class="img-fluid">
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i>
                            {{ __("Reset")}}</button>
                        <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update')}}"><i class="fa fa-check-circle"></i>
                            {{ __("Update")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
