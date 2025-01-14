@extends('admin.layouts.master')
@section('title', 'Payment Settings - Instructor')
@section('maincontent')
<?php
$data['heading'] = 'Payment Settings';
$data['title'] = 'Payment Settings';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
  @if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
<div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Setup payment informations') }}</h5>
        </div>
        <div class="card-body">
          
			<form action="{{ route('instructor.payout', $user->id) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field('POST') }}

          
        <div class="row col-6">
            <div class="form-group col-md-12">
				
				<label for="type">{{ __('Type') }}:<sup class="redstar">*</sup></label>
				<select class="select2-single form-control"  name="type" id="paytype" required>
					<option value="none" selected disabled hidden >{{ __('ChoosePaymentType') }}</option>

					@if($isetting['paytm_enable'] == 1)
						<option {{ $user->prefer_pay_method == 'paytm' ? 'selected' : ''}} value="paytm">{{ __('Paytm') }}</option>
					@endif
					@if($isetting['paypal_enable'] == 1)
					<option {{ $user->prefer_pay_method == 'paypal' ? 'selected' : ''}} value="paypal">{{ __('Paypal') }}</option>
					@endif
					@if($isetting['bank_enable'] == 1)
					<option {{ $user->prefer_pay_method == 'banktransfer' ? 'selected' : ''}} value="bank">{{ __('BankTransfer') }}</option>
					@endif
				</select>
            </div>
       
            
              

			
				<div class="form-group col-md-12" id="paypalpayment"  style="d-none;">
					@if($isetting['paypal_enable'] == 1)
					<div id="paypalpayment" @if($user['prefer_pay_method'] == "banktransfer" || $user['prefer_pay_method'] == "paytm" ) class="display-none" @endif>
						<h5 class="box-title">{{ __('PAYPALPAYMENT') }}</h5>
						<label for="pay_cid">{{ __('PaypalEmail') }}<sup class="redstar">*</sup></label>
						<input value="{{ $user['paypal_email'] }}" autofocus name="paypal_email" type="text" class="form-control" placeholder="Enter Paypal Email"/>
						@endif
					</div>
				</div>
		

            
			
		             

		
            <div class="form-group col-md-12" id="paytmpayment" >
				@if($isetting['paytm_enable'] == 1)
				<div id="paytmpayment" @if($user['prefer_pay_method'] == "banktransfer" || $user['prefer_pay_method'] == "paypal" ) class="display-none" @endif>
					<h5 class="box-title">{{ __('PAYTMPAYMENT') }}</h5>
					<label for="pay_cid">{{ __('PaytmMobileNo') }}<sup class="redstar">*</sup></label>
					<input value="{{ $user['paytm_mobile'] }}" autofocus name="paytm_mobile" type="text" class="form-control" placeholder="Enter Paytm Mobile No"/>
               </div>
			   @endif
			</div>



            <div class="form-group col-md-12" id="bankpayment"   style="d-none;">
				@if($isetting['bank_enable'] == 1)
				<div id="bankpayment" @if($user['prefer_pay_method'] == "paypal" || $user['prefer_pay_method'] == "paytm" ) class="display-none" @endif>
					<h5 class="box-title">{{ __('BankTransfer') }}</h5>
					<div class="row">
						<div class="col-md-6 mb-2">

							<label for="pay_cid">{{ __('AccountHolderName') }}<sup class="redstar">*</sup></label>
							<input value="{{ $user->bank_acc_name }}" autofocus name="bank_acc_name" type="text" class="form-control" placeholder="Enter Account Holder Name"/>
							
						</div>

						<div class="col-md-6 mb-2">
							<label for="pay_cid">{{ __('BankName') }}<sup class="redstar">*</sup></label>
							<input value="{{ $user->bank_acc_no }}" autofocus name="bank_acc_no" type="text" class="form-control" placeholder="Enter Bank Name"/>
							
						</div>

						<div class="col-md-6 mb-2">
							<label for="pay_cid">{{ __('IFCSCode') }}<sup class="redstar">*</sup></label>
							<input value="{{ $user->ifsc_code }}" autofocus name="ifsc_code" type="text" class="form-control" placeholder="Enter IFCS Code"/>
							
						</div>

						<div class="col-md-6 mb-2">
							<label for="pay_cid">{{ __('AccountNumber') }}<sup class="redstar">*</sup></label>
							<input value="{{ $user->bank_name }}" autofocus name="bank_name" type="text" class="form-control" placeholder="Enter Account Number"/>
							
						</div>
					</div>
               </div>
			   @endif
			</div>


			
              
             
              
           
            
             
            
            
          </div>
          <div class="form-group col-md-6">
            <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
            {{ __("Create")}}</button>
          </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection


@section('script')

<script type="text/javascript">
	 $('#paytype').change(function() {
      
    if($(this).val() == 'paytm')
    {
      $('#paytmpayment').show();
      $('#paypalpayment').hide();
      $('#bankpayment').hide();
     
    }
    else if($(this).val() == 'paypal')
    { 
      $('#paytmpayment').hide();
      $('#paypalpayment').show();
      $('#bankpayment').hide();
    
    }
    else if($(this).val() == 'bank')
    {
    	$('#bankpayment').show();
      $('#paypalpayment').hide();
      $('#paytmpayment').hide();
      
    }
  });

    
</script>

@endsection

