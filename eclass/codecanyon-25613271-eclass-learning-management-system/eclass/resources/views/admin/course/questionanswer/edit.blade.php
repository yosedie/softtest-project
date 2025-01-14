@extends('admin.layouts.master')
@section('title','Edit QuestionAnswer')
@section('maincontent')
<?php
$data['heading'] = 'QuestionAnswer';
$data['title'] = 'QuestionAnswer';
$data['title1'] = 'Edit QuestionAnswer';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Edit') }} {{ __('Question Answer') }}</h5>
          <div>
            <a href="{{ url('course/create/'. $que->courses->id) }}" class="float-right btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
          </div>
        </div>
        <div class="card-body ml-2">
          <form id="demo-form" method="post" action="{{url('questionanswer/'.$que->id)}}" data-parsley-validate class="form-horizontal form-label-left">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
<div style="display:none;">
    
  <input type="hidden" name="instructor_id" class="form-control" value="{{ Auth::User()->id }}"  />
​
  <select name="course_id" class="form-control select2 d-none">
    @foreach($courses as $cou)
    <option class="d-none" value="{{ $cou->id }}" {{$que->courses->id == $cou->id  ? 'selected' : ''}}>{{ $cou->title}}</option>
    @endforeach
   </select>
​
   <select name="user_id" class="form-control col-md-7 col-xs-12 display-none">
     @foreach($user as $cu)
       <option class="display-none" value="{{ $cu->id }}" {{$que->courses->id == $cou->id  ? 'selected' : ''}}>{{ $cu->fname}}</option>
     @endforeach
   </select>
​
</div>
​
              
                 
            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputTit1e">{{ __('Question') }}:<span class="redstar">*</span></label>
                <textarea name="question" rows="3" class="form-control" placeholder="Enter Your Question" required >{{$que->question}}</textarea>
              </div>
          
              <div class="col-md-12 mt-3">
                <label for="exampleInputTit1e">{{ __('Status') }}:</label><br>
               
                    <label class="switch">
                      <input class="slider" type="checkbox" name="status" {{ $que->status==1 ? 'checked' : '' }} />
                      <span class="knob"></span>
                    </label>
             
                
             
               
              </div>
            </div> 
            <br>
              
            <div class="form-group">
              <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
                {{ __('Reset') }}</button>
              <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                {{ __('Update') }}</button>
            </div>
​
            <div class="clear-both"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
​
@endsection