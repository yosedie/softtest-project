@extends('admin.layouts.master')
@section('title', 'Remove Frontend')
@section('maincontent')
<?php
$data['heading'] = 'Remove Frontend';
$data['title'] = 'Remove Frontend';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)
        <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
                <span aria-hidden="true" class="text-danger">&times;</span></button></p>
        @endforeach
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Remove Frontend') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form" action="{{ route('mobile.update') }}" method="POST" novalidate
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                    <div class="col-lg-12">
                                        <label class="text-dark">{{ __('You can remove frontend by enable the mobile setting.It is shown as a landing page only') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch1" name="setting_enable" {{ $msetting->setting_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                    <small class="text-primary">
                                        <i class="feather icon-help-circle"></i> {{ __("If you enabled  the toggle frontend is been disabled.") }}
                                      </small>
                                </div>
                        </div>
                        <div class="form-group">
                            <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i>
                                {{ __("Reset")}}</button>
                            <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update') }}"><i class="fa fa-check-circle"></i>
                                {{ __("Update")}}</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection