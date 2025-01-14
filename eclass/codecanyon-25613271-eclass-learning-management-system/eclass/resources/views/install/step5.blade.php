<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url('installer/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('installer/css/shards.min.css') }}">
    <link rel="stylesheet" href="{{ url('installer/css/custom.css') }}">
    <link rel="stylesheet" href="{{ url('installer/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ url('installer/css/bootstrap-toggle.min.css') }}">
    <title>{{ __('Installing App - Step 5 - Store Creation') }}</title>

    <style type="text/css">
     
      .btn-default {
        color: #0284A2;
    background-color: #FFF;
    border-color: #0284A2 !important;
      }
    </style>
    
  </head>
  <body>
   	  
    <div class="preL display-none">
      <div class="preloader3 display-none"></div>
    </div>

 		<div class="container">
 			<div class="card">
        <div class="card-header">
            <h3 class="m-3 text-center text-dark ">
               {{ __(' Welcome To Setup Wizard - Custom Setting') }}
            </h3>
        </div>
 				<div class="card-body" id="stepbox">
          <form autocomplete="off" enctype="multipart/form-data" action="{{ route('store.step5') }}" id="step5form" method="POST" class="database-validation" novalidate>
            @csrf
            <h3>{{ __('Custom Settings') }}</h3>
            <hr>
            <div class="form-row">
              <br>
             
              <div class="col-md-6 mb-3">
                <label for="">{{ __('Right Click: ') }}</label>
                <br>          
                <input name="rightclick"  id="toggle-one" checked type="checkbox">
              </div>

              <div class="col-md-6 mb-3">
                <label for="">{{ __('Inspect Element: ') }}</label>
                <br>
                <input name="inspect"  id="toggle-two" checked type="checkbox">
              </div>

              <div class="col-md-6 mb-3">
                <label for="">{{ __('Become An Instructor: ') }}</label>
                <br>          
                <input name="instructor_enable"  id="toggle-three" checked type="checkbox">
              </div>

              <div class="col-md-6 mb-3">
                <label for="">{{ __('Welcome Email:') }} </label>
                <br>
                <input name="wel_email"  id="toggle-four" checked type="checkbox">
              </div>

              <div class="col-md-6 mb-3">
                <label for="">{{ __('Import Demo Database: ') }}</label>
                <br>
                <input name="import_demo"  id="toggle-five" type="checkbox">
              </div>

              <div class="col-md-6 mb-3">
                <label for="">{{ __('Remove public from URL: ') }}</label>
                <br>
                <input name="remove_public"  id="toggle-six" type="checkbox">
                <div>
                  <small>⦿ {{__(('Removing public from URL is only works when you have installed script in main domain.'))}}</small>
                  <br>

                  <small>⦿ {{__("Do not remove public when you have Installed script in subdomin or subfolders.")}}</small>
                </div>
              </div>

           
              
              
            </div>

            <button class="float-right step1btn btn btn-primary" type="submit">{{ __('Finish...') }}</button>

          </form>
 				</div>
 			</div>
      <p class="text-center m-3 text-white">&copy;{{ date('Y') }} | {{ __('eClass - Learning Management System | Installer v1.1 ') }}| <a class="text-white" href="http://mediacity.co.in">Media City</a></p>
 		</div>
      
    <div class="corner-ribbon bottom-right sticky green shadow">{{ __('Final Phase') }} </div>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ url('installer/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ url('installer/js/jquery.validate.min.js') }}"></script>
    <script src="{{ url('installer/js/additional-methods.min.js') }}"></script>
    <script src="{{ url('installer/js/ej.web.all.min.js') }}"></script>
    <script src="{{ url('installer/js/popper.min.js') }}"></script>
    <script src="{{ url('installer/js/bootstrap.min.js') }}"></script>

    <script src="{{ url('installer/js/shards.min.js') }}"></script>
    <script src="{{ url('installer/js/select2.min.js') }}"></script>
    <script src="{{ url('installer/js/bootstrap-toggle.min.js') }}"></script>

  @yield('script-zone')

  <script>

    (function() {
        'use strict';
        window.addEventListener('load', function() {
          var forms = document.getElementsByClassName('database-validation');
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();

      (function() {
        'use strict';

        $(function() 
        { 
          $("form").submit(function () {
              if($(this).valid()){
                $('.preL').fadeIn('fast');
                $('.preloader3').fadeIn('fast');
                $('.container').css({ '-webkit-filter':'blur(5px)'});
                $('body').attr('scroll','no');
                $('body').css('overflow','hidden');
              }
              
          });
        
      });
 
      $(function() {
        $('#toggle-one').bootstrapToggle();
        $('#toggle-two').bootstrapToggle();
        $('#toggle-three').bootstrapToggle();
        $('#toggle-four').bootstrapToggle();
        $('#toggle-five').bootstrapToggle();
        $('#toggle-six').bootstrapToggle();
      })

   })(jQuery);
</script>

</body>
</html>