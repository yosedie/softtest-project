@extends('theme.master')
@section('title', 'Flash Deals')
@section('content')

@include('admin.message')


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
                        <h1 class="wishlist-home-heading">{{ __('Flash Deals') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($deals!= NULL)
<section id="learning-courses" class="learning-courses-main-block">
    <div class="container-xl">
        <div class="row">
        	@foreach($deals as $deal)
            @if($deal->status == '1')
        	
                <div class="col-lg-3 col-md-6">
                    <div class="view-block">
                        <div class="view-img">
                            @if($deal['background_image'] !== NULL && $deal['background_image'] !== '')
                                <a href="{{ route('deal.items',$deal->id) }}"><img src="{{ asset('images/flashdeals/'.$deal->background_image) }}" class="img-fluid" alt="{{ __('course')}}">
                            @else
                                <a href="{{ route('deal.items',$deal->id) }}"><img src="{{ Avatar::create($deal->title)->toBase64() }}" class="img-fluid" alt="{{ __('course')}}">
                            @endif
                            </a>
                        </div>
                        
                        <div class="view-dtl flash-deal-block">
                            <div class="view-heading"><a href="{{ route('deal.items', $deal->id) }}">{{ str_limit($deal->title, $limit = 35, $end = '...') }}</a></div>
                            <p class="btm-10"><a href="#"><span>{{ __('Sale Start Date') }}: </span> {{ date('jS F Y', strtotime($deal->start_date)) }}</a></p>

                            <p class="btm-10"><a href="#"><span>{{ __('Sale End Date') }}: </span> {{ date('jS F Y', strtotime($deal->end_date)) }}</a></p>
                          
                            
                        </div>
                    </div>
                    <div class="wishlist-action">
                        <div class="row">
                        	<div class="col-md-12 col-12">
                        		<div class="flash-button">
                               		<a href="{{ route('deal.items',$deal->id) }}" class="btn btn-primary"><i data-feather="eye"></i></a>
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
@else
<section id="search-block" class="search-main-block search-block-no-result text-center">
    <div class="container-xl">
        <div class="no-result-img btm-20">
            <img src="{{ url('/images/no-result.jpg') }}" class="img-fluid" alt="{{ __('no-result')}}">
        </div>
        <div class="no-result-courses btm-10">{{ __('No Deals Found') }}</div>
        <div class="recommendation-btn text-white text-center">
            <a href="{{ url('/') }}" class="btn btn-primary" title="search"><b>{{ __('Browse') }}</b></a>
        </div> 
    </div>
</section>
@endif
@endsection