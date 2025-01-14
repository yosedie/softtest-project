@extends('theme.master')
@section('title', 'Plan Checkout')
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
        <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="{{ __('course')}}" class="img-fluid">
        @endif
    </div>
    <div class="overlay-bg"></div>
    <div class="container-xl">
        <div class="business-dtl">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bredcrumb-dtl">
                        <h1 class="wishlist-home-heading">{{ __('Plan') }} {{ __('Checkout') }}</h1>
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
		<div class="plans-items btm-30">
	        <div class="row">
	        	<div class="col-lg-4 col-sm-4">
	        		
	            	<div class="checkout-items">
	            		
		            	<div class="row btm-10">
		            		<div class="col-lg-3 col-4">
		            			{{-- <div class="checkout-course-img">
		            				
		            				@if($plans['preview_image'] !== NULL && $plans->courses['preview_image'] !== '')
		            					<img src="{{ asset('images/plans/'. $plans->preview_image) }}" class="img-fluid" alt="course">
		            				@else
										<img src="{{ Avatar::create($plans->title)->toBase64() }}" class="img-fluid" alt="course">
		            				@endif
		            				
		            			</div> --}}
		            		</div>
		            		<div class="col-lg-9 col-8">
		            			<ul>
		            				
		            				<li class="checkout-course-title">{{ str_limit($plans->title, $limit =35 , $end = '...') }}</li>
		            				
		            				
		            				
	                                @if($plans->discount_price == !NULL)

	                                	<li class="checkout-course-price"><b><i class="{{ $currency->icon }}"></i>{{ $plans->price }}</b>  <s><i class="{{ $currency->icon }}"></i>{{ $plans->discount_price }}</s></li>

		                                {{-- <li class="checkout-course-price"><s><i class="{{ $currency->icon }}"></i>{{ $plans->price }}</s></li>
		                                <li class="checkout-course-price"><b><i class="{{ $currency->icon }}"></i>{{ $plans->discount_price }}</b></li> --}}
		                            @else
		                                <li class="checkout-course-price"><b><i class="{{ $currency->icon }}"></i>{{ $plans->price }}</b></li>
		                            @endif
		            			</ul>
		            		</div>
		            	</div>
	            		
	            	</div>
                </div>
	            <div class="col-lg-8 col-sm-8">
	            	<div class="checkout-pricelist">
		            	<ul>
		            		@if($plans->discount_price == !NULL)

                               <li><h1 class="checkout-total">{{ __('Total') }}: <i class="{{ $currency->icon }}"></i>{{ $plans->price }}</h1></li>
		            			<li><div class="checkout-price"><s><i class="{{ $currency->icon }}"></i>{{ $plans->discount_price }}</s></div></li>

                                
                            @else
                               <li><h1 class="checkout-total">{{ __('Total') }}: {{ $plans->price }}<i class="{{ $currency->icon }}"></i></h1></li>
		            			<li><div class="checkout-price"><s><i class="{{ $currency->icon }}"></i>{{ $plans->price }}</s></div></li>
                            @endif
		            		

		            		@php
		            			if(($plans->discount_price == !NULL)){
		            				$mainpay = round($plans->discount_price,2);
		            			}else{
		            				$mainpay = round($plans->price,2);
		            			}
		            		@endphp
		            		
		            	</ul>
	            	</div>
	            	@php  			
        				$secureamount = Crypt::encrypt($mainpay);
        			@endphp
	            	<div class="payment-gateways">
	            		<div id="accordion" class="second-accordion">


	            			@if($gsetting->paypal_enable == 1)
						    <div class="card">
	                            <div class="card-header" id="headingOne">
							        <div class="panel-title">
							            <label for='r11'>
								            <input type='radio' id='r11' name='occupation' value='Working' required />
								            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"></a>
								              
								            <img src="{{ url('images/payment/paypal2.png') }}" class="img-fluid" alt="{{ __('course')}}">
							            </label>
							        </div>
						    	</div>
							    <div id="collapseOne" class="panel-collapse collapse in">
							        <div class="card-body">
		                            
		                            	<div class="payment-proceed-btn">
		                            		<form action="{{ route('subscribewithpaypal') }}" method="POST" autocomplete="off">
		                            			@csrf

		                            			<input type="hidden" name="plan_id" value="{{ $plans->id  }}"/>
		                            			
		                         				<input type="hidden" name="amount" value="{{ $secureamount  }}"/>
		                            			<button class="btn btn-primary" title="checkout" type="submit">{{ __('Proceed') }}</button>
		                            		</form>
		                            		
		                            	</div>
							        </div>
							    </div>
							</div>
							@endif
						


							@if($gsetting->paytm_enable == 1)
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
		                            		<form method="post" action="{{ url('/plan/subscribe/paytm') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
		                            			@csrf

										            <input type="hidden" name="user_id" value="{{Auth::User()->id}}"/>
										            <input type="hidden" name="plan_id" value="{{ $plans->id  }}"/>

										          
												    <div class="row">
											        <div class="col-md-12">
											            <div class="form-group">
											                <strong>{{__('Name')}}</strong>
											                <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{Auth::User()->fname}}" required>
											            </div>
											        </div>
											        <div class="col-md-12">
											            <div class="form-group">
											                <strong>{{__('Mobile Number')}}</strong>
											                <input type="text" name="mobile" class="form-control" placeholder="Enter Mobile Number" value="{{Auth::User()->mobile}}" required autocomplete="off">
											            </div>
											        </div>
											        <div class="col-md-12">
											            <div class="form-group">
											                <strong>{{__('Email Id')}}</strong>
											                <input type="email" name="email" class="form-control" value="{{Auth::User()->email}}" placeholder="Enter Email id" required>
											            </div>
											        </div>
											        <div class="col-md-12">
											            <div class="form-group">
											                <input type="hidden" name="amount" class="form-control" placeholder="" value="{{ $mainpay }}" readonly="">
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

							

							





                        </div>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>

@endsection

