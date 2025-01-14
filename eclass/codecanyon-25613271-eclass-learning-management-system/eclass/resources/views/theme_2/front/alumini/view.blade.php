@extends('theme2.master')
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
                        <h1 class="wishlist-home-heading">{{ __('Alumini') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- breadcumb end -->
@if(isset($alumini))
<section id="alumini" class="alumini-main-block alumini-profile-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <div class="alumini-profile-block text-center">
                    <div class="alumini-profile-img">
                        @if($alumini->user['user_img'] == !NULL)
                        <img src="{{ asset('images/user_img/'.$alumini->user['user_img']) }}" class="img-fluid" alt="{{$alumini->user->fname}}">
                    @else
                        <img src="{{ Avatar::create($alumini->user->fname)->toBase64() }}" class="img-fluid" alt="{{$alumini->user->fname}}">
                    @endif                      </div>
                    <div class="alumini-dtl text-center">
                        <h5 class="alumini-heading mb-2">{{ $alumini->user->fname }}</h5>
                        <div class="alumini-email mb-2">{{ $alumini->user->email }}</div>
                        <div class="alumini-no mb-2">{{ $alumini->user->mobile }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="alumini-profile-video">
                    <div class="video-item hidden-xs">
                        <script type="text/javascript">
                            var video_url = '<iframe src="{{ $alumini->url }}" frameborder="0" allowfullscreen></iframe>';
                        </script>

                        <div class="video-device">
                            @if($alumini->user['user_img'] == !NULL)
                            <img src="{{ asset('images/user_img/'.$alumini->user['user_img']) }}" class="img-fluid bg_img" alt="{{$alumini->user->fname}}">
                        @else
                            <img src="{{ Avatar::create($alumini->user->fname)->toBase64() }}" class="img-fluid bg_img" alt="{{$alumini->user->fname}}">
                        @endif                              <div class="video-preview">
                                <a href="javascript:void(0);" class="btn-video-play"><i class="fa fa-play"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection