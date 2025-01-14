@extends('admin.layouts.master')
@section('title', 'Instructor Dashboard - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Instructor Dashboard';
$data['title'] = 'Instructor Dashboard';
?>
@include('admin.layouts.topbar',$data)
@if(Auth::User()->role == "instructor")
<div class="contentbar bardashboard-card">
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-md-3">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">

                                <div class="col-7">
                                    <h4>@php
                                        $course = App\Course::where('user_id', Auth::User()->id)->get();
                                        if(count($course)>0){

                                        echo count($course);
                                        }
                                        else{

                                        echo "0";
                                        }
                                        @endphp</h4>
                                    <p class="font-14 mb-0">{{__('Courses')}}</p>
                                </div>
                                <div class="col-5 text-right">
                                    <a href="{{url('course')}}">
                                        <div><i class="text-success feather icon-book-open" style="font-size:45px;"></i></div>
                                    </a>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <h4> @php
                                        $cat = App\Order::where('instructor_id', Auth::User()->id)->get();
                                        if(count($cat)>0){

                                        echo count($cat);
                                        }
                                        else{

                                        echo "0";
                                        }
                                        @endphp
                                    </h4>
                                    <p class="font-14 mb-0">{{__('User Enrolled')}}</p>
                                </div>
                                <div class="col-5 text-right">
                                    <a href="{{url('userenroll')}}">
                                        <div><i class="text-warning feather icon-users" style="font-size:45px;"></i></div>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <h4>@php
                                        $question = App\Question::where('instructor_id', Auth::User()->id)->get();
                                        if(count($question)>0){

                                        echo count($question);
                                        }
                                        else{

                                        echo "0";
                                        }
                                        @endphp</h4>
                                    <p class="font-14 mb-0">{{__('Total Question')}}</p>
                                </div>
                                <div class="col-5 text-right">
                                    <a href="{{url('instructorquestion')}}">
                                        <div><i class="text-info feather icon-file-plus" style="font-size:45px;"></i></div>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <h4> @php
                                        $answer = App\Answer::all();


                                        if(count($answer)>0){

                                        echo count($answer);
                                        }
                                        else{

                                        echo "0";
                                        }
                                        @endphp</h4>
                                    <p class="font-14 mb-0">{{__('Total Answer')}}</p>
                                </div>
                                <div class="col-5 text-right">
                                    <a href="{{url('instructoranswer')}}">
                                        <div><i class=" text-secondary feather icon-x-square" style="font-size:45px;"></i></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <h4>@php
                                        $answer = App\Course::where('user_id', Auth::User()->id)->where('status',
                                        '1')->where('featured', '1')->get();
                                        if(count($answer)>0){

                                        echo count($answer);
                                        }
                                        else{

                                        echo "0";
                                        }
                                        @endphp</h4>
                                    <p class="font-14 mb-0">{{__('Featured Courses')}}</p>
                                </div>
                                <div class="col-5 text-right">
                                    <a href="{{url('featurecourse')}}">
                                        <div><i class=" text-danger feather icon-user-plus" style="font-size:45px;"></i></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <h4> @php
                                        $answer = App\Blog::where('user_id', Auth::User()->id)->where('status',
                                        '1')->get();
                                        if(count($answer)>0){

                                        echo count($answer);
                                        }
                                        else{

                                        echo "0";
                                        }
                                        @endphp</h4>
                                    <p class="font-14 mb-0">{{__('Blog')}}</p>
                                </div>
                                <div class="col-5 text-right">
                                    <a href="{{url('blog')}}">
                                        <div><i class="text-success feather icon-book-open" style="font-size:45px;"></i></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($zoom_enable) && $zoom_enable == 1)
                <div class="col-md-3">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <h4>@php
                                        $answer = App\Meeting::where('user_id', Auth::User()->id)->get();
                                        if(count($answer)>0){

                                        echo count($answer);
                                        }
                                        else{

                                        echo "0";
                                        }
                                        @endphp</h4>
                                    <p class="font-14 mb-0">{{__('Zoom Meeting')}}</p>
                                </div>
                                <div class="col-5 text-right">
                                    <a href="{{route('zoom.index')}}">
                                        <div><i class="text-info feather icon-video" style="font-size:45px;"></i></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif


                @if(isset($gsetting) && $gsetting->bbl_enable == 1)
                <div class="col-md-3">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <h4> @php
                                        $answer = App\BBL::where('instructor_id', Auth::User()->id)->where('is_ended',
                                        '0')->get();
                                        if(count($answer)>0){

                                        echo count($answer);
                                        }
                                        else{

                                        echo "0";
                                        }
                                        @endphp</h4>
                                    <p class="font-14 mb-0">{{__('Big Blue Meeting')}}</p>
                                </div>
                                <div class="col-5 text-right">
                                    <a href="{{route('bbl.all.meeting')}}">
                                        <div><i class="feather icon-mic" style="font-size:45px;"></i></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>


        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{__('Total Orders in 2021')}}</h5>
                </div>
                <div class="card-body">
                    <div id="apex-area-chart">

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card m-b-30 ">
                <div class="card-header">
                    <h5 class="card-title">{{__('Monthly Instructor Payout')}}</h5>
                </div>
                <div class="card-body">
                    <canvas height='200' id="chartjs-bar-chart" class="chartjs-chart"></canvas>
                </div>
            </div>
        </div>







    </div>
</div>
</div>




@endif

@endsection


@section('script')
<script>
    var datas = @json($datas);
    "use strict";
    $(document).ready(function () {
        var barChartID = document.getElementById("chartjs-bar-chart").getContext('2d');
        var barChart = new Chart(barChartID, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                    'Dec'
                ],
                datasets: [{
                    label: 'Users',
                    backgroundColor: ["#506fe4", "#506fe4", "#506fe4", "#506fe4", "#506fe4",
                        "#506fe4", "#506fe4", "#506fe4", "#506fe4", "#506fe4", "#506fe4",
                        "#506fe4", "#506fe4"
                    ],
                    borderColor: ["#506fe4", "#506fe4", "#506fe4", "#506fe4", "#506fe4",
                        "#506fe4", "#506fe4", "#506fe4", "#506fe4", "#506fe4", "#506fe4",
                        "#506fe4", "#506fe4"
                    ],
                    borderWidth: 1,
                    data: datas,

                }]
            },
            options: {


                responsive: true,
                legend: {
                    position: 'top',
                    height: 100
                },
                title: {
                    display: false,
                    text: 'Chart.js Bar Chart'
                },
                scales: {
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        },
                        gridLines: {
                            color: 'rgba(0,0,0,0.05)',
                            lineWidth: 1,
                            borderDash: [0]
                        }
                    }],
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        },

                        gridLines: {
                            color: 'rgba(0,0,0,0.05)',
                            lineWidth: 1,
                            borderDash: [0]
                        }
                    }]
                }
            }
        });
    });
</script>
<script>
    var datas1 = @json($datas1);
    "use strict";
    $(document).ready(function () {
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
            colors: ['#ff3385'],
            series: [{
                name: 'Orders',
                data: datas1
            }],
            legend: {
                show: false,
            },
            xaxis: {
                title: {
                    text: 'Months',
                },
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
            yaxis: {
                title: {
                    text: 'Orders',
                },
                min: 0
            },
            grid: {
                row: {
                    colors: ['transparent', 'transparent'],
                    opacity: .5
                },
                borderColor: #ff3385 '
            },


        }
        var chart = new ApexCharts(
            document.querySelector("#apex-area-chart"),
            options
        );
        chart.render();
    });
</script>


@endsection