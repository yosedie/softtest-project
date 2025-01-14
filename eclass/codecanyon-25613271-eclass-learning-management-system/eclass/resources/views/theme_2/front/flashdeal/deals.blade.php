@extends('theme2.master')
@section('title', 'Flash Deals')
@section('content')
@include('admin.message')
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
                        <h2>{{ __('Flash Deal ') }}</h2>    
                        
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
@if($deals!= NULL)
<section class="flash-deal-main-block pt-120 pb-120 p-relative fix">
    <div class="container">
        <div class="row">   
            @foreach($deals as $deal)
            @if($deal->status == '1')                  
            <div class="col-lg-4 col-md-6 ">
                <div class="courses-item mb-30 hover-zoomin">
                    <div class="thumb fix">
                        @if($deal['background_image'] !== NULL && $deal['background_image'] !== '')
                        <a href="{{ route('deal.items',$deal->id) }}"><img src="{{ asset('images/flashdeals/'.$deal->background_image) }}" alt="contact-bg-an-01"></a>
                        @else
                        <a href="{{ route('deal.items',$deal->id) }}"><img src="{{ Avatar::create($deal->title)->toBase64() }}" alt="contact-bg-an-01"></a>
                        @endif
                        <div class="courses-icon">
                            <ul>
                                <li><a href="{{ route('deal.items',$deal->id) }}" class="" title="notification" tabindex="0"><i data-feather="eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="courses-content">
                        <h3><a href="{{ route('deal.items', $deal->id) }}">{{ str_limit($deal->title) }}</a></h3>
                        <p class="card-text"><b>{{__('Sale Start Date:')}}</b>{{ date('jS F Y', strtotime($deal->start_date)) }}</p>
                        <p class="card-text"><b>{{__('Sale End Date:')}}</b>{{ date('jS F Y', strtotime($deal->end_date)) }}</p>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection



































































