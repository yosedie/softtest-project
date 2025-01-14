@extends('theme2.master')
@section('title', 'Cart')
@section('content')
@include('admin.message')

<!-- about-home start -->
@php
$gets = App\Breadcum::first();
@endphp
	@if($gets['img'] !== NULL && $gets['img'] !== '')
	<section class="breadcrumb-area d-flex  p-relative align-items-center" style="background-image: url('{{ asset('/images/breadcum/'.$gets->img) }}')">
	@else
	<section class="breadcrumb-area d-flex  p-relative align-items-center" style="background-image: url('{{ asset('Avatar::create($gets->text)->toBase64() ') }}')">
	@endif
	<div class="overlay-bg"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-12 col-lg-12">
                <div class="breadcrumb-wrap text-left">
                    <div class="breadcrumb-title">
                        <h2>{{ __('Shopping Cart') }}</h2>    
                        
                    </div>
                </div>
            </div>
			<div class="breadcrumb-wrap2">
                  
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('Shopping Cart')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- about-home end -->

<section id="cart-block" class="cart-main-block">
	<div class="container-xl">
		<div class="cart-items btm-30">
			<h4 class="cart-heading">{{__('1 Courses in Cart')}}</h4>
            @if($carts != NULL)
			<div class="row">
				<div class="col-lg-8 col-md-9">
					@auth
	        			@foreach($carts as $cart)
					<div class="cart-add-block">
						<div class="row">
							<div class="col-lg-2 col-sm-6 col-5">
								<div class="cart-img">
									@if($cart->course_id != NULL)
				                    @if($cart->courses['preview_image'] !== NULL && $cart->courses['preview_image'] !== '')
									<a href="{{ route('user.course.show',['slug' => $cart->courses->slug ]) }}">
										<img src="{{ asset('images/course/'. $cart->courses->preview_image) }}" class="img-fluid" alt="blog">
										@else
										<a href="{{ route('user.course.show',['slug' => $cart->courses->slug ]) }}">
											<img src="{{ Avatar::create($cart->courses->title)->toBase64() }}" class="img-fluid" alt="blog">
										@endif	
										@endif	
									</a>
								</div>
							</div>
							<div class="col-lg-5 col-sm-6 col-6">
								<div class="cart-course-detail">
									@if($cart->course_id != NULL)
			                    	<div class="cart-course-name">
										<a href="{{ route('user.course.show',['slug' => $cart->courses->slug ]) }}">{{ str_limit($cart->courses->title, $limit = 50, $end = '...') }}</a>
									</div>
									<div class="cart-course-update">{{ $cart->courses->user->fname }} </div>
									@else
									<div class="cart-course-name">
										<a href="{{ route('user.course.show',['slug' => $cart->bundle->slug ]) }}">{{ str_limit($cart->bundle->title, $limit = 50, $end = '...') }}</a>
									</div>
									<div class="cart-course-update">{{ $cart->courses->user->fname }} </div>
									@endif
								</div>
							</div>
							<div class="col-lg-3 col-sm-6 col-6">
								<div class="cart-actions float-right">
									<span>
										<form id="cart-form" method="post" action="{{url('removefromcart', $cart->id)}}" 
											data-parsley-validate class="form-horizontal form-label-left">
											{{ csrf_field() }}
											
										  <button  type="submit" class="cart-remove-btn display-inline" title="Remove From cart">{{ __('Remove') }}</button>
										</form>
									</span>
									<span>
										<form id="wishlist-form" method="post" action="{{ url('show/wishlist', $cart->id ) }}" data-parsley-validate class="form-horizontal form-label-left">
											{{ csrf_field() }}

											<input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
											<input type="hidden" name="course_id"  value="{{$cart->course_id}}" />

											<button class="cart-wishlisht-btn" title="Remove to wishlist" type="submit">{{ __('Remove to Wishlist') }}</button>
										</form>
									</span>
									
								</div>
			                </div>
							<div class="col-lg-2 col-sm-6 col-6">
								<div class="row float-right">
									<div class="col-lg-10 col-10">
										<div class="cart-course-amount">
											<ul>		
												@if($cart->offer_price == !NULL)
												<li><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($cart->offer_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false) )}}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></li>
												<li><s>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(   currency($cart->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</s></li>
												@else
												<li>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(   currency($cart->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</li>
												@endif							
											</ul>
										</div>
									</div>
									<div class="col-lg-2 col-2">
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
	                @endauth 
				</div>
				<div class="col-lg-4 col-md-3">
					<div class="cart-total">                   
						<div class="cart-price-detail">
							<h4 class="cart-heading">{{__('Total:')}}</h4>
							<table class="table">
								<tbody>
									<tr>
										<td style="width: 70%;">{{__('Total price')}}</td>
										<td>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }} {{ price_format(  currency($price_total, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</td>
									</tr>
									<tr>
										<td style="width: 70%;">{{__('Offer Discount')}}</td>
										<td class="wishlist-out-stock">{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }} {{ price_format(  currency($price_total - $offer_total, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</td>
									</tr>
									<tr>
										<td style="width: 70%;">{{__('Coupon Discount')}}</td>
										@if( $cpn_discount == !NULL)
										<td class="wishlist-out-stock"><span class="categories-count"><a href="#" data-toggle="modal" data-target="#myModalCoupon" title="report">{{__('ApplyCoupon')}}</a>{{ currency($cpn_discount, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}</span>
										@else
										<td class="wishlist-out-stock"><span class="categories-count"><a href="#" data-toggle="modal" data-target="#myModalCoupon" title="report">{{__('ApplyCoupon')}}</a>
										</td>
										@endif
									</tr>
									<tr>
										<td style="width: 70%;">{{__('Discount Percent')}}</td>
										<td class="wishlist-stock">{{ round($offer_percent, 0) }}% {{ __('off') }}</td>
									</tr>
								</tbody>
							</table>
							<table class="table total-amount-table">
								<tbody>
								<tr>
									<td style="width: 65%;">{{__('Total:')}}</td>
									<td><span class="categories-count"> {{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }} {{ price_format( currency($cart_total, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</span></td>
								</tr>
								</tbody>
							</table>
							@auth
							<div class="coupon-apply mb-4">
								<form id="cart-form" method="post" action="{{url('apply/coupon')}}" data-parsley-validate class="form-horizontal form-label-left" >
                                    {{ csrf_field() }}
									<div class="row g-0">
										<div class="col-lg-9 col-9">
											<input type="hidden" name="user_id" value="{{Auth::User()->id}}">
											<input type="text" name="coupon" value="" placeholder="Enter Coupon">
										</div>
										<div class="col-lg-3 col-3">
											<button data-purpose="coupon-submit" type="submit" class="btn btn-primary"><span>{{__('Apply')}}</span></button>
										</div>
									</div>
								</form>
							</div>
							@endauth
							@if(Session::has('fail'))
									<div class="alert alert-danger alert-dismissible fade show">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
										{{ Session::get('fail') }}
									</div>
								@endif
								@if(Session::has('coupanapplied'))
									<form id="demo-form2" method="post" action="{{ route('remove.coupon', Session::get('coupanapplied')['cpnid']) }}">
										{{ csrf_field() }}
											
										<div class="remove-coupon">
										<button type="submit" class="btn btn-primary" title="Remove Coupon"><i class="fa fa-times icon-4x" aria-hidden="true"></i></button>
										</div>
									</form>
									<div class="coupon-code">   
										{{Session::get('coupanapplied')['msg']}}
									</div>
								@endif
							<div class="course-rate">			                        
								
									<div class="checkout-btn">

			                        	@if(round($cart_total) == 0)

			                        		<a href="{{url('free/enroll',$cart_total)}}" class="btn btn-primary" title="Enroll Now">{{ __('Enroll Now') }}</a>


			                     		@else


				                     		@if(auth::check())

				                        		<form id="cart-form" action="{{url('gotocheckout')}}" data-parsley-validate class="form-horizontal form-label-left">
				                           
				    	                        @csrf
												@php
													session()->put('price_total',$price_total);
													session()->put('offer_total',$offer_total);
													session()->put('offer_percent',$offer_percent);
													session()->put('cart_total',$cart_total);
												@endphp
				    	                      
				    	                      
							                    
				    	                        
				    	                      <button class="btn btn-primary" title="checkout" type="submit">{{ __('Checkout') }}</button>
				    	                    </form>
				    	                    @else
				                        		
				                        		<a href="{{url('guest/register')}}" class="btn btn-primary" title="checkout" type="submit">{{ __('Checkout') }}</a>
				                        	@endif



			                     		@endif

			                        	
			    	                    
			                    	</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			@else
			<div class="cart-no-result">
				<i class="fa fa-shopping-cart"></i>
				<div class="no-result-courses btm-10">{{ __('cart empty') }}</div>
				<div class="recommendation-btn text-white text-center">
					<a href="{{ url('/') }}" class="btn btn-primary" title="Keep Shopping"><b>{{ __('Keep Shopping') }}</b></a>
				</div> 
			</div>
		@endif
		</div>
	</div>

	<!--Model start-->
	@auth	
	<div class="modal fade" id="myModalCoupon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	    <div class="modal-dialog modal-md" role="document">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title" id="myModalLabel">{{__('Coupon Code')}}</h4>
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        </div>
	        <div class="box box-primary">
	          <div class="panel panel-sum">
	            <div class="modal-body">
	            	<div class="coupon-apply">
						<form id="cart-form" method="post" action="{{url('apply/coupon')}}" data-parsley-validate class="form-horizontal form-label-left">
							{{ csrf_field() }}
	                        
		                	<div class="row no-gutters">
		                		<div class="col-lg-9 col-9">
		                			<input type="hidden" name="user_id" value="{{Auth::User()->id}}">
	                    			<input type="text" name="coupon" value="" placeholder="Enter Coupon">
	                    		</div>
	                    		<div class="col-lg-3 col-3">
	                    			<button data-purpose="coupon-submit" type="submit" class="btn btn-primary"><span>{{__('Apply')}}</span></button>
	                    		</div>
	                    	</div>
	                    </form>
	                </div>
					
	                <hr>
					@if($item != NULL)
	                <div class="available-coupon">
	                	@php
	                		$cpns = App\Coupon::get();
	                		$mytime = Carbon\Carbon::now();
	                	@endphp

	                	@foreach($cpns as $cpn)
	                		@if($cpn->expirydate >= $mytime && $cpn->show_to_users == 1)
	                		<ul>
	                			<li>{{ $cpn->code }}</li>
	                		</ul>
	                		@endif
	                	@endforeach
	                	
	                </div>
	                @endif
	             </div>
	                

	            </div>
	          </div>
	        </div>
	      </div>
	    </div> 
	</div>
	@endauth
	<!--Model close -->
</section>

@endsection