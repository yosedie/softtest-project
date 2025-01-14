@extends('theme.master')
@section('title', "$zoom->meeting_title")
@section('content')

@include('admin.message')

@section('meta_tags')

@php
    $url =  URL::current();
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
<link rel="canonical" href="{{ url()->full() }}"/>
<meta name="robots" content="all">
<meta name="keywords" content="{{ $gsetting->meta_data_keyword }}">
    

@endsection
<!-- course detail header start -->
<section id="about-home" class="about-home-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-8">
                <div class="about-home-block text-white">
                    <h1 class="about-home-heading text-white">{{ $zoom['meeting_title'] }}</h1>
                    <ul>
                       
                    <ul>
                        <li><a href="#" title="about">{{ __('Created') }}: {{ $zoom->user['fname'] }} </a></li>

                        @if($zoom->type != '3')
                        <li><a href="#" title="about">{{ __('Start At')}}: {{ date('d-m-Y | h:i:s A',strtotime($zoom['start_time'])) }}</a></li>
                        @endif
                        
                    </ul>
                </div>
            </div>
            <!-- course preview -->
            <div class="col-lg-4">
                @php
                    // Ensure $meeting->paid_meeting_price is a number
                    $paidMeetingPrice = (float) $zoom->paid_meeting_price;
                
                    $isPaid = App\PaidMettings::where('user_id', auth()->id())
                                ->where('meeting_id', $zoom->id)
                                ->where('amount', '>=', $paidMeetingPrice)
                                ->exists();
                @endphp
                
                <div class="about-home-product">
                    <div class="video-item hidden-xs">
                       
                        <div class="video-device">
                            @if($zoom['image'] !== NULL && $zoom['image'] !== '')
                                <img src="{{ asset('images/zoom/'.$zoom['image']) }}" class="bg_img img-fluid" alt="Background">
                            @else
                                <img src="{{ Avatar::create($zoom['meeting_title'])->toBase64() }}" class="bg_img img-fluid" alt="Background">
                            @endif
                        </div>
                    </div>
                    <div class="about-home-dtl-training">
                        <div class="about-home-dtl-block btn-10">
                            <div class="about-home-btn btm-20">
                                @if(isset($zoom) && $zoom->paid_meeting_price && !$isPaid)
                                    <p class="meeting-owner btm-10">
                                        {{ currency($zoom->paid_meeting_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}
                                    </p>
                                    <form action="{{ route('checkoutmeeting') }}" method="GET">
                                        <input type="hidden" name="meeting_id" value="{{ $zoom->id }}">
                                        <input type="hidden" name="type" value="zoom">
                                        <button type="submit" class="btn btn-primary">{{ __('Checkout') }}</button>
                                    </form>
                                @else
                                    <a href="{{ $zoom->zoom_url }}" class="iframe btn btn-secondary">{{ __('Join Meeting') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- course header end -->
<!-- course detail start -->
<section id="about-product" class="about-product-main-block meetings-main-block">
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
</section>


<!-- course detail end -->
@endsection

@section('custom-script')

<script src="{{ url('js/colorbox-script.js')}}"></script>

@endsection