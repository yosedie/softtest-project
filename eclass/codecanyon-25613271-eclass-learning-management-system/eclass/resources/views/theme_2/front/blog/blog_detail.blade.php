@extends('theme2.master')
@section('title', "Blog.Details")
@section('content')
@include('admin.message')
@section('meta_tags')
@php
    $url =  URL::current();
@endphp
@endsection
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
                        <h2>{{__('Blog Details')}}</h2>    
                        
                    </div>
                </div>
            </div>
            <div class="breadcrumb-wrap2">
                  
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('Blog Details')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb-area-end --> 
 <!-- inner-blog -->
 <section class="inner-blog b-details-p pt-120 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog-details-wrap">
                    <div class="details__content pb-30">
                        <h2>{{ $blog->heading }}</h2>   
                        <div class="meta-info">
                            <ul>
                                <li><i class="fal fa-calendar-alt"></i>   {{ date('d-m-Y',strtotime($blog['created_at'])) }}</li>
                            </ul>
                        </div>
                        <p>{!! $blog->detail !!}</p>
                        <div class="details__content-img">
                            <img src="{{ asset('images/blog/'.$blog->image) }}" alt="{{ $blog->heading }}">
                        </div>
                        <figure>
                        </figure>
                    </div>
                    <div class="related__post mt-45 mb-85">
                        <div class="post-title">
                            <h4>{{__('Related Post')}}</h4>
                        </div>
                        <div class="row">
                            @foreach($blogs as $blog)
                            <div class="col-md-6">
                                <div class="related-post-wrap mb-30">
                                    <div class="post-thumb">
                                        <img src="{{ asset('images/blog/'.$blog->image) }}" alt="{{ $blog->heading }}">
                                    </div>
                                    <div class="rp__content">
                                        @php
                                        $image = $blog['image'];
                                        $slug = $blog->slug;
                                        $headingSlug = str_slug(str_replace('-','&',$blog->heading));
                                        $detailRoute = $slug != NULL ? route('blog.detail', ['slug' => $slug]) : route('blog.detail', ['slug' => $headingSlug]);
                                        $imageSrc = $image ? asset('images/blog/'.$image) : Avatar::create($blog->heading)->toBase64();
                                        @endphp
                                        <h3><a class="truncate" href="{{ $detailRoute }}">{{ $blog->heading }}</a></h3>
                                        <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($blog->detail))) , $limit = 100, $end = '...') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                           
                        </div>
                    </div>
                </div>
            </div>
             <!-- #right side -->
            <div class="col-sm-12 col-md-12 col-lg-4">
                <aside class="sidebar-widget">
                  
                    <section id="recent-posts-4" class="widget widget_recent_entries">
                     <h2 class="widget-title">{{__('Recent Posts')}}</h2>
                     <ul>
                     @foreach($blogs as $b)
                     @php
                     $image = $b['image'];
                     $slug = $b->slug;
                     $headingSlug = str_slug(str_replace('-','&',$b->heading));
                     $detailRoute = $slug != NULL ? route('blog.detail', ['slug' => $slug]) : route('blog.detail', ['slug' => $headingSlug]);
                     $imageSrc = $image ? asset('images/blog/'.$image) : Avatar::create($b->heading)->toBase64();
                     @endphp
                        <li>
                            <div class="sidebar-blog-img">
                                <img src="{{ asset('images/blog/'.$b->image) }}" class="img-fluid"  alt="{{ __('blog')}}">
                            </div>
                            <div class="sidebar-blog-text">
                                <a href="{{ $detailRoute }}">{{ $b->heading }}</a>
                                <span class="post-date">{{ date('d-m-Y',strtotime($b['created_at'])) }}</span>
                            </div>
                        </li>
                    
                        @endforeach
                     </ul>
                  </section>
               </aside>
            </div>
            <!-- #right side end -->
        </div>
    </div>
</section>
<!-- inner-blog-end -->
@endsection