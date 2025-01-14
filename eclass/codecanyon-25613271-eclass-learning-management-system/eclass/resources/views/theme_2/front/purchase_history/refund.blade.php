@extends('theme2.master')
@section('title', 'Refund')
@section('content')

@include('admin.message')

<section id="refund-block" class="refund-main-block">
	<div class="container-xl">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-4">
					@if($order->courses['preview_image'] !== NULL && $order->courses['preview_image'] !== '')
                    	<a href="{{ route('user.course.show',['slug' => $order->courses->slug ]) }}"><img src="{{ asset('images/course/'. $order->courses->preview_image) }}" class="img-fluid" alt="course"></a>
                    @else
                    	<a href="{{ route('user.course.show',['slug' => $order->courses->slug ]) }}"><img src="{{ Avatar::create($order->courses->title)->toBase64() }}" class="img-fluid" alt="course"></a>
                    @endif
                    <br>
                    <br>
                    <div class="purchase-history-course-title">
                        <a href="{{ route('user.course.show',['slug' => $order->courses->slug ]) }}">{{ $order->courses->title }}</a>
                    </div>

                    
				</div>
				<div class="col-lg-8">


					<div class="refund-policy">
						<ul>
							@if($gsetting['currency_swipe'] == 1)
								<li><b>{{ __('Order price')}}</b>: <i class="{{ $order['currency_icon'] }}"></i> {{ $order->total_amount }}</li>
							@else
								<li><b>{{ __('Order price')}}</b>: {{ $order->total_amount }}<i class="{{ $order['currency_icon'] }}"></i> </li>
							@endif
							
							<li><b>{{ __('Refund Policy')}}</b>: {!! $policy->detail !!}</li>
						</ul>
					</div>
					<br>
					<h5 class="">{{ __('Refund Request') }}</h5>


                    @php
                        $order_id = Crypt::encrypt($order->id);
                    @endphp


                    <form action="{{ route('refund.request',$order_id) }}" method="POST" enctype="multipart/form-data">
		        	{{ csrf_field() }}
		            {{ method_field('POST') }}


		            	<input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
					    <input type="hidden" name="course_id"  value="{{$order->courses->id}}" />
					    <input type="hidden" name="course_id"  value="{{$order->order_id}}" />
					    <input type="hidden" name="ammount"  value="{{$order->total_amount}}" />
					    <input type="hidden" name="payment_method"  value="{{$order->payment_method}}" />

	                    <div class="form-group">
	                        <label for="name">{{ __('Reason') }}</label>
	                        <input type="text" id="reason" name="reason" class="form-control" placeholder="Enter Reason" required>
	                    </div>

	                    <div class="form-group">
	                        <label for="bio">{{ __('Detail') }}</label>
	                        <textarea id="detail" name="detail" rows="4" class="form-control" placeholder="Enter Detail" value="" required></textarea>
	                    </div>


	                    <div class="form-group">
	                        <label for="bio">{{ __('Refund Mode') }}</label>
	                        <select id="refund_mode" class="form-control js-example-basic-single" name="refund_mode" required>
		                       	<option value="none" selected disabled hidden> 
			                      {{ __('SelectanOption') }}
			                    </option>
			                    @if($order->payment_method == 'PayPal' || $order->payment_method == 'Stripe' ||  $order->payment_method == 'Paystack' || $order->payment_method == 'Instamojo' ||  $order->payment_method == 'PayTM' || $order->payment_method == 'RazorPay' )
			                    <option value="original">{{__('Orginal Source')}}</option>
			                    @endif
			                    <option value="bank">{{ __('Bank')}}</option>
			                </select>
	                    </div>


	                    @php

	                    $user_bank = App\UserBankDetail::where('user_id', Auth::user()->id)->get();

	                    @endphp


	                    @if(isset($user_bank))


	                     <div class="display-none" id="bank_box">

		                    <div class="form-group" style="width: 100%">
		                        <label for="bio">{{ __('Select Bank') }}</label>
		                        <select style="width: 100%" id="bank_id" class="form-control js-example-basic-single" name="bank_id">
			                       	<option value="none" selected disabled hidden> 
				                      {{ __('Select anO ption') }}
				                    </option>

				                    @foreach($user_bank as $bank)
				                    
				                    <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>

				                    @endforeach
				                    
				                </select>
		                    </div>
		                </div>

		                @else


		                <div class="alert alert-danger" role="alert">
		                    {{ __('You have not added your your bank details in your profile') }} 
		                </div>


		                @endif

	                    <div class="mark-read-button txt-rgt">
                            <button type="submit" class="btn btn-md btn-primary">
                                {{ __('Refund Request') }}
                            </button>
                        </div>

                    </form>


				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('custom-script')
<script>
(function($) {
  "use strict";

  $('#refund_mode').change(function() {
      
    if($(this).val() == 'bank')
    {
      $('#bank_box').show();
    }
    else
    {
      $('#bank_box').hide();
    }
  });

 })(jQuery);

</script>


@endsection