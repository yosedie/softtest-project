@extends('theme2.master')
@section('title','front/service')
@section('content')
@include('admin.message')
<!-- breadcumb start -->
@php
$gets = App\Breadcum::first();
@endphp
 <!-- breadcrumb-area -->
@if(isset($gets))
@if($gets['img'] !== NULL && $gets['img'] !== '')
 <section class="breadcrumb-area d-flex align-items-center" style="background-image:url({{ url('/images/breadcum/'.$gets->img) }})";>
    @else
    <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="course" class="img-fluid">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-12 col-lg-12">
                <div class="breadcrumb-wrap text-left">
                    <div class="breadcrumb-title">
                        <h2>{{__('Services Deatils')}}</h2>    
                        <div class="breadcrumb-wrap">
                  
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('Services Deatils')}}</li>
                        </ol>
                    </nav>
                </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
@endif
@endif
<!-- breadcrumb-area-end -->
	<!-- service-details-area -->
@if(isset($services))
    <div class="about-area5 about-p p-relative">
        <div class="container pt-120 pb-90">
            <div class="row">
                 <!-- #right side -->
                <div class="col-sm-12 col-md-12 col-lg-4 order-1">
                   <aside class="sidebar services-sidebar">
                
                <!-- Category Widget -->
                <div class="sidebar-widget categories">
                    <div class="widget-content">
                        <h2 class="widget-title"> {{__('Services List')}}  </h2>
                        <!-- Services Category -->
                        <ul class="services-categories">
            @foreach($services as $ser)
                            <li><a href="single-courses.html">{{__('Poster Printing ')}}</a></li>
                            {{-- <li><a href="single-courses.html"> Poster Printing </a></li>
                            <li><a href="single-courses.html">Business Card </a></li>
                            <li><a href="single-courses.html">Billboard Printing </a></li>
                            <li><a href="single-courses.html"> T-Shirt Printing </a></li>
                            <li><a href="single-courses.html"> Flyer Printing </a></li> --}}
            @endforeach            

                        </ul>
                    </div>
                </div>
                <!--Service Contact-->
                <div class="service-detail-contact wow fadeup-animation" data-wow-delay="1.1s">
                    <h3 class="h3-title">{{__('If You Need Any Help Contact With Us')}}</h3>
                    <a href="javascript:void(0);" title="Call now">{{__('+91 705 2101 786')}}</a>
                </div>
                <div class="sidebar-widget brochures-box">
                    <div class="inner">
                        <h4 class="widget-title">{{__('Design Guideline')}}</h4>
                        <div class="text">{{__('Pleasure and praising pain was born and I will give you a complete account.')}}</div>
                           <div class="box mt-20">
                                <div class="icon">
                                    <i class="fal fa-file-pdf"></i>
                                </div>
                                <div class="content">
                                    <a href="#"><h4>{{__('Photoshop File')}}</h4></a>
                                </div>
                            </div>
                            <div class="box mt-20">
                                <div class="icon">
                                    <i class="fal fa-download"></i>
                                </div>
                                <div class="content">
                                    <a href="#"><h4>{{__('Illustrator File')}}</h4></a>
                                </div>
                            </div>
                            <div class="box mt-20">
                                <div class="icon">
                                    <i class="fal fa-file-image"></i>
                                </div>
                                <div class="content">
                                    <a href="#"><h4>{{__('Jpg file')}}</h4></a> 
                                </div>
                            </div>
                    </div>
                </div>
            </aside>
                </div>
                <!-- #right side end -->
               
                
            <div class="col-lg-8 col-md-12 col-sm-12 order-2">
                   <div class="service-detail">
              

                <div class="content-box">
                    <h2>{{__(' We give the best Services')}} </h2>
                    <p>{{__('Pleasure and praising pain was born and I will give you a complete account of the systems, and expound the actually teachings of the great explorer of the truth, the master-builder of human uts happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally Nor who loves or pursues or desires to obtain pain of itself.')}}</p>

                    <!-- Two Column -->
                    <div class="two-column">
                        <div class="row">
                             <div class="image-column col-xl-6 col-lg-12 col-md-12">
                                <figure class="image"><img src="{{url('frontcss/img/gallery/protfolio-img04.png')}}" alt="{{ __('Portfolia_img')}}"></figure>
                            </div>
                            <div class="text-column col-xl-6 col-lg-12 col-md-12">
                               <figure class="image"><img src="{{url('frontcss/img/gallery/protfolio-img06.png')}}" alt="{{ __('Portfolia_img')}}"></figure>
                            </div>
                           
                        </div>
                    </div>

                    <h3>{{__('Why Choose This Service')}}</h3>

                    <p>{{__('Complete account of the systems and expound the actually teachings of the great explorer of the truth, the master-builder of human uts happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely.')}}</p>
                     
                    <p>{{__('Complete account of the systems and expound the actually teachings of the great explorer of the truth, the master-builder of human uts happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally.')}}</p>
                    <h3> {{__('Working Process')}}</h3>
                   
                     <div class="row">
            @foreach($services as $ser)
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="services-box07 mb-30">
                        
                     <div class="sr-contner">
                        <div class="icon">
                    @if($serv['image'] == !NULL)
                        <img src="{{ asset('images/services/'.$serv['image']) }}" alt="icon01">
                    @else
                        <img src="{{ Avatar::create($serv->title)->toBase64() }}">
                    @endif    
                        </div>
                        <div class="text">
                            <h5>{{ $ser->title }}</h5>
                            <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($ser->detail))) , $limit = 80, $end = '...') }}</p>
                        </div>
                     </div>
                        
                        
                    </div>
                </div>
            @endforeach    
                {{-- <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="services-box07 mb-30">
                        <div class="sr-contner">
                        <div class="icon">
                        <img src="img/icon/sve-icon5.png" alt="icon01">
                        </div>
                        <div class="text">
                            <h5>Digital Printing</h5>
                            <p>Aenean eleifend turpis tellus, nec laoreet metus elementum ac.</p>
                        </div>
                     </div>
                       
                    </div>
                </div> --}}
                
            {{-- <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="services-box07 mb-30">
                        <div class="sr-contner">
                        <div class="icon">
                        <img src="img/icon/sve-icon6.png" alt="icon01">
                        </div>
                        <div class="text">
                            <h5>3D Printing</h5>
                            <p>Aenean eleifend turpis tellus, nec laoreet metus elementum ac.</p>
                        </div>
                     </div>
                        
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="services-box07 mb-30">
                        <div class="sr-contner">
                        <div class="icon">
                        <img src="img/icon/sve-icon7.png" alt="icon01">
                        </div>
                        <div class="text">
                            <h5>3D Printing</h5>
                            <p>Aenean eleifend turpis tellus, nec laoreet metus elementum ac.</p>
                        </div>
                     </div>
                        
                    </div>
                </div> --}}
             
            </div>
                    <h3>{{ $serv->title }}</h3>
                    <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($serv->detail))) , $limit = 300, $end = '...') }}</p>
                    
                      <!-- Two Column -->
                    <div class="two-column">
                        <div class="row">
                             <div class="image-column col-xl-12 col-lg-12 col-md-12">
                                <figure class="image"><img src="{{url('frontcss/img/gallery/protfolio-img02.png')}}" alt="{{ __('protfolio-img')}}"></figure>
                            </div>
                            
                           
                        </div>
                    </div>
                    
                   <p>Phasellus hac phasellus consequat malesuada veler aliquam dictumst amet a phasellus lacinia integer curabitur duis. Urna taciti nisl torquent varius libero dui. Tempus magnis libero pulvinar purus pharetra justo sem curae duis eget tempus erat ornare. Consequat litora a blandit fermentum. Quam taciti site nascetur nunc litora quis tempor metus adipiscing ac quis sodales ultrices cubilia. Arcu in penatibus vestibulum diam. Curabitur platea quam fusce molestie venenatis platea ligula in aenean gravida dolor aptent nostra luctus rutrum morbi porttitor cursus</p>
                </div>
            </div>
                </div>
             
            </div>
        </div>
    </div>
@endif
@endsection
    <!-- service-details-area-end -->
