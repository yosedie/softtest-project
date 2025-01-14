@extends('admin.layouts.master')
@section('title',__('Admin Dashboard'))
@section('maincontent')
<?php
$data['heading'] = 'Home';
$data['title'] = 'Home';
?>
@include('admin.layouts.topbar',$data)
@section('maincontent')
<div class="contentbar">
    <!-- Start row -->
    <div class="row">

        <!-- Start col -->
        <div class="col-lg-12">
           <h3> {{ auth()->user()->getRoleNames()[0] }} {{ __('Dashboard') }} </h3>
        </div>
        <div class="col-md-12">
        <div class="card bg-primary-rgba m-b-30">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h5 class="card-title text-primary mb-1">{{__('Welcome,')}} {{ Auth::user()->fname}}
                        </h5>
                        <p class="mb-0 text-primary font-14">{{__('"May the sun shine brightest, Today"')}}</p>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection