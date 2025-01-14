<head>
<meta charset="utf-8" />
<title>{{__('Network Error | ')}}{{ $gsetting->project_title }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="{{ $gsetting->meta_data_desc }}">
<meta name="keywords" content="{{ $gsetting->meta_data_keyword }}">
<meta name="author" content="Media City">
<meta name="MobileOptimized" content="320">
<link rel="icon" type="image/icon" href="{{ asset('images/favicon/'.$gsetting->favicon) }}"> <!-- favicon-icon -->
<!-- theme styles -->
<link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"> <!-- bootstrap css -->
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700" rel="stylesheet"><!--  google fonts -->
<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet"> <!-- google fonts -->
<link href="{{ url('vendor/fontawesome/css/all.css') }}"  rel="stylesheet"> <!--  fontawesome css -->
<link href="{{ url('vendor/font/flaticon.css') }}" rel="stylesheet"> <!--  fontawesome css -->
<link href="{{ url('vendor/navigation/menumaker.css') }}" rel="stylesheet"> <!-- navigation css -->
<link href="{{ url('vendor/owl/css/owl.carousel.min.css') }}" rel="stylesheet"> <!-- owl carousel css -->
<link href="{{ url('vendor/protip/protip.css') }}" rel="stylesheet"> <!-- menu css -->
<link href="{{ url('css/style.css') }}" rel="stylesheet" type="text/css"> <!-- custom css -->
<link href="{{ URL::asset('css/pace.min.css') }}" rel="stylesheet">
<link href="{{ url('css/protip.css') }}" rel="stylesheet" type="text/css"> <!-- protip css -->
<!-- end theme styles -->
</head>
<body>
<!-- error page -->
<section id="error" class="error-page-main-block">
    <div class="container-xl">
        <div class="error-block text-center"> 
            <h1>{{__('You are currently not connected to any networks.')}}</h1>
            <div class="nav-bar-btn btm-20">
                <a href="{{ url('/') }}" class="btn btn-secondary" title="home"><i class="fa fa-chevron-left"></i>{{__('Back to Home')}}</a>
            </div>
        </div>
    </div>
</section>
<!-- error page end -->
<script src="{{ url('js/jquery-2.min.js') }}"></script> <!-- jquery library js -->
<script src="{{ url('js/colorbox.js') }}"></script>
<script src="{{ url('js/bootstrap.bundle.js') }}"></script> <!-- bootstrap js -->
<script src="{{ url('vendor/counter/waypoints.min.js') }}"></script> <!-- facts count js required for jquery.counterup.js file -->
<script src="{{ url('vendor/counter/jquery.counterup.js') }}"></script> <!-- facts count js-->
<script src="{{ url('vendor/owl/js/owl.carousel.min.js') }}"></script> <!-- owl carousel js -->	
<script src="{{ url('vendor/smoothscroll/smooth-scroll.js') }}"></script> <!-- smooth scroll js -->
<script src="{{ url('vendor/popup/jquery.magnific-popup.min.js')}}"></script> <!-- popup js-->
<script src="{{ url('vendor/navigation/menumaker.js') }}"></script> <!-- navigation js--> 
<script src="{{ url('vendor/mailchimp/jquery.ajaxchimp.js') }}"></script> <!-- mail chimp js --> 
<script src="{{ url('vendor/protip/protip.js') }}"></script> <!-- protip js -->
<script src="{{ url('js/theme.js') }}"></script> <!-- custom js -->
<script src="{{ url('js/FWDUVPlayer.js') }}"></script> <!-- player js --> 
<script src="{{ url('js/jquery.owl-filter.js') }}"></script> <!-- filter js --> 
<script src="{{ url('js/fontawesome-iconpicker.js')}}"></script><!-- iconpicker js -->
<script src="{{ url('js/tinymce.min.js')}}"></script>
<script src="{{ url('js/protip.js') }}"></script> <!-- protip js -->
<script src="{{ URL::asset('js/pace.min.js') }}"></script>
</body>
