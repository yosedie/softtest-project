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
    <link rel="stylesheet" href="{{url('css/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <title>{{ __('Installing App - Step 1 - Basic Details') }}</title>
    
  </head>
  <body>
      <div class="preL display-none">
        <div class="preloader3 display-none"></div>
      </div>

   		<div class="container">
   			<div class="card">
          <div class="card-header">
              <h3 class="m-3 text-center text-dark ">
             {{ __('Welcome To Setup Wizard') }}
              </h3>
          </div>
   				<div class="card-body" id="stepbox">
               <form autocomplete="off" action="{{ route('store.step1') }}" id="step1form" method="POST" class="needs-validation" novalidate>
                  @csrf
                   <h3>{{ __('Basic Details') }}</h3>
                   <hr>
                  <div class="form-row">
                   
                    <br>
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom01">{{ __('App/Project Name:') }}</label>
                      <input name="APP_NAME" type="text" class="form-control" id="validationCustom01" placeholder="Project_Name |" value="{{ env('APP_NAME') }}" required>
                      <div class="valid-feedback">
                       {{ __(' Looks good!') }}
                      </div>
                      <div class="invalid-feedback">
                          {{ __('Please choose a app name.') }}
                      </div>
                    </div>
                    
                     <div class="col-md-6 mb-3">
                      <label for="validationCustom01">{{ __('App URL:') }}</label>
                      <input name="APP_URL" type="url" class="form-control" id="validationCustom01" placeholder="http://" value="{{ env('APP_URL') }}" required>
                      <div class="valid-feedback">
                        {{ __('Looks good!') }}
                      </div>
                      <div class="invalid-feedback">
                       {{ __('Please enter app url.') }}
                      </div>
                    </div>
                    
                  </div>
                  <h3>{{ __('Mail Details') }}</h3>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom03">{{ __('Mail Sender Name:') }}</label>
                      <input name="MAIL_FROM_NAME" type="text" class="form-control" id="validationCustom03" placeholder="Example_Name" required value="{{ env('MAIL_FROM_NAME') }}">
                      <div class="invalid-feedback">
                       {{ __(' Please enter sender name.') }}
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom04">{{__('Mail Address: ') }}{{__('ex. info@example.com') }}</label>
                      <input type="text" name="MAIL_FROM_ADDRESS" class="form-control" id="validationCustom04" placeholder="eg: info@example.com" required value="{{ env('MAIL_FROM_ADDRESS') }}">
                      <div class="invalid-feedback">
                        Please enter mail address.
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom05">{{ __('Mail Username:') }}{{ __(' ex.info@example.com') }}</label>
                      <input name="MAIL_USERNAME" type="text" class="form-control" id="validationCustom05" placeholder="{{ __('eg: info@example.com') }}" required value="{{ env('MAIL_USERNAME') }}">
                      <div class="invalid-feedback">
                       {{ __(' Please enter mail username.') }}
                      </div>
                      <div class="valid-feedback">
                       {{ __('Looks good!') }}
                      </div>
                    </div>

                     <div class="eyeCy col-md-6 mb-3">
                      <label for="validationCustom05">{{ __('Mail Password:') }}</label>
                      <input name="MAIL_PASSWORD" type="password" placeholder="*******" class="form-control" id="validationCustom06" required value="{{ env('MAIL_PASSWORD') }}">

                      <span toggle="#validationCustom06" class="eye fa fa-fw fa-eye field-icon toggle-password"></span>
                      <div class="invalid-feedback">
                       {{ __('Please enter mail password.') }}
                      </div>
                      <div class="valid-feedback">
                       {{ __('Looks good!') }}
                      </div>
                    </div>

                    <div class="col-md-6 mb-3">
                      <label for="validationCustom05">{{ __('Mail Host: ex. mail.example.com') }}</label>
                      <input name="MAIL_HOST" type="text" placeholder="mail.example.com" class="form-control" id="validationCustom07" required value="{{ env('MAIL_HOST') }}">
                      <div class="invalid-feedback">
                        Please enter mail host.
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>

                    <div class="eyeCy col-md-6 mb-3">
                      <label for="validationCustom05">{{ __('Mail Port: ex. 587/2525/465') }}</label>
                      <input name="MAIL_PORT" type="password" placeholder="587" class="form-control" id="validationCustom08" required value="{{ env('MAIL_PORT') }}">

                      <span toggle="#validationCustom08" class="eye fa fa-fw fa-eye field-icon toggle-password"></span>
                      <div class="invalid-feedback">
                        {{ __('Please enter mail port.') }}
                      </div>
                      <div class="valid-feedback">
                       {{ __(' Looks good!') }}
                      </div>
                    </div>

                    <div class="col-md-6 mb-3">
                      <label for="validationCustom05">{{ __('Mail Driver: ex. smtp/sendmail') }}</label>
                      <input name="MAIL_DRIVER" type="text" placeholder="smtp" class="form-control" id="validationCustom09" required value="{{ env('MAIL_DRIVER') }}">
                      <div class="invalid-feedback">
                        {{ __('Please enter mail driver.') }}
                      </div>
                      <div class="valid-feedback">
                        {{ __('Looks good!') }}
                      </div>
                    </div>

                    <div class="col-md-6 mb-3">
                      <label for="validationCustom05">{{ __('Mail Encryption: ex. SSL/TLS') }}</label>
                      <input name="MAIL_ENCRYPTION" type="text" placeholder="TLS" class="form-control" id="validationCustom10" value="{{ env('MAIL_ENCRYPTION') }}">

                      
                      <div class="invalid-feedback">
                        {{ __('Please enter mail encryption.') }}
                      </div>
                      <div class="valid-feedback">
                       {{ __(' Looks good!') }}
                      </div>
                    </div>

                  </div>
                  
                <button class="float-right step1btn btn btn-primary" type="submit">{{ __('Continue to Step 2...') }}</button>
              </form>
   				</div>
   			</div>
        <p class="text-center m-3 text-white">&copy;{{ date('Y') }} {{ __('| eClass - Learning Management System | Installer v1.1 |') }} <a class="text-white" href="http://mediacity.co.in">{{ __('Mediacity') }}</a></p>
   		</div>
      
      <div class="corner-ribbon bottom-right sticky green shadow">{{ __('Step 1') }} </div>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ url('installer/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ url('installer/js/jquery.validate.min.js') }}"></script>
    <script src="{{ url('installer/js/additional-methods.min.js') }}"></script>
    <script src="{{ url('installer/js/ej.web.all.min.js') }}"></script>
    <script src="{{ url('installer/js/popper.min.js') }}"></script>
    <script src="{{ url('installer/js/bootstrap.min.js') }}"></script>

    <script src="{{ url('installer/js/shards.min.js') }}"></script>
    @yield('script-zone')
    <script>
      (function() {
        'use strict';
        window.addEventListener('load', function() {
          var forms = document.getElementsByClassName('needs-validation');
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

  <script>
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
      })();
  </script>

</body>
</html>