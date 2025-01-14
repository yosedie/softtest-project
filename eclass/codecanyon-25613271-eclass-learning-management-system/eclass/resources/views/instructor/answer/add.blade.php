@extends('admin.layouts.master')
@section('title','Create a new answer')
@section('maincontent')
<?php
$data['heading'] = 'Create a new answer';
$data['title'] = 'Answer';
$data['title1'] = 'Create a new answer';
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
          <h5 class="box-tittle">{{ __('Add') }} {{ __('Answer') }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{url('instructoranswer')}}" class="float-right btn btn-primary-rgba mr-2"><i
                  class="feather icon-arrow-left mr-2"></i>{{__('Back')}}</a> </div>
          </div>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" action="{{url('instructoranswer/')}}" data-parsley-validate class="form-horizontal form-label-left">
            {{ csrf_field() }}
            

            <input type="hidden" name="instructor_id" value="{{Auth::user()->id}}" />
            <input type="hidden" name="ans_user_id" value="{{Auth::user()->id}}" />
       
            <div class="row">
              <div class="col-md-12">
                <label  for="exampleInputTit1e"> {{ __('Select') }} {{ __('Question') }}:<sup class="redstar">*</sup></label>
                <br>
                <select name="question_id" required class="form-control select2">
                  <option value="none" selected disabled hidden> 
                     {{ __('SelectanOption') }}
                  </option>
                  @foreach($questions as $ques)
                    <option value="{{ $ques->id }}">{{ $ques->question}}</option>
                  @endforeach
                </select>
              </div>
              @foreach($questions as $ques)
              <input type="hidden" name="ques_user_id"  value="{{$ques->user_id}}" />
              <input type="hidden" name="course_id"  value="{{$ques->course_id}}" />
              @endforeach
            </div>
            <br>

            <div class="row">
              <div class="col-md-12">
                <label for="exampleInput">{{ __('Answer') }}:<sup class="redstar">*</sup></label>
                <textarea name="answer" rows="4" class="form-control" placeholder="Please Enter Your Answer"></textarea>
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-md-6">
                <label for="exampleInputDetails">{{ __('Status') }}:</label>
                <input id="c12" type="checkbox" class="custom_toggle" name="status" checked />

                  <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="c12"></label>
               
                <input type="hidden" name="status" value="1" id="t12">
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