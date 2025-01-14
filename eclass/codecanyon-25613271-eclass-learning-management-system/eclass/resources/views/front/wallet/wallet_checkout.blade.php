<!-- User Wallet checkout page start -->
@extends('theme.master')
@section('title', __('Checkout'))
@section('content')

@include('admin.message')

<!-- wallet-checkout-header start -->
@php
$gets = App\Breadcum::first();
@endphp
@if(isset($gets))
<section id="business-home" class="business-home-main-block">
    <div class="business-img">
        @if($gets['img'] !== NULL && $gets['img'] !== '')
        <img src="{{ url('/images/breadcum/'.$gets->img) }}" class="img-fluid" alt="{{$gets->text}}" />
        @else
        <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="{{$gets->text}}" class="img-fluid">
        @endif
    </div>
    <div class="overlay-bg"></div>
    <div class="container-xl">
        <div class="business-dtl">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bredcrumb-dtl">
                        <h1 class="wishlist-home-heading">{{ __('Wallet') }} {{ __('Checkout') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- wallet-checkout-header end -->

<!-- wallet checkout payment options start -->
<section id="checkout-block" class="checkout-main-block">
	<div class="container-xl">
		<div class="cart-items btm-30">
	        <div class="row">
	        	
	            <div class="col-lg-8 col-sm-8">
	            	<div class="checkout-pricelist">
		            	<ul>
		            		@if($gsetting['currency_swipe'] == 1)
		            			<li><h1 class="checkout-total">{{ __('Total') }}: <i class="{{ $currency->icon }}"></i>{{ strip_tags($amount) }}</h1></li>
		            			
		            		@else
		            			<li><h1 class="checkout-total">{{ __('Total') }}: {{ strip_tags($amount) }}<i class="{{ $currency->icon }}"></i></h1></li>

		            		@endif

		            		@php
		            			if($amount != '' || $amount != 0){
		            				$mainpay = strip_tags(round($amount,2));
		            			}else{
		            				$mainpay = strip_tags(round($amount,2));
		            			}
		            		@endphp
		            		
		            	</ul>
	            	</div>
	            	@php  			
        				$secureamount = Crypt::encrypt($mainpay);
        			@endphp
	            	<div class="payment-gateways">
	            		<div id="accordion" class="second-accordion">

	            			@if($wallet_settings->paypal_enable == 1)
						    <div class="card">
	                            <div class="card-header" id="headingOne">
							        <div class="panel-title">
							            <label for='r11'>
								            <input type='radio' id='r11' name='occupation' value='{{ __("Working") }}' required />
								            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"></a>
								              
								            <img src="{{ url('images/payment/paypal2.png') }}" class="img-fluid" alt="course">
							            </label>
							        </div>
						    	</div>
							    <div id="collapseOne" class="panel-collapse collapse in">
							        <div class="card-body">
		                            
		                            	<div class="payment-proceed-btn">
		                            		<form action="{{ route('wallet.paypal') }}" method="POST" autocomplete="off">
		                            			@csrf
		                            			
		                         				<input type="hidden" name="amount" value="{{ strip_tags($secureamount)  }}"/>
		                            			<button class="btn btn-primary" title="{{ __('checkout') }}" type="submit">{{ __('Proceed') }}</button>
		                            		</form>
		                            		
		                            	</div>
							        </div>
							    </div>
							</div>
							@endif


							@if($wallet_settings->paytm_enable == 1)
							<div class="card">
	                            <div class="card-header" id="headingFour">
							        <div class="panel-title">
							            <label for='r17'>
							              <input type='radio' id='r17' name='occupation' value='{{ __("Working") }}' required />
							              <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"></a>
							              <img src="{{ url('images/payment/paytm.png') }}"  class="img-fluid" alt="course"> 
							            </label>
							        </div>
						    	</div>
							    <div id="collapseFour" class="panel-collapse collapse in">
							        <div class="card-body">
		                            	<div class="payment-proceed-btn">
		                            		<form method="post" action="{{ route('wallet.paytm') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
		                            			@csrf

										            <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
										          
												    <div class="row">
											        <div class="col-md-12">
											            <div class="form-group">
											                <strong>{{ __('Name') }}</strong>
											                <input type="text" name="name" class="form-control" placeholder="{{ __('Enter Name') }}" value="{{Auth::user()->fname}}" required>
											            </div>
											        </div>
											        <div class="col-md-12">
											            <div class="form-group">
											                <strong>{{ __('Mobile Number') }}</strong>
											                <input type="text" name="mobile" class="form-control" placeholder="{{ __('Enter Mobile Number') }}" value="{{Auth::user()->mobile}}" required autocomplete="off">
											            </div>
											        </div>
											        <div class="col-md-12">
											            <div class="form-group">
											                <strong>{{ __('Email Id') }}</strong>
											                <input type="email" name="email" class="form-control" value="{{Auth::user()->email}}" placeholder="{{ __('Enter Email id') }}" required>
											            </div>
											        </div>
											        <div class="col-md-12">
											            <div class="form-group">
											                <input type="hidden" name="amount" class="form-control" value="{{ strip_tags($mainpay) }}" readonly="">
											            </div>
											        </div>
											        <div class="col-md-12">
											            <button class="btn btn-primary" title="checkout" type="submit">{{ __('Proceed') }}</button>
											        </div>
											    </div>
										          
											</form>
		                            	</div>
							        </div>
							    </div>
							</div>
							@endif
							

							@if($wallet_settings->stripe_enable == 1)
							<div class="card">
	                            <div class="card-header" id="headingThree">
							        <div class="panel-title">
							            <label for='r13'>
							              <input type='radio' id='r13' name='occupation' value='{{ __("Working") }}' required />
							              <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"></a>
							              <img src="{{ url('images/payment/stripe.png') }}" class="img-fluid" alt="course">
							            </label>
							        </div>
						    	</div>
							    <div id="collapseThree" class="panel-collapse collapse in">
							        <div class="card-body">
								      
									    <div class="creditCardForm">
										  
										    <div class="payment">
										        <form accept-charset="UTF-8" action="{{route('stripe.wallet')}}" id="stripe-form" method="POST" autocomplete="off">
										    		{{ csrf_field() }}
															<div class="row mb-2">
										            <div class="form-group owner col-md-6">
										                <label for="owner">{{ __('Owner')}}</label>
										                <input type="text" class="form-control" id="owner" required>
										            </div>
										            <div class="form-group col-md-6" id="card-number-field">
																	<label for="cardNumber">Card Number</label>
						  										<div id="card-number-element" class="form-control"></div>
																</div>
																<div class="form-group col-md-6" id="expiry">
																	<label>Expiration Date</label>
						    									<div id="card-expiry-element" class="form-control"></div>
																</div>
																<div class="form-group CVV col-md-6">
																		<label for="cvv">CVV</label>
							    									<div id="card-cvc-element" class="form-control"></div>
																</div>
										            <div class="form-group" id="credit_cards">
										                <img src="{{ url('images/payment/visa.jpg') }}" id="visa">
										                <img src="{{ url('images/payment/mastercard.jpg') }}" id="mastercard">
										                <img src="{{ url('images/payment/amex.jpg') }}" id="amex">
										            </div>

										            <input type="hidden" name="amount"  value="{{ strip_tags($mainpay) }}" />

															 </div>
														    <!-- Used to display form errors -->
														    <div id="card-errors" role="alert"></div>

										            <button class='btn btn-default' type='submit'>{{ __('Proceed') }}</button>
										        </form>
										    </div>
										</div>
							        </div>
							    </div>
							</div>
							@endif



                        </div>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>
<!-- wallet checkout page end -->
<!-- script start-->
@endsection

@section('custom-script')

<script src="{{ url('js/jquery.payform.min.js')}}" charset="utf-8"></script>
<script src="{{ url('js/script.js') }}"></script>
<script src="{{ url('js/jquery.min.js') }}"></script>  

<script src="https://js.stripe.com/v3/"></script>
<script>var stripeKey = Stripe("{{ env('STRIPE_KEY') }}")</script>
<script src="{{ url('js/stripe.js') }}"></script>
@endsection
<!-- script end -->