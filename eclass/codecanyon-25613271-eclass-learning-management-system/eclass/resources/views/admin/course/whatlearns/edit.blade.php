@extends('admin.layouts.master')
@section('title','Edit What-learn')
@section('maincontent')
<?php
$data['heading'] = 'What-learn';
$data['title'] = 'What-learn';
$data['title1'] = 'Edit What-learn';
?>
@include('admin.layouts.topbar',$data)
@if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif 
<div class="contentbar dashboard-card">
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Edit') }} {{ __('What Learn') }}</h5>
          <div class="widgetbar">
            <a href="{{ url('course/create/'. $cate->courses->id) }}" class="float-right btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
            </div>
        </div>
        <div class="card-body ml-2">
          <form id="demo-form" method="post" action="{{url('whatlearns/'.$cate->id)}}" data-parsley-validate class="form-horizontal form-label-left">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="col-md-12">
                              <div class="d-none">

           <label class="d-none" for="exampleInputSlug">{{ __('SelectCourse') }}</label>
            <select  name="course_id" class="form-control select2 d-none">
    
              @foreach($courses as $cou)
                <option class="display-none" value="{{ $cou->id }}"{{$cate->courses->id == $cou->id  ? 'selected' : ''}}>{{ $cou->title}}</option>
              @endforeach
            </select>
            </div>
           </div>
              <div class="col-md-12">
                <label for="exampleInputDetails">{{ __('Detail') }}:<sup class="redstar">*</sup></label>
                <textarea name="detail"  class="form-control" >{!! $cate->detail !!}</textarea>
              </div>
              <br>
              <div class="col-md-12">
                <label for="exampleInputTit1e">{{ __('Status') }}:</label><br>
                    <label class="switch">
                      <input class="slider" type="checkbox" name="status" {{ $cate->status == '1' ? 'checked' : '' }} />
                      <span class="knob"></span>
                    </label>
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
