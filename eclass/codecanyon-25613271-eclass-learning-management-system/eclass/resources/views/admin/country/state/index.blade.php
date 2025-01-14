@extends('admin.layouts.master')
@section('title','States')
@section('maincontent')
<?php
$data['heading'] = 'States';
$data['title'] = 'States';
?>
@include('admin.layouts.topbar',$data)
 <div class="contentbar dashboard-card">                
    <!-- Start row -->
    <div class="row">
		 <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('Add States')}}</h5>
					<div>
						<div class="widgetbar">
							@can('locations.state.create')
							<a href=" {{url('admin/state/create')}}" class="btn btn-primary-rgba" title="{{ __('Add State') }}"><i class="feather icon-plus mr-2"></i>{{ __("Add State")}}</a>
							<button type="button"  class="btn btn-primary-rgba" data-toggle="modal" data-target="#exampleStandardModal" title="{{ __('Add State Manual') }}">
							  <i class="feather icon-plus mr-2"></i>{{ __("Add State Manual")}}</button>
						  @endcan							
						</div>                        
					  </div>
                </div>
                <div class="card-body">
                 
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
								<th> 
	                               #</th>
								<th>{{ __('State') }}</th>
								<th>{{ __('Country') }}</th>
								<th>{{ __('Delete') }}</th>
                            </tr>
                            </thead>
                            <tbody>
								<?php $i=0;?> 
								@foreach ($states as $state)
		
									<tr>
									  <?php $i++;?>
									  <td> 
										<?php echo $i;?></td>
									  <td>{{ $state->name }}</td>
									  <td>@if(isset($state->country)) {{ $state->country->nicename }} @endif</td>
                              <td>
                                <a href="page-product-detail.html" class="btn btn-danger-rgba"  data-toggle="modal" data-target=".bd-example-modal-sm"><i class="feather icon-delete"></i></a>
                                
                                <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                            </div>
                                            <div class="modal-footer">
												<form  method="post" action="{{url('admin/state/'.$state->id)}}" data-parsley-validate class="form-horizontal form-label-left">
													{{ csrf_field() }}
													{{ method_field('DELETE') }}
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
                                                <button type="submit" class="btn btn-primary" title="{{ __('Delete') }}">{{ __("Delete")}}</button>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
							@endforeach
						  </tr>
						  
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- End col -->
</div>
<!-- End row -->
</div>        
              
<!--Model for add city -->
<div class="modal fade" id="exampleStandardModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleStandardModalLabel">{{__('Add State')}}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			  <form id="demo-form2" method="post" action="{{route('state.manual')}}" data-parsley-validate class="form-horizontal form-label-left">
				  {{ csrf_field() }}
	
					<div class="row">
					  <div class="col-md-12">
						<label for="exampleInputDetails">{{ __('Choose State') }} :<sup class="redstar">*</sup></label>
						<select class="select2-single form-control" name="country_id">
							<option>{{ __('Choose Country') }}:</option>
							@foreach ($country as $cou)
							<option value="{{ $cou->country_id }}">{{ $cou->name }}</option>
						  @endforeach
						</select>
						 
					  </div>
					  </div>
					  <br>
	
					<div class="row">
						<div class="col-md-12">
						<label for="exampleInputDetails"> {{ __('State') }}:<sup class="redstar">*</sup></label>
						<input type="text" name="name" class="form-control" placeholder="{{ __('Enter State Name') }}">
					  </div>
					</div>
	
					<br>
				 
				
					<div class="form-group">
						<button type="reset" class="btn btn-danger mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
						<button type="submit" class="btn btn-primary" title="{{ __('Create') }}"><i class="fa fa-check-circle"></i>
						{{ __("Create")}}</button>
					</div>

				</form>
			</div>
		   
		</div>
	</div>
</div>
@endsection

                               
                              
                
                               
                              



