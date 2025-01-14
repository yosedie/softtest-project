@extends('admin.layouts.master')
@section('title','Create a new question')
@section('maincontent')
<?php
$data['heading'] = 'Create a new question';
$data['title'] = 'Question';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
  @if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="box-tittle">{{ __('Add') }} {{ __('Question') }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{url('instructorquestion')}}" class="float-right btn btn-primary mr-2"><i
                  class="feather icon-arrow-left mr-2"></i>{{__('Back')}}</a> </div>
          </div>
              </div>
        <div class="card-body">
          <form id="demo-form2" method="post" action="{{ route('instructorquestion.store') }}" data-parsley-validate class="form-horizontal form-label-left">
            {{ csrf_field() }}
            <input type="hidden" name="instructor_id" class="form-control" value="{{ Auth::User()->id }}"  />

            <div class="row"> 
              <div class="col-md-12">
                <label for="exampleInputSlug">{{__('Course')}} <span class="redstar">*</span></label>
                <select name="course_id" class="form-control select2">
                  <option value="none" selected disabled hidden> 
                    {{__('Select an Option')}} 
                  </option>
                  @foreach($course as $cor)
                      <option value="{{ $cor->id }}">{{ $cor->title }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            {{-- <div class="row"> 
              <div class="col-md-12">
                <select name="user_id" class="form-control display-none">
                  <option  value="{{ Auth::user()->id }}">{{ Auth::user()->fname }}</option>
                </select>
              </div>
            </div>
            <br> --}}
            
            <div class="row">  
              <div class="col-md-12">
                <label for="exampleInputDetails">{{__('Question')}}:<sup class="redstar">*</sup></label>
                <textarea name="question" rows="3" class="form-control" placeholder="Enter Your quetion"></textarea>
              </div>
            </div>
            <br>
            
            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputDetails">{{__('Status:')}}</label>               
                  
                  <input id="c2222" type="checkbox" class="custom_toggle" name="status" checked />

                  <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="c2222"></label>
                <input type="hidden" name="status" value="0" id="t2222">
              </div>
            </div>
            <br>
          
            <div class="form-group">
              <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i> {{__('Reset')}}</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                {{__('Create')}}</button>
            </div>

            <div class="clear-both"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection