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
    <title>{{ __('Installing App - Step 3 - Basic Settings') }}</title>
    
  </head>
  <body>
   	  
      <div class="preL display-none">
        <div class="preloader3 display-none"></div>
      </div>

   		<div class="container">
   			<div class="card">
          <div class="card-header">
              <h3 class="m-3 text-center text-dark ">
                 {{ __(' Welcome To Setup Wizard - Basic Site Setting') }}
              </h3>
          </div>
   				<div class="card-body" id="stepbox">
               <form autocomplete="off" enctype="multipart/form-data" action="{{ route('store.step3') }}" id="step3form" method="POST" class="needs-validation" novalidate>
                  @csrf
                   <h3>Site Setting</h3>
                   <hr>
                  <div class="form-row">
                   
                    <br>
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom01">{{ __('Project Title:') }}</label>
                      <input name="project_name" type="text" class="form-control" id="validationCustom01" placeholder="Project_Name" value="" required>
                      <div class="valid-feedback">
                       {{ __(' Looks good!') }}
                      </div>
                      <div class="invalid-feedback">
                          {{ __('Please enter project title.') }}
                      </div>
                    </div>
                   
              
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom02">{{ __('Default Email:') }}</label>
                      <input name="email" type="text" class="form-control" id="validationCustom02" placeholder="user@example.com" value="" required>
                      <div class="valid-feedback">
                        {{ __('Looks good!') }}
                      </div>
                      <div class="invalid-feedback">
                        {{ __('Please enter email.') }}
                      </div>
                     

                    </div>
                   
                  </div>
                  <hr>
               
                  
                <button class="float-right step1btn btn btn-primary" type="submit">{{ __('Continue to Step 4...') }}</button>
              </form>
   				</div>
   			</div>
        <p class="text-center m-3 text-white">&copy;{{ date('Y') }} |{{ __(' eClass - Learning Management System | Installer v1.1 ') }}| <a class="text-white" href="http://mediacity.co.in">Media City</a></p>
   		</div>
      
    <div class="corner-ribbon bottom-right sticky green shadow">Step 3 </div>
    <!-- Optional JavaScript -->
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

      function readURL2(input) {

        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function(e) {
            $('#fav-prev').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
        }
      }

      $("#favicon").change(function() {
        readURL2(this);
      });

    </script>


</body>
</html>