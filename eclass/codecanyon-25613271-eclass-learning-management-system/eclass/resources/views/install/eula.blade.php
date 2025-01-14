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
    <title>{{ __('Installing App - Terms and Condition') }}</title>
   
  </head>
  <body>
    @include('admin.message')
   	  
      <div class="preL display-none">
        <div class="preloader3 display-none"></div>
      </div>

   		<div class="container">
   			<div class="card">
          <div class="card-header">
              <h3 class="m-3 text-center text-dark ">
                  {{__('Installing eClass - Learning Management System')}}
              </h3>
          </div>
   				<div class="card-body" id="stepbox">
               <form action="{{ route('store.eula') }}" id="step1form" method="POST" class="needs-validation" novalidate>
                  @csrf
                  <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom01">{{__('Envato User Name')}}:</label>
                      <input name="user_id" type="text" class="form-control" id="validationCustom01" placeholder="Username" value="" required>
                      <div class="valid-feedback">
                       {{__(' Looks good!')}}
                      </div>
                      <div class="invalid-feedback">
                          {{__('Please fill name.')}}
                      </div>
                    </div>
                    <div class="eyeCy col-md-4 mb-3">
                      <label for="validationCustom02">{{__('Purchase Code')}}:</label>
                      <input name="code" type="password" class="form-control" id="validationCustom02" placeholder="Please enter valid purchase code" value="" autocomplete="off" required>
                      <span toggle="#validationCustom02" class="eye fa fa-fw fa-eye field-icon toggle-password"></span>
                      <div class="valid-feedback">
                        {{__('Looks good!')}}
                      </div>
                      <div class="invalid-feedback">
                      </div>                          
                        @if($errors->any())
                          <h6 class="text-danger alert alert-error">{{$errors->first()}}</h6>
                        @endif
                    </div>
                    <div class="col-md-4 mb-3">
                      <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank">{{__('Where Is My Purchase Code ??')}}</a>
                    </div>
                  </div>
                  <h3>{{ __('Terms & Conditions') }}</h3>
                  <hr>
                  <div class="form-row">
                    <br>
                    <div class="col-md-12">
                      <p class="text-dark font-weight-bold">{{ __('Please read this agreement carefully before installing or using this product.') }}</p>
                      <p class="text-dark font-weight-normal">{{ __('If you agree to all of the terms of this End-User License Agreement, by checking the box or clicking the button to confirm your acceptance when you first install the web application, you are agreeing to all the terms of this agreement. Also, By downloading, installing, using, or copying this web application, you accept and agree to be bound by the terms of this End-User License Agreement, you are agreeing to all the terms of this agreement. If you do not agree to all of these terms, do not check the box or click the button and/or do not use, copy or install the web application, and uninstall the web application from all your server that you own or control.') }}</p>
                      
                      <b>{{ __('Note:') }}</b> <span class="text-dark font-weight-normal">
                        {{ __('With eClass - Learning Management System, We are using the official Payment API Paypal, Instamojo, Stripe, Razorpay, Paystack, Paytm, Skrill, Molli, Flutterwave, Cash Free, PayU, Omise) which is available on Developer Center. That is a reason why our product depends on Payment API(Paypal, Instamojo, Stripe, Razorpay, Paystack, Paytm, Skrill, Molli, Flutterwave, Cash Free, PayU, Omise, Skrill, Molli, Flutterwave, Cash Free, PayU, Omise). Therefore, We are not responsible if they made too many critical changes in their side. We also dont guarantee that the compatibility of the script with Payment API will be forever. Although we always try to update the lastest version of script as soon as possible. We dont provide any refund for all problems which are originated from Payments API (Paypal, Instamojo, Stripe, Razorpay, Paystack, Paytm, Skrill, Molli, Flutterwave, Cash Free, PayU, Omise.') }}
                      </span> 
                      <br><br>
                      <hr>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-8">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="eula"/>
                        <label class="custom-control-label" for="customCheck1"><b>{{ __('I read the terms and condition carefully and I agree on it.') }}</b></label>
                        <label class="custom-control-label"
                            for="customCheck1"><b>{{ __('I read the update procedure carefully and I take backup already.') }}</b> <b>{{__('I agree')}} <a href ="http://mediacity.co.in/privacy-policy" target="_blank">{{__('Privacy Policy')}}</a></b></label>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <button class="float-right step1btn btn btn-primary" type="submit">{{ __('Continue to Installation...') }}</button>
                    </div>
                  </div>
              </form>
   				</div>
   			</div>
        <p class="text-center m-3 text-white">&copy;{{ date('Y') }} | {{ __('eClass - Learning Management System | Installer v1.1 |') }} <a class="text-white" href="http://mediacity.co.in">Media City</a></p>
   		</div>
      
    <div class="corner-ribbon bottom-right sticky green shadow">{{ __('EULA') }} </div>
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
        })(jQuery);
    </script>
</body>
</html>