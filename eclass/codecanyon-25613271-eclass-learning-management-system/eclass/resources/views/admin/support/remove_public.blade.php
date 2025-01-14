@extends('admin.layouts.master')
@section('title', 'Remove Public')
@section('maincontent')
<?php
$data['heading'] = 'Remove Public';
$data['title'] = 'Remove Public';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    <div class="row">
@if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
  
    <!-- row started -->
    <div class="col-lg-12">
    
        <div class="card dashboard-card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Remove Public From URL') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                <div class="card bg-primary-rgba m-b-30">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <small class="text-primary process-fonts"><i class="fa fa-info-circle"></i> {{ __('ImportantNote') }}
                                        <ul class="process-font">
                                    <li>
                                        {{__(('Removing public from URL is only works when you have installed script in main domain.'))}}
                                    </li>

                                    <li>
                                        {{__("Do not remove public when you have Installed script in subdomin or subfolders.")}}
                                    </li>
                                    <li>
                                        {{__("Removing public from URL not work for Localhost.")}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- =============================== -->
                <div class="row">
                 
                    @if(file_exists(base_path().'/'.'.htaccess'))         
                    @if($contents == NULL || $contents != $destinationPath)
                    <div class="col-12">
                        <!-- form start -->
                        <form action="{{ route('add.content') }}" class="form" method="POST">
                            @csrf
                            <!-- row start -->
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- card start -->
                                    <div class="card">
                                        <!-- card body start -->
                                        <div class="card-body">
                                            <!-- row start -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!-- row start -->
                                                    <div class="row">       
                                                            <div class="col-md-12">
                                                               
                                                                    <button type="submit" class="btn btn-primary">
                                                                        {{__("Click to Remove Public")}}
                                                                    </button>
                                                            </div>
                                                    </div><!-- row end -->
                                                </div><!-- col end -->
                                            </div><!-- row end -->
                                        </div><!-- card body end -->
                                    </div><!-- card end -->
                                </div><!-- col end -->
                            </div><!-- row end -->
                        </form>
                    <!-- form end -->
                    </div>@endif
                        @elseif(!file_exists(base_path().'/'.'.htaccess') )
                        <div class="col-12">
                            <!-- form start -->
                            <form action="{{ route('create.file') }}" class="form" method="POST">
                                @csrf
                                <!-- row start -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- card start -->
                                        <div class="card">
                                            <!-- card body start -->
                                            <div class="card-body">
                                                <!-- row start -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <!-- row start -->
                                                        <div class="row">       
                                                            <div class="col-md-4">
                                                            
                                                                <button type="submit" class="btn btn-primary">
                                                                    {{__("Click to Remove Public")}}
                                                                </button>
                                                            </div>
                                                        </div><!-- row end -->
                                                    </div><!-- col end -->
                                                </div><!-- row end -->
                                            </div><!-- card body end -->
                                        </div><!-- card end -->
                                    </div><!-- col end -->
                                </div><!-- row end -->
                            </form>
                            <!-- form end -->
                            <div class="card-body">
                        <div class="card bg-info-rgba m-b-30">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <div class="text-info process-fonts"><i class="fa fa-info-circle"></i> {{ __('Remove Public From URL Manually') }}       
                                                <p>
                                                    {{ __('To remove the public from the URL create a .htaccess file in  the root folder and write following code.') }}
                                                </p>
                                                <p>
                                                    </p><pre>   
&lt;IfModule mod_rewrite.c&gt;
    RewriteEngine On 
    RewriteRule ^(.*)$ public/$1 [L]
&lt;/IfModule&gt;           
</pre>                                          
                                                    <p></p>
                                                    <p>
                                                    {{ __('To remove the public from URL and Force HTTPS redirection create a .htaccess file in the root folder and write the following code.') }}
                                                    </p>
                                                    <p>
                                                                                                            </p><pre>   
&lt;IfModule mod_rewrite.c&gt;  
    RewriteEngine On
    RewriteCond %{HTTPS} !=on
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301,NE] 
    RewriteRule ^(.*)$ public/$1 [L]
&lt;/IfModule&gt;               
</pre>      
                                                    <p></p>
                                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                        </div>
                        @endif
                   
                </div>
                <!-- =============================== -->
               
                </div>
                <!-- card body end -->
            
        </div><!-- col end -->
    </div>
</div>
</div><!-- row end -->
    <br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain javacsript start -->
@section('script')
@endsection
<!-- This section will contain javacsript end -->