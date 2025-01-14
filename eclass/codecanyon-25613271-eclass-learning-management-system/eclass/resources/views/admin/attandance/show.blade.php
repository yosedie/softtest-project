@extends('admin.layouts.master')
@section('title', 'Attendance')
@section('maincontent')
<?php
$data['heading'] = 'Attendance';
$data['title'] = 'Attendance';
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
                    <h5 class="card-box">{{ __('Attendance') }}</h5>
                </div>                
                <!-- card body started -->
                <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="defaultTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#facebook" role="tab" aria-controls="home" aria-selected="true" title="{{ __('Courses') }}">{{ __('Courses') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#google" role="tab" aria-controls="profile" aria-selected="false" title="{{ __('Meetings') }}">{{ __('Meetings') }}</a>
                        </li>
                  
                    </ul>
                    <div class="tab-content" id="defaultTabContent">

                        <!-- === language start ======== -->
                        <div class="tab-pane fade show active" id="facebook" role="tabpanel" aria-labelledby="home-tab">
                            <!-- === language form start ======== -->
                            @include('admin.attandance.index')
                            <!-- === language form end ===========-->    
                        </div>
                          <!-- === language end ======== -->

                          <!-- === frontstatic start ======== -->
                        <div class="tab-pane fade" id="google" role="tabpanel" aria-labelledby="profile-tab">
                            <!-- === frontstatic form start ======== -->
                            @include('admin.attandance.liveclass')
                           
                            <!-- === frontstatic form end ===========-->
                        </div>
                        <!-- === frontstatic end ======== -->

                    </div>
                </div><!-- card body end -->
            
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