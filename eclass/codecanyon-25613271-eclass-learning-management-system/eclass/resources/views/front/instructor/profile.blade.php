@extends('theme.master')
@section('title')
@section('content')
@include('admin.message')
<!-- breadcumb start -->
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
                        <h1 class="wishlist-home-heading">{{ __('My Courses') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- breadcumb end -->
<!-- instructor profile start -->
<section id="instructor-profile" class="instructor-profile-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <div class="instructor-profile-block text-center">
                    <div class="instructor-profile-img">
                        @if(isset($instructors['user_img']))
                        @if($instructors['user_img'] !== NULL && $instructors['user_img'] !== '')
                        <img src="{{ url('/images/user_img/'.$instructors->user_img) }}"  class="img-fluid" />
                        @else
                        <img src="{{ Avatar::create($instructors->fname)->toBase64() }}" alt="{{ __('course')}}"
                            class="img-fluid">
                        @endif
                        @endif
                        <div class="tooltip">
                            <div class="tooltip-icon">
                                <i data-feather="share-2"></i>
                            </div>
                            <span class="tooltiptext">
                                <div class="instructor-home-social-icon">
                                    <ul>
                                        <li><a href="{{ $instructors->fb_url ?? '-' }}"><i data-feather="facebook"></i></a></li>
                                        <li><a href="{{ $instructors->twitter_url ?? '-'}}"><i data-feather="twitter"></i></a></li>
                                        <li><a href="{{ $instructors->youtube_url ?? '-'}}"></a><i data-feather="youtube"></i></a></li>
                                        <li><a href="{{ $instructors->linkedin_url ?? '-'}}"><i data-feather="linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </span>
                        </div> 
                    </div>
                    <div class="instructor-profile-dtl">
                        <div class="instructor-content-block">
                            <h5 class="about-content-heading">{{ $instructors->fname ?? '-' }} {{ $instructors->lname ?? '-'}}</h5>
                            <p>{{ $instructors->role ?? '-'}}</p>
                            <div class="instructor-profile-number">
                                {{ $instructors->mobile ?? '-'}}
                            </div>
                            <div class="instructor-profile-mail">
                                {{ $instructors->email ?? '-'}}
                            </div>
                            @if(isset($instructors->id))
                            @php

                            $followers = App\Followers::where('user_id', '!=', $instructors->id)->where('follower_id', $instructors->id)->count();
        
                            $followings = App\Followers::where('user_id', $instructors->id)->where('follower_id','!=', $instructors->id)->count();
                            $course = App\Course::where('user_id', $instructors->id)->count();
        
                            @endphp
                            @endif
                            <div class="instructor-home-info">
                                <ul>
                                    <li>{{ $course ?? ''}} {{ __('Courses') }}</li>
                                    <li>{{ $followers ?? '' }} {{ __('Follower') }}</li>
                                    <li>{{ $followings ?? '' }} {{ __('Following') }}</li>
                                </ul>
                            </div>
                            <div class="instructor-btn">
                                <div class="tooltip">
                                    <div class="tooltip-icon">
                                        <button type="button" title="{{ __('Share')}}" class="btn btn-primary">{{ __('Share')}}</button>
                                    </div>
                                    <span class="tooltiptext">
                                        <div class="instructor-home-social-icon">
                                            <ul>
                                                <li><a href="{{ $instructors->fb_url ?? '-' }}"><i data-feather="facebook"></i></a></li>
                                                <li><a href="{{ $instructors->twitter_url ?? '-'}}"><i data-feather="twitter"></i></a></li>
                                                <li><a href="{{ $instructors->youtube_url ?? '-'}}"></a><i data-feather="youtube"></i></a></li>
                                                <li><a href="{{ $instructors->linkedin_url ?? '-'}}"><i data-feather="linkedin"></i></a></li>
                                            </ul>
                                        </div>
                                    </span>
                                </div> 

                                @auth

                                @php

                                $follow = App\Followers::where('follower_id', $user->id)->first();

                                @endphp

                                @if($follow == NULL)


                                <form id="demo-form2" method="post" action="{{ route('follow') }}"
                                    data-parsley-validate class="form-horizontal form-label-left">
                                        {{ csrf_field() }}

                                    <input type="hidden" name="follower_id"  value="{{$user->id}}" />

                                   
                                     <button type="submit" class="btn btn-primary" title="{{ __('Follow')}}">&nbsp;Follow</button>
                                </form>
                                

                                @else
                                
                                <form id="demo-form2" method="post" action="{{ route('unfollow') }}"
                                    data-parsley-validate class="form-horizontal form-label-left">
                                        {{ csrf_field() }}

                                    <input type="hidden" name="user_id"value="{{$user->id}}" />
                                    <input type="hidden" name="instructor_id"  value="{{$user->id}}" />

                                    
                                     <button type="submit" class="btn btn-secondary" title="{{ __('Unfollow')}}">&nbsp;{{__('Unfollow')}}</button>
                                </form>

                                @endif

                                @endauth

                                

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="instructor-profile-tabs">
                    <ul class="nav nav-tabs" id="tabs-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="classes-tab" data-toggle="tab" href="#classes" role="tab" aria-controls="classes" aria-selected="true">{{ __('Explore Courses') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="about-tab" data-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="false">{{ __('About me') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="nav-tabContent">
                        @if(isset($courses))
                        
                        <div class="tab-pane active show" id="classes" role="tabpanel" aria-labelledby="classes-tab">
                           <div class="about-instructor">
                               <div class="row">
                                    @foreach($courses as $c)
                                    @if($c->status == 1)
                                    <div class="col-lg-6">
                                        <div class="student-view-block">
                                            <div class="view-block">
                                                <div class="view-img">
                                                    @if($c['preview_image'] !== NULL && $c['preview_image'] !== '')
                                                        <a href="{{ route('user.course.show',['slug' => $c->slug ]) }}" title="{{$c->title}}"><img src="{{ asset('images/course/'.$c['preview_image']) }}" alt="{{ __('course')}}" class="img-fluid"></a>
                                                    @else
                                                        <a href="{{ route('user.course.show',['slug' => $c->slug ]) }}" title="{{$c->title}}"><img src="{{ Avatar::create($c->title)->toBase64() }}" alt="{{ __('course')}}" class="img-fluid"></a>
                                                    @endif
                                                </div>
                                                <div class="view-user-img">

                                                    @if(optional($c->user)['user_img'] !== NULL && optional($c->user)['user_img'] !== '')
                                                    <a href="" title="{{$c->title}}"><img src="{{ asset('images/user_img/'.$c->user['user_img']) }}"
                                                            class="img-fluid user-img-one" alt="{{$c->title}}"></a>
                                                    @else
                                                    <a href="" title="{{$c->title}}"><img src="{{ asset('images/default/user.png') }}"
                                                            class="img-fluid user-img-one" alt="{{$c->title}}"></a>
                                                    @endif
                        
                        
                                                </div>
                                                <div class="view-dtl">
                                                    <div class="view-heading"><a href="{{ route('user.course.show',['slug' => $c->slug ]) }}" title="{{$c->title}}">{{ str_limit($c->title, $limit = 30, $end = '...') }}</a></div>
                                                    <div class="user-name">
                                                        <h6>By <span>{{ optional($c->user)['fname'] }}</span></h6>
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
                                                                $reviews = App\ReviewRating::where('course_id',$c->id)->get();
                                                                ?> 
                                                                @if(!empty($reviews[0]))
                                                                <?php
                                                                $count =  App\ReviewRating::where('course_id',$c->id)->count();

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

                                                            $reviewcount = App\ReviewRating::where('course_id', $c->id)->WhereNotNull('review')->get();

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
                                                                $reviewsrating = App\ReviewRating::where('course_id', $c->id)->first();
                                                            @endphp
                                                            <li class="reviews">
                                                                (@php
                                                                $data = App\ReviewRating::where('course_id', $c->id)->count();
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
                                                                        <i data-feather="user"></i><span>1</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                                    @if( $c->type == 1)
                                                                    <div class="rate text-right">
                                                                        <ul>
                                                                            @php
                                                                                $currency = App\Currency::first();
                                                                                $string =  currency($c->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) ;

                                                                            @endphp
                                                                              @if($c->discount_price == !NULL)
                                                       
                                                                              <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($c['discount_price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a></li>
                      
                                                                              <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($c['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</strike></b></a></li>
                                                                             
                                                                              
                                                                          @else
                      
                                                                              @if($c->price == !NULL) 
                                                                              <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($c['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a></li>
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
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    @endif
                                    @endforeach
                               </div>
                            </div>
                            <div>{{ $courses->links() }}</div>
                        </div>
                        @endif
                        <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                           {!! $instructors['detail'] ?? ''  !!}
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- instructor profile end -->
<section id="instructor-info" class="instructor-info-main-block">
    <div class="container-xl">
        
    </div>
</section>
@endsection