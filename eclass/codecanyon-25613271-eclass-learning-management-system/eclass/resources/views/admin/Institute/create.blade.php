@extends('admin.layouts.master')
@section('title', 'Add Institute - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Create Institute';
$data['title'] = 'Institutes';
$data['title1'] = 'Create Institute';
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
          <h5 class="card-title">{{ __('Add Institute') }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{url('institute')}}" class="btn btn-primary-rgba" title="{{ __('Back') }}"><i
                  class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
          </div>
          </div>
        </div>
        <div class="card-body">
           <form id="demo-form2" method="post" action="{{ route('institute.save') }}" data-parsley-validate
            class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="row">
              <div class="form-group col-md-3">
                <label for="exampleInputTit1e">{{ __('Institute Name') }}:<sup
                    class="redstar text-danger">*</sup></label>
                <input class="form-control" type="text" name="title" id="title" placeholder="{{ __('Enter Institute Name') }}">

              </div>
              <div class="form-group col-md-3">
                <label class="text-dark" for="slug">{{ __('Slug') }}: <sup
                    class="text-danger">*</sup></label>
                <input value="{{ old('slug')}}" id="slug" name="slug"
                  placeholder="{{ __('Please') }} {{ __('Enter') }} {{ __('Slug') }}"
                  class="form-control">
              </div>
              <div class="form-group col-md-3">
                <label for="exampleInputSlug"> {{ __('Logo') }}:<sup class="redstar text-danger">*</sup></label><br>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                  </div>
                  <div class="custom-file">
                    <input type="file" name="image" class="custom-file-input" id="inputGroupFile01"
                      aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose File') }}</label>
                  </div>
                </div>
              </div>              
              <div class="form-group col-md-3">
                <label class="text-dark" for="mobile">{{ __('Email') }}: <sup
                    class="text-danger">*</sup></label>
                <input value="{{ old('email')}}" required type="email" name="email"
                  placeholder=" {{ __('Please') }} {{ __('Enter Email') }}"
                  class="form-control">
              </div>
              <div class="form-group col-md-3">
                <label class="text-dark" for="mobile">{{ __('Mobile') }}: <sup
                    class="text-danger">*</sup></label>
                <input value="{{ old('mobile')}}" required type="number" name="mobile"
                  placeholder="{{ __('Please Enter Mobile') }}"
                  class="form-control">
              </div>
             <div class="form-group col-md-6">
                <label class="text-dark" for="exampleInputDetails">{{ __('Address') }}:</label>
                <textarea name="address" rows="1" class="form-control"
                  placeholder="{{ __('Please Enter Address') }} "></textarea>
              </div>             

           
              <div class="col-md-2 form-group">
                <label for="exampleInputSlug">{{ __('Affiliated By') }}:</label>
                <input type="text" name="affilated_by"  class="form-control"
                  data-role="tagsinput" />
              </div>
              <div class="col-md-4 form-group">
                <label for="exampleInputSlug">{{ __('Skills') }}:<sup class="redstar text-danger">*</sup></label>
                <input type="text" name="skill" id="tagsinput-default" class="form-control"  data-role="tagsinput" />
              </div>  
              
             
                 <div class="form-group col-md-6">
                <label for="exampleInputSlug">{{ __('About') }}:<sup class="redstar text-danger">*</sup></label>
                <textarea name="detail" rows="1" class="form-control"></textarea>
              </div>
              <div class="form-group col-md-12">
                <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i>
                  {{ __("Reset")}}</button>
                <button type="submit" class="btn btn-primary-rgba" title="{{ __('Create') }}"><i class="fa fa-check-circle"></i>
                  {{ __("Create")}}</button>
              </div>
             </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection