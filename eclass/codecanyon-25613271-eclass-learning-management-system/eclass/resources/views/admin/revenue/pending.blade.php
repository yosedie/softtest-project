@extends('admin.layouts.master')
@section('title', 'All Pending Payout - Instructor')
@section('maincontent')
<?php
$data['heading'] = 'All Pending Payout';
$data['title'] = 'All Pending Payout';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">                
    <!-- Start row -->
    <div class="row">
      <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('Pending Payout')}}</h5>
                    <div>
                      <div class="widgetbar">
                    @can(' instructor-pending-payout.manage')
                        <button type="button" class="float-right btn btn-danger-rgba mr-2" data-toggle="modal" data-target="#bulk_delete"><i class="feather icon-trash mr-2"></i> {{ __('PaySelected') }}</button>
                    @endcan
                      </div>
                    <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
                        <div class="modal-dialog modal-sm">
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <div class="delete-icon"></div>
                            </div>
                            <div class="modal-body text-center">
                              <h4 class="modal-heading">{{ __('AreYouSure') }}</h4>
                              <p>{{ __('Do you really want to pay to selected payouts ? This process
                                                                        cannot be undone') }}.</p>
                            </div>
                            <div class="modal-footer text-center">
                    
                              <form  method="post" action="{{ action('AdminPayoutController@bulk_payout', $id) }}" id="bulk_delete_form" data-parsley-validate class="form-horizontal form-label-left">
                              {{ csrf_field() }}
                    
                                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __('No') }}</button>
                               
                                <input type="submit" value="Yes"  class="btn btn-sm btn-danger"/>
                              </form>
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
                              <th>{{ __('User') }}</th>
                              <th>{{ __('Course') }}</th>
                              <th>{{ __('OrderId') }}</th>
                              <th>{{ __('PayoutDeatil') }}</th>
                           
                            </tr>
                            </thead>
                            <tbody>
                              <?php $i=0;?>
                              @foreach($payout as $pay)
                              <tr>
                                <?php $i++;?>
                                <td>
                                    <div class="inline">
                                      <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$pay->id}}" id="checkbox{{$pay->id}}">
                                      <label for="checkbox{{$pay->id}}" class="material-checkbox"></label>
                                    </div>
                                    <?php echo $i;?>
                                  </td>
                               
                                  <td>@if(isset($pay->user)){{$pay->user->fname}}@endif</td>
                                  <td>@if(isset($pay->courses)){{$pay->courses->title}}@endif</td>
                                  <td>@if(isset($pay->order)){{$pay->order->order_id}}@endif</td> 
                                  <td>
                                    <b>{{ __('TotalAmount') }}</b>: <i class="fa {{$pay->currency_icon}}"></i>{{$pay->total_amount}}
                                    <br>
                      
                                    <b>{{ __('InstructorRevenue') }}</b>: <i class="fa {{$pay->currency_icon}}"></i> {{$pay->instructor_revenue}}
                                  </td>
                                
                      
                                
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
                       
  
@section('script')
<script>
  $(function(){
    $('#checkboxAll').on('change', function(){
      if($(this).prop("checked") == true){
        $('.material-checkbox-input').attr('checked', true);
      }
      else if($(this).prop("checked") == false){
        $('.material-checkbox-input').attr('checked', false);
      }
    });
  });
</script>

<script>
  $(function() {
    $('#cb3').change(function() {
      $('#status').val(+ $(this).prop('checked'))
    })
  })
</script>


@endsection                                  
                                     
                                      
                                    
                                   
                              
                               
                                
    
              
                               
                              
                
                               
                              
