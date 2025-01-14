@extends('admin.layouts.master')
@section('title', 'Advertise Settings - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Advertise Settings';
$data['title'] = 'Player Settings';
$data['title1'] = 'Advertise Settings';
?>
@include('admin.layouts.topbar',$data)
  <div class="contentbar">
    @if ($errors->any())  
    <div class="alert alert-danger" role="alert">
    @foreach($errors->all() as $error)     
    <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true" style="color:red;">&times;</span></button></p>
    @endforeach  
    </div>
    @endif
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-md-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{ __("Advertise Settings")}}</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTabLine" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab-line" data-toggle="tab" href="#home-line" role="tab" aria-controls="home-line" aria-selected="true">{{ __("Skip AD Setting")}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-line" data-toggle="tab" href="#profile-line" role="tab" aria-controls="profile-line" aria-selected="false">{{ __("Pop Up Ad Setting")}}</a>
                        </li>
                      </ul>
                    <div class="tab-content" id="defaultTabContentLine">
                        <div class="tab-pane fade show active" id="home-line" role="tabpanel" aria-labelledby="home-tab-line">
                        	<form action="{{ route('ad.update') }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group col-md-6">
                              <label for="exampleInputTit1e">{{ __('Skip AD Timer') }}</label>
                              <select name="timer_check" id="timer" class="select2-single form-control">
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                              </select>
                            </div>
                             <div class="form-group col-md-6"  style="display: none;" id="t">
                              <label for="exampleInputTit1e">{{ __('Time : ( Please Ensure that its not conflict with popup ad start time )') }}</label>
                              <input type="text" placeholder="00:00:10" name="ad_timer" class="form-control">
                              <br>
                              <label for="">{{ __("Ad Hold Time:")}} </label>
                              <input type="number" name="ad_hold" min="0" max="10" placeholder="eg. 5" class="form-control">                            
                            </div>
                            <div class="form-group col-md-12">
                              <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                              <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                                {{ __("Update")}}</button>
                            </div>
                          </form>
                        </div>
                                
                              
                                
                                
                              
                            
                        <div class="tab-pane fade" id="profile-line" role="tabpanel" aria-labelledby="profile-tab-line">
                          <form action="{{ route('ad.pop.update') }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                           

                            <div class="form-group col-md-6">
                              <label for="">{{ __("Start Time:")}} <br><span class="help-block">{{ __("( Please Ensure that its not conflict with video ad start time )")}}</span></label>
                              <input type="text" name="time" placeholder="00:00:10" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                              <label for="">{{ __("End Time:")}} </label>
                              <input type="text" name="endtime" placeholder="00:00:30" class="form-control">                        
                            </div>
                            
                            
                            <div class="form-group col-md-12">
                              <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                              <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                                {{ __("Update")}}</button>
                            </div>
                          </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
	
	
@endsection
@section('script')
	<script type="text/javascript">
		$('#timer').change(function(){
			if($(this).val() == 'no')
			{
				$('#t').hide();
			}else
			{
				$('#t').show();
			}
		});
	</script>
@endsection