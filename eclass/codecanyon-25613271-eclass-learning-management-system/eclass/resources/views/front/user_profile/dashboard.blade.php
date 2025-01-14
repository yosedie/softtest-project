@extends('theme.master')
@section('title', 'Profile & Setting')
@section('content')

@include('admin.message')


<!-- about-home start -->
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
                        <h1 class="wishlist-home-heading">{{ __('Dashboard') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- profile update start -->
<section id="profile-item" class="profile-item-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="dashboard-author-block text-center">
                    <div class="author-image">
					    <div class="avatar-upload">
					        
					        <div class="avatar-preview">
					        	@if(Auth::User()->user_img != null || Auth::User()->user_img !='')
						            <div class="avatar-preview-img" id="imagePreview" style="background-image: url({{ url('/images/user_img/'.Auth::User()->user_img) }});">
						            </div>
						        @else
						        	<div class="avatar-preview-img" id="imagePreview" style="background-image: url({{ asset('images/default/user.jpg')}});">
						            </div>
						        @endif
					        </div>
					    </div>
                    </div>
                    <div class="author-name">{{ Auth::User()->fname }}&nbsp;{{ Auth::User()->lname }}</div>

                    @php

            		$followers = App\Followers::where('user_id', '!=', $user->id)->where('follower_id', $user->id)->count();

            		$followings = App\Followers::where('user_id', $user->id)->where('follower_id','!=', $user->id)->count();

            		@endphp

                    <div class="instructor-follower">
                		<div class="followers-status">
                            <span class="followers-value">{{ $followers }}</span>
                            <span class="followers-heading">{{__('Followers')}}</span>
                        </div>
                		<div class="following-status">
                            <span class="followers-value">{{ $followings }}</span>
                            <span class="followers-heading">{{__('Following')}}</span>
                        </div>
                    </div>

                </div>
                <div class="dashboard-items">
                    <ul>

                        @php
                        $fullname = isset($user['fname']) . ' ' . isset($user['lname']);
                        $fullname = preg_replace('/\s+/', '', $fullname);
                        @endphp

                        <li>
                            <i class="fa fa-bookmark"></i><a href="{{ route('instructor.profile', ['id' => $user->id, 'name' => $fullname] ) }}" title="{{ __('Dashboard')}}">{{ __('My Profile') }}</a>
                        </li>

                        <li>
                            <i class="fa fa-bookmark"></i><a href="{{ route('mycourse.show') }}" title="{{ __('My Courses')}}">{{ __('MyCourses') }}</a>
                        </li>
                        
                        <li>
                            <i class="fa fa-heart"></i><a href="{{ route('get.affiliate') }}" title="{{ __('Marketing')}}">{{ __('Marketing') }}</a>
                        </li>
                        
                        <li>
                            <i class="fa fa-bank"></i><a href="{{route('profile.show',Auth::User()->id)}}" title="{{ __('Settings')}}">{{ __('Settings') }}</a>
                        </li>

                        <li>
                            <i class="fa fa-check"></i>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
                                    @csrf
                                </form>   
                            </a>
                        </li>

                         
                    </ul>
                </div>
            </div>
            
            <div class="col-xl-9 col-lg-8">

            </div>
        </div>

    </div>
</section>
<!-- profile update end -->
@endsection

@section('custom-script')

<script>
(function($) {
  "use strict";
	function readURL(input) {
	if (input.files && input.files[0]) {
	    var reader = new FileReader();
	    reader.onload = function(e) {
	        $('#imagePreview').css('background-image', 'url('+e.target.result +')');
	        $('#imagePreview').hide();
	        $('#imagePreview').fadeIn(650);
	    }
	    reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imageUpload").change(function() {
	    readURL(this);
	});
})(jQuery);
</script>


@endsection
