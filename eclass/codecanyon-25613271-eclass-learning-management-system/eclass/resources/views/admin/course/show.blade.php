@extends('admin.layouts.master')
@section('title','Edit Course')
@section('maincontent')
<?php
$data['heading'] = 'Course';
$data['title'] = 'Edit Course';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar bardashboard-card ">
  <!-- Start row -->
  <div class="row">
    <!-- Start col -->
    <div class="col-lg-5 col-xl-3">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-box">{{__('Courses')}}</h5>
        </div>
        <div class="card-body">

          @php
          $involvement = App\Involvement::firstWhere(['user_id' => Auth::user()->id,'course_id' => $cor->id]);

          @endphp

          @if(isset($involvement))
          <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link mb-2 active" id="v-pills-CourseChapter-tab" data-toggle="pill" href="#v-pills-CourseChapter" role="tab" aria-controls="v-pills-CourseChapter" aria-selected="true"><i class="feather icon-grid mr-2"></i>{{ __('CourseChapter') }}</a>
            <a class="nav-link mb-2" id="v-pills-CourseClass-tab" data-toggle="pill" href="#v-pills-CourseClass" role="tab" aria-controls="v-pills-CourseClass" aria-selected="false"><i class="feather icon-package mr-2"></i>{{ __('CourseClass')  }}</a>
          </div>
          @else
          <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

            <a class="nav-link mb-2 show active" data-toggle="pill" href="#v-pills-courseedit" role="tab" aria-selected="true"><i class="feather icon-grid mr-2"></i>{{ __('Course') }}</a>

            <a class="nav-link mb-2" id="v-pills-order-tab" data-toggle="pill" href="#v-pills-order" role="tab" aria-controls="v-pills-order" aria-selected="false"><i class="feather icon-book mr-2"></i>{{ __('CourseInclude') }}</a>

            <a class="nav-link mb-2" id="v-pills-addresses-tab" data-toggle="pill" href="#v-pills-addresses" role="tab" aria-controls="v-pills-addresses" aria-selected="false"><i class="feather icon-map-pin mr-2"></i>{{ __('WhatLearns') }}</a>

            <a class="nav-link mb-2" id="v-pills-wishlist-tab" data-toggle="pill" href="#v-pills-wishlist" role="tab" aria-controls="v-pills-wishlist" aria-selected="false"><i class="feather icon-book-open mr-2"></i>{{ __('CourseChapter') }}</a>

            <a class="nav-link mb-2" id="v-pills-wallet-tab" data-toggle="pill" href="#v-pills-wallet" role="tab" aria-controls="v-pills-wallet" aria-selected="true"><i class="feather icon-credit-card mr-2"></i>{{ __('CourseClass') }}</a>

            <a class="nav-link mb-2" id="v-pills-chat-tab" data-toggle="pill" href="#v-pills-chat" role="tab" aria-controls="v-pills-chat" aria-selected="false"><i class="feather icon-message-circle mr-2"></i>{{ __('RelatedCourse') }}</a>

            <a class="nav-link mb-2" id="v-pills-notifications-tab" data-toggle="pill" href="#v-pills-notifications" role="tab" aria-controls="v-pills-notifications" aria-selected="false"><i class="feather icon-bell mr-2"></i>{{ __('Question') }}</a>

            <a class="nav-link mb-2" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="feather icon-user mr-2"></i>{{ __('ReviewRating') }}</a>

            <a class="nav-link  mb-2" id="v-pills-logout-tab" data-toggle="pill" href="#v-pills-logout" role="tab" aria-controls="v-pills-logout" aria-selected="false"><i class="feather icon-speaker mr-2"></i>{{ __('Announcement') }}</a>

            <a class="nav-link  mb-2" id="v-pills-ReviewReport-tab" data-toggle="pill" href="#v-pills-ReviewReport" role="tab" aria-controls="v-pills-ReviewReport" aria-selected="false"><i class="feather icon-file-text mr-2"></i>{{ __('ReviewReport') }}</a>

            <a class="nav-link  mb-2" id="v-pills-QuizTopic-tab" data-toggle="pill" href="#v-pills-QuizTopic" role="tab" aria-controls="v-pills-QuizTopic" aria-selected="false"><i class="feather icon-log-out mr-2"></i>{{ __('QuizTopic') }}</a>

            <a class="nav-link  mb-2" id="v-pills-noticeboard-tab" data-toggle="pill" href="#v-pills-noticeboard" role="tab" aria-controls="v-pills-noticeboard" aria-selected="false"><i class="feather icon-clipboard mr-2"></i>{{ __('Notice Board') }}</a>
            
            <a class="nav-link  mb-2" id="v-pills-questionbook-tab" data-toggle="pill" href="#v-pills-questionbook" role="tab" aria-controls="v-pills-questionbook" aria-selected="false"><i class="feather icon-airplay mr-2"></i>{{ __('Question Bank') }}</a>


            @if($gsetting->appointment_enable == 1)
            <a class="nav-link" id="v-pills-Appointment-tab3" data-toggle="pill" href="#v-pills-Appointment" role="tab" aria-controls="v-pills-Appointment" aria-selected="false"><i class="feather icon-plus mr-2"></i>{{ __('Appointment') }}</a>
            @endif

            <a class="nav-link" id="v-pills-PreviousPaper-tab4" data-toggle="pill" href="#v-pills-PreviousPaper" role="tab" aria-controls="v-pills-PreviousPaper" aria-selected="false"><i class="feather icon-file mr-2"></i>{{ __('PreviousPaper') }}</a>
            @endif

          </div>
        </div>
      </div>
    </div>
    <!-- End col -->
    <!-- Start col -->
    <div class="col-lg-7 col-xl-9">
      <div class="tab-content" id="v-pills-tabContent">
        @if(isset($involvement))
        <div class="tab-pane fade show active" id="v-pills-CourseChapter">
          @include('admin.course.coursechapter.index')
        </div>
        <div class="tab-pane fade" id="v-pills-CourseClass" role="tabpanel" aria-labelledby="v-pills-CourseClass-tab">
          @include('admin.course.courseclass.index')
        </div>
        @else
        <div class="tab-pane fade show active" id="v-pills-courseedit" role="tabpanel">
          @include('admin.course.editcor')
        </div>

        <div class="tab-pane fade" id="v-pills-order" role="tabpanel" aria-labelledby="v-pills-order-tab">
          @include('admin.course.courseinclude.index')
        </div>
        <!-- My Orders End -->
        <!-- My Addresses Start -->
        <div class="tab-pane fade" id="v-pills-addresses" role="tabpanel" aria-labelledby="v-pills-addresses-tab">
          @include('admin.course.whatlearns.index')
        </div>
        <!-- My Addresses End -->
        <!-- My Wishlist Start -->
        <div class="tab-pane fade" id="v-pills-wishlist" role="tabpanel" aria-labelledby="v-pills-wishlist-tab">
          @include('admin.course.coursechapter.index')
        </div>
        <!-- My Wishlist End -->
        <!-- My Wallet Start -->
        <div class="tab-pane fade" id="v-pills-wallet" role="tabpanel" aria-labelledby="v-pills-wallet-tab">
          @include('admin.course.courseclass.index')
        </div>
        <!-- My Wallet End -->
        <!-- My Chat Start -->
        <div class="tab-pane fade" id="v-pills-chat" role="tabpanel" aria-labelledby="v-pills-chat-tab">
          @include('admin.course.relatedcourse.index')
        </div>
        <!-- My Chat End -->
        <!-- My Notifications Start -->
        <div class="tab-pane fade" id="v-pills-notifications" role="tabpanel" aria-labelledby="v-pills-notifications-tab">
          @include('admin.course.questionanswer.index')
        </div>
        <!-- My Notifications End -->
        <!-- My Profile Start -->
        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
          @include('admin.course.reviewrating.index')
        </div>

        <div class="tab-pane fade" id="v-pills-logout" role="tabpanel" aria-labelledby="v-pills-logout-tab">
          @include('admin.course.announsment.index')
        </div>
        <div class="tab-pane fade" id="v-pills-ReviewReport" role="tabpanel" aria-labelledby="v-pills-ReviewReport-tab">
          @include('admin.course.reviewreport.index')
        </div>
        <div class="tab-pane fade" id="v-pills-QuizTopic" role="tabpanel" aria-labelledby="v-pills-QuizTopic-tab">
          @include('admin.course.quiztopic.index')
        </div>

        <div class="tab-pane fade" id="v-pills-noticeboard" role="tabpanel" aria-labelledby="v-pills-noticeboard-tab">
          @include('admin.course.noticeboard.index')
        </div>

        <div class="tab-pane fade" id="v-pills-questionbook" role="tabpanel" aria-labelledby="v-pills-questionbook-tab">
          @include('admin.course.question_book.index')
        </div>

        <div class="tab-pane fade" id="v-pills-Appointment" role="tabpanel" aria-labelledby="v-pills-Appointment-tab3">
          @include('admin.course.appointment.index')
        </div>

        <div class="tab-pane fade" id="v-pills-PreviousPaper" role="tabpanel" aria-labelledby="v-pills-PreviousPaper-tab4">
          @include('admin.course.previous_paper.index')
        </div>
        @endif
      </div>
    </div>
    <!-- End col -->
  </div>
  <!-- End row -->
</div>

@endsection