<!-- User Wallet checkout page start -->
@extends('theme2.master')
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
        <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="course" class="img-fluid">
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
										        <form accept-charset="UTF-8" action="{{route('stripe.wallet')}}" method="POST"autocomplete="off">
										    		{{ csrf_field() }}
										            <div class="form-group owner">
										                <label for="owner">{{ __('Owner') }}</label>
										                <input type="text" class="form-control" id="owner" required>
										            </div>
										            <div class="form-group CVV">
										                <label for="cvv">{{ __('CVV') }}</label>
										                <input type="text" class="form-control" id="cvv" name="ccv" required>
										            </div>
										            <div class="form-group" id="card-number-field">
										                <label for="cardNumber">{{ __('Card Number') }}</label>
										                <input type="text" class="form-control" id="cardNumber" name="card_no" required>
										            </div>
										            <div class="form-group" id="expiration-date">
										                <label>{{ __('Expiration Date') }}</label>
										                <select name="expiry_month" required> 
										                    <option value="01">{{ __('January') }}</option>
										                    <option value="02">{{ __('February') }}</option>
										                    <option value="03">{{ __('March') }}</option>
										                    <option value="04">{{ __('April') }}</option>
										                    <option value="05">{{ __('May') }}</option>
										                    <option value="06">{{ __('June') }}</option>
										                    <option value="07">{{ __('July') }}</option>
										                    <option value="08">{{ __('August') }}</option>
										                    <option value="09">{{ __('September') }}</option>
										                    <option value="10">{{ __('October') }}</option>
										                    <option value="11">{{ __('November') }}</option>
										                    <option value="12">{{ __('December') }}</option>
										                </select>
										                <select name="expiry_year" required>
										                    <option value="19">{{ __('2019') }}</option>
										                    <option value="20">{{ __('2020') }}</option>
										                    <option value="21">{{ __('2021') }}</option>
										                    <option value="22">{{ __('2022') }}</option>
										                    <option value="23">{{ __('2023') }}</option>
										                    <option value="24">{{ __('2024') }}</option>
										                    <option value="25">{{ __('2025') }}</option>
										                    <option value="26">{{ __('2026') }}</option>
										                    <option value="27">{{ __('2027') }}</option>
										                    <option value="28">{{ __('2028') }}</option>
										                    <option value="29">{{ __('2029') }}</option>
										                    <option value="30">{{ __('2030') }}</option>
										                    <option value="31">{{ __('2031') }}</option>
										                    <option value="32">{{ __('2032') }}</option>
										                </select>
										            </div>
										            <div class="form-group" id="credit_cards">
										                <img src="{{ url('images/payment/visa.jpg') }}" id="visa">
										                <img src="{{ url('images/payment/mastercard.jpg') }}" id="mastercard">
										                <img src="{{ url('images/payment/amex.jpg') }}" id="amex">
										            </div>

										            <input type="hidden" name="amount"  value="{{ strip_tags($mainpay) }}" />

										            <button class='form-control btn btn-default' type='submit'>{{ __('Proceed') }}</button>
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

@endsection
<!-- script end -->
