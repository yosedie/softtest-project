@extends('admin.layouts.master')
@section('title', 'Payout Setting - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Instructor Payout Settings';
$data['title'] = 'Instructors';
$data['title1'] = 'Instructors Payout';
$data['title2'] = 'Instructors Payout Settings';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  @if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}"
>
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
  @endforeach  
  </div>
  @endif
<div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Instructors Payout Settings') }}</h5>
        </div>
        <div class="card-body">
          
			<form action="{{ route('instructor.update') }}" method="POST">
				{{ csrf_field() }}
				{{ method_field('POST') }}
          <div class="row ">

			<div class="form-group col-md-2">
				<label for="Revenue">{{ __('Instructor Revenue in') }} %</label>
			    <div class="input-group mb-3">
					<input  min="1" max="100" class="form-control" name="instructor_revenue" type="number" value="{{ optional($setting)->instructor_revenue }}" id="revenue"  placeholder="{{ __('Enter revenue percentage') }}" class="{{ $errors->has('instructor_revenue') ? ' is-invalid' : '' }} form-control">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">%</span>
					</div>
				</div>
			</div>
				
			<div class="form-group col-md-2">
			<label for="Revenue">{{ __('Admin Revenue in') }} %</label>
			    <div class="input-group mb-3">
					<input min="1" max="100" class="form-control" name="admin_revenue" type="number" value="{{ 100 - optional($setting)->instructor_revenue }}" id="revenue"  placeholder="{{ __('Enter revenue percentage') }}" class="{{ $errors->has('admin_revenue') ? ' is-invalid' : '' }} form-control" readonly>
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">%</span>
					</div>
				</div>
			</div>
      <div class="form-group col-md-2">
            	<label for="">{{ __('Paytm Enable') }}: </label><br>
              <input  class="custom_toggle"  type="checkbox" name="paytm_enable" {{ optional($setting)['paytm_enable'] == '1' ? 'checked' : '' }}  />
              <input type="hidden"  name="free" value="0" for="paytm" id="paytm">
                
              
            </div>
            <div class="form-group col-md-2">
				<label for="">{{ __('PayPal Enable') }}: </label><br>
              <input  type="checkbox" class="custom_toggle" name="paypal_enable" {{ optional($setting)['paypal_enable'] == '1' ? 'checked' : '' }} />
			  <input type="hidden"  name="free" value="0" for="paypal" id="paypal">
            
            </div>
            <div class="form-group col-md-2">
				<label for="">{{ __('Bank Transfer Enable') }}: </label><br>
              <input  type="checkbox" class="custom_toggle" name="bank_enable" {{ optional($setting)['bank_enable'] == '1' ? 'checked' : '' }}  />
			  <input type="hidden"  name="free" value="0" for="bank" id="bank">
            
            </div>
          </div>
          <div class="form-group">
            <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __('Reset')}}</button>
            <button type="submit" class="btn btn-primary-rgba" title="{{ __('Save') }}"><i class="fa fa-check-circle"></i>
            {{ __('Save')}}</button>
          </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

