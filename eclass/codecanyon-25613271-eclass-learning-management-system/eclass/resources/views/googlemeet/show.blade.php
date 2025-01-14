@extends('admin/layouts.master')
@section('title', 'View Google Meet Meeting : '.$response['id'])
@section('maincontent')
<section class="content">
	<div class="box">
		
		<div class="box-header with-border">
			<div class="box-title" style="color:black">
					{{ __('View Meeting') }} : {{ $response['id'] }}
			</div>

			<div class="pull-right tools">
				<a title="Back" href="{{ route('zoom.index') }}" class="btn btn-sm btn-default">
					<i class="fa fa-reply"></i>
				</a>

				<a title="Edit Meeting" href="{{ route('zoom.edit',$response['id']) }}" class="btn btn-sm btn-success">
								<i class="fa fa-pencil" aria-hidden="true"></i>
				</a>

				<a title="Delete Meeting" data-toggle="modal" data-target="#delete{{ $response['id'] }}" class="btn btn-sm btn-primary">
								<i class="fa fa-trash-o"></i>
				</a>

				<a title="Start Meeting" target="_blank" href="{{ $response['start_url'] }}" class="btn btn-sm btn-success">
					<i class="fa fa-camera"></i>
				</a>
			</div>

			 <div id="delete{{ $response['id'] }}" class="delete-modal modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" title="{{ __('Close') }}">&times;</button>
                      <div class="delete-icon"></div>
                    </div>
                    <div class="modal-body text-center">
                      <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                      <p>{{ __('Do you really want to delete this meeting? This process cannot be undone') }}.</p>
                    </div>
                    <div class="modal-footer">
                   <form method="post" action="{{ route('zoom.delete',$response['id']) }}" class="pull-right">
                        {{csrf_field()}}
                        {{method_field("DELETE")}}
                                      
                    
                        <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">{{__('Yes')}}</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
		</div>

		<div class="box-body">
			<h3>{{__('Meeting ID')}} : {{ $response['id'] }}</h3>
			<hr>
			<h3>{{__('Meeting Type')}} :@if($response['type'] == '2') {{__('Scheduled Meeting')}} @elseif($response['type'] == '3') {{__('Recurring Meeting with no fixed time')}} @else {{__('Recurring Meeting with fixed time')}} @endif</h3>
			<hr>
			<h3>{{__('Meeting Topic')}} : {{ $response['topic'] }}</h3>
			<hr>
			<h3>{{__('Meeting Agenda')}} :{{ isset($response['agenda']) ? $response['agenda'] : "" }}</h3>
			<hr>
			<h3>{{__('Start Time')}} :{{ isset($response['start_time']) ? date('d-m-Y | h:i:s A',strtotime($response['start_time'])) : "" }}</h3>
			<hr>
			<h3>{{__('Meeting Contact Name ')}}: {{ isset($response['settings']['contact_name']) ? $response['settings']['contact_name'] : $response['host_email'] }}</h3>
			<hr>
			<h3>{{__('Invite URL')}} : <a href="{{ isset($response['join_url']) }}">{{ $response['join_url'] }}</a></h3>
			<hr>
			<h3>{{__('Meeting Duration')}} : {{ isset($response['duration']) ? $response['duration'] : "" }} {{__('min.')}}</h3>
			<hr>
			<h3>{{__('Other Meeting Settings')}} :</h3>
			<hr>
			<h5><i class="fa fa-microphone" aria-hidden="true"></i> {{__('Audio')}} : {{ isset($response['settings']['audio']) == 'both' ? "Computer and Internet call" : isset($response['settings']['audio']) }}</h5>
			<h5><i class="fa fa-camera" aria-hidden="true"></i> {{__('Host Video')}} : {{ isset($response['settings']['host_video']) == true ? "Enabled" : "Disabled"}}</h5>
			<h5><i class="fa fa-group" aria-hidden="true"></i> {{__('Join before Host')}} : {{ isset($response['settings']['join_before_host']) == true ? "Yes" : "No"}}</h5>
			<h5><i class="fa fa-group" aria-hidden="true"></i> {{__('Join before Host')}} : {{ isset($response['settings']['join_before_host']) == true ? "Yes" : "No"}}</h5>
			<h5><i class="fa fa-group" aria-hidden="true"></i> {{__('Participant Video')}} : {{ isset($response['settings']['participant_video']['join_before_host']) == true ? "Enabled" : "Disabled"}}</h5>
		</div>

		
	</div>
</section>
@endsection