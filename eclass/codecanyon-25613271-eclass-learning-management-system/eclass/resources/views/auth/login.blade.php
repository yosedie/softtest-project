@extends('theme.master')
@section('title', 'Login')
@section('content')
@include('admin.message')
<!-- Signup start-->
<section id="signup" class="signup-block-main-block">
    <div class="container">
        <div class="login-signup">
            <div class="row no-gutters">
                <div class="col-lg-6 col-md-6">
                    <div class="signup-side-block">
                        <img src="{{ url('images/login/login.png')}}" class="img-fluid" alt=" {{ $gsetting->text }}">
                        <div class="login-img">
                            <img src="{{ url('/images/login/'.$gsetting->img) }}" class="img-fluid" alt=" {{ $gsetting->text }}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="signup-heading">
                     
                        {{ $gsetting->text }}
                        <div class="signup-block">
                            <form method="POST" class="signup-form" action="{{ route('login') }}">
                                @csrf
                             
                                <div class="form-group">
                                    <i data-feather="mail"></i>
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Enter Your E-Mail"   name="email" value="{{ old('email') }}" required autofocus>
                                    
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <i data-feather="lock"></i>
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Enter Your Password" name="password"  required>
                                    <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <div class="form-group">                       
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <div class="forgot-password text-right btm-20"><a href="{{ 'password/reset' }}" title="sign-up">{{ __('Forgot Password') }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit"  class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </form>

                            <div class="social-link btm-10">
                                <h2><span>Or Sign Up Using</span></h2>
                                <div class="row">
                                    @if($gsetting->fb_login_enable == 1)
                                    <div class="col-lg-2 col-4">
                                        <a href="{{ url('/auth/facebook') }}" target="_blank" title="facebook" class="social-icon facebook-icon" title="Facebook"><i class="fa fa-facebook"></i></a>
                                    </div>
                                    @endif

                                    @if($gsetting->google_login_enable == 1)
                                    <div class="col-lg-2 col-4">
                                        <div class="google">
                                            <a href="{{ url('/auth/google') }}" target="_blank" title="google" class="social-icon google-icon" title="google"><i class="fab fa-google-plus-g"></i></a>
                                        </div>
                                    </div>
                                    @endif

                                    @if($gsetting->amazon_enable == 1)
                                    <div class="col-lg-2 col-4">
                                        <div class="signin-link amazon-button">
                                            <a href="{{ url('/auth/amazon') }}" target="_blank" title="amazon" class="social-icon amazon-icon" title="Amazon"><i class="fab fa-amazon"></i></a>
                                        </div>
                                    </div>
                                    @endif

                                    @if($gsetting->linkedin_enable == 1)
                                    <div class="col-lg-2 col-4"> 
                                        <div class="signin-link linkedin-button">
                                            <a href="{{ url('/auth/linkedin') }}" target="_blank" title="linkedin" class="social-icon linkedin-icon" title="Linkedin"><i class="fab fa-linkedin"></i></a>
                                        </div>
                                    </div>
                                    @endif

                                    @if($gsetting->twitter_enable == 1)
                                    <div class="col-lg-2 col-4">
                                        <div class="signin-link twitter-button">
                                            <a href="{{ url('/auth/twitter') }}" target="_blank" title="twitter" class="social-icon twitter-icon" title="Twitter"><i class="fab fa-twitter"></i></a>
                                        </div>
                                    </div>
                                    @endif

                                    @if($gsetting->gitlab_login_enable == 1)
                                    <div class="col-lg-2 col-4">
                                        <div class="signin-link btm-10">
                                            <a href="{{ url('/auth/gitlab') }}" target="_blank" title="gitlab" class="social-icon gitlab-icon" title="gitlab"><i class="fab fa-gitlab"></i></a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            {{-- <div class="login-options">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="social-link">
                                            <a href="#" title="{{ __('Admin') }}"
                                                onclick="switchUserType('admin')">{{ __('Admin') }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="social-link">
                                            <a href="#" title="{{ __('User') }}" onclick="switchUserType('user')">{{
                                                __('User') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="sign-up text-center">{{ __('Do not have an account') }}?<a href="{{ url('registers') }}" title="sign-up"> {{ __('Signup') }}</a>
                            </div>
                            <hr>
                            <div class="signin-link text-center">
                               {{ __('By signing up') }} <a href="{{url('terms_condition')}}" title="Policy">{{ __('Terms & Condition') }} </a>, <a href="{{url('privacy_policy')}}" title="Policy">{{ __('Privacy Policy') }}.</a>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!--  Signup end-->
@endsection
@section('custom-script')
<script>
    function switchUserType(userType) {
        var emailInput = document.getElementById('email');
        var passwordInput = document.getElementById('password');

        if (userType === 'admin') {
            emailInput.value = 'admin@mediacity.co.in';
            passwordInput.value = '123456';
        } else if (userType === 'user') {
            emailInput.value = 'user@mediacity.co.in';
            passwordInput.value = '123456';
        }

        document.getElementById('user_type').value = userType;
    }

    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }
</script>
@endsection