@extends('theme2.master')
@section('title', 'About Us')
@section('content')
@include('admin.message')

       <main>
        
          <!-- breadcrumb-area -->
        @php
        $gets = App\Breadcum::first();
        @endphp
        @if($about['one_enable'] == 1)
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
                                <h2 class="about-home-one-heading text-center">{{ $about->one_heading }}</h2>    
                                   
                               </div>
                           </div>
                       </div>
                       <div class="breadcrumb-wrap2">
                             
                               <nav aria-label="breadcrumb">
                                   <ol class="breadcrumb">
                                       <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                                       <li class="breadcrumb-item active" aria-current="page">{{__('About Us')}}</li>
                                   </ol>
                               </nav>
                           </div>
                       
                   </div>
               </div>
           </section>
           @endif
           <!-- breadcrumb-area-end -->
             <!-- about-area -->
           @if($about['two_enable'] == 1)
           <section class="about-area about-page about-p pt-120 pb-120 p-relative fix">
               <div class="animations-02"><img src="{{url('frontcss/img/bg/an-img-02.png')}}" alt="contact-bg-an-01"></div>
               <div class="container">
                   <div class="row justify-content-center align-items-center">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                           <div class="s-about-img p-relative  wow fadeInLeft animated" data-animation="fadeInLeft" data-delay=".4s">
                               <img src="{{ asset('images/about/'.$about->two_imageone) }}" alt="img"> 
                           </div>
                         
                       </div>
                       
                   <div class="col-lg-6 col-md-12 col-sm-12">
                           <div class="about-content s-about-content pl-15 wow fadeInRight  animated" data-animation="fadeInRight" data-delay=".4s">
                               <div class="about-title second-title pb-25">  
                                   <h5><i class="fal fa-graduation-cap"></i> {{ $gsetting->project_title }}</h5>
                                   <h2>{{$about->two_heading}}</h2>                                   
                               </div>
                                  <p class="txt-clr">{{$about->one_text}}</p>
                                   <p>{{$about->two_txtone}}</p>
                                    <div class="about-content2">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="green2"> 
                                                    @php
                                                    $feature = App\About::first();
                                                    @endphp   
                                                    <li><div class="abcontent"><div class="ano"><span>1</span></div> <div class="text"><h3>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($about->three_countone))) , $limit = 12, $end = '...') }}</h3> <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($about->three_txtone))) , $limit = 50, $end = '...') }}</p></div></div></li>
                                                    <li><div class="abcontent"><div class="ano"><span>2</span></div> <div class="text"><h3>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($about->three_counttwo))) , $limit = 12, $end = '...') }}</h3> <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($about->three_txttwo))) , $limit = 50, $end = '...') }}</p></div></div></li>
                                                    <li><div class="abcontent"><div class="ano"><span>3</span></div> <div class="text"><h3>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($about->three_countthree))) , $limit = 12, $end = '...') }}</h3> <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($about->three_txtthree))) , $limit = 50, $end = '...') }}</p></div></div></li>
                                                    <li><div class="abcontent"><div class="ano"><span>4</span></div> <div class="text"><h3>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($about->three_countfour))) , $limit = 12, $end = '...') }}</h3> <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($about->three_txtfour))) , $limit = 50, $end = '...') }}</p></div></div></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                
                           </div>
                       </div>
                    
                   </div>
               </div>
           </section>
           @endif

           <!-- about-area-end -->

        <!-- cta-area -->
        @if($about['three_enable'] == 1)
        <section class="cta-area cta-bg pt-50 pb-50" style="background-image: url('{{ asset('images/about/cta_bg02.png') }}')">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="section-title cta-title wow fadeInLeft animated" data-animation="fadeInDown animated" data-delay=".2s">
                            <h2>{{$about->five_heading}}</h2>
                            <p>{{ str_limit($about->six_deatilone, $limit = 100, $end = '...') }}</p>
                        </div>
                                        
                    </div>
                    <div class="col-lg-4 text-right"> 
                        <div class="cta-btn s-cta-btn wow fadeInRight animated mt-30" data-animation="fadeInDown animated" data-delay=".2s">
                                <div class="btn ss-btn smoth-scroll">{{__('Financial Aid')}}</div>
                            </div>
                    </div>
                
                </div>
            </div>
        </section>
        @endif
        <!-- cta-area-end -->

          <!-- frequently-area -->
          @if($about['four_enable'] == 1)
           <section class="faq-area pt-120 pb-120 p-relative fix">
               <div class="animations-10"><img src="{{url('frontcss/img/bg/an-img-04.png')}}"></div>
               <div class="animations-08"><img src="{{url('frontcss/img/bg/an-img-05.png')}}"></div>
               <div class="container">  
                   <div class="row justify-content-center  align-items-center">
                       <div class="col-lg-7">
                           <div class="section-title wow fadeInLeft animated" data-animation="fadeInDown animated" data-delay=".2s">
                               <h2>{{$about->three_heading}}</h2>
                               <p>{{ str_limit($about->six_deatiltwo, $limit = 100, $end = '...') }}</p>
                           </div>
                           @php
                           $faqs = App\FaqStudent::get();
                           @endphp
                            @if(isset($faqs))
                              <div class="faq-wrap mt-30 pr-30 wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                                @foreach ($faqs as $index => $faq)
                                <div class="accordion" id="accordionExample">
                                
                                   <div class="card">
                                       <div class="card-header" id="heading{{$faq->id}}">
                                           <h2 class="mb-0">
                                                <button class="faq-btn  {{ $index == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{$faq->id}}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse">
                                                {{$faq->title}}
                                                </button>
                                           </h2>
                                       </div>
                                       <div id="collapse{{$faq->id}}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" >
                                            <div class="card-body">
                                                {{substr(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($faq->details))), 0, 100)}}
                                            </div>
                                        </div>
                                   </div>     
                                </div>
                               @endforeach
                           </div>
                           @endif
                       </div>
                       <div class="col-lg-5">
                           <div class="contact-bg02">
                           <div class="section-title wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                               <h2>
                                {{__(' Make An Contact')}}
                               </h2>
                             
                           </div>
                               
                       <form action="{{route('contact.user')}}" method="post" class="contact-form mt-30 wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                           @csrf
                        <div class="row">
                           <div class="col-lg-12">
                               <div class="contact-field p-relative c-name mb-20">                                    
                                   <input type="text" id="firstn" name="fname" placeholder="First Name" required>
                               </div>                               
                           </div>
                           
                           <div class="col-lg-12">                               
                               <div class="contact-field p-relative c-subject mb-20">                                   
                                   <input type="text" id="email" name="email" placeholder="Email" required>
                               </div>
                           </div>		
                           <div class="col-lg-12">                               
                               <div class="contact-field p-relative c-subject mb-20">                                   
                                   <input type="text" id="phone" name="mobile" placeholder="Phone No." required>
                               </div>
                           </div>	
                         
                           <div class="col-lg-12">
                               <div class="contact-field p-relative c-message mb-30">                                  
                                   <textarea name="message" id="message" cols="30" rows="10" placeholder="Write comments"></textarea>
                               </div>
                               <div class="slider-btn">                                          
                                           <button class="btn ss-btn" data-animation="fadeInRight" data-delay=".8s"><span>{{__('Submit Now')}}</span> <i class="fal fa-long-arrow-right"></i></button>				
                                       </div>                             
                           </div>
                           </div>
                       
                   </form>
                           
                           </div>
                       </div>
                   </div>
               </div>
           </section>
           @endif
           <!-- frequently-area-end -->	

          <!-- steps-area -->
           @if($about['five_enable'] == 1)
           <section class="steps-area2 p-relative fix">
               <div class="animations-02"><img src="{{url('frontcss/img/bg/an-img-10.png')}}" alt="an-img-01"></div>
               <div class="container">
         
                   <div class="row align-items-center">
                       <div class="col-lg-6 col-md-12">
                           <div class="step-box step-box2 wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                               <div class="dnumber">
                                   <div class="date-box"><img src="{{url('frontcss/img/icon/fea-icon01.png')}}" alt="icon"></div>
                               </div>
                               <div class="text">
                                   <h2>{{$about->two_heading}}</h2>
                                   <p>{{$about->three_text}}</p>
                               </div>
                           </div>
                       </div>
                       <div class="col-lg-6 col-md-12">
                           <div class="step-img2 wow fadeInLeft animated" data-animation="fadeInLeft" data-delay=".4s">
                               <img src="{{url('frontcss/img/bg/steps-img-2.png')}}" alt="class image">
                           </div>
                          
                       </div>
                       
                      
                       
                   </div>
                   
               </div>
           </section>
           @endif
           <!-- steps-area-end -->
            <!-- steps-area -->
           <section class="steps-area2 p-relative fix">              
               <div class="container">
                   <div class="animations-08"><img src="{{url('frontcss/img/bg/an-img-20.png')}}" alt="contact-bg-an-01"></div>
                   <div class="row align-items-center">                       
                       <div class="col-lg-6 col-md-12">
                           <div class="step-img3 wow fadeInLeft animated" data-animation="fadeInLeft" data-delay=".4s">
                               <img src="{{ asset('images/about/'.$about->five_imageone) }}" alt="class image">
                           </div>
                          
                       </div>
                        <div class="col-lg-6 col-md-12">
                           <div class="step-box step-box3 wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                               <div class="dnumber">
                                   <div class="date-box"><img src="{{url('frontcss/img/icon/fea-icon03.png')}}" alt="icon"></div>
                               </div>
                               <div class="text">
                                   <h2>{{$about->six_heading}}</h2>
                                   <p>{{ str_limit($about->six_deatilthree, $limit = 100, $end = '...') }}</p>
                               </div>
                           </div>
                       </div>
                      
                       
                   </div>
                   
               </div>
           </section>
           <!-- steps-area-end -->

           <!-- testimonial-area -->
           <section class="testimonial-area pt-120 pb-115 p-relative fix">
                <div class="animations-01"><img src="{{url('frontcss/img/bg/an-img-03.png')}}" alt="an-img-01"></div>
               <div class="animations-02"><img src="{{url('frontcss/img/bg/an-img-04.png')}}" alt="contact-bg-an-01"></div>
               <div class="container">
                   <div class="row">
                       <div class="col-lg-12">
                           <div class="section-title text-center mb-50 wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                               <h5><i class="fal fa-graduation-cap"></i> &nbsp;{{__('Testimonial')}} </h5>
                               <h2>
                                {{ $about->four_heading }}
                               </h2>
                            
                           </div>
                          
                       </div>
                       
                       <div class="col-lg-12">
                           <div class="testimonial-active wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                               <div class="single-testimonial text-center">
                                    <div class="qt-img">
                                   <img src="{{url('frontcss/img/testimonial/qt-icon.png')}}" alt="img">
                                   </div>
                                   <p>{{ str_limit($about->one_text , $limit = 50, $end = '...') }}</p>
                                   <div class="testi-author">
                                       <img src="{{ asset('images/about/'.$about->two_imagethree) }}" alt="img">
                                   </div>
                                   <div class="ta-info">
                                           <h6>{{ $about->six_txtthree }}</h6>
                                           <span> {{ $about->three_txtone }}</span>
                                       </div>                                    
                               </div>
                               <div class="single-testimonial text-center">
                                    <div class="qt-img">
                                   <img src="{{url('frontcss/img/testimonial/qt-icon.png')}}" alt="img">
                                   </div>
                                   <p>{{ str_limit( $about->two_text , $limit = 50, $end = '...') }}</p>
                                   <div class="testi-author">
                                    <img src="{{ asset('images/about/'.$about->two_imageone) }}" alt="img">
                                   </div>
                                   <div class="ta-info">
                                    <h6>{{ $about->six_txtone }}</h6>

                                    <span> {{ $about->three_txttwo}}</span>
                                       </div>                                    
                               </div>
                             <div class="single-testimonial text-center">
                                    <div class="qt-img">
                                   <img src="{{url('frontcss/img/testimonial/qt-icon.png')}}" alt="img">
                                   </div>
                                   <p>{{ str_limit( $about->two_imagetext  , $limit = 50, $end = '...') }}</p>
                                   
                                   <div class="testi-author">
                                    <img src="{{ asset('images/about/'.$about->two_imagetwo) }}" alt="img">
                                   </div>
                                   <div class="ta-info">
                                    <h6>{{ $about->six_txttwo }}</h6>
                                    <span> {{ $about->three_txtthree }}</span>
                                       </div>                                    
                               </div>
                               <div class="single-testimonial text-center">
                                    <div class="qt-img">
                                   <img src="{{url('frontcss/img/testimonial/qt-icon.png')}}" alt="img">
                                   </div>
                                   <p class="btm-40">{{ str_limit($about->three_txtfive, $limit = 50, $end = '...') }}</p>

                                   <div class="testi-author">
                                    <img src="{{ asset('images/about/'.$about->two_imagefour) }}" alt="img">
                                   </div>
                                   <div class="ta-info">
                                    <h6>{{ $about->two_txtfour }}</h6>

                                           <span>{{ $about->two_txtone }}</span>
                                       </div>                                    
                               </div>
                              <div class="single-testimonial text-center">
                                    <div class="qt-img">
                                   <img src="{{url('frontcss/img/testimonial/qt-icon.png')}}" alt="img">
                                   </div>
                                   <p>{{ str_limit( $about->three_txtfour, $limit = 50, $end = '...') }}</p>
                                   <div class="testi-author">
                                    <img src="{{ asset('images/about/'.$about->four_imageone) }}">
                                   </div>
                                   <div class="ta-info">
                                    <h6>{{ $about->two_txtthree}}</h6>
                                           <span>{{ $about->two_txttwo }}</span>
                                       </div>                                    
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </section>
           <!-- testimonial-area-end -->
           <!-- brand-area -->
            @if($hsetting->trusted_enable == 1 && ! $trusted->isEmpty() )
            <div class="brand-area pt-60 pb-60 bg_darkblue">
                <div class="container">
                    <div class="row brand-active">
                    @foreach($trusted as $trust)
                        <div class="col-xl-2">
                            <div class="single-brand owl-carousel">
                                <img src="{{ asset('images/trusted/'.$trust['image']) }}" class="img-fluid owl-lazy" alt="img">
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
            @endif
            <!-- brand-area-end -->     
       </main>
@endsection