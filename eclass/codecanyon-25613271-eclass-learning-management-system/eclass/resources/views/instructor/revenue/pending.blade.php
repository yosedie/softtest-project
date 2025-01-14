@extends('admin.layouts.master')
@section('title', 'All Pending Payouts - Instructor')
@section('maincontent')
<?php
$data['heading'] = 'All Pending Payouts';
$data['title'] = 'All Pending Payouts';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">   
    @if ($errors->any())  
    <div class="alert alert-danger" role="alert">
    @foreach($errors->all() as $error)     
    <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true" style="color:red;">&times;</span></button></p>
        @endforeach  
    </div>
    @endif             
    <!-- Start row -->
    <div class="row">
      <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('All Pending Payouts')}}</h5>
                </div>
                <div class="card-body">
                 
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                              <th>#</th>
                              <th>{{ __('User') }}</th>
                              <th>{{ __('Course') }}</th>
                              <th>{{ __('TransactionId') }}</th>
                              <th>{{ __('TotalAmount') }}</th>
                              <th>{{ __('Delete') }}</th>
                           
                            </tr>
                            </thead>
                            <tbody>
                              <?php $i=0;?>
                            @foreach($payout as $pay)
                            <tr>
                              <?php $i++;?>
                              <td><?php echo $i;?></td>
                                <td>{{$pay->user->fname}}</td>
                                <td>{{$pay->courses->title}}</td>
                                <td>{{$pay->order->order_id}}</td>
                                <td><i class="fa {{$pay->currency_icon}}"></i>{{$pay->instructor_revenue}}</td> 
          
                              <td>

                              
                                        <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="feather icon-trash mr-2"></i>{{ __("Delete")}}</a>
                                      
                                   
                              </td>

                              <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-sm">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="exampleSmallModalLabel">{{__('Delete')}}</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                              <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                          </div>
                                          <div class="modal-footer">
                                            <form  method="post" action="{{url('instructoranswer/'.$pay->id)}}
                                              "data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
                                              <button type="submit" class="btn btn-primary">{{ __("Delete")}}</button>
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
                       
                                    
                                     
                                      
                                    
                                   
                              
                               
                                
    
              
                               
                              
                
                               
                              
