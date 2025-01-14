@if(env('GOOGLE_TAG_MANAGER_ENABLED') == 'true' && env('GOOGLE_TAG_MANAGER_ID') == !NULL)
@include('googletagmanager::head')
@endif
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
{{-- <meta name="csrf-token" content="{{csrf_token()}}"> --}}

<title>@yield('title') | {{ $gsetting->project_title ?? '' }}</title>
<meta name="description" content="Media City">
<meta name="viewport" content="width=device-width, initial-scale=1">

@yield('meta_tags')
@if(isset($gsetting))
<link rel="shortcut icon" type="image/x-icon" href="{{url('frontcss/img/favicon.ico'.$gsetting->favicon)}}">
@endif
<!-- theme styles -->


<?php
$language = Session::get('changed_language');
$rtl = array('ar','he','ur', 'arc', 'az', 'dv', 'ku', 'fa');
?>


<!-- CSS here -->
@if (in_array($language,$rtl))
<link rel="stylesheet" href="{{url('frontcss/css/bootstrap.rtl.min.css')}}">
@else
<link rel="stylesheet" href="{{url('frontcss/css/bootstrap.min.css')}}">
@endif
<link rel="stylesheet" href="{{url('frontcss/css/animate.min.css')}}">
<link rel="stylesheet" href="{{url('frontcss/css/magnific-popup.css')}}">
<link rel="stylesheet" href="{{url('frontcss/fontawesome/css/all.min.css')}}">
<link rel="stylesheet" href="{{url('admin_assets/assets/icons/font-awesome/css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{url('frontcss/css/dripicons.css')}}">
<link rel="stylesheet" href="{{url('frontcss/css/slick.css')}}">
<link rel="stylesheet" href="{{url('frontcss/css/meanmenu.css')}}">
<link rel="stylesheet" href="{{ asset('css/venom-button.min.css') }}" />
<link rel="stylesheet" href="{{url('frontcss/css/default.css')}}">
<link rel="stylesheet" href="{{url('frontcss/css/colorbox.css')}}">
<link rel="stylesheet" href="{{ url('vendor/protip/protip.css') }}" /> <!-- menu css -->
@if (in_array($language,$rtl))
<link rel="stylesheet" href="{{url('frontcss/css/style_rtl.css')}}">
@else
<link rel="stylesheet" href="{{url('frontcss/css/style.css')}}">
@endif
@if (in_array($language,$rtl))
<link rel="stylesheet" href="{{url('frontcss/css/responsive_rtl.css')}}">
@else
<link rel="stylesheet" href="{{url('frontcss/css/responsive.css')}}">
@endif
<link rel="stylesheet" href="{{url('css/simple_line_icons/css/simple-line-icons.css')}}">

@if(env('PWA_ENABLE') == 1)
  @laravelPWA
@endif
<meta name="google-site-verification" content="{{ $gsetting->google_search_console }}">
<meta name="keywords" content="{{ $gsetting->meta_data_keyword }}">
@if(isset($gsetting->google_ana))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $gsetting->google_ana }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '{{ $gsetting->google_ana }}');
</script>
@endif
@php
  if(Schema::hasTable('player_settings')){
  $colors = App\PlayerSetting::first();
}
@endphp
@if(isset($color))
<style type="text/css">

:root {
  --subtitle_color:  {{ $colors['subtitle_color'] }};
}
</style>
@endif

<!-- end theme styles -->
@php
if(Schema::hasTable('color_options')){
  $color = App\ColorOption::first();
}
@endphp
@if(isset($gsetting->fb_pixel))
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '{{ $gsetting->fb_pixel }}');
  fbq('track', 'PageView');
  <noscript>
  <img style="display:none" src="https://www.facebook.com/tr?id={{ $gsetting->fb_pixel }}&ev=PageView&noscript=1"/>
  </noscript>
</script>
@endif
@if(isset($color))

<style type="text/css">
  
  :root {
  --linear-gradient-bg-color:linear-gradient(-45deg, {{ $color['linear_bg_one'] }} 0, {{ $color['linear_bg_two'] }} 100%);
  --linear-gradient-reverse-bg-color:linear-gradient(-45deg, {{ $color['linear_reverse_bg_one'] }} 0, {{ $color['linear_reverse_bg_two'] }} 100%);
  --linear-gradient-about-bg-color:linear-gradient(197.61deg, {{ $color['linear_about_bg_one'] }} , {{ $color['linear_about_bg_two'] }});
  --linear-gradient-about-blue-bg-color:linear-gradient(40deg, {{ $color['linear_about_bluebg_one'] }} 33%, {{ $color['linear_about_bluebg_two'] }} 84%);
  --linear-gradient-career-bg-color:linear-gradient(22.72914987deg, {{ $color['linear_career_bg_one'] }} 4%, {{ $color['linear_career_bg_two'] }});
  --background-blue-bg-color: {{ $color['blue_bg'] }};
  --background-red-bg-color: {{ $color['red_bg'] }}; 
  --background-grey-bg-color:{{ $color['grey_bg'] }};
  --background-light-grey-bg-color:{{ $color['light_grey_bg'] }};
  --background-black-bg-color:{{ $color['black_bg'] }};
  --background-white-bg-color:{{ $color['white_bg'] }};
  --background-mehroon-bg-color:{{ $color['dark_red_bg'] }};
  --text-black-color:{{ $color['black_text'] }};
  --text-light-grey-color:{{ $color['light_grey_text'] }};
  --text-dark-grey-color:{{ $color['dark_grey_text'] }};
  --text-red-color:{{ $color['red_text'] }};
  --text-blue-color:{{ $color['blue_text'] }};
  --text-dark-blue-color:{{ $color['dark_blue_text'] }};
  --text-white-color:{{ $color['white_text'] }};
}
</style>

@else

<style type="text/css">
 :root {

  --linear-gradient-bg-color:linear-gradient(-45deg, #F44A4A 0, #6E1A52 100%);
  --linear-gradient-reverse-bg-color:linear-gradient(-45deg, #6E1A52 0,#F44A4A 100%);
  --linear-gradient-about-bg-color:linear-gradient(197.61deg,#F44A4A,#6E1A52);
  --linear-gradient-about-blue-bg-color:linear-gradient(40deg,#1A263A 33%,#4A8394 84%);
  --linear-gradient-career-bg-color:linear-gradient(22.72914987deg,#F5C252 4%,#6AC1D0);
  --background-blue-bg-color: #0284A2;
  --background-red-bg-color:#F44A4A; 
  --background-grey-bg-color:#F7F8FA;
  --background-light-grey-bg-color:#F9F9F9;
  --background-black-bg-color:#29303B;
  --background-white-bg-color:#FFF;
  --background-mehroon-bg-color:#992337;
  --text-black-color:#29303B;
  --text-light-grey-color:#777;
  --text-red-color:#F44A4A;
  --text-dark-grey-color:#686F7A; 
  --text-blue-color:#0284A2;
  --text-dark-blue-color:#003845;
  --text-white-color:#FFF;
}

</style>
@endif
@yield('custom-head')