@extends('admin.layouts.master')
@section('title','Enroll a user')
@section('maincontent')
<?php
$data['heading'] = 'Enroll a User';
$data['title'] = 'Orders';
$data['title1'] = 'Enroll a User';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    <div class="row">
      <div class="col-lg-12">
        <div class="card dashboard-card m-b-30">
          <div class="card-header">
             <h5 class="card-box">{{ __('Enroll a User') }}</h5>
            <div>
                <div class="widgetbar">
                  <a href="{{ url('order') }}" class="float-right btn btn-primary-rgba mr-2" title="{{ __('Back') }}"><i
                    class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>  </div>                        
              </div>
            <div class="box-body">
                <div class="form-group">
                    <form id="demo-form2" method="post" action="{{ route('order.store') }}" data-parsley-validate
                        class="form-horizontal form-label-left" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
                                <label>{{ __('User') }}<span class="redstar">*</span></label>

                                <input type="hidden" id="enrollUserViewRoute"
                                    value="{{ route('order.enrolluserview', '') }}">
                                <select name="user_id" id="user_id" class="form-control select2"
                                    required>
                                    <option value="">{{ __('Select User') }}</option>
                                    @foreach ($users as $user)
                                        <option
                                            {{ isset($selectedUser) && $user->id === $selectedUser->id ? 'selected' : '' }}
                                            value="{{ $user->id }}">{{ $user->fname }} {{ $user->lname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>{{ __('Courses') }} </label>
                                <select name="course_id" id="course_id"
                                    class="form-control select2">
                                    <option value="">{{ __('Select Course') }}</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>{{ __('Bundles') }}</label>
                                <select name="bundle_id" id="bundle_id"
                                    class="form-control select2">
                                    <option value="">{{ __('Select Bundle') }}</option>
                                    @foreach ($bundles as $bundle)
                                        <option value="{{ $bundle->id }}">{{ $bundle->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="box-footer">
                            <button type="submit" value="Add Slider" class="btn btn-md col-md-2 btn-primary" title="{{ __('Enroll User') }}">{{ __('Enroll
                                User') }}</button>
                        </div>
                     </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @if (isset($enrolledCourses)  )
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <div class="card-header">
                            <h5 class="card-box">{{ __('Enrolled Courses') }}</h5>
                            <div class="box-body">

                                @foreach ($enrolledCourses as $enrolledCourse)

                                    <div class="row">
                                        <div class="col-md-6">

                                            {{ $enrolledCourse['title'] }}
                                        </div>

                                    </div>
                                    <br>
                                @endforeach
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (isset($enrolledBundles)  )
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <div class="card-header">
                            <h5 class="card-box">{{ __('Enrolled Bundles') }}</h5>
                            <div class="box-body">

                                @foreach ($enrolledBundles as $enrolledBundle)

                                    <div class="row">
                                        <div class="col-md-6">
                                            {{ $enrolledBundle->title }}
                                        </div>

                                    </div>
                                    <br>
                                @endforeach
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>



@endsection

@section('script')

    <script>
        $(function() {
            $('#user_id').on('change', function(e) {
                var userId = this.value;
                var link = $('#enrollUserViewRoute').val() + '/' + userId;

                top.location.href = link;
            });
        })

    </script>
@endsection

