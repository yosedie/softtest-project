@extends('admin.layouts.master')
@section('title', 'List all meetings- Admin')
@section('maincontent')
<?php
$data['heading'] = 'List all meetings';
$data['title'] = 'List all meetings';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">                
    <!-- Start row -->
    <div class="row">
		 <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('List all meetings')}}</h5>
					<div>
						<div class="widgetbar">
							<a href="{{ route('bbl.create') }}" class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>{{ __("Add")}}</a>
							<a href="page-product-detail.html" class="btn btn-danger-rgba"  data-toggle="modal" data-target=".bd-example-modal-sm1"><i class="feather icon-trash mr-2"></i>{{__('Delete Selected')}}</a>
													  
							<div class="modal fade bd-example-modal-sm1" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleSmallModalLabel">{{__('Delete')}}</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body text-center">
											<p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
										</div>
										<div class="modal-footer">
										  <form method="post" action="{{ action('BulkdeleteController@bblmeetingdeleteAll') }}
										  " id="bulk_delete_form" data-parsley-validate class="form-horizontal form-label-left">
										  {{ csrf_field() }}
										  
											<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("No")}}</button>
											<button type="submit" class="btn btn-danger">{{ __("Yes")}}</button>
										</form>
										</div>
									</div>
								</div>
							</div>
					  
					  
						</div>                        
					  </div>
				</div>
                <div class="card-body">
                 
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
								<th>
									
								<input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" id="checkboxAll">
								<label for="checkboxAll" class="material-checkbox"></label> 
								#
								</th>
								<th>
									{{ __('MeetingID') }}
								</th>
								<th>
									 {{ __('Meeting') }} {{ __('Detail') }}
								</th>
								<th>
									{{ __('Password') }}
								</th>
								<th>
									{{ __('Action') }}
								</th>
                            </tr>
                            </thead>
                            <tbody>
								@foreach($meetings as $key=> $meeting)
									<tr>
										<td><input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$meeting->id}}" id="checkbox{{$meeting->id}}">
											<label for="checkbox{{$meeting->id}}" class="material-checkbox"></label>
											{{ $key+1 }}</td>
										<td><b>{{ $meeting->meetingid }}</b></td>
										<td>
											<p><b>{{ __('Meeting') }} {{ __('Name') }} :</b> {{ $meeting->meetingname }}</p>
											<p><b>{{ __('Meeting') }}  Participant:</b> {{ $meeting->setMaxParticipants == -1 ? "Unlimited" : $meeting->setMaxParticipants }}</p>
											<p><b>{{ __('Duration') }}:</b> {{ $meeting->duration }}min</p>
											<p><b>{{__('Welcome Message:')}}</b> {{ $meeting->welcomemsg == '' ? "Not set" : $meeting->welcomemsg }}</p>
											<p><b>{{__('Mute on start:')}}</b> {{ $meeting->setMuteOnStart == 1 ? "Yes" : "No" }}</p>
											@if($meeting->link_by == 'course')
											<p><b>{{__('Link on course:')}}</b> {{ $meeting->course['title'] ?? '-' }}</p>
											@endif
											<p><b>{{__('Start Time:')}}</b> {{ date('d-m-Y | h:i:s A',strtotime($meeting['start_time'])) }}</p>
										</td>
										<td>
											<p><b>{{__('Moderator')}} {{ __('Password') }}:</b> {{ $meeting->modpw }}</p>
											<p><b>{{__('Attendee')}} {{ __('Password') }}:</b> {{ $meeting->attendeepw }}</p>
										</td>

										<td>
											<div class="dropdown">
												<button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
												<div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
													<a class="dropdown-item" href="{{ route('bbl.edit',$meeting->id) }}" ><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
													<a href="page-product-detail.html"  class="dropdown-item"  data-toggle="modal" data-target=".bd-example-modal-sm"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
													<a class="dropdown-item"href="{{ route('api.create.meeting',$meeting->id) }}"><i class="feather icon-eye mr-2"></i>{{ __("View")}}</a>
													
												</div>
											</div>
										</td>
								
			                          	{{-- Delete Model --}}
										<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
											<div class="modal-dialog modal-sm">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleSmallModalLabel">{{ __("Delete")}}</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
													</div>
													<div class="modal-footer">
														<form method="post" action="{{ route('bbl.delete',$meeting['id']) }}" class="pull-right">
															{{csrf_field()}}
															{{method_field("DELETE")}}
														<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("No")}}</button>
														<button type="submit" class="btn btn-danger">{{ __("Yes")}}</button>
													</form>
													</div>
												</div>
											</div>
										</div>
				
				
									</tr>
								@endforeach
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


@endsection
