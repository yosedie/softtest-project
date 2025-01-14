@extends('admin.layouts.master')
@section('title','Edit Answer')
@section('maincontent')
<?php
$data['heading'] = 'Edit Answer';
$data['title'] = 'Edit Answer';
?>
@include('admin.layouts.topbar',$data)
 <div class="contentbar dashboard-card">
   	<div class="row">
	    <div class="col-md-12">
	    	<div class="card dashboard-card m-b-30">
	           	<div class="card-header">
	          	<h3 class="card-box"> {{ __('Edit') }} {{ __('Answer') }}</h3>
				  <div>
					<a href="{{ url('courseanswer/'. $show->courses->id) }}" class="float-right btn btn-primary mr-2"><i
						class="feather icon-arrow-left mr-2"></i>{{__('Back')}}</a>
				  </div>
	       		</div>
	          	<div class="card-body ml-2">
	          		<form action="{{route('courseanswer.update',$show->id)}}" method="POST" enctype="multipart/form-data">
		                {{ csrf_field() }}
		                {{ method_field('PUT') }}
						

						<input type="hidden" name="instructor_id" class="form-control" value="{{ Auth::User()->id }}"  />
						
		              
	                    <input type="hidden" value="{{ $show->course_id }}" autofocus name="course_id" type="text" class="form-control d-none" >


	                    <div class="row">
	                    	<div class="col-md-12">
	                    		<label for="exampleInput">{{ __('Answer') }}:<sup class="redstar">*</sup></label>
	                  			<textarea name="answer" rows="4" class="form-control" placeholder="Please Enter Your Answer" required>{{ $show->answer }}</textarea>
	                    	</div>
	                    </div>
		              	
		              	<br>


		              	<div class="form-group col-md-12">
                          <label class="text-dark" for="exampleInputDetails">{{ __('Status') }} :</label><br>
                          <label class="switch">
                            <input class="slider" type="checkbox" name="status" {{ $show->status == '1' ? 'checked' : '' }} />
                            <span class="knob"></span>
                          </label>
                        </div>
		              	<br>
		              	<br>
		              	<br>
		              	
						<div class="box-footer">
		              		<button value="" type="submit"  class="btn btn-md col-md-2 btn-primary-rgba">{{ __('Save') }}</button>
		              	</div>

		          	</form>
	          	</div>
	      	</div>
	  	</div>
  	</div>
</div>
@endsection
