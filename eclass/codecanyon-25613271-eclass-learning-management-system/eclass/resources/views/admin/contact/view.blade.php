@extends('admin.layouts.master')
@section('title', 'View Message')
@section('maincontent')
<?php
$data['heading'] = 'View Message';
$data['title'] = 'Contact Form Messages';
$data['title1'] = 'View Message';

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
                    <h5 class="card-box"> {{ __('View Message') }}</h5>
                    <div>
                        <div class="widgetbar">
                        <a href="{{url('usermessage')}}" class="btn btn-primary-rgba" title="{{ __('Back') }}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                        </div>
                      </div>
                </div> 
                <!-- card body started -->
                <div class="card-body">
					<div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-4 text-center">
                            <h4 class="btm-20">{{ __(' User ') }}: {{ $show->fname }}</h4>
                            <div class="card card-contact text-left">
                                <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <th scope="row" class="p-1">{{ __('Email ID. :') }} </th>
                                                    <td class="p-1 text-black">{{ $show->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="p-1">{{ __('Contact No. :') }} </th>
                                                    <td class="p-1 text-black"> {{ $show->mobile }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="p-1">{{ __('Date :') }}</th>
                                                    <td class="p-1 text-black">{{ date('jS F Y', strtotime($show->created_at)) }}</td>
                                                </tr>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-center">
                                <h4 class="btm-20">{{ __('Message :') }}</h4>
                                <div class="card card-contact">
                                    <p class="text-black">{{ $show->message }}</p>
                                </div>
                            </div>
                            <div class="col-lg-4 text-center">
                                <h4 class="btm-20">{{ __('Reason :') }}</h4>
                                <div class="card card-contact">
                                    <p class="text-black">{{ $show->reason }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
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