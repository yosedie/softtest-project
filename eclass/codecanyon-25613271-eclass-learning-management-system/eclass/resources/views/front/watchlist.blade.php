@extends('theme.master')
@section('title', 'Watchlist')
@section('content')

@include('admin.message')


<section id="learning-courses" class="learning-courses-main-block">
    <div class="container-xl">

    	<h4 class="cart-heading">
    		<b>
    		@php
                
                if(count($coursewatch)>0){

                    echo count($coursewatch);
                }
                else{

                    echo "0";
                }
            @endphp
        	  {{ __('Courses') }} {{ __('in') }} {{ __('Watchlist') }}
        	</b>
        </h4>
        <div class="row">
        	@foreach($coursewatch as $wish)
        	@if($wish->user_id == Auth::User()->id)
                <div class="col-lg-3 col-sm-6 col-md-4">
                    <div class="view-block">
                        <div class="view-img">
                            @if($wish->courses['preview_image'] !== NULL && $wish->courses['preview_image'] !== '')
                                <a href="{{ route('user.course.show',['slug' => $wish->courses->slug ]) }}"><img src="{{ asset('images/course/'.$wish->courses->preview_image) }}" class="img-fluid" alt="course">
                            @else
                                <a href="{{ route('user.course.show',['slug' => $wish->courses->slug ]) }}"><img src="{{ Avatar::create($wish->courses->title)->toBase64() }}" class="img-fluid" alt="course">
                            @endif
                            </a>
                        </div>
                        <div class="view-dtl">
                            <div class="view-heading btm-10"><a href="{{ route('user.course.show',['slug' => $wish->courses->slug ]) }}">{{ str_limit($wish->courses->title, $limit = 35, $end = '...') }}</a></div>
                            <p class="btm-10"><a href="#">{{ __('by') }} {{ $wish->courses->user->fname }}</a></p>
                            <div class="rating">
                                <ul>
                                    <li>
                                        <?php 
                                        $learn = 0;
                                        $price = 0;
                                        $value = 0;
                                        $sub_total = 0;
                                        $sub_total = 0;
                                        $reviews = App\ReviewRating::where('course_id',$wish->courses->id)->where('status','1')->get();
                                        ?> 
                                        @if(!empty($reviews[0]))
                                            <?php
                                            $count =  App\ReviewRating::where('course_id',$wish->courses->id)->count();

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
                                            <div class="pull-left">
                                                {{ __('No Rating') }}
                                            </div>
                                        @endif
                                    </li>

                                    @php
                                    $reviews = App\ReviewRating::where('course_id' ,$wish->courses->id)->get();
                                    @endphp
                                    <?php 
                                    $learn = 0;
                                    $price = 0;
                                    $value = 0;
                                    $sub_total = 0;
                                    $count =  count($reviews);
                                    $onlyrev = array();

                                    $reviewcount = App\ReviewRating::where('course_id', $wish->courses->id)->where('status',"1")->WhereNotNull('review')->get();

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
                                        $reviewsrating = App\ReviewRating::where('course_id', $wish->courses->id)->first();
                                    @endphp
                                    @if(!empty($reviewsrating))
                                    <li>
                                        <b>{{ round($overallrating, 1) }}</b>
                                    </li>
                                    @endif
                                  
                                   
                                </ul>
                            </div>
                           
                        </div>
                    </div>
                    <div class="wishlist-action">
                        <div class="row">
                        	<div class="col-md-6 col-6">
                               
                        	</div>
                        	<div class="col-md-6 col-6">
                                <div class="wishlist-btn txt-rgt">
                                    <form  method="post" action="{{route('active.delete', $wish->id)}}" data-parsley-validate class="form-horizontal form-label-left">
            	                        {{ csrf_field() }}
            	                        
            	                      <button type="submit" class="btn btn-primary " title="{{ __('Remove') }}"><i class="fa fa-trash"></i></button>
            	                    </form>
                                </div>
                        	</div>
                        </div>
                    </div>
                </div>
            @endif
            @endforeach
        </div>
    </div>
    
</section>


@endsection