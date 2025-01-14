@extends('admin.layouts.master')
@section('title', 'Mailchimp Settings - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Mailchimp Settings';
$data['title'] = 'Site Setting';
$data['title1'] = 'Mailchimp Settings';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)
        <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close')}}">
                <span aria-hidden="true" class="text-danger">&times;</span></button></p>
        @endforeach
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Mailchimp Settings') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form" action="{{ route('mailchimp.update') }}" method="POST" novalidate
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-dark" for="MAILCHIMP_APIKEY">{{ __('Mailchimp Api Key') }} <span class="text-danger">*</span></label>
                                    <input value="{{ env('MAILCHIMP_APIKEY') }}" autofocus name="MAILCHIMP_APIKEY" type="text" class="form-control" placeholder="{{ __('Enter Mailchimp Api Key')}}"/>
                                </div>
                                </div> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-dark" for="MAILCHIMP_LIST_ID">{{ __('Mailchimp List ID') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('MAILCHIMP_LIST_ID') }}" autofocus name="MAILCHIMP_LIST_ID" type="text" class="form-control" placeholder="{{ __('Enter  Mailchimp List ID')}}"/>
                                    </div>
                                    </div>
                        </div>
                        <div class="form-group">
                            <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i>
                                {{ __("Reset")}}</button>
                            <button type="submit" class="btn btn-primary-rgba" title="{{ __('Save')}}"><i class="fa fa-check-circle"></i>
                                {{ __("Save")}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection