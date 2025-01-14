@extends('admin.layouts.master')
@section('title', 'All paid Payout - Instructor')
@section('maincontent')
<?php
$data['heading'] = 'All paid Payout';
$data['title'] = 'All paid Payout';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">                
    <!-- Start row -->
    <div class="row">
      <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('All paid Payout')}}</h5>
                </div>
                <div class="card-body">
                 
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                              <th>
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
                                    
                                    <?php echo $i;?>
                                  </td>
                               
                                  <td>@if(isset($pay->user)){{$pay->user->fname}}@endif</td>
                                  <td>@if(isset($pay->courses)){{$pay->courses->title}}@endif</td>
                                  <td>>@if(isset($pay->order)){{$pay->order->order_id}}@endif</td> 
                                  <td>
                                    <b>{{ __('TotalAmount') }}</b>: <i class="fa {{$pay->currency_icon}}"></i>{{$pay->total_amount}}
                                    <br>
                      
                                    <b>{{ __('InstructorRevenue') }}</b>: <i class="fa {{$pay->currency_icon}}"></i> {{$pay->instructor_revenue}}
                                  </td>
                                
                      
                              </tr>
                              @endforeach
                              
                              </tfoot>
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
                               
                                     
                                      
                                    
                                   
                              
                               
                                
    
              
                               
                              
                
                               
                              
