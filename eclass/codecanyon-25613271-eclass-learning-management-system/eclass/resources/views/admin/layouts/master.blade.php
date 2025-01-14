<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $gsetting->meta_data_desc }}">
    <meta name="keywords" content="{{ $gsetting->meta_data_keyword }}">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    @if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
    @endif
    <!-- <title>@yield('title') | {{ __('Admin') }}</title> -->
    <title>@yield('title')</title>
    @include('admin.layouts.head')
</head>
<body class="vertical-layout" > 
<div id="containerbar">
    @if(Auth::User()->role == "admin")
    @if($gsetting->sidebar_enable == 1)
    @include('admin.layouts.new_sidebar')
    @else
    @include('admin.layouts.sidebar')
    @endif
    @endif
    @if(Auth::User()->role == "instructor")
    @if($gsetting->instructor_sidebar == 1)
    @include('admin.layouts.instructor_sidebar')
    @else
    @include('instructor.layouts.sidebar')
    @endif
    @endif
    <div class="rightbar">
    
    @yield('maincontent')
    <!-- Start Footerbar -->
    <div class="footerbar">
        <footer class="footer">
          {{ $gsetting->project_title }}
            <p class="mb-0">© {{ $gsetting->cpy_txt }} {{ get_release() }}</p>
        </footer>
    </div>
<!-- End Footerbar -->
</div>
</div>
 @include('admin.layouts.scripts')
 @yield('script')
</body>
</html>