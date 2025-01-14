@extends('admin.layouts.master')
@section('title', 'Language - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Language';
$data['title'] = 'Language';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    <div class="row">
@if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
  <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Admin  of') }} {{ $findlang->name }} ({{ $findlang->local }})</h5>
                    <div>
                      <div class="widgetbar">
                      <a href="{{route('show.lang')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                      </div>
                    </div>
                </div> 
               
                	<!-- card body started -->
                	<div class="card-body">
                  <!-- form start -->
                  <form action="{{ route('admin.static.update',$findlang->local) }}" method="POST">
                    @csrf
					
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <textarea class="form-control" name="transfile" id="inputTextarea" rows="10" placeholder="Textarea text">{{ $file }}</textarea>
                        </div>
                      </div>

                    </div>
							
                    <div class="form-group">
                      <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                      <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                      {{ __("Update")}}</button>
                    </div>

                  </form>
                  <!-- form end -->
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