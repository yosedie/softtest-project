@extends('theme2.master')
@section('title', 'Wishlist')
@section('content')
@include('admin.message')
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
                        <h2>{{ __('Wishlist') }}</h2>    
                        
                    </div>
                </div>
            </div>
            <div class="breadcrumb-wrap2">
                  <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('My Wishlist')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
    </div>
</section>
@php
    $item = App\Wishlist::where('user_id', Auth::User()->id)->get();
@endphp
@if(isset($wishlist))
<section class="courses pt-120 pb-120 p-relative fix courses-coloumn-block">
    <div class="container">
        <div class="row"> 
            @foreach($wishlist as $wish)
            @if($wish->courses->status == '1')
        	@if($wish->user_id == Auth::User()->id)  
            <div class="col-lg-4 col-md-6 ">
                <div class="courses-item mb-30 hover-zoomin">
                    <div class="thumb fix">
                        @if($wish->courses['preview_image'] !== NULL && $wish->courses['preview_image'] !== '')
                        <a href="{{ route('user.course.show',['slug' => $wish->courses->slug ]) }}"><img src="{{ asset('images/course/'.$wish->courses->preview_image) }}" class="img-fluid" alt="course">
                        @else
                            <a href="{{ route('user.course.show',['slug' => $wish->courses->slug ]) }}"><img src="{{ Avatar::create($wish->courses->title)->toBase64() }}" class="img-fluid" alt="course">
                        @endif                    
                        <div class="courses-icon">
                            <ul>
                                <li class="">   
                                    @if($wish->courses->type == 1)
                                    <div class="cart-btn">
                                        <form id="demo-form2" method="post" action="{{ route('addtocart',['course_id' => $wish->courses->id, 'price' => $wish->courses->price, 'discount_price' => $wish->courses->discount_price ]) }}">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="category_id"  value="{{$wish->courses->category['id']}}" />
                                                <button type="submit" class="wishlist-cart"  title="Add To Cart"><i
                                                data-feather="shopping-cart" ></i></button>
                                        </form>
                                    </div>
                                    @endif
                                </li>
                                <li class="">
                                    <div class="wishlist-btn txt-rgt">
                                        <form  method="post" action="{{url('delete/wishlist', $wish->id)}}">
                                            {{ csrf_field() }}
                                            <button type="submit" class="trash-icon" title="Remove From Wishlist"><i
                                            data-feather="trash" ></i></button>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="courses-content">      
                        <div class="view-user-img">
                            <a href="#" title="{{$wish->courses->title}}">
                                @if($wish->user['user_img'] !== NULL && $wish->user['user_img'] !== '')
                                <img src="{{ asset('images/user_img/'.$wish->user['user_img']) }}" alt="img">
                                @else
                                <img src="{{ url('frontcss/img/icon/cou-icon.png') }}" alt="img">
                                @endif
                            </a>
                                                     
                        </div>                                
                        <div class="cat">
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
                        </div>
                        <h3><a href="{{ route('user.course.show',['slug' => $wish->courses->slug ]) }}">{{ str_limit($wish->courses->title, $limit = 35, $end = '...') }}</a></h3>
                        <p>{{ str_limit($wish->courses->title, $limit = 70, $end = '...') }}</p>
                        <a href="{{ route('user.course.show',['slug' => $wish->courses->slug ]) }}" class="readmore">{{__('Read More')}} <i class="fal fa-long-arrow-right"></i></a>
                    </div>
                    <div class="icon">
                        <img src="{{ url('frontcss/img/icon/cou-icon.png') }}" alt="img">
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
            <img src="{{ url('/images/no-result.jpg') }}" class="img-fluid" alt="{{ __('no-result')}}">
        </div>
        <div class="no-result-courses btm-10">{{ __('Empty Wishlist') }}</div>
        <div class="recommendation-btn text-white text-center">
            <a href="{{ url('/') }}" class="btn btn-primary" title="search"><b>{{ __('Browse') }}</b></a>
        </div> 
    </div>
</section>
@endif
@endsection