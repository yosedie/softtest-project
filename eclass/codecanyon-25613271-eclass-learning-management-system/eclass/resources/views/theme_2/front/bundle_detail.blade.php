@extends('theme2.master')
@section('title', "$bundle->title")
@section('content')

@section('meta_tags')

@php
    $url =  URL::current();
@endphp

<meta name="title" content="{{ $bundle['title'] }}">
<meta name="description" content="{{ $bundle['short_detail'] }} ">
<meta name="author" content="elsecolor">
<meta property="og:title" content="{{ $bundle['title'] }} ">
<meta property="og:url" content="{{ $url }}">
<meta property="og:description" content="{{ $bundle['short_detail'] }}">
<meta property="og:image" content="{{ asset('images/bundle/'.$bundle['preview_image']) }}">
<meta itemprop="image" content="{{ asset('images/bundle/'.$bundle['preview_image']) }}">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="{{ asset('images/bundle/'.$bundle['preview_image']) }}">
<meta property="twitter:title" content="{{ $bundle['title'] }} ">
<meta property="twitter:description" content="{{ $bundle['short_detail'] }}">
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
                            <h2>{{__('Bundle Detail')}}</h2>  
                        </div>
                    </div>
                </div>
                <div class="breadcrumb-wrap2">
                    
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('Bundle Details')}}</li>
                        </ol>
                    </nav>
                </div>
                
            </div>
        </div>
    </section>
<!-- breadcrumb-area-end -->
@include('admin.message')
<!-- bundle detail start -->
<section class="project-detail">
    <div class="container">
        <div class="lower-content">
            <div class="row">
                <div class="text-column col-lg-9 col-md-8 col-sm-12">
                    <h2>{{ $bundle['title'] }}</h2>
                
                    <div class="upper-box">
                        <div class="single-item-carousel">
                            @if ($bundle['preview_image'] !== null && $bundle['preview_image'] !== '')
                                <img src="{{ asset('images/bundle/' . $bundle['preview_image']) }}"
                                    class="bg_img img-fluid" width="100%" alt="Background">
                            @else
                                <img src="{{ Avatar::create($bundle->title)->toBase64() }}" width="100%" class="bg_img img-fluid"
                                    alt="Background">
                            @endif
                        </div>
                    </div>
                    <div class="inner-column">
                        <ul class="mb-4">
                            <li class="d-inline-block"><a href="#" title="about">{{ __('Created') }}:
                                    {{ $bundle->user['fname'] }} </a></li>
                            <li class="d-inline-block float-end"><a href="#" title="about">{{ __('Last Updated') }}:
                                    {{ date('jS F Y', strtotime($bundle['updated_at'])) }}</a></li>

                        </ul>
                    </div>
                    <div class="requirements">
                        <h3>{{ __('Detail') }}</h3>
                        <ul>
                            <li class="comment more">

                                {!! $bundle->detail !!}

                            </li>

                        </ul>
                    </div>
                    <div class="course-content-block btm-30">
                        <h3>{{ __('Courses In Bundle') }}</h3>
                        <!-- FSMS -->

                        <div class="row" style="padding-bottom:10px">
                            <div class="col-lg-8 col-md-6 col-12 mb-3">
                                @php
                                // FSMS
                                function convertToHoursMins($time, $format = '%02d:%02d') {
                                    if ($time < 1) {
                                        return;
                                    }
                                    $hours =floor($time / 60);
                                    $minutes = ($time % 60);

                                    return sprintf($format, $hours, $minutes);
                                }

                                $courseCount = count( $bundle['course_id'] )

                                // FSMS
                            @endphp

                            <small> &nbsp; {{ $courseCount . " courses" }}</small>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 text-start text-md-end text-lg-end">
                                <button type="button" onclick="toggleAllSections()" class="btn btn-link courseToggle text-white">{{__('Expand all courses')}}</button>
                                <button type="button" onclick="toggleAllSections()" class="btn btn-link courseToggle text-white"
                                    style="display:none">{{__('Collapse all')}}
                                            {{__('courses')}}</button>
                            </div>
                        </div>


                        <!-- FSMS -->

                        <div class="faq-block">
                            <div class="faq-dtl">
                                <div id="accordion" class="second-accordion">
                                    @foreach ($bundle->course_id as $bundles)

                                        @php
                                        $course = App\Course::where('id', $bundles)->first();
                                        @endphp
                                        @if(isset($course))
                                        <div class="card">
                                            <div class="card-header" id="headingTwo{{ $course->id }}">
                                                <div class="mb-0">
                                                    <button class="btn btn-link" data-toggle="collapse"
                                                        data-target="#collapseTwo{{ $course->id }}" aria-expanded="false"
                                                        aria-controls="collapseTwo">

                                                        <div class="row">
                                                            <div class="col-lg-8 col-12">
                                                                <a
                                                                    href="{{ route('user.course.show', ['slug' => $course->slug]) }}">{{ $course->title }}</a>
                                                            </div>

                                                        </div>

                                                    </button>
                                                </div>

                                            </div>

                                            <div id="collapseTwo{{ $course->id }}" class="collapse"
                                                aria-labelledby="headingTwo" data-parent="#accordion">

                                                <div class="card-body">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <td class="class-icon">
                                                                    {{ $course->short_detail }}
                                                                </td>
                                                            </tr>
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
                </div>
                <div class="col-lg-3 col-md-4">
                    <aside class="sidebar-widget info-column">
                        <div class="inner-column3">
                            <h3>{{ __('Course Features') }}</h3>
                            <ul class="project-info clearfix">
                                @if ($bundle->type == 1)
                                    <li>
                                        <div class="priceing"> 
                                                @if ($bundle->is_subscription_enabled == 1)
                                                    @if($bundle->discount_price == !null)
                                                        <strong>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($bundle->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}/{{ $bundle->billing_interval }}</strong>
                                                        <sub>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($bundle->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}/{{ $bundle->billing_interval }}</sub>
                                                        
                                                    @else
                                                        
                                                    <strong>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($bundle->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}/{{ $bundle->billing_interval }}</strong>
                                                        
                                                    @endif
                                                @else
                                                    @if ($bundle->discount_price == !null)
                                                            
                                                    <strong>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($bundle->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}/{{ $bundle->billing_interval }}</strong>
                                                    <sub>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($bundle->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}/{{ $bundle->billing_interval }}</sub>
                                                    
                                                    @else
                                                        
                                                    <strong>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($bundle->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}/{{ $bundle->billing_interval }}</strong>
                                                    
                                                    @endif
                                                @endif
                                        </div>
                                    </li>
                                    <li class="course-detail-button">
                                        @if (Auth::check())
                                            @if (Auth::User()->role == 'admin')
                                                <div class="about-home-btn btm-20">
                                                    <a href="" class="btn btn-secondary"
                                                        title="course">{{ __('Purchased') }}</a>
                                                </div>
                                                @else


                                                @php
                                                $order = App\Order::where('user_id', Auth::User()->id)->where('bundle_id',
                                                $bundle->id)->first();
                                                @endphp



                                                @if (!empty($order) && $order->status == 1)

                                                    <div class="about-home-btn btm-20">
                                                        <a href="" class="btn btn-secondary"
                                                            title="course">{{ __('Purchased') }}</a>
                                                    </div>

                                                    @else
                                                        @php
                                                        $cart = App\Cart::where('user_id', Auth::User()->id)->where('bundle_id',
                                                        $bundle->id)->first();
                                                        @endphp
                                                        @if (!empty($cart))
                                                            <div class="about-home-btn btm-20">
                                                                <form id="demo-form2" method="post"
                                                                    action="{{ route('remove.item.cart', $cart->id) }}">
                                                                    {{ csrf_field() }}

                                                                    <div class="box-footer">
                                                                        <button type="submit" class="btn btn-primary"><i
                                                                                class="fa fa-shopping-cart"
                                                                                aria-hidden="true"></i>&nbsp;{{ __('Remove From Cart') }}</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        @else
                                                        <div class="about-home-btn btm-20">
                                                            <form id="demo-form2" method="post"
                                                                action="{{ route('bundlecart', $bundle->id) }}"
                                                                data-parsley-validate class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}

                                                                <div class="box-footer">
                                                                    @if ($bundle->is_subscription_enabled == 1)
                                                                        <button type="submit" class="btn btn-primary"><i
                                                                                class="fa fa-cart-plus"
                                                                                aria-hidden="true"></i>&nbsp;{{ __('Subscribe Now') }}</button>
                                                                    @else
                                                                        <button type="submit" class="btn btn-primary"><i
                                                                                class="fa fa-cart-plus"
                                                                                aria-hidden="true"></i>&nbsp;{{ __('Add To Cart') }}</button>
                                                                    @endif
                                                                </div>
                                                            </form>
                                                        </div>
                                                        @endif
                                                @endif
                                            @endif
                                            @else
                                            <div class="about-home-btn btm-20">
                                                @if ($bundle->is_subscription_enabled == 1)
                                                    <a href="{{ route('login') }}" class="btn btn-primary"><i
                                                            class="fa fa-cart-plus"
                                                            aria-hidden="true"></i>&nbsp;{{ __('Subscribe Now') }}</a>
                                                @else

                                                    <a href="{{ route('login') }}" class="btn btn-primary"><i
                                                            class="fa fa-cart-plus"
                                                            aria-hidden="true"></i>&nbsp;{{ __('Add To Cart') }}</a>
                                                @endif
                                            </div>
                                        @endif
                                    </li>
                                @else
                                    <li class="course-detail-button">
                                        <div class="about-home-rate">
                                            <ul>
                                                <li>{{ __('Free') }}</li>
                                            </ul>
                                        </div>
                                        @if (Auth::check())
                                            @if (Auth::User()->role == 'admin')
                                                <div class="about-home-btn btm-20">
                                                    <a href="" class="btn btn-secondary"
                                                        title="course">{{ __('Purchased') }}</a>
                                                </div>
                                            @else
                                                @php
                                                $enroll = App\Order::where('user_id', Auth::User()->id)->where('bundle_id',
                                                $bundle->id)->first();
                                                @endphp
                                                @if ($enroll == null)
                                                    <div class="about-home-btn btm-20">
                                                        <a href="{{ url('bundle/enroll', $bundle->id) }}"
                                                            class="btn btn-primary"
                                                            title="Enroll Now">{{ __('Enroll Now') }}</a>
                                                    </div>
                                                @else
                                                    <div class="about-home-btn btm-20">
                                                        <a href="" class="btn btn-secondary"
                                                            title="Cart">{{ __('Purchased') }}</a>
                                                    </div>
                                                @endif
                                            @endif
                                        @else
                                            <div class="about-home-btn btm-20">
                                                <a href="{{ route('login') }}" class="btn btn-primary"
                                                    title="Enroll Now">{{ __('Enroll Now') }}</a>
                                            </div>
                                        @endif
                                    </li>
                                @endif
                                <li class="course-detail-button">
                                    <div class="row">
                                        <div class="col-md-6 col-6">
                                            <div class="about-home-share text-center">
                                                <a href="https://calendar.google.com/calendar/r/eventedit?text={{ $bundle['title'] }}" target="__blank"><i data-feather="calendar"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6">
                                            <div class="about-home-share text-center">
                                                <a href="#" data-toggle="modal" data-target="#myModalshare" title="share" data-dismiss="modal"><i data-feather="share"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </li>

                            </ul>
                            <!--Model start-->
                            <div class="modal fade" data-backdrop="" style="z-index: 1050;" id="myModalshare" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">

                                        <h4 class="modal-title" id="myModalLabel">{{ __('Share this course') }}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="box box-primary">
                                        <div class="panel panel-sum">
                                            <div class="modal-body">

                                                @php
                                                $url=  URL::current();
                                                @endphp

                                                <!-- The text field -->

                                                <div class="nav-search d-flex mb-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="myInput"  value="{{ $url }}">
                                                    </div>
                                                    <button onclick="myFunction()" class="btn btn-primary">{{ __('CopyText') }}</button>
                                                </div>

                                                <div class="social-icon">

                                                @php

                                                echo Share::currentPage('', [], '<ul class="d-flex justify-content-center">')
                                                    ->facebook()
                                                    ->twitter()
                                                    ->linkedin('Extra linkedin summary can be passed here')
                                                    ->whatsapp()
                                                    ->telegram();

                                                @endphp

                                                </div>

                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Model close -->
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- bundle detail end -->
@endsection


@section('custom-script')
    <script>
        // FSMS
        function toggleAllSections() {
            $("div[id*='collapseTwo']").collapse('toggle');
            $(".courseToggle").toggle();
        }
        // FSMS

    </script>
    
<script>
    function myFunction() {
      /* Get the text field */
      var copyText = document.getElementById("myInput");
    
      /* Select the text field */
      copyText.select();
      copyText.setSelectionRange(0, 99999); /* For mobile devices */
    
      /* Copy the text inside the text field */
      navigator.clipboard.writeText(copyText.value);
      
      /* Alert the copied text */
    }
    </script>
@endsection