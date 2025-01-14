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
<section id="alumini" class="alumini-main-block">
    <div class="container-xl">
        <div class="row">
            @foreach($alumini as $data)
            <div class="col-lg-3 col-md-4">
                <div class="alumini-block">
                    <div class="alumini-img">
                        @if($data->user['user_img'] == !NULL)
                        <img src="{{ asset('images/user_img/'.$data->user['user_img']) }}" class="img-fluid" alt="{{$data->user->fname}}">
                        @else
                        <img src="{{ Avatar::create($data->user->fname)->toBase64() }}" class="img-fluid" alt="{{$data->user->fname}}">
                        @endif  
                        <div class="instructor-home-hover-icon">
                            <ul>
                                <li>
                                    <div class="instructor-home-btn">
                                        <a href="{{ url('footer/update',$data->id) }}" class="btn btn-primary" title="View Page"><i data-feather="eye"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="alumini-dtl text-center">
                        <h5 class="alumini-heading mb-2">{{ $data->user->fname }} {{ $data->user->lname }}</h5>
                        <div class="alumini-email mb-2">{{ $data->user->email }}</div>
                        <div class="alumini-no mb-2">{{ $data->user->mobile }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection