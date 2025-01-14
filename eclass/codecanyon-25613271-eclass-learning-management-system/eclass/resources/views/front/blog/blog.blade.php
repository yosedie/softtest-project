@extends('theme.master')
@section('title', 'Blog')
@section('content')

@include('admin.message')
<!-- about-home start -->
@php
$gets = App\Breadcum::first();
@endphp
@if(isset($gets))
<section id="business-home" class="business-home-main-block">
    <div class="business-img">
        @if($gets['img'] !== NULL && $gets['img'] !== '')
        <img src="{{ url('/images/breadcum/'.$gets->img) }}" class="img-fluid" alt="{{$gets->text}}" />
        @else
        <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="{{ __('course')}}" class="img-fluid">
        @endif
    </div>
    <div class="overlay-bg"></div>
    <div class="container-xl">
        <div class="business-dtl">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bredcrumb-dtl">
                        <h1 class="wishlist-home-heading">{{ __('Blog') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- about-home end --> 
<!-- blog start -->
@if(isset($blogs))
<section id="blog" class="blog-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    @foreach($blogs as $blog)
                    <div class="col-lg-3 col-md-6">
                        <div class="blog-block btm-40">
                            <div class="blog-block-img">
                               @if($blog->slug != NULL)
                                    <a href="{{ route('blog.detail', ['slug' => $blog->slug ]) }}"><img src="{{ asset('images/blog/'.$blog->image) }}" class="img-fluid"  alt="blog"></a>
                                @else
                                    <a href="{{ route('blog.detail', ['slug' => str_slug(str_replace('-','&',$blog->heading)) ]) }}"><img src="{{ asset('images/blog/'.$blog->image) }}" class="img-fluid"  alt="blog"></a>
                                @endif
                            </div>
                            <div class="block-block-dtl">
                                <h3 class="blog-slider-heading">
                                    
                                    @if($blog->slug != NULL)
                                        <a href="{{ route('blog.detail', ['slug' => $blog->slug ]) }}">{{ $blog->heading }}</a>
                                    @else
                                         <a href="{{ route('blog.detail', ['slug' => str_slug(str_replace('-','&',$blog->heading)) ]) }}">{{ $blog->heading }}</a>
                                    @endif
                                </h3>
                                <p>{{substr(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($blog->detail))), 0, 151)}}...</p>
                                <div class="view-footer">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                            <div class="view-date">
                                                <a href="{{ route('blog.detail', ['slug' => str_slug(str_replace('-','&',$blog->heading)) ]) }}"><i data-feather="calendar"></i>
                                                    {{ date('d-m-Y',strtotime($blog['created_at'])) }}</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                            <div class="view-time text-right">
                                                <a href="{{ route('blog.detail', ['slug' => str_slug(str_replace('-','&',$blog->heading)) ]) }}"><i data-feather="clock"></i>
                                                    {{ date('h:i:s A',strtotime($blog['created_at'])) }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="pull-right">{{ $blogs->links() }}</div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- blog end -->

@endsection