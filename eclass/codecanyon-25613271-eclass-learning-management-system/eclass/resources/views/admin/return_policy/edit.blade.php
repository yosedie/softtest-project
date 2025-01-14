@extends('admin.layouts.master')
@section('title','Edit Refund Policy')
@section('maincontent')
<?php
$data['heading'] = 'Edit Refund Policy';
$data['title'] = 'Courses';
$data['title1'] = 'Refund Policies';
$data['title2'] = 'Edit Refund Policies';
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
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('Edit Refund Policy') }}</h5>
          <div>
            <div class="widgetbar">
            <a href="{{ url('refundpolicy')}}" class="btn btn-primary-rgba" title="{{ __('Back') }}"><i
                class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
            </div>
          </div>
        </div>
        <div class="card-body ml-2">
          <form id="demo-form2" method="post" action="{{url('refundpolicy/'.$return->id)}}" data-parsley-validate
            class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{method_field('PATCH')}}

            <div class="row">
              <div class="col-md-4">
                <label for="exampleInputName">{{ __('Policy Name') }}:<sup class="redstar">*</sup></label>
                <input type="text" class="form-control" name="name" id="exampleInputTitle" value="{{$return->name}}" placeholder=" Please Enter Policy Name">
              </div>
              <div class="col-md-2">
                <label for="exampleInputSlug">{{ __('Days') }}:<sup class="redstar">*</sup></label>
                <input type="text" class="form-control" name="days" id="exampleInputPassword1"
                  value="{{$return->days}}" placeholder=" Please Enter Return Days">
               
              </div>
              <br>
              <br>
              <br>
                          
              <div class="col-md-12 mt-3">
                <label for="exampleInputDetails">{{ __('Details') }}:<sup class="redstar">*</sup></label>
                <textarea name="detail" rows="5" class="form-control">{{$return->detail}}</textarea>
              </div>
           
            <br>
            <div class="col-md-6 mt-3">
              <label for="exampleInputTit1e">{{ __('Status') }}:</label>
              <input id="cb10" type="checkbox" class="custom_toggle" name="status"
                {{ $return->status==1 ? 'checked' : '' }} />           
              
            </div>
          

            <div class="col-md-12 mt-3">
             
                <button type="reset" class="btn btn-danger-rgba" title="{{ __('Reset') }}"><i class="fa fa-ban"></i>
                  {{ __('Reset') }}</button>
                <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update') }}"><i class="fa fa-check-circle"></i>
                  {{ __('Update') }}</button>
              </div>
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
  tinymce.init({
    selector: '#editor1,#editor2,.editor',
    height: 350,
    menubar: 'edit view insert format tools table tc',
    autosave_ask_before_unload: true,
    autosave_interval: "30s",
    autosave_prefix: "{path}{query}-{id}-",
    autosave_restore_when_empty: false,
    autosave_retention: "2m",
    image_advtab: true,
    plugins: [
      'advlist autolink lists link image charmap print preview anchor',
      'searchreplace visualblocks fullscreen',
      'insertdatetime media table paste wordcount'
    ],
    toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media  template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
    content_css: '//www.tiny.cloud/css/codepen.min.css'
  });
</script>
@endsection