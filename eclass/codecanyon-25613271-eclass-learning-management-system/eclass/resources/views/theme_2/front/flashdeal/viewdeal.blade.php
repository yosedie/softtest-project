@extends('theme2.master')
@section('title', 'All deals')
@section('content')
@include('admin.message')
@include('sweetalert::alert')
@section('meta_tags')
<link rel="canonical" href="{{ url()->full() }}" />
<meta name="robots" content="all">
<meta property="og:title" content="{{ __("All deals") }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->full() }}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="{{ url()->full() }}" />
@endsection
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
                        <h2>
                            <div class="countdown-deal">
                                <p class="text-center mb-4">{{__("Sale ends in ")}}</p>
                                <div id="countdown">
                                    <ul>
                                        <li class="text-shadow"><span class="text-white" id="days"></span><span class="text-white text-20">{{__('days')}}</span></li>
                                        <li class="text-shadow"><span class="text-white" id="hours"></span><span class="text-white text-20">{{__(' hours')}}</span></li>
                                        <li class="text-shadow"><span class="text-white" id="minutes"></span><span class="text-white text-20">{{__(' minutes')}}</span></li>
                                        <li class="text-shadow"><span class="text-white" id="seconds"></span><span class="text-white text-20">{{__('seconds')}}</span></li>
                                    </ul>
                                </div>
                            </div>
                        </h2>    
                        
                    </div>
                </div>
            </div>
            <div class="breadcrumb-wrap2">
                  
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('Flash Deal')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section id="flash-home" class="flash-home-main-block">
<div class="container-xl">
    <div class="test">
        @php
            $mytime = Carbon\Carbon::now();
        @endphp
        @if($mytime <= $deal->end_date)
        <div class="flash-countdown bg_image_deal">
                <div class="row">
                    @forelse($deal->saleitems as $item)
                    <div class="col-lg-4 col-md-6 ">
                        <div class="courses-item mb-30 hover-zoomin">
                            @if(isset($item->courses))
                            <div class="thumb fix">
                                @if(isset($item->courses->preview_image))
                                <a href="{{ route('user.course.show',['slug' => $item->courses->slug ]) }}">
                                    <img src="{{ asset('images/course/'.$item->courses['preview_image']) }}" alt="contact-bg-an-01"></a>
                                    @else
                                    <a href="{{ route('user.course.show',['slug' => $item->courses->slug ]) }}">
                                    <img src="{{ Avatar::create($item->courses->title)->toBase64() }}" alt="contact-bg-an-01"></a>
                                    @endif
                                <div class="courses-icon">
                                    <ul>
                                        <li><a href="#" class="" title="add to cart" tabindex="0"><i data-feather="shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="courses-content">
                                <h3><a href="single-courses.html">  {{$item->courses->title}}</a></h3>
                                <p class="card-text">{{ substr(strip_tags($item->courses->detail), 0, 90)}}{{strlen(strip_tags($item->courses->detail))>90 ? '...' : ""}}</p>
                                <div class="flash-deal-dtl-offer">
                                    <span class="badge text-primary">{{__('Discount')}} : {{ $item->discount }}% ({{ $item->discount_type }})</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-md-12">
                        <h4 class="text-center">
                            {{__("No products found !")}}
                        </h4>
                    </div>
                    @endforelse
                   </div>
                    <div>
                    <div class="flash-deals-details">
                        {!! $deal->detail !!}
                    </div>
                </div>
        </div>
            @else
        <section id="search-block" class="search-main-block search-block-no-result text-center">
                <div class="container-xl">
                    <div class="no-result-courses mb-3">{{ __('Flash Deal Ends') }}</div>
                    <div class="recommendation-btn text-white text-center">
                        <a href="{{ route('flash.deals') }}" class="btn btn-primary" title="search"><b>{{ __('Browse More Deals') }}</b></a>
                    </div> 
                </div>
            </section>
            @endif
        </div>
</div>
</section>
@endsection
@section('custom-script')
<script>
    (function () {
        const second = 1000,
            minute = second * 60,
            hour = minute * 60,
            day = hour * 24;

        let birthday = "{{ date('M d, Y h:i:s',strtotime($deal->end_date)) }}",
            countDown = new Date(birthday).getTime(),
            x = setInterval(function () {

                let now = new Date().getTime(),
                    distance = countDown - now;

                document.getElementById("days").innerText = Math.floor(distance / (day)),
                    document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)),
                    document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
                    document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);

                //do something later when date is reached
                if (distance < 0) {
                    let headline = document.getElementById("headline"),
                        countdown = document.getElementById("countdown"),
                        content = document.getElementById("content");

                    headline.innerText = "It's my birthday!";
                    countdown.style.display = "none";
                    content.style.display = "block";

                    clearInterval(x);
                }
                //seconds
            }, 0)
    }());
</script>
@endsection





























































