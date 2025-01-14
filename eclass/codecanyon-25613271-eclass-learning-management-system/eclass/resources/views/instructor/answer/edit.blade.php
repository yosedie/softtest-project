@extends('admin.layouts.master')
@section('title','Edit Answer')
@section('maincontent')
<?php
$data['heading'] = 'Edit answer';
$data['title'] = 'Answer';
$data['title1'] = 'Edit answer';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
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
          <h5 class="box-title">{{ __('Edit') }} {{ __('Answer') }}</h5>
          <div class="widgetbar">
            <a href="{{ url('instructoranswer')}}" class="float-right btn btn-primary mr-2"><i
                class="feather icon-arrow-left mr-2"></i>{{__('Back')}}</a>
          </div>
        </div>
        <div class="card-body ml-2">
          <form action="{{url('instructoranswer/'.$answer->id)}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <label class="d-none" for="exampleInputSlug">{{ __('SelectCourse') }}</label>
              <input value="{{ $answer->course_id }}" autofocus name="course_id" class="d-none" type="text" class="form-control select2" >


              <div class="row">
                <div class="col-md-12">
                  <label for="exampleInput"> {{ __('Answer') }}:<sup class="redstar">*</sup></label>
                  <textarea name="answer" rows="4" class="form-control" placeholder="Please Enter Your Answer">{{ $answer->answer }}</textarea>
                </div>
              </div>
            
            <br>


            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                <label for="exampleInputTit1e">{{ __('Status') }}:</label>
                <input id="cb10111" type="checkbox" class="custom_toggle" name="status"
                {{ $answer->status==1 ? 'checked' : '' }} />
               
                <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="cb10111"></label>
                
                <input type="hidden" name="status" value="{{ $answer->status }}" id="jjjj">
            </div>
           
            
            
            <div class="form-group">
              <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
                {{__('Reset')}}</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                {{__('Update')}}</button>
            </div>

            <div class="clear-both"></div>
        </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection