@extends('theme.master')
@section('title')
@section('content')
@include('admin.message')
<!-- breadcumb start -->
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
                        <h1 class="wishlist-home-heading">{{__('Student Profile')}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- breadcumb end -->
<section id="student-profile" class="student-profile-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-12">
                <div class="student-profile-sidebar mb-4">
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            <div class="student-profile-img">
                                @if($users['user_img'] !== NULL && $users['user_img'] !== '')
                                <img src="{{ url('/images/user_img/'.$users->user_img) }}"  class="img-fluid" />
                                @else
                                <img src="{{ Avatar::create($users->fname)->toBase64() }}" alt="{{ __('course')}}"
                                    class="img-fluid">
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8">
                            <div class="row">
                                <div class="col-lg-6 col-md-8">
                                    <h2 class="student-name">{{ $users->fname }} {{ $users->lname }}</h2>
                                </div>
                                <div class="col-lg-6 col-md-4">
                                    <div class="student-profile-share text-right">
                                        <a href="#" data-toggle="modal" data-target="#myModalshare" title="share" data-dismiss="modal"><i data-feather="share"></i>{{__('Share')}}</a>
                                    </div>
                                </div>
                                <div class="modal fade" data-backdrop="" style="z-index: 1050;" id="myModalshare" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">{{ __('Share this profile') }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="box box-primary">
                                                <div class="panel panel-sum">
                                                    <div class="modal-body">
                                                        @php
                                                            $url=  URL::current();
                                                        @endphp
                                                        <div class="nav-search">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="myInput"  value="{{ $url }}">
                                                            </div>
                                                            <button onclick="myFunction()" class="btn btn-primary"><i data-feather="copy"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="student-des"><p>{{ $users->detail }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        <div class="student-course-info">
                            <div class="student-contact-dtl">
                                <h4>Contact</h4>
                                <p>{{ $users->mobile }}</p>
                            </div>
                            <div class="student-social-dtl">
                                <h4>{{__('Social Media')}}</h4>
                                <p><span>{{__('Email:')}} </span><br>{{ $users->email }}</p>
                                @isset($linkedin_url)
                                <p><span>{{__('Linkdin:')}} </span><br>{{ $users->linkedin_url }}</p>
                                @endisset
                                @isset($fb_url)
                                <p><span>{{__('Facebook:')}} </span><br>{{ $users->fb_url }}</p>
                                @endisset
                                @isset($youtube_url)
                                <p><span>{{__('youtube:')}} </span><br>{{ $users->youtube_url }}</p>
                                @endisset
                                @isset($twitter_url)
                                <p><span>{{__('Twitter:')}} </span><br>{{ $users->twitter_url }}</p>
                                @endisset
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="student-course-info">
                            <div class="student-courses">
                                <h4>{{__('My Courses')}}</h4>
                                <section id="learning-courses" class="learning-courses-main-block">
                                    <div class="container-xl">
                                        <div class="row">
                                            @foreach($enroll as $enrol)
                                            @if($enrol->course_id != NULL)
                                            @if($enrol->status == 1)
                                            @if($enrol->user_id == Auth::User()->id)
                                
                                
                                            <div class="col-lg-4 col-md-12">
                                
                                                <div class="view-block">
                                                    <div class="view-img">
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
                                                    <div class="view-dtl">
                                                        <div class="view-heading"><a
                                                                href="{{ route('course.content',['slug' => $enrol->courses->slug ]) }}">{{ str_limit($enrol->courses->title, $limit = 35, $end = '...') }}</a>
                                                        </div>
                                                        <div class="user-name">
                                                            <h6>{{ __('By')}} <span>{{ optional($enrol->courses->user)['fname'] }}</span></h6>
                                                        </div>
                                                        <!-- <p class="btm-10"><a href="#">by @if(isset($enrol->courses->user))
                                                                {{ $enrol->courses->user->fname }} @endif</a></p> -->
                                                        <div class="rating">
                                                            <ul>
                                                                <li>
                                                                    <!-- star rating -->
                                                                    <?php 
                                                                        $learn = 0;
                                                                        $price = 0;
                                                                        $value = 0;
                                                                        $sub_total = 0;
                                                                        $sub_total = 0;
                                                                        $reviews = App\ReviewRating::where('course_id',$enrol->courses->id)->where('status','1')->get();
                                                                        ?>
                                                                    @if(!empty($reviews[0]))
                                                                    <?php
                                                                        $count =  App\ReviewRating::where('course_id',$enrol->courses->id)->count();
                                
                                                                        foreach($reviews as $review){
                                                                            $learn = $review->price*5;
                                                                            $price = $review->price*5;
                                                                            $value = $review->value*5;
                                                                            $sub_total = $sub_total + $learn + $price + $value;
                                                                        }
                                
                                                                        $count = ($count*3) * 5;
                                                                        $rat = $sub_total/$count;
                                                                        $ratings_var = ($rat*100)/5;
                                                                    ?>
                                
                                                                    <div class="pull-left">
                                                                        <div class="star-ratings-sprite"><span
                                                                                style="width:<?php echo $ratings_var; ?>%"
                                                                                class="star-ratings-sprite-rating"></span>
                                                                        </div>
                                                                    </div>
                                                                    @else
                                                                    <div class="pull-left">
                                                                        {{ __('No Rating') }}
                                                                    </div>
                                                                    @endif
                                                                </li>
                                                                <!-- overall rating -->
                                                                @php
                                                                $reviews = App\ReviewRating::where('course_id' ,$enrol->courses->id)->get();
                                                                @endphp
                                                                <?php 
                                                                    $learn = 0;
                                                                    $price = 0;
                                                                    $value = 0;
                                                                    $sub_total = 0;
                                                                    $count =  count($reviews);
                                                                    $onlyrev = array();
                                
                                                                    $reviewcount = App\ReviewRating::where('course_id', $enrol->courses->id)->where('status',"1")->WhereNotNull('review')->get();
                                
                                                                    foreach($reviewcount as $review){
                                
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
                                
                                                                @php
                                                                $reviewsrating = App\ReviewRating::where('course_id', $enrol->courses->id)->first();
                                                                @endphp
                                                                @if(!empty($reviewsrating))
                                                                <!-- <li>
                                                                    <b>{{ round($overallrating, 1) }}</b>
                                                                </li> -->
                                                                @endif
                                
                                                                <li class="reviews">
                                                                    (@php
                                                                    $data = App\ReviewRating::where('course_id', $enrol->courses->id)->count();
                                                                    if($data>0){
                                
                                                                    echo $data;
                                                                    }
                                                                    else{
                                
                                                                    echo "0";
                                                                    }
                                                                    @endphp Reviews)
                                                                </li>
                                                            </ul>
                                                        </div>
                                
                                
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
                                
                                            @foreach($bundle_order->course_id as $bundle_course)
                                            @php
                                
                                            $coursess = App\Course::where('id', $bundle_course)->first();
                                
                                            @endphp
                                
                                            <div class="col-lg-4 col-md-12">
                                
                                                <div class="view-block">
                                                    <div class="view-img">
                                                        @if($coursess['preview_image'] !== NULL && $coursess['preview_image'] !== '')
                                                        <a href="{{ route('course.content',['slug' => $coursess->slug ]) }}"><img
                                                                src="{{ asset('images/course/'.$coursess->preview_image) }}" class="img-fluid"
                                                                alt="student">
                                                        </a>
                                                        @else
                                                        <a href="{{ route('course.content',['slug' => $coursess->slug ]) }}"><img
                                                                src="{{ Avatar::create($coursess->title)->toBase64() }}" class="img-fluid"
                                                                alt="student"></a>
                                                        @endif
                                                    </div>
                                                    <div class="view-dtl">
                                                        <div class="view-heading"><a
                                                                href="{{ route('course.content',['slug' => $coursess->slug ]) }}">{{ str_limit($coursess->title, $limit = 35, $end = '...') }}</a>
                                                        </div>
                                                        <div class="user-name">
                                                            <h6>By <span>{{ optional($coursess->user)['fname'] }}</span></h6>
                                                        </div>
                                                        <!-- <p class="btm-10"><a href="#">by @if(isset($coursess->user)) {{ $coursess->user->fname }}
                                                                @endif</a></p> -->
                                                        <div class="rating">
                                                            <ul>
                                                                <li>
                                                                    <!-- star rating -->
                                                                    <?php 
                                                                        $learn = 0;
                                                                        $price = 0;
                                                                        $value = 0;
                                                                        $sub_total = 0;
                                                                        $sub_total = 0;
                                                                        $reviews = App\ReviewRating::where('course_id',$coursess->id)->where('status','1')->get();
                                                                    ?>
                                                                    @if(!empty($reviews[0]))
                                                                    <?php
                                                                        $count =  App\ReviewRating::where('course_id',$coursess->id)->count();
                                
                                                                        foreach($reviews as $review){
                                                                            $learn = $review->price*5;
                                                                            $price = $review->price*5;
                                                                            $value = $review->value*5;
                                                                            $sub_total = $sub_total + $learn + $price + $value;
                                                                        }
                                
                                                                        $count = ($count*3) * 5;
                                                                        $rat = $sub_total/$count;
                                                                        $ratings_var = ($rat*100)/5;
                                                                    ?>
                                
                                                                    <div class="pull-left">
                                                                        <div class="star-ratings-sprite"><span
                                                                                style="width:<?php echo $ratings_var; ?>%"
                                                                                class="star-ratings-sprite-rating"></span>
                                                                        </div>
                                                                    </div>
                                                                    @else
                                                                    <div class="pull-left">
                                                                        {{ __('No Rating') }}
                                                                    </div>
                                                                    @endif
                                                                </li>
                                                                <!-- overall rating -->
                                                                @php
                                                                $reviews = App\ReviewRating::where('course_id' ,$coursess->id)->get();
                                                                @endphp
                                                                <?php 
                                                                    $learn = 0;
                                                                    $price = 0;
                                                                    $value = 0;
                                                                    $sub_total = 0;
                                                                    $count =  count($reviews);
                                                                    $onlyrev = array();
                                
                                                                    $reviewcount = App\ReviewRating::where('course_id', $coursess->id)->where('status',"1")->WhereNotNull('review')->get();
                                
                                                                    foreach($reviewcount as $review){
                                
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
                                
                                                                @php
                                                                $reviewsrating = App\ReviewRating::where('course_id', $coursess->id)->first();
                                                                @endphp
                                                                @if(!empty($reviewsrating))
                                                                <!-- <li>
                                                                    <b>{{ round($overallrating, 1) }}</b>
                                                                </li> -->
                                                                @endif
                                
                                                                <li class="reviews">
                                                                    (@php
                                                                    $data = App\ReviewRating::where('course_id', $coursess->id)->count();
                                                                    if($data>0){
                                
                                                                    echo $data;
                                                                    }
                                                                    else{
                                
                                                                    echo "0";
                                                                    }
                                                                    @endphp Reviews)
                                                                </li>
                                                            </ul>
                                                        </div>
                                
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
                                             @endforeach
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
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