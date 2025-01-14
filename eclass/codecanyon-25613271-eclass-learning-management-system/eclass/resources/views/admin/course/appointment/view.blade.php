@extends('admin.layouts.master')
@section('title', 'Edit Appointment - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Edit Appointment';
$data['title'] = 'Edit Appointment';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Appointment') }}</h5>
        </div>
        <div class="card-body appoint-view-page">
          <div class="view-instructor">
            <div class="instructor-detail">
              <div class="row">
                <div class="col-lg-3">
                  @if($appoint->user->user_img != null || $appoint->user->user_img !='')
                    <img src="{{ asset('images/user_img/'.$appoint->user->user_img) }}" class="img-circle"/>
                  @else
                    <img src="{{ asset('images/default/user.jpg')}}" class="img-circle" alt="User Image">
                  @endif
                </div>
                <div class="col-lg-6">
                  <div class="appoint-view-dtl">
                    <div class="row mb-3">
                      <div class="col-lg-2">
                        <span class="text-dark appoint-title">{{ __('User') }}: </span>
                      </div>
                      <div class="col-lg-10">
                        {{ $appoint->user->fname }} {{ $appoint->user->lname }}
                      </div>
                    </div>
                  </div>
                  <div class="appoint-view-dtl">
                    <div class="row mb-3">
                      <div class="col-lg-2">
                        <span class="text-dark appoint-title">{{ __('Course') }}: </span>
                      </div>
                      <div class="col-lg-10">
                        {{ $appoint->courses->title }}
                      </div>
                    </div>
                  </div>
                  <div class="appoint-view-dtl">
                    <div class="row mb-3">
                      <div class="col-lg-2">
                        <span class="text-dark appoint-title">{{ __('Title') }}:</span> 
                      </div>
                      <div class="col-lg-10">
                        {{ $appoint->title }}
                      </div>
                    </div>
                  </div>
                  <div class="appoint-view-dtl">
                    <div class="row mb-3">
                      <div class="col-lg-2">
                        <span class="text-dark appoint-title">{{ __('Detail') }}:</span> 
                      </div>
                      <div class="col-lg-10">
                        {{ $appoint->detail }}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 text-center">
                  <form action="{{route('appointment.update',$appoint->id)}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="">
                      <div class=" form-group">
                        <label for="exampleInputTit1e">{{ __('Accept') }}:</label><br>
                        <label class="switch">
                          <input class="slider" type="checkbox" name="search_enable" {{ $appoint->accept == 1 ? 'checked' : '' }}  />
                          <span class="knob"></span>
                        </label>
                          <!--<input  type="checkbox" name="search_enable"  id="appoint_accept" {{ $appoint->accept == 1 ? 'checked' : '' }}  class="custom_toggle"/>           -->
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <!-- <ul style="list-style-type:none;" class="mt-3">
                <li>
                  @if($appoint->user->user_img != null || $appoint->user->user_img !='')
                    <img src="{{ asset('images/user_img/'.$appoint->user->user_img) }}" class="img-circle"/>
                  @else
                    <img src="{{ asset('images/default/user.jpg')}}" class="img-circle" alt="User Image">
                  @endif
                </li>
                <li><span class="text-dark">{{ __('User') }}: </span>{{ $appoint->user->fname }} {{ $appoint->user->lname }}</li>
                <li><span class="text-dark">{{ __('Course') }}: </span>{{ $appoint->courses->title }}</li>
                <li><span class="text-dark">{{ __('Title') }}:</span> {{ $appoint->title }}</li>
                <li><span class="text-dark">{{ __('Detail') }}:</span> {{ $appoint->detail }}</li>
              </ul> -->
            </div>
          </div>
          <form action="{{route('appointment.update',$appoint->id)}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <input type="hidden" value="{{ $appoint->user_id }}" name="user_id" class="form-control">
            <input type="hidden" value="{{ $appoint->course_id }}" name="course_id" class="form-control">
            <!-- <div class="row "> -->
              <!-- <div class=" form-group col-md-6"> -->
                <!-- <label for="exampleInputTit1e">{{ __('Accept') }}:</label><br>
                <label class="switch">
                  <input class="slider" type="checkbox" name="search_enable" {{ $appoint->accept == 1 ? 'checked' : '' }}  />
                  <span class="knob"></span>
                </label> -->
                  <!--<input  type="checkbox" name="search_enable"  id="appoint_accept" {{ $appoint->accept == 1 ? 'checked' : '' }}  class="custom_toggle"/>           -->
              <!-- </div> -->
            <!-- </div> -->
            <!-- <br> -->
            <div class="row" style="{{ $appoint['accept'] == '1' ? '' : 'display:none' }}" id="sec1_one">
              <div class="col-md-12">
                <label for="exampleInputDetails" class="appoint-title">{{ __('Reply') }}:</label>
                <textarea id="reply" name="reply" rows="1" class="form-control" placeholder="Enter class detail">{{ $appoint['reply'] }}</textarea>
              </div>
            </div>
            <br>
            <div class="form-group">
              <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
              <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
              {{ __("Update")}}</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<!--courseclass.js is included -->
<script>
 tinymce.init({selector:'textarea#reply'});
</script>
<script>
(function($) {
  "use strict";
  $(function(){
      $('#appoint_accept').change(function(){
        if($('#appoint_accept').is(':checked')){
          $('#sec1_one').show('fast');
          $('#sec_one').hide('fast');
        }else{
          $('#sec1_one').hide('fast');
          $('#sec_one').show('fast');
        }
      });
  });
})(jQuery);
</script>
@endsection