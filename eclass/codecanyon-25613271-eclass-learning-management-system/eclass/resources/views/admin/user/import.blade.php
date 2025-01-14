@extends('admin.layouts.master')
@section('title','Import User')
@section('maincontent')
<?php
$data['heading'] = 'Import Users';
$data['title'] = 'Import Users';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
<div class="row">
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="box-tittle">{{ __('Import Users') }}</h5>
          <div class="widgetbar">
			<a href="{{ url('files/user.csv') }}" class="float-right btn btn-primary-rgba mr-2"><i
				class="feather icon-arrow-down mr-2"></i>{{__('Download Example CSV File')}}
			</a>
		  </div>
		</div>
	   </div>
		<div class="row">
		
			<div class="col-lg-12">
				<div class="card m-b-30">
					<div class="card-header">
						<div class="row">
							<div class="col-lg-7">
								<h5 class="box-title py-4 px-3">{{ __('Import Institute') }}</h5>
							</div>
							<div class="col-lg-5">
								<form action="{{ route('user.csvfileupload') }}" method="POST" enctype="multipart/form-data">
									{{ csrf_field() }}
							
									<div class="row">
										<div class="form-group col-md-9">
												<label for="file">{{__('Select CSV File :')}} <sup class="text-danger">*</sup>
												</label>
												<input required="" type="file" name="file" class="form-control">
												@if ($errors->has('file'))
												<span class="invalid-feedback text-danger" role="alert">
													<strong>{{ $errors->first('file') }}</strong>
												</span>
											@endif
											</div>
											<div class="form-group col-md-3">
												<br/><p></p>
											<button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
												{{__('Submit')}}</button>
										</div>
									</div>
								</form>	
							</div>
						</div>
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
							<td><b>{{__('First Name')}}</b> {{__('Required')}}</td>
							<td>{{__('First Name')}}</td>
                        </tr>
                        <tr>
							<td>{{__('2')}}</td>
							<td><b>{{__('Last Name')}}</b> {{__('Required')}}</td>
							<td>{{__('Last Name')}}</td>
						</tr>
	
						<tr>
							<td>{{__('3')}}</td>
							<td><b>{{__('Mobile')}}</b> {{__('Required')}}</td>
							<td>{{__('Mobile')}}</td>
						</tr>
	
						<tr>
							<td>{{__('4')}}</td>
							<td><b>{{__('Email')}}</b> {{__('Required')}}</td>
							<td>{{__('Email')}}</td>
						</tr>
	
						<tr>
							<td>{{__('5')}}</td>
							<td><b>{{__('Address')}}</b> {{__('Required')}}</td>
							<td>{{__('Address')}}</td>
						</tr>
	        			<tr>
							<td>{{__('6')}}</td>
							<td><b>{{__('Gender')}}</b> {{__('Required')}}</td>
							<td>{{__('Gender')}}</td>
						</tr>
                        <tr>
							<td>{{__('7')}}</td>
							<td><b>{{__('Image')}}</b> {{__('Required')}}</td>
							<td>{{__('Image')}}</td>
						</tr>
                        <tr>
							<td>{{__('8')}}</td>
							<td><b>{{__('Verified')}}</b> {{__('Required')}}</td>
							<td>{{__('Verified')}}</td>
						</tr>
						<tr>
							<td>{{__('9')}}</td>
							<td><b>{{__('Status')}}</b> {{__('Required')}}</td>
							<td>{{__('Status')}}</td>
						</tr>
						<tr>
							<td>{{__('10')}}</td>
							<td><b>{{__('Role')}}</b> {{__('Required')}}</td>
							<td>{{__('Role')}}</td>
						</tr>
                        <tr>
							<td>{{__('11')}}</td>
							<td><b>{{__('Password')}}</b> {{__('Required')}}</td>
							<td>{{__('Password')}}</td>
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