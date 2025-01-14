@extends('theme.master')
@section('title', "Course Completion Certificate")
@section('content')
@include('admin.message')

<section id="cirtificate" class="course-cirtificate">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-9 col-md-9">
                <div id="printableArea" class="certificate-responsive">
                    @if(Module::has('Certificate') && Module::find('Certificate')->isEnabled())
                        @include('certificate::front.certificate_view')
                    @else
                    <div class="cirtificate-border-one text-center">
                        <div class="cirtificate-border-two">
                        <div class="cirtificate-heading" style=""> {{ __('Certificate of Completion') }}</div>
                            @php
                                $mytime = Carbon\Carbon::now();
                            @endphp
                            <p class="cirtificate-detail" style="font-size:30px"> {{ __('This is to certify that') }}
                                <b>&nbsp;{{ $progress->user['fname'] }}&nbsp;{{ $progress->user['lname'] }}</b>  
                                {{ __('successfully completed') }} 
                                <b>{{ $course['title'] }}</b> 
                                {{ __('online course on') }} <br>
                                <span style="font-size:25px">{{ date('jS F Y', strtotime($progress['updated_at'])) }}</span>
                            </p>

                        <span class="cirtificate-instructor">{{ ($course->user['fname']) }} {{ ($course->user['lname']) }}</span>
                        <br>
                        <span class="cirtificate-one">{{ ($course->user['fname']) }} {{ ($course->user['lname']) }}, {{ __('Instructor') }}</span>
                        <br>
                        <span>&</span>
                            <div class="cirtificate-logo">
                            @if($gsetting['logo_type'] == 'L')
                                <img src="{{ asset('images/logo/'.$gsetting['logo']) }}" class="img-fluid" alt="{{ __('logo')}}">
                            @else
                                <a href="{{ url('/') }}"><b><div class="logotext">{{ $gsetting['project_title'] }}</div></b></a>
                            @endif
                            </div>
                            

                            <div class="cirtificate-serial">{{ __('Certificate no.')}} :{{ $serial_no  }}</div>
                            <div class="cirtificate-serial">{{ __('Certificate url.')}} :{{ url()->full() }}</div>
                        
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <h4>{{ __('Certificate Recipient') }}:</h4>
                <div class="recipient-block">
                    <div class="row">
                        <div class="col-md-4 col-4">
            
                            @if($progress->user->user_img != null || $progress->user->user_img !='')
                                <img src="{{ asset('images/user_img/'.$progress->user->user_img) }}" alt="{{ __('user')}}" class="img-fluid img-circle">
                            @else
                                <img src="{{ asset('images/default/user.jpg')}}" alt="{{ __('user')}}" class="img-fluid img-circle">
                            @endif
                        </div>
                        <div class="col-md-8 col-8">
                            {{ $progress->user->fname }}
                        </div>
                    </div>
                </div>

                <h4>{{ __('About the Course') }}:</h4>
                <div class="view-block btm-20">
                    <div class="view-img">
                        @if($course['preview_image'] !== NULL && $course['preview_image'] !== '')
                            <a href="{{ route('user.course.show',['slug' => $course->slug ]) }}"><img src="{{ asset('images/course/'.$course['preview_image']) }}" alt="{{ __('course')}}" class="img-fluid"></a>
                        @else
                            <a href="{{ route('user.course.show',['slug' => $course->slug ]) }}"><img src="{{ Avatar::create($course->title)->toBase64() }}" alt="{{ __('course')}}" class="img-fluid"></a>
                        @endif
                    </div>
                    <div class="view-dtl">
                        <div class="view-heading"><a href="{{ route('user.course.show',['slug' => $course->slug ]) }}">{{ str_limit($course->title, $limit = 30, $end = '...') }}</a></div>
                        <div class="user-name">
                            <h6>{{ __('By')}} <span>{{ optional($course->user)['fname'] }}</span></h6>
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
                                    $reviews = App\ReviewRating::where('course_id',$course->id)->get();
                                    ?> 
                                    @if(!empty($reviews[0]))
                                    <?php
                                    $count =  App\ReviewRating::where('course_id',$course->id)->count();

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

                                $reviewcount = App\ReviewRating::where('course_id', $course->id)->WhereNotNull('review')->get();

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
                                    $reviewsrating = App\ReviewRating::where('course_id', $course->id)->first();
                                @endphp
                                <li class="reviews">
                                    (@php
                                    $data = App\ReviewRating::where('course_id', $course->id)->count();
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
                            @if( $course->type == 1)
                                <div class="rate text-right">
                                    <ul>

                                        @if($course->discount_price == !NULL)
                                           
                                            <sub>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($course->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</sub>

                                        @else
                                            @if($course->price == !NULL)
                                            <strong>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($course->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</strong>
                                            @endif
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
                <div class="download-btn btm-20">
                    <?php
                            
                        $parameter= Crypt::encrypt($course->id);
                    ?>

                    @php
                    $random = $progress->id.'CR-'.uniqid();
                    @endphp

                    @if(Module::has('Certificate') && Module::find('Certificate')->isEnabled())
                        @include('certificate::front.download_link')

                    @else
                        
                        <a href="" onclick="printDiv('printableArea')"  target="_blank"  class="btn btn-primary w-100">{{ __('Print Certificate') }}</a>
                    @endif
                </div>
                @auth
                <p><a href="#" data-toggle="modal" data-target="#myModalCirtificate" title="{{ __('report')}}">{{ __('Updateyourcertificate') }}</a> {{ __('withy our correct name') }}.</p>
                <div class="modal fade" id="myModalCirtificate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title" id="myModalLabel">{{ __('Update You Certificate') }}</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        
                        <div class="box box-primary">
                          <div class="panel panel-sum">
                            <div class="modal-body">
                                 {{ __('Confirm your name is') }} <b>{{ Auth::User()->fname }}</b>
                                <br>

                                 {{ __('Incorrect') }}? <a href="{{route('profile.show',Auth::User()->id)}}">{{ __('Update your profile name') }}</a>.
                           
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
</section>

@endsection