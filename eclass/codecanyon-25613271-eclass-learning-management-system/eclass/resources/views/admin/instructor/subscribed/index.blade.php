@extends('admin.layouts.master')
@section('title', 'Subscribed Instructors - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Subscribed Instructors';
$data['title'] = 'Subscribed Instructors';
?>
@include('admin.layouts.topbar',$data)

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-bsubscrib">
                        <h3 class="box-title"> {{ __('Subscribed Instructors') }}</h3>
                       
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bsubscribed table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Instructor') }}</th>
                                        <th>{{ __('Plan') }}</th>
                                        <th>{{ __('TransactionId') }}</th>
                                        <th>{{ __('PaymentMethod') }}</th>
                                        <th>{{ __('TotalAmount') }}</th>
                                        <th>{{ __('View') }}</th>
                                        <th>{{ __('Delete') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($subscribed as $subscrib)
                                        <?php $i++; ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td>
                                               
                                                @if(isset($subscrib->user))
                                                {{ $subscrib->user['fname'] }} {{ $subscrib->user['lname'] }}
                                                @endif
                                                
                                            </td>
                                            <td>

                                                @if ($subscrib->plan_id != null)
                                                    {{ $subscrib->plans['title'] }}
                                                @else
                                                    {{ $subscrib->plans['title'] }}
                                                @endif
                                            </td>
                                            <td>{{ $subscrib->transaction_id }}</td>
                                            <td>{{ $subscrib->payment_method }}</td>

                                            <td>{{ $subscrib->total_amount }}</td>


                                            

                                            
                                            <td><a class="btn btn-primary btn-sm"
                                                    href="{{ url('orders/subscription', $subscrib->id) }}">{{ __('View') }}</a>
                                            </td>
                                            
                                            <td>
                                                <form method="post" action="{{ url('orders/subscription/' . $subscrib->id) }}"
                                                    data-parsley-validate class="form-horizontal form-label-left">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-danger btn-sm">
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
