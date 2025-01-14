@extends('admin.layouts.master')
@section('title', 'View Instructor - Admin')
@section('maincontent')
<?php
$data['heading'] = 'View Instructor';
$data['title'] = 'View Instructor';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">                
    <!-- Start row -->
    <div class="row">
		<div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('View Instructor')}}</h5>
                </div>
                <div class="card-body">
					<div class="form-group col-md-12">
						<ul class="instructor">
							<li><img src="{{ asset('images/instructor/'.$show->image) }}" class="img-circle"/></li>
							<li><span class="text-color">{{ __('Name') }}:</span> {{ $show->fname }} {{ $show['lname'] }}</li>
							<li><span class="text-color">{{ __('Role') }}:</span> {{ $show->role }}</li>
							<li><span class="text-color">{{ __('Phone') }}:</span> {{ $show->mobile }}</li>
							<li><span class="text-color">{{ __('Email') }}:</span> {{ $show->email }}</li>
							<li><span class="text-color">{{ __('Detail') }}:</span> {{ $show->detail }}</li>
							<li><span class="text-color">{{ __('Resume') }}:</span> <a href="{{ asset('files/instructor/'.$show->file) }}" download="{{$show->file}}">{{ __('Download') }} <i class="fa fa-download"></i></a></li>

						</ul>
					</div>
					<form action="{{route('requestinstructor.update',$show->id)}}" method="POST" enctype="multipart/form-data">
						  {{ csrf_field() }}
						  {{ method_field('PUT') }}
					<div class="form-group col-md-12">
						<input type="hidden" value="{{ $show->user_id }}" name="user_id" class="form-control">
						   <input type="hidden" value="{{ $show->role }}" name="role" class="form-control">
						  <input type="hidden" value="{{ $show->mobile }}" name="mobile" class="form-control">
						  <input type="hidden" value="{{ $show->detail }}" name="detail" class="form-control">
						  <input type="hidden" value="{{ $show->image }}" name="image" class="form-control">
					</div>
                  
						
							
						
					  
					<div class="row ml-3">
						<div class="form-group ml-4 col-md-6">
							<label for="exampleInputTit1e">{{ __('Status') }}:</label>
							<br>
							<input  type="checkbox" name="search_enable"  class="custom_toggle"   {{ $show->status==1 ? 'checked' : '' }} />
							<input type="hidden" name="status" value="{{ $show->status }}" id="c33">
						  </div>
					</div>
						
					
						    
								
								
								
					<div class="row ml-3">
							<div class="form-group ml-4  col-md-6">
								<button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
								<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
								{{ __("Update")}}</button>
							</div>
						</div>
			
						  </form>
					  </div>
					</div>
				  </div>
				  <!-- End col -->
			  </div>
			  <!-- End row -->
			</div>     
			
@endsection
					
                             
                            
                         
                  



				  
				 
				 
