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
                        <h1 class="wishlist-home-heading">{{ __('Feature Product') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- breadcumb end -->
@if(isset($feature))
<section id="feature" class="feature-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-7 col-md-7">
                <div class="feature-block">
                    <h4 class="feature-title">{{ $featuresetting->title }}</h4>
                    <p>{{ $featuresetting->detail }}</p>
                </div>
                <div class="feature-dtl-block">
                    <div class="row">
                        @foreach($feature as $data)
                        <div class="col-lg-6 mb-4">
                            <div class="feature-dtl-icon">
                                @if($data['image'] == !NULL)
                                    <img src="{{ asset('images/feature/'.$data['image']) }}" class="img-fluid" alt="{{$data->title}}">
                                @else
                                    <img src="{{ Avatar::create($data->title)->toBase64() }}" class="img-fluid" alt="{{$data->title}}">
                                @endif  
                            </div>    
                            <div class="feature-dtl">
                                <h5 class="feature-dtl-title mb-2">{{ $data->title }}</h5>
                                <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($data->detail))) , $limit = 300, $end = '...') }}</p>                       
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5">
                <div class="feature-image">
                    @if($data['image'] == !NULL)
                    <img src="{{ asset('images/feature/'.$featuresetting['image']) }}" class="img-fluid" alt="{{$featuresetting->title}}">
                @else
                    <img src="{{ Avatar::create($featuresetting->title)->toBase64() }}" class="img-fluid" alt="{{$featuresetting->title}}">
                @endif                 
             </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection