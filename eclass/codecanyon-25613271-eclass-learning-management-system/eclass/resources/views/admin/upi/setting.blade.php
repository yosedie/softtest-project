@extends('admin.layouts.master')
@section('title', 'Upi - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Upi Setting';
$data['title'] = 'Setting';
$data['title1'] = 'Upi Setting';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      @foreach($errors->all() as $error)
      <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true" class="text-danger" >&times;</span></button></p>
      @endforeach
    </div>
    @endif
    <div class="row">
    <div class="col-lg-12">
        <div class="card dashboard-card m-b-30">
            <div class="card-header">
                <h5 class="card-title">{{ __('Upi Setting') }}</h5>
            </div>
            <div class="card-body">
                <form class="form" action="{{ route('upi.update') }}" method="POST" novalidate
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="text-dark">{{ __('Reciver Nmae') }}:</label>
                            <input name="name" value="{{ $upi->name }}" autofocus="" type="name"
                                class="{{ $errors->has('name') ? ' is-invalid' : '' }} form-control"
                                placeholder="Enter Receiver Name" required="">
                            <div class="invalid-feedback">
                                {{ __('Please enter name!') }}.
                            </div>
                        </div> 
                        <div class="form-group col-md-12">
                            <label class="text-dark">{{ __('Upi Id') }}:</label>
                            <input name="upiid" value="{{ $upi->upiid }}" autofocus="" type="text"
                                class="{{ $errors->has('text') ? ' is-invalid' : '' }} form-control"
                                placeholder="Please Enter Upi id" required="">
                            <div class="invalid-feedback">
                                {{ __('Please enter upiid!') }}.
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="text-dark">{{ __('Status') }} :</label>
                            <input type="checkbox" class="custom_toggle" id="customSwitch2" name="status"  {{ $upi->status == 1 ? 'checked' : '' }} />
                        </div>
                            </div>
                    <div class="form-group">
                        <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i>
                            {{ __("Reset")}}</button>
                        <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                            {{ __("Update")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection