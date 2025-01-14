@extends('theme.master')
@section('title', 'Online Courses')
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
                        <h1 class="wishlist-home-heading">{{ __('Courses') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- search start -->
@if(count($search_data) > 0)
    <section id="search-block" class="search-main-block">
        <div class="container-xl">
            <div class="row">
                
                <div class="col-lg-12">

                    <div class ="prod grid-view">
                        <div class="btn-group-web-screen">
                            <div class="btn-group mt-2 mb-4">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label id="gridview" class="btn btn-outline-dark active">
                                        <input type="radio" name="layout" id="layout3"> <i data-feather="grid"></i>
                                    </label>
                                    <label id="listview" class="btn btn-outline-dark">
                                        <input type="radio" name="layout" id="layout4" checked> <i data-feather="list"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="posts" class="students-bought btm-30">
                            <div class="row">
                                @foreach($search_data as $course)
                                <div class="search-item col-lg-3">
                                @if($course->status == 1)
                            
                                    <div class="item first">
                                        <div class="course-bought-section protip" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block{{$course->id}}">

                                            <div class="view-img">

                                                @if($course['preview_image'] !== NULL && $course['preview_image'] !== '')
                                                <a href="{{ route('user.course.show',['slug' => $course->slug ]) }}"><img src ="{{ asset('images/course/'.$course->preview_image) }}" alt="{{$course->title}}" class="img-fluid"></a>
                                                @else
                                                <a href="{{ route('user.course.show',['slug' => $course->slug ]) }}"><img src="{{ Avatar::create($course->title)->toBase64() }}" alt="{{$course->title}}" class="img-fluid"></a>
                                                @endif
                                                @if($course['level_tags'] == 'trending')
                                                <div class="advance-badge">
                                                    <span class="badge bg-warning">{{__('Trending')}}</span>
                                                </div>
                                                @endif
                                                @if($course['level_tags'] == 'featured')
                        
                                                <div class="advance-badge">
                                                    <span class="badge bg-danger">{{__('Featured')}}</span>
                                                </div>
                                                @endif
                                                @if($course['level_tags'] == 'new')
                        
                                                <div class="advance-badge">
                                                    <span class="badge bg-success">{{__('New')}}</span>
                                                </div>
                                                @endif
                                                @if($course['level_tags'] == 'onsale')
                        
                                                <div class="advance-badge">
                                                    <span class="badge bg-info">{{__('Onsale')}}</span>
                                                </div>
                                                @endif
                                                @if($course['level_tags'] == 'bestseller')
                        
                                                <div class="advance-badge">
                                                    <span class="badge bg-success">{{__('Bestseller')}}</span>
                                                </div>
                                                @endif
                                                @if($course['level_tags'] == 'beginner')
                        
                                                <div class="advance-badge">
                                                    <span class="badge bg-primary">{{__('Beginner')}}</span>
                                                </div>
                                                @endif
                                                @if($course['level_tags'] == 'intermediate')
                        
                                                <div class="advance-badge">
                                                    <span class="badge bg-secondary">{{__('Intermediate')}}</span>
                                                </div>
                                                @endif

                                                <div class="view-user-img">

                                                    @if(optional($course->user)['user_img'] !== NULL && optional($course->user)['user_img'] !== '')
                                                    <a href="{{ route('all/profile',$course->user->id) }}" title="{{$course->short_detail}}"><img src="{{ asset('images/user_img/'.$course->user['user_img']) }}"
                                                            class="img-fluid user-img-one" alt="{{$course->short_detail}}"></a>
                                                    @else
                                                    <a href="{{  route('all/profile',$course->id)  }}" title="{{$course->short_detail}}"><img src="{{ asset('images/default/user.png') }}"
                                                            class="img-fluid user-img-one" alt="{{$course->short_detail}}"></a>
                                                    @endif
                                                </div>
                                            </div>
                                            


                                            <div class="view-dtl">
                                                <div class="view-heading"><a href="{{ route('user.course.show',['slug' => $course->slug ]) }}">{{ str_limit($course->title, $limit = 30, $end = '...') }}</a></div>
                                                
                                                <div class="categories-popularity-dtl">
                                                    <ul>
                                                        <li>
                                                            @php
                                                                $data = App\CourseClass::where('course_id', $course->id)->get();
                                                                if(count($data)>0){

                                                                    echo count($data);
                                                                }
                                                                else{

                                                                    echo "0";
                                                                }
                                                            @endphp {{ __('Classes') }} 
                                                        </li>
                                                    </ul>
                                                    <p>{{  str_limit($course->short_detail, $limit = 60, $end = '..') }}</p>
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
                                                                $reviews = App\ReviewRating::where('course_id',$course->id)->where('status','1')->get();
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
                                                        <li>
                                                            (@php
                                                                $data = App\ReviewRating::where('course_id', $course->id)->get();
                                                                if(count($data)>0){
                
                                                                    echo count($data);
                                                                }
                                                                else{
                
                                                                    echo "0";
                                                                }
                                                            @endphp ratings)
                                                        </li> 
                                                    </ul>
                                                </div>
                                                <ul>
                                                    
                                                </ul>
                                                
                                            </div>
                                            <div class="view-footer">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-6">                                                
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-6">
                                                        <div class="rate text-right">
                                                            <ul>
                                                                
                                                                @if($course->type == 1)
                                                                    @if($course->discount_price == !NULL)
                                                                        <li><a><b>{{ currency($course->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}</b></a></li>
                                                                        <li><a><b><strike>{{ currency($course->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}</strike></b></a></li>
                                                                            
                                                                            
                                                                    @else

                                                                        @if($course->price == !NULL)

                                                                        <li><a><b>{{ currency($course->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}</b></a></li>

                                                                        @endif
                                                                    @endif

                                                                @else
                                                                <div class="rate text-right">
                                                                    <ul>
                                                                        <li><a><b>{{ __('Free') }}</b></a></li>
                                                                    </ul>
                                                                </div>
                                                                @endif
                                                            </ul>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($course['whatlearns']->isNotEmpty())
                                            <div id="prime-next-item-description-block{{$course->id}}" class="prime-description-block">
                                                <div class="prime-description-under-block">
                                                    <div class="prime-description-under-block">
                                                        <h5 class="description-heading">{{ __('What you will learn')}}</h5>
                                                        
                                                        @foreach($course['whatlearns'] as $wl)
                                                        @if($wl->status ==1)
                                                            <div class="product-learn-dtl protip-whatlearn">
                                                                <ul>
                                                                    <li><i data-feather="check-circle"></i>{{ str_limit($wl['detail'], $limit = 120, $end = '...') }}</li>
                                                                </ul>
                                                            </div>
                                                        @endif
                                                        @endforeach
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                @endif
                                </div>

                                @endforeach
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@else
    <section id="search-block" class="search-main-block search-block-no-result">
        <div class="container-xl">
          <h2>{{ __('No search') }} "{{$searchTerm}}"</h2>
        </div>
    </section>
@endif
<!-- search end -->

@endsection


@section('custom-script')
<script type="text/javascript">
      $('.item i').on('click', function(){
      $(this).toggleClass('fa-plus fa-minus').next().slideToggle()
    })
    /* list or grid item*/
    $(".view i").click(function(){

      $('.prod').removeClass('grid-view list-view').addClass($(this).data('view'));

    })
    $(".view i").click(function(){

      $(this).addClass('selected').siblings().removeClass('selected');

    })
</script>

@endsection


