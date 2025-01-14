@extends('admin.layouts.master')
@section('title', 'List all Recordings - Admin')
@section('maincontent')
<?php
$data['heading'] = 'List all Recordings';
$data['title'] = 'List all Recordings';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">                
    <!-- Start row -->
    <div class="row">
		<div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('List all Recordings ')}}</h5>
                </div>
                <div class="card-body">
                 
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
								<th>
									#
								</th>
								<th>
									{{__('Meeting ID')}}
								</th>
								<th>
									{{__('Meeting Name')}} 
								</th>
								<th>
									{{__('Get Recording')}} 
								</th>
                            </tr>
                            </thead>
							<tbody>
								<?php $i=0;?>
				
								@if(isset($all_recordings['recording']))
								@foreach($all_recordings['recording'] as $meeting)
								<?php $i++;?>
									<tr>
										<td><?php echo $i;?></td>
										<td><b>{{ $meeting->meetingID }}</b></td>
										<td><b>{{ $meeting->name }}</b></td>
										
				
										<td>
				
											 <a href="{{ $meeting->playback->format->url }}" target="_blank" class="btn btn-primary">{{__('Play Recording')}} </a>
										</td>
										
										
				
				
									</tr>
								@endforeach
								@endif
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
