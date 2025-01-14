@extends('theme.master')
@section('title', 'Cart')
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
    <div class="container-xl">
        <div class="business-dtl">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bredcrumb-dtl">
                        <h1 class="wishlist-home-heading">{{ __('Shopping Cart') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- about-home end -->
<section id="cart-block" class="cart-main-block">
	<div class="container-xl">
		<h4 class="cart-heading">
			@php
				if(Auth::check())
				{
					$item = App\Cart::where('user_id', Auth::User()->id)->get();
				}
				else{

				}
				

				if($item != NULL){

					echo count($item);
				}
				else{

					echo "0";
				}
			@endphp
			
			{{ __('Courses in Cart') }}
		</h4>
		@if($carts != NULL)
			<div class="row">
				<div class="col-lg-9 col-md-9">
					@auth
					@foreach($carts as $cart)
						<div class="cart-add-block">
							<div class="row">
								<div class="col-lg-3 col-sm-6 col-5">
									<div class="cart-img">
										@if($cart->course_id != NULL)
											@if($cart->courses['preview_image'] !== NULL && $cart->courses['preview_image'] !== '')
												<a href="{{ route('user.course.show',['slug' => $cart->courses->slug ]) }}"><img src="{{ asset('images/course/'. $cart->courses->preview_image) }}" class="img-fluid" alt="blog"></a>
											@else
												<a href="{{ route('user.course.show',['slug' => $cart->courses->slug ]) }}"><img src="{{ Avatar::create($cart->courses->title)->toBase64() }}" class="img-fluid" alt="blog"></a>
											@endif
										@else
											@if($cart->bundle['preview_image'] !== NULL && $cart->bundle['preview_image'] !== '')
												<a href="{{ route('user.course.show',['slug' => $cart->bundle->slug ]) }}"><img src="{{ asset('images/bundle/'. $cart->bundle->preview_image) }}" class="img-fluid" alt="blog"></a>
											@else
												<a href="{{ route('user.course.show',['slug' => $cart->bundle->slug ]) }}"><img src="{{ Avatar::create($cart->bundle->title)->toBase64() }}" class="img-fluid" alt="blog"></a>
											@endif
										@endif


									</div>
								</div>
								<div class="col-lg-5 col-sm-6 col-6">
									<div class="cart-course-detail">
										@if($cart->course_id != NULL)
											<div class="cart-course-name"><a href="{{ route('user.course.show',['slug' => $cart->courses->slug ]) }}">{{ str_limit($cart->courses->title, $limit = 50, $end = '...') }}</a></div>

											<div class="cart-course-update"> {{ $cart->courses->user->fname }}</div>
										@else
											<div class="cart-course-name"><a href="{{ route('user.course.show',['slug' => $cart->bundle->slug ]) }}">{{ str_limit($cart->bundle->title, $limit = 50, $end = '...') }}</a></div>

											<div class="cart-course-update"> {{ $cart->bundle->user->fname }}</div>
										@endif
										
										<ul>

											<li>
												<i data-feather="play-circle"></i>
												<div class="class-des">
													@php
													$data = App\CourseClass::where('course_id', $cart->id)->count();
													if($data>0){

													echo $data;
													}
													else{

													echo "0";
													}
													@endphp {{ __('Classes') }}
												</div>
											</li>
											<li>
												<i data-feather="clock"></i>
												<div class="time-des">


													<span class="">
														@php
														$classtwo = App\CourseClass::where('course_id', $cart->id)->sum("duration");

														@endphp
														{{ $classtwo }} {{ __('Minutes')}}
													</span>
												</div>
											</li>
											<li>
												<i data-feather="user"></i>
												<div class="student-des">
													@php
													$enroll = App\Order::where('course_id', $cart->id)->count();
													if($enroll>0){

													echo $enroll;
													}
													else{

													echo "0";
													}



													@endphp {{ __('Students') }}
												</div>
											</li>
											<li>
												@if(isset($cart->level_tags))
												<i data-feather="align-justify"></i>
												<div class="all-levels-des">
													{{ optional($cart)->level_tags }}
												</div>
												@endif
											</li>
										</ul>
									</div>
								</div>
								<div class="col-lg-2 col-sm-6 col-6">
									<div class="cart-actions float-right">
										<span>
											<form id="cart-form" method="post" action="{{url('removefromcart', $cart->id)}}" 
												data-parsley-validate class="form-horizontal form-label-left">
												{{ csrf_field() }}
												
												<button  type="submit" class="cart-remove-btn display-inline" title="Remove From cart"><i data-feather="shopping-cart"></i>{{ __('Cart Remove') }}</button>
											</form>
										</span>
										<span>
											<form id="wishlist-form" method="post" action="{{ url('show/wishlist', $cart->id ) }}" data-parsley-validate class="form-horizontal form-label-left">
												{{ csrf_field() }}

												<input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
												<input type="hidden" name="course_id"  value="{{$cart->course_id}}" />

												<button class="cart-wishlisht-btn" title="Remove to wishlist" type="submit"><i data-feather="heart"></i>{{ __('Wishlist Remove') }}</button>
											</form>
										</span>
										
									</div>
								</div>
								<div class="col-lg-2 col-sm-6 col-6">
									<div class="cart-amt-rating">
										<div class="row float-right">
											<div class="col-lg-9 col-10">
												<div class="cart-course-amount">
													<ul>
														
														@if($cart->offer_price == !NULL)
															
															<li>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($cart->offer_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false) )}}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</li>

															<li><s>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(   currency($cart->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</s></li>
															
														@else
															
															<li>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(   currency($cart->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</li>
														@endif
														
													</ul>
													<div class="rating">
														<ul>
															<li>
																<?php 
																$learn = 0;
																$price = 0;
																$value = 0;
																$sub_total = 0;
																$sub_total = 0;
																$reviews = App\ReviewRating::where('course_id',$cart->id)->get();
																?> 
																@if(!empty($reviews[0]))
																<?php
																$count =  App\ReviewRating::where('course_id',$cart->id)->count();
		
																foreach($reviews as $review){
																	$learn = $review->price*5;
																	$price = $review->price*5;
																	$value = $review->value*5;
																	$sub_total = $sub_total + $learn + $price + $value;
																}
		
																$count = ($count*3) * 5;
																$rat = $sub_total/$count;
																$ratings_var = ($rat*100)/5;
																?>
												
																<div class="pull-left">
																	<div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
																	</div>
																</div>
															
																
																@else
																	<div class="pull-left">{{ __('No Rating') }}</div>
																@endif
															</li>
															<!-- overall rating-->
															<?php 
															$learn = 0;
															$price = 0;
															$value = 0;
															$sub_total = 0;
															$count =  count($reviews);
															$onlyrev = array();
		
															$reviewcount = App\ReviewRating::where('course_id', $cart->id)->WhereNotNull('review')->get();
		
															foreach($reviews as $review){
		
																$learn = $review->learn*5;
																$price = $review->price*5;
																$value = $review->value*5;
																$sub_total = $sub_total + $learn + $price + $value;
															}
		
															$count = ($count*3) * 5;
															
															if($count != "" && $count != '0')
															{
																$rat = $sub_total/$count;
														
																$ratings_var = ($rat*100)/5;
														
																$overallrating = ($ratings_var/2)/10;
															}
															
															?>
		
															@php
																$reviewsrating = App\ReviewRating::where('course_id', $cart->id)->first();
															@endphp
															<li class="reviews">
																(@php
																$data = App\ReviewRating::where('course_id', $cart->id)->count();
																if($data>0){
						
																echo $data;
																}
																else{
						
																echo "0";
																}
																@endphp Reviews)
															</li>
														</ul>
													</div>
												</div>
											</div>
											<div class="col-lg-3 col-2">
												{{-- @if($cart->disamount == !NULL) --}}
													{{-- @if(Session::has('coupanapplied')) --}}
													<div class="cart-coupon">
														{{-- <a href="" class="btn btn-link top" data-toggle="tooltip" data-placement="top" title="{{Session::get('coupanapplied')['msg']}}"><i class="fa fa-tag"></i></a> --}}
													</div>
													{{-- @endif --}}
												{{-- @endif --}}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					@endforeach
					@endauth

					@guest
					@foreach($carts as $c)
						@php
						$cart = App\Course::where('id', $c)->where('status', '1')->first();
						@endphp
						<div class="cart-add-block">
							<div class="row no-gutters">
								<div class="col-lg-2 col-sm-6 col-5">
									<div class="cart-img">
										
										@if($cart->preview_image !== NULL && $cart->preview_image !== '')
											<a href="{{ route('user.course.show',['slug' => $cart->slug ]) }}"><img src="{{ asset('images/course/'. $cart->preview_image) }}" class="img-fluid" alt="blog"></a>
										@else
											<a href="{{ route('user.course.show',['slug' => $cart->slug ]) }}"><img src="{{ Avatar::create($cart->title)->toBase64() }}" class="img-fluid" alt="blog"></a>
										@endif

									</div>
								</div>
								<div class="col-lg-4 col-sm-6 col-6">
									<div class="cart-course-detail">
										
										<div class="cart-course-name"><a href="{{ route('user.course.show',['slug' => $cart->slug ]) }}">{{ str_limit($cart->title, $limit = 50, $end = '...') }}</a></div>

										<div class="cart-course-update"> {{ $cart->user->fname }}</div>
										

									</div>
								</div>
								<div class="col-lg-2 offset-lg-1 col-sm-6 col-6">
									<div class="cart-actions">
										<span>
											<form id="cart-form" method="post" action="{{ auth()->check() ? url('removefromcart', $cart->id) : route('guest.removefromcart', $cart->id)}}" {{-- hmd --}}

												data-parsley-validate class="form-horizontal form-label-left">
												{{ csrf_field() }}
												
												<button  type="submit" class="cart-remove-btn display-inline" title="Remove From cart">{{ __('Remove') }}</button>
											</form>
										</span>
										
										
									</div>
								</div>
								<div class="col-lg-3 col-sm-6 col-6">
									<div class="row">
										<div class="col-lg-10 col-10">
											<div class="cart-course-amount">
												<ul>
													
													@if($cart->discount_price == !NULL)
														
														<li>{{ currency($cart->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}</li>

														<li><s>{{ currency($cart->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}</s></li>
														
													@else
														
														<li>{{ currency($cart->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}</li>
														
													@endif
													
												</ul>
											</div>
										</div>
										<div class="col-lg-2 col-2">
											@if($cart->disamount == !NULL)
												@if(Session::has('coupanapplied'))
												<div class="cart-coupon">
													<a href="" class="btn btn-link top" data-toggle="tooltip" data-placement="top" title="{{Session::get('coupanapplied')['msg']}}"><i class="fa fa-tag"></i></a>
												</div>
												@endif
											@endif
										</div>
									</div>
								</div>
							</div>
						</div>
					@endforeach
					@endguest
					<div class="container-xl" id="adsense">
						<!-- google adsense code -->
						<?php
							if (isset($ad)) {
							if ($ad->iscart==1 && $ad->status==1) {
								$code = $ad->code;
								echo html_entity_decode($code);
							}
							}
						?>
					</div>
				</div>
				<div class="col-lg-3 col-md-3">
					@if(count($item)>0)
						<div class="cart-total">
							@php
								if(auth::check())
								{
									$cartitems = App\Cart::where('user_id', Auth::User()->id)->first();
								}
								else
								{
									$cartitems = session()->get('cart.add_to_cart');
								}
							@endphp
							@if ($cartitems == NULL)
								{{ __('empty') }}
							@else

							<div class="cart-price-detail">
								<h4 class="cart-heading">{{ __('Total') }}:</h4>
								<ul>
									
									<li>{{ __('Total Price') }}<span class="categories-count">{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }} {{ price_format(  currency($price_total, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</span></li>

									<li>{{ __('Offer Discount') }}<span class="categories-count">&nbsp;{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }} {{ price_format(  currency($price_total - $offer_total, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</span></li>
									
									

									<li>{{ __('Coupon Discount') }}
										@if( $cpn_discount == !NULL)
											
											<span class="categories-count">-&nbsp;{{ currency($cpn_discount, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}  </span>
											
										@else
											<span class="categories-count"><a href="#" data-toggle="modal" data-target="#myModalCoupon" title="report">{{ __('Apply Coupon') }}</a></span>
										@endif
									</li>
									<li>{{ __('Discount Percent') }}<span class="categories-count">{{ round($offer_percent, 0) }}% {{ __('off') }}</span></li>
									<hr>
									
									<li class="cart-total-two"><b>{{ __('Total') }}:<span class="categories-count">{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }} {{ price_format( currency($cart_total, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></span></li>
									
								</ul>
							</div>


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
							@endif
							<hr>
							@auth
							<div class="coupon-apply">
								<form id="cart-form" method="post" action="{{url('apply/coupon')}}" 
									data-parsley-validate class="form-horizontal form-label-left">
									{{ csrf_field() }}

									<div class="row no-gutters">
										<div class="col-lg-9 col-9">
											<input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
											<input type="text" name="coupon" value="" placeholder="Enter Coupon" />
										</div>
										<div class="col-lg-3 col-3">
											<button data-purpose="coupon-submit" type="submit" class="btn btn-primary"><span>{{ __('Apply') }}</span></button>
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
							
						</div>
					@endif
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

	<!--Model start-->
	@auth
	<div class="modal fade" id="myModalCoupon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	    <div class="modal-dialog modal-md" role="document">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title" id="myModalLabel">{{ __('Coupon Code') }}</h4>
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        </div>
	        <div class="box box-primary">
	          <div class="panel panel-sum">
	            <div class="modal-body">
	            	<div class="coupon-apply">
						<form id="cart-form" method="post" action="{{url('apply/coupon')}}" 
	                    	data-parsley-validate class="form-horizontal form-label-left">
	                        {{ csrf_field() }}
	                        
		                	<div class="row no-gutters">
		                		<div class="col-lg-9 col-9">
		                			<input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
	                    			<input type="text" name="coupon" value="" placeholder="Enter Coupon" />
	                    		</div>
	                    		<div class="col-lg-3 col-3">
	                    			<button data-purpose="coupon-submit" type="submit" class="btn btn-primary"><span>{{ __('Apply') }}</span></button>
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
	@endauth
	<!--Model close -->
</section>


@endsection
