@extends('admin.layouts.master')
@section('title', 'Add Front Theme new')
@section('maincontent')
<?php
$data['heading'] = 'Add Front Theme';
$data['title'] = 'Front Theme Settings';
$data['title1'] = 'Add Front Theme';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar mb-2">
        <div class="row">

            <!-- Show error message -->
            @if ($errors->any())  
                <div class="alert alert-danger" role="alert">
                    @foreach($errors->all() as $error)     
                        <p>
                            {{ $error}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </p>
                    @endforeach  
                </div>
            @endif
        <!-- row started -->
            <div class="col-lg-12">
                <div class="card dashboard-card m-b-30">
                    <!-- Card header will display you the heading -->
                    <div class="card-header">
                        <h5 class="card-box">{{ __('Add Front Theme') }}</h5>
                        <div>
                            <div class="widgetbar">
                                <a href="{{ route('themesettings.index')}}" class="btn btn-primary-rgba" title="{{ __('Back') }}">
                                <i class="feather icon-arrow-left mr-2"></i>
                                {{ __("Back")}}
                                </a>
                            </div>
                        </div>
                    </div> 
                
                    <!-- card body started -->
                    <div class="card-body">
                        <!-- form start -->
                        <form action="{{ route('install.theme') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- card start -->
                                    <div class="card">
                                        <!-- card body start -->
                                        <div class="card-body">
                                            <!-- row start -->
                                            <div class="row">
                                                <!-- Purchase Code -->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="text-dark">{{ __('Purchase Code :') }}<span class="text-danger">*</span></label>
                                                        <input id="pass_log_id6" type="password" placeholder="Please enter valid purchase code" class="form-control"  name="code" value=""  required>
                                                        <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password6"></span>
                                                    </div>
                                                </div>

                                                <!-- UPLOAD THEME FILE -->
                                                <div class="col-md-4">
                                                    <label class="text-dark mb-1">
                                                        {{ __('UPLOAD THEME FILE (.ZIP FILE) :') }}
                                                    </label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input accept=".zip" type="file" required class="custom-file-input" name="addon_file" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                            <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                                    
                                                <!-- Install theme button -->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}">
                                                            <i class="fa fa-ban"></i> 
                                                            {{ __("Reset")}}
                                                        </button>
                                                        <button type="submit" class="btn btn-primary-rgba" title="{{ __('Install') }}">
                                                            <i class="fa fa-check-circle"></i>
                                                            {{ __("Install")}}
                                                        </button>
                                                    </div>
                                                </div>        
                                            </div><!-- row end -->
                                        </div><!-- card body end -->
                                    </div><!-- card end -->
                                </div><!-- col end -->
                            </div>
                        </form>
                        <!-- form end -->
                    </div>
                    <!-- card body end -->
                </div><!-- col end -->
            </div>

        </div><!-- row end -->
    </div>
@endsection
<!-- main content section ended -->

<!-- This section will contain javacsript start -->
@section('script')
    <style>
    .field_icon {
    float: right;
    margin-left: -25px;
    margin-top: -25px;
    position: relative;
    z-index: 2;
    }
    </style>

    <!-- Script to show and hide purchase code -->
    <script>
        $(document).on('click', '.toggle-password6', function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $("#pass_log_id6");
            input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
        });
    </script>
@endsection
<!-- This section will contain javacsript end -->