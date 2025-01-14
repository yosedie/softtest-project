<div class="row">
    <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header all-user-card-header">
                    <h5 class="box-title">{{ __('All Orders') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Payment Details') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Subscription Status') }}</th>
                                    <th>{{ __('Declined') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($orders as $order)
                                <?php $i++; ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <p><b>{{ __('User') }}</b>:
                                            @if(Auth::user()->role == 'admin')
                                            @if(isset($order->user))
                                            {{ $order->user['fname'] }} {{ $order->user['lname'] }}
                                            {{ $order->user['email'] }}
                                            @endif
                                            @else
                                            @if ($gsetting->hide_identity == 0)
                                            @if(isset($order->user))
                                            {{ $order->user['fname'] }} {{ $order->user['lname'] }}
                                            {{ $order->user['email'] }}
                                            @endif
                                            @else
                                            {{ __('Hidden') }}
                                            @endif
                                            @endif
                                        </p>
                                        <p><b>{{ __('Course') }}</b>:
                                            @if ($order->course_id != null)
                                            {{ optional($order->courses)['title'] }}
                                            @else
                                            {{ optional($order->bundle)['title'] }}
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        <p><b>{{ __('TransactionId') }}</b>:
                                            {{ $order->transaction_id }}</p>
                                        <p><b>{{ __('PaymentMethod') }}</b>:
                                            {{ $order->payment_method }}</p>

                                        @php
                                            $contains = Illuminate\Support\Str::contains($order->currency_icon, 'fa');
                                        @endphp

                                        <p><b>{{ __('TotalAmount') }}</b>:

                                            @if ($order->coupon_discount == !null)

                                            @if($contains)

                                                <i class="{{ $order->currency_icon }}"></i>{{ $order->total_amount - $order->coupon_discount }}

                                                @if ($order->subscription_id !== null)
                                                / {{ $order->bundle->billing_interval }}
                                                @endif

                                            @else
                                            {{ $order->currency_icon }} {{ $order->total_amount - $order->coupon_discount }}

                                                @if ($order->subscription_id !== null)
                                                / {{ $order->bundle->billing_interval }}
                                                @endif


                                            @endif



                                            @else

                                            @if($contains)

                                                <i class="fa {{ $order->currency_icon }}"></i>{{ $order->total_amount }}
                                                @if ($order->subscription_id !== null)
                                                / {{ $order->bundle->billing_interval }}
                                                @endif

                                            @else

                                                {{ $order->currency_icon }}

                                                {{ $order->total_amount }}
                                                @if ($order->subscription_id !== null)
                                                / {{ $order->bundle->billing_interval }}
                                                @endif

                                            @endif


                                            @endif
                                        </p>

                                    </td>

                                    <td>
                                        

                                        <label class="switch">
                                        <input class="orders" type="checkbox"  data-id="{{$order->id}}" name="status" {{ $order->status == '1' ? 'checked' : '' }}>
                                        <span class="knob"></span>
                                      </label>

                                    </td>

                                    <td>
                                        @if ($order->bundle_id != null)
                                        @if ($order->subscription_status == 'active')
                                        {{ __('Active') }}
                                        @else
                                        {{ __('Canceled') }}
                                        @endif
                                        @else
                                        -
                                        @endif
                                    </td>

                                    <td>
                                        @if ($order->subscription_status === 'active')
                                        <form method="post"
                                            action="{{ route('stripe.cancelsubscription', ['order_id' => $order->id, 'redirect_to' => '/order']) }}"
                                            data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-xs" title="{{ __('Declined') }}">
                                                <i class="fa fa-fw fa-close"></i>
                                                {{ __('Declined') }}
                                            </button>
                                        </form>
                                        @else
                                        -
                                        @endif

                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-round btn-outline-primary" type="button"
                                                id="CustomdropdownMenuButton1" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false" title="{{ __('Settings') }}"><i
                                                    class="feather icon-more-vertical-"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                                <a class="dropdown-item" href="{{ route('view.order', $order->id) }}" title="{{ __('View Order') }}"><i
                                                        class="feather icon-eye mr-2"></i>{{ __('View Order') }}</a>
                                                <a class="dropdown-item btn btn-link" data-toggle="modal"
                                                    data-target="#delete{{ $order->id }}" title="{{ __('Delete') }}">
                                                    <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- delete Modal start -->
                                        <div class="modal fade bd-example-modal-sm" id="delete{{$order->id}}"
                                            tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close" title="{{ __('Close') }}">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4>{{ __('Are You Sure ?')}}</h4>
                                                        <p>{{ __('Do you really want to delete')}} ?
                                                            {{ __('This process cannot be undone.')}}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="post" action="{{ url('order/' . $order->id) }}"
                                                            class="pull-right">
                                                            {{csrf_field()}}
                                                            {{method_field("DELETE")}}
                                                            <button type="reset" class="btn btn-secondary"
                                                                data-dismiss="modal">{{ __('No') }}</button>
                                                            <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- delete Model ended -->

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


@section('script')
<script>
  $(function() {
    $(document).on("change",".orders",function() {
        
        $.ajax({
            type: "GET",
            dataType: "json",
            url: 'order-status',
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
   });
</script>
@endsection