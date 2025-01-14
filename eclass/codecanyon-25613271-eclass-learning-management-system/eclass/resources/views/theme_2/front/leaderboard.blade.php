@extends('theme2.master')
@section('title', "My Leaderboard")
@section('content')
@include('admin.message')
<!-- course detail header start -->
@section('custom-head')
<style>
    .green .progress .inner .water {
      top: {{ $all_total_reverse }}%;
    }
</style>
@endsection
<section class="growth-main-block">
    <div class="container-xl">
        <div class="row g-0">
            <div class="col-lg-4 col-md-12">
                <div class="engagement-bar">
                    <h3 class="engagement-heading">{{ __('Engagement')}}</h3>
                    <div class="wrapper">                  
                      <div class="green">
                        <div class="progress">
                          <div class="inner">
                            <div class="percent"><span>{{ $all_total }}</span>%</div>
                            <div class="water"></div>
                            <div class="glare"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <h4 class="wrapper-heading text-center">{{ __('Looking Good')}} !</h4>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-4">
                            <div class="leader-progress-bar">
                                <div class="progress" data-percentage="{{ $social_total }}">
                                    <span class="progress-left">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <span class="progress-right">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <div class="progress-value">
                                        <div>
                                            {{ $social_total }}%
                                        </div>
                                    </div>
                                </div>
                                <h4 class="progress-heading text-center">{{ __('Social')}}</h4>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-4">
                            <div class="leader-progress-bar">
                                <div class="progress" data-percentage="{{ $progres }}">
                                    <span class="progress-left">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <span class="progress-right">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <div class="progress-value">
                                        <div>
                                            {{ $progres }}%
                                        </div>
                                    </div>
                                </div>
                                <h4 class="progress-heading text-center">{{ __('Learning')}}</h4>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-4">
                            <div class="leader-progress-bar">
                                <div class="progress" data-percentage="{{ $quiz_total }}">
                                    <span class="progress-left">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <span class="progress-right">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <div class="progress-value">
                                        <div>
                                            {{ $quiz_total }}%
                                        </div>
                                    </div>
                                </div>
                                <h4 class="progress-heading text-center">{{ __('Quiz')}}</h4>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="growth-block">
                    <div class="row">
                        <div class="col-lg-6 col-md-5">
                            <div class="profile-block text-center">

                                @if(Auth::User()->user_img != null || Auth::User()->user_img !='')
                                    <img src="{{ url('/images/user_img/'.Auth::User()->user_img) }}" class="profile-block-img">
                                @else
                                    <img src="{{ asset('images/default/user.jpg')}}" class="profile-block-img">

                                @endif

                                
                                <h3 class="profile-block-heading text-center text-white"> {{ Auth::user()->fname }} {{ Auth::user()->lname }}</h3>
                                <ul class="text-center">
                                    @if(isset( Auth::user()->address))
                                    <li><i class="fa fa-map-marker"></i> {{ Auth::user()->address }}</li>
                                    @endif

                                    <li><i class="fa fa-envelope" aria-hidden="true"></i> 
                                    {{ Auth::user()->email }}</li>

                                    @if(isset( Auth::user()->mobile))
                                    <li><i class="fa fa-phone"></i> {{ Auth::user()->mobile }}</li>
                                    @endif
                                   
                                </ul>

                               
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-7">
                            <div class="profile-dtl-block">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-4 text-center">
                                        <i class="fas fa-certificate"></i>
                                        <h5 class="profile-dtl-block-heading">{{ $total_courses }}</h5>
                                        <p>{{ __('Enrolled Courses')}}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-4 text-center">
                                        <i class="fas fa-trophy"></i>
                                        <h5 class="profile-dtl-block-heading">{{ $total_progess }}</h5>
                                        <p>{{ __('Course Completed')}}</p>
                                    </div>
                                   
                                    <div class="col-lg-4 col-md-4 col-4 text-center">
                                        <i class="fas fa-award"></i>
                                        <h5 class="profile-dtl-block-heading">{{ $live_meeting_count }}</h5>
                                        <p>{{ __('Live Classes')}}</p>
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



<section id="online-blog" class="online-blog-main-block">
    <div class="container-xl">
     
        <div class="row">
            <div class="col-lg-12">
                <div class="bdr-yellow"></div>
                <div class="online-blog-block">
                    <p>{!! Auth::user()->detail !!}</p>
                   
                </div>
            </div>
            
        </div>
    </div>
</section>


<!-- course detail end -->
@endsection
















































































































{{-- @extends('theme.master')
@section('title', "My Leaderboard")
@section('content')
@include('admin.message')
<!-- course detail header start -->
@section('custom-head')
<style>
    .green .progress .inner .water {
      top: {{ $all_total_reverse }}%;
    }
</style>
@endsection
<section class="growth-main-block">
    <div class="container-fluid">
        <div class="row no-gutters">
            <div class="col-lg-4 col-md-12">
                <div class="engagement-bar">
                    <h3 class="engagement-heading">{{ __('Engagement')}}</h3>
                    <div class="wrapper">                  
                      <div class="green">
                        <div class="progress">
                          <div class="inner">
                            <div class="percent"><span>{{ $all_total }}</span>%</div>
                            <div class="water"></div>
                            <div class="glare"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <h4 class="wrapper-heading text-center">{{ __('Looking Good')}} !</h4>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-4">
                            <div class="leader-progress-bar">
                                <div class="progress" data-percentage="{{ $social_total }}">
                                    <span class="progress-left">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <span class="progress-right">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <div class="progress-value">
                                        <div>
                                            {{ $social_total }}%
                                        </div>
                                    </div>
                                </div>
                                <h4 class="progress-heading text-center">{{ __('Social')}}</h4>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-4">
                            <div class="leader-progress-bar">
                                <div class="progress" data-percentage="{{ $progres }}">
                                    <span class="progress-left">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <span class="progress-right">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <div class="progress-value">
                                        <div>
                                            {{ $progres }}%
                                        </div>
                                    </div>
                                </div>
                                <h4 class="progress-heading text-center">{{ __('Learning')}}</h4>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-4">
                            <div class="leader-progress-bar">
                                <div class="progress" data-percentage="{{ $quiz_total }}">
                                    <span class="progress-left">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <span class="progress-right">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <div class="progress-value">
                                        <div>
                                            {{ $quiz_total }}%
                                        </div>
                                    </div>
                                </div>
                                <h4 class="progress-heading text-center">{{ __('Quiz')}}</h4>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="growth-block">
                    <div class="row">
                        <div class="col-lg-6 col-md-5">
                            <div class="profile-block text-center">

                                @if(Auth::User()->user_img != null || Auth::User()->user_img !='')
                                    <img src="{{ url('/images/user_img/'.Auth::User()->user_img) }}" class="profile-block-img">
                                @else
                                    <img src="{{ asset('images/default/user.jpg')}}" class="profile-block-img">

                                @endif

                                
                                <h3 class="profile-block-heading text-center text-white"> {{ Auth::user()->fname }} {{ Auth::user()->lname }}</h3>
                                <ul class="text-center">
                                    @if(isset( Auth::user()->address))
                                    <li><i class="fa fa-map-marker"></i> {{ Auth::user()->address }}</li>
                                    @endif

                                    <li><i class="fa fa-envelope" aria-hidden="true"></i> 
                                    {{ Auth::user()->email }}</li>

                                    @if(isset( Auth::user()->mobile))
                                    <li><i class="fa fa-phone"></i> {{ Auth::user()->mobile }}</li>
                                    @endif
                                   
                                </ul>

                               
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-7">
                            <div class="profile-dtl-block">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-4 text-center">
                                        <i class="fas fa-certificate"></i>
                                        <h5 class="profile-dtl-block-heading">{{ $total_courses }}</h5>
                                        <p>{{ __('Enrolled Courses')}}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-4 text-center">
                                        <i class="fas fa-trophy"></i>
                                        <h5 class="profile-dtl-block-heading">{{ $total_progess }}</h5>
                                        <p>{{ __('Course Completed')}}</p>
                                    </div>
                                   
                                    <div class="col-lg-4 col-md-4 col-4 text-center">
                                        <i class="fas fa-award"></i>
                                        <h5 class="profile-dtl-block-heading">{{ $live_meeting_count }}</h5>
                                        <p>{{ __('Live Classes')}}</p>
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



<section id="online-blog" class="online-blog-main-block">
    <div class="container-xl">
     
        <div class="row">
            <div class="col-lg-12">
                <div class="bdr-yellow"></div>
                <div class="online-blog-block">
                    <p>{!! Auth::user()->detail !!}</p>
                   
                </div>
            </div>
            
        </div>
    </div>
</section>


<!-- course detail end -->
@endsection

 --}}
