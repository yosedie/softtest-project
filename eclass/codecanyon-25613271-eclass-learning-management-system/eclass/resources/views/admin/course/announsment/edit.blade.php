@extends('admin.layouts.master')
@section('title','Edit Announcement')
@section('maincontent')
<?php
$data['heading'] = 'Admin';
$data['title'] = 'Edit Announcement';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar bardashboard-card">
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
          <h5 class="box-title">{{ __('Edit') }} {{ __('Announcement') }}</h5>
          <div class="widgetbar">
            <a href="{{ url('course/create/'. $annou->courses->id) }}" class="float-right btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
            </div>
        </div>
        <div class="card-body ml-2">
          <form id="demo-form" method="post" action="{{url('announsment/'.$annou->id)}}" data-parsley-validate class="form-horizontal form-label-left">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

           
            <select class="d-none" name="course_id">
              @foreach($courses as $cou)
                <option class="d-none" value="{{ $cou->id }}" {{$annou->courses->id == $cou->id  ? 'selected' : ''}}>{{ $cou->title}}</option>
              @endforeach
            </select>

            <label class="d-none" for="exampleInputSlug">{{ __('User') }}</label>
            <select  name="user" class="form-control col-md-7 col-xs-12 display-none">
              @foreach($user as $cu)
                <option class="d-none" value="{{ $cu->id }}" {{$annou->user->id == $cu->id  ? 'selected' : ''}}>{{ $cu->fname}}</option>
              @endforeach
            </select>
               
            <div class="row">
              <div class="col-md-9">
                <label for="exampleInputDetails">{{ __('Announcement') }}:<sup class="redstar">*</sup></label>
                <textarea name="announsment" id="editor4" rows="3" class="form-control" >{{$annou->announsment}}</textarea>

              </div>
              <div class="col-md-3">
                <label for="exampleInputTit1e">{{ __('Status') }}:</label>
                <input type="checkbox" class="custom_toggle" name="status" id="status"
                {{ $annou->status == '1' ? 'checked' : '' }} />   
                    
                    <label class="tgl-btn" data-tg-off="Disable" data-tg-on="Enable" for="status"></label>
               
                <input type="hidden"  name="free" value="0" for="status" id="status">
              </div>
            </div>
            <br>
         

            <div class="form-group">
              <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
                {{ __('Reset') }}</button>
              <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                {{ __('Update') }}</button>
            </div>

            <div class="clear-both"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

