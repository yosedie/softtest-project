@extends('admin.layouts.master')
@section('title',' Financial Reports')
@section('maincontent')
<?php
$data['heading'] = 'Financial Reports';
$data['title'] = 'Reports';
$data['title1'] = 'Financial Reports';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar"> 
    <div class="row">
        <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{__('Orders Total')}} </h5>
                </div>
                <div class="card-body">
                    <div id="apex-area-chart"></div>
                </div>
            </div>

        </div>
        <div class="col-lg-12 mb-5">
            <div class="card ">
                <div class="table-responsive  mt-2 mb-2">
                    <table id="datatable-buttons" class="table table-striped table-bordered mt-2 mb-2">
                        <thead>
                            <tr>
                                <th>{{ __('Months') }}</th>
                                <th>{{ __('Order Count') }}</th>
                                <th>{{ __('Total Amount') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order_data as $value)
                            <tr>
                                <td>{{ $value->month }}</td>
                                <td>{{ $value->count }}</td>
                                <td>{{ $value->total_amount }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    var order_total = @json($order_total);
    
    var options = {
        chart: {
            height: 300,
            type: 'area',
            toolbar: {
                show: false
            },
            zoom: {
              type: 'x',
              enabled: false,
              autoScaleYaxis: true
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
        },
        colors: ['#506fe4', '#43d187'],
        series: [{
            name: 'Orders total',
            data: order_total
        }],
        legend: {
            show: false,
        },
        xaxis: {
           
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                    'Dec'
                ],
            axisBorder: {
                show: true, 
                color: 'rgba(0,0,0,0.05)'
            },
            axisTicks: {
                show: true, 
                color: 'rgba(0,0,0,0.05)'
            }
        },
        grid: {
            row: {
                colors: ['transparent', 'transparent'], opacity: .2
            },
            borderColor: 'rgba(0,0,0,0.05)'
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        }
    }
    var chart = new ApexCharts(
        document.querySelector("#apex-area-chart"),
        options
    );
    chart.render();
</script>

@endsection
