@extends('theme2.master')
@section('title', "$zoom->meeting_title")
@section('content')

@include('admin.message')

@section('meta_tags')

@php
$url = URL::current();
@endphp

<meta name="title" content="{{ $zoom['meeting_title'] }}">
<meta name="description" content="{{ $zoom['agenda'] }} ">
<meta name="author" content="elsecolor">
<meta property="og:title" content="{{ $zoom['meeting_title'] }} ">
<meta property="og:url" content="{{ $url }}">
<meta property="og:description" content="{{ $zoom['agenda'] }}">
<meta property="og:image" content="{{ asset('images/zoom/'.$zoom['image']) }}">
<meta itemprop="image" content="{{ asset('images/zoom/'.$zoom['image']) }}">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="{{ asset('images/zoom/'.$zoom['image']) }}">
<meta property="twitter:title" content="{{ $zoom['meeting_title'] }} ">
<meta property="twitter:description" content="{{ $zoom['agenda'] }}">
<meta name="twitter:site" content="{{ url()->full() }}" />
<link rel="canonical" href="{{ url()->full() }}" />
<meta name="robots" content="all">
<meta name="keywords" content="{{ $gsetting->meta_data_keyword }}">


@endsection
<!-- breadcrumb-area -->
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
                    <h2>{{__('Zoom Meeting')}}</h2>  
                </div>
            </div>
        </div>
        <div class="breadcrumb-wrap2">
              
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{__('Zoom Meeting')}}</li>
                </ol>
            </nav>
        </div>
        
    </div>
</div>
</section>
<!-- breadcrumb-area-end -->
<!-- course detail header start -->
<section class="project-detail">
    <div class="container">
        <div class="lower-content">
            <div class="row">
                <div class="text-column col-lg-9 col-md-8 col-sm-12">
                    <h2>{{ $zoom['meeting_title'] }}</h2>
                    <div class="upper-box">
                        <div class="single-item-carousel">
                            @if($zoom['image'] !== NULL && $zoom['image'] !== '')
                            <figure class="image"><img src="{{ asset('images/zoom/'.$zoom['image']) }}" alt="Background"></figure>
                            @else
                            <figure class="image"><img src="{{ Avatar::create($zoom['meeting_title'])->toBase64() }}" alt="Background"></figure>
                            @endif
                        </div>
                    </div>
                    <div class="inner-column">
                        <ul class="mb-4">
                            <li class="d-inline-block"><a href="#" title="about">{{ __('Created') }}: {{ $zoom->user['fname'] }} </a></li>

                            @if($zoom->type != '3')
                            <li class="d-inline-block float-end"><a href="#" title="about">{{ __('Start At')}}: {{ date('d-m-Y | h:i:s
                                    A',strtotime($zoom['start_time'])) }}</a></li>
                            @endif
                        </ul>
                    </div>
                    <div class="requirements">
                        <h3>{{ __('Agenda') }}</h3>
                        <ul>
                            <li class="comment more">
    
                                {!! $zoom->agenda !!}
    
                            </li>
    
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <aside class="sidebar-widget info-column">
                        <div class="inner-column3">
                            <h3>{{ __('Meeting') }}</h3>
                            <ul class="project-info clearfix">
                                @php
                                // Ensure $meeting->paid_meeting_price is a number
                                $paidMeetingPrice = (float) $zoom->paid_meeting_price;
                                $isPaid = App\PaidMettings::where('user_id', auth()->id())
                                            ->where('meeting_id', $zoom->id)
                                            ->where('amount', '>=', $paidMeetingPrice)
                                            ->exists();
                                @endphp

                                @if(isset($zoom) && $zoom->paid_meeting_price)
                                <li>
                                    <div class="priceing">  
                                        <strong>{{ currency($zoom->paid_meeting_price, $from = $currency->code, $to =
                                            Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code,
                                            $format = true) }}</strong>
                                    </div>
                                </li>
                                <li class="course-detail-button">
                                    <div class="about-home-dtl-training">
                                        <div class="about-home-dtl-block btm-10">
                                            <form action="{{ route('checkoutmeeting') }}" method="GET">
                                                <input type="hidden" name="meeting_id" value="{{ $zoom->id }}">
                                                <input type="hidden" name="type" value="zoom">
                                                <button type="submit" class="btn btn-primary">{{ __('Checkout') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                                @else
                                <li class="course-detail-button">
                                    <div class="about-home-btn btm-20">
                                        <a href="{{ $zoom->zoom_url }}" class="iframe btn btn-secondary">{{ __('Join
                                            Meeting')}}</a>
                                    </div>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- <section id="about-home" class="about-home-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-8">
                <div class="about-home-block text-white">
                    <h1 class="about-home-heading text-white">{{ $zoom['meeting_title'] }}</h1>
                    <ul>

                        <ul>
                            <li><a href="#" title="about">{{ __('Created') }}: {{ $zoom->user['fname'] }} </a></li>

                            @if($zoom->type != '3')
                            <li><a href="#" title="about">{{ __('Start At')}}: {{ date('d-m-Y | h:i:s
                                    A',strtotime($zoom['start_time'])) }}</a></li>
                            @endif

                        </ul>
                </div>
            </div>
            <!-- course preview -->
            <div class="col-lg-4">


                <div class="about-home-product">
                    <div class="video-item hidden-xs">

                        <div class="video-device">
                            @if($zoom['image'] !== NULL && $zoom['image'] !== '')
                            <img src="{{ asset('images/zoom/'.$zoom['image']) }}" class="bg_img img-fluid"
                                alt="Background">
                            @else
                            <img src="{{ Avatar::create($zoom['meeting_title'])->toBase64() }}" class="bg_img img-fluid"
                                alt="Background">
                            @endif
                        </div>
                    </div>


                    <div class="about-home-dtl-training">
                        <div class="about-home-dtl-block btm-10">
                            @if(isset($zoom) && $zoom->paid_meeting_price)
                            <p class="meeting-owner btm-10">
                                {{ __('Price') }}:{{ currency($zoom->paid_meeting_price, $from = $currency->code, $to =
                                Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code,
                                $format = true) }}
                            </p>
                            <form action="{{ route('checkoutmeeting') }}" method="GET">
                                <input type="hidden" name="meeting_id" value="{{ $zoom->id }}">
                                <input type="hidden" name="type" value="zoom">
                                <button type="submit" class="btn btn-primary">{{ __('Checkout') }}</button>
                            </form>
                            @else
                            <div class="about-home-btn btm-20">
                                <a href="{{ $zoom->zoom_url }}" class="iframe btn btn-secondary">{{ __('Join
                                    Meeting')}}</a>
                            </div>
                             @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}
<!-- course header end -->
<!-- course detail start -->
{{-- <section id="about-product" class="about-product-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-8">
                <div class="requirements">
                    <h3>{{ __('Agenda') }}</h3>
                    <ul>
                        <li class="comment more">

                            {!! $zoom->agenda !!}

                        </li>

                    </ul>
                </div>

            </div>
        </div>
    </div>
</section> --}}


<!-- course detail end -->
@endsection

@section('custom-script')

<script src="{{ url('js/colorbox-script.js')}}"></script>

@endsection