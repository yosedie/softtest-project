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
                        <h1 class="wishlist-home-heading">{{ __('Our Services') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- breadcumb end -->
@if(isset($services))
<section id="services" class="services-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="service-side-img">
                    @if($serv['image'] == !NULL)
                    <img src="{{ asset('images/services/'.$serv['image']) }}" class="img-fluid" alt="{{$serv->title}}">
                    @else
                    <img src="{{ Avatar::create($serv->title)->toBase64() }}" class="img-fluid" alt="{{$serv->title}}">
                    @endif                    <div class="overlay-bg"></div>
                </div>
                <div class="service-side-dtl text-center">
                    <h3 class="service-heading mb-4">{{ $serv->title }}</h3>
                    <p class="mb-4">{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($serv->detail))) , $limit = 300, $end = '...') }}</p>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="row">
                    @foreach($services as $ser)
                    <div class="col-lg-4 col-md-6">
                        <div class="service-block">
                            <div class="service-img text-center">
                                @if($ser['image'] == !NULL)
                                    <img src="{{ asset('images/services/'.$ser['image']) }}" class="img-fluid" alt="{{$ser->title}}">
                                @else
                                    <img src="{{ Avatar::create($ser->title)->toBase64() }}" class="img-fluid" alt="{{$ser->title}}">
                                @endif
                            </div>
                            <div class="service-dtl text-center">
                                <h5 class="service-heading mb-2">{{ $ser->title }}</h5>
                                <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($ser->detail))) , $limit = 80, $end = '...') }}</p>
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
@endsection