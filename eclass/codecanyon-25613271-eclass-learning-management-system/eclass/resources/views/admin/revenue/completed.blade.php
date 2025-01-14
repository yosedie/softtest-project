@extends('admin.layouts.master')
@section('title', 'All Completed - Admin')
@section('maincontent')
<?php
$data['heading'] = 'All Completed';
$data['title'] = 'All Completed';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">                
    <!-- Start row -->
    <div class="row">
       <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('All Completed')}}</h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                              <th>#</th>
                              <th>{{ __('User') }}</th>
                              <th>{{ __('Payer') }}</th>
                              <th>{{ __('PayTotal') }}</th>
                              <th>{{ __('OrderId') }}</th>
                              <th>{{ __('PayStatus') }}</th>
                              <th>{{ __('View') }}</th>
                           
                            </tr>
                            </thead>
                            <tbody>
                              <?php $i=0;?>
                                @foreach($payout as $pay)
                                <tr>
                                  <?php $i++;?>
                                    <td><?php echo $i;?></td>
                                    <td>{{$pay->user->fname}}</td>
                                    <td>{{$pay->payer_id}}</td>
                                    <td><i class="fa {{$pay->currency_icon}}"></i> {{$pay->pay_total}}</td>
                                    <td>
                                      @foreach($pay->order_id as $order)
                                        @php
                                            $id= App\Order::find($order);
                                        @endphp
                                        @if(isset($id->order_id)){{ $id['order_id'] }} @endif,
                                        
                                      @endforeach
                                    <td>
                                      @if($pay->pay_status ==1)
                                        {{ __('Recieved') }}
                                      @else
                                        {{ __('Pending') }}
                                      @endif
                                    </td>

                                    <td>
                                      <a class="btn btn-primary btn-sm" href="{{ route('completed.view', $pay->id) }}">{{ __('View') }}</a>
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
                                     
                                      
                                    
                                   
                              
                               
                                
    
              
                               
                              
                
                               
                              
