@extends('admin.layouts.master')
@section('title', 'Edit Institute - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Edit Institute';
$data['title'] = 'Institutes';
$data['title1'] = 'Edit Institute';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  @if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Edit Institute') }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{url('institute')}}" class="btn btn-primary-rgba" title="{{ __('Back') }}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
          
            </div>
          </div>
        </div>
        <div class="card-body">
          
          <form id="demo-form2" method="post" action="{{ route('institute.update',['id' => $data->id]) }}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}
          
          <div class="row">
            <div class="form-group col-md-3">
              <label for="exampleInputTit1e">{{ __('Institute Name') }}:<sup class="redstar text-danger">*</sup></label>
              <input class="form-control" type="text" name="title" id="title" value="{{ filter_var($data->title) }}" placeholder="{{ __('Enter Institute Name') }}">
              
            </div>
            <div class="form-group col-md-3">
                <label class="text-dark" for="slug">{{ __('Slug') }}: <sup
                    class="text-danger">*</sup></label>
                <input value="{{$data->slug}}"  name="slug" id="slug"
                  placeholder="{{ __('Please Enter Slug') }}"
                  class="form-control">
              </div>

            <div class="form-group col-md-3">
                <label for="exampleInputSlug"> {{ __('Logo') }}:</label><br>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                  </div>
                  <div class="custom-file">
                    <input type="file" name="image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                  </div>
                </div>
              </div>
             
              <div class="form-group col-md-3">
                <label class="text-dark" for="mobile">{{ __('Email') }}: <sup
                    class="text-danger">*</sup></label>
                <input value="{{$data->email}}" required type="email" name="email"
                  placeholder=" {{ __('Please') }} {{ __('Enter') }} {{ __('Email') }}"
                  class="form-control">
              </div>
              <div class="form-group col-md-3">
                <label class="text-dark" for="mobile">{{ __('Mobile') }}: <sup
                    class="text-danger">*</sup></label>
                <input value="{{$data->mobile}}" required type="number" name="mobile"
                  placeholder="{{ __('Please Enter Mobile') }}"
                  class="form-control">
              </div>
              <div class="form-group col-md-6">
                <label class="text-dark" for="exampleInputDetails">{{ __('Address') }}: </label>
                <input name="address" value="{{$data->address}}" required rows="1" class="form-control"
                  placeholder="{{ __('Please Enter Address') }}"></input>
              </div>
              <div class="col-md-3 form-group">
              <label for="exampleInputSlug">{{ __('Affiliated By') }}:</label>
              <input type="text" name="affilated_by" value="{{ $data->affilated_by }}"  class="form-control"
                data-role="tagsinput" />
            </div>
             <div class="col-md-4 form-group">
                <label for="exampleInputSlug">{{ __('Skills') }}:<sup class="redstar text-danger">*</sup></label>
                <input type="text" name="skill" value="{{ $data->skill}}" id="tagsinput-default" class="form-control"  value="{{ $data->skill }}" data-role="tagsinput" />
            </div> 
            <div class="form-group col-md-6">
              <label for="exampleInputSlug">{{ __('About') }}:<sup class="redstar text-danger">*</sup></label>
              <textarea name="detail" value="{{ $data->detail }}" rows="5" class="form-control">{{ filter_var($data->detail) }}</textarea>
            </div>            
            
             <div class="form-group col-md-12">
            <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
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


