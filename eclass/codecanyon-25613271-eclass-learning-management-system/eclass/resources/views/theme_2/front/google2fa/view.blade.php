@extends('theme2.master')
@section('title', '2FA')
@section('content')

@include('admin.message')
@include('sweetalert::alert')

<!-- about-home start -->
@php
$gets = App\Breadcum::first();
@endphp
@if(isset($gets)) 

<section id="business-home" class="business-home-main-block" >
    <div class="business-img">
        @if($gets['img'] !== NULL && $gets['img'] !== '')
        <img src="{{ url('/images/breadcum/'.$gets->img) }}" class="img-fluid" alt="{{$gets->text}}" />
        @else
        <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="course"
            class="img-fluid">
        @endif
    </div>
    <div class="overlay-bg"></div>
    <div class="container-xl">
        <div class="business-dtl">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="bredcrumb-dtl">
                        <h1 class="">{{ __('Two Factor Authentication') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>  
@endif
<!-- profile update start -->
<section id="profile-item" class="profile-item-block factor-page">
    <div class="container-xl">

        <div class="row">
           
            <div class="col-xl-12 col-lg-12">

            	       <p>{{ __('Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.')}}</p>

                        @if($QR_Image == '')

                         
						<form action="{{ route('generate2faSecret') }}" method="POST">
							@csrf
							
							<div class="form-group">
								<button type="submit" class="btn btn-primary">
									{{ __('Generate Secret Key to Enable 2FA') }}
								</button>
							</div>

						</form>

                        @endif

                        @if($QR_Image != '' )

                        1. {{ __('Scan this QR code with your Google Authenticator App')}}. <code></code>
                        <br/>

                        <br/>

						<div>
                        	<img src="{!! $QR_Image !!}">
                    	</div>
                        @endif

                        <br/><br/>

                    	
                        @if(Auth::user()->google2fa_secret != '' && Auth::user()->google2fa_enable == 0 )
                        2. {{ __('Enter the pin from Google Authenticator app')}}:<br/><br/>
						<form class="form-horizontal" method="POST" action="{{ route('enable2fa') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="one_time_password" class="col-md-4 control-label">{{ __('One Time Password')}}</label>

                            <div class="col-md-6">
                                <input id="one_time_password" type="number" class="form-control" name="one_time_password" required autofocus>
                            </div>
                        </div>

                       



                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login')}}
                                </button>
                            </div>
                        </div>
                    </form>


                     @endif

                     @if(Auth::user()->google2fa_enable == 1)

                     <div class="alert alert-success">
                                {{ __('2FA is currently')}} <strong>{{ __('enabled')}}</strong> {{ __('on your account')}}.
                            </div>
                            <p>{{ __('If you are looking to disable Two Factor Authentication. Please confirm your password and Click Disable 2FA Button.')}}</p>

                            <form class="form-horizontal" method="POST" action="{{ route('disable2fa') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                    <label for="change-password" class="control-label">{{__('Current Password')}}</label>
                                        <input id="current-password" type="password" class="form-control col-md-4" name="current-password" required>
                                        @if ($errors->has('current-password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                        </span>
                                        @endif
                                </div>
                                <button type="submit" class="btn btn-primary ">{{ __('Disable 2FA')}}</button>
                            </form>

                            @endif
					
            </div>
        </div>
    </div>
</section>
<!-- profile update end -->
@endsection

@section('custom-script')


@endsection
