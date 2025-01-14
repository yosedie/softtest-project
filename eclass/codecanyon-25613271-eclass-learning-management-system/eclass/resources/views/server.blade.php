<!doctype html>
<html lang="en">
  <head>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
    <link href="{{ url('installer/css/bootstrap.min.css') }}" rel="stylesheet"><!-- Bootstrap CSS -->
    <link href="{{ url('installer/css/shards.min.css') }}" rel="stylesheet">
    <link href="{{ url('installer/css/custom.css') }}" rel="stylesheet">
    <link href="{{url('css/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <title>{{__('Installing App - Server Requirement')}}</title>    
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
                  {{__('Server Requirement')}}
              </h3>
          </div>
   				<div class="card-body" id="stepbox">
               <form autocomplete="off" action="{{ route('server.check') }}" id="step1form" method="POST" class="needs-validation" novalidate>
                  @csrf
                  @php
                    $servercheck= array();
                  @endphp
                  <div class="form-row">
                      <br>
                     <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>{{__('PHP Extension')}}</th>
                              <th>{{__('Status')}}</th>
                            </tr>
                          </thead>

                          <tbody>

                             <tr>
                                @php
                                  $v = phpversion();
                                @endphp
                              <td>{{__('php version')}} (<b>{{ $v }}</b>)</td>
                              <td>
                               
                               @if($v > 8.1)
                                 
                                 <i class="text-success fa fa-check-circle"></i>
                                 @php
                                   array_push($servercheck, 1);
                                 @endphp
                               @else
                                <i class="text-danger fa fa-times-circle"></i>
                                 <i class="text-success fa fa-times-circle"></i> {{__('PHP Version required >= 8.1')}}
                                 @php
                                   array_push($servercheck, 0);
                                 @endphp
                               @endif
                              </td>
                            </tr>

                             <tr>
                              <td>{{__('pdo')}}</td>
                              <td>
                               
                                  @if (extension_loaded('pdo'))
                                       
                                    <i class="text-success fa fa-check-circle"></i> 
                                    @php
                                      array_push($servercheck, 1);
                                    @endphp
                                  @else
                                     <i class="text-danger fa fa-times-circle"></i>
                                     @php
                                      array_push($servercheck, 0);
                                     @endphp
                                  @endif
                              </td>
                            </tr>

                             <tr>
                              <td>{{__('BCMath')}}</td>
                              <td>
                               
                                  @if (extension_loaded('BCMath'))
                                       
                                    <i class="text-success fa fa-check-circle"></i> 
                                    @php
                                      array_push($servercheck, 1);
                                    @endphp
                                  @else
                                     <i class="text-danger fa fa-times-circle"></i>
                                     @php
                                      array_push($servercheck, 0);
                                     @endphp
                                  @endif
                              </td>
                            </tr>

                             <tr>
                              <td>{{__('openssl')}}</td>
                              <td>
                               
                                  @if (extension_loaded('openssl'))
                                       
                                    <i class="text-success fa fa-check-circle"></i> 
                                     @php
                                      array_push($servercheck, 1);
                                    @endphp
                                  @else
                                     <i class="text-danger fa fa-times-circle"></i>
                                     @php
                                      array_push($servercheck, 0);
                                     @endphp
                                  @endif
                              </td>
                            </tr>

                            <tr>
                              <td>{{__('JSON')}}</td>
                              <td>
                               
                                  @if (extension_loaded('json'))
                                       
                                    <i class="text-success fa fa-check-circle"></i> 
                                    @php
                                      array_push($servercheck, 1);
                                    @endphp
                                  @else
                                     <i class="text-danger fa fa-times-circle"></i>
                                     @php
                                      array_push($servercheck, 0);
                                     @endphp
                                  @endif
                              </td>
                            </tr>

                            <tr>
                              <td>{{__('Session')}}</td>
                              <td>
                               
                                  @if (extension_loaded('session'))
                                       
                                    <i class="text-success fa fa-check-circle"></i> 
                                     @php
                                      array_push($servercheck, 1);
                                    @endphp
                                  @else
                                     <i class="text-danger fa fa-times-circle"></i>
                                     @php
                                      array_push($servercheck, 0);
                                    @endphp
                                  @endif
                              </td>
                            </tr>
                             <tr>
                              <td>{{__('gd')}}</td>
                              <td>
                               
                                  @if (extension_loaded('gd'))
                                       
                                    <i class="text-success fa fa-check-circle"></i> 
                                    @php
                                      array_push($servercheck, 1);
                                    @endphp
                                  @else
                                     <i class="text-danger fa fa-times-circle"></i>
                                     @php
                                      array_push($servercheck, 0);
                                     @endphp
                                  @endif
                              </td>
                            </tr>                            
                            <tr>
                              <td>{{__('allow_url_fopen')}}</td>
                              <td>
                               
                                  @if (ini_get('allow_url_fopen'))
                                       
                                    <i class="text-success fa fa-check-circle"></i> 
                                     @php
                                      array_push($servercheck, 1);
                                    @endphp
                                  @else
                                     <i class="text-danger fa fa-times-circle"></i>
                                      @php
                                      array_push($servercheck, 0);
                                     @endphp
                                  @endif
                              </td>
                            </tr>
                            

                             <tr>
                              <td>{{__('XML')}}</td>
                              <td>
                               
                                  @if (extension_loaded('xml'))
                                       
                                    <i class="text-success fa fa-check-circle"></i> 
                                     @php
                                      array_push($servercheck, 1);
                                    @endphp
                                  @else
                                     <i class="text-danger fa fa-times-circle"></i>
                                     @php
                                      array_push($servercheck, 0);
                                     @endphp
                                  @endif
                              </td>
                            </tr>

                             <tr>
                              <td>{{__('tokenizer')}}</td>
                              <td>
                               
                                  @if (extension_loaded('tokenizer'))
                                       
                                    <i class="text-success fa fa-check-circle"></i> 
                                     @php
                                      array_push($servercheck, 1);
                                    @endphp
                                  @else
                                     <i class="text-danger fa fa-times-circle"></i>
                                     @php
                                      array_push($servercheck, 0);
                                    @endphp
                                  @endif
                              </td>
                            </tr>
                             <tr>
                              <td>{{__('standard')}}</td>
                              <td>
                               
                                  @if (extension_loaded('standard'))
                                       
                                    <i class="text-success fa fa-check-circle"></i> 
                                     @php
                                      array_push($servercheck, 1);
                                    @endphp
                                  @else
                                     <i class="text-danger fa fa-times-circle"></i>
                                     @php
                                      array_push($servercheck, 0);
                                    @endphp
                                  @endif
                              </td>
                            </tr>

                            <tr>
                              <td>{{__('mysqli')}}</td>
                              <td>
                               
                                  @if (extension_loaded('mysqli'))
                                       
                                    <i class="text-success fa fa-check-circle"></i> 
                                     @php
                                      array_push($servercheck, 1);
                                    @endphp
                                  @else
                                     <i class="text-danger fa fa-times-circle"></i>
                                     @php
                                      array_push($servercheck, 0);
                                    @endphp
                                  @endif
                              </td>
                            </tr>

                            <tr>
                              <td>{{__('mbstring')}}</td>
                              <td>
                               
                                  @if (extension_loaded('mbstring'))
                                       
                                    <i class="text-success fa fa-check-circle"></i> 
                                     @php
                                      array_push($servercheck, 1);
                                    @endphp
                                  @else
                                     <i class="text-danger fa fa-times-circle"></i>
                                     @php
                                      array_push($servercheck, 0);
                                    @endphp
                                  @endif
                              </td>
                            </tr>

                             <tr>
                              <td>{{__('ctype')}}</td>
                              <td>
                               
                                  @if (extension_loaded('ctype'))
                                       
                                    <i class="text-success fa fa-check-circle"></i> 
                                     @php
                                      array_push($servercheck, 1);
                                    @endphp
                                  @else
                                     <i class="text-danger fa fa-times-circle"></i>
                                     @php
                                      array_push($servercheck, 0);
                                    @endphp
                                  @endif
                              </td>
                            </tr>

                          <tr>
                            <td>{{__('fileinfo')}}</td>
                              <td>
                               
                                  @if (extension_loaded('fileinfo'))
                                       
                                    <i class="text-success fa fa-check-circle"></i> 
                                     @php
                                      array_push($servercheck, 1);
                                    @endphp
                                  @else
                                     <i class="text-danger fa fa-times-circle"></i>
                                     @php
                                      array_push($servercheck, 0);
                                     @endphp
                                  @endif
                              </td>
                          </tr>                         

                          <tr>
                            <td><b>{{storage_path()}}</b>{{__(' is writable?')}}</td>
                            <td>
                              @php
                                $path = storage_path();
                              @endphp
                              @if(is_writable($path))
                               <i class="text-success fa fa-check-circle"></i> 
                              @else
                                <i class="text-danger fa fa-times-circle"></i>
                              @endif
                            </td>
                          </tr>

                          <tr>
                            <td><b>{{base_path('bootstrap/cache')}}</b> {{__('is writable?')}}</td>
                            <td>
                              @php
                                $path = base_path('bootstrap/cache');
                              @endphp
                              @if(is_writable($path))
                                <i class="text-success fa fa-check-circle"></i> 
                              @else
                                <i class="text-danger fa fa-times-circle"></i>
                              @endif
                            </td>
                          </tr>

                          </tbody>
                        </table>
                     </div>                     
                  </div>
                  @if(!in_array(0, $servercheck))
                    <button class="float-right step1btn btn btn-primary" type="submit">{{__('Next')}}</button>
                  @else
                    <p class="pull-right text-danger"><b>{{__('Some extension are missing. Please Contact your hosting provider for enable it.')}}</b></p>
                  @endif
              </form>
   				</div>
   			</div>
        <p class="text-center m-3 text-white">&copy;{{ date('Y') }} {{__('| eClass - Learning Management System | Installer v1.1 |')}} <a class="text-white" href="http://mediacity.co.in" title="{{__('Media City')}}" target="__blank">{{__('Media City')}}</a></p>
   		</div>
      
    <div class="corner-ribbon bottom-right sticky green shadow">{{__('Server Check')}} </div>    
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
      })();
  </script>
</body>
</html>
