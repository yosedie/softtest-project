@extends('admin.layouts.master')
@section('title', 'Manual Payment Gateway - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Manual Payment Gateway';
$data['title'] = 'Manual Payment Gateway';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
    <div class="row">
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $error)
            <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="color:red;">&times;</span></button></p>
            @endforeach
        </div>
        @endif

        <!-- row started -->
        <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Manual Payment Gateway') }}</h5>
                    <div>
                        <div class="widgetbar">
                            @can('payment-setting.manual-payment.delete')
                            <button type="button" class="float-right btn btn-danger-rgba mr-2" data-toggle="modal"
                                data-target="#bulk_delete"><i class="feather icon-trash mr-2"></i> {{ __('Delete Selected') }}</button>
                                @endcan
                                @can('payment-setting.manual-payment.create')
                                <a href="{{url('manualpayment/create')}}" class="float-right btn btn-primary-rgba mr-2"><i
                                    class="feather icon-plus mr-2"></i>{{ __('Add') }}</a>
                                    @endcan
                        </div>
                    </div>
                </div>

                <!-- card body started -->
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- table to display payment start -->
                        <table id="datatable-buttons" class="table table-borderd">
                            <thead>
                                <th>
                                    <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                                        value="all" />
                                    <label for="checkboxAll" class="material-checkbox"></label> #
                                </th>
                                <th>{{ __('Payment Gateway Name') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </thead>

                            <tbody>
                                <?php $i=0;?>
                                @foreach($payments as $payment)
                                <?php $i++;?>
                                <tr>
                                    <td>
                                        <input type='checkbox' form='bulk_delete_form'
                                            class='check filled-in material-checkbox-input' name='checked[]'
                                            value='{{ $payment->id }}' id='checkbox{{ $payment->id }}'>
                                        <label for='checkbox{{ $payment->id }}' class='material-checkbox'></label>
                                        <?php echo $i; ?>
                                        <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
                                            <div class="modal-dialog modal-sm">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                        <div class="delete-icon"></div>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                                                        <p>{{ __('Do you really want to delete selected item ? This process
                                                    cannot be undone') }}.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form id="bulk_delete_form" method="post"
                                                            action="{{ route('manualpayment.bulk.delete') }}">
                                                            @csrf
                                                            @method('POST')
                                                            <button type="reset" class="btn btn-gray translate-y-3"
                                                                data-dismiss="modal">{{ __('No') }}</button>
                                                            <button type="submit"
                                                                class="btn btn-danger">{{ __('Yes') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$payment->name}}</td>
                                    <td>
                                        <label class="switch">
                                            <input class="manual" type="checkbox" data-id="{{$payment->id}}"
                                                name="status" {{ $payment->status == '1' ? 'checked' : '' }}>
                                            <span class="knob"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-round btn-outline-primary" type="button"
                                                id="CustomdropdownMenuButton1" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"><i
                                                    class="feather icon-more-vertical-"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                                @can('payment-setting.manual-payment.edit')
                                                <a class="dropdown-item"
                                                    href="{{url('manualpayment/'.$payment->id)}}"><i
                                                        class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                                                        @endcan
                                                        @can('payment-setting.manual-payment.delete')
                                                <a class="dropdown-item btn btn-link" data-toggle="modal"
                                                    data-target="#delete{{ $payment->id }}">
                                                    <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                                </a>
                                                @endcan
                                            </div>
                                        </div>

                                        <!-- delete Modal start -->
                                        <div class="modal fade bd-example-modal-sm" id="delete{{ $payment->id }}"
                                            tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleSmallModalLabel">
                                                            {{ __('Delete') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4>{{ __('Are You Sure ?')}}</h4>
                                                        <p>{{ __('Do you really want to delete')}}
                                                            <b>{{$payment->name}}</b> ?
                                                            {{ __('This process cannot be undone.')}}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="post"
                                                            action="{{url('manualpayment/'.$payment->id)}}"
                                                            class="pull-right">
                                                            {{csrf_field()}}
                                                            {{method_field("DELETE")}}
                                                            <button type="reset" class="btn btn-secondary"
                                                                data-dismiss="modal">{{ __('No') }}</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">{{ __('Yes') }}</button>
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
                        <!-- table to display payment data end -->
                    </div><!-- table-responsive div end -->

                </div><!-- card body end -->

            </div><!-- col end -->
        </div>
    </div>
</div><!-- row end -->
<br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain javacsript start -->
@section('script')
<!-- script to change status start -->
<script>
    $(document).on("change", ".manual", function () {


        $.ajax({
            type: "GET",
            dataType: "json",
            url: 'manualpayment-status',
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
<!-- script to change status end -->
<script>
    $("#checkboxAll").on('click', function () {
        $('input.check').not(this).prop('checked', this.checked);
    });
</script>
@endsection
<!-- This section will contain javacsript end -->