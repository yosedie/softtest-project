@extends('theme2.master')
@section('title', 'Contact us')
@section('content')
@include('admin.message')
<!-- about-home start -->
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
                              <h2>{{ __('Contact Us') }}</h2>  
                          </div>
                      </div>
                  </div>
                  <div class="breadcrumb-wrap2">
                        
                          <nav aria-label="breadcrumb">
                              <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                                  <li class="breadcrumb-item active" aria-current="page">{{__('Contact Us')}}</li>
                              </ol>
                          </nav>
                      </div>
                  
              </div>
          </div>
</section>
<!-- breadcrumb-area-end -->
@if(isset($gets))
<main>
<section id="services" class="services-area pt-120 pb-90 fix">
    <div class="container">
       <div class="row">
             <div class="col-lg-12">
                <div class="section-title text-center mb-50 wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                    <h5><i class="fal fa-graduation-cap"></i>{{ __('Keep in Touch') }}</h5>
                    <h2>
                    {{__('Get In Touch')}}
                    </h2>
                 
                </div>
               
            </div>
        </div>
        <div class="row">
             <div class="col-lg-4 col-md-4">
                 
              <div class="services-box text-center">
                  <div class="services-icon">
                       <img src="{{url('frontcss/img/bg/contact-icon01.png')}}" alt="image">
                    </div>
                   <div class="services-content2">
                        <h5><a href="tel:{{ $gsetting->default_phone }}" title="{{ $gsetting->default_phone }}">{{ $gsetting->default_phone }}</a></h5>   
                        <p>{{('Phone Support')}}</p>
                    </div>
                </div>   
                 
             
            </div>
            <div class="col-lg-4 col-md-4">
                 
              <div class="services-box text-center active">
                  <div class="services-icon">
                      <img src="{{url('frontcss/img/bg/contact-icon02.png')}}" alt="image">
                    </div>
                   <div class="services-content2">
                        <h5>{{ $gsetting->wel_email }}</h5>   
                         <p>{{('Email Address')}}</p>
                         
                    </div>
                </div>   
                 
             
            </div>
            <div class="col-lg-4 col-md-4">
                 
              <div class="services-box text-center">
                  <div class="services-icon">
                     <img src="{{url('frontcss/img/bg/contact-icon03.png')}}" alt="image">
                    </div>
                   <div class="services-content2">
                        <h5>{{ $gsetting->default_address }}</h5>   
                        <p>{{('Office Address')}}</p>
                    </div>
                </div>   
                 
             
            </div>
            
        </div>
    </div>
</section>
@endif
<!-- about-home end -->

 <!-- map-area-end -->
 <div class="map fix" style="background: #f5f5f5;">
    <div class="container-flud">
        
        <div class="row">
            <div class="col-lg-12">
                <iframe src="{{ $gsetting['map_url'] }}" width="100%" height="450px"></iframe>
            </div>
        </div>
    </div>
</div>
 <!-- map-area-end -->
  <!-- contact-area -->
  <section id="contact" class="contact-area after-none contact-bg pt-120 pb-120 p-relative fix" style="background: #e7f0f8;">
                
    <div class="container">
 
        <div class="row">
            
             
            <div class="col-lg-12 order-2">
                <div class="contact-bg">
                <div class="section-title center-align text-center mb-50">
                    <h2>
                       {{('Customer Inqure Form')}}
                    </h2>
                   
                </div>
                
                 
            <form  id="demo-form2" action="{{ route('contact.user') }}" method="post" class="contact-form mt-30 text-center" enctype="multipart/form-data">

                {{ csrf_field() }}


                @if(Auth::check())

                <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />

                @endif
                <div class="row">
                <div class="col-lg-4">
                    <div class="contact-field p-relative c-name mb-30">                                    
                        <input type="text" class="form-control" name="fname" id="fname" placeholder="{{ __('Name')}}">

                        <i class="icon fal fa-user"></i>
                    </div>                               
                </div>
                <div class="col-lg-4">                               
                    <div class="contact-field p-relative c-subject mb-30">                                   
                        <input type="email" class="form-control" name="email" id="email" placeholder="{{ __('E-mail')}}">
                        
                        <i class="icon fal fa-envelope"></i>
                    </div>
                </div>		
                <div class="col-lg-4">                               
                    <div class="contact-field p-relative c-subject mb-30">                                   
                        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="{{ __('Phone')}}">

                         <i class="icon fal fa-phone"></i>
                    </div>
                </div>	                            
                <div class="col-lg-12">
                    <div class="contact-field p-relative c-message mb-30">                                  
                        <textarea id="comment" name="message" rows="6" placeholder="{{ __('Your Message')}}"></textarea>
                        @php
                        $data =  App\Contactreason::where('status', '1')->get();
                       @endphp
                         <i class="icon fal fa-edit"></i>
                    </div>
                    <div class="slider-btn  text-center">                                          
                                <button class="btn ss-btn" data-animation="fadeInRight" data-delay=".8s" type="submit">{{__('Make An Request')}} <i class="fal fa-long-arrow-right"></i></button>				
                            </div>                             
                </div>
                </div>
            
        </form>
                
                </div>
            
            </div>
        </div>
        
    </div>
   
  </section>
 <!-- contact-area-end -->   
</main>
  <!-- main-area-end -->

@endsection

@section('custom-script')

<script>
    
jQuery(function($) {
    // Asynchronously Load the map API 
    var script = document.createElement('script');
    script.src = "https://maps.googleapis.com/maps/api/js?key={{ $gsetting['map_api'] }}&libraries=places&callback=initialize";
    
    document.body.appendChild(script);
  });
  function initialize(){
    var myLatLng = {lat: {{ $gsetting['map_lat'] }}, lng: {{ $gsetting['map_long'] }}}; // Insert Your Latitude and Longitude For Footer Wiget Map
    var mapOptions = {
      center: myLatLng, 
      zoom: 15,
      disableDefaultUI: true,
      scrollwheel: false,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      styles: [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]     
    }
    // For Footer Widget Map
    var map = new google.maps.Map(document.getElementById("location"), mapOptions);
    var image = 'images/icons/map.png';
    var beachMarker = new google.maps.Marker({
      position: myLatLng, 
      map: map,   
      icon: image
    });    
  }
</script>
<!-- end jquery -->

@endsection