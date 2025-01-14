@extends('theme2.master')
@section('title')
@section('content')
@include('admin.message')
<!-- breadcumb start -->
@php
$gets = App\Breadcum::first();
@endphp

@if($gets['img'] !== NULL && $gets['img'] !== '')
<section class="breadcrumb-area d-flex  p-relative align-items-center"
    style="background-image: url('{{ asset('/images/breadcum/'.$gets->img) }}')">
    @else
    <section class="breadcrumb-area d-flex  p-relative align-items-center"
        style="background-image: url('{{ asset('Avatar::create($gets->text)->toBase64() ') }}')">
        @endif
        <div class="overlay-bg"></div>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-12 col-lg-12">
                    <div class="breadcrumb-wrap text-left">
                        <div class="breadcrumb-title">
                            <h2>{{ __('Student Profile') }}</h2>


                        </div>
                    </div>
                </div>
                <div class="breadcrumb-wrap2">

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('Student Profile')}}</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </section>
    <!-- breadcumb end -->
    <!-- breadcumb end -->
    <section id="student-profile" class="student-profile-main-block pt-120 pb-120">
        <div class="container-xl">
            <div class="row">
                <div class="col-lg-12">
                    <div class="student-profile-sidebar mb-4">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-12">
                                <div class="student-profile-img">
                                    @if($users['user_img'] !== NULL && $users['user_img'] !== '')
                                    <img src="{{ url('/images/user_img/'.$users->user_img) }}" class="img-fluid" />
                                    @else
                                    <img src="{{ Avatar::create($users->fname)->toBase64() }}" alt="{{ __('course')}}"
                                        class="img-fluid">
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-8 col-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-8 col-12">
                                        <h2 class="student-name">{{ $users->fname }} {{ $users->lname }}</h2>
                                    </div>
                                    <div class="col-lg-6 col-md-4 col-12">
                                        <div class="student-profile-share text-right">
                                            <a href="#" data-toggle="modal" data-target="#myModalshare" title="share"
                                                data-dismiss="modal"><i data-feather="share"></i>Share</a>
                                        </div>
                                    </div>
                                    <div class="modal fade" data-backdrop="" style="z-index: 1050;" id="myModalshare"
                                        tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        {{ __('Share this profile') }}</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"><span
                                                            aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="box box-primary">
                                                    <div class="panel panel-sum">
                                                        <div class="modal-body">
                                                            @php
                                                            $url= URL::current();
                                                            @endphp
                                                            <div class="nav-search">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" id="myInput"
                                                                        value="{{ $url }}">
                                                                </div>
                                                                <button onclick="myFunction()"
                                                                    class="btn btn-primary"><i
                                                                        data-feather="copy"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="student-des">
                                    <p>{{ $users->detail }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="student-course-info">
                        <div class="student-contact-dtl">
                            <h4>Contact</h4>
                            <p>{{ $users->mobile }}</p>
                        </div>
                        <div class="student-social-dtl">
                            <h4>{{__('Social Media')}}</h4>
                            <p><span>{{__('Email')}}: </span><br>{{ $users->email }}</p>
                            @isset($linkedin_url)
                            <p><span>{{__('Linkdin')}}: </span><br>{{ $users->linkedin_url }}</p>
                            @endisset
                            @isset($fb_url)
                            <p><span>{{__('Facebook')}}: </span><br>{{ $users->fb_url }}</p>
                            @endisset
                            @isset($youtube_url)
                            <p><span>{{__('youtube')}}: </span><br>{{ $users->youtube_url }}</p>
                            @endisset
                            @isset($twitter_url)
                            <p><span>{{__('Twitter')}}: </span><br>{{ $users->twitter_url }}</p>
                            @endisset
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="student-course-info">
                        <div class="student-courses">
                            <h4>{{__('My Courses')}}</h4>
                            <section id="learning-courses" class="learning-courses-main-block">
                                <div class="row">
                                    @foreach($enroll as $enrol)
                                    @if($enrol->course_id != NULL)
                                    @if($enrol->status == 1)
                                    @if($enrol->user_id == Auth::User()->id)
                                    <div class="col-lg-6 col-md-12 col-12">
                                        <div class="courses-item mb-30 ms-0 me-0 hover-zoomin  protip">

                                            <div class="thumb fix ">
                                                @if($enrol->courses['preview_image'] !== NULL && $enrol->courses['preview_image'] !== '')
                                                <a
                                                    href="{{ route('course.content',['slug' => $enrol->courses->slug ]) }}"><img
                                                        src="{{ asset('images/course/'.$enrol->courses->preview_image) }}" class="img-fluid"
                                                        alt="student">
                                                </a>
                                                @else
                                                <a href="{{ route('course.content',['slug' => $enrol->courses->slug ]) }}"><img
                                                        src="{{ Avatar::create($enrol->courses->title)->toBase64() }}" class="img-fluid"
                                                        alt="student"></a>
                                                @endif
                                            </div>
                                            <div class="courses-content"> 
                                                <h3><a href="{{ route('course.content',['slug' => $enrol->courses->slug ]) }}"> {{ $enrol->courses->title }}</a></h3>
                                            <div class="mycourse-progress">
                                
                                                <?php
                                                    $progress = App\CourseProgress::where('course_id', $enrol->course_id)->where('user_id', Auth::User()->id)->first();
                                                                    ?>
                                                @if(!empty($progress))
                    
                                                <?php
                                                                        
                                                    $total_class = $progress->all_chapter_id;
                                                    $total_count = count($total_class);
                    
                                                    $total_per = 100;
                    
                                                    $read_class = $progress->mark_chapter_id;
                                                    $read_count =  count($read_class);
                    
                                                    $progres = ($read_count/$total_count) * 100;
                                                    ?>
                    
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                                        style="width: <?php echo $progres; ?>%" aria-valuenow="100" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <div class="complete"><?php echo $progres; ?>% {{ __('Complete') }}</div>
                                                @else
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                                        style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <div class="complete">{{ __('Start Course') }}</div>
                                                @endif
                    
                                            </div>
                                           
                                        </div>
                                    </div>
                                    </div>
                                    @endif
                                    @endif
                                    @else

                                    @php
                                    $bundle_order = App\BundleCourse::where('id', $enrol->bundle_id)->first();
                                    @endphp
                                    @if(isset($bundle_order->course_id))
                                    @foreach($bundle_order->course_id as $bundle_course)
                                    @php

                                    $coursess = App\Course::where('id', $bundle_course)->first();

                                    @endphp

                                    <div class="col-lg-6 col-md-12 col-12">
                                        <div class="courses-item mb-30 ms-0 me-0 hover-zoomin  protip">

                                            <div class="thumb fix ">
                                                @if($enrol->courses['preview_image'] !== NULL && $enrol->courses['preview_image'] !== '')
                                                <a
                                                    href="{{ route('course.content',['slug' => $enrol->courses->slug ]) }}"><img
                                                        src="{{ asset('images/course/'.$enrol->courses->preview_image) }}" class="img-fluid"
                                                        alt="student">
                                                </a>
                                                @else
                                                <a href="{{ route('course.content',['slug' => $enrol->courses->slug ]) }}"><img
                                                        src="{{ Avatar::create($enrol->courses->title)->toBase64() }}" class="img-fluid"
                                                        alt="student"></a>
                                                @endif

                                            </div>
                                            <div class="courses-content">
                                                <h3><a
                                                    href="{{ route('course.content',['slug' => $coursess->slug ]) }}">{{ str_limit($coursess->title, $limit = 35, $end = '...') }}</a></h3>
                                                <div class="mycourse-progress">
                                                    <?php
                                                    $progress = App\CourseProgress::where('course_id', $coursess->id)->where('user_id', Auth::User()->id)->first();
                                                ?>
                                                @if(!empty($progress))
                    
                                                <?php
                                                                    
                                                    $total_class = $progress->all_chapter_id;
                                                    $total_count = count($total_class);
                    
                                                    $total_per = 100;
                    
                                                    $read_class = $progress->mark_chapter_id;
                                                    $read_count =  count($read_class);
                    
                                                    $progres = ($read_count/$total_count) * 100;
                                                ?>
                    
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                                        style="width: <?php echo $progres; ?>%" aria-valuenow="100" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <div class="complete"><?php echo $progres; ?>% {{ __('Complete') }}</div>
                                                @else
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                                        style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <div class="complete">{{ __('Start Course') }}</div>
                                                @endif
                                                   
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                    @endif
                                    @endforeach
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection
    @section('custom-script')
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