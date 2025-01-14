<!DOCTYPE html>

<?php
$language = Session::get('changed_language'); //or 'english' //set the system language
$rtl = array('ar','he','ur', 'arc', 'az', 'dv', 'ku', 'fa'); //make a list of rtl languages
?>

<html class="no-js" lang="en" @if (in_array($language,$rtl)) dir="rtl" @endif>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
 
  
  <title>@yield('title') | {{ $gsetting->project_title }}</title>
  <!-- Tell the browser to be to screen width -->

 
    <meta name="description" content="{{ $gsetting->meta_data_desc }}">
    <meta name="keywords" content="{{ $gsetting->meta_data_keyword }}">
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gsetting->google_ana }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '{{ $gsetting->google_ana }}');
    </script>
    <!-- Facebook Pixel Code -->

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

    @endif

    <script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>
    <noscript>
      <img style="display:none" src="https://www.facebook.com/tr?id={{ $gsetting->fb_pixel }}&ev=PageView&noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->
 

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{url('admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}"> <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ url('css/datepicker.css') }}">
  <link rel="icon" type="image/icon" href="{{ asset('images/favicon/'.$gsetting->favicon) }}"> <!-- favicon-icon -->
  <link rel="stylesheet" href="{{ url('admin/css/select2.min.css') }}"> <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('admin/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{ url('css/fontawesome-iconpicker.min.css') }}">
  <link rel="stylesheet" href="{{url('admin/css/jquery-ui.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{url('admin/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{url('admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}"> <!-- Theme style -->
  <link rel="stylesheet" href="{{url('admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <link rel="stylesheet" href="{{url('admin/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
  <?php
  $language = Session::get('changed_language'); //or 'english' //set the system language
  $rtl = array('ar','he','ur', 'arc', 'az', 'dv', 'ku', 'fa'); //make a list of rtl languages
  ?>
  @if (in_array($language,$rtl))
  <link rel="stylesheet" href="{{url('admin/dist/css/AdminLTE-rtl.min.css')}}">  <!-- adminLTE RTL  style -->
  @else
  <link rel="stylesheet" href="{{url('admin/dist/css/AdminLTE.min.css')}}">
  @endif
  
  <link rel="stylesheet" href="{{url('css/toggle.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('css/component.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('css/normalize.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('admin/plugins/pace/pace.min.css') }}">
  <link rel="stylesheet" href="{{url('admin/dist/css/skins/_all-skins.min.css')}}">
  <link href="{{url('admin/css/bootstrap-toggle.min.css')}}">
  <link rel="stylesheet" href="{{ url('css/animate.min.css') }}"><!-- Custom Css -->
  @if (in_array($language,$rtl))
  <link rel="stylesheet" href="{{ url('admin/css/admin-rtl.css') }}">
  @else
  <link rel="stylesheet" href="{{ url('admin/css/admin.css') }}">
  @endif
  <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="{{ url('admin/font/font/flaticon.css') }}" /> <!-- fontawesome css -->

  

  @yield('stylesheets')
  
</head>

<body class="hold-transition skin-blue sidebar-mini fixed">
  <div class="wrapper">
    @include('sweetalert::alert')

    <header class="main-header">
      <!-- Logo -->
      <a href="{{ url('/') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">
        <img title="{{ $gsetting->project_title }}" width="20px" src="{{ url('images/favicon/'.$gsetting->favicon) }}" alt="{{ $gsetting->project_title }}"/>
      </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"> <img title="{{ $gsetting->project_title }}" width="100px" src="{{ url('images/logo/'.$gsetting->logo) }}" alt="{{ $gsetting->project_title }}"/></span>
    </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">{{__('Toggle navigation')}}</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">

            <!-- Notifications: style can be found in dropdown.less -->
            @if(Auth()->user()->role == "admin")
            <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label bg-red">{{ Auth()->user()->unreadNotifications->where('type', 'App\Notifications\AdminOrder')->count() }}</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">{{__('You have')}} {{ Auth()->user()->unreadNotifications->where('type', 'App\Notifications\AdminOrder')->count() }} {{__('notifications')}}</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                    @foreach(Auth()->user()->unreadNotifications->where('type', 'App\Notifications\AdminOrder') as $notification)
                    <li>

                     
                      <a href="#">
                        <i class="fa fa-users text-aqua"></i> {{ $notification->data['data'] }}
                      </a>
                    </li>
                    @endforeach
                  
                  </ul>
                </li>
                <li class="footer"><a href="{{route('deleteNotification')}}">{{__('Clear all')}}</a></li>
              </ul>
            </li>
            @endif
          <!-- Tasks: style can be found in dropdown.less -->
            <!-- Messages: style can be found in dropdown.less-->
            @php
                $languages = App\Language::all(); 
            @endphp
            <li class="dropdown admin-nav language">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-globe"></i> {{Session::has('changed_language') ? Session::get('changed_language') : ''}}</button>

              <ul class="dropdown-menu animated flipInX">
                @if (isset($languages) && count($languages) > 0)
                  @foreach ($languages as $language)
                    <li><a href="{{ route('languageSwitch', $language->local) }}">{{$language->name}} ({{$language->local}}) </a></li>
                  @endforeach
                @endif
              </ul>
              
            </li>
            <!-- User Account: style can be found in dropdown.less -->
            <li><a href="{{ url('/') }}" target="_blank" class="visit site" >{{ __('VisitSite') }}</a></li>


            

            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                @if(Auth()->User()['user_img'] != null && Auth()->User()['user_img'] !='' && @file_get_contents('images/user_img/'.Auth::user()['user_img']))
                  <img src="{{ asset('images/user_img/'.Auth()->User()['user_img'])}}" class="user-image" alt="{{Auth::user()['fname']}}">
                @else
                  <img src="{{ asset('images/default/user.jpg')}}" class="user-image" alt="{{Auth::user()['fname']}}">
                @endif
                <span class="hidden-xs">Hi ! {{ Auth()->User()['fname'] }}</span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                   @if(Auth()->User()['user_img'] != null && Auth()->User()['user_img'] !='' && @file_get_contents('images/user_img/'.Auth()->user()['user_img']))
                    <img src="{{ asset('images/user_img/'.Auth()->User()['user_img'])}}" class="img-circle" alt="User Image">
                  @else
                    <img src="{{ asset('images/default/user.jpg')}}" class="img-circle" alt="{{ __('user')}}">
                  @endif
                  </br>
                  <p>
                   {{Auth()->User()['fname']}}
                    <small>{{ __('MemberSince') }}: {{ date('jS F Y',strtotime( Auth()->User()['created_at']))}}</small>
                  </p>
                  
                </li>

                <li class="user-footer">
                  <div class="pull-left">
                    <a href="{{ url('user/edit/'.Auth()->User()->id)}}" class="btn btn-default btn-flat">{{ __('Profile') }}</a>
                  </div>
                  <div class="pull-right">

                    <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                     document.getElementById('logout-form-1').submit();">
                    {{ __('Logout') }}
                    </a>

                    <form id="logout-form-1" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                  </div>
                </li>
              </ul>

            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
                 <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                     document.getElementById('logout-form-2').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form-2" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    @if(Auth::User()->role == "admin")
      @include('admin.layouts.sidebar')
    @endif
    @if(Auth::User()->role == "instructor")
      @include('instructor.layouts.sidebar')
    @endif
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      @yield('body')
      <!-- Main content end-->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        {{ $gsetting->project_title }} @if(Auth()->user()->role == "admin") (version {{ env('APP_VERSION') }}) @endif
      </div>
     {{ $gsetting->cpy_txt }} 
    </footer>
    <!-- /.control-sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <!-- jQuery 3 -->
  <script src="{{url('admin/bower_components/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{ url('admin/js/select2.min.js')}}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{url('admin/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script> <!-- DataTables -->
  <script src="{{url('admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{url('admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script> <!-- SlimScroll -->
  <script src="{{url('admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script> <!-- FastClick -->
  <script src="{{url('admin/bower_components/fastclick/lib/fastclick.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{url('admin/dist/js/adminlte.min.js')}}"></script> <!-- AdminLTE for demo purposes -->
  <script src="{{url('admin/dist/js/demo.js')}}"></script>
  <script src="{{ URL::asset('admin/bower_components/PACE/pace.min.js') }}"></script> 
  <!-- PACE -->
  <script src="{{ URL::asset('admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script> <!-- bootstrap datepicker -->
  <script src="{{url('admin/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
  <script src="{{ url('admin/js/jquery-ui.js')}}"></script>
  <script src="{{ url('js/custom-toggle.js') }}"></script>
  <script src="{{ url('js/custom-file-input.js')}}"></script>
  <script src="{{ url('js/fontawesome-iconpicker.js')}}"></script>
  <script src="{{ url('admin/js/courseclass.js')}}"></script>
   
  <script src="{{ url('admin/js/tinymce.min.js')}}"></script>
  <script src="{{ url('admin/bower_components/moment/moment.js') }}"></script>
  <script src="{{ url('js/datepicker.js') }}"></script>
  <script src="{{ url('js/custom-js.js')}}"></script>

  <script src="{{ url('admin/js/dataTables.buttons.min.js')}}"></script> 
  <script src="{{ url('admin/js/buttons.flash.min.js')}}"></script> 
  <script src="{{ url('admin/js/jszip.min.js')}}"></script>
  <script src="{{ url('admin/js/pdfmake.min.js')}}"></script>
  <script src="{{ url('admin/js/vfs_fonts.js')}}"></script>
  <script src="{{ url('admin/js/buttons.html5.min.js')}}"></script>
  <script src="{{ url('admin/js/buttons.print.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

  <script src="{{ url('js/subscription-pricing.js') }}"></script>



<script>var youtubekey = @json(env('YOUTUBE_API_KEY'));</script>
@if($gsetting->youtube_enable == 1)
<script src="{{ url('js/youtube.js') }}"></script>
@endif

<script>var vimeokey = @json(env('VIMEO_ACCESS'));</script>

@if($gsetting->vimeo_enable == 1)
<script src="{{ url('js/vimeo.js') }}"></script>

@endif

  
  <!-- page script -->
  <script>
    $(function () {
      $('#example1').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : true
      })
    }) 
  </script>

  <script>
    $(document).ready(function() {
      $('#example2').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ],
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : true
      });
    });
  </script>

  
<?php
$language = Session::get('changed_language'); //or 'english' //set the system language
$rtl = array('ar','he','ur', 'arc', 'az', 'dv', 'ku', 'fa'); //make a list of rtl languages
?>

  @if (in_array($language,$rtl))
    <script type="text/javascript">
      
      tinymce.init({   
        selector: 'textarea#detail, textarea#detail2, textarea#detail3',    
        rtl_ui:true,
        directionality :"rtl",
        height: 250,
        menubar: 'edit view insert format tools table tc',
        autosave_ask_before_unload: true,
        autosave_interval: "30s",
        autosave_prefix: "{path}{query}-{id}-",
        autosave_restore_when_empty: false,
        autosave_retention: "2m",
        image_advtab: true,
        image_dimensions: false,
        image_class_list: [
            {title: 'Responsive', value: 'img-fluid'}
        ],
        plugins: [
          'advlist autolink lists link image charmap print preview anchor',
          'searchreplace visualblocks fullscreen',
          'insertdatetime media table paste wordcount',
          'textcolor',
        ],
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media  template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
        content_css: '//www.tiny.cloud/css/codepen.min.css'  
          });
    </script>

  @else

    <script type="text/javascript">
      
      tinymce.init({   
        selector: 'textarea#detail, textarea#detail2, textarea#detail3', 
        height: 250,
        menubar: 'edit view insert format tools table tc',
        autosave_ask_before_unload: true,
        autosave_interval: "30s",
        autosave_prefix: "{path}{query}-{id}-",
        autosave_restore_when_empty: false,
        autosave_retention: "2m",
        image_advtab: true,
        image_dimensions: false,
        image_class_list: [
            {title: 'Responsive', value: 'img-fluid'}
        ],
        plugins: [
          'advlist autolink lists link image charmap print preview anchor',
          'searchreplace visualblocks fullscreen',
          'insertdatetime media table paste wordcount',
          'textcolor',
        ],
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media  template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
        content_css: '//www.tiny.cloud/css/codepen.min.css'  
          });
    </script>
  @endif

  
 
  

  <script>
    window.setTimeout(function(){
      $(".alert").fadeTo(300,0).slideUp(500, function(){
        $(this).remove();
      });
    },2000);
  </script>

  <script>
 
    $(function () {
      
      $('.action-destroy').on('click', function () {
        $.iconpicker.batch('.icp.iconpicker-element', 'destroy');
      });

      $(document).on('click', '.action-placement', function (e) {
        $('.action-placement').removeClass('active');
        $(this).addClass('active');
        $('.icp-opts').data('iconpicker').updatePlacement($(this).text());
        e.preventDefault();
        return false;
      });

    });

  </script>
  
  <script>
    $('#datepicker').datepicker({
      autoclose: true,
      changeYear: true,
    })
  </script>




  <script>
    $(function(){
      $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
          localStorage.setItem('activeTab', $(e.target).attr('href'));
      });
      var activeTab = localStorage.getItem('activeTab');
      if(activeTab){
          $('#nav-tab a[href="' + activeTab + '"]').tab('show');
      }
    });
  </script>

  <script>
    $(function() {
        $('form').attr('autocomplete','off');
    });
  </script>

  <script>
    $(function() {
      $('.js-example-basic-single').select2(
        {
          tags: true,
          tokenSeparators: [',', ' ']
        });
    });
  </script>

  <script >
    
      $(".toggle-password").on('click', function() {
          $(this).toggleClass("fa-eye fa-eye-slash");
          var input = $($(this).attr("toggle"));
          if(input.attr("type") == "password") {
            input.attr("type", "text");
          } else {
            input.attr("type", "password");
          }
      });
  </script>

  @if($gsetting->rightclick=='1')
    <script>
      (function($) {
        "use strict";
          $(function() {
            $(document).on("contextmenu",function(e) {
               return false;
            });
        });
      })(jQuery);
    </script>
  @endif
  @if($gsetting->inspect=='1')
    <script>
      (function($) {
      "use strict";
           document.onkeydown = function(e) {
          if(event.keyCode == 123) {
             return false;
          }
          if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
             return false;
          }
          if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
             return false;
          }
          if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
             return false;
          }
          if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
             return false;
          }
        }
      })(jQuery);
    </script>
  @endif

@yield('scripts')
@yield('script')

</body>
</html>
