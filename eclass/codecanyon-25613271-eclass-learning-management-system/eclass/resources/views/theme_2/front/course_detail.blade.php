@extends('theme2.master')
@section('title', "$course->title")
@section('content')

@include('admin.message')

@section('meta_tags')

@php
    $url =  URL::current();
@endphp

<meta name="title" content="{{ $course['title'] }}">
<meta name="description" content="{{ $course['short_detail'] }} ">
<meta property="og:title" content="{{ $course['title'] }} ">
<meta property="og:url" content="{{ $url }}">
<meta property="og:description" content="{{ $course['short_detail'] }}">
<meta property="og:image" content="{{ asset('images/course/'.$course['preview_image']) }}">
<meta itemprop="image" content="{{ asset('images/course/'.$course['preview_image']) }}">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="{{ asset('images/course/'.$course['preview_image']) }}">
<meta property="twitter:title" content="{{ $course['title'] }} ">
<meta property="twitter:description" content="{{ $course['short_detail'] }}">
<meta name="twitter:site" content="{{ url()->full() }}" />
<link rel="canonical" href="{{ url()->full() }}"/>
<meta name="robots" content="all">
<meta name="keywords" content="{{ $gsetting->meta_data_keyword }}">
    
@endsection


<!-- breadcrumb-area -->
    @php
    $gets = App\Breadcum::first();
    @endphp
    
    @if($gets['img'] !== NULL && $gets['img'] !== '')
    <section class="breadcrumb-area d-flex  p-relative align-items-center" style="background-image: url('{{ asset('/images/breadcum/'.$gets->img) }}')">
    @else
    <section class="breadcrumb-area d-flex  p-relative align-items-center" style="background-image: url('{{ asset('Avatar::create($gets->text)->toBase64() ') }}')">
    @endif
    <div class="overlay-bg"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-12 col-lg-12">
                <div class="breadcrumb-wrap text-left">
                    <div class="breadcrumb-title">
                        <h2>{{__('Course Detail')}}</h2>  
                    </div>
                </div>
            </div>
            <div class="breadcrumb-wrap2">
                  
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('Course Details')}}</li>
                    </ol>
                </nav>
            </div>
            
        </div>
    </div>
</section>
<!-- breadcrumb-area-end -->
<!-- Project Detail -->
<section class="project-detail">
    <div class="container">
        <div class="lower-content">
            <div class="row">
                <div class="text-column col-lg-9 col-md-8 col-sm-12">
                    <h2>{{ $course['title'] }}</h2>
                
                    <div class="upper-box">
                        <div class="single-item-carousel">
                            @if($course['preview_image'] !== NULL && $course['preview_image'] !== '')
                            <figure class="image"><img src="{{ asset('images/course/'.$course['preview_image']) }}" ></figure>
                        @else
                        <figure class="image"><img src="{{ Avatar::create($course->title)->toBase64() }}"  alt="Background"></figure>
                        @endif
                        </div>
                    </div>

                    <div class="inner-column">
                       
                        <section id="about-product" class="about-product-main-block">
                            <div class="container-xl">
                                <div class="row">
                                    <div class="col-md-12">
                                        @if($whatlearns->isNotEmpty())
                                            <div class="product-learn-block">
                                                <h3 class="product-learn-heading">{{ __('What learn') }}</h3>
                                                <div class="row">
                                                    @foreach($course['whatlearns'] as $wl)
                                                    @if($wl->status ==1)
                                                    <div class="col-lg-6 col-md-6">
                                                        
                                                            <ul class="pr-ul">
                                                                <li>
                                                                    <div class="icon"><i class="fal fa-check"></i></div>
                                                                    <div class="text">
                                                                    {{ str_limit($wl['detail'], $limit = 120, $end = '...') }}
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                    </div>
                                                    @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                        
                        
                        
                                        <h3>{{ __('Meetings') }}</h3>
                                        @auth
                        
                                        @php
                                        $user_enrolled = App\Order::where('course_id', $course->id)->where('user_id', Auth::user()->id) ->first();
                        
                                        $bundle = App\Order::where('user_id', Auth::User()->id)->where('bundle_id', '!=', NULL)->get();
                        
                                        $course_id = array();
                                          
                                        
                                        // foreach($bundle as $b)
                                        // {
                                        //  $bundle = App\BundleCourse::where('id', $b->bundle_id)->first();
                                        //   array_push($course_id, $bundle->course_id);
                                        // }
                        
                                        $course_id = array_values(array_filter($course_id));
                        
                                        $course_id = array_flatten($course_id);
                        
                                        @endphp
                        
                        
                                        @if( $user_enrolled != NULL || Auth::user()->role == 'admin' || isset($course_id) || in_array($course->id, $course_id))
                        
                                        @if( ! $bigblue->isEmpty() )
                        
                                        <div class="course-content-block btm-30">
                                            <h5>{{ __('Big Blue Meetings') }}</h5>
                                            <div class="faq-block">
                                                <div class="faq-dtl">
                                                    <div id="accordion" class="second-accordion">
                        
                                                        @foreach($bigblue as $bbl)
                                                        @if($bbl->is_ended != 1)
                            
                                                        <div class="card">
                                                            <div class="card-header" id="headingThree{{ $bbl->id }}">
                                                                <div class="mb-0">
                                                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseThree{{ $bbl->id }}" aria-expanded="false" aria-controls="collapseThree">
                            
                                                                        {{ $bbl['meetingname'] }}
                            
                                                                    </button>
                                                                </div>
                            
                                                            </div>
                                                            <div id="collapseThree{{ $bbl->id }}" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                                                @php
                                                                // Ensure $meeting->paid_meeting_price is a number
                                                                $paidMeetingPrice = (float) $bbl->paid_meeting_price;
                                                                $isPaid = App\PaidMettings::where('user_id', auth()->id())
                                                                            ->where('meeting_id', $bbl->id)
                                                                            ->where('amount', '>=', $paidMeetingPrice)
                                                                            ->exists();
                                                                @endphp

                                                               
                                                                <div class="card-body">
                                                                    <table class="table">
                                                                    <tbody>
                                                                        <td>
                                                                        <ul>
                                                                            <li><a href="#" title="about">{{ __('Created') }}: @if(isset($bbl->user)) {{ $bbl->user['fname'] }} {{ $bbl->user['lname'] }} @endif</a></li>
                                                                            <li><a href="#" title="about">{{ __('Start At') }}: {{ date('d-m-Y | h:i:s A',strtotime($bbl['start_time'])) }}</a></li>
                                                                            <li class="comment more">
                                                                            {!! $bbl->detail !!}
                                                                            </li>
                                
                                                                            <li>
                                                                                @if($bbl->paid_meeting_price && !$isPaid)
                                                                                    <p class="meeting-owner btm-10">{{ __('Price') }}:{{ currency($bbl->paid_meeting_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}
                                                                                    </p>
                                                                                <form action="{{ route('checkoutmeeting') }}" method="GET">
                                                                                    <input type="hidden" name="meeting_id" value="{{ $bbl->id }}">
                                                                                    <input type="hidden" name="type" value="bbl">
                                                                                    <button type="submit" class="btn btn-primary">{{ __('Checkout') }}</button>
                                                                                </form> 
                                                                                @else
                                                                                <a href="" data-toggle="modal" data-target="#myModalBBL" title="join" class="btn btn-light" title="course">{{ __('Join Meeting') }}</a>
                                                                            @endif
                                                                            </li>
                                
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
                                                                                                    {{ __('Join Meeting') }}
                                                                                                </button>
                                
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                    </div>
                                                                                </div>
                                                                                </div>
                                                                            </div>
                                
                                                                        </ul>
                                                                        </td>
                                
                                                                    </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                            
                                                        @endif
                                                        @endforeach
                                                    </div>
                            
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                        
                                        @if( ! $meetings->isEmpty() )
                        
                                        <div class="course-content-block btm-30">
                                            <h5>{{ __('Zoom Meetings') }}</h5>
                                            <div class="faq-block">
                                                <div class="faq-dtl">
                                                    <div id="accordion" class="second-accordion">
                        
                        
                                                    @foreach($meetings as $meeting)
                        
                                                    <div class="card">
                                                        <div class="card-header" id="headingFour{{ $meeting->id }}">
                                                            <div class="mb-0">
                                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFour{{ $meeting->id }}" aria-expanded="false" aria-controls="collapseFour">
                        
                                                                    {{ $meeting['meeting_title'] }}
                        
                                                                </button>
                                                            </div>
                        
                                                        </div>
                                                        <div id="collapseFour{{ $meeting->id }}" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                                            
                                                            @php
                                                            // Ensure $meeting->paid_meeting_price is a number
                                                            $paidMeetingPrice = (float) $meeting->paid_meeting_price;
                                                            $isPaid = App\PaidMettings::where('user_id', auth()->id())
                                                                        ->where('meeting_id', $meeting->id)
                                                                        ->where('amount', '>=', $paidMeetingPrice)
                                                                        ->exists();
                                                            @endphp
                                                            
                                                           
                                                        <div class="card-body">
                                                            <table class="table">
                                                            <tbody>
                                                                <td>
                                                                    <ul>
                                                                        <li>
                                                                            <a href="#" title="about">{{ __('Created') }}: @if(isset($meeting->user)) {{ $meeting->user['fname'] }} {{ $meeting->user['lname'] }} @endif </a>
                        
                                                                        </li>
                                                                        <li>
                                                                           <p>{{ __('Meeting Owner')}}: {{ $meeting->owner_id }}</p>
                                                                        </li>
                                                                        <li>
                                                                           <p class="btm-10"><a herf="#">{{ __('Start At') }}: {{ date('d-m-Y | h:i:s A',strtotime($meeting['start_time'])) }}</a></p>
                                                                        </li>
                                                                        <li>
                                                                            @if($meeting->paid_meeting_price && !$isPaid)
                                                                                <p class="meeting-owner btm-10">{{ __('Price') }}:{{ currency($meeting->paid_meeting_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}
                                                                                </p>
                                                                            <form action="{{ route('checkoutmeeting') }}" method="GET">
                                                                                <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
                                                                                <input type="hidden" name="type" value="zoom">
                                                                                <button type="submit" class="btn btn-primary">{{ __('Checkout') }}</button>
                                                                            </form> 
                                                                            @else
                                                                            <a href="{{ $meeting->zoom_url }}" target="_blank" class="btn btn-light">{{ __('Join Meeting') }}</a>
                                                                            @endif
                                                                        </li>
                                                                        
                                                                    </ul>
                        
                                                                </td>
                                                            </tbody>
                                                            </table>
                                                        </div>
                                                       </div>
                                                    </div>
                                                    @endforeach
                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                        
                        
                                        {{-- googlemeeting start --}}
                                        @if($gsetting->googlemeet_enable == '1')
                                        @if( ! $googlemeetmeetings->isEmpty() )
                        
                                        <div class="course-content-block btm-30">
                                            <h5> {{__('Google Meetings')}}</h5>
                                            <div class="faq-block">
                                                <div class="faq-dtl">
                                                    <div id="accordion" class="second-accordion">
                        
                        
                                                    @foreach($googlemeetmeetings as $meeting)
                                                    <div class="card">
                                                        <div class="card-header" id="headingFour{{ $meeting->id }}">
                                                            <div class="mb-0">
                                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFour{{ $meeting->id }}" aria-expanded="false" aria-controls="collapseFour">
                        
                                                                    {{ $meeting['meeting_title'] }}
                        
                                                                </button>
                                                            </div>
                        
                                                        </div>
                                                        <div id="collapseFour{{ $meeting->id }}" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                        
                                                        <div class="card-body">
                                                            <table class="table">
                                                            <tbody>
                                                                <td>
                                                                    <ul>
                                                                        <li>
                                                                            <a href="#" title="about">{{ __('Created') }}: @if(isset($meeting->user)) {{ $meeting->user['fname'] }} {{ $meeting->user['lname'] }} @endif </a>
                        
                                                                        </li>
                                                                        <li>
                                                                           <p>Meeting Owner: {{ $meeting->owner_id }}</p>
                                                                        </li>
                                                                        <li>
                                                                           <p class="btm-10"><a herf="#">{{ __('Start At') }}: {{ date('d-m-Y | h:i:s A',strtotime($meeting['start_time'])) }}</a></p>
                                                                        </li>
                                                                        <li>

                                                                            @php
                                                                            // Ensure $meeting->paid_meeting_price is a number
                                                                            $paidMeetingPrice = (float) $meeting->paid_meeting_price;
                                                                            $isPaid = App\PaidMettings::where('user_id', auth()->id())
                                                                                        ->where('meeting_id', $meeting->id)
                                                                                        ->where('amount', '>=', $paidMeetingPrice)
                                                                                        ->exists();
                                                                            @endphp


                                                                           

                                                                    @if($meeting->paid_meeting_price && !$isPaid)
                                                                    <p class="meeting-owner btm-10">{{ __('Price')
                                                                        }}:{{ currency($meeting->paid_meeting_price,
                                                                        $from = $currency->code, $to =
                                                                        Session::has('changed_currency') ?
                                                                        Session::get('changed_currency') :
                                                                        $currency->code, $format = true) }}
                                                                    </p>
                                                                    <form action="{{ route('checkoutmeeting') }}"
                                                                        method="GET">
                                                                        <input type="hidden" name="meeting_id"
                                                                            value="{{ $meeting->id }}">
                                                                        <input type="hidden" name="type"
                                                                            value="googlemeet">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">{{
                                                                            __('Checkout') }}</button>
                                                                    </form>
                                                                    @else
                                                                    <a href="{{ $meeting->meet_url }}"
                                                                        target="_blank" class="btn btn-light">{{
                                                                        __('Join Meeting') }}</a>
                                                                    @endif
                                                                        </li>
                                                                    </ul>
                        
                                                                </td>
                                                            </tbody>
                                                            </table>
                                                        </div>
                                                       </div>
                                                    </div>
                                                    @endforeach
                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endif
                                        {{-- googlemeeting end --}}
                        
                                        {{-- jitsi start --}}
                                        @if($gsetting->jitsimeet_enable == '1')
                                        @if( ! $jitsimeetings->isEmpty() )
                                        <div class="course-content-block btm-30">
                                            <h5> Jitsi Meetings</h5>
                                            <div class="faq-block">
                                                <div class="faq-dtl">
                                                    <div id="accordion" class="second-accordion">
                        
                        
                                                    @foreach($jitsimeetings as $meeting)
                        
                                                    <div class="card">
                                                        <div class="card-header" id="headingFour{{ $meeting->id }}">
                                                            <div class="mb-0">
                                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFour{{ $meeting->id }}" aria-expanded="false" aria-controls="collapseFour">
                        
                                                                    {{ $meeting['meeting_title'] }}
                        
                                                                </button>
                                                            </div>
                        
                                                        </div>
                                                        <div id="collapseFour{{ $meeting->id }}" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                        
                                                        <div class="card-body">
                                                            <table class="table">
                                                            <tbody>
                                                                <td>
                                                                    <ul>
                                                                        <li>
                                                                            <a href="#" title="about">{{ __('Created') }}: @if(isset($meeting->user)) {{ $meeting->user['fname'] }} {{ $meeting->user['lname'] }} @endif </a>
                        
                                                                        </li>
                                                                        <li>
                                                                           <p>{{ __('Meeting Owner')}}: {{ $meeting->owner_id }}</p>
                                                                        </li>
                                                                        <li>
                                                                           <p class="btm-10"><a herf="#">{{ __('Start At') }}: {{ date('d-m-Y | h:i:s A',strtotime($meeting['start_time'])) }}</a></p>
                                                                        </li>

                                                                        @php
                                                                        // Ensure $meeting->paid_meeting_price is a number
                                                                        $paidMeetingPrice = (float) $meeting->paid_meeting_price;
                                                                        $isPaid = App\PaidMettings::where('user_id', auth()->id())
                                                                                    ->where('meeting_id', $meeting->id)
                                                                                    ->where('amount', '>=', $paidMeetingPrice)
                                                                                    ->exists();
                                                                        @endphp

                                                                       
                                                                        <li>
                                                                            @if($meeting->paid_meeting_price && !$isPaid)
                                                                                <p class="meeting-owner btm-10">{{ __('Price') }}:{{ currency($meeting->paid_meeting_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}
                                                                                </p>
                                                                            <form action="{{ route('checkoutmeeting') }}" method="GET">
                                                                                <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
                                                                                <input type="hidden" name="type" value="jitsi">
                                                                                <button type="submit" class="btn btn-primary">{{ __('Checkout') }}</button>
                                                                            </form> 
                                                                            @else
                                                                            <a href="{{url('meetup-conferencing/'.$meeting->meeting_id) }}" target="_blank" class="btn btn-light">{{ __('Join Meeting') }}</a>
                                                                            @endif
                                                                        </li>

                                                                       
                                                                    </ul>
                        
                                                                </td>
                                                            </tbody>
                                                            </table>
                                                        </div>
                                                       </div>
                                                    </div>
                                                    @endforeach
                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                        
                                        @endif
                                        {{-- jitsi end --}}
                        
                        
                                        @endif
                        
                                        @endauth
                    
                                
                        
                                        <div class="requirements">
                                            <h3>{{ __('Requirements') }}</h3>
                                            <ul>
                                                <li class="comment more">
                                                    @if(strlen($course->requirement) > 400)
                                                    {{substr($course->requirement,0,400)}}
                                                    <span class="read-more-show hide_content"><br>+&nbsp;{{ __('See More')}}</span>
                                                    <span class="read-more-content"> {{substr($course->requirement,400,strlen($course->requirement))}}
                                                    <span class="read-more-hide hide_content"><br>-&nbsp;{{ __('See Less')}}</span> </span>
                                                    @else
                                                    {{$course->requirement}}
                                                    @endif
                                                </li>
                        
                                            </ul>
                                        </div>
                                        <div class="description-block btm-30">
                                            <h3>{{ __('Description') }}</h3>
                        
                                            <p>{!! $course->detail !!}</p>
                        
                                        </div>
                        
                        
                                       @php
                                            $alreadyrated = App\ReviewRating::where('course_id', $course->id)->limit(1)->first();
                                        @endphp
                                        @if($alreadyrated == !NULL)
                                        @if($alreadyrated->featured == 1)
                                            <div class="featured-review btm-40">
                                                <h3>{{ __('Featured Review') }}</h3>
                                                <?php
                        
                                                    $user_count = count([$alreadyrated]);
                                                    $user_sub_total = 0;
                                                    $user_learn_t = $alreadyrated->learn * 5;
                                                    $user_price_t = $alreadyrated->price * 5;
                                                    $user_value_t = $alreadyrated->value * 5;
                                                    $user_sub_total = $user_sub_total + $user_learn_t + $user_price_t + $user_value_t;
                        
                                                    $user_count = ($user_count * 3) * 5;
                                                    $rat1 = $user_sub_total / $user_count;
                                                    $ratings_var1 = ($rat1 * 100) / 5;
                        
                                                ?>
                                                @if(isset($alreadyrated))
                                                
                                                @foreach($coursereviews as $rating)
                                                @if($rating->review == !null && $rating->featured == 1)
                                                <div class="featured-review-block">
                                                    <div class="row">
                                                        <div class="col-lg-2 col-sm-3 col-4">
                                                            <div class="featured-review-img">
                                                                <div class="review-img text-white">
                                                                {{ str_limit($rating->user->fname ?? '', $limit = 1, $end = '') }}{{ str_limit($rating->user->lname ?? '', $limit = 1, $end = '') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-10 col-sm-9 col-8">
                                                            <div class="featured-review-img-dtl">
                                                                <div class="review-img-name"><span> @if(isset($rating->user)) {{ $rating->user['fname'] }} {{ $rating->user['lname'] }} @endif</span></div>
                                                                <div class="pull-left">
                                                                    <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var1; ?>%" class="star-ratings-sprite-rating"></span>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="year btm-20">{{ date('jS F Y', strtotime($rating['created_at'])) }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="btm-20">{{ $rating['review'] }}</p>
                        
                                                    @auth
                                                    <div class="review">{{ __('helpful') }}?
                                                        @php
                                                        $help = App\ReviewHelpful::where('user_id', Auth::User()->id)->where('review_id', $rating->id)->first();
                                                        @endphp
                        
                                                        
                                                      
                                                        @if(isset($help['review_like']) == '1')
                                                            <div class="helpful">
                                                               
                                                                <form  method="post" action="{{route('helpful', $course->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}
                        
                                                                <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
                        
                                                                <input type="hidden" name="review_id"  value="{{ $rating->id }}" />
                        
                                                                <input type="hidden" name="helpful"  value="yes" />
                                                                <input type="hidden" name="review_like"  value="0" />
                                                                
                                                                  <button type="submit" class="btn btn-link lft-7 rgt-10 "><i class="fa fa-check"></i> {{ __('Yes') }}</button>
                                                                </form>
                                                            </div>
                                                        @else
                                                            <div class="helpful">
                                                                <form  method="post" action="{{route('helpful', $course->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}
                        
                                                                <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
                        
                                                                <input type="hidden" name="review_id"  value="{{ $rating->id }}" />
                        
                                                                <input type="hidden" name="helpful"  value="yes" />
                                                                <input type="hidden" name="review_like"  value="1" />
                                                                
                                                                  <button type="submit" class="btn btn-link lft-7 rgt-10 ">{{ __('Yes') }}</button>
                                                                </form>
                                                            </div>
                                                        @endif
                        
                        
                        
                                                        @if(isset($help['review_dislike']) == '1')
                                                            <div class="helpful">
                                                               
                        
                                                                <form  method="post" action="{{route('helpful', $course->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}
                        
                                                                <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
                        
                                                                <input type="hidden" name="review_id"  value="{{ $rating->id }}" />
                        
                                                                <input type="hidden" name="helpful"  value="yes" />
                                                                <input type="hidden" name="review_dislike"  value="0" />
                                                                
                                                                  <button type="submit" class="btn btn-link lft-7 rgt-10 "><i class="fa fa-check"></i>{{ __('No') }}</button>
                                                                </form>
                                                            </div>
                                                        @else
                                                            <div class="helpful">
                                                                <form  method="post" action="{{route('helpful', $course->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}
                        
                                                                <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
                        
                                                                <input type="hidden" name="review_id"  value="{{ $rating->id }}" />
                        
                                                                <input type="hidden" name="helpful"  value="yes" />
                                                                <input type="hidden" name="review_dislike"  value="1" />
                                                                
                                                                  <button type="submit" class="btn btn-link lft-7 rgt-10 ">{{ __('No') }}</button>
                                                                </form>
                                                            </div>
                                                        @endif
                        
                                                        
                        
                                                        <a href="#" data-toggle="modal" data-target="#myModalreport"  title="report">{{ __('Report') }}</a>
                        
                                                    </div>
                        
                                                    @endauth
                                                </div>
                                                @endif
                                                @endforeach
                                                @endif
                                            </div>
                                        @endif
                                        @endif
                        
                        
                        
                                        
                        
                        
                                        <!--Model start-->
                                        @auth
                                        <div class="modal fade" id="myModalCourse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog modal-lg" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                        
                                                  <h4 class="modal-title" id="myModalLabel">{{ __('Report') }}</h4>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="box box-primary">
                                                  <div class="panel panel-sum">
                                                    <div class="modal-body">
                        
                                                    <form id="demo-form2" method="post" action="{{ route('course.report', $course->id) }}"
                                                        data-parsley-validate class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}
                        
                                                        <div class="row">
                                                          <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="title">{{ __('Title') }}:<sup class="redstar">*</sup></label>
                                                                <input type="text" class="form-control" name="title" id="title" placeholder="{{ __('Please Enter Title')}}" value="" required>
                                                            </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="email">{{ __('Email') }}:<sup class="redstar">*</sup></label>
                                                                <input type="email" class="form-control" name="email" placeholder="{{ __('Please Enter Email')}}" value="{{ Auth::user()->email }}" required>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <div class="row">
                                                          <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="detail">{{ __('Detail') }}:<sup class="redstar">*</sup></label>
                                                                <textarea name="detail" rows="4"  class="form-control" placeholder="{{ __('Please Enter Detail')}}" required></textarea>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <br>
                                                        <div class="box-footer">
                                                            <button type="submit" class="btn btn-lg col-md-3 btn-primary">{{ __('Submit') }}</button>
                                                        </div>
                                                    </form>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                        @endauth
                                        <!--Model close -->
                                    </div>
                        
                                </div>
                            </div>
                        </section>
                        @php
                        $faqs = App\FaqStudent::get();
                    @endphp
                    <h3>Frequently Asked Question</h3>
                    <div class="faq-wrap mt-30 pr-30 pb-60 wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                        @foreach ($faqs as $index => $faq)
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="heading{{$faq->id}}">
                                    <h2 class="mb-0">
                                        <button class="faq-btn  {{ $index == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{$faq->id}}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse">
                                           {{$faq->title}}
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse{{$faq->id}}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" 
                                    data-bs-parent="#accordionExample">
                                    <div class="card-body">
                                        {{substr(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($faq->details))), 0, 100)}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div> 

                    <div class="about-instructor-block">
                        <h3>{{ __('About Instructor') }}</h3>
                        @php
                        $fullname = isset($course->user['fname']) . ' ' . isset($course->user['lname']);
                        $fullname = preg_replace('/\s+/', '', $fullname);
                        @endphp

                        <div class="about-instructor mb-40">
                            <div class="row">
                                <div class="col-lg-2 col-md-3 col-4">
                                    <div class="instructor-img mb-30">
                                        
                                        @if($course->user->user_img != null || $course->user->user_img !='')
                                        <a href="{{ route('instructor.profile', ['id' => $course->user->id, 'name' => $fullname] ) }}" title="instructor"><img src="{{ asset('images/user_img/'.$course->user['user_img']) }}" class="img-fluid" alt="instructor"></a>
                                        @else
                                        <img src="{{ asset('images/default/user.jpg')}}" class="img-fluid" alt="instructor">
                                        @endif
                                        {{-- <ul>
                                            <li><span>10</span> Courses</li>
                                            <li><span>5</span> Reviews</li>
                                        </ul> --}}
                                    </div>
                                </div>
                                <div class="col-lg-10 col-md-9 col-8">
                                    <div class="instructor-block">
                                        <div class="instructor-name btm-10"><a href="{{ route('instructor.profile', ['id' => $course->user->id, 'name' => $fullname] ) }}" title="instructor-name">@if(isset($course->user)) {{ $course->user['fname'] }} {{ $course->user['lname'] }} @endif</a></div>
                                        <div class="instructor-post btm-5">{{ __('About Instructor') }}</div>
                                        {{-- <div class="instructor-block-ratings">
                                            <ul>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                            </ul>
                                        </div> --}}
                                        <p>{!! $course->user['detail'] !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(! $reviews->isEmpty())
                        <div class="student-feedback pb-80">
                            <h3 class="student-feedback-heading pb-20">{{ __('Student Feedback') }}</h3>
                            <div class="student-feedback-block">

                                <div class="rating">
                                    <?php
                                        $learn = 0;
                                        $price = 0;
                                        $value = 0;
                                        $sub_total = 0;
                                        $count =  count($reviews);
                                        $onlyrev = array();

                                        $reviewcount = App\ReviewRating::where('course_id',1)->where('status',"1")->WhereNotNull('review')->get();

                                    foreach($reviews as $review){

                                        $learn = $review->learn*5;
                                        $price = $review->price*5;
                                        $value = $review->value*5;
                                        $sub_total = $sub_total + $learn + $price + $value;
                                    }

                                    $count = ($count*3) * 5;

                                    if($count != "" && $count != '0')
                                    {
                                        $rat = $sub_total/$count;

                                        $ratings_var = ($rat*100)/5;

                                        $overallrating = ($ratings_var/2)/10;
                                    }

                                    ?>

                                    <div class="rating-num">{{ round($overallrating, 1) }}</div>

                                    <?php
                                    $learn = 0;
                                    $price = 0;
                                    $value = 0;
                                    $sub_total = 0;
                                    $sub_total = 0;
                                    $reviews = App\ReviewRating::where('course_id',$course->id)->where('status','1')->get();
                                    ?>
                                    @if(!empty($reviews[0]))
                                        <?php
                                        $count =  App\ReviewRating::where('course_id',$course->id)->count();

                                        foreach($reviews as $review){
                                            $learn = $review->learn*5;
                                            $price = $review->price*5;
                                            $value = $review->value*5;
                                            $sub_total = $sub_total + $learn + $price + $value;
                                        }

                                        $count = ($count*3) * 5;
                                        $rat = $sub_total/$count;
                                        $ratings_var = ($rat*100)/5;
                                        ?>
                                        <div class="pull-left">
                                            <div class="star-ratings-sprite star-ratings-center"><span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="pull-left">
                                            <div class="star-ratings-sprite star-ratings-center"><span style="width:%" class="star-ratings-sprite-rating"></span>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="rating-users">{{ __('Course Rating') }}</div>
                                </div>
                                <div class="histo">
                                    <div class="three histo-rate">
                                        <span class="histo-star">
                                            <?php
                                            $learn = 0;
                                            $total = 0;
                                            $reviews = App\ReviewRating::where('course_id',$course->id)->where('status','1')->get();
                                            ?>
                                            @if(!empty($reviews[0]))
                                                <?php
                                                $count =  App\ReviewRating::where('course_id',$course->id)->count();

                                                foreach($reviews as $review){
                                                    $learn = $review->learn*5;
                                                    $total = $total + $learn;
                                                }

                                                $count = ($count*1) * 5;
                                                $rat = $total/$count;
                                                $ratings_var = ($rat*100)/5;
                                                ?>

                                                <div class="pull-left">
                                                    <div class="star-ratings-sprite star-ratings-center"><span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
                                                    </div>
                                                </div>

                                            @else
                                                <div class="pull-left">
                                                    <div class="star-ratings-sprite star-ratings-center"><span style="width:%" class="star-ratings-sprite-rating"></span>
                                                    </div>
                                                </div>
                                            @endif
                                        </span>
                                        <span class="histo-percent">
                                            <a href="#" title="rate">{{ round($ratings_var) }}%</a>
                                        </span>
                                        <span class="bar-block">
                                            <span id="bar-three" style=" width:{{ $ratings_var }}%;" class="bar bar-clr bar-radius">&nbsp;</span>
                                        </span>
                                    </div>
                                    <div class="two histo-rate">
                                        <span class="histo-star">
                                            <?php
                                            $price = 0;
                                            $total = 0;
                                            $reviews = App\ReviewRating::where('course_id',$course->id)->where('status','1')->get();
                                            ?>
                                            @if(!empty($reviews[0]))
                                                <?php
                                                $count =  App\ReviewRating::where('course_id',$course->id)->count();

                                                foreach($reviews as $review){
                                                    $price = $review->price*5;
                                                    $total = $total + $price;
                                                }

                                                $count = ($count*1) * 5;
                                                $rat = $total/$count;
                                                $ratings_var = ($rat*100)/5;
                                                ?>

                                                <div class="pull-left">
                                                    <div class="star-ratings-sprite star-ratings-center"><span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
                                                    </div>
                                                </div>

                                            @else
                                                <div class="pull-left">
                                                    <div class="star-ratings-sprite star-ratings-center"><span style="width:%" class="star-ratings-sprite-rating"></span>
                                                    </div>
                                                </div>
                                            @endif
                                        </span>
                                        <span class="histo-percent">
                                            <a href="#" title="rate">{{ round($ratings_var) }}%</a>
                                        </span>
                                        <span class="bar-block">
                                            <span id="bar-two" style="width: {{ $ratings_var }}%" class="bar bar-clr bar-radius">&nbsp;</span>
                                        </span>
                                    </div>
                                    <div class="one histo-rate">
                                        <span class="histo-star">
                                            <?php
                                            $value = 0;
                                            $total = 0;
                                            $reviews = App\ReviewRating::where('course_id',$course->id)->where('status','1')->get();
                                            ?>
                                            @if(!empty($reviews[0]))
                                                <?php
                                                $count =  App\ReviewRating::where('course_id',$course->id)->count();

                                                foreach($reviews as $review){
                                                    $value = $review->value*5;
                                                    $total = $total + $value;
                                                }

                                                $count = ($count*1) * 5;
                                                $rat = $total/$count;
                                                $ratings_var = ($rat*100)/5;
                                                ?>

                                                <div class="pull-left">
                                                    <div class="star-ratings-sprite star-ratings-center"><span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
                                                    </div>
                                                </div>

                                            @else
                                                <div class="pull-left">
                                                    <div class="star-ratings-sprite star-ratings-center"><span style="width:%" class="star-ratings-sprite-rating"></span>
                                                    </div>
                                                </div>
                                            @endif
                                        </span>
                                        <span class="histo-percent">
                                            <a href="#" title="rate">{{ round($ratings_var) }}%</a>
                                        </span>
                                        <span class="bar-block">
                                            <span id="bar-one" style="width: {{ $ratings_var }}%" class="bar bar-clr bar-radius">&nbsp;</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endif

                    <div class="learning-review btm-40">

                        @auth
                        {{-- @php
                            $orders = App\Order::where('user_id', Auth::User()->id)->where('course_id', $course->id)->first();
                        @endphp --}}


                        @php
                            $user_enrolled = App\Order::where('course_id', $course->id)->where('user_id', Auth::user()->id) ->first();

                            $bundle = App\Order::where('user_id', Auth::User()->id)->where('bundle_id', '!=', NULL)->get();

                            $course_id = array();
                    

                            // foreach($bundle as $b)
                            // {
                            //  $bundle = App\BundleCourse::where('id', $b->bundle_id)->first();
                            //   array_push($course_id, $bundle->course_id);
                            // }

                            $course_id = array_values(array_filter($course_id));

                            $course_id = array_flatten($course_id);

                        @endphp


                        @if( $user_enrolled != NULL || Auth::user()->role == 'admin' || isset($course_id) || in_array($course->id, $course_id))
                            
                            <div class="review-block">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <h3 class="top-20">{{ __('Reviews') }}</h3>
                                    </div>
                                    <div class="col-lg-10 col-12">
                                        <form id="demo-form2" method="post" action="{{route('course.rating',$course->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}
                                            <div class="review-table">
                                                <table class="table mb-40">
                                                    <tbody>
                                                        <tr>
                                                        <th scope="row">{{ __('Learn') }}</th>
                                                        <td>
                                                            <div class="star-rating">
                                                                <input id="option1" type="radio" name="learn" value="5" />
                                                                <label for="option1" title="5 stars">
                                                                <i class="active fa fa-star mrg-lft" aria-hidden="true"></i>
                                                                </label>
                                                                <input id="option2" type="radio" name="learn" value="4" />
                                                                <label for="option2" title="4 stars">
                                                                <i class="active fa fa-star mrg-lft" aria-hidden="true"></i>
                                                                </label>
                                                                <input id="option3" type="radio" name="learn" value="3" />
                                                                <label for="option3" title="3 stars">
                                                                <i class="active fa fa-star mrg-lft" aria-hidden="true"></i>
                                                                </label>
                                                                <input id="option4" type="radio" name="learn" value="2" />
                                                                <label for="option4" title="2 stars">
                                                                <i class="active fa fa-star mrg-lft" aria-hidden="true"></i>
                                                                </label>
                                                                <input id="option5" type="radio" name="learn" value="1" />
                                                                <label for="option5" title="1 star">
                                                                <i class="active fa fa-star mrg-lft" aria-hidden="true"></i>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                        <th scope="row">{{ __('Price') }}</th>
                                                        <td>
                                                            <div class="star-rating">
                                                                <input id="option6" type="radio" name="price" value="5" />
                                                                <label for="option6" title="5 stars">
                                                                <i class="active fa fa-star mrg-lft" aria-hidden="true"></i>
                                                                </label>
                                                                <input id="option7" type="radio" name="price" value="4" />
                                                                <label for="option7" title="4 stars">
                                                                <i class="active fa fa-star mrg-lft" aria-hidden="true"></i>
                                                                </label>
                                                                <input id="option8" type="radio" name="price" value="3" />
                                                                <label for="option8" title="3 stars">
                                                                <i class="active fa fa-star mrg-lft" aria-hidden="true"></i>
                                                                </label>
                                                                <input id="option9" type="radio" name="price" value="2" />
                                                                <label for="option9" title="2 stars">
                                                                <i class="active fa fa-star mrg-lft" aria-hidden="true"></i>
                                                                </label>
                                                                <input id="option10" type="radio" name="price" value="1" />
                                                                <label for="option10" title="1 star">
                                                                <i class="active fa fa-star mrg-lft" aria-hidden="true"></i>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                        <th scope="row">{{ __('Value') }}</th>
                                                        <td>
                                                            <div class="star-rating">
                                                                <input id="option11" type="radio" name="value" value="5" />
                                                                <label for="option11" title="5 stars">
                                                                <i class="active fa fa-star mrg-lft" aria-hidden="true"></i>
                                                                </label>
                                                                <input id="option12" type="radio" name="value" value="4" />
                                                                <label for="option12" title="4 stars">
                                                                <i class="active fa fa-star mrg-lft" aria-hidden="true"></i>
                                                                </label>
                                                                <input id="option13" type="radio" name="value" value="3" />
                                                                <label for="option13" title="3 stars">
                                                                <i class="active fa fa-star mrg-lft" aria-hidden="true"></i>
                                                                </label>
                                                                <input id="option14" type="radio" name="value" value="2" />
                                                                <label for="option14" title="2 stars">
                                                                <i class="active fa fa-star mrg-lft" aria-hidden="true"></i>
                                                                </label>
                                                                <input id="option15" type="radio" name="value" value="1" />
                                                                <label for="option15" title="1 star">
                                                                <i class="active fa fa-star mrg-lft" aria-hidden="true"></i>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="review-text mb-30">
                                                    <label for="review">{{ __('Write review') }}:</label>
                                                    <textarea name="review" rows="4" class="form-control" placeholder=""></textarea>
                                                </div>
                                                <div class="review-rating-btn text-right">
                                                    <button type="submit" class="btn btn-success" title="Review">{{ __('Submit') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <hr>

                        @endif
                        @endauth


                        @php
                            $alreadyrated = App\ReviewRating::where('course_id', $course->id)->first();
                        @endphp
                        @if($alreadyrated == !NULL)

                        <div class="review-dtl">
                            
                            @if(isset($alreadyrated))
                            @foreach($course->review as $rating)

                            <?php

                                $user_count = count([$rating]);
                                $user_sub_total = 0;
                                $user_learn_t = $rating->learn * 5;
                                $user_price_t = $rating->price * 5;
                                $user_value_t = $rating->value * 5;
                                $user_sub_total = $user_sub_total + $user_learn_t + $user_price_t + $user_value_t;

                                $user_count = ($user_count * 3) * 5;
                                $rat1 = $user_sub_total / $user_count;
                                $ratings_var7 = ($rat1 * 100) / 5;

                            ?>

                            @if($rating->review == !null && $rating->status == 1 && $rating->approved == 1)
                            <div class="row btm-20">
                                <div class="col-lg-4">
                                    <div class="review-img text-white">
                                        {{ str_limit($rating->user->fname, $limit = 1, $end = '') }}{{ str_limit($rating->user->lname, $limit = 1, $end = '') }}
                                    </div>
                                    <div class="review-img-block">
                                        <div class="review-month">{{ date('d-m-Y', strtotime($rating['created_at'])) }}</div>
                                        <div class="review-name">{{ $rating->user['fname'] }} {{ $rating->user['lname'] }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="review-rating">
                                        <div class="pull-left-review">
                                            <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var7; ?>%" class="star-ratings-sprite-rating"></span>
                                            </div>
                                        </div>
                                        <div class="review-text">
                                            <p>{{ $rating['review'] }}<p>
                                        </div>

                                        @auth

                                        <div class="review">{{ __('helpful') }}?
                                    @php
                                    $help = App\ReviewHelpful::where('user_id', Auth::User()->id)->where('review_id', $rating->id)->first();
                                    @endphp

                                    
                                
                                    @if(isset($help['review_like']) == '1')
                                        <div class="helpful">
                                        
                                            <form  method="post" action="{{route('helpful', $course->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}

                                            <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />

                                            <input type="hidden" name="review_id"  value="{{ $rating->id }}" />

                                            <input type="hidden" name="helpful"  value="yes" />
                                            <input type="hidden" name="review_like"  value="0" />
                                            
                                            <button type="submit" class="btn btn-link lft-7 rgt-10 "><i class="fa fa-check"></i> {{ __('Yes') }}</button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="helpful">
                                            <form  method="post" action="{{route('helpful', $course->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}

                                            <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />

                                            <input type="hidden" name="review_id"  value="{{ $rating->id }}" />

                                            <input type="hidden" name="helpful"  value="yes" />
                                            <input type="hidden" name="review_like"  value="1" />
                                            
                                            <button type="submit" class="btn btn-link lft-7 rgt-10 ">{{ __('Yes') }}</button>
                                            </form>
                                        </div>
                                    @endif



                                    @if(isset($help['review_dislike']) == '1')
                                        <div class="helpful">
                                        

                                            <form  method="post" action="{{route('helpful', $course->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}

                                            <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />

                                            <input type="hidden" name="review_id"  value="{{ $rating->id }}" />

                                            <input type="hidden" name="helpful"  value="yes" />
                                            <input type="hidden" name="review_dislike"  value="0" />
                                            
                                            <button type="submit" class="btn btn-link lft-7 rgt-10 "><i class="fa fa-check"></i>{{ __('No') }}</button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="helpful">
                                            <form  method="post" action="{{route('helpful', $course->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}

                                            <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />

                                            <input type="hidden" name="review_id"  value="{{ $rating->id }}" />

                                            <input type="hidden" name="helpful"  value="yes" />
                                            <input type="hidden" name="review_dislike"  value="1" />
                                            
                                            <button type="submit" class="btn btn-link lft-7 rgt-10 ">{{ __('No') }}</button>
                                            </form>
                                        </div>
                                    @endif

                                
                                            {{-- report --}}
                                            <a href="#" data-toggle="modal" data-target="#myModalreport"  title="report">{{ __('Report') }}</a>
                                            <div class="modal fade" id="myModalreport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">{{ __('Report') }}</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="box box-primary">
                                                    <div class="panel panel-sum">
                                                        <div class="modal-body">
                                                            @php
                                                                $courses = App\Course::first();
                                                            @endphp
                                                            <form id="demo-form2" method="post" action="{{ route('report.review', $course->id) }}"              data-parsley-validate class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}

                                                                <input type="hidden" name="review_id"  value="{{ $rating->id }}" />

                                                                <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="title">{{ __('Title') }}:<sup class="redstar">*</sup></label>
                                                                        <input type="text" class="form-control" name="title" id="title" placeholder="Please Enter Title" value="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="email">{{ __('Email') }}:<sup class="redstar">*</sup></label>
                                                                        <input type="email" class="form-control" name="email" id="title" placeholder="Please Enter Email" value="{{ Auth::User()->email }}" required>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                                <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="detail">{{ __('Detail') }}:<sup class="redstar">*</sup></label>
                                                                        <textarea name="detail" rows="4"  class="form-control" placeholder=""></textarea>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                                <br>
                                                                <div class="box-footer">
                                                                <button type="submit" class="btn btn-lg col-md-3 btn-primary">{{ __('Submit') }}</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>

                                        @endauth


                                    </div>
                                </div>
                            </div>
                            <hr>
                            @endif
                            @endforeach
                            @endif
                        </div>
                        @endif

                    </div>
                </div>
            </div>
                <div class="col-lg-3 col-md-4">
                    <aside class="sidebar-widget info-column">
                        <div class="inner-column3">
                                <h3>Course Features</h3>
                                <ul class="project-info clearfix">
                                    <li>
                                        <div class="priceing">                                    
                                        
                                        
                                        @if($course->discount_price == !NULL)
                                           
                                        <strong>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($course->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</strong>
                                            <sub>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($course->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</sub>

                                        @else
                                            @if($course->price == !NULL)
                                            <strong>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($course->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</strong>
                                            @endif
                                        @endif
                                       
                                        </div>
                                    </li>
                                    <li>
                                         @php
                                            $insti = App\Institute::where('id',$course->institude_id)->first();
                                        @endphp
                                    @if(isset($insti))
                                    <span class="icon fal fa-home-lg-alt"></span> <strong>Instructor:</strong> <span>{{ $insti->title }}</span>
                                    @endif
                                    </li>
                                    @php
                                    // FSMS
                                    if (!function_exists('convertToHoursMins')) {
                                    function convertToHoursMins($time, $format = '%02d:%02d') {
                                        if ($time < 1) {
                                            return;
                                        }
                                        $hours =floor($time / 60);
                                        $minutes = ($time % 60);
                                        return sprintf($format, $hours, $minutes);
                                    }
                                    }
                                    $classtwo =  App\CourseClass::where('course_id', $course->id)->sum("duration");

                                    // echo $duration_round2 = round($classtwo,2);

                                    $chapterCount = $coursechapters->count();
                                    $classesCount = count(App\CourseClass::where('course_id', $course->id)->get());
                                    $courseDuration = convertToHoursMins($classtwo, '%02dh %02dm total length');
                                    // FSMS
                                    @endphp
                                    <li>
                                    <span class="icon fal fa-book"></span> <strong>Lectures:</strong> <span>{{ $classesCount }}</span>
                                    </li>

                                    <li>
                                        <span class="icon fal fa-clock"></span> <strong>Duration: </strong> <span>{{ $courseDuration }}</span>
                                    </li>
                                    <li>
                                        <span class="icon fal fa-user"></span> <strong>Enrolled: </strong> <span> @php
                                            $data = App\Order::where('course_id', $course->id)->get();
                                            if(count($data)>0){
            
                                                echo count($data);
                                            }
                                            else{
            
                                                echo "0";
                                            }
                                        @endphp</span>
                                    </li>
                                    <li>
                                        <span class="icon fal fa-globe"></span> <strong>Language: </strong> <span>{{ $course->language['name'] }}</span>
                                    </li>
                                    <li class="course-detail-button">
                                     
                                        @if($course->type == 1)
                                            @if(Auth::check())

                                                @if(Auth::User()->role == "admin")
                                                    <div class="about-home-btn btm-20">
                                                        <a href="{{ route('course.content',['slug' => $course->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                                    </div>
                                                    @else
                                                    @if(isset($course->duration))
                                                        @if($course->duration_type == "m")
                                                        <div class="course-duration btm-10">{{ __('Enroll Duration') }}: {{ $course->duration }} Months</div>
                                                        @else
                                                        <div class="course-duration btm-10">{{ __('Enroll Duration') }}: {{ $course->duration }} Days</div>
                                                        @endif
                                                    @endif


                                                    @if(!empty($order) && $order->status == 1)

                                                        <div class="about-home-btn btm-20">
                                                            <a href="{{ route('course.content',['slug' => $course->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                                        </div>

                                                        @elseif(isset($course_id) && in_array($course->id, $course_id))
                                                        <div class="about-home-btn btm-20">
                                                            <a href="{{ route('course.content',['slug' => $course->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                                        </div>





                                                        @elseif(!empty($instruct_course->id) && $instruct_course->id == $course->id)

                                                        <div class="about-home-btn btm-20">
                                                            <a href="{{ route('course.content',['slug' => $course->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                                        </div>


                                                        @else

                                                        @if(!empty($cart))
                                                            <div class="about-home-btn btm-20">
                                                                <form id="demo-form2" method="post" action="{{ route('remove.item.cart',$cart->id) }}">
                                                                    {{ csrf_field() }}

                                                                    <div class="box-footer">
                                                                    <button type="submit" class="btn btn-primary"><i data-feather="shopping-cart"></i>&nbsp;{{ __('Remove From Cart') }}</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            @else
                                                            <div class="about-home-btn">
                                                                <form id="demo-form2" method="post" action="{{ route('addtocart',['course_id' => $course->id, 'price' => $course->price, 'discount_price' => $course->discount_price ]) }}"
                                                                    data-parsley-validate class="form-horizontal form-label-left">
                                                                        {{ csrf_field() }}

                                                                    <input type="hidden" name="category_id"  value="{{$course->category->id}}" />

                                                                    <div class="box-footer">
                                                                    <button type="submit" class="btn btn-primary"><i data-feather="shopping-cart"></i>&nbsp;{{ __('Add To Cart') }}</button>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                            <div class="about-home-btn mt-10">
                                                                <form id="demo-form2" method="GET" action="{{ route('buynow') }}"
                                                                    data-parsley-validate class="form-horizontal form-label-left">
                                                                    <input type="hidden" name="category_id" value="{{$course->category->id}}" />
                                                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                                                    <input type="hidden" name="course_id" value="{{$course->id}}" />
                                                                    <div class="box-footer">
                                                                        <button type="submit" class="btn btn-primary">&nbsp;{{ __('BUY NOW') }}</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        @endif

                                                    @endif


                                                @endif
                                                @else
                                                <div class="about-home-btn btm-20">
                                                    @if($gsetting->guest_enable == 1)

                                                    <form id="demo-form2" method="post" action="{{ route('guest.addtocart', $course->id) }}"
                                                        data-parsley-validate class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}


                                                        <div class="box-footer">
                                                        <button type="submit" class="btn btn-primary"><i data-feather="shopping-cart"></i>&nbsp;{{ __('Add To Cart') }}</button>
                                                        </div>
                                                    </form>
                                                    @else

                                                    <a href="{{ route('login') }}" class="btn btn-primary"><i data-feather="shopping-cart"></i>&nbsp;{{ __('Add To Cart') }}</a>

                                                    @endif

                                                </div>
                                            @endif

                                            @else
                                            <div class="about-home-rate">
                                                <ul>
                                                    <li>{{ __('Free') }}</li>
                                                </ul>
                                            </div>
                                            @if(Auth::check())
                                                @if(Auth::User()->role == "admin")
                                                    <div class="about-home-btn btm-20">
                                                        <a href="{{ route('course.content',['slug' => $course->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                                    </div>
                                                    @else
                                                    @php
                                                        $enroll = App\Order::where('user_id', Auth::User()->id)->where('course_id', $course->id)->first();
                                                    @endphp
                                                    @if($enroll == NULL)
                                                        <div class="about-home-btn btm-20">
                                                            <a href="{{url('enroll/show',$course->id)}}" class="btn btn-primary" title="Enroll Now">{{ __('Enroll Now') }}</a>
                                                        </div>
                                                    @else
                                                        <div class="about-home-btn btm-20">
                                                            <a href="{{ route('course.content',['slug' => $course->slug ]) }}" class="btn btn-secondary" title="Cart">{{ __('Go To Course') }}</a>
                                                        </div>
                                                    @endif
                                                @endif
                                                @else
                                                <div class="about-home-btn btm-20">
                                                    <a href="{{ route('login') }}" class="btn btn-primary" title="Enroll Now">{{ __('Enroll Now') }}</a>
                                                </div>
                                            @endif
                                        @endif
                                    </li>
                                    <li class="course-detail-button">
                                        <div class="row">
                                            <div class="col">
                                                <div class="about-home-share text-center">
                                                    <a href="https://calendar.google.com/calendar/r/eventedit?text={{ $course['title'] }}" target="__blank"><i data-feather="calendar"></i></a>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="about-home-share text-center">
                                                    <a href="#" data-toggle="modal" data-target="#myModalshare" title="share" data-dismiss="modal"><i data-feather="share"></i></a>
                                                </div>
                                            </div>
                                            {{-- <div class="col">
                                                <div class="about-home-share text-center">
                                                    @auth
                                                        @if($course->type == 1)
                                                        
                                                        <div><a href="{{ route('gift.view',['id' => $course->id, 'slug' => $course->slug ]) }}" title="gift"><i data-feather="gift"></i></a></div>
                                                        @endif

                                                    @endauth
                                                    @guest
                                                        @if($course->type == 1)
                                                        
                                                        <div><a href="{{ route('login') }}" title="gift"><i data-feather="gift"></i></a></div>
                                                        @endif
                                                    @endguest
                                                </div>
                                            </div> --}}
                                            <div class="col">
                                                <div class="about-home-share text-center">
                                                    @if(Auth::check())

                                                        @if($wish == NULL)
                                                            <div class="about-icon-one">
                                                                <form id="demo-form2" method="post" action="{{ url('show/wishlist', $course->id) }}" data-parsley-validate
                                                                    class="form-horizontal form-label-left">
                                                                    @csrf

                                                                    <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
                                                                    <input type="hidden" name="course_id"  value="{{$course->id}}" />

                                                                    <button class="wishlisht-btn" title="{{ __('Add to wishlist')}}" type="submit"><i data-feather="heart"></i></button>
                                                                </form>
                                                            </div>
                                                        @else
                                                            <div class="about-icon-two">
                                                                <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $course->id) }}" data-parsley-validate
                                                                    class="form-horizontal form-label-left">
                                                                    @csrf

                                                                    <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
                                                                    <input type="hidden" name="course_id"  value="{{$course->id}}" />

                                                                    <button class="wishlisht-btn" title="{{ __('Remove from Wishlist')}}" type="submit"><i data-feather="heart"></i></button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="about-icon-one"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="about-home-share text-center">
                                                    @if(Auth::check())
                                                        <div class="report-abuse text-center">
                                                            <a href="#" data-toggle="modal" data-target="#myModalCourse" title="Report"><i data-feather="flag"></i></a>
                                                        </div>
                                                    @else
                                                        <div class="report-abuse text-center">
                                                            <a href="{{ route('login') }}" title="Report"><i data-feather="flag"></i></a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                </aside>
                
                
                    
                </div>

                
            </div>
        </div>
    </div>
</section>
<!--End Project Detail -->
<!-- brand-area -->
@php
    $trusted = App\Trusted::where('status', '1')->get();
@endphp
<div class="brand-area pt-60 pb-60" >
    <div class="container">
        <div class="row brand-active">
        @foreach($trusted as $trust)
            <div class="col-xl-2">
                <div class="single-brand owl-carousel">
                    <img src="{{ asset('images/trusted/'.$trust['image']) }}" class="img-fluid owl-lazy" alt="img">
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>
@endsection