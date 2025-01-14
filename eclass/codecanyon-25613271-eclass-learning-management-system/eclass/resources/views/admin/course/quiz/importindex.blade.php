@extends('admin.layouts.master')
@section('title','Import Question')
@section('maincontent')
<?php
$data['heading'] = 'Question';
$data['title'] = 'Import Question';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
<div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="box-tittle">{{ __('Import') }} {{ __('Question') }}</h5>
		  <div>
			<div class="widgetbar">
			  <a href="{{ url('files/QuizQuestion.xlsx') }}" class="float-right btn btn-primary-rgba mr-2"><i
				  class="feather icon-arrow-down mr-2"></i>{{ __('Back') }}{{__('Download Example xls/csv File')}}</a> </div>
		  </div>
        </div>
        <div class="card-body">
			<form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
		  
		  <div class="row">
			  <div class="form-group col-md-6">
			   <label for="file">{{ __('Back') }}{{__('Select xls/csv File :')}}</label>
				<input required="" type="file" name="file" class="form-control">
				@if ($errors->has('file'))
				  <span class="invalid-feedback text-danger" role="alert">
					  <strong>{{ $errors->first('file') }}</strong>
				  </span>
			   @endif
			  <br>
			   <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                {{ __('Back') }}{{__('Submit')}}</button>
			  </div>

			  
		  </div>

		  </form>
		</div>
		<div class="row">
		
			<div class="col-lg-12">
				<div class="card m-b-30">
					<div class="card-header">
						<h5 class="box-title">{{ __('Back') }}{{__('Import Question')}}</h5>
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
							<td><b>{{__('Course')}}</b> {{__('Required')}}</td>
							<td>{{__('Name of course')}}</td>
	
							
						</tr>
	
						<tr>
							<td>{{__('2')}}</td>
							<td><b>{{__('QuizTopic')}}</b> {{__('Required')}}</td>
							<td>{{__('Name of Quiz Topic')}}</td>
						</tr>
	
						<tr>
							<td>{{__('3')}}</td>
							<td><b>{{__('Question')}}</b> {{__('Required')}}</td>
							<td>{{__('Name of Question')}}</td>
						</tr>
	
						<tr>
							<td>{{__('4')}}</td>
							<td><b>{{__('A')}}</b> {{__('Required')}}</td>
							<td>{{__('Option A.')}}</td>
						</tr>
	
						<tr>
							<td>{{__('5')}}</td>
							<td><b>{{__('B')}}</b> {{__('Required')}}</td>
							<td>{{__('Option B.')}}</td>
						</tr>
	
						<tr>
							<td>{{__('6')}}</td>
							<td><b>{{__('C')}}</b> {{__('Required')}}</td>
							<td>{{__('Option C.')}}</td>
						</tr>
	
						<tr>
							<td>{{__('7')}}</td>
							<td><b>{{__('D')}}</b> {{__('Required')}}</td>
							<td>{{__('Option D.')}}</td>
						</tr>
	
						<tr>
							<td>{{__('8')}}</td>
							<td><b>{{__('CorrectAnswer')}}</b> {{__('Required')}}</td>
							<td>{{__('Question correct answer -> options')}} (a,b,c,d)</td>
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
