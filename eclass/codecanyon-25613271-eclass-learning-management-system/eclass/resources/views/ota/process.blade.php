@extends('admin.layouts.master')
@section('title', 'Update Process - Admin')
@section('maincontent')
@include('admin.layouts.topbar')
<div class="contentbar bardashboard-card">
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="alert alert-success alert-dismissible fade show"> 
                <span id="update_text">                    
                </span>    
                <form action="{{ url("/merge-quick-update") }}" method="POST" class="float-right d-none updaterform">
                    @csrf
                    <input required type="hidden" value="" name="filename">
                    <input required type="hidden" value="" name="version">
                    <button class="btn btn-sm btn-primary-rgba" title="{{ __('Update Now') }}">
                        <i class="feather icon-check-circle"></i> {{__("Update Now")}}
                    </button>
                </form>        
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
                <span aria-hidden="true">&times;</span>
                </button>    
            </div>
        </div>
    </div>        
    <div class="card m-b-30">
        @include('admin.message')
        <!-- Card header will display you the heading -->
        <div class="card-header">
            <h5 class="card-box">{{ __('Update Process') }}</h5>
        </div>         
        <!-- card body started -->
        <div class="card-body bg-warning-rgba ml-5 mr-5 mb-5">
        <!-- ===================== -->
            <small class="text-warning process-fonts"><i class="fa fa-info-circle"></i> {{__('Important Note:')}}
                <ul class="process-font">
                    <li>{{ __('Note: Before Update Take Backup of All Files And Database. Make .zip file and download all file, Go To phpmyadmin and select your database and export it.') }}<br/></li>
                    <li>Copy All files and paste to you folder replace file. Only be careful when replace files in public folder, don't copy<code> .env </code>file. Any user customize design and code please do not update.</li>
                    <li>{{ __('Update to Latest Version') }} </li>
                    <li>Copy All files of folder and paste to you folder and replace files, only be careful when replace files in public folder, don't copy<code> .env </code>file.Any user customize design and code please do not update.</li>
                    <li>{{ __('After replacing the files successfully ') }}
                    <li>{{ __('login with admin goto yourdomain.com/ota/update. If your domain contain public then goto ') }}</li>
                    <li>{{ __('yourdomain.com/public/ota/update') }}</li><li>.{{ __(' Read update pre-notes and FAQ properly, then check the agreement box and click on update. After the update completion you will be redirected to yourdomain with a successful update message.') }}</li>
                    <li>{{ __(' Once the process is complete you will see a successful message on your home page.') }}</li>
                    <li>{{ __('You successfully upgraded to latest version ') }}</li>
                </ul>
            </small>
        </div>
    </div>
</div>
@endsection
<!-- main content section ended -->
@section('script')
@endsection
