@extends('theme2.master')
@section('title', 'Purchase History')
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
                        <h2>{{ __('Purchase History') }}</h2>    
                        
                    </div>
                </div>
            </div>
			<div class="breadcrumb-wrap2">
                  
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('Purchase History')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- about-home start -->

<!-- about-home end -->

<section id="purchase-block" class="purchase-main-block">
	<div class="container-xl">
		<div class="purchase-table table-responsive">
	        <table class="table">
			  <thead>
			    <tr>
	                <th class="purchase-history-heading">{{ __('Purchase History') }}</th>
				    <th class="purchase-text">{{ __('Enroll on') }}</th>
				    <th class="purchase-text">{{ __('Enroll End') }}</th>
				    <th class="purchase-text">{{ __('Payment Mode') }}</th>
				    <th class="purchase-text">{{ __('Total Price') }}</th>
				    <th class="purchase-text">{{ __('Payment Status') }}</th>
				    <th class="purchase-text">{{ __('Actions') }}</th>
				    
			    </tr>
			  </thead>
				
				@foreach($orders as $order)
				
		            <div class="purchase-history-table">
		            	<tbody>
			            	<tr>
				    			<td >
									@if(isset($order->bundle->id))
				                    <div class="purchase-history-course-img">
				                    	@if($order->course_id != NULL)
					                    	@if($order->courses['preview_image'] !== NULL && $order->courses['preview_image'] !== '')
					                        	<a href="{{ route('user.course.show',['slug' => $order->courses->slug ]) }}"><img src="{{ asset('images/course/'. $order->courses->preview_image) }}" class="img-fluid" alt="course"></a>
					                        @else
					                        	<a href="{{ route('user.course.show',['slug' => $order->courses->slug ]) }}"><img src="{{ Avatar::create($order->courses->title)->toBase64() }}" class="img-fluid" alt="{{ __('course')}}"></a>
					                        @endif
				                        @else
				                        	@if($order->bundle['preview_image'] !== NULL && $order->bundle['preview_image'] !== '')
					                        	<a href="{{ route('bundle.detail', $order->bundle->slug) }}"><img src="{{ asset('images/bundle/'. $order->bundle->preview_image) }}" class="img-fluid" alt="course"></a>
					                        @else
					                        	<a href="{{ route('bundle.detail', $order->bundle->slug) }}"><img src="{{ Avatar::create($order->bundle->title)->toBase64() }}" class="img-fluid" alt="course"></a>
					                        @endif
					                    @endif

				                    </div>
				                    <div class="purchase-history-course-title">
				                    	@if($order->course_id != NULL)
				                        <a href="{{ route('user.course.show',['slug' => $order->courses->slug ]) }}">{{ $order->courses->title }}</a>
				                        @else
				                        <a href="{{ route('bundle.detail', $order->bundle->slug) }}">{{ $order->bundle->title }}</a>
				                        @endif
				                    </div>
									@endif
				                </td>
				                <td>
				                   	<div class="purchase-text">{{ date('jS F Y', strtotime($order->created_at)) }}</div>			                   	
				                </td>

				                <td>
				                	<div class="purchase-text">
				                		@if($order->course_id != NULL)
				                		@if($order->enroll_expire != NULL)
				                            {{ date('jS F Y', strtotime($order->enroll_expire)) }}
				                        @else
				                            -
				                        @endif
				                        @endif
				                	</div>
				                </td>

				                <td>   
				                    <div class="purchase-text">{{ $order->payment_method }}</div>
				                </td>

				              
				                
				                <td>

				                	@php
				                	$contains = Illuminate\Support\Str::contains($order->currency_icon, 'fa');
				                	@endphp
				                	@if($order->coupon_discount == !NULL)
				                		
				                    	<div class="purchase-text">
				                    		<b>
				                    		@if($contains)
				                    		<i class="fa {{ $order->currency_icon }}"></i>
				                    		@else
				                    		{{ $order->currency_icon }} 
				                    		@endif
				                    		{{ $order->total_amount - $order->coupon_discount }}
				                    		</b>
				                    	</div>
				                    	
				                    @else
				                    	
				                    	<div class="purchase-text"><b>
				                    		@if($contains)
				                    		<i class="fa {{ $order->currency_icon }}"></i>
				                    		@else 
				                    		{{ $order->currency_icon }}
				                    		@endif
				                    		{{ $order->total_amount }}</b></div>
				                    		

				                    	
				                    @endif

				                </td>

				                <td>
				                	<div class="purchase-text">
				                		@if($order->status ==1)
				                            {{ __('Received') }}
				                        @else
				                        	@if(isset($order->bundle))
											{{ __('Pending') }}
					                            {{-- @if($order->bundle['subscription_status'] !== 'active')
	                                                {{ __('Canceled') }}
	                                            @else
	                                                {{ __('Pending') }}
	                                            @endif --}}
                                            @endif
				                        @endif
				                	</div>
				                </td>
				               
				                <td>
				                    <div class="invoice-btn">
				                    	
				                    	<a href="{{route('invoice.show',$order->id)}}"  class="btn btn-secondary">{{ __('Invoice') }}</a>
				                    	
				                    </div>

			                    	@if ($order->subscription_status == 'active' && $order->payment_method !== 'Admin Enroll')
                                        <div class="unsubscribe-btn">
                                            <form id="unsubscribeForm" action="{{ route('stripe.cancelsubscription') }}"
                                                method="POST" accept-charset="UTF-8">
                                                {{ csrf_field() }}
                                                <input type="hidden" value="{{ $order->id }}" name="order_id">
                                                <a onclick="document.getElementById('unsubscribeForm').submit()"
                                                    class="btn btn-secondary">{{ __('UnSubscribe') }}</a>
                                            </form>
                                        </div>
                                    @endif

				                    @php
                                        $order_id = Crypt::encrypt($order->id);


                                    	$cor = $order->course_id;

                                    	$course = App\Course::where('id', $cor)->first();

                                    	$ref = App\RefundPolicy::where('id', optional($course)->refund_policy_id)->first();

                                    	$days = isset($ref['days']);

                                     	$orderDate = $order['created_at'];
                                    
                                     	$startDate = date("Y-m-d", strtotime("$orderDate +$days days"));

                                     	$mytime = Carbon\Carbon::now();


                                    @endphp

                                 @php

                                 $requested = App\RefundCourse::where('user_id', Auth::User()->id)->where('course_id', $order->course_id)->first();


                                 @endphp

                                   
                                @if($requested == NULL)
                                    @if($order->id) 
							            @if($order->status == 1 )
						                    @if($startDate >= $mytime)

						                    <div class="invoice-btn">
				                    	
						                    	<a href="{{route('refund.proceed',$order_id)}}"  class="btn btn-secondary">{{ __('Refund') }}</a>
						                    	
						                    </div>
						                        
						                    @endif
							            @endif
							        @endif

							    @endif
				                    

				                </td>
				                
				               
				            </tr>
				        </tbody>
		            </div>
	            
	            @endforeach
	        </table>
        </div>
	</div>
</section>


<section id="purchase-block" class="purchase-main-block">
	<div class="container-xl">
		<div class="purchase-table table-responsive">
	        <table class="table">
			  <thead>
			    <tr>
	                <th class="purchase-history-heading">{{ __('Refunds') }}</th>
				    <th class="purchase-text">{{ __('Date') }}</th>
				    <th class="purchase-text">{{ __('Amount') }}</th>
				    <th class="purchase-text">{{ __('Payment Mode') }}</th>
				    <th class="purchase-text">{{ __('Payment Status') }}</th>
				    <th class="purchase-text">{{ __('Actions') }}</th>
				    
			    </tr>
			  </thead>


			  	@foreach($refunds as $refund)
				
			
				
		        <div class="purchase-history-table">
		            <tbody>
			            <tr>
				    		<td>
				                <div class="purchase-history-course-img">
				                	@if($refund->courses['preview_image'] !== NULL && $refund->courses['preview_image'] !== '')
			                        	<a href="{{ route('user.course.show',['slug' => $refund->courses->slug ]) }}"><img src="{{ asset('images/course/'. $refund->courses->preview_image) }}" class="img-fluid" alt="course"></a>
			                        @else
			                        	<a href="{{ route('user.course.show',['slug' => $refund->courses->slug ]) }}"><img src="{{ Avatar::create($refund->courses->title)->toBase64() }}" class="img-fluid" alt="course"></a>
			                        @endif
				                </div>
				                <div class="purchase-history-course-title">
			                        <a href="{{ route('user.course.show',['slug' => $refund->courses->slug ]) }}">{{ $refund->courses->title }}</a>
			                    </div>
				            </td>
				            <td>
			                   	<div class="purchase-text">{{ date('jS F Y', strtotime($refund->updated_at)) }}</div>			                   	
			                </td>
			                <td>
			                	@if($gsetting['currency_swipe'] == 1)
			                    	<div class="purchase-text"><i class="fa {{ $refund->currency_icon }}"></i>{{ $refund->total_amount }}</div>
			                    @else
			                    	<div class="purchase-text">{{ $refund->total_amount }}<i class="fa {{ $refund->currency_icon }}"></i></div>
			                    @endif
			                </td>
			                <td>   
			                    <div class="purchase-text">{{ $refund->payment_method }}</div>
			                </td>
			                <td>   
			                    <div class="purchase-text">
			                    	@if($refund->status ==1)
				                    {{ __('Refunded') }}
				                    @else
				                    {{ __('Pending') }}
				                    @endif
					            </div>
			                </td>
			                <td>
			                    <div class="invoice-btn">
			                    	
			                    	<a href="{{route('invoice.show',$refund->id)}}"  class="btn btn-secondary">{{ __('Invoice') }}</a>
			                    	
			                    </div>
			                </td>
				        </tr>
				    </tbody>
				</div>

				@endforeach
			</table>
		</div>
	</div>
</section>

@endsection
