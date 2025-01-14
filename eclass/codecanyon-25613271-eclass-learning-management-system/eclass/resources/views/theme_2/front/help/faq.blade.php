@extends('theme2.master')
@section('title','help.show')
@section('content')
@include('admin.message')

<!-- help start-->
@php
$gets = App\Breadcum::first();
@endphp


  <!-- breadcrumb-area -->
  @if(isset($gets))
  @if($gets['img'] !== NULL && $gets['img'] !== '')
  <section class="breadcrumb-area d-flex  p-relative align-items-center" style="background-image:url({{ url('/images/breadcum/'.$gets->img) }})">
  
              
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-12 col-lg-12">
                <div class="breadcrumb-wrap text-left">
                    <div class="breadcrumb-title">
                        <h2>{{__('Faq')}}</h2>    
                        
                    </div>
                </div>
            </div>
            <div class="breadcrumb-wrap2">
                  
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('Faq')}}</li>
                        </ol>
                    </nav>
                </div>
            
        </div>
    </div>
</section>
@endif
@endif
<!-- breadcrumb-area-end --> 
<!-- event-area -->
<section class="event event03 pt-150 pb-120 p-relative fix">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5  wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
               
                <div class="s-video-wrap2" style="background-image:url('frontcss/img/bg/video-img3.png')">
                    <div class="s-video-content text-center">
                       <h6><a href="https://www.youtube.com/watch?v=7e90gBu4pas" class="popup-video mb-50"><img src="{{ url('frontcss/img/bg/play-button.png') }}" alt="circle_right"></a></h6> 
                       
                    </div>
                </div>
            </div>
            @if ($faqs)
            <div class="col-lg-7 col-md-7  wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
               <div class="faq-wrap pl-30 wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                    <div class="accordion" id="accordionExample">
                        @foreach($faqs as $faq)
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <button class="faq-btn" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree"  >
                                        {{$faq->title}}
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseThree" class="collapse show"
                                data-bs-parent="#accordionExample">
                                <div class="card-body">
                                    {{substr(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($faq->details))), 0, 100)}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>  
            </div> 
            @endif
        </div>
    </div>
</section>
<!-- event-area -->
<!-- brand-area -->
            <div class="brand-area pt-60 pb-60" style="background-color:#4099BF">
                <div class="container">
                    <div class="row brand-active">
                        <div class="col-xl-2">
                            <div class="single-brand">
                                <img src="{{url('frontcss/img/brand/b-logo1.png')}}" alt="img">
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="single-brand">
                                 <img src="{{url('frontcss/img/brand/b-logo2.png')}}" alt="img">
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="single-brand">
                                 <img src="{{url('frontcss/img/brand/b-logo3.png')}}" alt="img">
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="single-brand">
                                  <img src="{{url('frontcss/img/brand/b-logo4.png')}}" alt="img">
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="single-brand">
                                 <img src="{{url('frontcss/img/brand/b-logo5.png')}}" alt="img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- brand-area-end -->


            @endsection




























































































