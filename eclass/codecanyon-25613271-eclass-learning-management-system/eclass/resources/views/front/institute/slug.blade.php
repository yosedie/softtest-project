@extends('theme.master')
@section('title', 'Institute Detail')

@section('content')
@include('admin.message')
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
    <div class="container-fluid">
        <div class="business-dtl">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bredcrumb-dtl">
                        <h1 class="wishlist-home-heading">{{ __('Institute')}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<section id="institute-detail" class="institute-detail-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <div class="institute-detail-block text-center">
                    <div class="institute-detail-img">
                        @if($institute['image'] !== NULL && $institute['image'] !== '')
                        <img src="{{ asset('files/institute/'.$institute['image']) }}" alt="{{ __('course')}}" class="img-fluid">
                        @else
                            <img src="{{ Avatar::create($institute->title)->toBase64() }}" alt="{{ __('course')}}" class="img-fluid">
                        @endif                    
                    </div>
                    <div class="institute-dtl">
                        <div class="institute-content-block">
                            <h2 class="institute-content-title">{{ $institute ->title }}</h2>
                            <div class="institute-mobile">{{ $institute ->mobile }}</div>
                            <div class="institute-email">{{ $institute ->email }}</div>
                            <div class="institute-address">{{ $institute ->address }}</div>
                            <div class="institute-status mt-2 mb-2">
                                <span class="badge badge-primary"> @if($institute->status == '1')
                                    {{ __('Active') }}
                                    @else
                                    {{ __('Deactivate') }}

                                    @endif
                                </span>
                            </div>
                            <div class="institute-verified mt-2 mb-2">
                                <span class="badge badge-success">@if($institute->verified == '1')
                                    {{ __('Verified') }}
                                    @else
                                    {{ __('Not verified') }}

                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="institute-detail-tab">
                    <ul class="nav nav-tabs" id="tabs-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="courses-tab" data-toggle="tab" href="#courses" role="tab" aria-controls="courses" aria-selected="true">{{__('Courses')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="false">{{__('Detail')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="skill-tab" data-toggle="tab" href="#skill" role="tab" aria-controls="skill" aria-selected="true">{{__('Skill')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="affiliated-tab" data-toggle="tab" href="#affiliated" role="tab" aria-controls="affiliated" aria-selected="true">{{__('Affiliated')}}</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" id="instructor-tab" data-toggle="tab" href="#instructor" role="tab" aria-controls="instructor" aria-selected="true">Instructor</a>
                        </li> --}}
                    </ul>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane active show" id="courses" role="tabpanel" aria-labelledby="courses-tab">
                            @if(isset($course))
                            <div class="about-instructor">
                                <div class="row">
                                    @foreach($course as $c)
                                    @if($c->status == 1)
                                        <div class="col-lg-6">
                                            <div class="student-view-block">
                                                <div class="view-block">
                                                    <div class="view-img">
                                                        @if($c['preview_image'] !== NULL && $c['preview_image'] !== '')
                                                            <a href="{{ route('user.course.show',['slug' => $c->slug ]) }}"><img src="{{ asset('images/course/'.$c['preview_image']) }}" alt="{{ __('course')}}" class="img-fluid"></a>
                                                        @else
                                                            <a href="{{ route('user.course.show',['slug' => $c->slug ]) }}"><img src="{{ Avatar::create($c->title)->toBase64() }}" alt="{{ __('course')}}" class="img-fluid"></a>
                                                        @endif
                                                    </div>
                                                    <div class="view-user-img">

                                                        @if(optional($c->user)['user_img'] !== NULL && optional($c->user)['user_img'] !== '')
                                                        <a href="" title="{{$c->title}}"><img src="{{ asset('images/user_img/'.$c->user['user_img']) }}"
                                                                class="img-fluid user-img-one" alt="{{$c->title}}"></a>
                                                        @else
                                                        <a href="" title="{{$c->title}}"><img src="{{ asset('images/default/user.png') }}"
                                                                class="img-fluid user-img-one" alt="{{$c->title}}"></a>
                                                        @endif
                            
                            
                                                    </div>
                                                    <div class="view-dtl">
                                                        <div class="view-heading"><a href="{{ route('user.course.show',['slug' => $c->slug ]) }}">{{ str_limit($c->title, $limit = 30, $end = '...') }}</a></div>
                                                        <div class="user-name">
                                                            <h6>By <span>{{ optional($c->user)['fname'] }}</span></h6>
                                                        </div>                                           
                                                        <div class="rating">
                                                            <ul>
                                                                <li>
                                                                    <?php 
                                                                    $learn = 0;
                                                                    $price = 0;
                                                                    $value = 0;
                                                                    $sub_total = 0;
                                                                    $sub_total = 0;
                                                                    $reviews = App\ReviewRating::where('course_id',$c->id)->get();
                                                                    ?> 
                                                                    @if(!empty($reviews[0]))
                                                                    <?php
                                                                    $count =  App\ReviewRating::where('course_id',$c->id)->count();

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
                                                                        <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
                                                                        </div>
                                                                    </div>
                                                                
                                                                    
                                                                    @else
                                                                        <div class="pull-left">{{ __('No Rating') }}</div>
                                                                    @endif
                                                                </li>
                                                                <!-- overall rating-->
                                                                <?php 
                                                                $learn = 0;
                                                                $price = 0;
                                                                $value = 0;
                                                                $sub_total = 0;
                                                                $count =  count($reviews);
                                                                $onlyrev = array();

                                                                $reviewcount = App\ReviewRating::where('course_id', $c->id)->WhereNotNull('review')->get();

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

                                                                @php
                                                                    $reviewsrating = App\ReviewRating::where('course_id', $c->id)->first();
                                                                @endphp
                                                                <li class="reviews">
                                                                    (@php
                                                                    $data = App\ReviewRating::where('course_id', $c->id)->count();
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
                                                            <div class="view-footer">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                                        <div class="count-user">
                                                                            <i data-feather="user"></i><span>1</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                                        @if( $c->type == 1)
                                                                        <div class="rate text-right">
                                                                            <ul>
                                                                                @php
                                                                                    $currency = App\Currency::first();
                                                                                @endphp
                    
                                                                                @if($c->discount_price == !NULL)
                                                                                <li>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($c->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</li>
                                                                                <li><strike>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($c->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</strike></li>
                                                                                    {{-- <li><a><b><i class="{{ $currency->icon }}"></i>{{ $c->discount_price }}</b></a></li>&nbsp;
                                                                                    <li><a><b><strike><i class="{{ $currency->icon }}"></i>{{ $c->price }}</strike></b></a></li> --}}
                                                                                    
                                                                                @else
                                                                                <li>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($c->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</li>

                                                                                    {{-- <li><a><b><i class="{{ $currency->icon }}"></i>{{ $c->price }}</b></a></li> --}}
                                                                                @endif
                                                                            </ul>
                                                                        </div>
                                                                        @else
                                                                        <div class="rate text-right">
                                                                            <ul>
                                                                                <li><a><b>{{ __('Free') }}</b></a></li>
                                                                            </ul>
                                                                        </div>
                                                                    @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    @endif
                                    @endforeach
                                    
                                </div>
                            </div>  
                            @else
                                <div class="about-instructor-no-found"><i data-feather="Frown"></i>{{__('No Data Found')}}</div>                          
                            @endif
                        </div>
                        <div class="tab-pane" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                           <p>{{ $institute->detail }}</p>
                        </div>
                        <div class="tab-pane" id="skill" role="tabpanel" aria-labelledby="skill-tab">
                            <ul>
                                <li><span class="badge badge-info">{{ $institute->skill }}</span></li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="affiliated" role="tabpanel" aria-labelledby="affiliated-tab">
                            <ul>
                                <li><span class="badge badge-info">{{ $institute->affilated_by }}</span></li>                               
                            </ul>
                        </div>
                        {{-- <div class="tab-pane" id="instructor" role="tabpanel" aria-labelledby="instructor-tab">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="instructor-profile-block text-center">
                                        <div class="instructor-profile-img">
                                            <img src="{{ url('images/user_img/1637571503young-smiling-student-woman-white-background.jpg')}}" class="img-fluid">                       
                                        </div>
                                        <div class="instructor-profile-dtl">
                                            <div class="instructor-content-block">
                                                <h5 class="about-content-heading">Joyce Garcia</h5>
                                                <p>instructor</p>
                                                <div class="instructor-profile-number">
                                                    1234567890
                                                </div>
                                                <div class="instructor-profile-mail">
                                                    joyce@example.com
                                                </div>
                                                    <div class="instructor-home-info">
                                                    <ul>
                                                        <li>0 Courses</li>
                                                        <li>0 Follower</li>
                                                        <li>0 Following</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection