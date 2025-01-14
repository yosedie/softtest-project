@extends('admin.layouts.master')
@section('title', 'Attendance - User Enrolled')
@section('maincontent')
<?php
$data['heading'] = 'User Enrolled';
$data['title'] = 'Attendance';
$data['title1'] = 'User Enrolled';
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
                    <h5 class="card-box">{{ __('User Enrolled') }}</h5>
                    <div>
                        <div class="widgetbar">
                        <a href="{{url('attandance')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                        </div>
                      </div>
                  </div> 
               
                <!-- card body started -->
                <div class="card-body">
                <div class="table-responsive">
                        <!-- table to display faq start -->
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                        <th>#</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Attendance Details') }}</th>
                        </thead>
​
                        <tbody>
                            <?php $i=0;?>
                            @foreach($enrolled as $enroll)
                            <?php $i++;?>
                              <tr>
                                <td><?php echo $i;?></td>
                                <td>
                                  <p><b>{{ __('User') }}:</b> {{ $enroll->user->fname }} {{ $enroll->user->lname }}</p>
                                  <p><b>{{ __('Email') }}:</b> {{ $enroll->user->email }} </p>
                                </td>
                                <td>
                                  <a href="{{ route('user.attandance', ['id' => $enroll->user_id, 'course' => $enroll->course_id]) }}" class="btn btn-primary" title="{{ __('Attendance') }}">{{ __('Attendance') }}</a>
                                </td>
            
                            </tr> 
                            @endforeach 
                        </tbody>
                        </table>                  
                        <!-- table to display faq data end -->                
                    </div><!-- table-responsive div end -->
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