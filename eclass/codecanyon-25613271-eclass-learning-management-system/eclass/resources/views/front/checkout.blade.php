@extends('theme.master')
@section('title', __('Checkout'))
@section('content')
@include('admin.message')
<!-- about-home start -->
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
    <div class="container-fluid">
        <div class="business-dtl">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bredcrumb-dtl">
                        <h1 class="wishlist-home-heading">{{ __('Checkout') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- about-home end -->
<section id="checkout-block" class="checkout-main-block">
	<div class="container-xl">
		<div class="cart-items btm-30">
	        <div class="row">
	        	<div class="col-lg-4 col-sm-4">
	        		<h4 class="cart-heading">{{ __('Your Items') }}
            		(@php
                        if(auth::check())
	        			{
	        				$item = App\Cart::where('user_id', Auth::User()->id)->get();
	        			}
	                	else
	                	{
	                		$item = session()->get('cart.add_to_cart');
	                		$item = array_unique($item);
	                	}
                        if(count($item)>0){

                            echo count($item);
                        }
                        else{

                            echo "0";
                        }
                    @endphp)
	            	</h4>
	            	<hr>
	            	<div class="checkout-items">
	            		@if(isset($one_course) && $one_course == 1)

	            			<div class="row btm-10">
			            		<div class="col-lg-3 col-4">
			            			<div class="checkout-course-img">
			            				@if($cart->id != NULL)
				            				@if($cart['preview_image'] !== NULL && $cart['preview_image'] !== '')
				            					<a href="{{ route('user.course.show',['slug' => $cart->slug ]) }}"><img src="{{ asset('images/course/'. $cart->preview_image) }}" class="img-fluid" alt="course"></a>
				            				@else
												<a href="{{ route('user.course.show',['slug' => $cart->slug ]) }}"><img src="{{ Avatar::create($cart->title)->toBase64() }}" class="img-fluid" alt="course"></a>
				            				@endif
			            				@else
			            					@if($cart->bundle['preview_image'] !== NULL && $cart->bundle['preview_image'] !== '')
			                                	<img src="{{ asset('images/bundle/'. $cart->bundle->preview_image) }}" class="img-fluid" alt="blog">
			                                @else
			                                	<img src="{{ Avatar::create($cart->bundle->title)->toBase64() }}" class="img-fluid" alt="blog">
			                                @endif
		                                @endif
			            			</div>
			            		</div>
			            		<div class="col-lg-9 col-8">
			            			<ul>
			            				@if($cart->id != NULL)
			            					<li class="checkout-course-title"><a href="{{ route('user.course.show',['slug' => $cart->slug ]) }}">{{ str_limit($cart->title, $limit =35 , $end = '...') }}</a></li>
			            				@else
			            					<li class="checkout-course-title"><a href="{{ route('user.course.show',['slug' => $cart->bundle->slug ]) }}">{{ str_limit($cart->bundle->title, $limit =35 , $end = '...') }}</a></li>
			            				@endif
			            				<li class="checkout-course-user">By {{ $cart->user->fname }}</li>
			            				
		                                @if($cart->discount_price == !NULL)
		                                	
			            				 <li class="checkout-course-price"><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($course->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b>
                                            <s>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($course->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</s></li>
			            					
			            				@else
                                            <li class="checkout-course-price"><span><s>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($course->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</s></span></li>		
			            				@endif
			            			</ul>
			            		</div>
			            	</div>
	            		@else
	            		
	            		@auth
	            		@foreach($carts as $cart)
			            	<div class="row btm-20">
			            		<div class="col-lg-3 col-4">
			            			<div class="checkout-course-img">
			            				@if($cart->course_id != NULL)
				            				@if($cart->courses['preview_image'] !== NULL && $cart->courses['preview_image'] !== '')
				            					<a href="{{ route('user.course.show',['slug' => $cart->courses->slug ]) }}"><img src="{{ asset('images/course/'. $cart->courses->preview_image) }}" class="img-fluid" alt="course"></a>
				            				@else
												<a href="{{ route('user.course.show',['slug' => $cart->courses->slug ]) }}"><img src="{{ Avatar::create($cart->courses->title)->toBase64() }}" class="img-fluid" alt="course"></a>
				            				@endif
			            				@else
			            					@if($cart->bundle['preview_image'] !== NULL && $cart->bundle['preview_image'] !== '')
			                                	<img src="{{ asset('images/bundle/'. $cart->bundle->preview_image) }}" class="img-fluid" alt="blog">
			                                @else
			                                	<img src="{{ Avatar::create($cart->bundle->title)->toBase64() }}" class="img-fluid" alt="blog">
			                                @endif
		                                @endif
			            			</div>
			            		</div>
			            		<div class="col-lg-9 col-8">
			            			<ul>
			            				@if($cart->course_id != NULL)
			            					<li class="checkout-course-title"><a href="{{ route('user.course.show',['slug' => $cart->courses->slug ]) }}">{{ str_limit($cart->courses->title, $limit =35 , $end = '...') }}</a></li>
			            				@else
			            					<li class="checkout-course-title"><a href="{{ route('user.course.show',['slug' => $cart->bundle->slug ]) }}">{{ str_limit($cart->bundle->title, $limit =35 , $end = '...') }}</a></li>
			            				@endif
			            				<li class="checkout-course-user">{{ __('By')}} {{ $cart->user->fname }}</li>
			            				
		                                @if($cart->offer_price == !NULL)
		                                	
			            					<li class="checkout-course-price"><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($cart->offer_price, $from = $currency->code, $to = $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b>  <s>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($cart->price, $from = $currency->code, $to = $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</s></li>
			            					
			            				@else
			            					
			            					<li class="checkout-course-price"><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($cart->price, $from = $currency->code, $to = $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></li>
			            					
			            				@endif
			            			</ul>
			            		</div>
			            	</div>
	            		@endforeach

	            		@endauth

	            		@endif

	            	</div>
                </div>
	            <div class="col-lg-8 col-sm-8">
	            	<div class="checkout-pricelist">
		            	<ul>
		            		@php
		            		$currency = App\Currency::where('default', '=', '1')->first();

		            		@endphp
		            		{{-- <li><h1 class="checkout-total">{{ __('Total') }}:{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(currency($course->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</h1></li> --}}

		            		{{-- <li><div class="checkout-price"><s>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($course->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</s></div></li> --}}
		            		
		            		<li><div class="checkout-percent">{{ round($offer_percent, 0) }}% Off</div></li>

		            		@php
		            			if($cart_total != '' || $cart_total != 0){
		            				$mainpay = round($cart_total,2);
		            			}else{
		            				$mainpay = round($cart_total,2);
		            			}
		            		@endphp
		            		
		            	</ul>
	            	</div>
					@if(session()->has('changed_currency'))
					@if(session()->get('changed_currency') !== $currency->code)
	            	<div class="h6 checkout-pricelist">

	            		({{ __('Equivalent to your currency')}} {{ currency($cart_total, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }})
	            		
	            	</div>
					<hr>
					@endif
					@endif
					@php  
								
        				// $secureamount = $mainpay;
						$string =  currency($cart_total, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false) ;
					// @dd(gettype($string));
						if(gettype($string) == 'double' || gettype($string) == 'integer'){
						$string = round($string,2);
						$double1 = $string;
					}
					else{
					 
						$str = preg_replace('/\D/', '', $string);
						$str1 = $str/100;
						$double = floatval($str1);
						$double1 = $double;
					}
					

						//  @dd($double1);
						//print_r($double1); 
						$secureamount = Crypt::encrypt($double1);	

					//   @dd(( Crypt::decrypt($secureamount) ));
						@endphp
	            	{{-- @php  
								
        				// $secureamount = $mainpay;
						$string =  currency($cart_total, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false) ;
						$str = preg_replace('/\D/', '', $string);
						//$str1 = $str/100;
						$double = floatval($str);
						$double1 = $double;
						//print_r($double1); 
						$secureamount = Crypt::encrypt($double1);	

						//@dd( gettype ( $double1 ));
						@endphp --}}

        			<div class="payment-gateways">
	            		<div id="accordion" class="second-accordion">
							@php
								$stripeSupportedCurrencies = [
									'USD', 'EUR', 'GBP', 'JPY', 'CAD', 'AUD', 'CHF', 'CNY', 'SEK', 'NZD', 'SGD', 'HKD', 'MXN', 'MYR', 'BRL', 'INR', 'RUB', 'ZAR'
								];
								$sessionCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
								$currencyCode = strtoupper($sessionCurrency);
								$isCurrencySupported = in_array($currencyCode, $stripeSupportedCurrencies);
							@endphp
	            			@if($gsetting->stripe_enable == 1 && $isCurrencySupported )
							<div class="card">
	                            <div class="card-header" id="headingThree">
							        <div class="panel-title">
							            <label for='r13'>
							              <input type='radio' id='r13' name='occupation' value='Working' required />
							              <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"></a>
							              <img src="{{ url('images/payment/stripe.png') }}" class="img-fluid" alt="course">
							            </label>
							        </div>
						    	</div>
							    <div id="collapseThree" class="panel-collapse collapse in">
							        <div class="card-body">
									    <div class="creditCardForm">
										    <div class="payment">
										        <form accept-charset="UTF-8" action="{{route('stripe.pay')}}" id="stripe-form" method="POST"autocomplete="off">
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
															<input type="hidden" name="amount" value="{{ session()->has('meeting_price') ? session('meeting_price') : $mainpay }}" />
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
							@if(!isset($cart->bundle->is_subscription_enabled) || $cart->bundle->is_subscription_enabled != '1')
							@php
							$paypalSupportedCurrencies = [
								'AUD', 'BRL', 'CAD', 'CNY', 'CZK', 'DKK', 'EUR', 'HKD', 'HUF', 'ILS', 'JPY', 'MYR', 'MXN', 'TWD', 'NZD', 'NOK', 'PHP', 'PLN', 'GBP', 'SGD', 'SEK', 'CHF', 'THB', 'USD'
							];
							$sessionCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
							$currencyCode = strtoupper($sessionCurrency);
							$isCurrencySupported = in_array($currencyCode, $paypalSupportedCurrencies);
							@endphp
							@if($gsetting->paypal_enable == 1 && $isCurrencySupported)
						    <div class="card">
	                            <div class="card-header" id="headingOne">
							        <div class="panel-title">
							            <label for='r11'>
								            <input type='radio' id='r11' name='occupation' value='Working' required />
								            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"></a>
								              
								            <img src="{{ url('images/payment/paypal2.png') }}" class="img-fluid" alt="course">
							            </label>
							        </div>
						    	</div>
							    <div id="collapseOne" class="panel-collapse collapse in">
							        <div class="card-body">
		                            
		                            	<div class="payment-proceed-btn">
		                            		<form action="{{ route('payWithpaypal') }}" method="POST" autocomplete="off">
		                            			@csrf
												<input type="hidden" name="amount" value="{{ session()->has('meeting_price') ? session('meeting_price') : $secureamount }}" />
		                         				{{-- <input type="hidden" name="amount" value="{{ $secureamount }}"/> --}}
		                            			<button class="btn btn-primary" title="checkout" type="submit">{{ __('Proceed') }}</button>
		                            		</form>
		                            		
		                            	</div>
							        </div>
							    </div>
							</div>
							@endif
							@php
								$instamojoSupportedCurrencies = ['INR']; // Supported currencies for Instamojo
								$sessionCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
								$currencyCode = strtoupper($sessionCurrency);
								$isCurrencySupported = in_array($currencyCode, $instamojoSupportedCurrencies);
							@endphp
							@if($gsetting->instamojo_enable == 1 && $isCurrencySupported)
							<div class="card">
	                            <div class="card-header" id="headingTwo">
							        <div class="panel-title">
							            <label for='r12'>
								            <input type='radio' id='r12' name='occupation' value='Working' required />
								            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"></a>

							            	<img src="{{ url('images/payment/instamojo.png') }}" class="img-fluid-img" alt="course">
							            </label>
							        </div>
						    	</div>
							    <div id="collapseTwo" class="panel-collapse collapse in">
							        <div class="card-body">
		                            	<div class="payment-proceed-btn">

		                            		<form action="{{ url('pay') }}" method="POST" name="laravel_instamojo" autocomplete="off">
											    {{ csrf_field() }}
											    
											     <div class="row">
											        <div class="col-md-12">
											            <div class="form-group">
											                <strong>{{ __('Name')}}</strong>
											                <input type="text" name="buyer_name" class="form-control" value="{{ Auth::user()->fname }}" placeholder="{{ __('Enter Name')}}" required>
											            </div>
											        </div>
											        <div class="col-md-12">
											            <div class="form-group">
											                <strong>{{ __('Mobile Number')}}</strong>
											                <input type="text" name="mobile_number" class="form-control" value="{{ Auth::user()->mobile }}" placeholder="{{ __('Enter Mobile Number')}}" required autocomplete="off">
											            </div>
											        </div>
											        <div class="col-md-12">
											            <div class="form-group">
											                <strong>{{ __('Email Id')}}</strong>
											                <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" placeholder="{{ __('Enter Email id')}}" required>
											            </div>
											        </div>
											        <div class="col-md-12">
											            <div class="form-group">
															<input type="hidden" name="amount" value="{{ session()->has('meeting_price') ? session('meeting_price') : $mainpay }}" />
											                {{-- <input type="hidden" name="amount" class="form-control" placeholder="" value="{{ $mainpay }}" readonly=""> --}}
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

							@php
							$omiseSupportedCurrencies = [
								'THB'
							];
							$sessionCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
							$currencyCode = strtoupper($sessionCurrency);
							$isCurrencySupported = in_array($currencyCode, $omiseSupportedCurrencies);
							@endphp

							@if($gsetting->enable_omise == 1 && $isCurrencySupported)
							<div class="card">
								<div class="card-header" id="headingOne">
									<div class="panel-title">
										<label for='omise'>
											<input type='radio' id='omise' name='occupation' value='Working' required />
											<a data-toggle="collapse" data-parent="#accordion" href="#omise_panel"></a>

											<img src="{{ url('images/payment/omise.svg') }}" class="img-fluid"
												alt="course">
										</label>
									</div>
								</div>
								<div id="omise_panel" class="panel-collapse collapse in">
									<div class="card-body">

										<div class="payment-proceed-btn">

											<form id="checkoutForm" method="POST" action="{{ route('pay.via.omise') }}">
												@csrf
											
												<!-- Hidden field to hold the amount -->
												<input type="hidden" name="amount" value="{{ (session()->has('meeting_price') ? session('meeting_price') : $mainpay) }}" />
											
												<!-- Omise payment script -->
												<script type="text/javascript" src="https://cdn.omise.co/omise.js"
													data-key="{{ env('OMISE_PUBLIC_KEY') }}"
													data-amount="{{ (session()->has('meeting_price') ? session('meeting_price') : $mainpay) * 100 }}"
													data-frame-label="{{ config('app.name') }}"
													data-image="{{ url('images/logo/'.$gsetting->logo) }}"
													data-currency="{{ $currency->code }}"
													data-default-payment-method="credit_card">
												</script>
											</form>


										</div>
									</div>
								</div>
							</div>
							@endif
							@php
							$razorpaySupportedCurrencies = [
								'INR'
							];
							$sessionCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
							$currencyCode = strtoupper($sessionCurrency);
							$isCurrencySupported = in_array($currencyCode, $razorpaySupportedCurrencies);
							@endphp

							@if($gsetting->razorpay_enable == 1 && $isCurrencySupported)
							<div class="card">
	                            <div class="card-header" id="headingSix">
							        <div class="panel-title">
							            <label for='r16'>
							              <input type='radio' id='r16' name='occupation' value='Working' required />
							              <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix"></a>
							              <img src="{{ url('images/payment/razorpay.png') }}"  class="img-fluid" alt="course"> 
							            </label>
							            
							        </div>
						    	</div>
							    <div id="collapseSix" class="panel-collapse collapse in">
							        <div class="card-body">
		                            	<div class="payment-proceed-btn">
		                            		@php
												$isMeetingPayment = isset($meeting_price) && $meeting_price > 0;
												$amount = $isMeetingPayment ? $meeting_price : Crypt::decrypt($secureamount);
												$payAmount = $isMeetingPayment ? $meeting_price * 100 : $mainpay * 100;
												$description = $isMeetingPayment ? ($description ?? '') : '';
												$prefillName = $isMeetingPayment ? ($prefillName ?? 'XYZ') : 'XYZ';
												$prefillEmail = $isMeetingPayment ? ($prefillEmail ?? 'info@example.com') : 'info@example.com';
											@endphp

											<form action="{{ route('dopayment') }}" method="POST">
												@csrf
												<input type="hidden" name="amount" value="{{ $amount }}" />
												<script
													src="https://checkout.razorpay.com/v1/checkout.js"
													data-key="{{ env('RAZORPAY_KEY') }}"
													data-amount="{{ $payAmount }}"
													data-currency="{{ $currency->code }}"
													data-order_id=""
													data-buttontext="Proceed"
													data-name="{{ $gsetting->project_title }}"
													data-description="{{ $description }}"
													data-image="{{ asset('images/logo/'.$gsetting->logo) }}"
													data-prefill.name="{{ $prefillName }}"
													data-prefill.email="{{ $prefillEmail }}"
													data-theme.color="#F44A4A"
												></script>
											</form>
		                            	</div>
							        </div>
							    </div>
							</div>
							@endif

							@php
								$paystackSupportedCurrencies = [
									'GHS', 'NGN', 'ZAR', 'KES'
								];
								$sessionCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
								$currencyCode = strtoupper($sessionCurrency);
								$isCurrencySupported = in_array($currencyCode, $paystackSupportedCurrencies);
							@endphp

							@if($gsetting->paystack_enable == 1 && $isCurrencySupported)
							<div class="card">
	                            <div class="card-header" id="headingSeven">
							        <div class="panel-title">
							            <label for='r14'>
							              <input type='radio' id='r14' name='occupation' value='Working' required />
							              <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven"></a>
							              <img src="{{ url('images/payment/paystack.png') }}"  class="img-fluid" alt="course"> 
							            </label>
							        </div>
						    	</div>
							    <div id="collapseSeven" class="panel-collapse collapse in">
							        <div class="card-body">
		                            	<div class="payment-proceed-btn">
		                            		{{-- <form method="POST" action="{{ route('paywithpaystack') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
										        <div class="row">
										          <div class="col-md-8 col-md-offset-2">

										          	<input type="hidden" name="quantity" value="1">
										            
										            <input type="hidden" name="email" value="{{Auth::User()->email}}"> 
										            <input type="hidden" name="amount" value="{{ $mainpay*100 }}">
										            <input type="hidden" name="currency" value="{{ $currency->code }}">
										            <input type="hidden" name="metadata" value="{{ json_encode($array = ['key_name' => 'value',]) }}" > 
										            <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> 
										            <input type="hidden" name="key" value="{{ env('PAYSTACK_SECRET_KEY') }}"> 
										            {{ csrf_field() }} 

										             <input type="hidden" name="_token" value="{{ csrf_token() }}"> 

										            <p>
										              <button class="btn btn-primary " type="submit" value="Pay Now">{{ __('Proceed') }}</button>
										            </p>
										          </div>
										        </div>
											</form> --}}

											<form method="POST" action="{{ route('paywithpaystack') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
												<div class="row">
													<div class="col-md-12 col-md-offset-2">
														<input type="hidden" name="quantity" value="1">
														<input type="hidden" name="email" value="{{ Auth::User()->email }}"> 
														
														@php
															$amount = session()->has('meeting_price') ? session('meeting_price') * 100 : $mainpay * 100;
														@endphp
														<input type="hidden" name="amount" value="{{ $amount }}">
														
														<input type="hidden" name="currency" value="{{ $currency->code }}">
														<input type="hidden" name="metadata" value="{{ json_encode(['key_name' => 'value']) }}">
														<input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
														<input type="hidden" name="key" value="{{ env('PAYSTACK_SECRET_KEY') }}">
														{{ csrf_field() }}
														<input type="hidden" name="_token" value="{{ csrf_token() }}">
														<p>
															<button class="btn btn-primary" type="submit" value="Pay Now">{{ __('Proceed') }}</button>
														</p>
													</div>
												</div>
											</form>
		                            	</div>
							        </div>
							    </div>
							</div>
							@endif

							@php
							$paytmSupportedCurrencies = [
								'INR'
							];
							$sessionCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
							$currencyCode = strtoupper($sessionCurrency);
							$isCurrencySupported = in_array($currencyCode, $paytmSupportedCurrencies);
							@endphp
							@if($gsetting->paytm_enable == 1 && $isCurrencySupported)
							<div class="card">
	                            <div class="card-header" id="headingFour">
							        <div class="panel-title">
							            <label for='r17'>
							              <input type='radio' id='r17' name='occupation' value='Working' required />
							              <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"></a>
							              <img src="{{ url('images/payment/paytm.png') }}"  class="img-fluid" alt="course"> 
							            </label>
							        </div>
						    	</div>
							    <div id="collapseFour" class="panel-collapse collapse in">
							        <div class="card-body">
		                            	<div class="payment-proceed-btn">
		                            		<form method="post" action="{{ url('/paywithpayment') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
		                            			@csrf
										            <input type="hidden" name="user_id" value="{{Auth::User()->id}}"/>										          
												    <div class="row">
											        <div class="col-md-12">
											            <div class="form-group">
											                <strong>{{ __('Name')}}</strong>
											                <input type="text" name="name" class="form-control" placeholder="{{ __('Enter Name')}}" value="{{Auth::User()->fname}}" required>
											            </div>
											        </div>
											        <div class="col-md-12">
											            <div class="form-group">
											                <strong>{{ __('Mobile Number')}}</strong>
											                <input type="text" name="mobile" class="form-control" placeholder="{{ __('Enter Mobile Number')}}" value="{{Auth::User()->mobile}}" required autocomplete="off">
											            </div>
											        </div>
											        <div class="col-md-12">
											            <div class="form-group">
											                <strong>{{ __('Email Id')}}</strong>
											                <input type="email" name="email" class="form-control" value="{{Auth::User()->email}}" placeholder="{{ __('Enter Email id')}}" required>
											            </div>
											        </div>
											        <div class="col-md-12">
											            <div class="form-group">
															<input type="hidden" name="amount" value="{{ session()->has('meeting_price') ? session('meeting_price') : $secureamount }}" />
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

							@php
								$banktransfer = App\BankTransfer::first();
							@endphp
							
							@if(isset($banktransfer))
							@if($banktransfer->bank_enable == '1')
							<div class="card">
	                            <div class="card-header" id="headingEight">
							        <div class="panel-title">
							            <label for='r18'>
							              <input type='radio' id='r18' name='occupation' value='Working' required />
							              <a data-toggle="collapse" data-parent="#accordion" href="#collapseEight"></a>
							              &emsp;<b>{{ __('bank transfer') }}</b>
							            </label>
							        </div>
						    	</div>
							    <div id="collapseEight" class="panel-collapse collapse in">
							        <div class="card-body">
		                            	<div class="payment-proceed-btn">
		                            		<form method="POST" action="{{ url('process/banktransfer') }}" accept-charset="UTF-8" class="form-horizontal" role="form" enctype="multipart/form-data">
		                            			@csrf
										        <div class="row">
										          <div class="col-md-8 col-md-offset-2">

										          	<input type="file" name="proof" required />
										          	<br>
										            <small>({{ __('Please Document') }})</small>
										            
									            	<input type="hidden" name="amount" value="{{ $mainpay }}"/>

										            <input type="hidden" name="user_id" value="{{Auth::User()->id}}"/>

										            <input type="hidden" name="fname" value="{{Auth::User()->fname}}"/>

										             <input type="hidden" name="mobile" value="{{Auth::User()->mobile}}"/>

										            <input type="hidden" name="email" value="{{Auth::User()->email}}"/>


										            <p>
										              <button class="btn btn-primary " type="submit" value="Pay Now">{{ __('Proceed') }}</button>
										            </p>
										          </div>
										        </div>
											</form>

											<div class="card">
											  <div class="card-header">
											    <h5 class="card-title">{{ __('bank transfer detail') }}</h5>
											  </div>
											  @php
											  	$bankdetail = App\BankTransfer::first();
											  @endphp
											  <ul class="list-group list-group-flush">
											    <li class="list-group-item"><b>{{ __('Account holder name') }}:</b>&nbsp;{{ $bankdetail['account_holder_name'] }}</li>
											    <li class="list-group-item"><b>{{ __('Bank Name') }}:</b>&nbsp;{{ $bankdetail['bank_name'] }}</li>
											    <li class="list-group-item"><b>{{ __('Bank Acccoun tNumber') }}:</b>&nbsp;{{ $bankdetail['account_number'] }}</li>
											    @if(isset($bankdetail['ifcs_code']))
											    <li class="list-group-item"><b>{{ __('IFCS Code') }}</b>:&nbsp;{{ $bankdetail['ifcs_code'] }}</li>
											    @endif
											    @if(isset($bankdetail['swift_code']))
											    <li class="list-group-item"><b>{{ __('Swift Code') }}</b>:&nbsp;{{ $bankdetail['swift_code'] }}</li>
											    @endif
											  </ul>
											</div>
		                            	</div>
							        </div>
							    </div>
							</div>
							@endif
							@endif

							@php
								$payuSupportedCurrencies = [
									'AUD', 'BRL', 'CAD', 'CHF', 'CNY', 'CZK', 'DKK', 'EUR', 'GBP', 'HKD', 'HUF', 'ILS', 'INR', 'JPY', 'MXN', 'MYR', 'NOK', 'NZD', 'PLN', 'SEK', 'SGD', 'THB', 'TRY', 'USD', 'ZAR'
								];
								$sessionCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
								$currencyCode = strtoupper($sessionCurrency);
								$isCurrencySupported = in_array($currencyCode, $payuSupportedCurrencies);
							@endphp

							@if($gsetting->enable_payu == 1 && $isCurrencySupported)
							<div class="card">
								<div class="card-header" id="headingOne">
									<div class="panel-title">
										<label for='ppay'>
											<input type='radio' id='ppay' name='occupation' value='Working' required />
											<a data-toggle="collapse" data-parent="#accordion" href="#payupay"></a>

											<img src="{{ url('images/payment/payumoney.png') }}" class="img-fluid"
												alt="course">
										</label>
									</div>
								</div>
								<div id="payupay" class="panel-collapse collapse in">
									<div class="card-body">

										<div class="payment-proceed-btn">
											<form action="{{ route('paywithpayu') }}" method="POST" autocomplete="off">
												@csrf

												<input type="hidden" name="amount" value="{{ session()->has('meeting_price') ? session('meeting_price') : Crypt::decrypt($secureamount) }}" />


												<div class="form-group">
													<label>{{ __('Email')}} : <span class="text-red">*</span></label>
													<input required="" name="email" type="email" class="form-control" value="{{ Auth::user()->email }}" placeholder="{{ __('Enter email')}}">
												</div>

												<div class="form-group">
													<label>{{ __('Phone')}} : <span class="text-red">*</span></label>
													<input required="" name="phone" type="text" class="form-control" value="{{ Auth::user()->mobile }}" placeholder="{{ __('Enter valid phone no')}}">
												</div>

												<button class="btn btn-primary" title="checkout"
													type="submit">{{ __('Proceed') }}</button>
											</form>

										</div>
									</div>
								</div>
							</div>
							@endif

							@php
								$cashfreeSupportedCurrencies = [
									'INR', 'USD', 'CNY', 'GBP', 'AED', 'AUD', 'AZN', 'BHD', 'CAD', 'CHF', 'DKK', 'EGP', 'EUR', 'HKD', 'ILS', 'JOD', 'JPY', 'KRW', 'KWD', 'MYR', 'NOK', 'NZD', 'OMR', 'QAR', 'RUB', 'SAR', 'SEK', 'SGD', 'THB', 'ZAR'
								];
								$sessionCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
								$currencyCode = strtoupper($sessionCurrency);
								$isCurrencySupported = in_array($currencyCode, $cashfreeSupportedCurrencies);
							@endphp

							@if($gsetting->enable_cashfree == 1 && $isCurrencySupported)
							<div class="card">
								<div class="card-header" id="headingOne">
									<div class="panel-title">
										<label for='cpay'>
											<input type='radio' id='cpay' name='occupation' value='Working' required />
											<a data-toggle="collapse" data-parent="#accordion" href="#cashfree_pay"></a>

											<img src="{{ url('images/payment/cashfree.png') }}" class="img-fluid"
												alt="course">
										</label>
									</div>
								</div>
								<div id="cashfree_pay" class="panel-collapse collapse in">
									<div class="card-body">

										<div class="payment-proceed-btn">
											<form action="{{ route('cashfree.pay') }}" method="POST" autocomplete="off">
												@csrf

												<input type="hidden" name="amount" value="{{ session()->has('meeting_price') ? session('meeting_price') : Crypt::decrypt($secureamount) }}" />

												{{-- <input type="hidden" name="currency" value="INR" /> --}}


												<div class="form-group">
													<label>{{ __('Email')}} : <span class="text-red">*</span></label>
													<input required="" name="email" type="email" class="form-control" value="{{ Auth::user()->email }}" placeholder="{{ __('Enter email')}}">
												</div>

												<div class="form-group">
													<label>{{ __('Phone')}} : <span class="text-red">*</span></label>
													<input required="" name="phone" type="text" class="form-control" value="{{ Auth::user()->mobile }}" placeholder="{{ __('Enter valid phone no')}}">
												</div>

												<button class="btn btn-primary" title="checkout"
													type="submit">{{ __('Proceed') }}</button>
											</form>

										</div>
									</div>
								</div>
							</div>
							@endif

							@php
							$moliSupportedCurrencies = [
								'AED', 'AUD', 'BGN', 'BRL', 'CAD', 'CHF', 'CZK', 'DKK', 'EUR', 'GBP', 'HKD', 'HUF', 'ILS', 'ISK', 'JPY', 'MXN', 'MYR', 'NOK', 'NZD', 'PHP', 'PLN', 'RON', 'RUB', 'SEK', 'SGD', 'THB', 'TWD', 'USD', 'ZAR'
							];
							$sessionCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
							$currencyCode = strtoupper($sessionCurrency);
							$isCurrencySupported = in_array($currencyCode, $moliSupportedCurrencies);
							@endphp
							@if($gsetting->enable_moli == 1 && $isCurrencySupported)
							<div class="card">
								<div class="card-header" id="headingOne">
									<div class="panel-title">
										<label for='mpay'>
											<input type='radio' id='mpay' name='occupation' value='Working' required />
											<a data-toggle="collapse" data-parent="#accordion" href="#moli_pay"></a>

											<img src="{{ url('images/payment/moli.png') }}" class="img-fluid"
												alt="course">
										</label>
									</div>
								</div>
								<div id="moli_pay" class="panel-collapse collapse in">
									<div class="card-body">

										<div class="payment-proceed-btn">
											<form action="{{ route('moli.pay') }}" method="POST" autocomplete="off">
												@csrf

												<input type="hidden" name="amount" value="{{ session()->has('meeting_price') ? session('meeting_price') : Crypt::decrypt($secureamount) }}" />


												<button class="btn btn-primary" title="checkout"
													type="submit">{{ __('Proceed') }}</button>
											</form>

										</div>
									</div>
								</div>
							</div>
							@endif

							@php
								$skrillSupportedCurrencies = [
									'AUD', 'EUR', 'BDT', 'BRL', 'IDR', 'INR', 'KES', 'MYR', 'MXN', 'NPR', 'PKR', 'PHP', 'PLN', 'THB', 'UAH', 'GBP', 'USD', 'VND'
								];
								$sessionCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
								$currencyCode = strtoupper($sessionCurrency);
								$isCurrencySupported = in_array($currencyCode, $skrillSupportedCurrencies);
							@endphp
							@if($gsetting->enable_skrill == 1 && $isCurrencySupported)
							<div class="card">
								<div class="card-header" id="headingOne">
									<div class="panel-title">
										<label for='skpay'>
											<input type='radio' id='skpay' name='occupation' value='Working' required />
											<a data-toggle="collapse" data-parent="#accordion" href="#sk_pay"></a>

											<img src="{{ url('images/payment/skrill.png') }}" class="img-fluid"
												alt="course">
										</label>
									</div>
								</div>
								<div id="sk_pay" class="panel-collapse collapse in">
									<div class="card-body">

										<div class="payment-proceed-btn">
											<form action="{{ route('skrill.pay') }}" method="POST" autocomplete="off">
												@csrf

												<input name="pay_to_email" type="hidden" value="{{ env('SKRILL_MERCHANT_EMAIL') }}">
												<input type="hidden" name="amount" 
           value="{{ session()->has('meeting_price') ? session('meeting_price') : Crypt::decrypt($secureamount) }}" />

												<button class="btn btn-primary" title="checkout"
													type="submit">{{ __('Proceed') }}</button>
											</form>

										</div>
									</div>
								</div>
							</div>
							@endif

							@php
							$raveSupportedCurrencies = [
								'NGN'
							];
							$sessionCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
							$currencyCode = strtoupper($sessionCurrency);
							$isCurrencySupported = in_array($currencyCode, $raveSupportedCurrencies);
							@endphp


							@if($gsetting->enable_rave == 1 && $isCurrencySupported)
							<div class="card">
								<div class="card-header" id="headingOne">
									<div class="panel-title">
										<label for='rpay'>
											<input type='radio' id='rpay' name='occupation' value='Working' required />
											<a data-toggle="collapse" data-parent="#accordion" href="#rave_pay"></a>

											<img src="{{ url('images/payment/rave.png') }}" class="img-fluid"
												alt="course">
										</label>
									</div>
								</div>
								<div id="rave_pay" class="panel-collapse collapse in">
									<div class="card-body">

										<div class="payment-proceed-btn">

											@php
											$array = array(array('metaname' => 'color', 'metavalue' => 'blue'),
											array('metaname' => 'size', 'metavalue' => 'small'));
											
								// print_r($secureamount); 


											@endphp

											<form method="POST" action="{{ route('flutterrave.pay') }}" id="paymentForm">
												{{ csrf_field() }}
												<input type="hidden" name="amount" 
           										value="{{ session()->has('meeting_price') ? session('meeting_price') : Crypt::decrypt($secureamount) }}" />

												
												<input required="" class="form-control" type="hidden" name="email"
													value="{{ Auth::user()->email }}" />
												<input type="hidden" name="name"
													value="{{ Auth::user()->fname }}" />
												
												<input type="hidden" name="phone"
													value="{{ Auth::user()->mobile }}" />
												<button class="btn btn-primary" title="checkout"
													type="submit">@if(session()->has('changed_currency'))
								@if(session()->get('changed_currency') !== $currency->code)
								<div class="h6 checkout-pricelist">

	            	
	            		
							</div>
							<hr>
							@endif
							@endif
							{{ Crypt::decrypt($secureamount) }}{{ __('Proceed') }}</button>
											</form>

										</div>
									</div>
								</div>
							</div>
							@endif

							@php
	                            $order_id = uniqid();
								$payhereSupportedCurrencies = [
									'LKR', 'USD', 'GBP', 'EUR', 'AUD'
								];
								$sessionCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
								$currencyCode = strtoupper($sessionCurrency);
								$isCurrencySupported = in_array($currencyCode, $payhereSupportedCurrencies);
	                        @endphp

							@if($gsetting->enable_payhere == 1 && $isCurrencySupported)
							<div class="card">
								<div class="card-header" id="headingten">
									<div class="panel-title">
										<label for='payhere'>
											<input type='radio' id='payhere' name='occupation' value='Working' required />
											<a data-toggle="collapse" data-parent="#accordion" href="#payhere_pay"></a>


											<img src="{{ url('images/payment/payhere.png') }}" class="img-fluid"
												alt="course">
										</label>
									</div>
								</div>
								<div id="payhere_pay" class="panel-collapse collapse in">
									<div class="card-body">

										<div class="payment-proceed-btn">

											@if(env('PAYHERE_MODE') == 'sandbox')
												@php
												$action = 'https://sandbox.payhere.lk/pay/checkout';
												@endphp
											@else
												@php
												$action = 'https://www.payhere.lk/pay/checkout';
												@endphp

											@endif

											<form method="post" action="{{ $action }}" >  

									            <input type="hidden" name="merchant_id" value="{{ env('PAYHERE_MERCHANT_ID') }}">    <!-- Replace your Merchant ID -->
									            <input type="hidden" name="return_url" value="{{route ( 'payhere.returnUrl' )}}">
									            <input type="hidden" name="cancel_url" value="{{route ( 'payhere.cancelUrl' )}}">
									            <input type="hidden" name="notify_url" value="{{route ( 'payhere.notifyUrl' )}}">  

									            <input hidden type="text" name="order_id" value="{{ $order_id }}">
									            <input hidden type="text" name="items" value="{{ $order_id }}">
									            <input hidden type="text" name="currency" value="LKR">
									            <input type="hidden" name="amount" 
          										 value="{{ session()->has('meeting_price') ? session('meeting_price') : Crypt::decrypt($secureamount) }}" />

									            
									            <input hidden type="text" name="first_name" value="{{ Auth::user()->fname }}">
									            <input hidden type="text" name="last_name" value="{{ Auth::user()->lname }}">
									            <input hidden type="text" name="email" value="{{ Auth::user()->email }}">
									            <input hidden type="text" name="phone" value="{{ isset(Auth::user()['mobile']) }}">
									            <input hidden type="text" name="address" value=" {{ isset(Auth::user()['address']) }}">
									            <input type="hidden" name="city" value="{{ isset(Auth::user()->state['name']) }}">
									            <input type="hidden" name="country" value="{{ isset(Auth::user()->country['name']) }}">

									        

                            					<button class="btn btn-primary" title="checkout"
													type="submit">{{ __('Proceed') }}
												</button>
									        </form> 

											

										</div>
									</div>
								</div>
							</div>
							@endif

							@php
	                            $conversation_id = uniqid();
								$iyzicoSupportedCurrencies = [
									'TRY', 'EUR', 'USD', 'GBP', 'IRR', 'NOK', 'RUB', 'CHF'
								];
								$sessionCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
								$currencyCode = strtoupper($sessionCurrency);
								$isCurrencySupported = in_array($currencyCode, $iyzicoSupportedCurrencies);
	                        @endphp

	                        @if($gsetting->iyzico_enable == 1 && $isCurrencySupported)
							<div class="card">
								<div class="card-header" id="headinggodvf">
									<div class="panel-title">
										<label for='izyy'>
											<input type='radio' id='izyy' name='occupation' value='Working' required />
											<a data-toggle="collapse" data-parent="#accordion" href="#izyy_pay"></a>


											<img src="{{ url('images/payment/iyzico.png') }}" class="img-fluid" alt="iyzipay">
										</label>
									</div>
								</div>
								<div id="izyy_pay" class="panel-collapse collapse in">
									<div class="card-body">

										<div class="payment-proceed-btn">

											<form action="{{ route('izy.pay') }}" method="POST" autocomplete="off">
												@csrf

												<div class="row">
											        <div class="col-md-12">
											            <div class="form-group">
											                <strong>{{ __('Email')}}</strong>
											                <input type="text" name="email" class="form-control" value="email@email.com"  placeholder="email@email.com" required autocomplete="off">

											            </div>
											        </div>
											        <div class="col-md-12">
											            <div class="form-group">
											                <strong>{{ __('Mobile Number')}}</strong>
											                <input type="text" name="mobile" class="form-control" value="+905350000000" placeholder="+905350000000" required autocomplete="off">
											            </div>
											        </div>

											        <div class="col-md-12">
											            <div class="form-group">
											                <strong>{{ __('Identity number')}}</strong>
											                <input type="text" name="identity_number" class="form-control" value="74300864791" placeholder="74300864791" required autocomplete="off">

											                <small class="text-muted">
																<i class="fa fa-question-circle"></i>
																{{ __('TCKN for Turkish merchants, passport number for foreign merchants')}}
															</small>
											            </div>
											        </div>
											    </div>

												@php
													$meetingPrice = session('meeting_price');
													$amount = $meetingPrice ? $meetingPrice : Crypt::decrypt($secureamount);
												@endphp
												<input type="hidden" name="conversation_id" value="{{ $conversation_id  }}" />
												<input type="hidden" name="amount" value="{{ $amount }}" />
												<input type="hidden" name="language" value="{{ $secureamount  }}" />
												<input type="hidden" name="currency" value="{{ $currency->code  }}" />
												<input type="hidden" name="fname" value="{{ Auth::user()->fname }}" />
												<input type="hidden" name="lname" value="{{ Auth::user()->lname }}" />
												<input type="hidden" name="mobile" value="{{ Auth::user()->mobile }}" />

												<input type="hidden" name="address" value="{{ Auth::user()->address }}" />
												<input type="hidden" name="city" value="{{ isset(Auth::user()->city['name']) }}" />
												<input type="hidden" name="state" value="{{ isset(Auth::user()->state['name']) }}" />
												<input type="hidden" name="country" value="{{ isset(Auth::user()->country['name']) }}" />
												<input type="hidden" name="pincode" value="{{ Auth::user()->pin_code }}" />

												<input type="hidden" name="language" value="{{ Session::get('changed_language') }}" />
												

												<button class="btn btn-primary" title="checkout"
													type="submit">{{ __('Proceed') }}</button>
											</form>
											

										</div>
									</div>
								</div>
							</div>
							@endif

							@php
							$sslSupportedCurrencies = [
								'BDT'  // Bangladeshi Taka
							];
							$sessionCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
							$currencyCode = strtoupper($sessionCurrency);
							$isCurrencySupported = in_array($currencyCode, $sslSupportedCurrencies);
							@endphp
							
							@if($gsetting->ssl_enable == 1 && $isCurrencySupported)
							<div class="card">
								<div class="card-header" id="headingssl">
									<div class="panel-title">
										<label for='ssl'>
											<input type='radio' id='ssl' name='occupation' value='Working' required />
											<a data-toggle="collapse" data-parent="#accordion" href="#ssl_pay"></a>


											<img src="{{ url('images/payment/ssl.png') }}" class="img-fluid" alt="sslpay">
										</label>
									</div>
								</div>
								<div id="ssl_pay" class="panel-collapse collapse in">
									<div class="card-body">

										<div class="payment-proceed-btn">

											<form action="{{ route('payvia.sslcommerze') }}" method="POST">
					                          @csrf
											  <input type="hidden" name="amount" value="{{ session()->has('meeting_price') ? session('meeting_price') : $secureamount }}" />
					                          <button class="btn btn-primary" title="checkout"
													type="submit">{{ __('Proceed') }}
												</button>
					                        </form>
											

										</div>
									</div>
								</div>
							</div>
							@endif



							@php
							$manualpay = App\ManualPayment::where('status', '1')->get();
							@endphp


							@foreach($manualpay as $manual)
							<div class="card">
							    <div class="card-header" id="headingManual{{ $manual->id }}">
							      <h2 class="mb-0">
							        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseManual{{ $manual->id }}" aria-expanded="false" aria-controls="collapseOne">
							          <b>{{ $manual->name  }}</b>
							        </button>
							      </h2>
							    </div>

							    <div id="collapseManual{{ $manual->id }}" class="collapse" aria-labelledby="headingManual" data-parent="#accordionExample">
							      <div class="card-body">


							        <div class="payment-proceed-btn">
								        <form action="{{ route('manualpay.checkout') }}" method="POST" enctype="multipart/form-data">
			                              	@csrf
			                              	<input type="hidden" name="payment_name" value="{{ $manual->name }}">
			                              	<input type="hidden" name="amount" value="{{ Crypt::decrypt($secureamount) }}">

				                            <div class="form-group">
				                                <input type="file" name="proof" required />
									          	<br>
									            <small>({{ __('Please Document') }})</small>

				                            </div>

			                               	<button class="btn btn-primary " type="submit" value="Pay Now">{{ __('Proceed') }}</button>
			                            </form>
			                        </div>
			                        <br>
			                        <br>


			                        <div class="row">
                                
		                                <div class="col-md-12">
		                                  {!! $manual->detail !!}
		                                </div>

		                            </div>
		                             
		                            @if($manual->image != '' && file_exists(public_path().'/images/manualpayment/'.$manual->image) )

		                                <div class="card card-1">
		                                  <div class="text-center card-body">
		                                   
		                                  <img width="300px" height="300px" class="img-fluid" src="{{ url('images/manualpayment/'.$manual->image) }}" alt="{{ $manual->image }}">
		                                  </div>
		                                </div>

		                            @endif

			                        

							      </div>
							    </div>
							</div>
							@endforeach
							@php
							$aamarpaySupportedCurrencies = [
								'BDT'  // Bangladeshi Taka
							];
							$sessionCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
							$currencyCode = strtoupper($sessionCurrency);
							$isCurrencySupported = in_array($currencyCode, $aamarpaySupportedCurrencies);
							@endphp

							@if($gsetting->aamarpay_enable == 1 && $isCurrencySupported)
							<div class="card">
								<div class="card-header" id="headingaamar">
									<div class="panel-title">
										<label for='aamar'>
											<input type='radio' id='aamar' name='occupation' value='Working' required />
											<a data-toggle="collapse" data-parent="#accordion" href="#aamar_pay"></a>


											<img src="{{ url('images/payment/aamarpay.png') }}" class="img-fluid" alt="aamarpay">
										</label>
									</div>
								</div>
								<div id="aamar_pay" class="panel-collapse collapse in">
									<div class="card-body">

										<div class="payment-proceed-btn">
											@php
											$user_name = Auth::user()->fname;
											$user_email = Auth::user()->email;
											$user_mobile = Auth::user()->email;
											@endphp
											<div class="aamar-pay-btn">
												{!! 
												aamarpay_post_button([
												    'cus_name'  => $user_name, // Customer name
												    'cus_email' => $user_email, // Customer email
												    'cus_phone' => $user_mobile // Customer Phone
												], $mainpay, 'Proceed', 'btn btn-sm btn-primary') 
												!!}
											</div>
										</div>
									</div>
								</div>
							</div>
							@endif

							@php
								$braintreeSupportedCurrencies = [
									'AUD', 'BRL', 'CAD', 'CHF', 'CNY', 'CZK', 'DKK', 'EUR', 'GBP',
									'HKD', 'HUF', 'ILS', 'JPY', 'MXN', 'NZD', 'NOK', 'PLN', 'SEK',
									'SGD', 'THB', 'USD'
								];
								$sessionCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
								$currencyCode = strtoupper($sessionCurrency);
								$isCurrencySupported = in_array($currencyCode, $braintreeSupportedCurrencies);
								@endphp
							@if($gsetting->braintree_enable == 1 && $isCurrencySupported)
							<div class="card">
	                            <div class="card-header" id="headingFive">
							        <div class="panel-title">
							            <label for='r15'>
							              <input type='radio' id='r15' name='occupation' value='Working' required />
							              <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive"></a>
							              <img src="{{ url('images/payment/braintree.png') }}" style="margin-left: 15px;" height="30px" width="90px" class="img-fluid-img" alt="course"> 
							            </label>
							        </div>
						    	</div>
							    <div id="collapseFive" class="panel-collapse collapse in">
							        <div class="card-body">
		                            	<div class="payment-proceed-btn">

	                            		<h3 class="plan-dtl-heading">{{ __('Checkout With Braintree')}}</h3>
               
		                            		

		                            	<form method="post" id="payment-form" action="{{ url('/checkout') }}">
						                    @csrf
						                    <section>
						                        <label for="amount">
						                           
						                            <div class="input-wrapper amount-wrapper">
														<input type="hidden" name="amount" id="amount" type="tel" min="1" value="{{ session()->has('meeting_price') ? session('meeting_price') : $mainpay }}" />
						                            </div>
						                        </label>

						                        <div class="bt-drop-in-wrapper">
						                            <div id="bt-dropin"></div>
						                        </div>
						                    </section>

						                    <input id="nonce" name="payment_method_nonce" type="hidden" />
						                    <button class="btn btn-primary" type="submit"><span>{{ __('Proceed') }}</span></button>
						                </form>

	                            		</div>
							        </div>
							    </div>
							</div>
							@endif


						
					        @php
							  $wallet_settings = App\WalletSettings::first();
							@endphp

							@if(isset($wallet_settings) && $wallet_settings->status == 1)
							
								<div class="card">
									<div class="card-header" id="headingWallet">
										<div class="panel-title">
											<label for='wallet'>
											<input type='radio' id='wallet' name='occupation' value='Working' required />
											<a data-toggle="collapse" data-parent="#accordion" href="#collapseWallet"></a>&emsp;
											<i class="fas fa-wallet"></i> <b>{{ __('Wallet Checkout') }}</b>
											</label>
											
										</div>
									</div>
									<div id="collapseWallet" class="panel-collapse collapse in">
										<div class="card-body">
											<div class="payment-proceed-btn">

											<h3 class="plan-dtl-heading">{{ __('Checkout With Wallet') }}</h3>

											@if(isset(auth()->user()->wallet))
											@if(auth()->user()->wallet->status == 1)
												@if(round(auth()->user()->wallet->balance) >= sprintf("%.2f",Crypt::decrypt(strip_tags($secureamount))))	

													<form method="post" id="payment-form" action="{{ url('wallet/checkout/wallet/payment') }}">
														@csrf

														<input id="nonce" name="amount" type="hidden" value="{{ Crypt::decrypt($secureamount) }}" />
													

														<button class="btn btn-primary" type="submit"><span>{{ __('Proceed') }}</span></button>
													</form>
												@else

												<h3 class="plan-dtl-heading">{{ __('Insufficient Wallet Balance') }}</h3>

												@endif

												@endif
											@endif

											</div>
										</div>
									</div>
								</div>

							@endif


					        @if(Module::has('MPesa') && Module::find('MPesa')->isEnabled())
					            @include('mpesa::front.checkout_form')
					        @endif

							@php
							$payflexiSupportedCurrencies = [
								'INR', 'USD', 'EUR', 'GBP', 'AUD', 'CAD', 'SGD'
							];
							$sessionCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
							$currencyCode = strtoupper($sessionCurrency);
							$isCurrencySupported = in_array($currencyCode, $payflexiSupportedCurrencies);
							@endphp
					        @if($gsetting->payflexi_enable == 1 && $isCurrencySupported)
								<div class="card">
									<div class="card-header" id="headingOne">
										<div class="panel-title">
											<label for='payflexi'>
												<input type='radio' id='payflexi' name='occupation' value='Working' required />
												<a data-toggle="collapse" data-parent="#accordion" href="#payflexi_pay"></a>

												<img src="{{ url('images/payment/payflexi.png') }}" class="img-fluid"
													alt="course">
											</label>
										</div>
									</div>
									<div id="payflexi_pay" class="panel-collapse collapse in">
										<div class="card-body">

											<div class="payment-proceed-btn">

												@php
												$array = array('title' => 'Online Course');
												@endphp

												<form method="POST" action="{{ route('payflexi.pay') }}" id="paymentForm">
													{{ csrf_field() }}
													<input type="hidden" name="key" value="{{ env('PAYFLEXI_SECRET_KEY') }}"> 
													<input type="hidden" name="amount" value="{{ session()->has('meeting_price') ? session('meeting_price') : Crypt::decrypt($secureamount) }}" />
													<input type="hidden" name="gateway" value="{{ env('PAYFLEXI_PAYMENT_GATEWAY') }}" />
													<input type="hidden" name="currency" value="{{ $currency->code }}" />
													<input type="hidden" name="email" value="{{ Auth::user()->email }}" />
													<input type="hidden" name="name" value="{{ Auth::user()->fname . ' ' . Auth::user()->lname }}" />
													<input type="hidden" name="meta" value="{{ json_encode($array) }}">
													<input type="hidden" name="phone" value="{{ Auth::user()->mobile }}" />
													<button class="btn btn-primary" title="checkout"
														type="submit">{{ __('Proceed') }}</button>
												</form>

											</div>
										</div>
									</div>
								</div>
							@endif


							@if(Module::has('Esewa') && Module::find('Esewa')->isEnabled())
					            @include('esewa::front.checkout_form')
					        @endif


					        @if(Module::has('Smanager') && Module::find('Smanager')->isEnabled())
					            @include('smanager::front.checkout_form')
					        @endif


					        @if(Module::has('Paytab') && Module::find('Paytab')->isEnabled())
					            @include('paytab::front.checkout_form')
					        @endif


					        @if(Module::has('DPOPayment') && Module::find('DPOPayment')->isEnabled())
					            @include('dpopayment::front.checkout_form')
					        @endif

					        @if(Module::has('AuthorizeNet') && Module::find('AuthorizeNet')->isEnabled())
					            @include('authorizenet::front.checkout_form')
					        @endif

					        @if(Module::has('Bkash') && Module::find('Bkash')->isEnabled())
					            @include('bkash::front.checkout_form')
					        @endif

					        @if(Module::has('Midtrains') && Module::find('Midtrains')->isEnabled())
					            @include('midtrains::front.checkout_form')
					        @endif

					        @if(Module::has('SquarePay') && Module::find('SquarePay')->isEnabled())
					            @include('squarepay::front.checkout_form')
					        @endif

					        @if(Module::has('Worldpay') && Module::find('Worldpay')->isEnabled())
					            @include('worldpay::front.checkout_form')
					        @endif

							@if(Module::has('Onepay') && Module::find('Onepay')->isEnabled())
					            @include('onepay::front.checkout_form')
					        @endif
							@endif
                        </div>
	            	</div>
	            	
	            </div>
	        </div>
	    </div>
	</div>
</section>

@endsection

@section('custom-script')

<script src="{{ url('js/jquery.payform.min.js')}}" charset="utf-8"></script>
<script src="{{ url('js/script.js') }}"></script>

{{-- <script src="{{ url('js/jquery.min.js') }}"></script>   --}}

@stack('custom-script')


@if($gsetting->braintree_enable == 1) 

	@php
		$gateway = new Braintree\Gateway([
            'environment' => env('BRAINTREE_ENV'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY'),
        ]);

        $token = $gateway->ClientToken()->generate();

	@endphp

	<script src="https://js.braintreegateway.com/web/dropin/1.13.0/js/dropin.min.js"></script>
	 
    <script>
        var form = document.querySelector('#payment-form');
        var client_token = "{{ $token }}";

        braintree.dropin.create({
          authorization: client_token,
          selector: '#bt-dropin',
          paypal: {
            flow: 'vault'
          }
        }, function (createErr, instance) {
          if (createErr) {
            console.log('Create Error', createErr);
            return;
          }
          else{
	          $('.bt-btn').hide();
	          $('.braintree').show();
	        }
          form.addEventListener('submit', function (event) {
            event.preventDefault();

            instance.requestPaymentMethod(function (err, payload) {
              if (err) {
                console.log('Request Payment Method Error', err);
                return;
              }

              // Add the nonce to the form and submit
              document.querySelector('#nonce').value = payload.nonce;
              form.submit();
            });
          });
        });
    </script>

@endif

@if(config('bkash.ENABLE') == 1 && Module::has('Bkash') && Module::find('Bkash')->isEnabled())
  
    @include("bkash::front.bkashscript")
 
@endif

@if(env('MID_TRANS_ENABLE') == 1 && Module::has('Midtrains') && Module::find('Midtrains')->isEnabled())
  
    @include("midtrains::front.midtrans_script")
 
@endif


<script src="https://js.stripe.com/v3/"></script>
<script>var stripeKey = Stripe("{{ env('STRIPE_KEY') }}")</script>
<script src="{{ url('js/stripe.js') }}"></script>
@endsection