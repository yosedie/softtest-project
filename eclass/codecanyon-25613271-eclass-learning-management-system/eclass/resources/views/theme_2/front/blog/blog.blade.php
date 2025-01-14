@extends('theme2.master')
@section('title', 'Blog')
@section('content')
@include('admin.message')
<!-- blog end -->
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
                            <h2>{{ __('Blog') }}</h2>
  
                             
                         </div>
                     </div>
                 </div>
                 <div class="breadcrumb-wrap2">
                       
                         <nav aria-label="breadcrumb">
                             <ol class="breadcrumb">
                                 <li class="breadcrumb-item"><a href="{{route('home')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                                 <li class="breadcrumb-item active" aria-current="page">{{__('Blog')}}</li>
                             </ol>
                         </nav>
                     </div>
                 
             </div>
         </div>
     </section>
     <!-- breadcrumb-area-end -->   
      <!-- inner-blog -->
      @if (isset($blog))
          
      @endif
     
     <section class="inner-blog pt-120 pb-120">
         <div class="container">
             <div class="row">
                @foreach($blogs as $blog)
                <div class="col-lg-4 col-md-6">
                    

                    <div class="bsingle__post mb-50">
                         <div class="bsingle__post-thumb">

                            @if($blog->slug != NULL)
                            <a href="{{ route('blog.detail', ['slug' => $blog->slug ]) }}" title="{{ __('blog')}}"><img src="{{ asset('images/blog/'.$blog->image) }}" class="img-fluid"  alt="blog"></a>
                         @else
                            <a href="{{ route('blog.detail', ['slug' => str_slug(str_replace('-','&',$blog->heading)) ]) }}" title="{{ __('blog')}}"><img src="{{ asset('images/blog/'.$blog->image) }}" class="img-fluid"  alt="blog"></a>
                         @endif
                         </div>
                         <div class="bsingle__content">
                             <div class="meta-info">
                                <div class="meta-info">
                                 <ul>
                                    
                                     <li><i class="fal fa-calendar-alt"></i> {{ date('d-m-Y',strtotime($blog['created_at'])) }}</li>
                                 </ul>
                             </div>
                             </div>
                             <h2><a href="{{ route('blog.detail', ['slug' => $blog->slug ]) }}" title="{{$blog->heading}}">{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($blog->heading ))) , $limit = 16, $end = '...') }}</a></h2>
                            <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($blog->detail))) , $limit = 110, $end = '...') }}</p>
                             <div class="blog__btn">
                                 <a href="{{ route('blog.detail', ['slug' => $blog->slug ]) }}" class="btn" title= "{{__('Read More')}}">{{__('Read More')}} <i class="fal fa-long-arrow-right"></i></a>
                             </div>
                         </div>
                    </div>
                    
                    
                    
                </div>
                 @endforeach
                <div class="pagination-wrap">
                    {{ $blogs->links() }}
                </div>

                
             </div>

         </div>
     </section>
     <!-- inner-blog-end -->
 @endsection