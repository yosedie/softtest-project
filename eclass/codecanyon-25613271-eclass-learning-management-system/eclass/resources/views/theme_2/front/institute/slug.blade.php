@extends('theme2.master')
@section('title', 'Institute Detail')
@section('content')
@include('admin.message')
<!-- breadcumb start -->
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
                        <h2>{{ __('Institute Profile') }}</h2>

                            
                        </div>
                    </div>
                </div>
                <div class="breadcrumb-wrap2">
                    
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{__('Institute Profile')}}</li>
                            </ol>
                        </nav>
                    </div>
                
            </div>
        </div>
    </section>
<!-- breadcumb end -->
<section id="institute-detail" class="institute-detail-main-block pt-120 pb-120">
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
                            <h3 class="institute-content-title">{{ $institute ->title }}</h3>
                            <div class="institute-mobile">{{ $institute ->mobile }}</div>
                            <div class="institute-email">{{ $institute ->email }}</div>
                            <div class="institute-address">{{ $institute ->address }}</div>
                            <div class="institute-status mt-2 mb-2">
                                <span class="badge bg-primary"> @if($institute->status == '1')
                                    {{ __('Active') }}
                                    @else
                                    {{ __('Deactivate') }}

                                    @endif
                                </span>
                            </div>
                            <div class="institute-verified mt-2 mb-2">
                                <span class="badge bg-success">@if($institute->verified == '1')
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
                    </ul>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane active show" id="courses" role="tabpanel" aria-labelledby="courses-tab">
                            @if(isset($course))
                            <div class="about-instructor">
                                <div class="row">
                                    @foreach($course as $c)
                                    @if($c->status == 1)
                                    <div class="col-lg-6">
                                        <div class="courses-item mb-30  ms-0 me-0 hover-zoomin @if($gsetting['course_hover'] == 1) protip @endif">
                    
                                            <div class="thumb fix ">
                                                @if($c['preview_image'] !== NULL && $c['preview_image'] !== '0')
                                                <a href="{{ route('user.course.show',['slug' => $c->slug ]) }}"><img src="{{ asset('images/course/'.$c['preview_image']) }}" alt="contact-bg-an-01"></a>
                                                @else
                                                <a href="{{ route('user.course.show',['slug' => $c->slug ]) }}"><img src="{{ Avatar::create($c->title)->toBase64() }}" alt="contact-bg-an-01"></a>
                                                @endif
                                                    
                                                <div class="courses-icon">
                                                    <ul>
                                                        <li class="protip-wish-btn">
                                                            <a  href="https://calendar.google.com/calendar/r/eventedit?text={{ $c['title'] }}"
                                                                target="__blank" title="reminder"><i data-feather="bell"></i></a>
                                                        </li>

                                                        @if (Auth::check())
                                                        <li class="protip-wish-btn">
                                                            <a class="compare" data-id="{{ filter_var($c->id) }}" title="compare">
                                                                <i data-feather="bar-chart"></i>
                                                            </a>
                                                        </li>
                                                        

                                                        @php
                                                        $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',
                                                        $c->id)->first();
                                                        @endphp
                                                        @if ($wish == NULL)
                                                        <li class="protip-wish-btn">
                                                            <form id="demo-form2" method="post"
                                                                action="{{ url('show/wishlist', $c->id) }}" data-parsley-validate
                                                                class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}

                                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                                <input type="hidden" name="course_id" value="{{$c->id}}" />

                                                                <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i
                                                                        data-feather="heart"></i></button>
                                                            </form>
                                                        </li>
                                                        @else
                                                        <li class="protip-wish-btn-two heart-fill">
                                                            <form id="demo-form2" method="post"
                                                                action="{{ url('remove/wishlist', $c->id) }}" data-parsley-validate
                                                                class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}

                                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                                <input type="hidden" name="course_id" value="{{$c->id}}" />

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
                                            @if(isset($c->discount_price))
                                            <div class="badges bg-priamry offer-badge"><span>{{__('OFF')}}<span><?php echo round((($c->price - $c->discount_price) * 100) / $c->price) . '%'; ?></span></span></div>
                                            @endif
                                            <div class="courses-content">    
                                                <div class="view-user-img">
                                                    <a href="{{ route('all/profile',$c->user->id) }}" title="{{ optional($c->user)['fname'] }}">
                                                        @if($c->user['user_img'] !== NULL && $c->user['user_img'] !== '')
                                                        <img src="{{ asset('images/user_img/'.$c->user['user_img']) }}" class="img-fluid user-img-one" alt="{{$c->title}}">
                                                        @else
                                                        <img src="{{ Avatar::create($c->title)->toBase64() }}" alt="img">
                                                        @endif
                                                    </a>
                                                                            
                                                </div>                                
                                                <div class="cat">
                                                    <div class="rate text-right">
                                                        <ul>
                                                            @if($c->type == 1)
                                                                @if($c->discount_price != NULL)
                                                                    <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($c['discount_price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }} {{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
                                                                    <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($c['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</strike></b></a></li>
                                                                @elseif($c->price != NULL)
                                                                    <li><a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($c['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a></li>
                                                                @endif
                                                            @else
                                                                <li><a><b>{{ __('Free') }}</b></a></li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                                <h3><a href="{{ route('user.course.show',['slug' => $c->slug ]) }}"> {{$c->category['title'] ?? '-'}}</a></h3>
                                                    <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($c->detail))) , $limit = 70, $end = '...') }}
                                                <a href="{{ route('user.course.show',['slug' => $c->slug ]) }}" class="readmore">{{__('Read More ')}}<i class="fal fa-long-arrow-right"></i></a>
                                            </div>
                                            <div class="icon">
                                                <img src="{{ url('frontcss/img/icon/cou-icon.png') }}" alt="img">
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
                                <li><span class="badge bg-info">{{ $institute->skill }}</span></li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="affiliated" role="tabpanel" aria-labelledby="affiliated-tab">
                            <ul>
                                <li><span class="badge bg-info">{{ $institute->affilated_by }}</span></li>                               
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection