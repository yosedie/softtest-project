@extends('admin.layouts.master')
@section('title', 'Import Demo Content')
@section('maincontent')
<?php
$data['heading'] = 'Import Demo Content';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
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
                    <h5 class="card-box text-white">{{ __('Import Demo Content') }}</h5>
                </div> 
                <!-- card body started -->
                <div class="card-body">
                    <div class="card-body bg-danger">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <small class="process-fonts text-white"><i class="fa fa-info-circle"></i> {{ __('Important Note') }}
                                    <ul class="process-font text-white">
                                        <li>
                                            {{__('Please take Backup first.')}}
                                        </li>
                                        <li>
                                            {{__('ON Click of import data your existing data will remove (except users & settings)')}}
                                        </li>
                                        <li>
                                           {{__('ON Click of reset data will reset your site (which you see after fresh install).')}} {{__('Its erase your Demo data and give blank site.')}}
                                        </li>
                                        <li>
                                            {{__('You get only placeholder images in demo data.')}}
                                        </li>
                                        <li>
                                            {{__('Demo data refers to sample or placeholder data that is used for demonstration or testing purposes. It is used to show how LMS works, or to test the functionality of a LMS.')}}
                                        </li>
                                    </ul>
                                
                            </div>
                        </div>
                    </div>
                    <!-- ========== DemoImport and reset start ===================== -->
                <div class="row">
                    <!-- DemoImport start -->
                    <div class="col-6">
                        <!-- ========== DemoImport start ===================== -->
                        <!-- form start -->
                        <form action="{{ url('admin/import/demo') }}" class="form" method="POST">
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
                                                            <!-- DemoImport -->
                                                            <div class="col-md-12">
                                                                <label class="text-dark">{{ __('Demo Import') }} :<span class="text-danger">*</span></label>
                                                                <button type="submit" class="btn btn-danger btn-lg btn-block" title="{{ __('Demo Import') }}">
                                                                    {{ __('Demo Import') }}
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
                    </div>
                    <!-- DemoImport end -->
                    <!-- reset start -->
                    <div class="col-6">
                          <!-- form start -->
                        <form action="{{ url('admin/reset/demo') }}" class="form" method="POST">
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
                                                        <!-- ResetDemo -->
                                                        <div class="col-md-12">
                                                                <label class="text-dark">{{ __('Reset Demo') }} :<span class="text-danger">*</span></label>
                                                                <button type="submit" class="btn btn-warning btn-lg btn-block" title="{{ __('Reset Demo') }}">
                                                                    {{ __('Reset Demo') }}
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
                    </div>
                     <!-- reset end -->
                </div>
                <!-- ========== DemoImport and reset end ===================== -->
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