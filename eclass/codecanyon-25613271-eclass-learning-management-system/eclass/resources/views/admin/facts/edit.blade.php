@extends('admin.layouts.master')
@section('title', 'Edit Fact - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Edit Fact';
$data['title'] = 'Front Settings';
$data['title1'] = 'Facts';
$data['title2'] = 'Edit Fact';
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
          <h5 class="card-title">{{ __('Edit Fact') }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{url('fact')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
          </div>
          </div>
        </div>
        <div class="card-body">
            <form id="demo-form2" method="post" action="{{ route('fact.update',$data->id) }}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputTit1e">{{ __('Fact') }}:<sup
                                        class="redstar text-danger">*</sup></label>
                                <input class="form-control" type="text" name="title" value="{{ $data->title }}"
                                    placeholder="{{ __('Enter Fact') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputSlug"> {{ __('Image') }}:<sup
                                        class="redstar text-danger">*</sup></label><br>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                    </div>
                                    <div class="custom-file">
                                        <input accept="image/*" type="file" name="image" class="custom-file-input" id="inputGroupFile01"
                                            aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label"
                                            for="inputGroupFile01">{{ __('Choose File') }}</label>
                                    </div>
                                </div>
                                @if($data->image != null || $data->image !='')
                                <div class="edit-user-img">
                                  <img src="{{ url('/images/facts/'.$data->image) }}"  alt="{ __('Fact Image') }}" class="img-responsive image_size">
                                </div>
                                @else
                                <div class="edit-user-img">
                                  <img src="{{ asset('images/fact/'.$data->tittle)}}"  alt="{ __('Fact Image') }}" class="img-responsive img-circle">
                                </div>
                                @endif
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="exampleInputSlug">{{ __('Number') }}:<sup
                                  class="redstar text-danger">*</sup></label>
                                <input type="number" name="number"  value="{{ $data->number }}" class="form-control" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-dark"
                                    for="exampleInputDetails">{{ __('Descriptions') }}:<sup
                                    class="redstar text-danger">*</sup></label>
                                <input name="description" value="{{ $data->description }}" rows="1" class="form-control"
                                    placeholder="{{ __('Please Enter Descriptions') }}">
                            </div>                            
                            <div class="form-group col-md-2">
                              <label class="text-dark" for="exampleInputDetails">{{ __('Status') }} :</label><br>
                              <input type="checkbox" class="custom_toggle" name="status" {{ $data->status == '1' ? 'checked' : '' }} />                              
                          </div>
                            <div class="form-group col-md-12">
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
