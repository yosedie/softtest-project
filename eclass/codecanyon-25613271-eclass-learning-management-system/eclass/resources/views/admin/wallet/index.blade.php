@extends('admin.layouts.master')
@section('title',__('Wallet Settings - Admin'))
@section('maincontent')
<?php
$data['heading'] = 'Wallet Settings';
$data['title'] = 'Wallet';
$data['title1'] = 'Wallet Settings';
?>
@include('admin.layouts.topbar',$data)
<!-- Content bar start -->
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
          <h5 class="card-title">{{ __('Wallet Settings') }}</h5>
        </div>
        <div class="card-body">
          <form class="form" action="{{ route('wallet.update') }}" method="POST" novalidate
            enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="form-group col-md-12">
                <label for="exampleInputDetails">{{ __('Status') }}:</label><br>
                <input type="checkbox" name="status" class="custom_toggle"
                  {{ optional($settings)['status'] == '1' ? 'checked' : '' }} />
              </div>
              <div class="form-group col-md-12">
                <h5 class="box-title">{{ __('Enable Payment Gateways For Wallet') }}:</h5>
              </div>
              <div class="form-group col-md-3">
                <label for="">{{ __('Stripe') }} {{ __('Enable') }}: </label><br>
                <input type="checkbox" class="custom_toggle" name="stripe_enable"
                  {{ optional($settings)['stripe_enable'] == '1' ? 'checked' : '' }} />
              </div>
              <div class="form-group col-md-3">
                <label for="">{{ __('PayTM') }} {{ __('Enable') }}: </label><br>
                <input type="checkbox" class="custom_toggle" name="paytm_enable"
                  {{ optional($settings)['paytm_enable'] == '1' ? 'checked' : '' }} />
              </div>
              <div class="form-group col-md-3">
                <label for="">{{ __('PayPal') }} {{ __('Enable') }}: </label><br>
                <input type="checkbox" class="custom_toggle" name="paypal_enable"
                  {{ optional($settings)['paypal_enable'] == '1' ? 'checked' : '' }} />
              </div>

            </div>
            <div class="form-group">
              <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
              <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update') }}"><i class="fa fa-check-circle"></i>
                {{ __("Update")}}</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Content bar end -->
@endsection