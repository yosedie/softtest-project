@extends('admin.layouts.master')
@section('title','Edit Question')
@section('maincontent')
<?php
$data['heading'] = 'Edit Question';
$data['title'] = 'Edit Question';
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
          <h5 class="box-title">{{ __('Edit') }} {{ __('Question') }}</h5>
          <div class="widgetbar">
            <a href="{{ url('instructorquestion') }}" class="float-right btn btn-primary mr-2"><i
                class="feather icon-arrow-left mr-2"></i>{{__('Back')}}</a>
          </div>
        </div>
        <div class="card-body ml-2">
          <form id="demo-form" method="post" action="{{url('instructorquestion/'.$que->id)}}" data-parsley-validate class="form-horizontal form-label-left">
            {{ csrf_field() }}
            {{ method_field('PUT') }}


            <input type="hidden" name="instructor_id" class="form-control" value="{{ Auth::User()->id }}"  />
                 
            <select name="course_id" class="form-control select2">
             @foreach($courses as $cou)
             <option class="display-none" value="{{ $cou->id }}" {{$que->courses->id == $cou->id  ? 'selected' : ''}}>{{ $cou->title}}</option>
             @endforeach
            </select>

            <select name="user_id" class="form-control select2">
              @foreach($user as $cu)
                <option class="display-none" value="{{ $cu->id }}" {{$que->courses->id == $cu->id  ? 'selected' : ''}}>{{ $cu->fname}}</option>
              @endforeach
            </select>
                 
            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputTit1e">{{__('Question:')}}<span class="redstar">*</span></label>
                <textarea name="question" rows="3" class="form-control" placeholder="Enter Your quetion">{{$que->question}}</textarea>
              </div>
            <br>
            <br>
              <div class="col-md-12">
                <label for="exampleInputTit1e">{{__('Status:')}}</label>
                <input type="checkbox" class="custom_toggle" name="status"
                {{ $que->status==1 ? 'checked' : '' }} />
                  
                  <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="cb77"></label>
               
                <input type="hidden" name="status" value="{{ $que->status }}" id="jp">
              </div>
            </div> 
            <br>
              
            <div class="form-group">
              <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
                {{__('Reset')}}</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                {{__('Update')}}</button>
            </div>

            <div class="clear-both"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection