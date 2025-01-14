@extends('theme2.master')
@section('title', 'Batch')
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
                        <h2>{{__('Batch')}}</h2>    
                    </div>
                </div>
            </div>
            <div class="breadcrumb-wrap2">
                  <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('Batch')}}</li>
                        </ol>
                    </nav>
                </div>
            
        </div>
    </div>
</section>
<!-- breadcrumb-area-end -->
 <section id="batch" class="batch-main-block">
<div class="container">
    <div class="row"> 
        @foreach($data as $datas)
        <div class="col-lg-4 col-md-6 ">
        <div class="courses-item mb-30 hover-zoomin">
            <div class="thumb fix">
                <a href="{{ route('batch.frontdetail',$datas->slug) }}"><img src="{{ asset('images/batch/'.$datas->preview_image) }}" alt="contact-bg-an-01"></a>
            </div>
            <div class="courses-content">                                    
                <div class="view-user-img">
                    <a href="{{route('all/profile',$datas->user->id)}}" title="{{ $datas->title }}">
                        @if($datas->user['user_img'] !== NULL && $datas->user['user_img'] !== '')
                        <img src="{{ asset('images/user_img/'.$datas->user['user_img']) }}" class="img-fluid user-img-one" alt="{{ $datas->title }}">
                        @else
                        <img src="{{ Avatar::create($datas->title)->toBase64() }}" alt="img">
                        @endif
                    </a>
                 </div>                                
                <h3><a href="{{ route('batch.frontdetail',$datas->slug) }}"> {{ $datas->title }}</a></h3>
                <p>{{substr(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($datas->detail))), 0, 120)}}</p>
                <a href="{{ route('batch.frontdetail',$datas->slug) }}" class="readmore">{{__('View More')}}<i class="fal fa-long-arrow-right"></i></a>
            </div>
            <div class="icon">
                <img src="{{url('frontcss/img/icon/cou-icon.png')}}" alt="img">
            </div>
        </div>
        </div>
        @endforeach
    </div>
</div>
 </section>
@endsection