<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @include('theme.head')
</head>
<body>
@yield('content')
<section id="nav-bar" class="nav-bar-main-block landing-nav-bar" data-toggle="sticky-onscroll">
    <div class="container-xl">
        <div class="logo text-center">
            @if($gsetting->logo_type == 'L')
                <a href="{{ url('/') }}" ><img src="{{ asset('images/logo/'.$gsetting->logo) }}" class="img-fluid" alt="logo"></a>
            @else()
                <a href="{{ url('/') }}"><b><div class="logotext">{{ $gsetting->project_title }}</div></b></a>
            @endif
        </div>
    </div>
</section>
@if(isset($sliders))
<section id="home-background-slider" class="background-slider-block owl-carousel">
    <div class="lazy item home-slider-img">
        @foreach($sliders as $slider)
        @if($slider->status == 1)
        <div id="home" class="home-main-block landing-home-main-block" style="background-image: url('{{ asset('images/slider/'.$slider['image']) }}')">
            <div class="container-xl">
                <div class="row">
                    <div class="col-lg-12 {{$slider['left'] == 1 ? 'col-md-offset-6 col-sm-offset-6 col-sm-6 col-md-6 text-right' : ''}}">
                        <div class="home-dtl">
                            <div class="home-heading">{{ $slider['heading'] }}</div>
                            <p class="btm-10">{{ $slider['sub_heading'] }}</p>
                            <p class="btm-20">{{ $slider['detail'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
</section>
@endif
@if(isset($facts))
<section id="learning-work" class="learning-work-main-block">
    <div class="container-xl">
        <div class="row">
            @foreach($facts as $fact)
            <div class="col-lg-4 col-md-4">
                <div class="learning-work-block">
                    <div class="row">
                        <div class="col-lg-3 col-md-3">
                            <div class="learning-work-icon">
                                <i class="fa {{ $fact['icon'] }}"></i>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9">
                            <div class="learning-work-dtl">
                                <div class="work-heading">{{ $fact['heading'] }}</div>
                                <p>{{ $fact['sub_heading'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@if($hsetting->fact_enable == 1 && isset($factsetting))
<section id="facts" class="fact-main-block">
    <div class="container-xl">
        <div class="row">
            @foreach($factsetting as $factset)
            <div class="col-lg-3 col-md-6 col-12"> 
                <div class="facts-block text-center">
                    <div class="facts-block-one">
                        <div class="facts-block-img">
                            @if($factset['image'] !== NULL && $factset['image'] !== '')
                            <img src="{{ url('/images/facts/'.$factset->image) }}" class="img-fluid" alt="{{$factset->title}}" />
                            @else
                            <img src="{{ Avatar::create($factset->title)->toBase64() }}" alt="course"
                                class="img-fluid">
                            @endif
                            <div class="facts-count">{{ $factset->number }}</div>
                        </div>                        
                        <h5 class="facts-title"><a href="#" title="{{ $factset->title }}">{{ $factset->title }}</a></h5>
                        <p>{{ $factset->description }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@if($hsetting->testimonial_enable == 1 && ! $testi->isEmpty() )
<section id="testimonial" class="testimonial-main-block">
    <div class="container-xl">
        <h4>{{ __('Testimonial') }}</h4>
        <div id="testimonial-slider" class="testimonial-slider-main-block owl-carousel">
            @foreach($testi as $tes)
            <div class="item testi-block text-center">
                <div class="testi-block-images">
                    <img src="{{ url('images/testimonial/testimonial.png') }}" class="img-fluid" alt="{{ $tes['client_name'] }}"> 
                </div>
                <div class="testi-block-one">
                    <div class="testi-img text-center">
                        <img data-src="{{ asset('images/testimonial/'.$tes['image']) }}" alt="blog" class="img-fluid owl-lazy">
                    </div>
                    <div class="testi-dtl text-center">
                        <div class="testi-name">
                            <h5 class="testi-heading mb-1">{{ $tes['client_name'] }}</h5>
                            <p class="testi-para p-0">{{ $tes['designation'] }}</p>
                        </div>
                        <div class="testi-rating mb-2">
                            @for($i = 1; $i <= 5; $i++) @if($i<=$tes->rating)
                                <i class='fa fa-star' style='color:orange'></i>
                                @else
                                <i class='fa fa-star' style='color:#ccc'></i>
                                @endif
                            @endfor
                        </div>
                        <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($tes->details))) , $limit = 300, $end = '...') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@if($hsetting->video_enable == 1 &&  isset($videosetting) )
<section id="video" class="video-main-block landing-video">
    <div class="container-fluid p-0">
        @if($videosetting['image'] !== NULL && $videosetting['image'] !== '')
        <div class="video-block parallax" style="background-image: url({{ 'images/videosetting/'.$videosetting->image }});">
        @else
        <div class="video-block parallax" style="background-image: url({{ Avatar::create($videosetting->tittle)->toBase64() }});">
        @endif
            <div class="overlay-bg"></div>
        </div>
        <div class="video-play-btn">
            <a class="play-btn" href="#video_modal" data-toggle="modal"></a>
            <div id="video_modal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe id="elearningVideo" class="embed-responsive-item" width="560" height="315" src="{{$videosetting->url}}" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="video-dtl text-center">
            <h3 class="video-heading text-white">{{ $videosetting->tittle }}</h3>
            <p class="text-white">{{ $videosetting->description }}</p>
        </div>
    </div>
</section>  
@endif
@if($hsetting->service_enable == 1 && ! $services->isEmpty() && isset($servicesetting) )
<section id="services" class="services-main-block">
    <div class="container-xl">
        <h4>{{ __('Our Service') }}</h4>
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="service-side-img">
                    @if($servicesetting['image'] == !NULL)
                    <img src="{{ asset('images/services/'.$servicesetting['image']) }}" class="img-fluid" alt="{{$servicesetting->title}}">
                    @else
                    <img src="{{ Avatar::create($servicesetting->title)->toBase64() }}" class="img-fluid" alt="{{$servicesetting->title}}">
                    @endif
                    <div class="overlay-bg"></div>
                </div>
                <div class="service-side-dtl text-center">
                    <h3 class="service-heading mb-4">{{ $servicesetting->title }}</h3>
                    <p class="mb-4">{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($servicesetting->detail))) , $limit = 300, $end = '...') }}</p>
                    <a href="{{ route('front.service') }}" type="button" class="btn btn-primary mt-2" title="View More">{{ __('View More') }} <i data-feather="chevrons-right"></i></a>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="row">
                    @foreach($services as $ser)
                    <div class="col-lg-4 col-md-6">
                        <div class="service-block">
                            <div class="service-img text-center">
                                @if($ser['image'] == !NULL)
                                    <img src="{{ asset('images/services/'.$ser['image']) }}" class="img-fluid" alt="{{$ser->title}}">
                                @else
                                    <img src="{{ Avatar::create($ser->title)->toBase64() }}" class="img-fluid" alt="{{ $ser->title }}">
                                @endif
                            </div>
                            <div class="service-dtl text-center">
                                <h5 class="service-heading mb-2">{{ $ser->title }}</h5>
                                <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($ser->detail))) , $limit = 80, $end = '...') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach 
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@if($hsetting->get_enable == 1 && isset($get_enable))
<section id="get-started" class="get-started-main-block landing-get-started">
    <div class="container-fluid p-0">
        <div class="get-started-block">
            @if($get_enable['image'] !== NULL && $get_enable['image'] !== '')
            <div class="get-started-bg-image parallax" style="background-image: url({{ 'images/getstarted/'.$get_enable->image }});">
            @else
            <div class="get-started-bg-image parallax" style="background-image: url({{ Avatar::create($get_enable->heading)->toBase64() }});">
            @endif 
                <div class="overlay-bg"></div>
            </div>
            <div class="get-started-dtl text-center">
                <h1 class="get-started-title text-white mb-2 text-center">{{ $get_enable->heading }}</h1>
                <h4 class="get-started-sub-title text-white text-center">{{ $get_enable->sub_heading }}</h4>
                <a href="{{ $get_enable->link }}" type="button" class="btn btn-primary">{{ $get_enable->button_txt }}</a>
            </div>
        </div>
    </div>
</section>
@endif
@if($hsetting->feature_enable == 1 && ! $feature->isEmpty() && isset($featuresetting) )
<section id="feature" class="feature-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-7 col-md-7">
                <div class="feature-block">
                    <h4 class="feature-title">{{ $featuresetting->title }}</h4>
                    <p>{{  $featuresetting->detail }}</p>
                </div>
                <div class="feature-dtl-block">
                    <div class="row">
                        @foreach($feature as $data)
                        <div class="col-lg-6 col-md-6 mb-4">
                            <div class="feature-dtl-icon">
                                @if($data['image'] == !NULL)
                                    <img src="{{ asset('images/feature/'.$data['image']) }}" class="img-fluid" alt="{{ $data->title }}">
                                @else
                                    <img src="{{ Avatar::create($data->title)->toBase64() }}" class="img-fluid" alt="{{ $data->title }}">
                                @endif  
                            </div>    
                            <div class="feature-dtl">
                                <h5 class="feature-dtl-title mb-2">{{ $data->title }}</h5>
                                <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($data->detail))) , $limit = 300, $end = '...') }}</p>                       
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ route('front.feature') }}" type="button" class="btn btn-primary" title="View More">{{ __('View More') }} <i data-feather="chevrons-right"></i></a>
                </div>
            </div>
            <div class="col-lg-5 col-md-5">
                <div class="feature-image">
                    @if($featuresetting['image'] == !NULL)
                    <img src="{{ asset('images/feature/'.$featuresetting['image']) }}" class="img-fluid" alt="{{$featuresetting->title}}">
                @else
                    <img src="{{ Avatar::create($featuresetting->title)->toBase64() }}" class="img-fluid" alt="{{$featuresetting->title}}">
                @endif                  
            </div>
            </div>
        </div>
    </div>
</section>
@endif
@if($hsetting->trusted_enable == 1 && ! $trusted->isEmpty() )
<section id="trusted" class="trusted-main-block">
    <div class="container-xl">
        <div class="patners-block">

            <h6 class="patners-heading btm-40">{{ __('Trusted By Companies') }}</h6>
            <div id="patners-slider" class="patners-slider owl-carousel">
                @foreach($trusted as $trust)
                <div class="item-patners-img">
                    <a href="{{ $trust['url'] }}" target="_blank"><img
                            data-src="{{ asset('images/trusted/'.$trust['image']) }}" class="img-fluid owl-lazy"
                            alt="patners-1"></a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</section>
@endif
@if(isset($qr))
<section id="download-apk" class="download-apk-main-block" style="background-image: url({{ 'images/qr/qr_bg.png' }});">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="download-apk-side-img">
                    <img src="{{ asset('images/qr/'.$qr['demo_image']) }}" class="img-fluid" alt="{{ __('QR')}}">
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="download-apk-block text-center">
                    <h2 class="download-title mb-2">{{ __('Download Apks for Android') }}</h2>
                    <p>{{ __('Please scan the QR code and download the app') }}</p>
                </div>
                <div class="download-apk-img text-center">
                    <div class="row">
                        <div class="col-lg-6 col-6">
                            <h5 class="apk-heading">{{ __('Download Instructor') }} <br>{{ __('APK for Android') }}</h5>
                            <img src="{{ asset('images/qr/'.$qr['image']) }}" class="img-fluid" alt="{{ __('QR')}}">
                        </div>
                        <div class="col-lg-6 col-6">
                            <h5 class="apk-heading">{{ __('Download User ') }}<br>{{ __('APK for Android') }}</h5>
                            <img src="{{ asset('images/qr/'.$qr['image2']) }}" class="img-fluid" alt="{{ __('QR')}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- testimonial end -->
<!-- footer start -->
@include('theme.footer')
<!-- footer end -->
<!-- jquery -->
@include('theme.scripts')
</body>
</html>