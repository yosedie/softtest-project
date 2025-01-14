@extends('admin.layouts.master')
@section('title','All Coursereview')
@section('maincontent')
<?php
$data['heading'] = 'All Coursereview';
$data['title'] = 'All Coursereview';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h4 class="box-title">{{ __('CourseReview') }}->{{ $course->title }}</h4>
        </div>
        <div class="card-body">
          <div class="view-instructor">
            <div class="instructor-detail">
              <ul>
                @if($course->preview_image != null || $course->preview_image !='')
                <img src="{{ asset('images/course/'.$course->preview_image) }}" class="img-circle" />
                @else
                <img src="{{ Avatar::create($course->title)->toBase64() }}" alt="course" class="img-responsive">
                @endif

                <li><b>{{ __('Course') }}</b>: {{ $course->title }}</li>
                <li><b>{{ __('User') }}</b>: {{ $course->user->fname }} {{ $course->user->lname }}</li>

                <li><b>{{ __('Title') }}</b>: {{ $course->title }}</li>
                <li><b>{{ __('Detail') }}</b>: {!! $course->detail !!}</li>
                <li><b>{{ __('Course Rejected Reason') }}</b>:<br> {!! $course->reject_txt !!}</li>
              </ul>
            </div>
          </div>



        </div>
      </div>
    </div>
  </div>
</div>

@endsection