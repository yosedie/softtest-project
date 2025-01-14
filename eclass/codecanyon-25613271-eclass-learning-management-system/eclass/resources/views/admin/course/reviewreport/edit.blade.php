@extends('admin.layouts.master')
@section('title','Edit ReviewReport - Admin')
@section('maincontent')
<?php
$data['heading'] = 'ReviewReport';
$data['title'] = 'ReviewReport';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Edit Review Report') }}</h5>
		  <div>
			<a href="{{ url('course/create/'. $show->courses->id) }}" class="float-right btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
			</div>
        </div>
        <div class="card-body ml-2">
          <!-- =================== -->
		  <form action="{{action('ReportReviewController@update',$show->id)}}" method="POST">
		                {{ csrf_field() }}
		                {{ method_field('PUT') }}

						<input type="hidden" value="{{ $show->course_id }}" autofocus required name="course" class="form-control" placeholder="Enter Title"/>

						<input type="hidden" value="{{ $show->review_id }}" autofocus required name="course" class="form-control" placeholder="Enter Title"/>

		                <div class="row">
		                  <div class="col-md-6">
		                    <label for="title">{{ __('Title') }}<sup class="redstar">*</sup></label>
		                    <input value="{{ $show->title }}" autofocus required name="title" type="text" class="form-control" placeholder="Enter Title"/>
		                  </div>
		                  <div class="col-md-6">
		                    <label for="email">{{ __('Email') }}<sup class="redstar">*</sup></label>
		                    <input value="{{ $show->email }}" autofocus required name="email" type="email" class="form-control" placeholder="Enter Email"/>
		                  </div>
		              	</div>
		              	<br>

		              	<div class="row">
		                  <div class="col-md-12">
		                    <label for="detail">{{ __('Detail') }}<sup class="redstar">*</sup></label>
		                    <textarea name="detail" value="" rows="4"  class="form-control" placeholder="">{{ $show->detail }}</textarea>
		                  </div>
		              	</div>
		              	<br>

		              	<div class="form-group">
							<button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
								{{ __('Reset') }}</button>
							<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
								{{ __('Update') }}</button>
						</div>

		          	</form>
		  <!-- =================== -->
        </div>
      </div>
    </div>
  </div>
</div>

@endsection