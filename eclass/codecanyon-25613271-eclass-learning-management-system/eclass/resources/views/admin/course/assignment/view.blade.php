@extends('admin.layouts.master')
@section('title','View Assignment')
@section('maincontent')
<?php
$data['heading'] = 'All Assignments';
$data['title'] = 'All Assignments';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card"> 
  <div class="row">
      <div class="col-lg-12">
          <div class="card dashboard-card m-b-30">
              <div class="card-header">
                  <h5 class="box-title">{{ __('View Assignment') }}</h5>
              </div>
              <div class="card-body">
                <div class="view-instructor">
                  <div class="instructor-detail">
                    
                      
                        @if($assign->user->user_img != null || $assign->user->user_img !='')
                        <img src="{{ asset('images/user_img/'.$assign->user->user_img) }}" class="img-circle" />
                      @else
                      <img src="{{ asset('images/default/user.jpg')}}" class="img-circle" alt="User Image">
                      @endif
                      <div class="mt-3">
                      <h4>{{ __('User') }} : {{ $assign->user->fname }} {{ $assign->user->lname }}</h4>
                    </div>
                    <div>
                     <h4>  {{ __('Course') }} : {{ $assign->courses->title }}</h4>
                    </div>
                    <div>
            <h4>{{ __('CourseChapter') }} : {{ $assign->chapter->chapter_name }}

                </h4>                    </div>
                    <div> 
                      <h4>
                        {{ __('AssignmentTitle') }} : {{ $assign->title }}

                      </h4>
                    </div>
                    <div>
                      <h4>
                        {{ __('Assignment') }}: <a href="{{ asset('files/assignment/'.$assign->assignment) }}"
                          download="{{$assign->assignment}}">{{ __('Download') }} <i class="fa fa-download"></i></a>
                      </h4>
                        </div>
              
                    
                  </div>
                </div>
              
              <br>
              <br>
                <form action="{{route('assignment.update',$assign->id)}}" method="POST" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  {{ method_field('PUT') }}
              
                  <input type="hidden" value="{{ $assign->user_id }}" name="user_id" class="form-control">
              
                  <input type="hidden" value="{{ $assign->course_id }}" name="course_id" class="form-control">
              
                  <div class="row">
                    <div class="col-md-6">
                      <label for="exampleInputTit1e">{{ __('ReviewAssignment') }}:</label>
                      <br>
                      <input id="assign_accept" type="checkbox" class="custom_toggle" name="type"
                      {{ $assign->type == 1 ? 'checked' : '' }} />
                        
                        <label class="tgl-btn" data-tg-off="Unchecked" data-tg-on="Checked" for="assign_accept"></label>
                      
                    </div>
                  </div>
                  <br>
              
                  <div class="row" style="{{ $assign['type'] == '1' ? '' : 'display:none' }}" id="sec1_one">
                    <div class="col-md-12">
                      <label for="exampleInputDetails">{{ __('Give scores to assignment') }} (1 to 10):</label>
                      <input min="1" max="10" class="form-control" name="rating" type="number" id="rating"
                        value="{{ $assign->rating }}" placeholder="Enter Duration in months">
                    </div>
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
@endsection
@section('script')



<script>
  (function ($) {
    "use strict";

    $(function () {

      $('#assign_accept').change(function () {
        if ($('#assign_accept').is(':checked')) {
          $('#sec1_one').show('fast');
          $('#sec_one').hide('fast');
        } else {
          $('#sec1_one').hide('fast');
          $('#sec_one').show('fast');
        }

      });

    });
  })(jQuery);
</script>



@endsection
