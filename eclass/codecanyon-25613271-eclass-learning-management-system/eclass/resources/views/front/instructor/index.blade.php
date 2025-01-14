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
        <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="{{ __('course')}}" class="img-fluid">
        @endif
    </div>
    <div class="overlay-bg"></div>
    <div class="container-xl">
        <div class="business-dtl">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bredcrumb-dtl">
                        <h1 class="wishlist-home-heading">{{ __('All Instructors') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif  
<!-- breadcumb end -->
<!-- instructor start -->
@if(isset($instructors))
<section id="instructor-home" class="instructor-home-main-block instructor-page">
    <div class="container-xl">
        <div class="row">
            @foreach($instructors as $inst)
        	<div class="col-lg-3 col-md-6">
                <div class="instructor-home-block text-center">
                    <div class="instructor-home-block-one">
                        <a href="{{ route('allinstructor/profile',$inst->id) }}" title="{{ $inst->fname }}">
                            @if($inst['user_img'] !== NULL && $inst['user_img'] !== '')
                                <img src="{{ url('/images/user_img/'.$inst['user_img']) }}" class="img-fluid" />
                            @else
                                <img src="{{ Avatar::create($inst->fname)->toBase64() }}" alt="course" class="img-fluid">
                            @endif
                        </a>
                        <div class="instructor-home-hover-icon">
                            <ul>
                                <li>
                                    <div class="tooltip">
                                        <div class="tooltip-icon">
                                            <i data-feather="share-2"></i>
                                        </div>
                                        <span class="tooltiptext">
                                            <div class="instructor-home-social-icon">
                                                <ul>
                                                    @php
                                                        $url = URL::to('/').'/allinstructor/profile/'.$inst->id;
                                                    @endphp
                                                    <li><a href="http://www.linkedin.com/shareArticle?mini=true&url={{ $url }}&title=Default+share+text&summary=" target="_blank"><b><i class="fa fa-linkedin" aria-hidden="true"></i></b></a></li>
                                                    <li><a href="https://www.facebook.com/sharer/sharer.php?&url={{ $url }}" target="_blank"><b><i class="fa fa-facebook-square" aria-hidden="true"></i></b></a></li>
                                                    <li><a href="https://twitter.com/intent/tweet?text=Default+share+text&url={{ $url }}" target="_blank"><b><i class="fa fa-twitter" aria-hidden="true"></i></b></a></li>
                                                    <li><a href="https://telegram.me/share/url?url={{ $url }}&text=Default+share+text" target="_blank"><b><i class="fa fa-telegram" aria-hidden="true"></i></b></a></li>
                                                    <li><a href="https://wa.me/?text={{ $url }}" target="_blank"><b><i class="fa fa-whatsapp" aria-hidden="true"></i></b></a></li>
                                                </ul>
                                            </div>
                                        </span>
                                    </div>
                                </li> 
                                <li>
                                    <div class="instructor-home-btn">
                                        <a href="{{ route('allinstructor/profile',$inst->id) }}" class="btn btn-primary" title="View Profile"><i data-feather="eye"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </div>  
                        <div class="instructor-home-dtl">
                            <h4 class="instructor-home-heading">
                                <a href="{{ route('allinstructor/profile',$inst->id) }}" title="{{ $inst->fname }}">{{ $inst->fname }} {{ $inst->lname }}</a>
                            </h4>
                            <p>{{ $inst->role }}</p>
                            @php
                                $followers = App\Followers::where('user_id', '!=', $inst->id)->where('follower_id', $inst->id)->count();
                                $followings = App\Followers::where('user_id', $inst->id)->where('follower_id','!=', $inst->id)->count();
                                $course = App\Course::where('user_id', $inst->id)->count();
                            @endphp
                            <div class="instructor-home-info">
                                <ul>
                                    <li>{{ $course > 0 ? $course.' '.__('Courses') : __('No Courses') }}</li>
                                    <li>{{ $followers }} {{ __('Follower') }}</li>
                                    <li>{{ $followings }} {{ __('Following') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- instructor end -->
@endsection