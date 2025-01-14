@extends('admin.layouts.master')
@section('title', 'Language - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Language';
$data['title'] = 'Site Setting';
$data['title1'] = 'Language';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
    <div class="row">
@if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close')}}">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif  
    <!-- row started -->
    <div class="col-lg-12">
        <div class="card dashboard-card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Language') }}</h5>
                    <div>
                        <div class="widgetbar">
                        <button type="button" class="float-right btn btn-danger-rgba mr-2" data-toggle="modal" data-target="#bulk_delete" title="{{ __('Delete Selected')}}"><i
                class="feather icon-trash mr-2"></i>{{ __('Delete Selected') }} </button>
                    <a href="{{ action('LanguageController@create') }}" class="float-right btn btn-primary-rgba mr-2" title="{{ __('Add Language')}}"><i class="feather icon-plus mr-2"></i>{{ __('Add Language') }}</a>
                   
                        </div>
                        </div>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="defaultTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#facebook" role="tab" aria-controls="home" aria-selected="true" title="{{ __('Language')}}">{{ __('Language') }}</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#google" role="tab" aria-controls="profile" aria-selected="false">{{ __('Static Word Translation') }}</a>
                        </li> --}}                     
                    </ul>
                    <div class="tab-content" id="defaultTabContent">
                        <!-- === language start ======== -->
                        <div class="tab-pane fade show active" id="facebook" role="tabpanel" aria-labelledby="home-tab">
                            <!-- === language form start ======== -->
                            @include('admin.language.index')
                            <!-- === language form end ===========-->    
                        </div>
                          <!-- === language end ======== -->

                          <!-- === frontstatic start ======== -->
                        {{-- <div class="tab-pane fade" id="google" role="tabpanel" aria-labelledby="profile-tab">
                            <!-- === frontstatic form start ======== -->
                            @include('admin.language.frontstatic.index')
                            <!-- === frontstatic form end ===========-->
                        </div> --}}
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
<script>
    $("#checkboxAll").on('click', function () {
$('input.check').not(this).prop('checked', this.checked);
});
</script>
@endsection
<!-- This section will contain javacsript end -->