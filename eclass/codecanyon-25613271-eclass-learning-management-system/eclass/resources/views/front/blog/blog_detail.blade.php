@extends('theme.master')
@section('title', "$blog->heading")
@section('content')

@include('admin.message')

@section('meta_tags')
@php
    $url =  URL::current();
@endphp

<meta name="title" content="{{ $blog['heading'] }}">
<meta name="description" content="{{ preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($blog['detail']))) }} ">
<meta name="author" content="elsecolor">
<meta property="og:title" content="{{ $blog['heading'] }} ">
<meta property="og:url" content="{{ $url }}">
<meta property="og:description" content="{{ preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($blog['detail']))) }}">
<meta property="og:image" content="{{ asset('images/blog/'.$blog['image']) }}">
<meta itemprop="image" content="{{ asset('images/blog/'.$blog['image']) }}">
<meta property="og:type" content="website">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="{{ asset('images/blog/'.$blog['image']) }}">
<meta property="twitter:title" content="{{ $blog['heading'] }} ">
<meta property="twitter:description" content="{{ preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($blog['detail']))) }}">
<meta name="twitter:site" content="{{ url()->full() }}" />

<link rel="canonical" href="{{ url()->full() }}"/>
<meta name="robots" content="all">
<meta name="keywords" content="{{ $gsetting->meta_data_keyword }}">
    

@endsection
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
                        <h1 class="wishlist-home-heading">{{ __('Blog Detail') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- blog-dtl start-->
<section id="blog-dtl" class="blog-dtl-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="blog-dtl-img btm-30">
                    <img src="{{ asset('images/blog/'.$blog->image) }}" class="img-fluid" alt="blog"> 
                </div>
                <ul>
                    <li>
                        <div class="view-date">
                            <a href="#"><i data-feather="calendar"></i>
                                {{ date('d-m-Y',strtotime($blog['created_at'])) }}</a>
                        </div>
                    </li>
                    <li>
                        <div class="view-time">
                            <a href="#"><i data-feather="clock"></i>
                                {{ date('h:i:s A',strtotime($blog['created_at'])) }}</a>
                        </div>
                    </li>
                </ul> 
                <div class="blog-dtl-block-heading btm-20">{{ $blog->heading }}</div>                
                <!-- <div class="blog-idea btm-30"><a href="#" title="blog-idea">{{ $blog->text }}</a></div> -->
                <p class="btm-20">{!! $blog->detail !!}</p>
                <div class="blog-link btm-30">
                    <a href="{{ route('blog.all') }}" class="btn btn-primary" title="{{ __('back to blog')}}"><i class="fa fa-chevron-left"></i>{{ __('Back to Blog') }}</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="blog-dtl-sidebar">
                    <h4 class="sidebar-heading">{{ __('Recent Posts') }}</h4>
                     @foreach($blogs as $b)
                    <div class="sidebar-block">
                        <div class="row">
                            

                            <div class="col-lg-4 col-md-4 col-4">
                                <img src="{{ asset('images/blog/'.$b->image) }}" class="img-fluid"  alt="{{ __('blog')}}">
                            </div>
                            <div class="col-lg-8 col-md-8 col-8">
                                <h5 class="sidebar-block-heading"><a href="{{ route('blog.detail', ['slug' => $b->slug ]) }}" title="{{ $b->heading }}">{{ $b->heading }}</a></h5>
                                <div class="view-date">
                                    <a href="{{ route('blog.detail', ['slug' => $b->slug ]) }}"><i data-feather="calendar"></i>{{ date('d-m-Y',strtotime($b['created_at'])) }}</a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    @endforeach
                    <a href="{{ route('blog.all') }}" class="btn btn-primary" title="{{ __('View All Posts') }}">{{ __('View All Posts') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- blog-dtl end-->
@endsection