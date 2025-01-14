@extends('admin.layouts.master')
@section('title', 'Email Template')
@section('maincontent')
<?php
$data['heading'] = 'Email Template';
$data['title'] = 'Email Template';
$data['title1'] = 'Edit Email Template';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  @if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
  @endforeach  
  </div>
  @endif
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Edit') }} {{ __('Email Template') }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{url('email-template')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
            </div>
          </div>
        </div>
        <div class="card-body">

          <form id="demo-form2" method="post" action="{{url('email-template')}}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}

            <input type="hidden" name="id" value="{{$emailTemplate->id}}">
            <div class="row">

                <div class="form-group col-md-6">
                    <label for="exampleInputTit1e">{{ __('Template Type') }}:<sup class="redstar">*</sup></label>
                    <select name="type" class="form-control" required>
                        <option value="">{{__('Select Type')}}</option>
                        <option value="admin_order" {{$emailTemplate->type=='admin_order'?"selected":''}}>{{__('Admin Order')}}</option>
                        <option value="course" {{$emailTemplate->type=='course'?"selected":''}}>{{__('Course')}}</option>
                        <option value="verification" {{$emailTemplate->type=='verification'?"selected":''}}>{{__('Verification')}}</option>
                        <option value="offer_push" {{$emailTemplate->type=='offer_push'?"selected":''}}>{{__('Offer Push')}}</option>
                        <option value="user_enroll" {{$emailTemplate->type=='user_enroll'?"selected":''}}>{{__('User Enroll')}}</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputTit1e">{{ __('Subject') }}:<sup class="redstar">*</sup></label>
                    <input class="form-control" type="text" value="{{$emailTemplate->subject}}" name="subject" placeholder="{{ __('adminstaticword.Enter') }} {{ __('Subject') }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputTit1e">{{ __('Title') }}:<sup class="redstar">*</sup></label>
                    <input class="form-control" type="text" name="title" value="{{$emailTemplate->title}}" placeholder="{{ __('adminstaticword.Enter') }} {{ __('Title') }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputTit1e">{{ __('Action Message') }}:</label>
                    <input class="form-control" type="text" name="action" value="{{$emailTemplate->action}}" placeholder="{{ __('adminstaticword.Enter') }} {{ __('Action Message') }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputTit1e">{{ __('Message') }}:</label>
                    <textarea class="form-control" name="message" placeholder="{{ __('adminstaticword.Enter') }} {{ __('Message') }}">{{$emailTemplate->message}}</textarea>
                </div>

            </div>

            <div class="form-group">

                <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i> {{ __("Update")}}</button>

            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection