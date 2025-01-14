@extends('admin/layouts.master')
@section('title', 'All Order - Instructor')
@section('maincontent')
<?php
$data['heading'] = 'All Order';
$data['title'] = 'Order';
$data['title1'] = 'All Order';
?>
@include('admin.layouts.topbar',$data)
<section class="content">
  @include('admin.message')
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> {{ __('User') }} {{ __('Order') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                
                <br>
                <br>
                <tr>
                  <th>#</th>
                  <th>{{ __('User') }}</th>
                  <th>{{ __('Course') }}</th>
                  <th>{{ __('TransactionId') }}</th>
                  <th>{{ __('PaymentMethod') }}</th>
                  <th>{{ __('Currency') }}</th>
                  <th>{{ __('TotalAmount') }}</th>
                  <th>{{ __('View') }}</th>
                  <th>{{ __('Delete') }}</th>
                </tr>
              </thead>
              <tbody>
              <?php $i=0;?>
              @foreach($orders as $order)
                <?php $i++;?>
                <tr>
                  <td><?php echo $i;?></td>
                  <td>
                    @if(isset($order->user)) {{$order->user->fname}} {{$order->user->lname}} @endif
                  </td>                 
                  <td>@if(isset($order->courses)) {{$order->courses['title']}} @endif</td>
                  <td>{{$order->transaction_id}}</td>
                  <td>{{$order->payment_method}}</td>
                  <td>{{$order->currency}}</td>

                  @if($order->coupon_discount == !NULL)
                    <td><i class="{{ $order->currency_icon }}"></i>{{ $order->total_amount - $order->coupon_discount }}</td>
                  @else
                    <td><i class="fa {{ $order->currency_icon }}"></i>{{ $order->total_amount }}</td>
                  @endif

                  <td><a class="btn btn-primary btn-sm" href="{{route('view.order',$order->id)}}">{{ __('View') }}</a>
                  </td>
                  
                  <td>
                    <form  method="post" action="{{url('order/'.$order->id)}}"
                        data-parsley-validate class="form-horizontal form-label-left">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                      <button type="submit" class="btn btn-danger">
                            <i class="fa fa-fw fa-trash-o"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach 
            </table>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
@endsection
