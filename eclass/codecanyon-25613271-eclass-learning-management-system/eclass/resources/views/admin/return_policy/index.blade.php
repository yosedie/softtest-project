@extends('admin.layouts.master')
@section('title','All Returnpolicy')
@section('maincontent')
<?php
$data['heading'] = 'All Refund Policies';
$data['title'] = 'Courses';
$data['title1'] = 'Refund Policies';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar"> 
  <div class="row">
      <div class="col-lg-12">
          <div class="card dashboard-card m-b-30">
              <div class="card-header">
                  <h5 class="box-title">{{ __('All Refund Policies') }} </h5>
                  <div>
                    <div class="widgetbar">
                        @can('refund-policy.delete')
                        <button type="button" class="float-right btn btn-danger-rgba mr-2 " data-toggle="modal" data-target="#bulk_delete" title="{{ __('Delete Selected') }}"><i
                            class="feather icon-trash mr-2"></i> {{ __('Delete Selected') }}</button>
                            @endcan
                            @can('refund-policy.create')
                        <a href="{{url('refundpolicy/create')}}" class="float-right btn btn-primary-rgba mr-2" title="{{ __('Add Refund Policy') }}"><i class="feather icon-plus mr-2"></i>{{ __('Add Refund Policy') }} </a>
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
                                  <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                                  value="all" />
                              <label for="checkboxAll" class="material-checkbox"></label>   # 
                              </th>
                              <th>{{ __('Name') }}</th>
                              <th>{{ __('Days') }}</th>
                              <th>{{ __('Status') }}</th>
                              <th>{{ __('Action') }}</th>
                              
                            </tr>
                            </thead>
              <tbody>
                @foreach($return as $key=>$policy)
              <tr>
                <td>
                                                     
                  <input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input'
                      name='checked[]' value='{{ $policy->id }}' id='checkbox{{ $policy->id }}'>
                  <label for='checkbox{{ $policy->id }}' class='material-checkbox'></label>
                  {{ $key+1 }}
              <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
                  <div class="modal-dialog modal-sm">
                      <!-- Modal content-->
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" title="{{ __('Close') }}">&times;</button>
                              <div class="delete-icon"></div>
                          </div>
                          <div class="modal-body text-center">
                              <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                              <p>{{ __('Do you really want to delete selected item names here? This process
                                  cannot be undone') }}.</p>
                          </div>
                          <div class="modal-footer">
                              <form id="bulk_delete_form" method="post"
                                  action="{{ route('refundpolicybulk.bulk_delete') }}">
                                  @csrf
                                  @method('POST')
                                  <button type="reset" class="btn btn-gray translate-y-3"
                                      data-dismiss="modal">{{ __('No') }}</button>
                                  <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                              </form>
                          </div>
                      </div>
                  </div>
              </div></td>
              <td>{{ $policy->name }}</td>
              <td>{{ $policy->days }}</td>
              <td>
                <label class="switch">
                  <input class="refund" type="checkbox"  data-id="{{$policy->id}}" name="status"    {{ $policy->status ==1 ? 'checked' : ''}}>
                  <span class="knob"></span>
                </label>
                </td>
              
              
              <td>
                <div class="dropdown">
                    <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings') }}"><i class="feather icon-more-vertical-"></i></button>
                    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                        @can('refund-policy.edit')
                        <a class="dropdown-item" href="{{url('refundpolicy/'.$policy->id.'/edit')}}" title="{{ __('Edit') }}"><i class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                        @endcan
                        @can('refund-policy.delete')
                        <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $policy->id }}"  title="{{ __('Delete') }}">
                            <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                            @endcan
                        </a>
                    </div>
                </div>

                <!-- delete Modal start -->
                <div class="modal fade bd-example-modal-sm" id="delete{{$policy->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <h4>{{ __('Are You Sure ?')}}</h4>
                                    <p>{{ __('Do you really want to delete')}} ? {{ __('This process cannot be undone.')}}</p>
                            </div>
                            <div class="modal-footer">
                                <form method="post" action="{{url('refundpolicy/'.$policy->id)}}}" class="pull-right">
                                    {{csrf_field()}}
                                    {{method_field("DELETE")}}
                                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
                                    <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
              </td>              

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
@section('script')
<script>
    $("#checkboxAll").on('click', function () {
$('input.check').not(this).prop('checked', this.checked);
});
</script>


<script>

"use Strict";

$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
$(document).on("change",".refund",function() {
        
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '{{url("refundpolicystatus/status")}}',
            data: {'status': $(this).is(':checked') ? 1 : 0, 'id': $(this).data('id')},
            success: function(data){
                var warning = new PNotify( {
                title: 'success', text:'Status Update Successfully', type: 'success', desktop: {
                desktop: true, icon: 'feather icon-thumbs-down'
                }
            });
                warning.get().click(function() {
                    warning.remove();
                });
            }
        });
    })

  
  </script>
@endsection
