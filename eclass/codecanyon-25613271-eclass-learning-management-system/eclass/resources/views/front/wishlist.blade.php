@extends('theme.master')
@section('title', 'Wishlist')
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
    <div class="container-xl">
        <div class="business-dtl">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="bredcrumb-dtl">
                        <h1 class="wishlist-home-heading text-white">{{ __('Wishlist') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- about-home end -->
@php
    $item = App\Wishlist::where('user_id', Auth::User()->id)->get();
@endphp
@if(count($item) > 0)
<section id="learning-courses" class="learning-courses-main-block">
    <div class="container-xl">
        <div class="row">
        	@foreach($wishlist as $wish)
            @if($wish->courses->status == '1')
        	@if($wish->user_id == Auth::User()->id)
                <div class="col-lg-3 col-md-6">
                    <div class="view-block">
                        <div class="view-img">
                            @if($wish->courses['preview_image'] !== NULL && $wish->courses['preview_image'] !== '')
                                <a href="{{ route('user.course.show',['slug' => $wish->courses->slug ]) }}"><img src="{{ asset('images/course/'.$wish->courses->preview_image) }}" class="img-fluid" alt="course">
                            @else
                                <a href="{{ route('user.course.show',['slug' => $wish->courses->slug ]) }}"><img src="{{ Avatar::create($wish->courses->title)->toBase64() }}" class="img-fluid" alt="course">
                            @endif
                            </a>
                        </div>
                        <div class="view-user-img">
                            @if($wish->user['user_img'] !== NULL && $wish->user['user_img'] !== '')
                                <a href="{{ route('all/profile',$wish->user->id) }}" title="{{$wish->courses->title}}"><img src="{{ asset('images/user_img/'.$wish->user['user_img']) }}" class="img-fluid user-img-one" alt="{{$wish->courses->title}}"></a>
                            @else
                                <a href="{{ route('all/profile',$wish->user->id) }}" title="{{$wish->courses->title}}"><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt="{{$wish->courses->title}}"></a>
                            @endif
                        </div>
                        @if($wish->courses['tags'] == !NULL)
                            <div class="best-seller">{{ $wish->courses['tags'] }}</div>
                        @endif
                        <div class="view-dtl">
                            <div class="view-heading"><a href="{{ route('user.course.show',['slug' => $wish->courses->slug ]) }}">{{ str_limit($wish->courses->title, $limit = 35, $end = '...') }}</a></div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$wish->user->id) }}"> {{ optional($wish->courses->user)['fname'] }}</a></span></h6>
                            </div>
                            <div class="rating">
                                <ul>
                                    <li>
                                        {{-- star rating --}}
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
                                    <li class="reviews">
                                        (@php
                                        $data = App\ReviewRating::where('course_id', $wish->courses->id)->count();
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
                                            <i data-feather="user"></i><span>
                                                @php
                                                $data = App\Order::where('course_id', $wish->courses->id)->count();
                                                if(($data)>0){

                                                echo $data;
                                                }
                                                else{

                                                echo "0";
                                                }
                                                @endphp</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        @if( $wish->courses->type == 1)
                                        <div class="rate text-right">
                                            <ul>

                                                @if($wish->courses->discount_price == !NULL)

                                                <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($wish->courses->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false))}}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                </li>

                                                <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($wish->courses->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</strike></b></a>
                                                </li>


                                                @else
                                                <li><a><b>
                                                    {{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($wish->courses->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false) )}}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                </li>


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
                    <div class="img-wishlist">
                        <div class="protip-wishlist">
                            <ul>
                                <li class="protip-wish-btn">   
                                    @if($wish->courses->type == 1)
                                    <div class="cart-btn text-center">
                                        <form id="demo-form2" method="post" action="{{ route('addtocart',['course_id' => $wish->courses->id, 'price' => $wish->courses->price, 'discount_price' => $wish->courses->discount_price ]) }}"
                                                data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}
                                                
                                                <input type="hidden" name="category_id"  value="{{$wish->courses->category['id']}}" />
                                                    
                                            
                                        <button type="submit" class="btn btn-primary wishlist-cart"  title="Add To Cart"><i
                                                data-feather="shopping-cart" class="rgt-10"></i></button>
                                        </form>
                                    </div>
                                    @endif
                                </li>
                                <li class="protip-wish-btn-two">
                                    <div class="wishlist-btn txt-rgt">
                                        <form  method="post" action="{{url('delete/wishlist', $wish->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}
                                            
                                        <button type="submit" class="btn btn-primary trash-icon" title="Remove From Wishlist"><i
                                            data-feather="trash" class="rgt-10"></i></button>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @endif
            @endforeach
        </div>
    </div>
    <div class="container-xl" id="adsense">
        <!-- google adsense code -->
        <?php
          if (isset($ad)) {
           if ($ad->iswishlist==1 && $ad->status==1) {
              $code = $ad->code;
              echo html_entity_decode($code);
           }
          }
        ?>
    </div>
</section>
@else
    <section id="search-block" class="search-main-block search-block-no-result text-center">
        <div class="container-xl">
            <div class="no-result-img btm-20">
                <img src="{{ url('/images/no-result.jpg') }}" class="img-fluid" alt="{{ __('no result')}}">
            </div>
            <div class="no-result-courses btm-10">{{ __('Empty Wishlist') }}</div>
            <div class="recommendation-btn text-white text-center">
                <a href="{{ url('/') }}" class="btn btn-primary" title="search"><b>{{ __('Browse') }}</b></a>
            </div> 
        </div>
    </section>
@endif

@endsection