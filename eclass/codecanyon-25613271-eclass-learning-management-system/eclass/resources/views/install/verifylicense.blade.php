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
    <title>{{ __('Installing App - Step  - Verify Purchase') }}</title>
    
  </head>
  <body>
      
      <div class="preL display-none">
        <div class="preloader3 display-none"></div>
      </div>

      <div class="container">
        <div class="card">
          <div class="card-header">
              <h3 class="m-3 text-center text-dark ">
                 {{ __(' Verify Your Purchase') }}
              </h3>
          </div> 
          <div class="card-body" id="stepbox">                    
          @if($errors->any())
            <h6 class="alert alert-error">{{$errors->first()}}</h6>
          @endif
            <h5>{{ __('Please purchase a valid license or verify your purchase code with author.') }}</h5>
          </div>
        </div>
        <p class="text-center m-3 text-white">&copy;{{ date('Y') }} | {{ __('eClass - Learning Management System | Installer v1.1') }} | <a class="text-white" href="http://mediacity.co.in">Media City</a></p>
      </div>
      
      <div class="corner-ribbon bottom-right sticky green shadow"> </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ url('installer/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ url('installer/js/jquery.validate.min.js') }}"></script>
    <script src="{{ url('installer/js/additional-methods.min.js') }}"></script>
    <script src="{{ url('installer/js/ej.web.all.min.js') }}"></script>
    <script src="{{ url('installer/js/popper.min.js') }}"></script>
    <script src="{{ url('installer/js/bootstrap.min.js') }}"></script>

    <script src="{{ url('installer/js/shards.min.js') }}"></script>
    
</body>
</html>