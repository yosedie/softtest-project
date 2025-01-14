@extends('theme.master')
@section('title')
@section('content')
@include('admin.message')
@if(! $bestselling->isEmpty() && $hsetting->bestselling_enable && isset($bestselling) && count($bestselling) > 0 )
<div class="student-view-slider-main-block view-more-pages">
    <div class="container-xl">
        <div class="row">
            @foreach($bestselling as $best)
           
            @if($best->courses->status == 1 )
            <div class="col-lg-3">
                <div class="item student-view-block student-view-block-1">
                    <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif"
                        data-pt-placement="outside" data-pt-interactive="false"
                        data-pt-title="#prime-next-item-description-block{{$best->id}}">
                        <div class="view-block">
                            <div class="view-img">
                                @if($best->courses['preview_image'] !== NULL && $best->courses['preview_image'] !== '')
                                <a href="{{ route('user.course.show',['slug' => $best->courses->slug ]) }}"><img src="{{ asset('images/course/'.$best->courses['preview_image']) }}" alt="course"
                                        class="img-fluid owl-lazy"></a>
                                @else
                                <a href="{{ route('user.course.show',['slug' => $best->courses->slug ]) }}"><img
                                        src="{{ Avatar::create($best->title)->toBase64() }}" alt="course"
                                        class="img-fluid owl-lazy"></a>
                                @endif
                            </div>
                            <div class="advance-badge">
                                @if($best->courses['level_tags'] == !NULL)
                                <span class="badge bg-primary">{{ $best->courses['level_tags'] }}</span>
                                @endif
                            </div>
                            <div class="view-user-img">
                                @if($best->courses->user['user_img'] !== NULL && $best->courses->user['user_img'] !== '')
                                <a href="" title="{{$best->courses->title}}"><img src="{{ asset('images/user_img/'.$best->courses->user['user_img']) }}" class="img-fluid user-img-one" alt="{{$best->courses->title}}"></a>
                                @else
                                <a href="" title="{{$best->courses->title}}"><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt="{{$best->courses->title}}"></a>
                                @endif
                                
                            </div>

                            <div class="view-dtl">
                                <div class="view-heading"><a
                                        href="{{ route('user.course.show',['slug' => $best->courses->slug ]) }}">{{ str_limit($best->courses->title, $limit = 30, $end = '...') }}</a>
                                </div>
                                <div class="user-name">
                                    <h6>By <span>{{ optional($best->courses->user)['fname'] }}</span></h6>
                                </div>
                                <div class="rating">
                                    <ul>
                                        <li>
                                            <?php 
                                                $learn = 0;
                                                $price = 0;
                                                $value = 0;
                                                $sub_total = 0;
                                                $sub_total = 0;
                                                $reviews = App\ReviewRating::where('course_id',$best->courses->id)->get();
                                                ?>
                                            @if(!empty($reviews[0]))
                                            <?php
                                                $count =  App\ReviewRating::where('course_id',$best->courses->id)->count();

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
                                                <div class="star-ratings-sprite"><span
                                                        style="width:<?php echo $ratings_var; ?>%"
                                                        class="star-ratings-sprite-rating"></span>
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

                                            $reviewcount = App\ReviewRating::where('course_id', $best->courses->id)->WhereNotNull('review')->get();

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
                                        $reviewsrating = App\ReviewRating::where('course_id', $best->courses->id)->first();
                                        @endphp
                                        @if(!empty($reviewsrating))
                                        <!-- <li>
                                                <b>{{ round($overallrating, 1) }}</b>
                                            </li> -->
                                        @endif
                                        <li class="reviews">
                                            (@php
                                            $data = App\ReviewRating::where('course_id', $best->courses->id)->count();
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
                                <div class="view-footer">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                            <div class="count-user">
                                                <i data-feather="user"></i><span>
                                                    @php
                                                    $data = App\Order::where('course_id', $best->courses->id)->count();
                                                    if(($data)>0){

                                                    echo $data;
                                                    }
                                                    else{

                                                    echo "0";
                                                    }
                                                    @endphp</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                            @if( $best->courses->type == 1)
                                            <div class="rate text-right">
                                                <ul>

                                                    @if($best->courses->discount_price == !NULL)

                                                    <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($best->courses['discount_price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                    </li>

                                                    <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($best->courses['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false) ) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</strike></b></a>
                                                    </li>


                                                    @else

                                                    @if($best->courses->price == !NULL)
                                                    <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($best->courses['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false) ) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                    </li>
                                                    @endif

                                                    @endif
                                                </ul>
                                            </div>
                                            @else
                                            <div class="rate text-right">
                                                <ul>
                                                    <li><a><b>{{ __('Free') }}</b></a></li>
                                                </ul>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>



                                <div class="img-wishlist">
                                    <div class="protip-wishlist">
                                        <ul>

                                            <li class="protip-wish-btn"><a
                                                    href="https://calendar.google.com/calendar/r/eventedit?text={{ $best['title'] }}"
                                                    target="__blank" title="reminder"><i data-feather="bell"></i></a></li>

                                            @if(Auth::check())

                                            <li class="protip-wish-btn"><a class="compare" data-id="{{filter_var($best->id)}}"
                                                    title="compare"><i data-feather="bar-chart"></i></a></li>

                                            @php
                                            $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',$best->courses->id)->first();
                                            @endphp
                                            @if ($wish == NULL)
                                            <li class="protip-wish-btn">
                                                <form id="demo-form2" method="post"
                                                    action="{{ url('show/wishlist', $best->courses->id) }}" data-parsley-validate
                                                    class="form-horizontal form-label-left">
                                                    {{ csrf_field() }}

                                                    <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                    <input type="hidden" name="course_id" value="{{$best->courses->id}}" />

                                                    <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i
                                                            data-feather="heart"></i></button>
                                                </form>
                                            </li>
                                            @else
                                            <li class="protip-wish-btn-two">
                                                <form id="demo-form2" method="post"
                                                    action="{{ url('remove/wishlist', $best->courses->id) }}" data-parsley-validate
                                                    class="form-horizontal form-label-left">
                                                    {{ csrf_field() }}

                                                    <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                    <input type="hidden" name="course_id" value="{{$best->courses->id}}" />

                                                    <button class="wishlisht-btn heart-fill" title="Remove from Wishlist"
                                                        type="submit"><i data-feather="heart"></i></button>
                                                </form>
                                            </li>
                                            @endif
                                            @else
                                            <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i
                                                        data-feather="heart"></i></a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div id="prime-next-item-description-block{{$best->courses->id}}" class="prime-description-block">
                        <div class="prime-description-under-block">
                            <div class="prime-description-under-block">
                                <h5 class="description-heading">{{ $best->courses['title'] }}</h5>
                                <div class="main-des">
                                    <p>Last Updated: {{ date('jS F Y', strtotime($best->courses->updated_at)) }}</p>
                                </div>

                                <ul class="description-list">
                                    <li>
                                        <i data-feather="play-circle"></i>
                                        <div class="class-des">
                                            {{ __('Classes') }}:
                                            @php
                                            $data = App\CourseClass::where('course_id', $best->courses->id)->count();
                                            if($data > 0){

                                            echo $data;
                                            }
                                            else{

                                            echo "0";
                                            }
                                            @endphp
                                        </div>
                                    </li>
                                    &nbsp;
                                    <li>
                                        <div>
                                            <div class="time-des">
                                                <span class="">
                                                    <i data-feather="clock"></i>
                                                    @php

                                                    $classtwo = App\CourseClass::where('course_id',
                                                    $best->courses->id)->sum("duration");

                                                    @endphp
                                                    {{ $classtwo }} {{ __('Minutes')}}
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="lang-des">
                                            @if($best->courses['language_id'] == !NULL)
                                            @if(isset($best->courses->language))
                                            <i data-feather="globe"></i> {{ $best->courses->language['name'] }}
                                            @endif
                                            @endif
                                        </div>
                                    </li>
                                </ul>

                                <div class="product-main-des">
                                    <p>{{ $best->courses->short_detail }}</p>
                                </div>
                                <div>
                                    @if($best->courses->whatlearns->isNotEmpty())
                                    @foreach($best->courses->whatlearns as $wl)
                                    @if($wl->status ==1)
                                    <div class="product-learn-dtl">
                                        <ul>
                                            <li><i
                                                    data-feather="check-circle"></i>{{ str_limit($wl['detail'], $limit = 120, $end = '...') }}
                                            </li>
                                        </ul>
                                    </div>
                                    @endif
                                    @endforeach
                                    @endif
                                </div>
                                <div class="des-btn-block">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            @if($best->courses->type == 1)
                                            @if(Auth::check())
                                            @if(Auth::User()->role == "admin")
                                            <div class="protip-btn">
                                                <a href="{{ route('course.content',['slug' => $best->courses->slug ]) }}"
                                                    class="btn btn-secondary"
                                                    title="course">{{ __('Go To Course') }}</a>
                                            </div>
                                            @else
                                            @php
                                            $order = App\Order::where('user_id', Auth::User()->id)->where('course_id',
                                            $best->courses->id)->first();
                                            @endphp
                                            @if(!empty($order) && $order->status == 1)
                                            <div class="protip-btn">
                                                <a href="{{ route('course.content',['slug' => $best->courses->slug ]) }}"
                                                    class="btn btn-secondary"
                                                    title="course">{{ __('Go To Course') }}</a>
                                            </div>
                                            @else
                                            @php
                                            $cart = App\Cart::where('user_id', Auth::User()->id)->where('course_id',
                                            $best->courses->id)->first();
                                            @endphp
                                            @if(!empty($cart))
                                            <div class="protip-btn">
                                                <form id="demo-form2" method="post"
                                                    action="{{ route('remove.item.cart',$cart->id) }}">
                                                    {{ csrf_field() }}

                                                    <div class="box-footer">
                                                        <button type="submit"
                                                            class="btn btn-primary">{{ __('Remove From Cart') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                            @else
                                            <div class="protip-btn">
                                                <form id="demo-form2" method="post"
                                                    action="{{ route('addtocart',['course_id' => $best->courses->id, 'price' => $best->courses->price, 'discount_price' => $best->courses->discount_price ]) }}"
                                                    data-parsley-validate class="form-horizontal form-label-left">
                                                    {{ csrf_field() }}

                                                    <input type="hidden" name="category_id"
                                                        value="{{$best->category['id'] ?? '-'}}" />

                                                    <div class="box-footer">
                                                        <button type="submit"
                                                            class="btn btn-primary">{{ __('Add To Cart') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                            @endif
                                            @endif
                                            @endif
                                            @else
                                            @if($gsetting->guest_enable == 1)
                                            <form id="demo-form2" method="post" action="{{ route('guest.addtocart', $best->courses->id) }}" data-parsley-validate
                                                class="form-horizontal form-label-left">
                                                {{ csrf_field() }}
                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary"><i data-feather="shopping-cart"></i>&nbsp;{{ __('Add To Cart') }}</button>
                                                </div>
                                            </form>
                                            @else
                                            <div class="protip-btn">
                                                <a href="{{ route('login') }}" class="btn btn-primary"><i data-feather="shopping-cart"></i>&nbsp;{{ __('Add To Cart') }}</a>
                                            </div>
                                            @endif
                                            @endif
                                            @else
                                            @if(Auth::check())
                                            @if(Auth::User()->role == "admin")
                                            <div class="protip-btn">
                                                <a href="{{ route('course.content',['slug' => $best->courses->slug ]) }}"
                                                    class="btn btn-secondary"
                                                    title="course">{{ __('Go To Course') }}</a>
                                            </div>
                                            @else
                                            @php
                                            $enroll = App\Order::where('user_id', Auth::User()->id)->where('course_id',
                                            $best->courses->id)->first();
                                            @endphp
                                            @if($enroll == NULL)
                                            <div class="protip-btn">
                                                <a href="{{url('enroll/show',$best->courses->id)}}" class="btn btn-primary"
                                                    title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                            </div>
                                            @else
                                            <div class="protip-btn">
                                                <a href="{{ route('course.content',['slug' => $best->courses->slug ]) }}"
                                                    class="btn btn-secondary"
                                                    title="Cart">{{ __('Go To Course') }}</a>
                                            </div>
                                            @endif
                                            @endif
                                            @else
                                            <div class="protip-btn">
                                                <a href="{{ route('login') }}" class="btn btn-primary"
                                                    title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                            </div>
                                            @endif
                                            @endif
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="img-wishlist">
                                                <div class="protip-wishlist">
                                                    <ul>
                                                        @if(Auth::check())

                                                        @php
                                                        $wish = App\Wishlist::where('user_id',
                                                        Auth::User()->id)->where('course_id', $best->courses->id)->first();
                                                        @endphp
                                                        @if ($wish == NULL)
                                                        <li class="protip-wish-btn">
                                                            <form id="demo-form2" method="post"
                                                                action="{{ url('show/wishlist', $best->courses->id) }}"
                                                                data-parsley-validate
                                                                class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}

                                                                <input type="hidden" name="user_id"
                                                                    value="{{Auth::User()->id}}" />
                                                                <input type="hidden" name="course_id" value="{{$best->courses->id}}" />

                                                                <button class="wishlisht-btn" title="Add to wishlist"
                                                                    type="submit"><i data-feather="heart"></i></button>
                                                            </form>
                                                        </li>
                                                        @else
                                                        <li class="protip-wish-btn-two">
                                                            <form id="demo-form2" method="post"
                                                                action="{{ url('remove/wishlist', $best->id) }}"
                                                                data-parsley-validate
                                                                class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}

                                                                <input type="hidden" name="user_id"
                                                                    value="{{Auth::User()->id}}" />
                                                                <input type="hidden" name="course_id" value="{{$best->courses->id}}" />

                                                                <button class="wishlisht-btn heart-fill" title="Remove from Wishlist"
                                                                    type="submit"><i data-feather="heart"></i></button>
                                                            </form>
                                                        </li>
                                                        @endif
                                                        @else
                                                        <li class="protip-wish-btn"><a href="{{ route('login') }}"
                                                                title="heart"><i data-feather="heart"></i></a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           @endif
           @endforeach
        </div>
    </div>    
</div>
@endif
@endsection 
@section('custom-script')
@endsection