@extends('theme2.master')
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
@endsection
<!-- categories-tab start-->
<!-- slider-area -->
@if(isset($sliders))
<section id="home" class="slider-area fix p-relative">
    <div class="slider-active" style="background: #141b22;">
    @foreach($sliders as $slider)
    @if($slider->status == 1)
        <div class="single-slider slider-bg" style="background-image: url('{{ asset('images/slider/'.$slider['image']) }}'); background-size: cover;">
            <div class="container">
               <div class="row">
                  <div class="col-lg-7 col-md-7">
                        <div class="slider-content s-slider-content mt-130">
                            <h5 data-animation="fadeInUp" data-delay=".4s">{{ $slider['heading'] }}</h5>
                            <h1 data-animation="fadeInUp" class="slider-main-heading" data-delay=".2s">{{ $slider['sub_heading'] }}</h1>
                            <p data-animation="fadeInUp" data-delay=".6s">{{ $slider['detail'] }}</p>
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
    </div>
</section>
@endif
<!-- slider-area-end -->
<!-- service-area -->
@if(isset($facts))
<section class="service-details-two p-relative">
    <div class="container">
        <div class="row">
            @foreach($facts as $fact)
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class="services-box07">
                    
                    <div class="sr-contner">
                    <div class="icon">
                        <i class="fa {{ $fact['icon'] }}"></i>                       
                        </div>
                    <div class="text">
                        <h5>{{ $fact['heading'] }}</h5>
                        <p>{{ $fact['sub_heading'] }}</p>
                    </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- service-details2-area-end -->
<!-- facts-area -->
@if($hsetting->fact_enable == 1 && isset($factsetting))
    <section id="facts" class="fact-main-block pt-120 pb-120 p-relative fix">
        <div class="container">
            <div class="row">
                @foreach($factsetting as $factset)
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="facts-block hover-zoomin text-center">
                            <div class="facts-block-one">
                                <div class="facts-block-img">
                                    @php
                                    $image = $factset['image'] !== NULL && $factset['image'] !== '' ? url('/images/facts/'.$factset->image) : Avatar::create($factset->title)->toBase64();
                                    @endphp
                                    <img src="{{ $image }}" class="img-fluid" alt="{{ $factset->number }}" />
                                    <div class="facts-count">{{ $factset->number }}</div>
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
<!-- facts-area-end -->
<!-- about-area -->
@if($hsetting->feature_enable == 1 && ! $feature->isEmpty() && isset($featuresetting) )
<section class="about-area about-p pt-120 pb-120 p-relative fix">
    <div class="animations-02">
        <img src="{{url('frontcss/img/bg/an-img-02.png')}}" alt="contact-bg-an-01">
    </div>
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="s-about-img p-relative  wow fadeInLeft animated" data-animation="fadeInLeft" data-delay=".4s">
                    @if($featuresetting['image'] == !NULL)
                    <img src="{{ asset('images/feature/'.$featuresetting['image']) }}" alt="{{ $featuresetting->title }}">
                    @else
                    <img src="{{ asset('images/feature/'.$featuresetting['image']) }}" alt="{{ $featuresetting->title }}">
                    <img src="{{ Avatar::create($featuresetting->title)->toBase64() }}" alt="{{ $featuresetting->title }}"> 
                    @endif  
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="about-content s-about-content pl-15 wow fadeInRight  animated" data-animation="fadeInRight" data-delay=".4s">
                    <div class="about-title second-title pb-25">  
                            <h5><i class="fal fa-graduation-cap"></i> {{__('About Our University')}}</h5>
                            <h2>{{ $featuresetting->title }}</h2>                                   
                    </div>
                    <p class="txt-clr">{{  $featuresetting->detail }}</p>
                    <div class="about-content2">
                    
                        <div class="row">
                        
                            <div class="col-md-12">
                                <ul class="green2">       
                                @foreach($feature as $key=>$data)                                       
                                    <li><div class="abcontent"><div class="ano"><span>{{ $key+1 }}</span></div> <div class="text"><h3>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($data->title))) , $limit = 15, $end = '...') }}</h3> <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($data->detail))) , $limit = 50, $end = '...') }}</p></div></div></li>
                                    @endforeach
                                </ul>
                            </div>
                            
                        </div>
                    
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- about-area-end -->
<!-- recent courses-area -->
@if(Auth::check())
@if($hsetting->recentcourse_enable  == 1 && isset($categories))
<section id="learning-courses" class="learning-courses-main-block pt-120 pb-120 p-relative fix">
    <div class="animations-01"><img src="{{url('frontcss/img/bg/an-img-03.png')}}" alt="an-img-01"></div>
    <div class="container-xl">
        <div class="row">   
            <div class="col-lg-6 p-relative">
                <div class="section-title center-align mb-50 wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                        <h5><i class="fal fa-graduation-cap"></i> {{__('Recent Courses')}}</h5>
                    <h2>
                        {{__('Recent Courses')}}
                    </h2>                             
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="learning-courses">
                    @if(isset($categories))
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @foreach($categories as $cats)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="photography-tab" data-bs-toggle="tab" href="#photography" onclick="showtab('{{ $cats->id }}')" data-bs-target="#photography" type="button" role="tab" aria-controls="photography" aria-selected="true">{{ $cats['title'] }}</a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                <div class="tab-content" id="myTabContent"> 
                    @if(!empty($categories))               
                    @foreach($categories as $cate)
                    <div class="tab-pane fade show active" id="photography" role="tabpanel" aria-labelledby="photography-tab">
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
@endif
<!-- recent courses-area-end -->
<!-- courses-area -->
@if(!$cors->isEmpty())
<section class="courses pt-120 pb-60 p-relative fix">
    <div class="animations-01"><img src="{{url('frontcss/img/bg/an-img-03.png')}}" alt="an-img-01')}}"></div>
    <div class="container">
        <div class="row">   
            <div class="col-lg-12 p-relative">
                <div class="section-title center-align mb-50 wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                        <h5><i class="fal fa-graduation-cap"></i> {{__('Our Courses')}}</h5>
                    <h2>
                        {{__('Our Courses')}}
                    </h2>                             
                </div>
            </div>
        </div>
        <div class="row class-active">  
            @foreach($cors as $c)
            @if($c->status == 1 && $c->featured == 1)   
                <div class="col-lg-4 col-md-4">
                <div class="courses-item mb-30 hover-zoomin @if($gsetting['course_hover'] == 1) protip @endif">
                
                    <div class="thumb fix ">
                        @if($c['preview_image'] !== NULL && $c['preview_image'] !== '0')
                        <a href="{{ route('user.course.show',['slug' => $c->slug ]) }}"><img src="{{ asset('images/course/'.$c['preview_image']) }}" alt="contact-bg-an-01"></a>
                        @else
                        <a href="{{ route('user.course.show',['slug' => $c->slug ]) }}"><img src="{{ Avatar::create($c->title)->toBase64() }}" alt="contact-bg-an-01"></a>
                        @endif
                            
                        <div class="courses-icon">
                            <ul>
                                <li class="protip-wish-btn"><a
                                        href="https://calendar.google.com/calendar/r/eventedit?text={{ $c['title'] }}"
                                        target="__blank" title="reminder"><i data-feather="bell"></i></a></li>

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
                    @if(isset($c->user->id))
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
                    @endif
                    <div class="icon">
                        <img src="{{ url('frontcss/img/icon/cou-icon.png') }}" alt="img">
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- courses-area-end -->
@if (isset($subscriptionBundles) && !$subscriptionBundles->isEmpty())
<section class="courses pt-60 pb-60 p-relative fix">
    <div class="animations-01"><img src="{{url('frontcss/img/bg/an-img-03.png')}}" alt="an-img-01')}}"></div>
    <div class="container">
        <div class="row">   
            <div class="col-lg-12 p-relative">
                <div class="section-title center-align mb-50 wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                        <h5><i class="fal fa-graduation-cap"></i> {{__('Subscription Bundles')}}</h5>
                    <h2>
                        {{__('Subscription Bundles')}}
                    </h2>                             
                </div>
            </div>
        </div>
        <div class="row class-active">  
            @foreach ($subscriptionBundles as $bundle)
            @if ($bundle->status == 1 && $bundle->is_subscription_enabled == 1)  
                <div class="col-lg-4 col-md-4">
                <div class="courses-item mb-30 hover-zoomin @if($gsetting['course_hover'] == 1) protip @endif">
                
                    <div class="thumb fix ">
                        @if($bundle['preview_image'] !== NULL && $bundle['preview_image'] !== '0')
                        <a href="{{ route('bundle.detail', $bundle->slug) }}"><img src="{{ asset('images/bundle/' . ($bundle['preview_image'] ?? Avatar::create($bundle->title)->toBase64())) }}" alt="contact-bg-an-01"></a>
                        @else
                        <a href="{{ route('bundle.detail', $bundle->slug) }}"><img src="{{ Avatar::create($bundle->title)->toBase64() }}" alt="contact-bg-an-01"></a>
                        @endif
                       
                    </div>
                    @if(isset($bundle->discount_price))
                    <div class="badges bg-priamry offer-badge"><span>{{ __('OFF') }}<span><?php echo round((($bundle->price - $bundle->discount_price) * 100) / $bundle->price) . '%'; ?></span></span></div>
                    @endif
                    <div class="courses-content">    
                        <div class="view-user-img">
                            <a href="{{ route('all/profile', $bundle->user->id) }}" title="{{ $bundle['title'] }}">
                                <img src="{{ asset('images/user_img/' . ($bundle->user['user_img'] ?? 'default/user.png')) }}"
                                    class="img-fluid user-img-one" alt="{{ $bundle['title'] }}">
                            </a>
                        </div>                              
                        <div class="cat">
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
                        <h3><a href="{{ route('bundle.detail', $bundle->slug) }}"> {{ $bundle['title'] }}</a></h3>
                        <p>{{ str_limit($bundle['short_detail'] ?? $bundle['detail'], $limit = 200, $end = '...') }}</p>
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
</section>
@endif
<!-- courses-area -->
@if($hsetting->discount_enable   == 1 && isset($discountcourse) && count($discountcourse) >0)
<section class="courses pt-60 pb-60 p-relative fix">
    <div class="animations-01"><img src="{{url('frontcss/img/bg/an-img-03.png')}}" alt="an-img-01')}}"></div>
    <div class="container">
        <div class="row">   
            <div class="col-lg-12 p-relative">
                <div class="section-title center-align mb-50 wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                        <h5><i class="fal fa-graduation-cap"></i> {{__('Top Disconted Courses')}}</h5>
                    <h2>
                        {{__('Top Disconted Courses')}}
                    </h2>                             
                </div>
            </div>
        </div>
        <div class="row class-active">  
            @foreach($discountcourse as $discount)
            @if($discount->status == 1 && $discount->featured == 1)
            <div class="col-lg-4 col-md-4">
                <div class="courses-item mb-30 hover-zoomin @if($gsetting['course_hover'] == 1) protip @endif">
                
                    <div class="thumb fix ">
                        @if($discount['preview_image'] !== NULL && $discount['preview_image'] !== '0')
                        <a href="{{ route('user.course.show',['slug' => $discount->slug ]) }}"><img src="{{ asset('images/course/'.$discount['preview_image']) }}" alt="{{$discount->title}}"></a>
                        @else
                        <a href="{{ route('user.course.show',['slug' => $discount->slug ]) }}"><img src="{{ Avatar::create($discount->title)->toBase64() }}" alt="{{$discount->title}}"></a>
                        @endif
                            
                        <div class="courses-icon">
                            <ul>
                                <li class="protip-wish-btn"><a
                                        href="https://calendar.google.com/calendar/r/eventedit?text={{ $discount['title'] }}"
                                        target="__blank" title="reminder"><i data-feather="bell"></i></a></li>

                                        @if (Auth::check())
                                        <li class="protip-wish-btn">
                                            <a class="compare" data-id="{{ filter_var($discount->id) }}" title="compare">
                                                <i data-feather="bar-chart"></i>
                                            </a>
                                        </li>
                                 

                                @php
                                $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',
                                $discount->id)->first();
                                @endphp
                                @if ($wish == NULL)
                                <li class="protip-wish-btn">
                                    <form id="demo-form2" method="post"
                                        action="{{ url('show/wishlist', $discount->id) }}" data-parsley-validate
                                        class="form-horizontal form-label-left">
                                        {{ csrf_field() }}

                                        <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                        <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                        <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i
                                                data-feather="heart"></i></button>
                                    </form>
                                </li>
                                @else
                                <li class="protip-wish-btn-two heart-fill">
                                    <form id="demo-form2" method="post"
                                        action="{{ url('remove/wishlist', $discount->id) }}" data-parsley-validate
                                        class="form-horizontal form-label-left">
                                        {{ csrf_field() }}

                                        <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                        <input type="hidden" name="course_id" value="{{$discount->id}}" />

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
                    <div class="courses-content">    
                        <div class="view-user-img">
                            <a href="{{route('all/profile',$discount->user->id)}}" title="{{$discount->title}}">
                                @if($discount->user['user_img'] !== NULL && $discount->user['user_img'] !== '')
                                <img src="{{ asset('images/user_img/'.$discount->user['user_img']) }}" class="img-fluid user-img-one" alt="{{$discount->title}}">
                                @else
                                <img src="{{ Avatar::create($discount->title)->toBase64() }}" alt="{{$discount->title}}">
                                @endif
                            </a>
                                                     
                        </div>                                
                        <div class="cat">
                            <div class="rate text-right">
                                <ul>
                                    @if($discount->type == 1)
                                                    @if($discount->discount_price != NULL)
                                                        <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($discount['discount_price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }} {{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
                                                        <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($discount['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</strike></b></a></li>
                                                    @elseif($discount->price != NULL)
                                                        <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($discount['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
                                                    @endif
                                                @else
                                                    <li><a><b>{{ __('Free') }}</b></a></li>
                                                @endif
                                </ul>
                            </div>
                        </div>
                        <h3><a href="{{ route('user.course.show',['slug' => $discount->slug ]) }}"> {{$discount->category['title'] ?? '-'}}</a></h3>
                            <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($discount->detail))) , $limit = 70, $end = '...') }}
                        <a href="{{ route('user.course.show',['slug' => $discount->slug ]) }}" class="readmore">{{__('Read More ')}}<i class="fal fa-long-arrow-right"></i></a>
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
</section>
@endif
<!-- courses-area-end -->

<!-- courses-area -->
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
<section class="courses pt-60 pb-60 p-relative fix">
    <div class="animations-01"><img src="{{url('frontcss/img/bg/an-img-03.png')}}" alt="an-img-01')}}"></div>
    <div class="container">
        @if(count($enroll) > 0)
        <div class="row">   
            <div class="col-lg-12 p-relative">
                <div class="section-title center-align mb-50 wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                        <h5><i class="fal fa-graduation-cap"></i> {{__('My Purchased Course')}}</h5>
                    <h2>
                        {{__('My Purchased Course')}}
                    </h2>                             
                </div>
            </div>
        </div>
        <div class="row">  
            @foreach($enroll as $enrol)
            @if(isset($enrol->courses) && $enrol->courses['status'] == 1 )
                <div class="col-lg-4 col-md-6">
                <div class="courses-item mb-30 ms-0 me-0 hover-zoomin @if($gsetting['course_hover'] == 1) protip @endif">
                
                    <div class="thumb fix ">
                        @if($enrol->courses['preview_image'] !== NULL && $enrol->courses['preview_image'] !== '0')
                        <a href="{{ route('user.course.show',['slug' => $enrol->courses->slug ]) }}"><img src="{{ asset('images/course/'.$enrol->courses['preview_image']) }}" alt="contact-bg-an-01"></a>
                        @else
                        <a href="{{ route('user.course.show',['slug' => $enrol->courses->slug ]) }}"><img src="{{ Avatar::create($enrol->courses->title)->toBase64() }}" alt="contact-bg-an-01"></a>
                        @endif
                          
                    </div>
                    @if(isset($enrol->courses->discount_price))
                    <div class="badges bg-priamry offer-badge"><span>{{__('OFF')}}<span><?php echo round((($enrol->courses->price - $enrol->courses->discount_price) * 100) / $enrol->courses->price) . '%'; ?></span></span></div>
                    @endif
                    <div class="courses-content">    
                        <div class="view-user-img">
                            <a href="{{ route('all/profile',$enrol->user->id) }}" title="{{ optional($enrol->user)['fname'] }}">
                                @if($c->user['user_img'] !== NULL && $c->user['user_img'] !== '')
                                <img src="{{ asset('images/user_img/'.$c->user['user_img']) }}" class="img-fluid user-img-one" alt="{{$enrol->user->title}}">
                                @else
                                <img src="{{ Avatar::create($enrol->user->title)->toBase64() }}" alt="img">
                                @endif
                            </a>
                                                     
                        </div>                                
                        <div class="cat">
                            <div class="rate text-right">
                                <ul>
                                    @if($enrol->courses->type == 1)
                                                    @if($enrol->courses->discount_price != NULL)
                                                        <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($enrol->courses['discount_price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }} {{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
                                                        <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($enrol->courses['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</strike></b></a></li>
                                                    @elseif($c->price != NULL)
                                                        <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($enrol->courses['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
                                                    @endif
                                                @else
                                                    <li><a><b>{{ __('Free') }}</b></a></li>
                                                @endif
                                </ul>
                            </div>
                        </div>
                        <h3><a href="{{ route('user.course.show',['slug' => $enrol->courses->slug ]) }}"> {{$c->category['title'] ?? '-'}}</a></h3>
                            <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($enrol->courses->detail))) , $limit = 70, $end = '...') }}
                        <a href="{{ route('user.course.show',['slug' => $enrol->courses->slug ]) }}" class="readmore">{{__('Read More ')}}<i class="fal fa-long-arrow-right"></i></a>
                    </div>
                    <div class="icon">
                        <img src="{{ url('frontcss/img/icon/cou-icon.png') }}" alt="img">
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
<!-- courses-area-end -->

<!-- courses-area -->
@if($hsetting->livemeetings_enable == 1)
@if($gsetting->zoom_enable == '1' || $gsetting->bbl_enable == '1' || $gsetting->googlemeet_enable == '1' ||
$gsetting->jitsimeet_enable == '1')
<section class="courses pt-60 pb-60 p-relative fix">
    <div class="animations-01"><img src="{{url('frontcss/img/bg/an-img-03.png')}}" alt="an-img-01')}}"></div>
    <div class="container">
        @php
        $mytime = Carbon\Carbon::now();
        @endphp
        @if( count($meetings) > 0 || count($bigblue) > 0 || count($allgooglemeet) > 0 || count($jitsimeeting) > 0 )
        <div class="row">
            <div class="col-lg-12 p-relative">
                <div class="section-title center-align mb-50 wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                        <h5><i class="fal fa-graduation-cap"></i> {{__('Live Meeting')}}</h5>
                    <h2>
                        {{__('Live Meeting')}}
                    </h2>                             
                </div>
            </div>
        </div>
        <div class="row class-active">   
            @if(!$meetings->isEmpty() )
            @foreach($meetings as $meeting)
            <div class="col-lg-4 col-md-4">
                <div class="courses-item mb-30 hover-zoomin  protip">
                    <div class="thumb fix ">
                        @if($meeting['image'] !== NULL && $meeting['image'] !== '')
                        <a href="{{ route('zoom.detail', $meeting->id) }}" tabindex="0"><img src="{{ asset('images/zoom/'.$meeting['image']) }}" class="img-fluid" alt="contact-bg-an-01"></a> 
                        @else
                        <a href="{{ route('zoom.detail', $meeting->id) }}" tabindex="0"><img src="{{ Avatar::create($meeting['meeting_title'])->toBase64() }}" class="img-fluid avtar-img" alt="contact-bg-an-01"></a> 
                        @endif  
                                         
                        <div class="courses-icon">
                            <ul>
                                <li class="protip-wish-btn">
                                    <a href="https://calendar.google.com/calendar/r/eventedit?text={{ $discount['title'] }}" target="__blank" title="reminder" tabindex="0"><i data-feather="bell"></i></a>
                                </li>
                                <li class="protip-wish-btn">
                                    <a class="compare" data-id="53" title="compare" tabindex="0" data-id="{{filter_var($discount->id)}}">
                                        <i data-feather="bar-chart"></i>
                                    </a>
                                </li>
                                @if(Auth::check())
                                    @php
                                    $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',
                                    $discount->id)->first();
                                    @endphp
                                    @if ($wish == NULL)
                                        <li class="protip-wish-btn">
                                            <form id="demo-form2" method="post" action="{{ url('show/wishlist', $discount->id) }}" data-parsley-validate="" class="form-horizontal form-label-left">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />
                                                <button class="wishlisht-btn" title="Add to wishlist" type="submit" tabindex="0">
                                                    <i data-feather="heart"></i>
                                                </button>
                                            </form>
                                        </li>
                                    @else
                                        <li class="protip-wish-btn">
                                            <form id="demo-form3" method="post" action="{{ url('remove/wishlist', $discount->id) }}" data-parsley-validate="" class="form-horizontal form-label-left">
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
                    @if(asset('images/meeting_icons/zoom.png') == !NULL)
                    <div class="meeting-icon">
                        <img src="{{ asset('images/meeting_icons/zoom.png')}}" class="img-circle" alt="{{ __('zoom')}}">
                    </div>
                    @endif

                    <div class="courses-content"> 
                        <div class="view-user-img">
                            @if(optional($meeting->user)['user_img'] !== NULL && optional($meeting->user)['user_img'] !== '')
                        <a href="{{ route('all/profile',$meeting->user->id) }}" title="{{$meeting->paid_meeting_price}}">
                            <img src="{{ asset('images/user_img/'.$meeting->user['user_img']) }}" class="img-fluid user-img-one" alt="{{$meeting->paid_meeting_price}}"></a>
                        @else
                        <a href="{{ route('all/profile',$meeting->user->id) }}" title="{{$meeting->paid_meeting_price}}"><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt="{{$meeting->paid_meeting_price}}"></a>
                        @endif            
                        </div>                                
                        
                        @php
                            // Ensure $meeting->paid_meeting_price is a number
                            $paidMeetingPrice = (float) $meeting->paid_meeting_price;
                            $isPaid = App\PaidMettings::where('user_id', auth()->id())
                                        ->where('meeting_id', $meeting->id)
                                        ->where('amount', '>=', $paidMeetingPrice)
                                        ->exists();
                        @endphp
                        @if($meeting->paid_meeting_price && !$isPaid)
                                <div class="cat">
                                    <div class="rate text-right">
                                    <p class="meeting-owner btm-10">
                                        {{ currency($meeting->paid_meeting_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}
                                    </p>
                                </div>
                            </div>
                        @endif
                        <h3><a href="{{ route('zoom.detail', $meeting->id) }}" tabindex="0"> {{ $meeting['meeting_title'] }}</a></h3>
                        <div class="meeting-date-time">
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
                    </div>
                    <div class="icon">
                        <img src="{{ url('frontcss/img/icon/cou-icon.png') }}" alt="img">
                    </div>
                </div>
            </div>
            @endforeach
            @endif


            @if(!$bigblue->isEmpty() )
            @foreach($bigblue as $bbl)
            <div class="col-lg-4 col-md-4">
                <div class="courses-item mb-30 hover-zoomin  protip">
                    <div class="thumb fix ">
                        <a href="{{ route('bbl.detail', $bbl->id) }}" tabindex="0"><img src="{{ Avatar::create($bbl['meetingname'])->toBase64() }}" class="img-fluid avtar-img" alt="contact-bg-an-01"></a>               
                        <div class="courses-icon">
                            <ul>
                                <li class="protip-wish-btn">
                                    <a href="https://calendar.google.com/calendar/r/eventedit?text={{ $discount['title'] }}" target="__blank" title="reminder" tabindex="0"><i data-feather="bell"></i></a>
                                </li>
                                <li class="protip-wish-btn">
                                    <a class="compare" data-id="53" title="compare" tabindex="0" data-id="{{filter_var($discount->id)}}">
                                        <i data-feather="bar-chart"></i>
                                    </a>
                                </li>
                                @if(Auth::check())
                                    @php
                                    $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',
                                    $discount->id)->first();
                                    @endphp
                                    @if ($wish == NULL)
                                        <li class="protip-wish-btn">
                                            <form id="demo-form2" method="post" action="{{ url('show/wishlist', $discount->id) }}" data-parsley-validate="" class="form-horizontal form-label-left">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />
                                                <button class="wishlisht-btn" title="Add to wishlist" type="submit" tabindex="0">
                                                    <i data-feather="heart"></i>
                                                </button>
                                            </form>
                                        </li>
                                    @else
                                        <li class="protip-wish-btn">
                                            <form id="demo-form3" method="post" action="{{ url('remove/wishlist', $discount->id) }}" data-parsley-validate="" class="form-horizontal form-label-left">
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
                    @if(asset('images/meeting_icons/bigblue.png') == !NULL)
                    <div class="meeting-icon">
                        <img src="{{ asset('images/meeting_icons/bigblue.png')}}" class="img-circle" alt="{{ __('bigblue')}}">
                    </div>
                    @endif

                    <div class="courses-content"> 
                          
                        <div class="view-user-img">
                            @if(optional($bbl->user)['user_img'] !== NULL && optional($bbl->user)['user_img'] !== '')
                        <a href="{{ route('all/profile',$bbl->user->id) }}" title="{{ $bbl['meetingname'] }}">
                            <img src="{{ asset('images/user_img/'.$bbl->user['user_img']) }}" class="img-fluid user-img-one" alt="{{ $bbl['meetingname'] }}"></a>
                        @else
                        <a href="{{ route('all/profile',$bbl->user->id) }}" title="{{ $bbl['meetingname'] }}"><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt="{{ $bbl['meetingname'] }}"></a>
                        @endif            
                        </div>                                
                       
                        @php
                            // Ensure $meeting->paid_meeting_price is a number
                            $paidMeetingPrice = (float) $bbl->paid_meeting_price;
                            $isPaid = App\PaidMettings::where('user_id', auth()->id())
                                        ->where('meeting_id', $bbl->id)
                                        ->where('amount', '>=', $paidMeetingPrice)
                                        ->exists();
                        @endphp
                        @if($bbl->paid_meeting_price && !$isPaid)
                            <div class="cat">
                                <div class="rate text-right">
                                    <p class="meeting-owner btm-10">
                                        {{ currency($bbl->paid_meeting_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}
                                    </p> 
                                </div>
                            </div>
                        @endif
                            
                        <h3><a href="{{ route('bbl.detail', $bbl->id) }}" tabindex="0"> {{ $bbl['meetingname'] }}</a></h3>
                        <div class="meeting-date-time">
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
                    </div>
                    <div class="icon">
                        <img src="{{ url('frontcss/img/icon/cou-icon.png') }}" alt="img">
                    </div>
                </div>
            </div>
            @endforeach
            @endif

            @if( isset($allgooglemeet) )
            @foreach($allgooglemeet as $meeting)
            <div class="col-lg-4 col-md-4">
                <div class="courses-item mb-30 hover-zoomin  protip">
                    <div class="thumb fix ">
                        @if($meeting['image'] !== NULL && $meeting['image'] !== '')
                        <a href="{{ route('googlemeetdetailpage.detail', $meeting['id']) }}" tabindex="0"><img src="{{ asset('images/googlemeet/profile_image/'.$meeting['image']) }}" alt="contact-bg-an-01"></a> 
                        @else
                        <a href="{{ route('googlemeetdetailpage.detail', $meeting['id']) }}" tabindex="0"><img src="{{ Avatar::create($meeting['meeting_title'])->toBase64() }}" class="img-fluid avtar-img" alt="contact-bg-an-01"></a> 
                        @endif  
                                         
                        <div class="courses-icon">
                            <ul>
                                <li class="protip-wish-btn">
                                    <a href="https://calendar.google.com/calendar/r/eventedit?text={{ $discount['title'] }}" target="__blank" title="reminder" tabindex="0"><i data-feather="bell"></i></a>
                                </li>
                                <li class="protip-wish-btn">
                                    <a class="compare" data-id="53" title="compare" tabindex="0" data-id="{{filter_var($discount->id)}}">
                                        <i data-feather="bar-chart"></i>
                                    </a>
                                </li>
                                @if(Auth::check())
                                    @php
                                    $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',
                                    $discount->id)->first();
                                    @endphp
                                    @if ($wish == NULL)
                                        <li class="protip-wish-btn">
                                            <form id="demo-form2" method="post" action="{{ url('show/wishlist', $discount->id) }}" data-parsley-validate="" class="form-horizontal form-label-left">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />
                                                <button class="wishlisht-btn" title="Add to wishlist" type="submit" tabindex="0">
                                                    <i data-feather="heart"></i>
                                                </button>
                                            </form>
                                        </li>
                                    @else
                                        <li class="protip-wish-btn">
                                            <form id="demo-form3" method="post" action="{{ url('remove/wishlist', $discount->id) }}" data-parsley-validate="" class="form-horizontal form-label-left">
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
                    @if(asset('images/meeting_icons/google.png') == !NULL)
                    <div class="meeting-icon">
                        <img src="{{ asset('images/meeting_icons/google.png')}}" class="img-circle" alt="{{ __('google')}}">
                    </div>
                    @endif

                    <div class="courses-content"> 
                        <div class="view-user-img">
                            @if(optional($meeting->user)['user_img'] !== NULL && optional($meeting->user)['user_img'] !== '')
                        <a href="{{ route('all/profile',$meeting->user->id) }}" title="{{ $meeting['meeting_title'] }}">
                            <img src="{{ asset('images/user_img/'.$meeting->user['user_img']) }}" class="img-fluid user-img-one" alt="{{ $meeting['meeting_title'] }}"></a>
                        @else
                        <a href="{{ route('all/profile',$meeting->user->id) }}" title="{{ $meeting['meeting_title'] }}"><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt="{{ $meeting['meeting_title'] }}"></a>
                        @endif            
                        </div>                                
                        
                        @php
                            // Ensure $meeting->paid_meeting_price is a number
                            $paidMeetingPrice = (float) $meeting->paid_meeting_price;
                            $isPaid = App\PaidMettings::where('user_id', auth()->id())
                                        ->where('meeting_id', $meeting->id)
                                        ->where('amount', '>=', $paidMeetingPrice)
                                        ->exists();
                        @endphp
                        @if($meeting->paid_meeting_price && !$isPaid)
                            <div class="cat">
                                <div class="rate text-right">
                                    <p class="meeting-owner btm-10">
                                        {{ currency($meeting->paid_meeting_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}
                                    </p>
                                </div>
                            </div>
                        @endif
                            
                        <h3><a href="{{ route('googlemeetdetailpage.detail', $meeting['id']) }}" tabindex="0"> {{ $meeting['meeting_title'] }}</a></h3>
                        <div class="meeting-date-time">
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
                    </div>
                    <div class="icon">
                        <img src="{{ url('frontcss/img/icon/cou-icon.png') }}" alt="img">
                    </div>
                </div>
            </div>
            @endforeach
            @endif

            @if(!$jitsimeeting->isEmpty() )
            @foreach($jitsimeeting as $meeting)
            <div class="col-lg-4 col-md-4">
                <div class="courses-item mb-30 hover-zoomin  protip">
                    <div class="thumb fix ">
                        @if($meeting['image'] !== NULL && $meeting['image'] !== '')
                        <a href="{{ route('jitsipage.detail', $meeting['id']) }}" tabindex="0"><img src="{{ asset('images/jitsimeet/'.$meeting['image']) }}" alt="contact-bg-an-01"></a> 
                        @else
                        <a href="{{ route('jitsipage.detail', $meeting['id']) }}" tabindex="0"><img src="{{ Avatar::create($meeting['meeting_title'])->toBase64() }}" class="img-fluid avtar-img" alt="contact-bg-an-01"></a> 
                        @endif  
                                         
                        <div class="courses-icon">
                            <ul>
                                <li class="protip-wish-btn">
                                    <a href="https://calendar.google.com/calendar/r/eventedit?text={{ $discount['title'] }}" target="__blank" title="reminder" tabindex="0"><i data-feather="bell"></i></a>
                                </li>
                                <li class="protip-wish-btn">
                                    <a class="compare" data-id="53" title="compare" tabindex="0" data-id="{{filter_var($discount->id)}}">
                                        <i data-feather="bar-chart"></i>
                                    </a>
                                </li>
                                @if(Auth::check())
                                    @php
                                    $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',
                                    $discount->id)->first();
                                    @endphp
                                    @if ($wish == NULL)
                                        <li class="protip-wish-btn">
                                            <form id="demo-form2" method="post" action="{{ url('show/wishlist', $discount->id) }}" data-parsley-validate="" class="form-horizontal form-label-left">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />
                                                <button class="wishlisht-btn" title="Add to wishlist" type="submit" tabindex="0">
                                                    <i data-feather="heart"></i>
                                                </button>
                                            </form>
                                        </li>
                                    @else
                                        <li class="protip-wish-btn">
                                            <form id="demo-form3" method="post" action="{{ url('remove/wishlist', $discount->id) }}" data-parsley-validate="" class="form-horizontal form-label-left">
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
                    @if(asset('images/meeting_icons/jitsi.png') == !NULL)
                    <div class="meeting-icon">
                        <img src="{{ asset('images/meeting_icons/jitsi.png')}}" class="img-circle" alt="{{ __('jitsi')}}">
                    </div>
                    @endif
                    <div class="courses-content"> 
                        <div class="view-user-img">
                            @if(optional($meeting->user)['user_img'] !== NULL && optional($meeting->user)['user_img'] !== '')
                        <a href="{{ route('all/profile',$meeting->user->id) }}" title="{{ $meeting['meeting_title'] }}">
                            <img src="{{ asset('images/user_img/'.$meeting->user['user_img']) }}" class="img-fluid user-img-one" alt="{{ $meeting['meeting_title'] }}"></a>
                        @else
                        <a href="{{ route('all/profile',$meeting->user->id) }}" title="{{ $meeting['meeting_title'] }}"><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt="{{ $meeting['meeting_title'] }}"></a>
                        @endif            
                        </div>                                
                        
                        @php
                            // Ensure $meeting->paid_meeting_price is a number
                            $paidMeetingPrice = (float) $meeting->paid_meeting_price;
                            $isPaid = App\PaidMettings::where('user_id', auth()->id())
                                        ->where('meeting_id', $meeting->id)
                                        ->where('amount', '>=', $paidMeetingPrice)
                                        ->exists();
                        @endphp
                        @if($meeting->paid_meeting_price && !$isPaid)
                            <div class="cat">
                                <div class="rate text-right">
                                    <p class="meeting-owner btm-10">
                                        {{ currency($meeting->paid_meeting_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}
                                    </p>
                                </div>
                            </div>
                        @endif
                            
                        <h3><a href="{{ route('jitsipage.detail', $meeting['id']) }}" tabindex="0"> {{ $meeting['meeting_title'] }}</a></h3>
                        <div class="meeting-date-time">
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
                    </div>
                    <div class="icon">
                        <img src="{{ url('frontcss/img/icon/cou-icon.png') }}" alt="img">
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
<!-- courses-area-end -->
 <!-- steps-area -->
@if($hsetting->service_enable == 1 && !$services->isEmpty() && isset($servicesetting))
<section class="steps-area p-relative">
    <div class="animations-10"><img src="{{url('frontcss/img/bg/an-img-10.png')}}" alt="an-img-01"></div> 
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12">
                <div class="section-title mb-35 wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                    <h2>{{__('Our Best Features')}}</h2>
                    <p>{{ str_limit(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($servicesetting->detail))), $limit = 150, $end = '...') }}</p>
                </div>
                <div class="row pr-20">
                    @foreach($services as $ser)
                    <div class="col-lg-6 col-md-6 mb-4">
                        <div class="step-box wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                            <div class="dnumber">
                                @if($ser['image'] == !NULL)
                                    <div class="date-box"><img src="{{ asset('images/service/'.$ser['image']) }}" alt="icon"></div>
                                @else
                                    <img src="{{ Avatar::create($ser->title)->toBase64() }}" alt="icon">
                                @endif
                            </div>
                            <div class="text">
                                <h3>{{ $ser->title }}</h3>
                                <p>{{ str_limit(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($ser->detail))), $limit = 25, $end = '...') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="step-img wow fadeInLeft animated" data-animation="fadeInLeft" data-delay=".4s">
                    <img src="{{ asset('images/services/'.$servicesetting['image']) }}" alt="class-image">
                </div>
            </div>
        </div> 
    </div>
</section>
@endif
<!-- steps-area-end -->
<!-- categories start -->
@if($hsetting->featuredcategories_enable == 1 && !$category->isEmpty())
    <section id="categories" class="categories-main-block pt-120 pb-120 p-relative fix">
        <div class="container-xl">
            @if($category->where('featured', '1')->count() > 0)
                <h3 class="categories-heading">{{ __('Featured Categories') }}</h3>
                <div class="row">
                    @foreach($category as $t)
                        @if($t->status == 1 && $t->featured == 1)
                            <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                                <div class="cat-container btm-20 hover-zoomin text-center">
                                    <a href="{{ route('category.page',['slug' => $t->slug]) }}">
                                        <div class="cat-img">
                                            <img src="{{ $t['cat_image'] ? asset('images/category/'.$t['cat_image']) : Avatar::create($t->title)->toBase64() }}" alt="{{ __('cat-img')}}">
                                        </div>
                                        <div class="cat-dtl">
                                            <div>
                                                <span>
                                                    <h5 class="cat-name"><i class="fa {{ $t['icon'] }} me-2"></i>{{ $t['title'] }}</h5>
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
<!-- cta-area -->
@if($hsetting->became_enable == 1)
@php
$gets = App\JoinInstructor::first();
@endphp
@if(isset($gets)) 
             @if($gets['img'] !== NULL && $gets['img'] !== '')
            <section class="cta-area cta-bg pt-50 pb-50" style="background-image:url({{ url('/images/joininstructor/'.$gets->img) }})">
                @else
            <section class="cta-area cta-bg pt-50 pb-50" style="background-image:url({{ url('/images/joininstructor/'.$gets->img) }})">
                <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="{{ $gets->text }}">
             @endif           
                <div class="overlay-bg"></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-8">
                            <div class="section-title cta-title wow fadeInLeft animated" data-animation="fadeInDown animated" data-delay=".2s">
                                <h2>{{ $gets->text }}</h2>
								<p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($gets->detail))) , $limit = 100, $end = '...') }}
                            </div>
                                             
                        </div>
                        <div class="col-lg-4 col-md-4 text-right"> 
                            <div class="recommendation-btn">
                                <a href=""  data-toggle="modal" data-target="#myModalinstructor" class="btn btn-primary" title="Become an Instructor">{{__('Become an Instructor')}}</a>
                            </div>
                        </div>
					
                    </div>
                </div>
            </section>
            @endif
            @endif
            <!-- cta-area-end -->
 <!-- frequently-area -->
 @php
     $faqs = App\FaqStudent::get();
 @endphp
 <section class="faq-area pt-120 pb-120 p-relative fix">
    <div class="animations-10"><img src="{{url('frontcss/img/bg/an-img-04.png')}}" alt="an-img-01"></div>
    <div class="animations-08"><img src="{{url('frontcss/img/bg/an-img-05.png')}}" alt="contact-bg-an-01"></div>
    <div class="container">
        <div class="row justify-content-center  align-items-center">
            @if (isset($faqs))
            <div class="col-lg-7">
                <div class="section-title wow fadeInLeft animated" data-animation="fadeInDown animated" data-delay=".2s">
                    <h2>{{__('Get every single answer here.')}}</h2>
                    <p>{{__('A business or organization established to provide a particular service, typically one that involves a organizing transactions.')}}</p>
                </div>
                <div class="faq-wrap mt-30 pr-30 wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                    @foreach ($faqs as $index => $faq)
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="heading{{$faq->id}}">
                                <h2 class="mb-0">
                                    <button class="faq-btn  {{ $index == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{$faq->id}}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse">
                                       {{$faq->title}}
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse{{$faq->id}}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" >
                                <div class="card-body">
                                    {{substr(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($faq->details))), 0, 100)}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>          
            </div>
            @endif
            
            @if(Auth::check())
            <div class="col-lg-5">
                <div class="contact-bg02">
                <div class="section-title wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                    <h2>
                      {{__('Make An Contact')}}
                    </h2>
                  
                </div>
                    
            <form action="{{ route('contact.user') }}" method="post" class="contact-form mt-30 wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                {{ csrf_field() }}


                <div class="row">
                <div class="col-lg-12">
                    <div class="contact-field p-relative c-name mb-20">                                    
                        <input type="text" id="firstn" name="fname" placeholder="First Name" required>
                    </div>                               
                </div>
                
                <div class="col-lg-12">                               
                    <div class="contact-field p-relative c-subject mb-20">                                   
                        <input type="text" id="email" name="email" placeholder="Email" required>
                    </div>
                </div>		
                <div class="col-lg-12">                               
                    <div class="contact-field p-relative c-subject mb-20">                                   
                        <input type="text" id="phone" name="mobile" placeholder="Phone No." required>
                    </div>
                </div>	
                @php
                $data =  App\Contactreason::where('status', '1')->get();
               @endphp
              
                <div class="col-lg-12">
                    <div class="contact-field p-relative c-message mb-30">                                  
                        <textarea name="message" id="message" cols="30" rows="10" placeholder="Write comments"></textarea>
                    </div>
                    <div class="slider-btn">                                          
                                <button class="btn ss-btn" data-animation="fadeInRight" data-delay=".8s"><span>{{__('Submit Now')}}</span> <i class="fal fa-long-arrow-right"></i></button>				
                            </div>                             
                </div>
                </div>
        </form>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>
<!-- frequently-area-end -->	
     <!-- video-area -->
@if($hsetting->video_enable == 1 &&  isset($videosetting) )
    <section class="cta-area cta-bg pt-160 pb-160 cta-area-videosetting" style="background-image:url({{ ('images/videosetting/'.$videosetting->image) }});">
        <div class="overlay-bg"></div>
        <div class="container">
            <div class="row justify-content-center  align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="section-title cta-title video-title wow fadeInLeft animated" data-animation="fadeInDown animated" data-delay=".2s">
                        <h2> {{ $videosetting->tittle }}</h2>
                        <p>{{ $videosetting->description }} </p>	
                    </div>
                                     
                </div>
                <div class="col-lg-2 col-md-2">
                </div>
               <div class="col-lg-4">

                        <div class="s-video-content">
                            <a href="{{$videosetting->url}}" class="popup-video mb-50"><img src={{ url('frontcss/img/bg/play-button.png') }} alt="circle_right"></a>
                           
                        </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- video-area-end -->	
<!-- testimonial-area -->
@if($hsetting->testimonial_enable == 1 && ! $testi->isEmpty() )
<section class="testimonial-area pt-120 pb-115 p-relative fix">
    <div class="animations-01"><img src="{{url('frontcss/img/bg/an-img-03.png')}}" alt="an-img-01"></div>
    <div class="animations-02"><img src="{{url('frontcss/img/bg/an-img-04.png')}}" alt="contact-bg-an-01"></div>
    <div class="container">
       <div class="row">
           <div class="col-lg-12">
               <div class="section-title text-center mb-50 wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                   <h5><i class="fal fa-graduation-cap"></i> {{ __('Testimonial') }}</h5>
                   <h2>
                    {{ __('What Our Clients Says')}}
                   </h2>
                
               </div>
              
           </div>
           
           <div class="col-lg-12">
             
                <div class="testimonial-active wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                    @foreach($testi as $tes)
                    <div class="single-testimonial text-center">
                        <div class="qt-img">
                            <img src="{{ asset('frontcss/img/qt-icon.png') }}" alt="img">
                        </div>
                        <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($tes->details))) , $limit = 100, $end = '...') }}</p>
                        <div class="testi-author">
                           <img src="{{ asset('images/testimonial/'.$tes['image']) }}"   alt="img">
                        </div>
                        <div class="ta-info">
                            <h6>{{ $tes['client_name'] }}</h6>
                            <span>{{ $tes['designation'] }}</span>
                        </div>                                    
                    </div>
                    @endforeach
                </div>
              
           </div>
       </div>
   </div>
</section>
@endif
<!-- testimonial-area-end -->	

 <!-- admission-area -->
@if($hsetting->get_enable == 1 && isset($get_enable))
 <section class="about-area about-p pt-120 pb-120 p-relative fix" style="background-image:url({{url('frontcss/img/bg/admission_bg.png')}}); background-repeat: no-repeat; background-position: top;">
    <div class="container">
        <div class="row justify-content-center align-items-center">
             <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="s-about-img p-relative  wow fadeInLeft animated" data-animation="fadeInLeft" data-delay=".4s">
                    <img src="{{ 'images/getstarted/'.$get_enable->image }}" alt="img">                              
                </div>                          
            </div>
            
        <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="about-content s-about-content pl-15 wow fadeInRight  animated" data-animation="fadeInRight" data-delay=".4s">
                    <div class="about-title second-title pb-25">  
                        <h2>{{ $get_enable->heading }}</h2>                                   
                    </div>
                       <p class="txt-clr">{{ $get_enable->sub_heading }}</p>
                     <div class="slider-btn mt-20">                                          
                         <a href="{{ $get_enable->link }}" class="btn ss-btn smoth-scroll">{{ $get_enable->button_txt }} <i class="fal fa-long-arrow-right"></i></a>				
                    </div>
                </div>
            </div>
         
        </div>
    </div>
</section>
@endif
<!-- admission-area-end -->
  <!-- brand-area -->
@if($hsetting->trusted_enable == 1 && ! $trusted->isEmpty() )
<div class="brand-area pt-60 pb-60" >
    <div class="container">
        <div class="row brand-active">
        @foreach($trusted as $trust)
            <div class="col-xl-2">
                <div class="single-brand owl-carousel">
                    <img src="{{ asset('images/trusted/'.$trust['image']) }}" class="img-fluid owl-lazy" alt="img">
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>
@endif
<!-- brand-area-end -->   
<!-- blog-area -->
@if($hsetting->blog_enable == 1 && !$blogs->isEmpty())
<section id="blog" class="blog-area p-relative fix pt-120 pb-90" style="background-image:url(frontcss/img/bg/blog_bg.png); background-repeat: no-repeat; background-position: top;">    <div class="container">
        <div class="row align-items-center"> 
            <div class="col-lg-12">
                <div class="section-title center-align mb-50 text-center wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                    <h5><i class="fal fa-graduation-cap"></i>{{__(' Our Blog')}}</h5>
                    <h2>
                        {{__('Latest Blog & News')}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="row">
            @php
                $counter = 0;
            @endphp
                                     
            @foreach($blogs as $blog)
            @php
            $image = $blog['image'];
            $slug = $blog->slug;
            $headingSlug = str_slug(str_replace('-','&',$blog->heading));
            $detailRoute = $slug != NULL ? route('blog.detail', ['slug' => $slug]) : route('blog.detail', ['slug' => $headingSlug]);
            $imageSrc = $image ? asset('images/blog/'.$image) : Avatar::create($blog->heading)->toBase64();
            @endphp
                @if($counter < 3)
                <div class="col-lg-4 col-md-6">
                    <div class="single-post2 hover-zoomin mb-30 wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                        <div class="blog-thumb2">
                            <a href="{{ $detailRoute }}"><img src="{{ asset('images/blog/'.$blog['image']) }}" alt="img"></a>
                            <div class="date-home">
                                <i class="fal fa-calendar-alt"></i> {{ date('d-m-Y',strtotime($blog['start_time'])) }}
                            </div>
                        </div>                    
                        <div class="blog-content2">    
                            <div class="b-meta">
                                <div class="meta-info">
                                    <ul>
                                        <li><i class="fal fa-user"></i>{{__(' By ')}}{{ optional($blog->user)['fname'] }}</a></li>
                                    </ul>
                                </div>
                            </div>

                            <h4><a href="{{ $detailRoute }}" class="truncate">{{ $blog['heading'] }}</a></h4> 
                            <p class="limited-lines">{{substr(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($blog->detail))), 0, 200)}}</p>
                            <div class="blog-btn"><a href="{{ $detailRoute }}">{{__('Read More')}} <i class="fal fa-long-arrow-right"></i></a></div>
                        </div>
                    </div>
                </div>
                @php
                    $counter++;
                @endphp
                @else
                    @break
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- blog-area-end -->

<!-- Instructor-area -->
@if($hsetting->instructor_enable == 1 && !$instructors->isEmpty())
<section id="instructor" class="instructor-main-block pt-90 pb-90 p-relative fix" data-animation="fadeInUp animated" data-delay=".2s">
    <div class="container">
        <div class="row"> 
            <div class="col-lg-12">
                <div class="section-title center-align mb-50 wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                    <h5><i class="fal fa-graduation-cap"></i> {{ __('Instructor') }}</h5>
                    <h2>
                        {{ __('Instructor') }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="row class-active">
            @foreach($instructors as $inst)
            <div class="col-lg-4 col-md-6 ">
                @php
                $url = URL::to('/').'/allinstructor/profile/'.$inst->id;
                @endphp
                <!-- class-item -->
                <div class="class-item mb-30 courses-item hover-zoomin">
                        <!-- class-img -->
                    <div class="class-img">
                        <div class="class-img-outer">
                            <a href="{{ route('allinstructor/profile',$inst->id) }}"> <img src="{{ url('/images/user_img/'.$inst['user_img']) }}" alt="class-image"></a>
                            <div class="courses-icon instructor-home-block">
                                <ul>
                                    <li>
                                        <div class="tooltip">
                                            <div class="tooltip-icon">
                                                <i data-feather="share-2"></i>
                                            </div>
                                            <span class="tooltiptext">
                                                <div class="instructor-home-social-icon">
                                                    <ul>
                                                        <li><a href="http://www.linkedin.com/shareArticle?mini=true&url={{ $url }}&title=Default+share+text&summary=" target="_blank" title="Linkedin"><b><i class="fab fa-linkedin-in"></i></b></a></li>
                                                        <li><a href="https://www.facebook.com/sharer/sharer.php?&url={{ $url }}" target="_blank" title="Facebook"><b><i class="fab fa-facebook-f"></i></b></a></li>
                                                        <li><a href="https://twitter.com/intent/tweet?text=Default+share+text&url={{ $url }}" target="_blank" title="Twitter"><b><i class="fab fa-twitter"></i></b></a></li>
                                                        <li><a href="https://telegram.me/share/url?url={{ $url }}&text=Default+share+text" target="_blank" title="Telegram"><b><i class="fab fa-telegram"></i></b></a></li>
                                                        <li><a href="https://wa.me/?text={{ $url }}" target="_blank" title="Whatsapp"><b><i class="fab fa-whatsapp"></i></b></a></li>
                                                    </ul>
                                                </div>
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="{{ route('allinstructor/profile',$inst->id) }}"  title="View Page"><i data-feather="eye"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <!-- course-meta -->
                            <div class="course-meta">
                                <div class="instructor-home-dtl">
                                    <h4 class="instructor-home-heading mb-0"><a href="{{ route('allinstructor/profile',$inst->id) }}" title="{{ $inst->fname . $inst->lname }}">{{ $inst->fname }} {{ $inst->lname }}</a></h4>
                                    <p>{{ $inst->role }}</p>
                                    <div class="instructor-home-info">
                                        @php
                                        $followers = App\Followers::where('user_id', '!=', $inst->id)->where('follower_id', $inst->id)->count();
                                        $followings = App\Followers::where('user_id', $inst->id)->where('follower_id','!=', $inst->id)->count();
                                        $course = App\Course::where('user_id', $inst->id)->count();
                                    @endphp
                                    <ul>
                                        <li>{{ $course > 0 ? $course.' '.__('Courses') : __('No Courses') }}</li>
                                        <li>{{ $followers }} {{ __('Follower') }}</li>
                                        <li>{{ $followings }} {{ __('Following') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- course-meta-end -->
                        </div>                                    
                    </div>
                    <!-- class-img -->
                </div>
                    <!-- class-item-end -->
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- Instructor-area-end -->

<!-- Institute-area -->
@if($hsetting->institute_enable == 1 && !$institute->isEmpty())
<section id="institute" class="institute-main-block pt-90 pb-90 p-relative fix" data-animation="fadeInUp animated" data-delay=".2s">
    <div class="container">
        <div class="row"> 
            <div class="col-lg-12">
                <div class="section-title center-align mb-50 wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                    <h5><i class="fal fa-graduation-cap"></i> {{ __('Institute') }}</h5>
                    <h2>
                        {{ __('Institute') }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="row class-active">
            @foreach($institute as $inst)
            <div class="col-lg-4 col-md-6 ">
                <!-- class-item -->
                <div class="class-item mb-30 courses-item hover-zoomin">
                        <!-- class-img -->
                    <div class="class-img">
                        <div class="class-img-outer">
                            <a href="{{ route('ins.sluging', ['slug' => $inst->slug]) }}"> <img src="{{ $inst['image'] ? url('/files/institute/'.$inst->image) : Avatar::create($inst->fname)->toBase64() }}" alt="class-image"></a>
                            <div class="courses-icon">
                                <ul>
                                    <li>
                                        <a href="{{ route('ins.sluging', ['slug' => $inst->slug]) }}"  title="View Page"><i data-feather="eye"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <!-- course-meta -->
                            <div class="course-meta">
                                <h4 class="instructor-home-heading"><a href="{{ route('ins.sluging', ['slug' => $inst->slug]) }}" title="{{ $inst->title }}">{{ $inst->title }} </a></h4>
                                <p>{{ $inst->email }}</p>
                                <p>{{ $inst->phone }}</p>
                            </div>
                            <!-- course-meta-end -->
                        </div>                                    
                    </div>
                    <!-- class-img -->
                </div>
                    <!-- class-item-end -->
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- Institute-area-end -->

<!-- newslater-area -->
<section class="newslater-area pt-60 pb-60">
    <div class="container" >
        <div class="row align-items-center">
            <div class="col-xl-7 col-lg-7">
                <div class="section-title newslater-title">
                    <div class="icon">
                        <img src="{{url('frontcss/img/icon/send-mail.png')}}" alt="img">
                    </div>
                    <div class="text">
                        <h2>{{__('Subscribe for Newsletter')}}</h2>
                        <p>{{__('Manage Your Business With Our Software')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-5">
                 <form name="ajax-form" id="contact-form4" action="{{url('store-newsletter')}}" method="post" class="contact-form newslater">
                    @csrf
                   <div class="form-group p-relative">
                      <input class="form-control" id="email2" name=subscribed_email type="email" placeholder="Email Address..." required> 
                      <button type="submit" class="btn btn-custom" id="send2">{{__('Subscribe Now')}}</button>
                   </div>
                   <!-- /Form-email -->	
                </form>
            </div>
        </div>
       
    </div>
</section>
<!-- newslater-aread-end -->
@endsection 
@section('custom-script')
<script>
    (function ($) {
        "use strict";
        $(function () {
            $("#photography-tab").trigger("click");
        });
    })(jQuery);
    function showtab(id) {
        $.ajax({
            type: 'GET',
            url:'{{ url('/tabcontent1') }}/' + id,
            dataType: 'json',
            success: function (data) {
                $('.btn_more').html(data.btn_view);
                $('#tabShow').html(data.tabview2);
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