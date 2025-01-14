@extends('theme.master')
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
        <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="{{$gets->text}}"
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
            
                <div class="offset-md-2 col-md-8">

                    <h6><p>{{ __('Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.')}}</p></h6>

                    <div class="card">
                        <div class="card-body">
                            <form action="{{ url('/verify-2fa') }}" method="POST">
                                @csrf
                                
                                <div class="form-group">
                                    <label>{{ __('Enter the pin from Google Authenticator app')}}: <span class="text-danger">*</span></label>
                                    <input required type="password" class="form-control @error('password') is-invalid @enderror " name="password">

                                    @if($errors->any())
                                      <h6 class="text-danger alert alert-error">{{$errors->first()}}</h6>
                                    @endif

                                    @error('password')
										<span class="invalid-feedback text-danger" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror


                                   

                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-primary">
                                        {{__('Login')}}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>
@endsection