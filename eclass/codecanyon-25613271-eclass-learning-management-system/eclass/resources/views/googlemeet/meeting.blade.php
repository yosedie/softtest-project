
@extends('admin.layouts.master')
@section('title', 'All Meetings- Admin')
@section('maincontent')
<?php
$data['heading'] = 'Google Meetings';
$data['title'] = 'Meetings';
$data['title1'] = 'Google Meetings';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">                
  <!-- Start row -->
  <div class="row">
    <div class="col-lg-12">
          <div class="card dashboard-card m-b-30">
              <div class="card-header">
                  <h5 class="box-title">{{ __('All Google Meetings')}}</h5>
              </div>
              <div class="card-body">
               
                  <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                          <tr>
                            <th>#</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Meeting') }}</th>
                            <th>{{ __('Join Meeting') }}</th>
                            <th>{{ __('Delete') }}</th>
                          </tr>
                          </thead>
                          <tbody>
                            <?php $i=0;?>
                            @foreach($allgooglemeet as $meeting)
                            <?php $i++;?>
                            <tr>
                              <td><?php echo $i;?></td>
                            
                              <td>{{$meeting->user['fname']}}</td>

                              <td>
                                <p><b>{{ __('Meeting ID') }}:</b> {{ $meeting['meeting_id'] }}</p>
                                <p><b>{{ __('Owner ID') }}:</b> {{ $meeting['owner_id'] }}</p>
                                <p><b>{{ __('Meeting Topic') }}:</b> {{ $meeting['meeting_title'] }}</p>
                                <p><b>{{ __('Time') }}:</b> {{ date('d-m-Y | h:i:s A',strtotime($meeting['start_time'])) }}</p>

                                @if(isset($meeting->course_id))

                                <p><b>{{ __('Meeting on Course') }}:</b> {{ $meeting->courses['title'] }}</p>

                                @endif

                              </td>

                              <td>
                            <a href="{{ $meeting['meet_url'] }}" target="_blank" class="btn btn-primary-rgba" title="{{ __('Join Meeting') }}">{{ __('Join Meeting') }}</a>
                          </td>

                            <td>
                              <a href="page-product-detail.html" class="btn btn-danger-rgba"  data-toggle="modal" data-target=".bd-example-modal-sm" title="{{ __('Delete') }}"><i class="feather icon-trash"></i></a>
                              
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
                                            <form  method="post" action="{{ route('googlemeet.delete',$meeting['meeting_id']) }}
                                            "data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal" title="{{ __('Close') }}">{{ __("Close")}}</button>
                                              <button type="submit" class="btn btn-primary">{{ __("Delete")}}</button>
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



@endsection
