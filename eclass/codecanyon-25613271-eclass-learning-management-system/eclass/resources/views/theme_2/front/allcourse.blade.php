@extends('theme2.master')
@section('title','All Course')
@section('content')
@include('admin.message')
        <!-- main-area -->
        <main>
            
           <!-- breadcrumb-area -->
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
                                    <h2>Courses</h2>    
                                    
                                </div>
                            </div>
                        </div>
                        <div class="breadcrumb-wrap2">
                              
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">{{__('Courses')}}</li>
                                    </ol>
                                </nav>
                            </div>
                        
                    </div>
                </div>
            </section>
            
            <!-- breadcrumb-area-end -->
			<!-- shop-area -->
            @if(isset($data))
            <section class="shop-area pt-120 pb-120 p-relative " data-animation="fadeInUp animated" data-delay=".2s">
                <div class="container">
                    <div class="row align-items-center">
                        @foreach($data as $course)
                        <div class="col-lg-4 col-md-6 ">
                            <div class="courses-item mb-30 hover-zoomin">
                                <div class="thumb fix">
                                    <a href="{{ route('user.course.show',['slug' => $course->slug ]) }}">
                                         @if($course['preview_image'] !== NULL && $course['preview_image'] !== '')
                                    
                                        <img src="{{ asset('images/course/'.$course['preview_image']) }}" alt="contact-bg-an-01" class="img-fluid">
                                        @else
                                        <img src="{{ Avatar::create($course->title)->toBase64() }}" alt="course" class="img-fluid">
                                        @endif
                                    </a>
                                    <div class="courses-icon">
                                        <ul>
                                            <li class="protip-wish-btn"><a
                                                    href="https://calendar.google.com/calendar/r/eventedit?text={{ $course['title'] }}"
                                                    target="__blank" title="reminder"><i data-feather="bell"></i></a></li>

                                            @if(Auth::check())
                                            <li class="protip-wish-btn"><a href="" class="compare" data-id="{{filter_var($course->id)}}"
                                                    title="compare"><i data-feather="bar-chart"></i></a></li>
                                            @php
                                            $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',
                                            $course->id)->first();
                                            @endphp
                                            @if ($wish == NULL)
                                            <li class="protip-wish-btn">
                                                <form id="demo-form2" method="post"
                                                    action="{{ url('show/wishlist', $course->id) }}" data-parsley-validate
                                                    class="form-horizontal form-label-left">
                                                    {{ csrf_field() }}

                                                    <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                    <input type="hidden" name="course_id" value="{{$course->id}}" />

                                                    <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i
                                                            data-feather="heart"></i></button>
                                                </form>
                                            </li>
                                            @else
                                            <li class="protip-wish-btn-two heart-fill">
                                                <form id="demo-form2" method="post"
                                                    action="{{ url('remove/wishlist', $course->id) }}" data-parsley-validate
                                                    class="form-horizontal form-label-left">
                                                    {{ csrf_field() }}

                                                    <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                    <input type="hidden" name="course_id" value="{{$course->id}}" />

                                                    <button class="wishlisht-btn" title="Remove from Wishlist"
                                                        type="submit"><i data-feather="heart"></i></button>
                                                </form>
                                            </li>
                                            @endif
                                            @else
                                            <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i
                                                        data-feather="heart"></i></a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <div class="courses-content">        
                                    <div class="view-user-img">
                                        <a href="" title="{{$course->title}}">
                                            @if($course->user['user_img'] !== NULL && $course->user['user_img'] !== '')
                                            <img src="{{ asset('images/user_img/'.$course->user['user_img']) }}" class="img-fluid user-img-one" alt="{{$course->title}}">
                                            @else
                                            <img src="{{ Avatar::create($course->title)->toBase64() }}" alt="img">
                                            @endif
                                        </a>
                                                                
                                    </div>                            
                                    <div class="cat">
                                        <div class="rate text-right">
                                            <ul>
                                                @if($course->type == 1)
                                                    @if($course->course != NULL)
                                                        <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($course['discount_price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }} {{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
                                                        <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($course['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</strike></b></a></li>
                                                    @elseif($course->price != NULL)
                                                        <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($course['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
                                                    @endif
                                                @else
                                                    <li><a><b>{{ __('Free') }}</b></a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <h3><a class="truncate" href="{{route('user.course.show',['slug' => $course->slug ])}}"> {{$course->title}}</a></h3>
                                     <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($course->detail))) , $limit = 200, $end = '...') }}</p>
                                    <a href="{{route('user.course.show',['slug' => $course->slug ])}}" class="readmore">{{__('Read More')}} <i class="fal fa-long-arrow-right"></i></a>
                                </div>
                                <div class="icon">
                                    <img src="{{ url('frontcss/img/icon/cou-icon.png') }}" alt="img">
                                </div>
                            </div>
                        </div>
                        @endforeach
                      
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="pagination-wrap mt-20 text-center">
                                {!! $data->links() !!}
                            </div>
                        </div>
                    <div>
					
                </div>
            </section>
            @endif
            <!-- shop-area-end -->    
        </main>
        <!-- main-area-end -->
        

@endsection