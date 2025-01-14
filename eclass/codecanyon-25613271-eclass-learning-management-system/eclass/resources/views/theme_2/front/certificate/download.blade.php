<!DOCTYPE html>
<!--
**********************************************************************************************************
    Copyright (c) 2019.
**********************************************************************************************************  -->
<!-- 
Template Name: eClass
Author: Media City
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]> -->
<?php
$language = Session::get('changed_language'); //or 'english' //set the system language
$rtl = array('ar','he','ur', 'arc', 'az', 'dv', 'ku', 'fa'); //make a list of rtl languages
?>

<html lang="en" @if (in_array($language,$rtl)) dir="rtl" @endif>
<!-- <![endif]-->
<!-- head -->
<!-- theme styles -->




@php
if(Schema::hasTable('color_options')){
  $color = App\ColorOption::first();
}
@endphp
@if(isset($color))

<style type="text/css">
  
  .cirtificate-border-one { 
     
    border: 15px groove {{ $color['blue_bg'] }}; 
    padding:20px;
    background-color: var(--background-white-bg-color);

  }
  .cirtificate-border-two {  
    border: 5px double {{ $color['blue_bg'] }};
    padding:20px;
  }
</style>

@else

<style type="text/css">
 .cirtificate-border-one { 
    
    border: 15px groove #0284A2;
    padding:20px;
    background-color: var(--background-white-bg-color);

  }
  .cirtificate-border-two {  
    border: 5px double #0284A2;
    padding:20px;
  }

</style>

@endif

<style type="text/css">

  * { font-family: DejaVu Sans, sans-serif; }

  .course-cirtificate {
    text-align: center;
  }

 .cirtificate-heading {
    font-size:50px; 
    font-weight:bold;
    font-style: normal;
    margin-bottom: 20px;
  }
  
  @font-face {
    font-family: 'Great Vibes';
    src: url('{{ public_path('GreatVibes-Regular.ttf') }}') format("ttf");
  }

  .course-cirtificate {
    padding: 10px 0;
    background: #F7F8FA;
  }
  .cirtificate-heading {
    color: #29303B;
  }

  .cirtificate-serial {
    text-align: left!important;
    font-size: 8px;
  }

  

  

</style>


</head>


<!-- end head -->
<!-- body start-->
<body>
<!-- terms end-->
<!-- about-home start -->
<section id="cirtificate" class="course-cirtificate">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-12">
                <div class="cirtificate-border-one text-center">
                    <div class="cirtificate-border-two">
                       <div class="cirtificate-heading" style="">{{ __('Certificate of Completion') }}</div>
                        @php
                            $mytime = Carbon\Carbon::now();
                        @endphp
                       <p class="cirtificate-detail" style="font-size:30px">{{ __('This is to certify that') }} <b>&nbsp;{{ $progress->user['fname'] }}&nbsp;{{ $progress->user['lname'] }}</b> {{ __('successfully completed') }} <b>{{ $course['title'] }}</b> {{ __('online course on') }} <br>
                       
                        <span style="font-size:25px">{{ date('jS F Y', strtotime($progress['updated_at'])) }}</span>
                       
                      </p>

                       <span class="cirtificate-instructor">{{ ($course->user['fname']) }} {{ ($course->user['lname']) }}</span>
                       <br>
                       <span class="cirtificate-one">{{ ($course->user['fname']) }} {{ ($course->user['lname']) }}, {{ __('Instructor') }}</span>
                       <br>
                       <span>&</span>
                       <div class="cirtificate-logo">
                        @if($gsetting['logo_type'] == 'L')
                            <img src="{{ asset('images/logo/'.$gsetting['logo']) }}" class="img-fluid" alt="{{ __('logo')}}" style="width: 150px">
                        @else
                            <a href="{{ url('/') }}"><b><div class="logotext">{{ $gsetting['project_title'] }}</div></b></a>
                        @endif
                      </div>
                      <br>
                      <br>

                      <div class="cirtificate-serial">{{ __('Certificate no.')}} :{{ $serial_no }}</div>
                      <div class="cirtificate-serial">{{ __('Certificate url.')}} :{{ url()->full() }}</div>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- footer start -->

<!-- footer end -->
<!-- jquery -->
<script src="{{ url('js/jquery-2.min.js') }}"></script> <!-- jquery library js -->
<script src="{{ url('js/bootstrap.bundle.js') }}"></script> <!-- bootstrap js -->
<!-- end jquery -->
</body>
<!-- body end -->
</html> 





