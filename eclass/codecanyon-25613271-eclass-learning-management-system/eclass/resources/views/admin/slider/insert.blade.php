@extends('admin.layouts.master')
@section('title', 'Create Slider - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Create Slider';
$data['title'] = 'Front Settings';
$data['title'] = 'Slider';
$data['title2'] = 'Create Slider';
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
          <h5 class="card-title">{{ __('Add Slider') }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{url('slider')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>          
            </div>
          </div>
        </div>
        <div class="card-body">          
          <form id="demo-form2" method="post" action="{{url('slider/')}}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}          
          <div class="row">
            <div class="form-group col-md-3">
              <label for="exampleInputTit1e">{{ __('Heading') }}:<sup class="redstar text-danger">*</sup></label>
              <input class="form-control" type="text" name="heading" placeholder="{{ __('Enter Heading') }}">
            </div>
            <div class="form-group col-md-3">
              <label for="exampleInputSlug">{{ __('Sub Heading') }}:<sup class="redstar text-danger">*</sup></label>
                  <input type="slug" class="form-control" name="sub_heading" id="exampleInputPassword1" placeholder="{{ __('Enter Sub Heading') }}">
            </div>
            <div class="d-none">
              <label for="exampleInputTit1e d-none">{{ __('Search Text') }}:<sup class="redstar text-danger">*</sup></label>
              <input type="text" class="form-control display-none" name="search_text" id="exampleInputTitle" value="0">
            </div>
            @if(Auth::user()->role == 'instructor')
            <div class="form-group col-md-3">
              <label for="exampleInputSlug"> {{ __('Image') }}:<sup class="redstar text-danger">*</sup></label><br>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload')}}</span>
                </div>
                <div class="custom-file">
                  <input  type="file" name="image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose File')}}</label>
                </div>
              </div>
            </div>
            @endif
            @if(Auth::user()->role == 'admin')
            <div class="col-md-3">
                <label class="text-dark">{{ __('Image') }}:<sup class="redstar text-danger">*</sup></label><br>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" readonly id="image" name="image">
                    <div class="input-group-append">
                      <span data-input="image" class="midia-toggle btn-primary  input-group-text" id="basic-addon2">{{__('Browse')}}</span>
                    </div>
                </div>
            </div>
            @endif  
            <div class="form-group col-md-12">
              <label for="exampleInputDetails">{{ __('Details') }}:<sup class="redstar text-danger">*</sup></label>
              <textarea name="detail" rows="3" class="form-control" placeholder="{{ __('Enter Details') }}"></textarea>
            </div>                        
            <div class="form-group col-md-2">
              <label for="exampleInputDetails">{{ __('Status') }}:</label><br>
              <input type="checkbox" class="custom_toggle" name="status"   checked />
              <input type="hidden"  name="free" value="0" for="status" id="status">
            </div>
            <div class="form-group col-md-2">
              <label for="exampleInputDetails">{{ __('Text Position') }}:</label><br>
              <input id="pay" class="custom_toggle"  type="checkbox" name="left"  checked />             
              <input type="hidden"  name="free" value="0" for="left" id="left">          
            </div>
            <div class="form-group col-md-2">
              <label for="exampleInputDetails">{{ __(' Enable Search on Slider') }}:</label><br>
              <input  type="checkbox" name="search_enable"  class="custom_toggle"  checked />
              <input type="hidden"  name="free" value="0" for="search_enable" id="search_enable">            
            </div>
          </div>
          <div class="form-group">
            <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
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
@section('script')
<script>
    $(".midia-toggle").midia({
        base_url: '{{url('')}}',
        title : 'Choose Slider Image',
    dropzone : {
      acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif'
    },
        directory_name : 'slider'
    });
</script>
@endsection


