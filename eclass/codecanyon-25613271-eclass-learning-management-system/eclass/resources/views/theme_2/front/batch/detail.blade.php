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
                        <h2>{{__('Batch Detail') }}</h2> 
                        
                    </div>
                </div>
            </div>
            <div class="breadcrumb-wrap2">
                  
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('Batch Detail')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb-area-end -->
<section class="courses pt-120 pb-120 p-relative fix">
    <div class="container">
        <div class="courses-item mb-30 hover-zoomin">
            <div class="row align-items-center">
                @foreach($data as $datas)
                    <div class="col-lg-4 col-md-6 text-center ">
                        <div class="thumb fix">
                            <img src="{{ asset('images/batch/'.$datas->preview_image) }}" alt="contact-bg-an-01">
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="courses-content">                                    
                            <h5>{{ $datas->courses->title }}</h5>
                            <div>{{ __('Enrolled User ') }}</div>
                            {{-- <ul>
                                @foreach($datas['allowed_users'] as $key => $Uid)
                                <li> <a href ="{{ route('all/profile',$Uid) }}">{{ App\User::whereId($Uid)->value('fname'); }}</a></li>
                                @endforeach
                            </ul> --}}
                            <p>{{ $datas->detail }}</p>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


