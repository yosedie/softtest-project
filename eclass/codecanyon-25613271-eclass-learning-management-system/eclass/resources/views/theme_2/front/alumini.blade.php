@extends('theme.master')
@section('title', 'Aumini')
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
                        <h1 class="wishlist-home-heading">{{ __('Alumini') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@if(isset($alumini))
<section id="user-alumini" class="user-alumini-main-block profile-item-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-4">
                <div class="dashboard-author-block text-center">
                    <div class="author-image">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type='file' id="imageUpload" name="user_img" accept=".png, .jpg, .jpeg" />
                                <label for="imageUpload"><i class="fa fa-pencil"></i></label>
                            </div>
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
                </div>
                <div class="dashboard-items">
                    <ul>
                        <li>
                            <i class="fa fa-bookmark"></i>
                            <a href="{{ route('mycourse.show') }}" title="{{ __('My Courses')}}">{{ __('My Courses') }}</a>
                        </li>
                        <li>
                            <i class="fa fa-heart"></i>
                            <a href="{{ route('wishlist.show') }}" title="{{ __('My wishlist')}}">{{ __('My Wishlist') }}</a>
                        </li>
                        <li>
                            <i class="fa fa-history"></i>
                            <a href="{{ route('purchase.show') }}" title="{{ __('Purchase History')}}">{{ __('Purchase History') }}</a>
                        </li>
                        <li>
                            <i class="fa fa-user"></i>
                            <a href="{{route('profile.show',Auth::User()->id)}}" title="{{ __('User Profile')}}">{{ __('User Profile') }}</a>
                        </li>
                        @if(Auth::User()->role == "user")
                        <li>
                            <i class="fas fa-chalkboard-teacher"></i>
                            <a href="#" data-toggle="modal" data-target="#myModalinstructor" title="{{ __('Become An Instructor') }}">{{ __('Become An Instructor') }}</a>
                        </li>
                        @endif
                        <li>
                            <i class="fa fa-bank"></i>
                            <a href="{{ url('bankdetail') }}" title="{{ __('My Bank Details') }}">{{ __('My Bank Details') }}</a>
                        </li>

                        <li>
                            <i class="fa fa-check"></i>
                            <a href="{{ route('2fa.show') }}" title="{{ __('2 Factor Auth') }}">{{ __('2 Factor Auth') }}</a>
                        </li>
                        <li>
                            <i class="fa fa-check"></i>
                            <a href="{{ route('verifaction') }}" title="{{ __('Verifaction') }}">{{ __('Verifaction') }}</a>
                        </li>
                        {{-- @if(Auth::User()->role == "user") --}}
                        <li>
								<i class="fas fa-user"></i>
								<a href="{{ route('front.alumini') }}" title="{{ __('Alumini') }}">{{ __('Alumini') }}</a>
							</li>
                        {{-- @endif --}}
                    </ul>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-8">
                <div class="profile-info-block">
                    <div class="alumini-msg">
                        <p>{{ __('You are selected for Alumni.
                            Do you want to describe yourself as alumni so keep the status and update the url...') }}</p>
                    </div>
                    <form action="{{ route('alumini.update',$alumini->user_id) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}                        
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-12">
                                <div class="aluimini-url-field">                                    
                                    <div class="form-group">
                                        <label>{{ __('Please Enter Your Url') }}</label>
                                        <input type="url" class="form-control" id="exampleInputUrl" name="url" value="{{ $alumini->url }}" aria-describedby="urlHelp" placeholder="Enter Url">
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="alumini-switch-block">
                                    <h5 class="alumini-switch">{{ __('Status') }}</h5>
                                    <label class="switch">
                                        <input type="checkbox" name="status"  {{ optional($alumini)->status == 1 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" title="upload items">{{ __('Update') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection
