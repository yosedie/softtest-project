@extends('theme.master')
@section('title', 'Support Us')
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
        <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="course" class="img-fluid">
        @endif
    </div>
    <div class="overlay-bg"></div>
    <div class="container-xl">
        <div class="business-dtl">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bredcrumb-dtl">
                        <h1 class="wishlist-home-heading">{{ __('Support us') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- about-home end -->
<!-- contact-us start-->
<section id="contact-us" class="contact-us-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <h4 class="contact-us-heading">{{ __('Generate Support Ticket') }}</h4>
                <form id="demo-form2" method="post" action="{{ route('supportadmin.store') }}" data-parsley-validate
                    class="form-horizontal form-label-left" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                    <div class="form-group">
                        <select class="form-control" id="exampleFormControlSelect1" name="category">
                            @foreach ($supporttype as $type)
                            <option value="{{ $type->id }}">
                                {{ $type->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="exampleFormControlSelect1" name="priority">
                            <option value="Low" selected>{{__('Low')}}</option>
                            <option value="Normal">{{__('Normal')}}</option>
                            <option value="High">{{__('High')}}</option>
                            <option value="Critical">{{__('Critical')}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="subject" id="subject"
                            placeholder="{{ __('Subject')}}">
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control" name="image">
                    </div>

                    <div class="comment btm-20">
                        <textarea id="comment" name="message" rows="6" placeholder="{{ __('Your Message')}}"></textarea>
                    </div>

                    @if($gsetting->captcha_enable == 1)
                    <div class="{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">

                        {!! app('captcha')->display() !!}
                        @if ($errors->has('g-recaptcha-response'))
                        <span class="help-block">
                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                        </span>
                        @endif
                    </div>
                    <br>
                    @endif

                    <div class="contact-form-btn">
                        <button type="submit" class="btn btn-primary" title="Send Message">{{ __('Message') }}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
<!-- Contact us end -->

@endsection