@extends('theme2.master')
@section('title', 'Sign Up')
@section('content')
@include('admin.message')
<!-- Start Register -->
    <section id="register" class="login-main-block register-main-block">
        <div class="login-block">
            <div class="row">
                <div class="col-lg-6 col-md-5">
                    <div class="register-image">
                        <img src="{{ url('/images/login/'.$gsetting->img) }}" alt="img">
                    </div>
                </div>
                <div class="col-lg-6 col-md-7">
                    <div class="logo">
                        <a href="{{route('home')}}" title="{{ __('logo')}}"><img src="{{ asset('images/logo/'.$gsetting->logoe) }}" alt="Logo" class="img-fluid"></a>
                    </div>
                    <h4 class="container-heading">{{ __('Create an account') }}</h4>
                    <div class="register-dtls">
                        <form class="contact-form-block" method="POST" action="{{ route('register') }}">
                            @csrf
                        
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        
                                        <input type="text" class="form-control{{ $errors->has('fname') ? ' is-invalid' : '' }}" name="fname" value="{{ old('fname') }}" id="fname" placeholder="First Name">
                                        @if ($errors->has('fname'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        
                                        <input type="text" class="form-control{{ $errors->has('lname') ? ' is-invalid' : '' }}" name="lname" value="{{ old('lname') }}" id="lname" placeholder="Last Name">
                                        @if($errors->has('lname'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('lname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        
                                        <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" id="email" placeholder="Email">
                                        @if($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    @if($gsetting->mobile_enable == 1)
                                    <div class="form-group">
                                        
                                        <input type="text" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{ old('mobile') }}" id="mobile" placeholder="Mobile">
                                        @if($errors->has('mobile'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('mobile') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        
                                        <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password" placeholder="Password">
                                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <span toggle="#password-confirm" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                                    </div>
                                </div>
                            </div>
                            @if($gsetting->captcha_enable == 1)
                                <div class="{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                    <div class="text-center">
                                        {!! app('captcha')->display() !!}
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="term" id="term" required>

                                    <label class="form-check-label" for="term">
                                        <div class="signin-link text-center btm-20">
                                            <b>{{ __('I agree to ') }}<a href="{{url('terms_condition')}}" title="Policy">{{ __('Terms&Condition') }} </a>, <a href="{{url('privacy_policy')}}" title="Policy">{{ __('PrivacyPolicy') }}.</a></b>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="login-options">
                                    <ul>
                                        <li><button type="submit" class="btn btn-primary create-btn" title="{{ __('Sign Up') }}">{{ __('Sign Up') }}</button></li>
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
                            </div>
                        </form> 
                        </div> 
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="sign-up already-account">{{ __('Already have an account ') }}? <a href="{{ route('login') }}" title="{{ __('Login') }}" target="_blank">{{ __('Login') }}</a>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </section>          
    <!-- End Register -->
    @endsection


