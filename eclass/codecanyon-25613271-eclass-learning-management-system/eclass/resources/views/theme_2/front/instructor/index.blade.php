@extends('theme2.master')
@section('title','allinstructor/view')
@section('content')
@include('admin.message')
<!-- breadcumb start -->
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
                        <h2>{{('Our Teacher')}}</h2>    
                        
                    </div>
                </div>
            </div>
            <div class="breadcrumb-wrap2">
                  
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('Our Teacher')}}</li>
                        </ol>
                    </nav>
                </div>
            
        </div>
    </div>
</section>
@endif
@endif
<!-- breadcrumb-area-end -->
 <!-- team-area -->
 <section class="team-area2 fix p-relative pt-120 pb-80">  
    <div class="container">  
      <div class="row">   
          <div class="col-lg-12 p-relative">
             <div class="section-title center-align mb-50 text-center wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                 <h5><i class="fal fa-graduation-cap"></i> {{__('Our Teacher')}}</h5>
                  <h2>
                     {{__(' Our Expert Teacher')}}
                  </h2>
               
              </div>
          </div>                        
           
      </div>
    
</section>
@if(isset($instructors))
 <section class="team-area fix p-relative pt-150 pb-80">  
    <div class="animations-06"><img src="{{url('frontcss/img/bg/an-img-17.png')}}" alt="an-img-01"></div>
    <div class="animations-09"><img src="{{url('frontcss/img/bg/slider_shape03.png')}}" alt="contact-bg-an-01"></div>
    <div class="container">  

       <div class="row">   
        @foreach($instructors as $inst)
            <div class="col-xl-3 col-md-6">
                <div class="single-team mb-40" >
                    <div class="team-thumb">
                        <div class="brd">
                        @if($inst['user_img'] !== NULL && $inst['user_img'] !== '')
                            <a href="{{ route('allinstructor/profile',$inst->id) }}"> <img src="{{ url('/images/user_img/'.$inst->user_img) }}" alt="img"></a>
                            @else
                            <img src="{{ Avatar::create($inst->fname)->toBase64() }}">
                            @endif
                        </div>
                    </div>
                    <div class="team-info">
                        <h4><a href="{{ route('allinstructor/profile',$inst->id) }}">{{ $inst->fname }} {{ $inst->lname }}</a></h4>
                        <p>{{__('CEO & Founder')}}</p>
                        <div class="team-social">
                            <ul>
                                <li><a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a></li> 
                                <li><a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a></li>
                                <li> <a href="https://twitter.com/"><i class="fab fa-twitter"></i></a></li>                                                  
                            </ul>       
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-xl-3 col-md-6">
                <div class="single-team mb-40" >
                    <div class="team-thumb">
                        <div class="brd">
                           <a href="team-single.html"> <img src="img/team/team10.png" alt="img"></a>
                        </div>                                     
                    </div>
                    <div class="team-info">
                        <h4><a href="team-single.html">Ella Thompson</a></h4>
                        <p>Kids Teacher</p>
                        <div class="team-social">
                            <ul>
                                <li><a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a></li> 
                                <li><a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a></li>
                                <li> <a href="https://twitter.com/"><i class="fab fa-twitter"></i></a></li>                                                  
                            </ul>          
                        </div>
                    </div>
                </div>
            </div> --}}
           {{-- <div class="col-xl-3 col-md-6">
                <div class="single-team mb-40" >
                    <div class="team-thumb">
                        <div class="brd">
                           <a href="team-single.html"> <img src="img/team/team11.png" alt="img"></a>
                        </div>
                        
                    </div>
                    <div class="team-info">
                        <h4><a href="team-single.html">Vincent Cooper</a></h4>
                        <p>Kids Teacher</p>
                        <div class="team-social">
                            <ul>
                                <li><a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a></li> 
                                <li><a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a></li>
                                <li> <a href="https://twitter.com/"><i class="fab fa-twitter"></i></a></li>                                                  
                            </ul>          
                        </div>
                    </div>
                </div>
            </div> --}}
             {{-- <div class="col-xl-3 col-md-6">
                <div class="single-team mb-40" >
                    <div class="team-thumb">
                        <div class="brd">
                            <a href="team-single.html"> <img src="img/team/team12.png" alt="img"></a>
                        </div>
                    
                    </div>
                    <div class="team-info">
                        <h4><a href="team-single.html">Danielle Bryant</a></h4>
                        <p>Kids Teacher</p>
                        <div class="team-social">
                           <ul>
                                <li><a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a></li> 
                                <li><a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a></li>
                                <li> <a href="https://twitter.com/"><i class="fab fa-twitter"></i></a></li>                                                  
                            </ul>       
                        </div>
                    </div>
                </div>
            </div> --}}
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- team-area-end --> 
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
  <!-- team-area -->
  
<!-- team-area-end --> 
@endsection
