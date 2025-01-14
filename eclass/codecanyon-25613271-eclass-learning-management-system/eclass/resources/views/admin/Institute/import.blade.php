@extends('admin.layouts.master')
@section('title','Import Institute')
@section('maincontent')
<?php
$data['heading'] = 'Import Institutes';
$data['title'] = 'Institutes';
$data['title1'] = 'Import Institutes';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
<div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="box-tittle">{{ __('Import Institutes') }}</h5>
		  <div>
			<div class="widgetbar">
				<a href="{{ url('files/institute.csv') }}" class="btn btn-primary-rgba mr-2" title="{{__('Download Example CSV File')}}"><i
				class="feather icon-arrow-down mr-2"></i>{{__('Download Example CSV File')}}</a> 
				<a href="{{url('institute')}}" class="float-right  btn btn-primary-rgba mr-2" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
			</div>
		</div>
        </div>
        <div class="card-body">
			<form action="{{ route('institute.csvfileupload') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
		  
		  <div class="row">
			  <div class="form-group col-md-4">
			   <label for="file">{{__('Select CSV File :')}}</label>
				<input required="" type="file" name="file" class="form-control">
				@if ($errors->has('file'))
				  <span class="invalid-feedback text-danger" role="alert">
					  <strong>{{ $errors->first('file') }}</strong>
				  </span>
			   @endif
			</div>
			 <div class="form-group col-md-6">
			 	<br/>
			   <button type="submit" class="btn btn-primary mt-2" title="{{__('Submit')}}"><i class="fa fa-check-circle"></i>
                {{__('Submit')}}</button>
			  </div>

			  
		  </div>

		  </form>
		</div>
		<div class="row">
		
			<div class="col-lg-12">
				<div class="card m-b-30">
					<div class="card-header">
						<h5 class="box-title">{{ __('Import Institute Column Details') }}</h5>
					</div>
					<div class="card-body">
					
						<div class="table-responsive">
							<table id="datatable-buttons" class="table table-striped table-bordered">
								<thead>
								<tr>
                                    <th>{{__('Column No')}}</th>
                                    <th>{{__('Column Name')}}</th>
                                    <th>{{__('Description')}}</th>
                        </tr>
					</thead>
	
					<tbody>
						<tr>
							<td>{{__('1')}}</td>
							<td><b>{{__('Image')}}</b> {{__('Required')}}</td>
							<td>{{__('Name of Image')}}</td>
	
							</tr>
	
						<tr>
							<td>{{__('2')}}</td>
							<td><b>{{__('Address')}}</b> {{__('Required')}}</td>
							<td>{{__('Address')}}</td>
						</tr>
	
						<tr>
							<td>{{__('3')}}</td>
							<td><b>{{__('Email')}}</b>{{__('Required')}}</td>
							<td>{{__('Email')}}</td>
						</tr>
	
						<tr>
							<td>{{__('4')}}</td>
							<td><b>{{__('Mobile')}}</b> {{__('Required')}}</td>
							<td>{{__('Mobile')}}</td>
						</tr>
	
						<tr>
							<td>{{__('5')}}</td>
							<td><b>{{__('Skills')}}</b> {{__('Required')}}</td>
							<td>{{__('Skills')}}</td>
						</tr>
	        			<tr>
							<td>{{__('6')}}</td>
							<td><b>{{__('About')}}</b> {{__('Required')}}</td>
							<td>{{__('About')}}</td>
						</tr>
                        <tr>
							<td>{{__('7')}}</td>
							<td><b>{{__('Status')}}</b> {{__('Required')}}</td>
							<td>{{__('Status')}}</td>
						</tr>
                        <tr>
							<td>{{__('8')}}</td>
							<td><b>{{__('Verified')}}</b>{{__('Required')}}</td>
							<td>{{__('Verified')}}</td>
						</tr>
						<tr>
							<td>{{__('9')}}</td>
							<td><b>{{__('Title')}}</b> {{__('Required')}}</td>
							<td>{{__('Title')}}</td>
						</tr>
						<tr>
							<td>{{__('10')}}</td>
							<td><b>{{__('UserID')}}</b> {{__('Required')}}</td>
							<td>{{__('UserID')}}</td>
						</tr>
						<tr>
							<td>{{__('11')}}</td>
							<td><b>{{__('Affilated')}}</b> {{__('Required')}}</td>
							<td>{{__('Affilated')}}</td>
						</tr>
                    </tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	  </div>
	</div>
</div>
</div>	
@endsection
