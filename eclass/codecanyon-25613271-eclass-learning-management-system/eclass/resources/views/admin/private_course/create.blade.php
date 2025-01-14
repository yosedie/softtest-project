@extends('admin.layouts.master')
@section('title','Create a new private course')
@section('maincontent')
<?php
$data['heading'] = 'Add Private Course';
$data['title'] = 'Courses';
$data['title1'] = 'Private Courses';
$data['title2'] = 'Create a Private Course';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-box">{{ __('Add Private Course') }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{ url('private-course') }}" class="float-right btn btn-primary-rgba mr-2" title="{{ __('Back') }}"><i
                  class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a> </div>
          </div>
        </div>
        <div class="card-body">
          <form action="{{url('private-course/')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="row">
              <div class="col-md-12">

                <div class="form-group">
                  <label>{{ __('Select Course') }}: <span
                      class="text-danger">*</span></label>
                  <select class="form-control js-example-basic-single" name="course_id" size="5" row="5"
                    placeholder="{{ __('Select Course') }}">
                    @foreach ($courses as $cat)
                    @if($cat->status == 1)
                    <option value="{{ $cat->id }}">{{ $cat->title }}
                    </option>
                    @endif
                    @endforeach
                  </select>
                </div>
              </div>              

                <div class="form-group col-md-12">
                  <label>{{ __('Hide from Users') }}: <span
                      class="text-danger">*</span></label>
                  <select class="form-control js-example-basic-single" name="user_id[]" multiple="multiple" size="5"
                    row="5" placeholder="{{ __('Select Users') }}">
                    @foreach ($users as $user)
                    @if($user->status == 1)
                    <option value="{{ $user->id }}">{{ $user->fname }}
                    </option>
                    @endif
                    @endforeach
                  </select>
                </div>  
                  <div class="form-group col-md-12">
                    @if(Auth::User()->role == "admin")
                    <label for="exampleInputDetails">{{ __('Status') }}:</label>
                    <input class="custom_toggle" type="checkbox" name="status" id="cb3" checked />                   
                    @endif
                  </div>
                
                <div class="form-group col-md-12">
                  <button type="reset" class="btn btn-danger-rgba" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __('Reset') }}</button>
                  <button type="submit" class="btn btn-primary-rgba" title="{{ __('Create') }}"><i class="fa fa-check-circle"></i>
                    {{ __('Create') }}</button>
                </div>

                <div class="clear-both"></div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')


<script>
  (function ($) {
    "use strict";


    $(function () {
      $('.js-example-basic-single').select2();
    });


  })(jQuery);
</script>

@endsection