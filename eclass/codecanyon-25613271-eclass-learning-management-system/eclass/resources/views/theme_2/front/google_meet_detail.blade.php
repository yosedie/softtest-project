@extends('theme2.master')
@section('title', "$googlemeet->meeting_title")
@section('content')
@include('admin.message')

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
                    <h2>{{__('Google Meet Meeting')}}</h2>  
                </div>
            </div>
        </div>
        <div class="breadcrumb-wrap2">
              
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{__('Google Meet Meeting')}}</li>
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
                    <h2>{{ $googlemeet['meeting_title'] }}</h2>
                
                    <div class="upper-box">
                        <div class="single-item-carousel">
                            @if($googlemeet['image'] !== NULL && $googlemeet['image'] !== '')
                            <figure class="image"><img src="{{ asset('/images/googlemeet/profile_image/'.$googlemeet['image']) }}" alt="Background"></figure>
                            @else
                            <figure class="image"><img src="{{ Avatar::create($googlemeet['meeting_title'])->toBase64() }}" alt="Background"></figure>
                            @endif
                        </div>
                    </div>
                    <div class="inner-column">
                        <ul class="mb-4">
                            <li class="d-inline-block"><a href="#" title="about"></a></li>
                            <li class="d-inline-block float-end"><a href="#" title="about">{{ __('Start At')}}: {{ date('d-m-Y | h:i:s
                                    A',strtotime($googlemeet['start_time'])) }}</a></li>
                            
                        </ul>
                        <div class="requirements">
                            <h3>{{ __('Agenda') }}</h3>
                            <ul>
                                <li class="comment more">
                                    {!! $googlemeet->agenda !!}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <aside class="sidebar-widget info-column">
                        <div class="inner-column3">
                            <h3>{{ __('Meeting') }}</h3>
                            <ul class="project-info clearfix">
                                @php
                                // Ensure $meeting->paid_meeting_price is a number
                                $paidMeetingPrice = (float) $googlemeet->paid_meeting_price;
                                $isPaid = App\PaidMettings::where('user_id', auth()->id())
                                            ->where('meeting_id', $googlemeet->id)
                                            ->where('amount', '>=', $paidMeetingPrice)
                                            ->exists();
                                @endphp

                                @if($googlemeet->paid_meeting_price && !$isPaid)
                                <li>
                                    <div class="priceing">  
                                        <strong>{{ currency($googlemeet->paid_meeting_price,
                                            $from = $currency->code, $to =
                                            Session::has('changed_currency') ?
                                            Session::get('changed_currency') :
                                            $currency->code, $format = true) }}</strong>         
                                    </div>
                                </li>
                                <li class="course-detail-button">
                                    <div class="about-home-dtl-training">
                                        <div class="about-home-dtl-block btm-10">
                                            <form action="{{ route('checkoutmeeting') }}" method="GET">
                                                <input type="hidden" name="meeting_id" value="{{ $googlemeet->id }}">
                                                <input type="hidden" name="type" value="googlemeet">
                                                <button type="submit" class="btn btn-primary">{{
                                                    __('Checkout') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                                @else
                                <li class="course-detail-button">
                                    <div class="about-home-btn btm-20">
                                        <a href="{{ $googlemeet->meet_url }}" target="_blank" class="btn btn-secondary">{{
                                            __('Join Meeting')}}</a>
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
                    <h1 class="about-home-heading text-white">{{ $googlemeet['meeting_title'] }}</h1>
                    <ul>

                        <ul>
                            <li><a href="#" title="about"></a></li>


                            <li><a href="#" title="about">{{ __('Start At')}}: {{ date('d-m-Y | h:i:s
                                    A',strtotime($googlemeet['start_time'])) }}</a></li>

                        </ul>
                </div>
            </div>
            <!-- course preview -->
            <div class="col-lg-4">


                <div class="about-home-product">
                    <div class="video-item hidden-xs">

                        <div class="video-device">
                            @if($googlemeet['image'] !== NULL && $googlemeet['image'] !== '')
                            <img src="{{ asset('/images/googlemeet/profile_image/'.$googlemeet['image']) }}"
                                class="bg_img img-fluid" alt="Background">
                            @else
                            <img src="{{ Avatar::create($googlemeet['meeting_title'])->toBase64() }}"
                                class="bg_img img-fluid" alt="Background">
                            @endif
                        </div>
                    </div>


                    <div class="about-home-dtl-training">
                        <div class="about-home-dtl-block btm-10">
                            @php
                            $isPaid = App\PaidMettings::where('user_id',
                            auth()->id())
                            ->where('meeting_id', $googlemeet->id)
                            ->where('amount', '>=', $googlemeet->paid_meeting_price)
                            ->exists();
                            @endphp

                            @if($googlemeet->paid_meeting_price && !$isPaid)
                            <p class="meeting-owner btm-10">{{ __('Price')
                                }}:{{ currency($googlemeet->paid_meeting_price,
                                $from = $currency->code, $to =
                                Session::has('changed_currency') ?
                                Session::get('changed_currency') :
                                $currency->code, $format = true) }}
                            </p>
                            <form action="{{ route('checkoutmeeting') }}" method="GET">
                                <input type="hidden" name="meeting_id" value="{{ $googlemeet->id }}">
                                <input type="hidden" name="type" value="googlemeet">
                                <button type="submit" class="btn btn-primary">{{
                                    __('Checkout') }}</button>
                            </form>
                            @else
                            <div class="about-home-btn btm-20">
                                <a href="{{ $googlemeet->meet_url }}" target="_blank" class="btn btn-secondary">{{
                                    __('Join Meeting')}}</a>
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
                            {!! $googlemeet->agenda !!}
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</section> --}}


<!-- course detail end -->
@endsection