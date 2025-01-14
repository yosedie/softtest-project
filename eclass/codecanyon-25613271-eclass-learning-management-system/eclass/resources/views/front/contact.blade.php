@extends('theme.master')
@section('title', 'Contact Us')
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
        <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="course" class="img-fluid">
        @endif
    </div>
    <div class="overlay-bg"></div>
    <div class="container-xl">
        <div class="business-dtl">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bredcrumb-dtl">
                        <h1 class="wishlist-home-heading">{{ __('Contact us') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- about-home end -->
<!-- contact-us start-->
<section id="contact-us" class="contact-us-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-7 col-md-6">
                @if(isset($gsetting['map_url']))
                <section id="#" class="map-location btm-30">
                    <iframe src="{{ $gsetting['map_url'] }}" width="100%" height="450px"></iframe>
                </section>
                @endif
            </div>
            <div class="col-lg-5 col-md-6">
                <h4 class="contact-us-heading">{{ __('Keep in Touch') }}</h4>
                <form id="demo-form2" method="post" action="{{ route('contact.user') }}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @if(Auth::check())
                    <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
                     @endif
                     <div class="form-group">
                        <input type="text" class="form-control" name="fname" id="fname" placeholder="{{ __('Name')}}">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="{{ __('Phone')}}">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="{{ __('E-mail')}}">
                    </div>
                    @php
                     $data =  App\Contactreason::where('status', '1')->get();
                    @endphp
                    <div class="form-group">
                        <select class="form-control" id="exampleFormControlSelect1" name="reason">
                            @foreach ($data as $coun)
                            <option value="{{ $coun->reason }}"
                              {{ $coun->reason == $coun->id ? 'selected' : ''}}>
                              {{ $coun->reason }}
                            </option>
                            @endforeach
                        </select>
                      </div>
                    <div class="comment btm-20">
                        <textarea id="comment" name="message" rows="6" placeholder="{{ __('Your Message')}}"></textarea>
                    </div>

                    @if($gsetting->captcha_enable == 1)
                    <div class="{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">

                            {!! app('captcha')->display() !!}
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                            @endif
                        </div>
                        <br>
                    @endif

                    
                    <div class="contact-form-btn">
                        <button type="submit" class="btn btn-primary" title="Send Message">{{ __('Message') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="contact-dtl">
            <div class="row">
                <div class="offset-lg-1 col-lg-3 col-md-4">
                    <ul>
                        <li class="btm-10"><i class="fa fa-map-marker"></i></li>
                        <li class="btm-10 caps">{{ __('address') }}</li>
                        <li class="btm-40">{{ $gsetting->default_address }}</li>
                    </ul>
                </div>
                <div class="offset-lg-1 col-lg-3 col-md-4">
                    <ul>
                        <li class="btm-10"><i class="fa fa-envelope"></i></li>
                        <li class="btm-10 caps">{{ __('Email') }} </li>
                        <li class="btm-40">{{ $gsetting->wel_email }}</li>
                    </ul>
                </div>
                <div class="offset-lg-1 col-lg-3 col-md-4">
                    <ul>
                        <li class="btm-10"><i class="fa fa-phone"></i></li>
                        <li class="btm-10 caps">{{ __('Phone') }}</li>
                        <li class="btm-40">{{ $gsetting->default_phone }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact us end -->

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