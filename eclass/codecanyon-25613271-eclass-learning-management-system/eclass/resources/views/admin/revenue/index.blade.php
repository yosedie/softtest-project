@extends('admin.layouts.master')
@section('title', 'Payout - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Instructors Payout';
$data['title'] = 'Instructors';
$data['title1'] = 'Instructors Payout';
$data['title2'] = 'Payout';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">                
  <!-- Start row -->
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header all-user-card-header">
          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true" title="{{ __('Pending Payout') }}">{{ __('Pending Payout') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false" title="{{ __('Completed Payout') }}">{{ __('Completed Payout') }}</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>{{ __('Instructor') }}</th>
                        <th>{{ __('View') }}</th>
                    
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=0;?>
                      @foreach($users as $user)
                      <tr>
                        <?php $i++;?>
                          <td><?php echo $i;?></td>
                          <td>{{$user->fname}}</td>
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings') }}"><i class="feather icon-more-vertical-"></i></button>
                              <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                <a class="dropdown-item"  href="{{ route('admin.pending', $user->id) }}" title="{{ __('Pending Payout') }}"><i class="feather icon-eye mr-2"></i>{{ __('Pending Payout') }}</a>
                                <a class="dropdown-item"  href="{{ route('admin.paid', $user->id) }}" title="{{ __('Complete Payout') }}"><i class="feather icon-eye mr-2"></i>{{ __('Complete Payout') }}</a>
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
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Payer') }}</th>
                        <th>{{ __('Pay Total') }}</th>
                        <th>{{ __('Order Id') }}</th>
                        <th>{{ __('Pay Status') }}</th>
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
                              <a class="btn btn-primary btn-sm" href="{{ route('completed.view', $pay->id) }}" title="{{ __('View') }}">{{ __('View') }}</a>
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
      <!-- End col -->
  </div>
  <!-- End row -->
</div>        
@endsection                            