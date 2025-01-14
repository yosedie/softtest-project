@extends('theme.master')
@section('title', "$bbl->meetingname")
@section('content')

@include('admin.message')

@section('meta_tags')

@php
    $url =  URL::current();
@endphp

<meta name="title" content="{{ $bbl['meetingname'] }}">
<meta name="description" content="{{ $bbl['detail'] }} ">
<meta name="author" content="elsecolor">
<meta property="og:title" content="{{ $bbl['meetingname'] }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:description" content="{{ $bbl['detail'] }}">
<meta property="og:image" content="{{ Avatar::create($bbl['meetingname'])->toBase64() }}">
<meta itemprop="image" content="{{ Avatar::create($bbl['meetingname'])->toBase64() }}">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="{{ Avatar::create($bbl['meetingname'])->toBase64() }}">
<meta property="twitter:title" content="{{ $bbl['meetingname'] }} ">
<meta property="twitter:description" content="{{ $bbl['detail'] }}">
<meta name="twitter:site" content="{{ url()->full() }}" />
<link rel="canonical" href="{{ url()->full() }}"/>
<meta name="robots" content="all">
<meta name="keywords" content="{{ $gsetting->meta_data_keyword }}">
    

@endsection

<!-- course detail header start -->
<section id="about-home" class="about-home-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-8">
                <div class="about-home-block text-white">
                    <h1 class="about-home-heading text-white">{{ $bbl['meetingname'] }}</h1>
                    <ul>
                       
                    <ul>
                        <li><a href="#" title="about">{{ __('Created') }}: {{ $bbl->user['fname'] }} </a></li>
                        <li><a href="#" title="about">Start At: {{ date('d-m-Y | h:i:s A',strtotime($bbl['start_time'])) }}</a></li>
                        
                    </ul>
                </div>
            </div>
            <!-- course preview -->
            <div class="col-lg-4">
                
                
                <div class="about-home-product">
                    <div class="video-item hidden-xs">
                       
                        <div class="video-device">
                            <img src="{{ Avatar::create($bbl['meetingname'])->toBase64() }}" class="bg_img img-fluid" alt="Background">
                        </div>
                    </div>
               
                    @php
                    // Ensure $meeting->paid_meeting_price is a number
                    $paidMeetingPrice = (float) $bbl->paid_meeting_price;
                    $isPaid = App\PaidMettings::where('user_id', auth()->id())
                                ->where('meeting_id', $bbl->id)
                                ->where('amount', '>=', $paidMeetingPrice)
                                ->exists();
                    @endphp

                   
                    <div class="about-home-dtl-training">
                        <div class="about-home-dtl-block btm-10">

                            @if(Auth::check())
                            @if($bbl->paid_meeting_price && !$isPaid)
                                <div class="about-home-btn btm-20">
                                    <p class="meeting-owner btm-10">
                                        {{ currency($bbl->paid_meeting_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}
                                    </p>
                                    <form action="{{ route('checkoutmeeting') }}" method="GET">
                                        <input type="hidden" name="meeting_id" value="{{ $bbl->id }}">
                                        <input type="hidden" name="type" value="bbl">
                                        <button type="submit" class="btn btn-primary">{{ __('Checkout') }}</button>
                                    </form>
                                </div>
                                    @else
                                    <div class="about-home-btn btm-20">
                                        <a href="" data-toggle="modal" data-target="#myModalBBL" title="join" class="btn btn-secondary" title="course">{{ __('Join Meeting') }}</a>
                                    </div>
                                    @endif
                                @else
                                    <div class="about-home-btn btm-20">
                                        <a href="{{ route('login') }}" class="btn btn-secondary">{{ __('Join Meeting') }}</a>
                                    </div>
                            @endif
                        
                            <div class="modal fade" id="myModalBBL" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			                    <div class="modal-dialog modal-lg" role="document">
			                      <div class="modal-content">
			                        <div class="modal-header">

			                          <h4 class="modal-title" id="myModalLabel">{{ __('Join Meeting') }}</h4>
			                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                        </div>
			                        <div class="box box-primary">
			                          <div class="panel panel-sum">
			                            <div class="modal-body">
                                             <form action="{{ route('bbl.api.join') }}" method="POST">
                                                 @csrf

                                                <div class="form-group"> 
                                                    <label>{{ __('Meeting ID')}}:</label>
                                                    <input readonly="" type="text" name="meetingid" value="{{ $bbl['meetingid'] }}" class="form-control">
                                                </div>

                                                <div class="form-group"> 
                                                    <label>{{ __('Your Name')}}:</label>
                                                    <input value="{{ old('name') }}" type="text" required="" name="name" placeholder="{{ __('Enter your name')}}" class="form-control">
                                                </div>

                                                <div class="form-group"> 
                                                    <label>{{ __('Meeting Password')}}:</label>
                                                    <input type="password" name="password" placeholder="{{ __('Enter meeting password')}}" class="form-control" required="">
                                                </div>

                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    + {{ __('Start')}}
                                                </button>

                                             </form>
			                            
			                            </div>
			                          </div>
			                        </div>
			                      </div>
			                    </div> 
			                </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- course header end -->
<!-- course detail start -->
<section id="about-product" class="about-product-main-block meetings-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-8">
                <div class="requirements">
                    <h3>{{ __('Detail') }}</h3>
                    <ul>
                        <li class="comment more">
                           
                           {!! $bbl->detail !!}
                           
                        </li>
                       
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
</section>


<!-- course detail end -->
@endsection

