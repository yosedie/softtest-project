@extends('theme2.master')
@section('title')
@section('content')
@include('admin.message')
<!-- breadcumb start -->
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
                        <h2>{{ __('All Instructor Profile') }}</h2>

                            
                        </div>
                    </div>
                </div>
                <div class="breadcrumb-wrap2">
                    
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{__('All Instructor Profile')}}</li>
                            </ol>
                        </nav>
                    </div>
                
            </div>
        </div>
    </section>
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
                        <div class="instructor-home-block">
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

                                @auth

                                @php

                                $follow = App\Followers::where('follower_id', $user->id)->first();

                                @endphp

                                @if($follow == NULL)


                                <form id="demo-form2" method="post" action="{{ route('follow') }}"
                                    data-parsley-validate class="form-horizontal form-label-left">
                                        {{ csrf_field() }}

                                    <input type="hidden" name="follower_id"  value="{{$user->id}}" />

                                   
                                     <button type="submit" class="btn btn-primary">&nbsp;{{__('Follow')}}</button>
                                </form>
                                

                                @else
                                
                                <form id="demo-form2" method="post" action="{{ route('unfollow') }}"
                                    data-parsley-validate class="form-horizontal form-label-left">
                                        {{ csrf_field() }}

                                    <input type="hidden" name="user_id"value="{{$user->id}}" />
                                    <input type="hidden" name="instructor_id"  value="{{$user->id}}" />

                                    
                                     <button type="submit" class="btn btn-secondary">&nbsp;{{__('Unfollow')}}</button>
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
                            <a class="nav-link" id="classes-tab" data-toggle="tab" href="#classes" role="tab" aria-controls="classes" aria-selected="true">{{ __('Explore Courses') }}</a>
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
                                        <div class="courses-item mb-30  ms-0 me-0 hover-zoomin @if($gsetting['course_hover'] == 1) protip @endif">
                    
                                            <div class="thumb fix ">
                                                @if($c['preview_image'] !== NULL && $c['preview_image'] !== '0')
                                                <a href="{{ route('user.course.show',['slug' => $c->slug ]) }}"><img src="{{ asset('images/course/'.$c['preview_image']) }}" alt="contact-bg-an-01"></a>
                                                @else
                                                <a href="{{ route('user.course.show',['slug' => $c->slug ]) }}"><img src="{{ Avatar::create($c->title)->toBase64() }}" alt="contact-bg-an-01"></a>
                                                @endif
                                                    
                                                <div class="courses-icon">
                                                    <ul>
                                                        <li class="protip-wish-btn">
                                                            <a  href="https://calendar.google.com/calendar/r/eventedit?text={{ $c['title'] }}"
                                                                target="__blank" title="reminder"><i data-feather="bell"></i></a>
                                                        </li>

                                                        @if (Auth::check())
                                                        <li class="protip-wish-btn">
                                                            <a class="compare" data-id="{{ filter_var($c->id) }}" title="compare">
                                                                <i data-feather="bar-chart"></i>
                                                            </a>
                                                        </li>
                                                        

                                                        @php
                                                        $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',
                                                        $c->id)->first();
                                                        @endphp
                                                        @if ($wish == NULL)
                                                        <li class="protip-wish-btn">
                                                            <form id="demo-form2" method="post"
                                                                action="{{ url('show/wishlist', $c->id) }}" data-parsley-validate
                                                                class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}

                                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                                <input type="hidden" name="course_id" value="{{$c->id}}" />

                                                                <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i
                                                                        data-feather="heart"></i></button>
                                                            </form>
                                                        </li>
                                                        @else
                                                        <li class="protip-wish-btn-two heart-fill">
                                                            <form id="demo-form2" method="post"
                                                                action="{{ url('remove/wishlist', $c->id) }}" data-parsley-validate
                                                                class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}

                                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                                <input type="hidden" name="course_id" value="{{$c->id}}" />

                                                                <button class="wishlisht-btn" title="Remove from Wishlist"
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
                                            @if(isset($c->discount_price))
                                            <div class="badges bg-priamry offer-badge"><span>{{__('OFF')}}<span><?php echo round((($c->price - $c->discount_price) * 100) / $c->price) . '%'; ?></span></span></div>
                                            @endif
                                            <div class="courses-content">    
                                                <div class="view-user-img">
                                                    <a href="{{ route('all/profile',$c->user->id) }}" title="{{ optional($c->user)['fname'] }}">
                                                        @if($c->user['user_img'] !== NULL && $c->user['user_img'] !== '')
                                                        <img src="{{ asset('images/user_img/'.$c->user['user_img']) }}" class="img-fluid user-img-one" alt="{{$c->title}}">
                                                        @else
                                                        <img src="{{ Avatar::create($c->title)->toBase64() }}" alt="img">
                                                        @endif
                                                    </a>
                                                                            
                                                </div>                                
                                                <div class="cat">
                                                    <div class="rate text-right">
                                                        <ul>
                                                            @if($c->type == 1)
                                                                @if($c->discount_price != NULL)
                                                                    <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($c['discount_price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }} {{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
                                                                    <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($c['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</strike></b></a></li>
                                                                @elseif($c->price != NULL)
                                                                    <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($c['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
                                                                @endif
                                                            @else
                                                                <li><a><b>{{ __('Free') }}</b></a></li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                                <h3><a href="{{ route('user.course.show',['slug' => $c->slug ]) }}"> {{$c->category['title'] ?? '-'}}</a></h3>
                                                    <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($c->detail))) , $limit = 70, $end = '...') }}
                                                <a href="{{ route('user.course.show',['slug' => $c->slug ]) }}" class="readmore">{{__('Read More ')}}<i class="fal fa-long-arrow-right"></i></a>
                                            </div>
                                            <div class="icon">
                                                <img src="{{ url('frontcss/img/icon/cou-icon.png') }}" alt="img">
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