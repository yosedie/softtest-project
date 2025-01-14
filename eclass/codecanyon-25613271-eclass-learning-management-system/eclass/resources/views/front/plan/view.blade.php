@extends('theme.master')
@section('title', 'Instructor Subscription Plan')
@section('content')

@include('admin.message')
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
                        <h1 class="wishlist-home-heading">{{ __('Instructor Plan') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<section id="profile-item" class="profile-item-block instructor-subscription-block">
    <div class="container-xl">
        @if(isset($subscribed))
        <h4 class="student-heading">{{ __('Active Plan') }}</h4>
        <div class="row">
            @foreach($subscribed as $subscrib)
            @if($subscrib->plans->status == '1')
            
                <div class="col-lg-3 col-sm-6 col-md-4">
                    <div class="view-block btm-10">
                        <div class="view-img">
                            @if($subscrib->plans['preview_image'] !== NULL && $subscrib->plans['preview_image'] !== '')
                                <img src="{{ asset('images/plan/'.$subscrib->plans->preview_image) }}" class="img-fluid" alt="{{ __('course')}}">
                            @else
                                <a href=""><img src="{{ Avatar::create($subscrib->plans->title)->toBase64() }}" class="img-fluid" alt="{{ __('course')}}">
                            @endif
                            </a>
                        </div>
                    
                        <div class="view-dtl">
                            <div class="row no-gutters">
                                <div class="col-lg-7">
                                    <div class="plan-name">{{__('Plan')}}</div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="view-heading"><a href="">{{ str_limit($subscrib->plans->title, $limit = 35, $end = '...') }}</a></div>
                                </div>
                            </div>
                            
                            <div class="row no-gutters mb-3">
                                <div class="col-lg-7">
                                    <div class="inst-duration-course-name">{{ __('Duration') }}:</div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="inst-duration-course">
                                        <ul>
                                            @if($subscrib->plans->duration == 'm')

                                                @if($subscrib->plans->discount_price == !NULL)

                                                <li class="rate-r"><s>@if($subscrib->plans->type == 1)<i class="{{ $currency->icon }}"></i>{{ $subscrib->plans->price }} /@endif {{ $subscrib->plans->duration }} {{ __('Month') }}</s></li>

                                                <li><b>@if($subscrib->plans->type == 1)<i class="{{ $currency->icon }}"></i>{{ $subscrib->plans->discount_price }}/@endif {{ $subscrib->plans->duration }} {{ __('Month') }}</b></li>

                                                @else

                                                <li class="rate-r">@if($subscrib->plans->type == 1)<i class="{{ $currency->icon }}"></i>{{ $subscrib->plans->price }} /@endif {{ $subscrib->plans->duration }} {{ __('Month') }}</li>

                                                @endif
                                                
                                                @else

                                                @if($subscrib->plans->discount_price == !NULL)
                                                <li class="rate-r"><s>@if($subscrib->plans->type == 1)<i class="{{ $currency->icon }}"></i>{{ $subscrib->plans->price }} /@endif {{ $subscrib->plans->duration }} {{ __('Month') }}</s></li>

                                                <li><b>@if($subscrib->plans->type == 1)<i class="{{ $currency->icon }}"></i>{{ $subscrib->plans->discount_price }}/@endif {{ $subscrib->plans->duration }} {{ __('Month') }}</b></li>

                                                @else

                                                <li class="rate-r">@if($subscrib->plans->type == 1)<i class="{{ $currency->icon }}"></i>{{ $subscrib->plans->price }} /@endif {{ $subscrib->plans->duration }} {{ __('Month') }}</li>

                                                @endif
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row no-gutters">
                                <div class="col-lg-7">
                                    <div class="inst-allowed-courses-name">{{ __('Allowed Courses') }}:</div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="inst-allowed-courses">{{ $subscrib->plans->courses_allowed }}</div>
                                </div>
                            </div>
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        @if($subscrib->plans->type == 1)
                                        <div class="rate text-right">
                                            <ul>
                                                

                                                @if($subscrib->plans->discount_price == !NULL)
                                                    <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($subscrib->plans->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false))}}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a></li>
                                                    <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($subscrib->plans->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</strike></b></a></li>
                                                    <!-- <li class="rate-r"><s><i class="{{ $currency->icon }}"></i>{{ $subscrib->plans->price }}</s></li> -->
                                                    <!-- <li><b><i class="{{ $currency->icon }}"></i>{{ $subscrib->plans->discount_price }}</b></li> -->
                                                @else
                                                <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($subscrib->plans->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false) )}}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a></li>
                                                    <!-- <li><b><i class="{{ $currency->icon }}"></i>{{ $subscrib->plans->price }}</b></li> -->
                                                @endif
                                            </ul>
                                        </div>
                                        @else
                                        <div class="rate text-right">
                                            <ul>
                                            <li><b>{{ __('Free') }}</b></li>
                                            </ul>
                                        </div>
                                        @endif
                                    </div>
                                </div>  
                            </div>  
                        </div>
                    </div>
                    <div class="plan-subs-btn">
                        <button type="submit" class="btn btn-primary" title="Add To Cart">{{__('Subscribed')}}</button>
                    </div>      
                </div>
            @endif
            @endforeach
        </div>

        @endif
        
    </div>
</section>
<!-- profile update start -->
<section id="profile-item" class="profile-item-block instructor-subscription-block">
    <div class="container-xl">
        <h4 class="student-heading">{{ __('All Plans Available') }}</h4>
    	<div class="row">
    		@foreach($plans as $plan)
            @if($plan->status == '1')
        	
                <div class="col-lg-3 col-sm-6 col-md-4">
                    <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block{{$plan->id}}">
                        <div class="view-block btm-10">
                            <div class="view-img">
                                @if($plan['preview_image'] !== NULL && $plan['preview_image'] !== '')
                                    <a href=""><img src="{{ asset('images/plan/'.$plan->preview_image) }}" class="img-fluid" alt="course">
                                @else
                                    <a href=""><img src="{{ Avatar::create($plan->title)->toBase64() }}" class="img-fluid" alt="course">
                                @endif
                                </a>
                            </div>
                        
                            <div class="view-dtl">
                                <div class="row no-gutters">
                                    <div class="col-lg-7">
                                        <div class="plan-name">{{__('Plan')}}</div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="view-heading"><a href="">{{ str_limit($plan->title, $limit = 35, $end = '...') }}</a></div>
                                    </div>
                                </div>
                                
                                <div class="row no-gutters mb-3">
                                    <div class="col-lg-7">
                                        <div class="inst-duration-course-name">{{__('Duration')}}:</div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="inst-duration-course">
                                            <ul>
                                                @if($plan->duration == 'm')

                                                    @if($plan->discount_price == !NULL)

                                                    <li class="rate-r"><s>@if($plan->type == 1)<i class="{{ $currency->icon }}"></i>{{ $plan->price }} /@endif {{ $plan->duration }} {{ __('Month')}}</s></li>

                                                    <li><b>@if($plan->type == 1)<i class="{{ $currency->icon }}"></i>{{ $plan->discount_price }} /@endif {{ $plan->duration }} {{ __('Month')}}</b></li>

                                                    @else

                                                    <li class="rate-r">@if($plan->type == 1)<i class="{{ $currency->icon }}"></i>{{ $plan->price }} /@endif {{ $plan->duration }} {{ __('Month')}}</li>

                                                    @endif
                                                    
                                                    @else

                                                    @if($plan->discount_price == !NULL)
                                                    <li class="rate-r"><s>@if($plan->type == 1)<i class="{{ $currency->icon }}"></i>{{ $plan->price }} @endif / {{ $plan->duration }} {{ __('Month')}}</s></li>

                                                    <li><b>@if($plan->type == 1)<i class="{{ $currency->icon }}"></i>{{ $plan->discount_price }} / @endif {{ $plan->duration }} {{ __('Month')}}</b></li>

                                                    @else

                                                    <li class="rate-r">@if($plan->type == 1)<i class="{{ $currency->icon }}"></i>{{ $plan->price }} / @endif {{ $plan->duration }} {{ __('Month')}}</li>

                                                    @endif
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row no-gutters">
                                    <div class="col-lg-7">
                                        <div class="inst-allowed-courses-name">{{ __('Allowed Courses') }}:</div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="inst-allowed-courses">{{ $plan->courses_allowed }}</div>
                                    </div>
                                </div>                               
                            </div>
                        </div>
                    </div>
                    <div id="prime-next-item-description-block{{$plan->id}}" class="prime-description-block">
                        <div class="prime-description-under-block">
                            <div class="prime-description-under-block">
                                <h5 class="description-heading">{{ $plan['title'] }}</h5>
                                

                                <div class="main-des">
                                    <p>{!! $plan->detail !!}</p>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="planlist-action">
                        <div class="row">
                        	<div class="col-md-12 col-12">
                               
                                @if($plan->type == 1)
                                <div class="plan-enroll-btn btm-10">
                                    <form id="demo-form2" method="post" action="{{ route('plan.checkout') }}"
                                            data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}
                                            
                                            <input type="hidden" name="plan_id"  value="{{ $plan->id }}" />
                                        
                                         <button type="submit" class="btn btn-primary"  title="{{ __('Add To Cart')}}">
                                            {{ __('Subscribe Now')}}
                                        </button>
                                    </form>
                                </div>
                                @else

                                <div class="plan-enroll-btn btm-10">
                                    <form id="demo-form2" method="post" action="{{ route('free.plan.checkout') }}"
                                            data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}
                                            
                                            <input type="hidden" name="plan_id"  value="{{ $plan->id }}" />
                                        
                                         <button type="submit" class="btn btn-primary"  title="Add To Cart">
                                            {{ __('Subscribe Now')}}
                                        </button>
                                    </form>
                                </div>

                                @endif
                        	</div>
                        	
                        </div>
                    </div>
                </div>
            @endif
            @endforeach
    	</div>
    	
    </div>
</section>
<!-- profile update end -->
@endsection

@section('custom-script')



@endsection