@extends('theme2.master')
@section('title', 'Login')
@section('content')
@include('admin.message')
    <!-- Start Login -->
    <section id="login-page" class="login-main-block">
        <div class="login-block">
            <div class="row">
                <div class="col-lg-6 col-md-7">
                    <div class="logo">
                        <a href="{{route('home')}}" title="{{ __('logo')}}"><img src="{{ asset('images/logo/'.$gsetting->logo) }}" class="img-fluid" alt="{{ __('logo')}}"></a>
                    </div>
                    <h4 class="container-heading">{{ __('Welcome Back') }}</h4>
                    <h6 class="login-heading">{{ __('Sign in to continue') }}</h6>
                    <form action="{{ url('login') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <input class="form-control form-control-lg email" type="email" name="email" placeholder="Email" aria-label="">
                        </div>
                        <div class="form-group mb-3">
                            <input id="password" class="form-control form-control-lg" name="password" type="Password" placeholder="Password" aria-label="">
                            <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        <div class="login-options">
                            <ul>
                                <li><button type="submit" class="btn btn-primary create-btn" title="{{ __('Sign In') }}">{{ __('Sign In') }}</button></li>
                            </ul>
                        </div>
                        <div class="login-options">
                            <ul>
                                <!-- <li><button type="submit" class="btn btn-primary create-btn" title="Sign Up">Sign Up</button></li> -->
                                @if($gsetting->google_login_enable == 1)
                                <li class="google">
                                    <a href="{{ url('/auth/google') }}" target="_blank" title="google">
                                        <img src="images/login/google.png" alt="{{ is_string(__('google')) ? __('google') : 'Google' }}" class="img-fluid">
                                    </a>
                                </li>
                                @endif

                                @if($gsetting->fb_login_enable == 1)
                                <li class="facebook">
                                    <a href="{{ url('/auth/facebook') }}" target="_blank" title="facebook">
                                        <img src="images/login/facebook.png" alt="{{ is_string(__('facebook')) ? __('facebook') : 'Facebook' }}" class="img-fluid">
                                    </a>
                                </li>
                                @endif

                                @if($gsetting->amazon_enable == 1)
                                <li class="amazon">
                                    <a href="{{ url('/auth/amazon') }}" target="_blank" title="amazon">
                                        <img src="images/login/amazon.png" alt="{{ is_string(__('Amazon')) ? __('Amazon') : 'Amazon' }}" class="img-fluid">
                                    </a>
                                </li>
                                @endif

                                @if($gsetting->linkedin_enable == 1)
                                <li class="linkedin">
                                    <a href="{{ url('/auth/linkedin') }}" target="_blank" title="linkedin">
                                        <img src="images/login/linkedin.png" alt="{{ is_string(__('Linkedin')) ? __('Linkedin') : 'LinkedIn' }}" class="img-fluid">
                                    </a>
                                </li>
                                @endif

                                @if($gsetting->twitter_enable == 1)
                                <li class="twitter">
                                    <a href="{{ url('/auth/twitter') }}" target="_blank" title="twitter">
                                        <img src="images/login/twitter.png" alt="{{ is_string(__('Twitter')) ? __('Twitter') : 'Twitter' }}" class="img-fluid">
                                    </a>
                                </li>
                                @endif

                                @if($gsetting->gitlab_login_enable == 1)
                                <li class="gitlab">
                                    <a href="{{ url('/auth/gitlab') }}" target="_blank" title="gitlab">
                                        <img src="images/login/github.png" alt="{{ is_string(__('Gitlab')) ? __('Gitlab') : 'GitLab' }}" class="img-fluid">
                                    </a>
                                </li>
                                @endif

                            </ul>
                        </div>
                    </form>
                    <br>
                    <div class="forgot-pass"><a href="{{ 'password/reset' }}" title="{{ __('Forgot Password') }}">{{ __('Forgot Password') }}?</a></div>
                   
                    <div class="sign-up">{{ __('Do not have an account') }}?  <a href="{{ url('registers') }}" title="{{ __('Sign up') }}" target="_blank">{{ __('Sign up') }}</a></div>
                </div>
                <div class="col-lg-6 col-md-5">
                    <div class="login-img">
                        <img src="{{ url('/images/login/'.$gsetting->img) }}" class="img-fluid" alt="img">    
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- End Login -->
    @endsection