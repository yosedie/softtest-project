<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('installer/css/shards.min.css') }}">
    <link rel="stylesheet" href="{{url('admin/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ url('installer/css/custom.css') }}">    
    <title>{{ __('-|| Updater ||-') }}</title>
</head>
<body>
    @include('admin.message')
    @include('sweetalert::alert')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="m-3 text-center text-dark ">
                    {{ __('Welcome To Update Wizard') }}
                </h3>
            </div>
            <div class="card-body" id="stepbox">
                <form autocomplete="off" action="{{ route('update.proccess') }}" id="updaterform" method="POST"
                    class="needs-validation" novalidate>
                    @csrf
                    <blockquote class="text-justify text-dark font-weight-normal">
                        <p class="font-weight-bold text-primary"><i class="fa fa-check-circle"></i> {{__('Before update make
                            sure you take your database backup and script backup from server so in case if anything goes
                            wrong you can restore it.')}}</p>
                        <hr>                        
                        <p>{{__('Before update make sure you read this')}} <b>{{__('FAQ.')}}</b></p>
                        <ul>
                            <li><b>{{__('Q.')}}</b> {{__('Will This Update affect my existing data eg. product data, orders?')}}
                                <br>
                                <b>{{__('Answer:')}}</b> {{__('No it will not affect your existing .')}}
                            </li>
                            <br>                            
                            <li><b>{{__('Q.')}}</b> {{__('Will This Update affect my customization eg. in ')}}<b>{{__('CSS,JS or in Core code')}}</b>
                                ?
                                <br>
                                <b>{{__('Answer:')}}</b> {{__('Yes it will affect your changes if you did changes in code files')}} <br> {{__('If you customize')}} <B>{{__('CSS or JS')}}</B> {{__('using')}} <b>{{__('Admin -> Custom Style Setting')}}</b> {{__('Than all your change will not affect else it will affect.')}}
                            </li>
                        </ul>
                    </blockquote>
                    <hr>

                     <h3>{{__('Domain Detail')}}</h3>
                  <hr/>
                  <div class="row">
                    <div class="eyeCy col-md-6 mb-3">
                      <label for="validationCustom02">{{ __('Domain Name:') }}</label>
                      <input name="domain" type="text" class="form-control @error('domain') is-invalid @enderror"  value="" required>
                     
                      <div class="valid-feedback">
                        {{ __('Looks good!') }}
                      </div>
                      @error('domain')
                      <div class="invalid-feedback">
                        {{$message}}
                      </div>                          
                       @enderror                         
                    </div> 
                    <div class="eyeCy col-md-6 mb-3">
                      <label for="validationCustom02">{{ __('Purchase Code:') }}</label>
                      <input name="code" type="password" class="form-control @error('code') is-invalid @enderror" id="validationCustom02" placeholder="{{ __('Please enter valid purchase code') }}" value="" required>
                      <span toggle="#validationCustom02" class="eye fa fa-fw fa-eye field-icon toggle-password"></span>
                      <div class="valid-feedback">
                        {{ __('Looks good!') }}
                      </div>
                        @if($errors->any())
                          <h6 class="text-danger alert alert-error">{{$errors->first()}}</h6>
                        @endif
                      @error('code')
                      <div class="invalid-feedback">
                        {{$message}}
                      </div> 
                      @enderror 
                        <small class="text-muted font-weight-bold">
                          <i class="fa fa-question-circle"></i> <a title="{{ __('Click to know') }}" class="text-muted" href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank">{{ __('Where Is My Purchase Code') }} ?</a>
                        </small>
                    </div>            
                  </div>
                    <div class="custom-control custom-checkbox">
                        <input required="" type="checkbox" class="custom-control-input" id="customCheck1" name="eula" />
                        <label class="custom-control-label"
                            for="customCheck1"><b>{{ __('I read the update procedure carefully and I take backup already.') }}</b> <b>{{__('I agree')}} <a href ="http://mediacity.co.in/privacy-policy" target="_blank">{{__('Privacy Policy')}}</a></b></label>
                    </div>
                    <small class="font-weight-normal text-center">
                        <a target="__blank"
                            href="https://codecanyon.net/item/eclass-learning-management-system/25613271">{{__('Read
                            complete changelog of update by clicking here.')}}</a>
                    </small>
                    <div class="row mt-4">
                      <div class="col-md-12">
                        <div class="alert alert-secondary">
                          <div class="scroll-down">
                            <p class="text-dark font-weight-bold">{{ __('Please read this agreement carefully before installing or using this product.') }}</p>
                            <p class="text-dark font-weight-normal">{{ __('If you agree to all of the terms of this End-User License Agreement, by checking the box or clicking the button to confirm your acceptance when you first install the web application, you are agreeing to all the terms of this agreement. Also, By downloading, installing, using, or copying this web application, you accept and agree to be bound by the terms of this End-User License Agreement, you are agreeing to all the terms of this agreement. If you do not agree to all of these terms, do not check the box or click the button and/or do not use, copy or install the web application, and uninstall the web application from all your server that you own or control.') }}</p>
                            
                            <b>{{ __('Note:') }}</b> 
                            <span class="text-dark font-weight-normal">
                            {{ __('With eClass - Learning Management System, We are using the official Payment API Paypal, Instamojo, Stripe, Razorpay, Paystack, Paytm, Skrill, Molli, Flutterwave, Cash Free, PayU, Omise which is available on Developer Center. That is a reason why our product depends on Payment API Paypal, Instamojo, Stripe, Razorpay, Paystack, Paytm, Skrill, Molli, Flutterwave, Cash Free, PayU, Omise, Skrill, Molli, Flutterwave, Cash Free, PayU, Omise. Therefore, We are not responsible if they made too many critical changes in their side. We also dont guarantee that the compatibility of the script with Payment API will be forever. Although we always try to update the lastest version of script as soon as possible. We dont provide any refund for all problems which are originated from Payments API Paypal, Instamojo, Stripe, Razorpay, Paystack, Paytm, Skrill, Molli, Flutterwave, Cash Free, PayU, Omise .') }}
                            </span> 
                            <br><br>
                            <div> 
                              <p class="mb-4"><b>{{ __('Purchase Data') }}</b> {{ __('To receive product support, you have to have one or more Envato purchase codes on our website. These purchase codes will be stored together with support expiration dates and your user data. This is required for us to provide you with downloads, product support and other customer services.') }}</p>
                            </div>
                            <div class="verify-content-list mb-4"> 
                              <p><b>{{ __('Cases for Using the Personal Data') }}</b></p>
                              <p><b>{{ __('We use your personal information in the following cases:') }}</b></p>
                              <ul>
                                <li>{{ __('Verification/identification of the user during website usage;') }}</li>
                                <li>{{ __('Providing Technical Assistance;') }}</li>
                                <li>{{ __('Sending updates to our users with important information to inform about news/changes;') }}</li>
                                <li>{{ __('Checking the accounts’ activity in order to prevent fraudulent transactions and ensure the security') }}</li>
                                <li>{{ __('over our customers’ personal information;') }}</li>
                                <li>{{ __('Customize the website to make your experience more personal and engaging;') }}</li>
                                <li>{{ __('Guarantee overall performance and administrative functions run smoothly.') }}</li>
                              </ul>
                            </div>
                            <div class="mb-4">
                              <h5 class="varified-content-title">{{ __('Embedded Content') }}</h5>
                              <p>{{ __('Pages on this site may include embedded content, like YouTube videos, for example. Embedded content from other websites behaves in the exact same way as if you visited the other website.') }}</p>
                              <p>{{ __('These websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with that embedded content, including tracking your interaction with the embedded content if you have an account and are logged-in to that website. Below you can find a list of the services we use:') }}</p>
                            </div>
                            <div class="mb-4">
                              <h5 class="varified-content-title">YouTube</h5>
                              <p>{{ __('We use YouTube videos embedded on our site. YouTube has its own cookie and privacy policies over which we have no control. There is no installation of cookies from YouTube and your IP is not sent to a YouTube server until you consent to it. See their privacy policy here:') }} <a href="" title="Youtube Privacy Policy">{{ __('YouTube Privacy Policy.') }}</a></p>
                            </div>
                            <div class="mb-4">
                              <h5 class="varified-content-title">{{ __('Consent Choice') }}</h5>
                              <p>{{ __('We provide you with the choice to accept this or not, we prompt consent boxes for all embedded content, and no data is transferred before you consented to it. The checkboxes below show you all embeds you have consented to so far. You can opt-out any time by un-checking them and clicking the update button.') }}</p>
                            </div>
                            <div class="mb-4">
                              <h5 class="varified-content-title">{{ __('How Long We Retain Your Data') }}</h5>
                              <p>{{ __('When you submit a support ticket or a comment, its metadata is retained until (if) you tell us to remove it. We use this data so that we can recognize you and approve your comments automatically instead of holding them for moderation.') }}</p>
                            </div>
                            <div class="mb-4">
                              <h5 class="varified-content-title">{{ __('Security Measures') }}</h5>
                              <p>{{ __('We use the SSL/HTTPS protocol throughout our site. This encrypts our user communications with the servers so that personal identifiable information is not captured/hijacked by third parties without authorization.') }}</p>
                              <p>{{ __('In case of a data breach, system administrators will immediately take all needed steps to ensure system integrity, will contact affected users and will attempt to reset passwords if needed.') }}</p>
                            </div>
                            <div class="mb-4">
                              <h5 class="varified-content-title">{{ __('Amendments') }}</h5>
                              <p>{{ __('We may amend this Privacy Policy from time to time. When we amend this Privacy Policy, we will update this page accordingly and require you to accept the amendments in order to be permitted to continue using our services.') }}</p>
                            </div>
                          </div>
                        </div>
                      </div>  
                    </div>
                    <hr>
                    <div class="d-flex justify-content-center">
                        <button class="updatebtn btn btn-primary" type="submit">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <p class="text-center m-3 text-white">&copy;{{ date('Y') }} | {{ __('eclass Updater') }} | <a class="text-white" href="http://mediacity.co.in">{{ __('Media City') }}</a></p>
    </div>
    <div class="corner-ribbon bottom-right sticky green shadow">{{ __('Updater') }} </div>
    <!-- Optional JavaScript -->
    <script src="{{ url('installer/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ url('installer/js/jquery.validate.min.js') }}"></script>
    <script src="{{ url('installer/js/additional-methods.min.js') }}"></script>
    <script src="{{ url('installer/js/ej.web.all.min.js') }}"></script>
    <script src="{{ url('installer/js/popper.min.js') }}"></script>
    <script src="{{ url('installer/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('installer/js/shards.min.js') }}"></script>
    <script>
        var baseUrl = "<?= url('/') ?>";
    </script>
    <script src="{{ url('js/minstaller.js') }}"></script>
    <script>
        $("#updaterform").on('submit', function () {
            if ($(this).valid()) {
                $('.updatebtn').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i><span class="sr-only">Loading...</span> Updating...');
            }
        });
    </script>
    <script>
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
</body>
</html>
