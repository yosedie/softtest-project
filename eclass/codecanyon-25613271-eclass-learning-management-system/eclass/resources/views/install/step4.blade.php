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
    <link rel="stylesheet" href="{{url('css/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <title>{{ __('Installing App - Step 4 - Creating Admin') }}</title>
    </head>
  <body>
   	  
      <div class="preL display-none">
        <div class="preloader3 display-none"></div>
      </div>

   		<div class="container">
   			<div class="card">
          <div class="card-header">
              <h3 class="m-3 text-center text-dark ">
                 {{ __(' Welcome To Setup Wizard - Create Admin') }}
              </h3>
          </div>
   				<div class="card-body" id="stepbox">
               <form autocomplete="off" enctype="multipart/form-data" action="{{ route('store.step4') }}" id="step4form" method="POST" class="needs-validation" novalidate>
                  @csrf
                   <h3>{{ __('Create Admin') }}</h3>
                   <hr>
                  <div class="form-row">
                   
                    <br>
                    <div class="col-md-6 mb-3">
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label for="validationCustom01">{{ __('Please First Name:') }}</label>
                          <input name="fname" type="text" class="form-control" id="validationCustom01" placeholder="Enter First Name" value="" required>
                          <div class="valid-feedback">
                         {{ __('Looks good!') }}
                          </div>
                          <div class="invalid-feedback">
                              {{ __('Please enter name.') }}
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label for="validationCustom01">{{ __('Please Last Name:') }}</label>
                          <input name="lname" type="text" class="form-control" id="validationCustom01" placeholder="Enter Last Name" value="" required>
                          <div class="valid-feedback">
                           {{ __(' Looks good!') }}
                          </div>
                          <div class="invalid-feedback">
                             {{ __(' Please enter name.') }}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom01">{{ __('Email:') }}</label>
                      <input name="email" type="email" class="form-control" id="validationCustom01" placeholder="user@example.com" value="" required>
                       <div class="invalid-feedback">
                          {{ __('Please enter email') }}.
                      </div>
                    </div>

                    <div class="eyeCy col-md-6 mb-3">
                       <label>{{ __('Password:') }}</label>
                       <input type="password" class="form-control" placeholder="*****" required id="validationCustom04" name="password">
                       <span toggle="#validationCustom04" class="eye fa fa-fw fa-eye field-icon toggle-password"></span>
                       <div class="invalid-feedback">
                          {{ __('Please choose password.') }}
                      </div>
                    </div>

                    <div class="eyeCy col-md-6 mb-3">
                       <label>{{ __('Confirm Password:') }}</label>
                       <input type="password" class="form-control" placeholder="*****" required id="validationCustom05" name="password_confirmation">
                       <span toggle="#validationCustom05" class="eye fa fa-fw fa-eye field-icon toggle-password"></span>
                       <div class="invalid-feedback">
                         {{ __(' Please confirm password.') }}
                      </div>
                    </div>
                  </div>
                   <hr>
                   <button class="float-right step1btn btn btn-primary" type="submit">{{ __('Continue to Step 5...') }}</button>
              </form>
   				</div>
   			</div>
        <p class="text-center m-3 text-white">&copy;{{ date('Y') }} | {{ __('eClass - Learning Management System | Installer v1.1 ') }}| <a class="text-white" href="http://mediacity.co.in">Media City</a></p>
   		</div>
      
      <div class="corner-ribbon bottom-right sticky green shadow">{{ __('Step 4 ') }}</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ url('installer/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ url('installer/js/jquery.validate.min.js') }}"></script>
    <script src="{{ url('installer/js/additional-methods.min.js') }}"></script>
    <script src="{{ url('installer/js/ej.web.all.min.js') }}"></script>
    <script src="{{ url('installer/js/popper.min.js') }}"></script>
    <script src="{{ url('installer/js/bootstrap.min.js') }}"></script>

    <script src="{{ url('installer/js/shards.min.js') }}"></script>
    <script src="{{ url('installer/js/select2.min.js') }}"></script>

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
    

      (function() {
        'use strict';
        $(document).ready(function() {
          $('.js-example-basic-single').select2();
        });

      })();

   
      function readURL1(input) {

        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function(e) {
            $('#logo-prev').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
        }
      }

      $("#logo").change(function() {
        readURL1(this);
      });

   
      (function() {
        'use strict';

      $(function() {
        var urlLike = '{{ url('allcountry/dropdown') }}';
        $('#country_id').change(function() {
          var up = $('#upload_id').empty();
          var cat_id = $(this).val();    
          if(cat_id){
            $.ajax({
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type:"GET",
              url: urlLike,
              data: {catId: cat_id},
              success:function(data){   
                console.log(data);
                up.append('<option value="0">Please Choose</option>');
                $.each(data, function(id, title) {
                  up.append($('<option>', {value:id, text:title}));
                });
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
              }
            });
          }
        });
      });
    

      $(function() {
        var urlLike = '{{ url('allcountry/gcity') }}';
        $('#upload_id').change(function() {
          var up = $('#grand').empty();
          var cat_id = $(this).val();    
          if(cat_id){
            $.ajax({
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type:"GET",
              url: urlLike,
              data: {catId: cat_id},
              success:function(data){   
                console.log(data);
                up.append('<option value="0">Please Choose</option>');
                $.each(data, function(id, title) {
                  up.append($('<option>', {value:id, text:title}));
                });
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
              }
            });
          }
        });
      });

      })(jQuery);
    </script>

</body>
</html>