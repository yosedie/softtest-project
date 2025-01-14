<div class="row">
    <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header all-user-card-header">
                  <h5 class="card-title">{{ __('All Refund Order') }}</h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                          <thead>
                          <tr>
                              <th>#</th>                  
                              <th>{{ __('User') }}</th>
                              <th>{{ __('Course') }}</th>
                              <th>{{ __('Order ID') }}</th>
                              <th>{{ __('Payment Method') }}</th>
                              <th>{{ __('Status') }}</th>
                              <th>{{ __('Action') }}</th>
                              
                          </tr>
                          </thead>
                          <tbody>
                            @foreach($refunds as $key=>$refund)
                          
                          <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $refund->user['fname'] }}</td>
                            <td>{{ $refund->courses->title }}</td>
                            <td>{{ $refund->order->order_id }}</td>
                            <td>{{ $refund->payment_method }}</td>
                            <td>
                               
                                @if($refund->status ==1)
                                {{ __('Refunded') }}
                                @else
                                {{ __('Pending') }}
                                @endif
                                 
                            </td>
                            <td>
                            <div class="dropdown">
                              <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings') }}"><i class="feather icon-more-vertical-"></i></button>
                              <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                  <a class="dropdown-item" href="{{url('refundorder/'.$refund->id.'/edit')}}" title="{{ __('View') }}"><i class="feather icon-eye mr-2"></i>{{ __('View') }}</a>
                                  <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $refund->id }}" title="{{ __('Delete') }}">
                                      <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                  </a>
                              </div>
                          </div>

                          <!-- delete Modal start -->
                          <div class="modal fade bd-example-modal-sm" id="delete{{$refund->id}}" tabindex="-1" role="dialog" aria-hidden="true">
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
                                          <form method="post" action="{{url('refundorder/'.$refund->id)}}" class="pull-right">
                                              {{csrf_field()}}
                                              {{method_field("DELETE")}}
                                              <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
                                              <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                          </div>
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