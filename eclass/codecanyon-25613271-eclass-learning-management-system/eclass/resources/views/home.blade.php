@extends('theme.master')
@section('title', 'Online Courses')
@section('content')
@include('admin.message')
@include('sweetalert::alert')
@section('meta_tags')
<meta name="title" content="{{ $gsetting['project_title'] }}">
<meta name="description" content="{{ $gsetting['meta_data_desc'] }} ">
<meta property="og:title" content="{{ $gsetting['project_title'] }} ">
<meta property="og:url" content="{{ url()->full() }}">
<meta property="og:description" content="{{ $gsetting['meta_data_desc'] }}">
<meta property="og:image" content="{{ asset('images/logo/'.$gsetting['logo']) }}">
<meta itemprop="image" content="{{ asset('images/logo/'.$gsetting['logo']) }}">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="{{ asset('images/logo/'.$gsetting['logo']) }}">
<meta property="twitter:title" content="{{ $gsetting['project_title'] }} ">
<meta property="twitter:description" content="{{ $gsetting['meta_data_desc'] }}">
<meta name="twitter:site" content="{{ url()->full() }}" />
<link rel="canonical" href="{{ url()->full() }}" />
<meta name="robots" content="all">
<meta name="keywords" content="{{ $gsetting->meta_data_keyword }}">
@endsection

<!-- categories-tab start-->
@if($gsetting->category_enable == 1)
<section id="categories-tab" class="categories-tab-main-block">
    <div class="container-xl">
        <div id="categories-tab-slider" class="categories-tab-block owl-carousel">
            @foreach($category as $cat)
            @if($cat->status == 1)
            <div class="item categories-tab-dtl">
                <a href="{{ route('category.page',['slug' => $cat->slug]) }}"
                    title="{{ $cat->title }}"><i class="fa {{ $cat->icon }}"></i>{{ $cat->title }}</a>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- categories-tab end-->
<div class="home-learning-block">
    <!-- home start -->
@if(isset($sliders))
    <section id="home-background-slider" class="background-slider-block owl-carousel">
        @foreach($sliders as $slider)
            @if($slider->status == 1)
            <div class="lazy item home-slider-img">
                <div id="home" class="home-main-block"
                    style="background-image: url('{{ asset('images/slider/'.$slider['image']) }}')">
                    <div class="overlay-bg"></div>
                    <div class="container-xl">
                        <div class="row">
                            <div class="col-lg-12 {{$slider['left'] == 1 ? 'col-md-offset-6 col-sm-offset-6 col-sm-12 col-md-12 text-right' : ''}}">
                                <div class="home-dtl">
                                    <div class="home-heading">{{ $slider['heading'] }}</div>
                                    <div class="home-sub-heading btm-20">{{ $slider['sub_heading'] }}</div>
                                    <p class="btm-20">{{ $slider['detail'] }}</p>
                                </div>

                                @if($slider->search_enable == 1)
                                <div class="home-search">
                                    <form method="GET" id="searchform" action="{{ route('search') }}">
                                        <div class="search">
                                            <input type="text" name="searchTerm" class="searchTerm"
                                                placeholder="{{ __('Search Courses')}}">
                                            <button type="submit" class="searchButton">{{ __('Search')}}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </section> 
@endif 
    <!-- home end -->
    <!-- learning-work start -->
    @if(isset($facts))
        <section id="learning-work" class="learning-work-main-block">
            <div class="container-xl">
                <div class="learning-work-bg-block">
                    <div class="row">
                        @foreach($facts as $fact)
                            <div class="col-lg-4 col-md-4">
                                <div class="learning-work-block">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-12">
                                            <div class="learning-work-icon">
                                                <i class="fa {{ $fact['icon'] }}"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-12">
                                            <div class="learning-work-dtl">
                                                <div class="work-heading">{{ $fact['heading'] }}</div>
                                                <p>{{ $fact['sub_heading'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- learning-work end -->
</div>
<!-- fact start -->
@if($hsetting->fact_enable == 1 && isset($factsetting) && !$factsetting->isEmpty())
    <section id="facts" class="fact-main-block">
        <div class="container-xl">
            <div class="row">
                @foreach($factsetting as $factset)
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="facts-block text-center">
                            <div class="facts-block-one">
                                <div class="facts-block-img">
                                    @php
                                    $image = $factset['image'] !== NULL && $factset['image'] !== '' ? url('/images/facts/'.$factset->image) : Avatar::create($factset->title)->toBase64();
                                    @endphp
                                    <img src="{{ $image }}" class="img-fluid" alt="{{ $factset->title }}" />
                                    <div class="facts-count counter" data-count="{{ $factset->number }}">{{ $factset->number }}</div>
                                </div>
                                <h5 class="facts-title"><a href="#" title="{{ $factset->title }}">{{ $factset->title }}</a></h5>
                                <p>{{ $factset->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
<!-- fact end -->
<!-- Advertisement -->
@if(isset($advs))
@foreach($advs as $adv)
@if($adv->position == 'belowslider')
<br>
<section id="student" class="student-main-block top-40">
    <div class="container-xl">
        <a href="{{ $adv->url1 }}" title="{{ __('Click to visit') }}">
        </a>
    </div>
</section>
@endif
@endforeach
@endif
@if($hsetting->discount_enable   == 1 && isset($discountcourse) && count($discountcourse) >0)
<section id="student" class="student-main-block top-40">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="student-heading">{{ __('Top Discounted Courses') }}</h4>
                <div class="view-button">
                    <a href="{{url('discount-courses')}}" class="btn btn-secondary" title="View More">{{ __('View More') }}<i data-feather="chevrons-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div id="discounted-view-slider" class="student-view-slider-main-block owl-carousel">
            @foreach($discountcourse as $discount)
             @if($discount->status == 1 && $discount->featured == 1)
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif"
                    data-pt-placement="outside" data-pt-interactive="false"
                    data-pt-title="#prime-next-item-description-block{{$discount->id}}">
                    <div class="view-block">
                        <div class="view-img">
                            @if($discount['preview_image'] !== NULL && $discount['preview_image'] !== '')
                            <a href="{{ route('user.course.show',['slug' => $discount->slug ]) }}"><img
                                    data-src="{{ asset('images/course/'.$discount['preview_image']) }}" alt="course"
                                    class="img-fluid owl-lazy"></a>
                            @else
                            <a href="{{ route('user.course.show',['slug' => $discount->slug ]) }}"><img
                                    data-src="{{ Avatar::create($discount->title)->toBase64() }}" alt="course"
                                    class="img-fluid owl-lazy"></a>
                            @endif
                        </div>                        
                        @php
                        $badgeMap = [
                            'trending' => ['badge bg-warning', __('Trending')],
                            'featured' => ['badge bg-danger', __('Featured')],
                            'new' => ['badge bg-success', __('New')],
                            'onsale' => ['badge bg-info', __('On-sale')],
                            'bestseller' => ['badge bg-success', __('Bestseller')],
                            'beginner' => ['badge bg-primary', __('Beginner')],
                            'intermediate' => ['badge bg-secondary', __('Intermediate')]
                        ];
                        @endphp
                        @if(isset($badgeMap[$discount['level_tags']]))
                            <div class="advance-badge">
                                <span class="{{ $badgeMap[$discount['level_tags']][0] }}">{{ $badgeMap[$discount['level_tags']][1] }}</span>
                            </div>
                        @endif                        
                        <div class="view-user-img">
                            @if(optional($discount->user)['user_img'] !== NULL && optional($discount->user)['user_img'] !== '')
                            <a href="{{ route('all/profile',$discount->user->id) }}" title="{{$discount->title}}"><img src="{{ asset('images/user_img/'.$discount->user['user_img']) }}"
                                    class="img-fluid user-img-one" alt="{{$discount->title}}"></a>
                            @else
                            <a href="{{  route('all/profile',$discount->id)  }}" title=" {{$discount->title}} "><img src="{{ asset('images/default/user.png') }}"
                                    class="img-fluid user-img-one" alt="{{$discount->title}}"></a>
                            @endif
                        </div>
                        @if(isset($discount->user->id))
                        <div class="view-dtl">
                            <div class="view-heading"><a
                                    href="{{ route('user.course.show',['slug' => $discount->slug ]) }}">{{ str_limit($discount->title, $limit = 30, $end = '...') }}</a>
                            </div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$discount->user->id) }}"> {{ optional($discount->user)['fname'] }}</a></span></h6>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    @include('ratings.discountratings', ['courseId' => $discount->id])
                                </div>
                                <div class="col-lg-6">
                                    <div class="badges bg-priamry offer-badge"><span>OFF<span><?php echo round((($discount->price - $discount->discount_price) * 100) / $discount->price) . '%'; ?></span></span></div>
                                </div>
                            </div>
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="count-user">
                                            <i data-feather="user"></i>
                                            <span>
                                                @php
                                                $data = App\Order::where('course_id', $discount->id)->count();
                                                // echo $data > 0 ? $data : "0";
                                                @endphp
                                                {{ $data > 0 ? $data : "0" }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="rate text-right">
                                            <ul>
                                                @if($discount->type == 1)
                                                    @if($discount->discount_price != NULL)
                                                        <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($discount['discount_price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }} {{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
                                                        <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($discount['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</strike></b></a></li>
                                                    @elseif($c->price != NULL)
                                                        <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($discount['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
                                                    @endif
                                                @else
                                                    <li><a><b>{{ __('Free') }}</b></a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="img-wishlist">
                                <div class="protip-wishlist">
                                    <ul>
                                        <li class="protip-wish-btn"><a
                                                href="https://calendar.google.com/calendar/r/eventedit?text={{ $discount['title'] }}"
                                                target="__blank" title="{{ __('Reminder') }}"><i data-feather="bell"></i></a></li>
                                        @if(Auth::check())
                                        <li class="protip-wish-btn"><a class="compare" data-id="{{filter_var($discount->id)}}" title="compare"><i data-feather="bar-chart"></i></a></li>
                                        {{-- @php
                                        $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',$discount->id)->first();
                                        @endphp --}}
                                        @php
                                        $wish = App\Wishlist::firstOrNew([
                                               'user_id' => Auth::id(),
                                               'course_id' => $discount->id
                                           ]);
                                           @endphp
                                        @if ($wish == NULL)
                                        <li class="protip-wish-btn">
                                            <form id="demo-form2" method="post"
                                                action="{{ url('show/wishlist', $discount->id) }}" data-parsley-validate
                                                class="form-horizontal form-label-left">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                <button class="wishlisht-btn" title="{{ __('Add to Wishlist') }}" type="submit"><i
                                                        data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @else
                                        <li class="protip-wish-btn-two">
                                            <form id="demo-form2" method="post"
                                                action="{{ url('remove/wishlist', $discount->id) }}" data-parsley-validate
                                                class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                <button class="wishlisht-btn heart-fill" title="Remove from Wishlist"
                                                    type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @endif
                                        @else
                                        <li class="protip-wish-btn"><a href="{{ route('login') }}" title="{{ __('Login') }}"><i
                                                    data-feather="heart"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div id="prime-next-item-description-block{{$discount->id}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <div class="row">
                                <div class="col-lg-10">
                                    <h5 class="description-heading">{{ $discount['title'] }}</h5>
                                </div>
                                <div class="col-lg-2">
                                    <div class="des-btn-block">
                                        <div class="img-wishlist">
                                            <div class="protip-wishlist">
                                                <ul>
                                                    @if(Auth::check())
                                                        @php
                                                        $user = Auth::user();
                                                        $wish = $user->wishlist->where('course_id', $discount->id)->first();
                                                        $formAction = $wish ? url('remove/wishlist', $discount->id) : url('show/wishlist', $discount->id);
                                                        $btnClass = $wish ? 'heart-fill' : '';
                                                        $btnTitle = $wish ? __('Remove from Wishlist') : __('Add to Wishlist');
                                                        @endphp
                                                        <li class="protip-wish-btn">
                                                            <form id="demo-form2" method="post" action="{{ $formAction }}" data-parsley-validate class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                                                <input type="hidden" name="course_id" value="{{ $discount->id }}" />
                                                                <button class="wishlisht-btn {{ $btnClass }}" title="{{ $btnTitle }}" type="submit"><i data-feather="heart"></i></button>
                                                            </form>
                                                        </li>
                                                    @else
                                                        <li class="protip-wish-btn">
                                                            <a href="{{ route('login') }}" title="{{ __('Login')}}"><i data-feather="heart"></i></a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            
                            <div class="main-des">
                                <p>Last Updated: {{ date('jS F Y', strtotime($discount->updated_at)) }}</p>
                            </div>
                            <ul class="description-list">
                                <li>
                                    <i data-feather="play-circle"></i>
                                    <div class="class-des">
                                        {{ __('Classes') }}:
                                        @php
                                        $classCount = App\CourseClass::where('course_id', $discount->id)->count();
                                        echo $classCount > 0 ? $classCount : "0";
                                        @endphp
                                    </div>
                                </li>
                                <li>&nbsp;</li>
                                <li>
                                    <div>
                                        <div class="time-des">
                                            <span class="">
                                                <i data-feather="clock"></i>
                                                @php
                                                $classDuration = App\CourseClass::where('course_id', $discount->id)->sum("duration");
                                                @endphp
                                                {{ $classDuration }} {{ __('Minutes') }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="lang-des">
                                        @if($discount['language_id'] != NULL && isset($c->language))
                                            <i data-feather="globe"></i> {{ $discount->language['name'] }}
                                        @endif
                                    </div>
                                </li>
                            </ul>                            
                            <div class="product-main-des">
                                <p>{{ $discount->short_detail }}</p>
                            </div>
                            <div>
                                @if($discount->whatlearns->isNotEmpty())
                                @foreach($discount->whatlearns as $wl)
                                @if($wl->status ==1)
                                <div class="product-learn-dtl">
                                    <ul>
                                        <li><i data-feather="check-circle"></i>{{ str_limit($wl['detail'], $limit = 120, $end = '...') }}
                                        </li>
                                    </ul>
                                </div>
                                @endif
                                @endforeach
                                @endif
                            </div>
                            <div class="des-btn-block">
                                <div class="row">
                                    <div class="col-lg-12">
                                        @php
                                            $isAdmin = (Auth::check() && Auth::user()->role === 'admin');
                                            $isUserLoggedIn = Auth::check();
                                            $hasEnrollment = ($isUserLoggedIn && App\Order::where('user_id', Auth::user()->id)->where('course_id', $discount->id)->first() !== null);
                                            $hasCartItem = ($isUserLoggedIn && App\Cart::where('user_id', Auth::user()->id)->where('course_id', $discount->id)->first() !== null);
                                        @endphp
                                    
                                        <div class="protip-btn">
                                            @if ($discount->type == 1)
                                                @if ($isAdmin || ($isUserLoggedIn && $hasEnrollment))
                                                    <a href="{{ route('course.content',['slug' => $discount->slug ]) }}"
                                                       class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                                @elseif ($isUserLoggedIn)
                                                    @if (!empty($cart) && $hasCartItem)
                                                        <form id="demo-form2" method="post" action="{{ route('remove.item.cart', $cart->id) }}">
                                                            {{ csrf_field() }}
                                                            <div class="box-footer">
                                                                <button type="submit" class="btn btn-primary">{{ __('Remove From Cart') }}</button>
                                                            </div>
                                                        </form>
                                                    @else
                                                        <form id="demo-form2" method="post" action="{{ route('addtocart', ['course_id' => $discount->id, 'price' => $discount->price, 'discount_price' => $discount->discount_price ]) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="category_id" value="{{ $discount->category['id'] ?? '-' }}" />
                                                            <div class="box-footer">
                                                                <button type="submit" class="btn btn-primary">{{ __('Add To Cart') }}</button>
                                                            </div>
                                                        </form>
                                                    @endif
                                                @endif
                                            @else
                                                @if ($isUserLoggedIn)
                                                    @if ($isAdmin || !$hasEnrollment)
                                                        <a href="{{ url('enroll/show', $c->id) }}" class="btn btn-primary" title="Enroll Now">
                                                            <i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}
                                                        </a>
                                                    @else
                                                        <a href="{{ route('course.content', ['slug' => $discount->slug ]) }}"
                                                           class="btn btn-secondary" title="Cart">{{ __('Go To Course') }}</a>
                                                    @endif
                                                @else
                                                    @if ($gsetting->guest_enable == 1)
                                                        <form id="demo-form2" method="post" action="{{ route('guest.addtocart', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}
                                                            <div class="box-footer">
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i data-feather="shopping-cart"></i>&nbsp;{{ __('Add To Cart') }}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    @else
                                                        <a href="{{ route('login') }}" class="btn btn-primary" title="Enroll Now">
                                                            <i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}
                                                        </a>
                                                    @endif
                                                @endif
                                            @endif
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
</section>
@endif
<!-- Student start -->
@if(Auth::check())
@if($hsetting->recentcourse_enable   == 1 && isset($recent_course_id) && isset($recent_course) && optional($recent_course)->status == 1)
<section id="student" class="student-main-block top-40">
    <div class="container-xl">
        @if($total_count >= '0')
        <h4 class="student-heading">{{ __('Recently Viewed Courses') }}</h4>
        <div id="recent-courses-slider" class="student-view-slider-main-block owl-carousel">
            @foreach($recent_course_id as $view)
            @php
            $recent_course = App\Course::where('id', $view)->with('user')->first();
            @endphp
            @if(isset($recent_course))
            @if($recent_course->status == 1)
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image">
                    <div class="view-block">
                        <div class="view-img">
                            @php
                            $imageUrl = $recent_course['preview_image'] !== NULL && $recent_course['preview_image'] !== ''
                                ? asset('images/course/'.$recent_course['preview_image'])
                                : Avatar::create($recent_course->title)->toBase64();
                            $courseUrl = route('user.course.show', ['slug' => $recent_course->slug]);
                            @endphp                    
                            <a href="{{ $courseUrl }}">
                                <img data-src="{{ $imageUrl }}" alt="course" class="img-fluid owl-lazy">
                            </a>
                        </div>
                        <div class="advance-badge">
                            @php
                            $levelTags = [
                                'trending' => ['badgeClass' => 'bg-warning', 'label' => __('Trending')],
                                'featured' => ['badgeClass' => 'bg-danger', 'label' => __('Featured')],
                                'new' => ['badgeClass' => 'bg-success', 'label' => __('New')],
                                'onsale' => ['badgeClass' => 'bg-info', 'label' => __('On-sale')],
                                'bestseller' => ['badgeClass' => 'bg-success', 'label' => __('Bestseller')],
                                'beginner' => ['badgeClass' => 'bg-primary', 'label' => __('Beginner')],
                                'intermediate' => ['badgeClass' => 'bg-secondary', 'label' => __('Intermediate')]
                            ];
                        
                            $levelTag = $recent_course['level_tags'];
                            @endphp
                        
                            @if (array_key_exists($levelTag, $levelTags))
                                <span class="badge {{ $levelTags[$levelTag]['badgeClass'] }}">{{ $levelTags[$levelTag]['label'] }}</span>
                            @endif
                        </div>                        
                        <div class="view-user-img">

                            @if($recent_course->user['user_img'] !== NULL && $recent_course->user['user_img'] !== '')
                            <a href="{{ route('all/profile',$recent_course->user->id) }}" title="{{$recent_course->title}} "><img
                                    src="{{ asset('images/user_img/'.$recent_course->user['user_img']) }}"
                                    class="img-fluid user-img-one" alt="{{$recent_course->title}}"></a>
                            @else
                            <a href="{{ route('all/profile',$recent_course->user->id) }}" title=" {{$recent_course->title}}"><img src="{{ asset('images/default/user.png') }}"
                                    class="img-fluid user-img-one" alt="{{$recent_course->title}}"></a>
                            @endif
                        </div>
                        <div class="view-dtl">
                            <div class="view-heading"><a
                                    href="{{ route('user.course.show',['slug' => $recent_course->slug ]) }}">{{ str_limit($recent_course->title, $limit = 30, $end = '...') }}</a>
                            </div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$recent_course->user->id) }}"> {{ optional($recent_course->user)['fname'] }}</a></span></h6>
                            </div>
                            
                            @include('ratings.discountratings', ['courseId' => $recent_course->id])

                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="count-user">
                                            <i data-feather="user"></i><span>
                                                @php
                                                $data = App\Order::where('course_id', $recent_course->id)->count();
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
                                        <div class="rate text-right">
                                            <ul>
                                                @php
                                                $currencyCode = $currency->code;
                                                $changedCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currencyCode;
                                                $price = currency($recent_course->price, $from = $currencyCode, $to = $changedCurrency, $format = true);
                                                $discountPrice = $recent_course->discount_price !== null ? currency($recent_course->discount_price, $from = $currencyCode, $to = $changedCurrency, $format = true) : null;
                                                @endphp
                                    
                                                @if ($recent_course->type == 1)
                                                    @if ($discountPrice !== null)
                                                        <li><a><b>{{ $discountPrice }}</b></a></li>
                                                        <li><a><b><strike>{{ $price }}</strike></b></a></li>
                                                    @else
                                                        <li><a><b>{{ $price }}</b></a></li>
                                                    @endif
                                                @else
                                                    <li><a><b>{{ __('Free') }}</b></a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="img-wishlist">
                                <div class="protip-wishlist">
                                    <ul>
                                        @if(Auth::check())
                                            @php
                                            $user = auth()->user();
                                            $wish = $user->wishlist->where('course_id', $recent_course->id)->first();
                                            $formAction = $wish ? url('remove/wishlist', $recent_course->id) : url('show/wishlist', $recent_course->id);
                                            $btnClass = $wish ? ' heart-fill' : '';
                                            $btnTitle = $wish ? 'Remove from Wishlist' : 'Add to wishlist';
                                            @endphp
                                            <li class="protip-wish-btn">
                                                <form id="demo-form2" method="post" action="{{ $formAction }}" data-parsley-validate class="form-horizontal form-label-left">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                                    <input type="hidden" name="course_id" value="{{ $recent_course->id }}" />
                                                    <button class="wishlisht-btn{{ $btnClass }}" title="{{ $btnTitle }}" type="submit">
                                                        <i data-feather="heart" class="rgt-10"></i>
                                                    </button>
                                                </form>
                                            </li>
                                        @else
                                            <li class="protip-wish-btn">
                                                <a href="{{ route('login') }}" title="heart">
                                                    <i data-feather="heart" class="rgt-10"></i>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endif
            @endforeach
        </div>
        @endif
    </div>
</section>
@endif
@endif
<!-- Students end -->
<!-- Student start -->
@if(Auth::check())
@php
if(Schema::hasColumn('orders', 'refunded')){
$enroll = App\Order::where('refunded', '0')->where('user_id', auth()->user()->id)->where('status',
'1')->with('courses')->with(['user','courses.user'] )->get();
}
else{
$enroll = NULL;
}
@endphp
@if($hsetting->purchase_enable == 1 && isset($enroll))
<section id="student" class="student-main-block top-40">
    <div class="container-xl">
         @if(count($enroll) > 0)
        <h4 class="student-heading">{{ __('My Purchased Courses') }}</h4>
        <div id="my-courses-slider" class="student-view-slider-main-block owl-carousel">
            @foreach($enroll as $enrol)
            @if(isset($enrol->courses) && $enrol->courses['status'] == 1 )
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image">
                    <div class="view-block">
                        <div class="view-img">
                            @if($enrol->courses['preview_image'] !== NULL && $enrol->courses['preview_image'] !== '')
                            <a
                                href="{{ route('course.content',['slug' => $enrol->courses->slug ]) }}"><img
                                    data-src="{{ asset('images/course/'.$enrol->courses['preview_image']) }}"
                                    alt="course" class="img-fluid owl-lazy"></a>
                            @else
                            <a
                                href="{{ route('course.content',['slug' => $enrol->courses->slug ]) }}"><img
                                    data-src="{{ Avatar::create($enrol->courses->title)->toBase64() }}" alt="course"
                                    class="img-fluid owl-lazy"></a>
                            @endif
                        </div>
                        <div class="view-user-img">

                            @if($enrol->user['user_img'] !== NULL && $enrol->user['user_img'] !== '')
                            <a href="{{ route('all/profile',$enrol->user->id) }}" title=" {{$enrol->courses->title}} "><img src="{{ asset('images/user_img/'.$enrol->user['user_img']) }}"
                                    class="img-fluid user-img-one" alt="{{$enrol->courses->title}}"></a>
                            @else
                            <a href="{{ route('all/profile',$enrol->user->id) }}" title=" {{$enrol->courses->title}} "><img src="{{ asset('images/default/user.png') }}"
                                    class="img-fluid user-img-one" alt="{{$enrol->courses->title}}"></a>
                            @endif
                        </div>
                        <div class="view-dtl">
                            <div class="view-heading"><a
                                    href="{{ route('course.content',['slug' => $enrol->courses->slug ]) }}" title=" {{$enrol->courses->title}} ">{{ str_limit($enrol->courses->title, $limit = 30, $end = '...') }}</a>
                            </div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$enrol->user->id) }}"> {{ optional($enrol->user)['fname'] }}</a></span></h6>
                            </div>

                            @include('ratings.courseratings', ['courseId' => $enrol->courses->id])

                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="count-user">
                                            <i data-feather="user"></i><span>
                                                @php
                                                $data = App\Order::where('course_id', $enrol->courses->id)->count();
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
                                        {{-- <div class="rate text-right">
                                            <ul>
                                                @php
                                                $currencyCode = $currency->code;
                                                $changedCurrency = Session::has('changed_currency') ? Session::get('changed_currency') : $currencyCode;
                                                $course = $enrol->courses;
                                                $discountPrice = $course->discount_price !== null
                                                    ? currency($course->discount_price, $from = $currencyCode, $to = $changedCurrency, $format = false)
                                                    : null;
                                                $price = currency($course->price, $from = $currencyCode, $to = $changedCurrency, $format = false);
                                                $symbolPosition = activeCurrency()->getData()->position;
                                                $symbol = activeCurrency()->getData()->symbol;
                                                @endphp
                                    
                                                @if ($course->type == 1)
                                                    @if ($discountPrice !== null)
                                                        <li><a><b>{{ $symbolPosition == 'l' ? $symbol : '' }}{{ price_format($discountPrice) }}{{ $symbolPosition == 'r' ? $symbol : '' }}</b></a></li>
                                                        <li><a><b><strike>{{ $symbolPosition == 'l' ? $symbol : '' }}{{ price_format($price) }}{{ $symbolPosition == 'r' ? $symbol : '' }}</strike></b></a></li>
                                                    @else
                                                        <li><a><b>{{ $symbolPosition == 'l' ? $symbol : '' }}{{ price_format($price) }}{{ $symbolPosition == 'r' ? $symbol : '' }}</b></a></li>
                                                    @endif
                                                @else
                                                    <li><a><b>{{ __('Free') }}</b></a></li>
                                                @endif
                                            </ul>
                                        </div> --}}

                                        <div class="rate text-right">
                                            <ul>
                                                @php
                                                    $currencyCode = $currency->code;
                                                    $changedCurrency = Session::get('changed_currency', $currencyCode);
                                                    $course = $enrol->courses;
                                                    $discountPrice = $course->discount_price !== null
                                                        ? currency($course->discount_price, $from = $currencyCode, $to = $changedCurrency, $format = false)
                                                        : null;
                                                    $price = currency($course->price, $from = $currencyCode, $to = $changedCurrency, $format = false);
                                                    $currencyData = activeCurrency()->getData();
                                                    $symbolPosition = $currencyData->position;
                                                    $symbol = $currencyData->symbol;
                                                @endphp
                                        
                                                @if ($course->type == 1)
                                                    @if ($discountPrice !== null)
                                                        <li>
                                                            <a>
                                                                <b>
                                                                    @if($symbolPosition == 'l') {{ $symbol }} @endif
                                                                    {{ price_format($discountPrice) }}
                                                                    @if($symbolPosition == 'r') {{ $symbol }} @endif
                                                                </b>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a>
                                                                <b>
                                                                    <strike>
                                                                        @if($symbolPosition == 'l') {{ $symbol }} @endif
                                                                        {{ price_format($price) }}
                                                                        @if($symbolPosition == 'r') {{ $symbol }} @endif
                                                                    </strike>
                                                                </b>
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <a>
                                                                <b>
                                                                    @if($symbolPosition == 'l') {{ $symbol }} @endif
                                                                    {{ price_format($price) }}
                                                                    @if($symbolPosition == 'r') {{ $symbol }} @endif
                                                                </b>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @else
                                                    <li>
                                                        <a>
                                                            <b>{{ __('Free') }}</b>
                                                        </a>
                                                    </li>
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
            @endif
            @endforeach
        </div>
        @endif
    </div>
</section>
@endif
@endif
<!-- Students end -->
<!-- learning-courses start -->
@if($hsetting->recentcourse_enable  == 1 && isset($categories))
<section id="learning-courses" class="learning-courses-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="student-heading">{{ __('Recent Courses') }}</h4>
                <div class="btn_more view-button">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="learning-courses">
                    @if(isset($categories))
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @foreach($categories as $cats)
                        <li class="btn nav-item"><a class="nav-item nav-link" id="home-tab" data-toggle="tab"
                                href="#content-tabs" role="tab" aria-controls="home"
                                onclick="showtab('{{ $cats->id }}')" aria-selected="true">{{ $cats['title'] }}</a></li>

                        @endforeach
                    </ul>
                    @endif
                </div>
                <div class="tab-content" id="myTabContent">
                    @if(!empty($categories))
                    @foreach($categories as $cate)
                    <div class="tab-pane fade show active" id="content-tabs" role="tabpanel" aria-labelledby="home-tab">
                        <div id="tabShow">
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- learning-courses end -->
<!-- Advertisement -->
@if(isset($advs))
@foreach($advs as $adv)
@if($adv->position == 'belowrecent')
<br>
<section id="student" class="student-main-block btm-40">
    <div class="container-xl">
        <a href="{{ $adv->url1 }}" title="{{ __('Click to visit') }}">
            <img class="lazy img-fluid advertisement-img-one" data-src="{{ url('images/advertisement/'.$adv->image1) }}"
                alt="{{ $adv->image1 }}">
        </a>
    </div>
</section>
@endif
@endforeach
@endif
<!-- Advertisement -->
<!-- Student start -->
@if( !$cors->isEmpty() && $hsetting->featured_enable)
<section id="student" class="student-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="student-heading">{{ __('Featured Courses') }}</h4>
                <div class="view-button">
                    <a href="{{ url('featured-courses') }}" class="btn btn-secondary" title="View More">{{__('View More')}}<i data-feather="chevrons-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div id="student-view-slider" class="student-view-slider-main-block owl-carousel">
            @foreach($cors as $c)
             @if($c->status == 1 && $c->featured == 1)   
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif"
                    data-pt-placement="outside" data-pt-interactive="false"
                    data-pt-title="#prime-next-item-description-block{{$c->id}}">
                    <div class="view-block">
                        <div class="view-img">
                            @php
                            $previewImage = $c['preview_image'] !== NULL && $c['preview_image'] !== ''
                                ? asset('images/course/'.$c['preview_image'])
                                : Avatar::create($c->title)->toBase64();
                            $courseUrl = route('user.course.show', ['slug' => $c->slug]);
                            @endphp
                        
                            <a href="{{ $courseUrl }}">
                                <img data-src="{{ $previewImage }}" alt="course" class="img-fluid owl-lazy">
                            </a>
                        </div>                        
                        
                    @endif
                    @php
                    $levelTags = [
                        'trending' => ['bg-warning', __('Trending')],
                        'featured' => ['bg-danger', __('Featured')],
                        'new' => ['bg-success', __('New')],
                        'onsale' => ['bg-info', __('Onsale')],
                        'bestseller' => ['bg-success', __('Bestseller')],
                        'beginner' => ['bg-primary', __('Beginner')],
                        'intermediate' => ['bg-secondary', __('Intermediate')],
                    ];
                    @endphp
                    @if(isset($levelTags[$c['level_tags']]))
                        <div class="advance-badge">
                            <span class="badge {{ $levelTags[$c['level_tags']][0] }}">{{ $levelTags[$c['level_tags']][1] }}</span>
                        </div>
                    @endif    
                    @if(isset($c->user->id))
                        <div class="view-user-img">
                            @if(optional($c->user)['user_img'] !== NULL && optional($c->user)['user_img'] !== '')
                            <a href="{{ route('all/profile',$c->user->id) }}" title=" {{$c->title}} "><img src="{{ asset('images/user_img/'.$c->user['user_img']) }}"
                                    class="img-fluid user-img-one" alt="{{$c->title}} "></a>
                            @else
                            <a href="{{ route('all/profile',$c->user->id) }}" title=" {{$c->title}} "><img src="{{ asset('images/default/user.png') }}"
                                    class="img-fluid user-img-one" alt="{{$c->title}} "></a>
                            @endif
                        </div>
                        <div class="view-dtl">
                            <div class="view-heading"><a
                                    href="{{ route('user.course.show',['slug' => $c->slug ]) }}" title=" {{$c->title}} ">{{ str_limit($c->title, $limit = 30, $end = '...') }}</a>
                            </div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$c->user->id) }}"> {{ optional($c->user)['fname'] }}</a></span></h6>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    @include('ratings.courseratings', ['courseId' => $c->id])
                                </div>
                                <div class="col-lg-6">
                                    @if(isset($c->discount_price))
                                    @php
                                    $discountPercentage = round((($c->price - $c->discount_price) * 100) / $c->price);
                                    @endphp
                                    <div class="badges bg-priamry offer-badge"><span>OFF<span>{{ $discountPercentage }}%</span></span></div>
                                </div>
                            </div>
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="count-user">
                                            <i data-feather="user"></i><span>
                                                @php
                                                $data = App\Order::where('course_id', $c->id)->count();
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
                                        <div class="rate text-right">
                                            <ul>
                                                @if($c->type == 1)
                                                    @if($c->discount_price != null)
                                                        <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($c->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
                                                        <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($c->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</strike></b></a></li>
                                                    @else
                                                        @if($c->price != null)
                                                            <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($c->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
                                                        @endif
                                                    @endif
                                                @else
                                                    <li><a><b>{{ __('Free') }}</b></a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="img-wishlist">
                                <div class="protip-wishlist">
                                    <ul>
                                        <li class="protip-wish-btn">
                                            <a href="https://calendar.google.com/calendar/r/eventedit?text={{ $c['title'] }}"
                                               target="__blank" title="reminder">
                                                <i data-feather="bell"></i>
                                            </a>
                                        </li>
                                        @if(Auth::check())
                                            <li class="protip-wish-btn">
                                                <a class="compare" data-id="{{ filter_var($c->id) }}" title="compare">
                                                    <i data-feather="bar-chart"></i>
                                                </a>
                                            </li>
                                            @php
                                                $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id', $c->id)->first();
                                            @endphp
                                            @if ($wish == NULL)
                                                <li class="protip-wish-btn">
                                                    <form id="demo-form2" method="post" action="{{ url('show/wishlist', $c->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="user_id" value="{{ Auth::User()->id }}" />
                                                        <input type="hidden" name="course_id" value="{{ $c->id }}" />
                                                        <button class="wishlisht-btn" title="Add to wishlist" type="submit">
                                                            <i data-feather="heart"></i>
                                                        </button>
                                                    </form>
                                                </li>
                                            @else
                                                <li class="protip-wish-btn-two">
                                                    <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $c->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="user_id" value="{{ Auth::User()->id }}" />
                                                        <input type="hidden" name="course_id" value="{{ $c->id }}" />
                                                        <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit">
                                                            <i data-feather="heart"></i>
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        @else
                                            <li class="protip-wish-btn">
                                                <a href="{{ route('login') }}" title="heart">
                                                    <i data-feather="heart"></i>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div id="prime-next-item-description-block{{$c->id}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <div class="row">
                                <div class="col-lg-10">
                                    <h5 class="description-heading">{{ $c['title'] }}</h5>
                                </div>
                                <div class="col-lg-2">
                                    <div class="des-btn-block">
                                        <div class="img-wishlist">
                                            <div class="protip-wishlist">
                                                <ul>
                                                    @if(Auth::check())
                                                        @php
                                                            $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id', $c->id)->first();
                                                        @endphp
                                                        <li class="protip-wish-btn{{ $wish ? '-two' : '' }}">
                                                            <form id="demo-form2" method="post" action="{{ $wish ? url('remove/wishlist', $c->id) : url('show/wishlist', $c->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                                <input type="hidden" name="course_id" value="{{$c->id}}" />
                                                                <button class="wishlisht-btn{{ $wish ? ' heart-fill' : '' }}" title="{{ $wish ? 'Remove from Wishlist' : 'Add to wishlist' }}" type="submit"><i data-feather="heart"></i></button>
                                                            </form>
                                                        </li>
                                                    @else
                                                        <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="main-des">
                                <p>Last Updated: {{ date('jS F Y', strtotime($c->updated_at)) }}</p>
                            </div>
                            <ul class="description-list">
                                <li>
                                    <i data-feather="play-circle"></i>
                                    <div class="class-des">
                                        {{ __('Classes') }}: {{ App\CourseClass::where('course_id', $c->id)->count() ?? 0 }}
                                    </div>
                                </li>
                                <li>
                                    <div class="time-des">
                                        <span class="">
                                            <i data-feather="clock"></i>
                                            {{ App\CourseClass::where('course_id', $c->id)->sum('duration') }} Minutes
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div class="lang-des">
                                        @if($c['language_id'] !== NULL && isset($c->language))
                                            <i data-feather="globe"></i> {{ $c->language['name'] }}
                                        @endif
                                    </div>
                                </li>
                            </ul>                            
                            <div class="product-main-des">
                                <p>{{ $c->short_detail }}</p>
                            </div>
                            <div>
                                @if($c->whatlearns->isNotEmpty())
                                @foreach($c->whatlearns as $wl)
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
                                    <div class="col-lg-12">
                                        @if($c->type == 1)
                                            @if(Auth::check())
                                                @if(Auth::User()->role == "admin" || (!empty($order) && $order->status == 1))
                                                    <div class="protip-btn">
                                                        <a href="{{ route('course.content',['slug' => $c->slug ]) }}"
                                                            class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                                    </div>
                                                @else
                                                    @php
                                                        $cart = App\Cart::where('user_id', Auth::User()->id)->where('course_id', $c->id)->first();
                                                    @endphp
                                                    @if(!empty($cart))
                                                        <div class="protip-btn">
                                                            <form id="demo-form2" method="post" action="{{ route('remove.item.cart',$cart->id) }}">
                                                                {{ csrf_field() }}
                                                                <div class="box-footer">
                                                                    <button type="submit" class="btn btn-primary">{{ __('Remove From Cart') }}</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    @else
                                                        <div class="protip-btn">
                                                            <form id="demo-form2" method="post" action="{{ route('addtocart',['course_id' => $c->id, 'price' => $c->price, 'discount_price' => $c->discount_price ]) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="category_id" value="{{$c->category['id'] ?? '-'}}" />
                                                                <div class="box-footer">
                                                                    <button type="submit" class="btn btn-primary"><i data-feather="shopping-cart"></i>{{ __('Add To Cart')}}</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    @endif
                                                @endif
                                            @else
                                                @if($gsetting->guest_enable == 1)
                                                    <form id="demo-form2" method="post" action="{{ route('guest.addtocart', $c->id) }}" data-parsley-validate class="form-horizontal form-label-left">
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
                                                @if(Auth::User()->role == "admin" || $enroll != NULL)
                                                    <div class="protip-btn">
                                                        <a href="{{ route('course.content',['slug' => $c->slug ]) }}"
                                                            class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                                    </div>
                                                @else
                                                    <div class="protip-btn">
                                                        <a href="{{url('enroll/show',$c->id)}}" class="btn btn-primary" title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="protip-btn">
                                                    <a href="{{ route('login') }}" class="btn btn-primary" title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                                </div>
                                            @endif
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
</section>
@endif
<!-- Students end -->
<!-- Subscription Bundle start -->
<section id="subscription" class="student-main-block">
    <div class="container-xl">
        @if (isset($subscriptionBundles) && !$subscriptionBundles->isEmpty())
        <h4 class="student-heading">{{ __('Subscription Bundles') }}</h4>
        <div id="subscription-bundle-view-slider" class="student-view-slider-main-block owl-carousel">
            @foreach ($subscriptionBundles as $bundle)
            @if ($bundle->status == 1 && $bundle->is_subscription_enabled == 1)

            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-interactive="false"
                    data-pt-title="#prime-next-item-description-block-3{{ $bundle->id }}">
                    <div class="view-block">
                        <div class="view-img">
                            <a href="{{ route('bundle.detail', $bundle->slug) }}" title="{{$bundle->user->fname}}">
                                <img data-src="{{ asset('images/bundle/' . ($bundle['preview_image'] ?? Avatar::create($bundle->title)->toBase64())) }}"
                                    alt="course" class="img-fluid owl-lazy">
                            </a>
                        </div>                        
                        
                        <div class="view-user-img">
                            <a href="{{ route('all/profile', $bundle->user->id) }}" title="{{$bundle->user->fname}}">
                                <img src="{{ asset('images/user_img/' . ($bundle->user['user_img'] ?? 'default/user.png')) }}"
                                    class="img-fluid user-img-one" alt="{{$bundle->user->fname}}">
                            </a>
                        </div>
                        <div class="view-dtl">
                            <div class="view-heading"><a
                                    href="{{ route('bundle.detail', $bundle->slug) }}">{{ str_limit($bundle->title, $limit = 30, $end = '...') }}</a>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="user-name">
                                        <h6>{{ __('By') }} <span><a href="{{ route('all/profile',$bundle->user->id) }}"> {{ optional($bundle->user)['fname'] }}</a></span></h6>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="badges bg-priamry offer-badge">
                                        <span>
                                            {{ __('OFF') }}
                                            <span>
                                                <?php
                                                if ($bundle->price != 0) {
                                                    echo round((($bundle->price - $bundle->discount_price) * 100) / $bundle->price) . '%';
                                                } else {
                                                    echo "0%"; // Or handle the zero division case in a way that makes sense for your application
                                                }
                                                ?>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <a href="#"><i data-feather="calendar"></i> {{ date('d-m-Y', strtotime($bundle['created_at'])) }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        @if ($bundle->type == 1 && $bundle->price != null)
                                        <div class="rate text-right">
                                            <ul>
                                                @if($bundle->discount_price != null)
                                                <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format( currency($bundle->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
                                                <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format( currency($bundle->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</strike></b></a></li>
                                                @else
                                                <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format( currency($bundle->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
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
                <div id="prime-next-item-description-block-3{{ $bundle->id }}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <h5 class="description-heading">{{ $bundle['title'] }}</h5>
                        <div class="main-des">
                            <p>{{ str_limit($bundle['short_detail'] ?? $bundle['detail'], $limit = 200, $end = '...') }}</p>
                        </div>
                        <div class="des-btn-block">
                            <div class="row">
                                <div class="col-lg-12">
                                    @if ($bundle->type == 1)
                                        @if (Auth::check())
                                            @if (Auth::User()->role == 'admin' || (!empty($order) && $order->status == 1))
                                                <div class="protip-btn">
                                                    <a href="" class="btn btn-secondary" title="course">{{ __('Purchased') }}</a>
                                                </div>
                                            @else
                                                @php
                                                    $cart = App\Cart::where('user_id', Auth::User()->id)->where('bundle_id', $bundle->id)->first();
                                                @endphp
                                                @if (!empty($cart))
                                                    <div class="protip-btn">
                                                        <form id="demo-form2" method="post" action="{{ route('remove.item.cart', $cart->id) }}">
                                                            {{ csrf_field() }}
                                                            <div class="box-footer">
                                                                <button type="submit" class="btn btn-primary">{{ __('Remove From Cart') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="protip-btn">
                                                        <form id="demo-form2" method="post" action="{{ route('bundlecart', $bundle->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="user_id" value="{{ Auth::User()->id }}" />
                                                            <input type="hidden" name="bundle_id" value="{{ $bundle->id }}" />
                                                            <div class="box-footer">
                                                                <button type="submit" class="btn btn-primary">{{ __('Subscribe Now') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @endif
                                            @endif
                                        @else
                                            <div class="protip-btn">
                                                <a href="{{ route('login') }}" class="btn btn-primary"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;{{ __('Subscribe Now') }}</a>
                                            </div>
                                        @endif
                                    @else
                                        @if (Auth::check())
                                            @if (Auth::User()->role == 'admin' || $enroll != null)
                                                <div class="protip-btn">
                                                    <a href="" class="btn btn-secondary" title="course">{{ __('Purchased') }}</a>
                                                </div>
                                            @else
                                                <div class="protip-btn">
                                                    <a href="{{ url('enroll/show', $bundle->id) }}" class="btn btn-primary" title="Enroll Now">{{ __('Subscribe Now') }}</a>
                                                </div>
                                            @endif
                                        @else
                                            <div class="protip-btn">
                                                <a href="{{ route('login') }}" class="btn btn-primary" title="Enroll Now">{{ __('Subscribe Now') }}</a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>

            @endif

            @endforeach
        </div>
        @endif
    </div>
</section>
<!-- Subscription Bundle end -->
<!-- Bundle start -->
@if(!$bundles->isEmpty() && $hsetting->bundle_enable && isset($bundles))
<section id="bundle-block" class="student-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="student-heading">{{ __('Bundle Courses') }}</h4>
                <div class="view-button">
                    <a href="{{url('bundle/view')}}" class="btn btn-secondary" title="View More">View More<i data-feather="chevrons-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @if(count($bundles) > 0)
        <div id="bundle-view-slider" class="student-view-slider-main-block owl-carousel">
            @foreach($bundles as $bundle)
            @if($bundle->status == 1)
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif"
                    data-pt-placement="outside" data-pt-interactive="false"
                    data-pt-title="#prime-next-item-description-block-4{{$bundle->id}}">
                    <div class="view-block">
                        <div class="view-img">
                            <a href="{{ route('bundle.detail', $bundle->slug) }}">
                                <img data-src="{{ $bundle['preview_image'] ? asset('images/bundle/'.$bundle['preview_image']) : Avatar::create($bundle->title)->toBase64() }}" alt="course" class="img-fluid owl-lazy">
                            </a>
                        </div>                        
                        <div class="view-user-img">
                            <a href="{{ route('all/profile', $bundle->user->id) }}" title="{{$bundle->user->fname}}">
                                <img src="{{ asset($bundle->user->user_img ? 'images/user_img/' . $bundle->user->user_img : 'images/default/user.png') }}" class="img-fluid user-img-one" alt="{{$bundle->user->fname}}">
                            </a>
                        </div>
                        <div class="view-dtl">
                            <div class="view-heading"><a
                                    href="{{ route('bundle.detail', $bundle->slug) }}">{{ str_limit($bundle->title, $limit = 30, $end = '...') }}</a>
                            </div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$bundle->user->id) }}"> {{ optional($bundle->user)['fname'] }}</a></span></h6>
                            </div>
                            <!-- <p class="btm-10"><a herf="#">{{ __('by') }} @if(isset($bundle->user)) {{ $bundle->user['fname'] }} {{ $bundle->user['lname'] }} @endif</a></p> -->
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="count-user">
                                            <i data-feather="user"></i><span>{{ $bundle->order->count() }}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        @if ($bundle->type == 1 && $bundle->price != null)
                                            <div class="rate text-right">
                                                <ul>
                                                    @if ($bundle->discount_price != null)
                                                        <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($bundle->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
                                                        <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($bundle->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</strike></b></a></li>
                                                    @else
                                                        <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($bundle->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
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
                                        <li class="protip-wish-btn">
                                            <a href="https://calendar.google.com/calendar/r/eventedit?text={{ $bundle['title'] }}" target="__blank" title="reminder"><i data-feather="bell"></i></a>
                                        </li>
                                        @if(Auth::check())
                                            <li class="protip-wish-btn">
                                                <a class="compare" data-id="{{ filter_var($bundle->id) }}" title="compare"><i data-feather="bar-chart"></i></a>
                                            </li>
                                            @php
                                            $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id', $bundle->id)->first();
                                            @endphp
                                            @if ($wish == NULL)
                                                <li class="protip-wish-btn">
                                                    <form id="demo-form2" method="post" action="{{ url('show/wishlist', $bundle->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="user_id" value="{{ Auth::User()->id }}" />
                                                        <input type="hidden" name="course_id" value="{{ $bundle->id }}" />
                                                        <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i data-feather="heart"></i></button>
                                                    </form>
                                                </li>
                                            @else
                                                <li class="protip-wish-btn-two">
                                                    <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $bundle->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="user_id" value="{{ Auth::User()->id }}" />
                                                        <input type="hidden" name="course_id" value="{{ $bundle->id }}" />
                                                        <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart"></i></button>
                                                    </form>
                                                </li>
                                            @endif
                                        @else
                                            <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div id="prime-next-item-description-block-4{{$bundle->id}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <h5 class="description-heading">{{ $bundle['title'] }}</h5>
                            <div class="product-main-des">
                                <p>{{ strip_tags(str_limit($bundle['detail'], $limit = 200, $end = '...')) }}</p>
                            </div>
                            <div>
                                <div class="product-learn-dtl">
                                    <ul>
                                        @foreach ($bundle->course_id as $bundles)
                                        @php
                                        $course = App\Course::where('id', $bundles)->first();
                                        @endphp
                                        @isset($course)
                                        <li><i data-feather="check-circle"></i>
                                            <a href="#">{{ $course['title'] }}</a>
                                        </li>
                                        @endisset

                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="des-btn-block">
                                <div class="row">
                                    <div class="col-lg-12">
                                        @if($bundle->type == 1)
                                        @if(Auth::check())
                                        @if(Auth::User()->role == "admin")
                                        <div class="protip-btn">
                                            <a href="" class="btn btn-secondary"
                                                title="course">{{ __('Purchased') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $order = App\Order::where('user_id', Auth::User()->id)->where('bundle_id',
                                        $bundle->id)->first();
                                        @endphp
                                        @if(!empty($order) && $order->status == 1)
                                        <div class="protip-btn">
                                            <a href="" class="btn btn-secondary"
                                                title="course">{{ __('Purchased') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $cart = App\Cart::where('user_id', Auth::User()->id)->where('bundle_id',
                                        $bundle->id)->first();
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
                                                action="{{ route('bundlecart', $bundle->id) }}" data-parsley-validate
                                                class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="bundle_id" value="{{$bundle->id}}" />

                                                <div class="box-footer">
                                                    <button type="submit"
                                                        class="btn btn-primary"><i data-feather="shopping-cart"></i>{{ __('Add To Cart') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                        @endif
                                        @endif
                                        @endif
                                        @else
                                        <div class="protip-btn">
                                            <a href="{{ route('login') }}" class="btn btn-primary"><i data-feather="shopping-cart"></i>&nbsp;{{ __('Add To Cart') }}</a>
                                        </div>
                                        @endif
                                        @else
                                        @if(Auth::check())
                                        @if(Auth::User()->role == "admin")
                                        <div class="protip-btn">
                                            <a href="" class="btn btn-secondary"
                                                title="course">{{ __('Purchased') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $enroll = App\Order::where('user_id', Auth::User()->id)->where('bundle_id',
                                        $bundle->id)->first();
                                        @endphp
                                        @if($enroll == NULL)
                                        <div class="protip-btn">
                                            <a href="{{url('enroll/show',$bundle->id)}}" class="btn btn-primary"
                                                title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                        </div>
                                        @else
                                        <div class="protip-btn">
                                            <a href="" class="btn btn-secondary"
                                                title="Cart">{{ __('Purchased') }}</a>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        @endif
</section>
@endif
<!-- Bundle end -->
@if(!$bestselling->isEmpty() && $hsetting->bestselling_enable && isset($bestselling) && count($bestselling) > 0 )
<section id="student" class="student-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="student-heading">{{ __('Best selling Courses') }}</h4>
                <div class="view-button">
                    <a href="{{ url('bestselling-courses') }}" class="btn btn-secondary" title="View More">View More<i data-feather="chevrons-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div id="bestseller-view-slider" class="student-view-slider-main-block owl-carousel">
            @foreach($bestselling as $best)
           
             @if($best->courses->status == 1 )
            
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif"
                    data-pt-placement="outside" data-pt-interactive="false"
                    data-pt-title="#prime-next-item-description-block{{$best->id}}">
                    <div class="view-block">
                        <div class="view-img">
                            <a href="{{ route('user.course.show', ['slug' => $best->courses->slug]) }}" title="{{$best->courses->title}}">
                                <img data-src="{{ $best->courses['preview_image'] ? asset('images/course/' . $best->courses['preview_image']) : Avatar::create($best->courses->title)->toBase64() }}" alt="course" class="img-fluid owl-lazy">
                            </a>
                        </div>                        
                        @if(in_array($best->courses['level_tags'], ['trending', 'featured', 'new', 'onsale', 'bestseller', 'beginner', 'intermediate']))
                        <div class="advance-badge">
                            @php
                                $badgeColors = [
                                    'trending' => 'warning',
                                    'featured' => 'danger',
                                    'new' => 'success',
                                    'onsale' => 'info',
                                    'bestseller' => 'success',
                                    'beginner' => 'primary',
                                    'intermediate' => 'secondary'
                                ];
                            @endphp
                            <span class="badge bg-{{ $badgeColors[$best->courses['level_tags']] }}">{{ __(ucfirst($best->courses['level_tags'])) }}</span>
                        </div>
                    @endif
                    @if(isset($best->courses->user->id))
                        <div class="view-user-img">
                            <a href="{{ route('all/profile', $best->courses->user->id) }}" title="{{$best->courses->user->fname}}">
                                <img src="{{ asset($best->courses->user->user_img ? 'images/user_img/' . $best->courses->user->user_img : 'images/default/user.png') }}" class="img-fluid user-img-one" alt="{{$best->courses->user->fname}}">
                            </a>
                        </div>                        
                        <div class="view-dtl">
                            @if(isset($best->courses->user->id))
                            <div class="view-heading"><a
                                    href="{{ route('user.course.show',['slug' => $best->courses->slug ]) }}" title="{{$best->courses->title}}">{{ str_limit($best->courses->title, $limit = 30, $end = '...') }}</a>
                            </div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$best->courses->user->id) }}"> {{ optional($best->courses->user)['fname'] }}</a></span></h6>
                            </div>
                            @endif
                            @include('ratings.courseratings', ['courseId' => $best->courses->id])

                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="count-user">
                                            <i data-feather="user"></i><span>
                                                @php
                                                $data = App\Order::where('course_id', $best->courses->id)->count();
                                                echo ($data > 0) ? $data : "0";
                                                @endphp
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        @if($best->courses->type == 1)
                                        <div class="rate text-right">
                                            <ul>
                                                @if($best->courses->discount_price != NULL)
                                                <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($best->courses['discount_price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
                                                <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($best->courses['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</strike></b></a></li>
                                                @else
                                                @if($best->courses->price != NULL)
                                                <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($best->courses['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
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
                                        <li class="protip-wish-btn">
                                            <a href="https://calendar.google.com/calendar/r/eventedit?text={{ $best['title'] }}" target="__blank" title="reminder">
                                                <i data-feather="bell"></i>
                                            </a>
                                        </li>
                                        @if (Auth::check())
                                            <li class="protip-wish-btn">
                                                <a class="compare" data-id="{{ filter_var($best->id) }}" title="compare">
                                                    <i data-feather="bar-chart"></i>
                                                </a>
                                            </li>
                                            @php
                                                $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id', $best->courses->id)->first();
                                            @endphp
                                            @if ($wish == NULL)
                                                <li class="protip-wish-btn">
                                                    <form id="demo-form2" method="post" action="{{ url('show/wishlist', $best->courses->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="user_id" value="{{ Auth::User()->id }}" />
                                                        <input type="hidden" name="course_id" value="{{ $best->courses->id }}" />
                                                        <button class="wishlisht-btn" title="Add to wishlist" type="submit">
                                                            <i data-feather="heart"></i>
                                                        </button>
                                                    </form>
                                                </li>
                                            @else
                                                <li class="protip-wish-btn-two">
                                                    <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $best->courses->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="user_id" value="{{ Auth::User()->id }}" />
                                                        <input type="hidden" name="course_id" value="{{ $best->courses->id }}" />
                                                        <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit">
                                                            <i data-feather="heart"></i>
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        @else
                                            <li class="protip-wish-btn">
                                                <a href="{{ route('login') }}" title="heart">
                                                    <i data-feather="heart"></i>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>                            
                        </div>
                        @endif
                    </div>
                </div>
                <div id="prime-next-item-description-block{{$best->courses->id}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <div class="row">
                                <div class="col-lg-10">
                                    <h5 class="description-heading">{{ $best->courses['title'] }}</h5>
                                </div>
                                <div class="col-lg-2">
                                    <div class="des-btn-block">
                                        <div class="img-wishlist">
                                            <div class="protip-wishlist">
                                                <ul>
                                                    @if (Auth::check())
                                                        @php
                                                        $wish = App\Wishlist::where('user_id', Auth::user()->id)->where('course_id', $best->courses->id)->first();
                                                        @endphp
                                                        <li class="protip-wish-btn">
                                                            <form id="demo-form2" method="post" action="{{ $wish ? url('remove/wishlist', $best->id) : url('show/wishlist', $best->courses->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                                                <input type="hidden" name="course_id" value="{{ $best->courses->id }}" />
                                                                <button class="wishlisht-btn{{ $wish ? ' heart-fill' : '' }}" title="{{ $wish ? 'Remove from Wishlist' : 'Add to wishlist' }}" type="submit"><i data-feather="heart"></i></button>
                                                            </form>
                                                        </li>
                                                    @else
                                                        <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="main-des">
                                <p>Last Updated: {{ date('jS F Y', strtotime($best->courses->updated_at)) }}</p>
                            </div>
                            <ul class="description-list">
                                <li>
                                    <i data-feather="play-circle"></i>
                                    <div class="class-des">
                                        {{ __('Classes') }}: {{ App\CourseClass::where('course_id', $best->courses->id)->count() ?: '0' }}
                                    </div>
                                </li>
                                &nbsp;
                                <li>
                                    <div class="time-des">
                                        <span>
                                            <i data-feather="clock"></i>
                                            {{ App\CourseClass::where('course_id', $best->courses->id)->sum('duration') }} {{ __('Minutes') }}
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div class="lang-des">
                                        @if($best->courses['language_id'])
                                            @isset($best->courses->language)
                                                <i data-feather="globe"></i> {{ $best->courses->language['name'] }}
                                            @endisset
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
                                    <div class="col-lg-12">
                                        @if ($best->courses->type == 1)
                                            @if (Auth::check())
                                                @if (Auth::user()->role == "admin" || (!empty($order) && $order->status == 1))
                                                    <div class="protip-btn">
                                                        <a href="{{ route('course.content',['slug' => $best->courses->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                                    </div>
                                                @else
                                                    @php
                                                    $cart = App\Cart::where('user_id', Auth::user()->id)->where('course_id', $best->courses->id)->first();
                                                    @endphp
                                                    <div class="protip-btn">
                                                        <form id="demo-form2" method="post" action="{{ $cart ? route('remove.item.cart',$cart->id) : route('addtocart',['course_id' => $best->courses->id, 'price' => $best->courses->price, 'discount_price' => $best->courses->discount_price ]) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}
                                                            @if (Auth::user()->role != "admin")
                                                                <input type="hidden" name="category_id" value="{{ $best->category['id'] ?? '-' }}" />
                                                            @endif
                                                            <div class="box-footer">
                                                                <button type="submit" class="btn btn-primary">{{ $cart ? __('Remove From Cart') : __('Add To Cart') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @endif
                                            @else
                                                @if ($gsetting->guest_enable == 1)
                                                    <form id="demo-form2" method="post" action="{{ route('guest.addtocart', $best->courses->id) }}" data-parsley-validate class="form-horizontal form-label-left">
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
                                            @if (Auth::check())
                                                @if (Auth::user()->role == "admin" || $enroll)
                                                    <div class="protip-btn">
                                                        <a href="{{ route('course.content',['slug' => $best->courses->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                                    </div>
                                                @else
                                                    <div class="protip-btn">
                                                        <a href="{{ url('enroll/show', $best->courses->id) }}" class="btn btn-primary" title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="protip-btn">
                                                    <a href="{{ route('login') }}" class="btn btn-primary" title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                                </div>
                                            @endif
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
</section>
@endif
<!-- Advertisement -->
@if(isset($advs))
@foreach($advs as $adv)
@if($adv->position == 'belowbundle')
<br>
<section id="student" class="student-main-block btm-40">
    <div class="container-xl">
        <a href="{{ $adv->url1 }}" title="{{ __('Click to visit') }}">
            <img class="lazy img-fluid advertisement-img-one" data-src="{{ url('images/advertisement/'.$adv->image1) }}"
                alt="{{ $adv->image1 }}">
        </a>
    </div>
</section>
@endif
@endforeach
@endif
<!-- Zoom start -->
@if($hsetting->livemeetings_enable == 1)
@if($gsetting->zoom_enable == '1' || $gsetting->bbl_enable == '1' || $gsetting->googlemeet_enable == '1' ||
$gsetting->jitsimeet_enable == '1')
<section id="student" class="student-main-block">
    <div class="container-xl">
        @php
        $mytime = Carbon\Carbon::now();
        @endphp
        @if( count($meetings) > 0 || count($bigblue) > 0 || count($allgooglemeet) > 0 || count($jitsimeeting) > 0 )
        <h4 class="student-heading">{{ __('Live Meetings') }}</h4>
        <div id="zoom-view-slider" class="student-view-slider-main-block owl-carousel">

            @if(!$meetings->isEmpty() )
            @foreach($meetings as $meeting)
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block-6{{$meeting->id}}">
                    <div class="view-block">
                        <div class="view-img">

                            @if($meeting['image'] !== NULL && $meeting['image'] !== '')
                            <a href="{{ route('zoom.detail', $meeting->id) }}" title="{{$meeting->meeting_title}}"><img data-src="{{ asset('images/zoom/'.$meeting['image']) }}" alt="course" class="img-fluid owl-lazy"></a>
                            @else
                            <a href="{{ route('zoom.detail', $meeting->id) }}" title="{{$meeting->meeting_title}}"><img data-src="{{ Avatar::create($meeting['meeting_title'])->toBase64() }}" alt="course" class="img-fluid owl-lazy"></a>
                            @endif


                        </div>
                        <div class="view-user-img">

                            @if(optional($meeting->user)['user_img'] !== NULL && optional($meeting->user)['user_img'] !== '')
                            <a href="{{ route('all/profile',$meeting->user->id) }}" title="{{$meeting->meeting_title}}"><img src="{{ asset('images/user_img/'.$meeting->user['user_img']) }}" class="img-fluid user-img-one" alt="{{$meeting->meeting_title}}"></a>
                            @else
                            <a href="{{ route('all/profile',$meeting->user->id) }}" title="{{$meeting->meeting_title}}"><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt="{{$meeting->meeting_title}}"></a>
                            @endif


                        </div>
                        @if(asset('images/meeting_icons/zoom.png') == !NULL)
                        <div class="meeting-icon"><img src="{{ asset('images/meeting_icons/zoom.png')}}" class="img-circle" alt="{{$meeting->meeting_title}}"></div>
                        @endif


                        <div class="view-dtl">
                            <div class="view-heading"><a href="{{ route('zoom.detail', $meeting->id) }}" title="{{$meeting->meeting_title}}">
                                    {{ str_limit($meeting->meeting_title, $limit = 30, $end = '...') }}</a></div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$meeting->user->id) }}"> {{ optional($meeting->user)['fname'] }}</a></span></h6>
                            </div>
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <i data-feather="calendar"></i>
                                                {{ date('d-m-Y',strtotime($meeting['start_time'])) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <i data-feather="clock"></i>
                                                {{ date('h:i:s A',strtotime($meeting['start_time'])) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="img-wishlist">
                                <div class="protip-wishlist">
                                    <ul>
                                        <li class="protip-wish-btn"><a href="https://calendar.google.com/calendar/r/eventedit?text={{ $discount['title'] }}" target="__blank" title="reminder"><i data-feather="bell"></i></a></li>

                                        @if(Auth::check())

                                        <li class="protip-wish-btn"><a class="compare" data-id="{{filter_var($discount->id)}}" title="compare"><i data-feather="bar-chart"></i></a></li>

                                        @php
                                        $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',
                                        $discount->id)->first();
                                        @endphp
                                        @if ($wish == NULL)
                                        <li class="protip-wish-btn">
                                            <form id="demo-form2" method="post" action="{{ url('show/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @else
                                        <li class="protip-wish-btn-two">
                                            <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />
                                                <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @endif
                                        @else
                                        <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="prime-next-item-description-block-6{{$meeting->id}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <h5 class="description-heading"><a href="{{ route('zoom.detail', $meeting->id) }}">{{ $meeting['meeting_title'] }}</a>
                            </h5>
                            <div class="protip-img">
                                <h6 class="user-name">{{ __('by') }}
                                    @if(isset($meeting->user)) {{ $meeting->user['fname'] }} @endif</h6>
                                <p class="meeting-owner btm-10"><a herf="#">Meeting Owner:
                                        {{ $meeting->owner_id }}</a></p>
                            </div>
                            <div class="main-des meeting-main-des">
                                <div class="main-des-head">Start At: </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <a href="#"><i data-feather="calendar"></i> {{ date('d-m-Y',strtotime($meeting['start_time'])) }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <a href="#"><i data-feather="clock"></i> {{ date('h:i:s A',strtotime($meeting['start_time'])) }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="des-btn-block">
                                @php
                                // Ensure $meeting->paid_meeting_price is a number
                                $paidMeetingPrice = (float) $meeting->paid_meeting_price;
                                $isPaid = App\PaidMettings::where('user_id', auth()->id())
                                            ->where('meeting_id', $meeting->id)
                                            ->where('amount', '>=', $paidMeetingPrice)
                                            ->exists();
                            @endphp
                            
                                @if($meeting->paid_meeting_price && !$isPaid)
                                    <p class="meeting-owner btm-10">
                                        {{ currency($meeting->paid_meeting_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}
                                    </p>
                                    <form action="{{ route('checkoutmeeting') }}" method="GET">
                                        <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
                                        <input type="hidden" name="type" value="zoom">
                                        <button type="submit" class="btn btn-primary">{{ __('Checkout') }}</button>
                                    </form> 
                                @else
                                    <a href="{{ $meeting->zoom_url }}" class="iframe btn btn-light">{{ __('Join Meeting') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif

             @if(!$bigblue->isEmpty() )
            @foreach($bigblue as $bbl)
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block-7{{$bbl->id}}">
                    <div class="view-block">
                        <div class="view-img">
                            <a href="{{ route('bbl.detail', $bbl->id) }}" ><img data-src="{{ Avatar::create($bbl['meetingname'])->toBase64() }}" alt="course" class="img-fluid owl-lazy"></a>
                        </div>
                        <div class="view-user-img">

                            @if(optional($bbl->user)['user_img'] !== NULL && optional($bbl->user)['user_img'] !== '')
                            <a href="{{ route('all/profile',$bbl->user->id) }}" title="{{ __('Course')}}"><img src="{{ asset('images/user_img/'.$bbl->user['user_img']) }}" class="img-fluid user-img-one" alt="{{ __('Course')}}"></a>
                            @else
                            <a href="{{ route('all/profile',$bbl->user->id) }}" title="{{ __('Course')}}"><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt="{{ __('Course')}}"></a>
                            @endif


                        </div>
                        @if(asset('images/meeting_icons/bigblue.png') == !NULL)
                        <div class="meeting-icon"><img src="{{ asset('images/meeting_icons/bigblue.png')}}" class="img-circle" alt="{{ __('bigblue')}}"></div>
                        @endif

                        <div class="view-dtl">
                            <div class="view-heading"><a href="{{ route('bbl.detail', $bbl->id) }}">{{ str_limit($bbl['meetingname'], $limit = 30, $end = '...') }}</a>
                            </div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$bbl->user->id) }}"> {{ optional($bbl->user)['fname'] }}</a></span></h6>
                            </div>
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <i data-feather="calendar"></i>
                                                {{ date('d-m-Y',strtotime($bbl['start_time'])) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <i data-feather="clock"></i>
                                                {{ date('h:i:s A',strtotime($bbl['start_time'])) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="img-wishlist">
                                <div class="protip-wishlist">
                                    <ul>

                                        <li class="protip-wish-btn"><a href="https://calendar.google.com/calendar/r/eventedit?text={{ $discount['title'] }}" target="__blank" title="reminder"><i data-feather="bell"></i></a></li>

                                        @if(Auth::check())

                                        <li class="protip-wish-btn"><a class="compare" data-id="{{filter_var($discount->id)}}" title="compare"><i data-feather="bar-chart"></i></a></li>

                                        @php
                                        $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',
                                        $discount->id)->first();
                                        @endphp
                                        @if ($wish == NULL)
                                        <li class="protip-wish-btn">
                                            <form id="demo-form2" method="post" action="{{ url('show/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @else
                                        <li class="protip-wish-btn-two">
                                            <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @endif
                                        @else
                                        <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="prime-next-item-description-block-7{{$bbl->id}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <h5 class="description-heading">{{ $bbl['meetingname'] }}</h5>
                            <div class="des-btn-bloc">

                                @php
                                // Ensure $meeting->paid_meeting_price is a number
                                $paidMeetingPrice = (float) $bbl->paid_meeting_price;
                            
                                $isPaid = App\PaidMettings::where('user_id', auth()->id())
                                            ->where('meeting_id', $bbl->id)
                                            ->where('amount', '>=', $paidMeetingPrice)
                                            ->exists();
                                @endphp
                                
                                

                                @if($bbl->paid_meeting_price && !$isPaid)
                                <p class="meeting-owner btm-10">{{ currency($bbl->paid_meeting_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}
                                </p>
                                <form action="{{ route('checkoutmeeting') }}" method="GET">
                                    <input type="hidden" name="meeting_id" value="{{ $bbl->id }}">
                                    <input type="hidden" name="type" value="bbl">
                                    <button type="submit" class="btn btn-primary">{{ __('Checkout') }}</button>
                                </form> 
                                @else
                                <a href="{{ route('bbl.detail', $bbl->id) }}"><img src="{{ Avatar::create($bbl['meetingname'])->toBase64() }}" alt="course" class="img-fluid"></a>
                                @endif
                            </div>

                            <div class="main-des">
                                <p>{!! $bbl['detail'] !!}</p>
                            </div>
                            <div class="des-btn-block">
                                <div class="row">
                                    <div class="col-lg-12">

                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            @endforeach
            @endif

           @if( isset($allgooglemeet) )
            @foreach($allgooglemeet as $meeting)
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block-6{{ $meeting['meeting_id'] }}">
                    <div class="view-block">
                        <div class="view-img">

                            @if($meeting['image'] !== NULL && $meeting['image'] !== '')
                            <a href="{{ route('googlemeetdetailpage.detail', $meeting['id']) }}"><img data-src="{{ asset('images/googlemeet/profile_image/'.$meeting['image']) }}" alt="course" class="img-fluid owl-lazy"></a>
                            @else
                            <a href="{{ route('googlemeetdetailpage.detail', $meeting['id']) }}"><img data-src="{{ Avatar::create($meeting['meeting_title'])->toBase64() }}" alt="course" class="img-fluid owl-lazy"></a>
                            @endif


                        </div>
                        <div class="view-user-img">

                            @if(optional($meeting->user)['user_img'] !== NULL && optional($meeting->user)['user_img'] !== '')
                            <a href="{{ route('all/profile',$meeting->user->id) }}" title="{{$meeting->meeting_title}}"><img src="{{ asset('images/user_img/'.$meeting->user['user_img']) }}" class="img-fluid user-img-one" alt="{{$meeting->meeting_title}}"></a>
                            @else
                            <a href="{{ route('all/profile',$meeting->user->id) }}" title="{{$meeting->meeting_title}}"><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt="{{$meeting->meeting_title}}"></a>
                            @endif


                        </div>
                        @if(asset('images/meeting_icons/google.png') == !NULL)
                        <div class="meeting-icon"><img src="{{ asset('images/meeting_icons/google.png')}}" class="img-circle" alt="{{ __('google image')}}"></div>
                        @endif

                        <div class="view-dtl">
                            <div class="view-heading"><a href="{{ route('googlemeetdetailpage.detail', $meeting['id']) }}">
                                    {{ str_limit($meeting->meeting_title, $limit = 30, $end = '...') }}</a></div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$meeting->user->id) }}"> {{ optional($meeting->user)['fname'] }}</a></span></h6>
                            </div>
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <i data-feather="calendar"></i>
                                                {{ date('d-m-Y',strtotime($meeting['start_time'])) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <i data-feather="clock"></i>
                                                {{ date('h:i:s A',strtotime($meeting['start_time'])) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="img-wishlist">
                                <div class="protip-wishlist">
                                    <ul>

                                        <li class="protip-wish-btn"><a href="https://calendar.google.com/calendar/r/eventedit?text={{ $discount['title'] }}" target="__blank" title="reminder"><i data-feather="bell"></i></a></li>

                                        @if(Auth::check())

                                        <li class="protip-wish-btn"><a class="compare" data-id="{{filter_var($discount->id)}}" title="compare"><i data-feather="bar-chart"></i></a></li>

                                        @php
                                        $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',
                                        $discount->id)->first();
                                        @endphp
                                        @if ($wish == NULL)
                                        <li class="protip-wish-btn">
                                            <form id="demo-form2" method="post" action="{{ url('show/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @else
                                        <li class="protip-wish-btn-two">
                                            <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @endif
                                        @else
                                        <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="prime-next-item-description-block-6{{$meeting['meeting_id']}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <h5 class="description-heading"><a href="{{ route('googlemeetdetailpage.detail', $meeting->id) }}">{{ $meeting['meeting_title'] }}</a>
                            </h5>
                            <div class="protip-img">
                                <h6 class="user-name">{{ __('by') }}
                                    @if(isset($meeting->user)) {{ $meeting->user['fname'] }} @endif</h6>
                                <p class="meeting-owner btm-10"><a herf="#">{{ __('Meeting Owner:') }}
                                        {{ $meeting->owner_id }}</a></p>
                            </div>
                            <div class="main-des meeting-main-des">
                                <div class="main-des-head">{{ __('Start At:') }} </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <a href="#"><i data-feather="calendar"></i> {{ date('d-m-Y',strtotime($meeting['start_time'])) }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <a href="#"><i data-feather="clock"></i> {{ date('h:i:s A',strtotime($meeting['start_time'])) }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="main-des meeting-main-des">
                                <div class="main-des-head">{{ __('End At: ') }}</div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <a href="#"><i data-feather="calendar"></i> {{ date('d-m-Y',strtotime($meeting['end_time'])) }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <a href="#"><i data-feather="clock"></i> {{ date('h:i:s A',strtotime($meeting['end_time'])) }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="des-btn-block">

                                @php
                                // Ensure $meeting->paid_meeting_price is a number
                                $paidMeetingPrice = (float) $meeting->paid_meeting_price;
                                $isPaid = App\PaidMettings::where('user_id', auth()->id())
                                            ->where('meeting_id', $meeting->id)
                                            ->where('amount', '>=', $paidMeetingPrice)
                                            ->exists();
                                @endphp
                                

                                @if($meeting->paid_meeting_price && !$isPaid)
                                <p class="meeting-owner btm-10">{{ currency($meeting->paid_meeting_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}
                                </p>
                                <form action="{{ route('checkoutmeeting') }}" method="GET">
                                    <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
                                    <input type="hidden" name="type" value="googlemeet">
                                    <button type="submit" class="btn btn-primary">{{ __('Checkout') }}</button>
                                </form> 
                                @else
                                <a href="{{ $meeting->meet_url }}" target="_blank" class="btn btn-light">
                                    {{ __(' Join Meeting') }}</a>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif

            @if(!$jitsimeeting->isEmpty() )
            @foreach($jitsimeeting as $meeting)
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block-6{{ $meeting['meeting_id'] }}">
                    <div class="view-block">
                        <div class="view-img">

                            @if($meeting['image'] !== NULL && $meeting['image'] !== '')
                            <a href="{{ route('jitsipage.detail', $meeting['id']) }}"><img data-src="{{ asset('images/jitsimeet/'.$meeting['image']) }}" alt="course" class="img-fluid owl-lazy"></a>
                            @else
                            <a href="{{ route('jitsipage.detail', $meeting['id']) }}"><img data-src="{{ Avatar::create($meeting['meeting_title'])->toBase64() }}" alt="course" class="img-fluid owl-lazy"></a>
                            @endif


                        </div>
                        <div class="view-user-img">

                            @if(optional($meeting->user)['user_img'] !== NULL && optional($meeting->user)['user_img'] !== '')
                            <a href="{{ route('all/profile',$meeting->user->id) }}" title="{{$meeting->meeting_title}}"><img src="{{ asset('images/user_img/'.$meeting->user['user_img']) }}" class="img-fluid user-img-one" alt="{{$meeting->meeting_title}}"></a>
                            @else
                            <a href="{{ route('all/profile',$meeting->user->id) }}" title="{{$meeting->meeting_title}}"><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt="{{$meeting->meeting_title}}"></a>
                            @endif


                        </div>
                        @if(asset('images/meeting_icons/jitsi.png') == !NULL)
                        <div class="meeting-icon"><img src="{{ asset('images/meeting_icons/jitsi.png')}}" class="img-circle" alt="{{ __('jitsi')}}"></div>
                        @endif

                        <div class="view-dtl">
                            <div class="view-heading"><a href="{{ route('jitsipage.detail', $meeting['id']) }}">
                                    {{ str_limit($meeting->meeting_title, $limit = 30, $end = '...') }}</a></div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$meeting->user->id) }}"> {{ optional($meeting->user)['fname'] }}</a></span></h6>
                            </div>
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <i data-feather="calendar"></i>
                                                {{ date('d-m-Y',strtotime($meeting['start_time'])) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <i data-feather="clock"></i>
                                                {{ date('h:i:s A',strtotime($meeting['start_time'])) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="img-wishlist">
                                <div class="protip-wishlist">
                                    <ul>
                                        <li class="protip-wish-btn"><a href="https://calendar.google.com/calendar/r/eventedit?text={{ $discount['title'] }}" target="__blank" title="reminder"><i data-feather="bell"></i></a></li>
                                        @if(Auth::check())
                                        <li class="protip-wish-btn"><a class="compare" data-id="{{filter_var($discount->id)}}" title="compare"><i data-feather="bar-chart"></i></a></li>
                                        @php
                                        $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',
                                        $discount->id)->first();
                                        @endphp
                                        @if ($wish == NULL)
                                        <li class="protip-wish-btn">
                                            <form id="demo-form2" method="post" action="{{ url('show/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @else
                                        <li class="protip-wish-btn-two">
                                            <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @endif
                                        @else
                                        <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="prime-next-item-description-block-6{{$meeting['meeting_id']}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <h5 class="description-heading"><a href="{{ route('zoom.detail', $meeting->id) }}">{{ $meeting['meeting_title'] }}</a>
                            </h5>
                            <div class="protip-img">
                                <h6 class="user-name">{{ __('by') }}
                                    @if(isset($meeting->user)) {{ $meeting->user['fname'] }} @endif</h6>
                                <p class="meeting-owner btm-10"><a herf="#">{{ __('Meeting Owner')}}:
                                        {{ $meeting->owner_id }}</a></p>
                            </div>
                            <div class="main-des meeting-main-des">
                                <div class="main-des-head">Start At: </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <a href="#"><i data-feather="calendar"></i> {{ date('d-m-Y',strtotime($meeting['start_time'])) }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <a href="#"><i data-feather="clock"></i> {{ date('h:i:s A',strtotime($meeting['start_time'])) }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="main-des meeting-main-des">
                                <div class="main-des-head">{{ __('End At')}}: </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <a href="#"><i data-feather="calendar"></i> {{ date('d-m-Y',strtotime($meeting['end_time'])) }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <a href="#"><i data-feather="clock"></i> {{ date('h:i:s A',strtotime($meeting['end_time'])) }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="des-btn-block">
                                @php
                                // Ensure $meeting->paid_meeting_price is a number
                                $paidMeetingPrice = (float) $meeting->paid_meeting_price;
                                $isPaid = App\PaidMettings::where('user_id', auth()->id())
                                            ->where('meeting_id', $meeting->id)
                                            ->where('amount', '>=', $paidMeetingPrice)
                                            ->exists();
                                @endphp
                                @if($meeting->paid_meeting_price && !$isPaid)
                                <p class="meeting-owner btm-10">{{ currency($meeting->paid_meeting_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}
                                </p>
                                <form action="{{ route('checkoutmeeting') }}" method="GET">
                                    <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
                                    <input type="hidden" name="type" value="jitsi">
                                    <button type="submit" class="btn btn-primary">{{ __('Checkout') }}</button>
                                </form> 
                                 @else
                                <a href="{{url('meetup-conferencing/'.$meeting->meeting_id) }}" target="_blank" class="btn btn-light">{{ __('Join Meeting')}}</a>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif 
        </div>
        @endif
    </div>
</section>
@endif
@endif
<!-- Zoom end -->
<!-- google class room start -->
@if(Schema::hasTable('googleclassrooms') && Module::has('Googleclassroom') &&
Module::find('Googleclassroom')->isEnabled())
@include('googleclassroom::frontend.home')
@endif
<!-- google class room end -->
@if($hsetting->batch_enable == 1 && ! $instruct->isEmpty() )
<section id="instructor-home-two" class="instructor-home-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-6 col-7">
                <h4 class="student-heading">{{ __('Featured Instructor') }}</h4>
            </div>
        </div>
        <div id="instructor-home-slider-two" class="instructor-home-main-slider owl-carousel">
            @foreach($instruct as $inst)
            <div class="item">
                <div class="instructor-home-block text-center">
                    <div class="instructor-home-block-one">
                        @php
                        $userImg = $inst->user->user_img;
                        $fullName = $inst->fname . ' ' . $inst->lname;
                        $followers = App\Followers::where('user_id', '!=', $inst->id)->where('follower_id', $inst->id)->count();
                        $followings = App\Followers::where('user_id', $inst->id)->where('follower_id','!=', $inst->id)->count();
                        $courseCount = App\Course::where('user_id', $inst->id)->count();
                        $url = URL::to('/').'/allinstructor/profile/'.$inst->id;
                        @endphp
        
                        <a href="{{ route('allinstructor/profile',$inst->id) }}" title="{{ $fullName }}">
                            <img src="{{ $userImg ? url('/images/user_img/'.$userImg) : Avatar::create($inst->user->fname)->toBase64() }}" class="img-fluid" alt="{{$inst->user->fname}}" />
                        </a>
        
                        <div class="instructor-home-hover-icon">
                            <ul>
                                <li>
                                    <div class="tooltip">
                                        <div class="tooltip-icon">
                                            <i data-feather="share-2"></i>
                                        </div>
                                        <span class="tooltiptext">
                                            <div class="instructor-home-social-icon">
                                                <ul>
                                                    <li><a href="http://www.linkedin.com/shareArticle?mini=true&url={{ $url }}&title=Default+share+text&summary=" target="_blank"><b><i class="fa fa-linkedin" aria-hidden="true"></i></b></a></li>
                                                    <li><a href="https://www.facebook.com/sharer/sharer.php?&url={{ $url }}" target="_blank"><b><i class="fa fa-facebook-square" aria-hidden="true"></i></b></a></li>
                                                    <li><a href="https://twitter.com/intent/tweet?text=Default+share+text&url={{ $url }}" target="_blank"><b><i class="fa fa-twitter" aria-hidden="true"></i></b></a></li>
                                                    <li><a href="https://telegram.me/share/url?url={{ $url }}&text=Default+share+text" target="_blank"><b><i class="fa fa-telegram" aria-hidden="true"></i></b></a></li>
                                                    <li><a href="https://wa.me/?text={{ $url }}" target="_blank"><b><i class="fa fa-whatsapp" aria-hidden="true"></i></b></a></li>
                                                </ul>
                                            </div>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div class="instructor-home-btn">
                                        <a href="{{ route('allinstructor/profile',$inst->id) }}" class="btn btn-primary" title="View Profile"><i data-feather="eye"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </div> 
        
                        <div class="instructor-home-dtl">
                            <h4 class="instructor-home-heading"><a href="#" title="{{ $fullName }}">{{ $fullName }}</a></h4>
                            <p>{{ $inst->role }}</p>
                            <div class="instructor-home-info">
                                <ul>
                                    <li>{{ $courseCount > 0 ? $courseCount.' '.__('Courses') : __('No Courses') }}</li>
                                    <li>{{ $followers }} {{ __('Follower') }}</li>
                                    <li>{{ $followings }} {{ __('Following') }}</li>
                                </ul>
                            </div>   
                        </div>
                    </div>
                </div>                
            </div>
            @endforeach
        </div>        
    </div>
</section>
@endif
<!-- Bundle start -->
@if($hsetting->blog_enable == 1 && ! $blogs->isEmpty() )
<section id="student" class="student-main-block">
    <div class="container-xl">
        <h4 class="student-heading">{{ __('Recent Blogs') }}</h4>
        <div id="blog-post-slider" class="student-view-slider-main-block owl-carousel">
            @foreach($blogs as $blog)
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif"
                    data-pt-placement="outside" data-pt-interactive="false"
                    data-pt-title="#prime-next-item-description-block-8{{$blog->id}}">
                    <div class="view-block">
                    <div class="view-img">
                        @php
                        $image = $blog['image'];
                        $slug = $blog->slug;
                        $headingSlug = str_slug(str_replace('-','&',$blog->heading));
                        $detailRoute = $slug != NULL ? route('blog.detail', ['slug' => $slug]) : route('blog.detail', ['slug' => $headingSlug]);
                        $imageSrc = $image ? asset('images/blog/'.$image) : Avatar::create($blog->heading)->toBase64();
                            @endphp
                            @php
                            $slug = $blog->slug ?? str_slug(str_replace('-', '&', $blog->heading));
                            $heading = str_limit($blog->heading, $limit = 25, $end = '...');
                            $route = route('blog.detail', ['slug' => $slug]);
                            @endphp
                            <a href="{{ $detailRoute }}" title="{{$heading}}">
                                <img data-src="{{ $imageSrc }}" alt="course" class="img-fluid owl-lazy">
                            </a>
                        </div>
                        <div class="view-user-img">
                            @php
                            $userImg = optional($blog->user)['user_img'];
                            $userId = optional($blog->user)->id;
                            $imgSrc = $userImg ? asset('images/user_img/'.$userImg) : asset('images/default/user.png');
                            @endphp
                            

                            <a href="{{ route('all/profile', $userId) }}" title="{{$heading}}">
                                <img src="{{ $imgSrc }}" class="img-fluid user-img-one" alt="{{$heading}}">
                            </a>
                        </div>
                            <div class="tooltip">
                                <div class="tooltip-icon">
                                    <i data-feather="share-2"></i>
                                </div>
                                <span class="tooltiptext">
                                    <div class="instructor-home-social-icon">
                                        <ul>
                                            @php
                                            $socialMedia = [
                                                'fb_url' => 'facebook',
                                                'twitter_url' => 'twitter',
                                                'youtube_url' => 'youtube',
                                                'linkedin_url' => 'linkedin'
                                            ];
                                            @endphp
                                            @foreach ($socialMedia as $url => $icon)
                                                @if ($blog->user->$url)
                                                    <li><a href="{{ $blog->user->$url }}"><i data-feather="{{ $icon }}"></i></a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </span>
                            </div>
                        <div class="view-dtl">
                            <div class="view-heading">
                            <a href="{{ $route }}" title="{{$heading}}">{{ $heading }}</a>
                        </div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile', optional($blog->user)->id) }}" title="{{$heading}}">{{ optional($blog->user)->fname }}</a></span></h6>
                            </div>
                           <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <a href="#"><i data-feather="calendar"></i> {{ $blog->created_at->format('d-m-Y') }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <a href="#"><i data-feather="clock"></i> {{ $blog->created_at->format('h:i:s A') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="prime-next-item-description-block-8{{$blog->id}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <h5 class="description-heading">{{ $blog['heading'] }}</h5>
                            <div class="row btm-20">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="view-date">
                                        <a href="#"><i data-feather="calendar"></i> {{ date('d-m-Y',strtotime($blog['start_time'])) }}</a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="view-time">
                                        <a href="#"><i data-feather="clock"></i> {{ date('h:i:s A',strtotime($blog['start_time'])) }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="main-des">
                                <p>{{substr(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($blog->detail))), 0, 400)}}
                                </p>
                            </div>
                            <div class="des-btn-block">
                                <div class="row">
                                    <div class="col-lg-12">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- Bundle end -->
<!-- recommendations start -->
@if($hsetting->became_enable == 1)
    <section id="border-recommendation" class="border-recommendation">
        @php
            $gets = App\JoinInstructor::first();
        @endphp
        @if(isset($gets))
        <div class="recommendation-main-block text-center">
            <div class="container-fluid p-0">
                <div class="row no-gutters">
                    <div class="col-lg-12 col-sm-12">
                        <div class="recommendations-main-slider">
                            <div class="recommendations-img">
                                <img src="{{ $gets['img'] ? url('/images/joininstructor/'.$gets->img) : Avatar::create($gets->text)->toBase64() }}" alt="{{$gets->text}}">
                            </div>
                            <div class="recommendations-block">
                                <h4 class="recommendations-heading">{{ $gets->text }}</h4>
                                <p>{{ $gets->detail }}</p>
                                <div class="recommendation-btn">
                                    <a href="" data-toggle="modal" data-target="#myModalinstructor" class="btn btn-primary" title="Become an Instructor">{{__('Become an Instructor')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </section>
@endif
<!-- recommendations end -->
<!-- categories start -->
@if($hsetting->featuredcategories_enable == 1 && !$category->isEmpty())
    <section id="categories" class="categories-main-block">
        <div class="container-xl">
            @if($category->where('featured', '1')->count() > 0)
                <h3 class="student-heading">{{ __('Featured Categories') }}</h3>
                <div class="row">
                    @foreach($category as $t)
                        @if($t->status == 1 && $t->featured == 1)
                            <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                                <div class="cat-container btm-20 text-center">
                                    <a href="{{ route('category.page',['slug' => $cat->slug]) }}">
                                        <div class="cat-img">
                                            <img src="{{ $t['cat_image'] ? asset('images/category/'.$t['cat_image']) : Avatar::create($t->title)->toBase64() }}" alt="{{$t->title}}">
                                        </div>
                                        <div class="cat-dtl">
                                            <div>
                                                <span>
                                                    <h5 class="cat-name"><i class="fa {{ $t['icon'] }} mr-2"></i>{{ $t['title'] }}</h5>
                                                    <div class="cat-img-count">{{ $t->courses->count() }} {{ __('Courses')}}</div>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endif
<!-- categories end -->
<!-- testimonial start -->
@if($hsetting->testimonial_enable == 1 && !$testi->isEmpty())
    <section id="testimonial" class="testimonial-main-block">
        <div class="container-xl">
            <h4 class="student-heading">{{ __('Testimonial') }}</h4>
            <div id="testimonial-slider" class="testimonial-slider-main-block owl-carousel">
                @foreach($testi as $tes)
                    <div class="item testi-block text-center">
                        <div class="testi-block-images">
                            <img src="{{ url('images/testimonial/testimonial.png') }}" class="img-fluid" alt="{{ __('testimonial')}}"> 
                        </div>
                        <div class="testi-block-one">
                            <div class="testi-img text-center">
                                <img data-src="{{ $tes['image'] ? asset('images/testimonial/'.$tes['image']) : '' }}" alt="blog" class="img-fluid owl-lazy">
                            </div>
                            <div class="testi-dtl text-center">
                                <div class="testi-name">
                                    <h5 class="testi-heading mb-1">{{ $tes['client_name'] }}</h5>
                                    <p class="testi-para p-0">{{ $tes['designation'] }}</p>
                                </div>
                                <div class="testi-rating mb-2">
                            @for($i = 1; $i <= 5; $i++) @if($i<=$tes->rating)
                                <i class='fa fa-star' style='color:orange'></i>
                                @else
                                <i class='fa fa-star' style='color:#ccc'></i>
                                @endif
                            @endfor
                        </div>
                                <p>{{ str_limit(strip_tags(html_entity_decode($tes->details)), $limit = 300, $end = '...') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
@if($hsetting->service_enable == 1 && !$services->isEmpty() && isset($servicesetting))
    <section id="services" class="services-main-block">
        <div class="container-xl">
            <h4 class="student-heading">{{ __('Our Service') }}</h4>
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="service-side-img">
                        <img src="{{ $servicesetting['image'] ? asset('images/services/'.$servicesetting['image']) : Avatar::create($servicesetting->title)->toBase64() }}" class="img-fluid" alt="{{$servicesetting->title}}">
                        <div class="overlay-bg"></div>
                    </div>
                    <div class="service-side-dtl text-center">
                        <h3 class="service-heading mb-4">{{ $servicesetting->title }}</h3>
                        <p class="mb-4">{{ str_limit(strip_tags(html_entity_decode($servicesetting->detail)), $limit = 300, $end = '...') }}</p>
                        <a href="{{ route('front.service') }}" type="button" class="btn btn-primary mt-2" title="View More">{{ __('View More') }} <i data-feather="chevrons-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8">
                    <div class="row">
                        @foreach($services as $ser)
                            <div class="col-lg-4 col-md-6">
                                <div class="service-block">
                                    <div class="service-img text-center">
                                        <img src="{{ $ser['image'] ? asset('images/service/'.$ser['image']) : Avatar::create($ser->title)->toBase64() }}" class="img-fluid" alt="{{$ser->title}}">
                                    </div>
                                    <div class="service-dtl text-center">
                                        <h5 class="service-heading">{{ $ser->title }}</h5>
                                        <p>{{ str_limit(strip_tags(html_entity_decode($ser->detail)), $limit = 80, $end = '...') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach 
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
<!-- testimonial end -->
<!-- video start -->
@if($hsetting->video_enable == 1 && isset($videosetting))
    <section id="video" class="video-main-block">
        <div class="video-block parallax" style="background-image: url('{{ $videosetting->image ? asset('images/videosetting/' . $videosetting->image) : Avatar::create($videosetting->tittle)->toBase64() }}');">
            <div class="overlay-bg"></div>
        </div>
        <div class="video-play-btn">
            <a class="play-btn" href="#video_modal" data-toggle="modal"></a>
            <div id="video_modal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe id="elearningVideo" class="embed-responsive-item" width="560" height="315" src="{{$videosetting->url}}" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="video-dtl text-center">
            <h3 class="video-heading text-white">{{ $videosetting->tittle }}</h3>
            <p class="text-white">{{ $videosetting->description }}</p>
        </div>
    </section>  
@endif
<!-- video end -->  
<!-- instructor start -->
@if($hsetting->instructor_enable == 1 && !$instructors->isEmpty())
<section id="instructor-home" class="instructor-home-main-block">
    <div class="container-xl">
        <h4 class="student-heading">{{ __('Instructor') }}</h4>
        <div class="view-button">
            <a href="{{ route('allinstructor/view') }}" class="btn btn-secondary" title="All Instructor">{{ __('All Instructor') }}<i data-feather="chevrons-right"></i>
            </a>
        </div>        
        <div id="instructor-home-slider" class="instructor-home-main-slider owl-carousel">
            @foreach($instructors as $inst)
             <div class="item">
                <div class="instructor-home-block text-center">
                    <div class="instructor-home-block-one">
                        <a href="{{ route('allinstructor/profile',$inst->id) }}" title="{{ $inst->fname }}">
                            @if($inst['user_img'] !== NULL && $inst['user_img'] !== '')
                                <img src="{{ url('/images/user_img/'.$inst['user_img']) }}" alt="course" class="img-fluid">
                            @else
                                <img src="{{ Avatar::create($inst->fname)->toBase64() }}" alt="course" class="img-fluid">
                            @endif
                        </a>
                        <div class="instructor-home-hover-icon">
                            <ul>
                                <li>
                                    <div class="tooltip">
                                        <div class="tooltip-icon">
                                            <i data-feather="share-2"></i>
                                        </div>
                                        <span class="tooltiptext">
                                            <div class="instructor-home-social-icon">
                                                <ul>
                                                    @php
                                                        $url = URL::to('/').'/allinstructor/profile/'.$inst->id;
                                                    @endphp
                                                    <li><a href="http://www.linkedin.com/shareArticle?mini=true&url={{ $url }}&title=Default+share+text&summary=" target="_blank"><b><i class="fa fa-linkedin" aria-hidden="true"></i></b></a></li>
                                                    <li><a href="https://www.facebook.com/sharer/sharer.php?&url={{ $url }}" target="_blank"><b><i class="fa fa-facebook-square" aria-hidden="true"></i></b></a></li>
                                                    <li><a href="https://twitter.com/intent/tweet?text=Default+share+text&url={{ $url }}" target="_blank"><b><i class="fa fa-twitter" aria-hidden="true"></i></b></a></li>
                                                    <li><a href="https://telegram.me/share/url?url={{ $url }}&text=Default+share+text" target="_blank"><b><i class="fa fa-telegram" aria-hidden="true"></i></b></a></li>
                                                    <li><a href="https://wa.me/?text={{ $url }}" target="_blank"><b><i class="fa fa-whatsapp" aria-hidden="true"></i></b></a></li>
                                                </ul>
                                            </div>
                                        </span>
                                    </div>
                                </li> 
                            </ul>
                        </div>  
                        <div class="instructor-home-dtl">
                            <h4 class="instructor-home-heading">
                                <a href="{{ route('allinstructor/profile',$inst->id) }}" title="{{ $inst->fname }}">{{ $inst->fname }} {{ $inst->lname }}</a>
                            </h4>
                            <p>{{ $inst->role }}</p>
                            @php
                                $followers = App\Followers::where('user_id', '!=', $inst->id)->where('follower_id', $inst->id)->count();
                                $followings = App\Followers::where('user_id', $inst->id)->where('follower_id','!=', $inst->id)->count();
                                $course = App\Course::where('user_id', $inst->id)->count();
                            @endphp
                            <div class="instructor-home-info">
                                <ul>
                                    <li>{{ $course > 0 ? $course.' '.__('Courses') : __('No Courses') }}</li>
                                    <li>{{ $followers }} {{ __('Follower') }}</li>
                                    <li>{{ $followings }} {{ __('Following') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            @endforeach

        </div>
    </div>
</section>
@endif
@if($hsetting->get_enable == 1 && isset($get_enable))
<section id="get-started" class="get-started-main-block">
    <div class="get-started-block">
        @if($get_enable['image'] !== NULL && $get_enable['image'] !== '')
        <div class="get-started-bg-image parallax" style="background-image: url({{ 'images/getstarted/'.$get_enable->image }});">
        @else
        <div class="get-started-bg-image parallax" style="background-image: url({{ Avatar::create($get_enable->heading)->toBase64() }});">
        @endif 
            <div class="overlay-bg"></div>
        </div>
        <div class="get-started-dtl text-center">
            <h1 class="get-started-title text-white text-center">{{ $get_enable->heading }}</h1>
            <h4 class="get-started-sub-title text-white text-center">{{ $get_enable->sub_heading }}</h4>
            <a href="{{ $get_enable->link }}" type="button" class="btn btn-primary">{{ $get_enable->button_txt }}</a>
        </div>
    </div>
</section>
@endif
@if($hsetting->institute_enable == 1 && !$institute->isEmpty())
<section id="instructor-home" class="instructor-home-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-7">
                <h4 class="student-heading">{{ __('Institute') }}</h4>
            </div>
            <div class="col-lg-6 col-md-6 col-5">
                <div class="instructor-button txt-rgt">
                    {{-- <a href="{{ route('allinstructor/view') }}" class="btn btn-secondary" title="All Instructor">All Institute<i data-feather="chevron-right"></i> --}}
                    {{-- </a> --}}
                </div>
            </div>
        </div>
        <div id="institute-home-slider" class="instructor-home-main-slider owl-carousel">
            @foreach($institute as $inst)
            <div class="item">
                <div class="instructor-home-block text-center">
                    <div class="instructor-home-block-one">
                        <a href="{{ route('ins.sluging', ['slug' => $inst->slug]) }}" title="{{ $inst->fname }}">
                            <img src="{{ $inst['image'] ? url('/files/institute/'.$inst->image) : Avatar::create($inst->fname)->toBase64() }}" class="img-fluid" alt="course">
                        </a>
                        <div class="instructor-home-dtl">
                            <h4 class="instructor-home-heading"><a href="{{ route('ins.sluging', ['slug' => $inst->slug]) }}" title="{{ $inst->fname }}">{{ $inst->title }}</a></h4>
                            <p>{{ $inst->email }}</p>
                            <p>{{ $inst->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>        
    </div>
</section>
@endif
<!-- instructor end -->
@if($hsetting->feature_enable == 1 && !$feature->isEmpty() && isset($featuresetting))
<section id="feature" class="feature-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-7 col-md-7">
                <div class="feature-block">
                    <h4 class="student-heading">{{ $featuresetting->title }}</h4>
                    <p>{{ $featuresetting->detail }}</p>
                </div>
                <div class="feature-dtl-block">
                    <div class="row">
                        @foreach($feature as $data)
                        <div class="col-lg-6 col-md-6 mb-4">
                            <div class="feature-dtl-icon">
                                <img src="{{ $data['image'] ? asset('images/feature/'.$data['image']) : Avatar::create($data->title)->toBase64() }}" class="img-fluid" alt="{{$data->title}}">
                            </div>
                            <div class="feature-dtl">
                                <h5 class="feature-dtl-title mb-2">{{ $data->title }}</h5>
                                <p>{{ str_limit(strip_tags(html_entity_decode($data->detail)), $limit = 300, $end = '...') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ route('front.feature') }}" type="button" class="btn btn-primary" title="View More">{{ __('View More') }} <i data-feather="chevrons-right"></i></a>
                </div>
            </div>
            <div class="col-lg-5 col-md-5">
                <div class="feature-image">
                    <img src="{{ $featuresetting['image'] ? asset('images/feature/'.$featuresetting['image']) : Avatar::create($featuresetting->title)->toBase64() }}" class="img-fluid" alt="{{$featuresetting->title}}">
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- Advertisement -->
@if(isset($advs))
@foreach($advs as $adv)
@if($adv->position == 'belowtestimonial')
<br>
<section id="student" class="student-main-block btm-40">
    <div class="container-xl">
        <a href="{{ $adv->url1 }}" title="{{ __('Click to visit') }}">
            <img class="lazy img-fluid advertisement-img-one" data-src="{{ url('images/advertisement/'.$adv->image1) }}"
                alt="{{ $adv->image1 }}">
        </a>
    </div>
</section>
@endif
@endforeach
@endif
@if($hsetting->trusted_enable == 1 && ! $trusted->isEmpty() )
<section id="trusted" class="trusted-main-block">
    <div class="container-xl">
        <div class="patners-block">
            <h6 class="patners-heading btm-40">{{ __('Trusted By Companies') }}</h6>
            <div id="patners-slider" class="patners-slider owl-carousel">
                @foreach($trusted as $trust)
                <div class="item-patners-img">
                    <a href="{{ $trust['url'] }}" target="_blank">
                        <img data-src="{{ asset('images/trusted/'.$trust['image']) }}" class="img-fluid owl-lazy" alt="patners-1">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
<section id="trusted" class="trusted-main-block">
    <!-- google adsense code -->
    <div class="container-fluid" id="adsense">
        @php
        $ad = App\Adsense::where('ishome', 1)->where('status', 1)->first();
        @endphp
        @if(isset($ad))
            {!! html_entity_decode($ad->code) !!}
        @endif
    </div>
</section>
@endsection
@section('custom-script')
<script>
    $('.counter').each(function() {
        var $this = $(this),
            countTo = $this.attr('data-count');        
        $({ countNum: $this.text()}).animate({
            countNum: countTo
        },
        {
            duration: 8000,
            easing:'linear',
            step: function() {
            $this.text(Math.floor(this.countNum));
            },
            complete: function() {
            $this.text(this.countNum);
            //alert('finished');
            }

        }); 
    });
</script>
<script>
    (function ($) {
        "use strict";
        $(function () {
            $("#home-tab").trigger("click");
        });
    })(jQuery);
    function showtab(id) {
        $.ajax({
            type: 'GET',
            url:'{{ url('/tabcontent') }}/' + id,
            dataType: 'json',
            success: function (data) {
                $('.btn_more').html(data.btn_view);
                $('#tabShow').html(data.tabview);
            }
        });
    }
    $(document).ready(function () {
        "use Strict";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.compare').on('click', function (e) {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                dataType: "json",
                url: 'compare/dataput',
                data: { id: id },
                success: function (data) {}
            });
        });
    });
    $(document).ready(function () {
        var url = $("#elearningVideo").attr('src');
        $("#video_modal").on('hide.bs.modal', function () {
            $("#elearningVideo").attr('src', '');
        });
        $("#video_modaal").on('show.bs.modal', function () {
            $("#elearningVideo").attr('src', url);
        });
    });
</script>
<script src="{{ url('js/colorbox-script.js')}}"></script>
@endsection