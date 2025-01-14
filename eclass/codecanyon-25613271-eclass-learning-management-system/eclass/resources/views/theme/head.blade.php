@if(env('GOOGLE_TAG_MANAGER_ENABLED') == 'true' && env('GOOGLE_TAG_MANAGER_ID') == !NULL)
@include('googletagmanager::head')
@endif
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="csrf-token" content="{{csrf_token()}}">
<title>@yield('title') | {{ $gsetting->project_title ?? '' }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="author" content="Media City" />
<meta name="MobileOptimized" content="320" />
@yield('meta_tags')
@if(isset($gsetting))
<link rel="icon" type="image/icon" href="{{ url('images/favicon/'.$gsetting->favicon) }}"> <!-- favicon-icon -->
@endif
<!-- theme styles -->
<link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> <!-- bootstrap css -->
<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Poppins:300,400,500,700" rel="stylesheet"> <!--  google fonts -->
<link href="https://fonts.googleapis.com/css?family=Muli&display=swap:400,500,600,700" rel="stylesheet"><!-- google fonts -->
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet"><!-- google fonts -->
<link rel="stylesheet" href="{{ url('vendor/fontawesome/css/all.css') }}" /> <!--  fontawesome css -->
<link rel="stylesheet" href="{{ url('vendor/font/flaticon.css') }}" /> <!-- flaticon css -->
<link rel="stylesheet" href="{{ url('vendor/navigation/menumaker.css') }}" /> <!-- navigation css -->
<link rel="stylesheet" href="{{ url('vendor/owl/css/owl.carousel.min.css') }}" /> <!-- owl carousel css -->
<link rel="stylesheet" href="{{ url('vendor/protip/protip.css') }}" /> <!-- menu css -->
<meta name="keywords" content="{{ $gsetting->meta_data_keyword }}">
<?php
$language = Session::get('changed_language'); //or 'english' //set the system language
$rtl = array('ar','he','ur', 'arc', 'az', 'dv', 'ku', 'fa'); //make a list of RTL languages
?>
@if (in_array($language,$rtl))
<link href="{{ url('css/rtl.css') }}" rel="stylesheet" type="text/css"/> <!-- RTL css -->
@else
<link href="{{ url('css/style.css') }}" rel="stylesheet" type="text/css"/> <!-- custom css -->
@endif
<link rel="stylesheet" href="{{ url('css/colorbox.css') }}">
<link rel="stylesheet" href="{{url('css/bower_components/font-awesome/css/font-awesome.min.css')}}"><!-- fontawesome css -->
<link rel="stylesheet" href="{{ url('css/select2.min.css') }}"> <!-- select2 css -->
<link rel="stylesheet" href="{{ URL::asset('css/pace.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('css/protip.css') }}" /> <!-- protip css -->
<link rel="stylesheet" href="{{ asset('css/custom-style.css') }}"/><!-- custom style css -->
<link rel="stylesheet" href="{{ asset('css/venom-button.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/videoplayer.css') }}" />
<link rel="stylesheet" href="{{url('css/simple_line_icons/css/simple-line-icons.css')}}">  <!-- line icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- PWA -->
@if(env('PWA_ENABLE') == 1)
  @laravelPWA
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
<meta name="google-site-verification" content="{{ $gsetting->google_search_console }}">
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
</script>
<noscript>
  <img style="display:none" src="https://www.facebook.com/tr?id={{ $gsetting->fb_pixel }}&ev=PageView&noscript=1"/>
</noscript>
@endif
@if(isset($gsetting->google_ana))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $gsetting->google_ana }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '{{ $gsetting->google_ana }}');
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
  --linear-gradient-bg-color:linear-gradient(-45deg, #FF7350 0, #6E1A52 100%);
  --linear-gradient-reverse-bg-color:linear-gradient(-45deg, #6E1A52 0,#FF7350 100%);
  --linear-gradient-about-bg-color:linear-gradient(197.61deg,#FF7350,#6E1A52);
  --linear-gradient-about-blue-bg-color:linear-gradient(40deg,#1A263A 33%,#4A8394 84%);
  --linear-gradient-career-bg-color:linear-gradient(22.72914987deg,#F5C252 4%,#6AC1D0);
  --background-blue-bg-color: #125875;
  --background-red-bg-color:#FF7350; 
  --background-grey-bg-color:#EFF7FF;
  --background-light-grey-bg-color:#F9F9F9;
  --background-black-bg-color:#29303B;
  --background-white-bg-color:#FFF;
  --background-mehroon-bg-color:#992337;
  --text-black-color:#29303B;
  --text-light-grey-color:#777;
  --text-red-color:#FF7350;
  --text-dark-grey-color:#686F7A; 
  --text-blue-color:#125875;
  --text-dark-blue-color:#003845;
  --text-white-color:#FFF;
}
</style>
@endif


@yield('custom-head')