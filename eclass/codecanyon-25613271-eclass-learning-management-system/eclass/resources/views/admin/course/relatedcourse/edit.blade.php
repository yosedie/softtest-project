
@extends('admin.layouts.master')
@section('title','Edit Related Course')
@section('maincontent')
<?php
$data['heading'] = 'Related Course';
$data['title'] = 'Edit Related Course';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Edit') }} {{ __('Related Course') }}</h5>
          <div>
            <a href="{{ url('course/create/'. $cate->courses->id) }}" class="float-right btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
            </div>
        </div>
        <div class="card-body ml-2">
          <form id="demo-form" method="post" action="{{url('relatedcourse/'.$cate->id)}}"data-parsley-validate class="form-horizontal form-label-left">

            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <input type="hidden" class="form-control " name="user_id" id="user_id" value="{{ $cate->user_id }}"> 

            <div class="row" class="d-none">             
              <div class="col-md-12">  
                <label class="d-none" for="exampleInputSlug">{{ __('Course') }}</label>
                <select class="d-none" name="main_course_id" class="form-control select2">
                    <div class="d-none">
                  <option value="{{ $cate->main_course_id }}">{{ $cate->main_course_id }}</option>
                  </div>
                </select>
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputSlug">{{ __('RelatedCourse') }}</label>
                <select name="course_id" class="form-control select2">
                 @foreach($courses as $cou)
                 <option value="{{ $cou->id }}" {{$cate->course_id == $cou->id  ? 'selected' : ''}}>{{ $cou->title}}</option>
                 @endforeach
                </select>
                <small>{{ __('Edit') }} {{ __('Related Course') }}</small>
              </div>
             
              <div class="col-md-12">
                <label for="exampleInputTit1e">{{ __('Status') }} :</label><br>
                <label class="switch">
                  <input class="slider" type="checkbox" name="status" {{ $cate->status==1 ? 'checked' : '' }} />
                  <span class="knob"></span>
                </label>
              </div>
            </div>
            <br>
            
            <div class="col-md-12">
                <div class="form-group">
                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                    {{ __("Update")}}</button>
                </div>
            </div>
          
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection