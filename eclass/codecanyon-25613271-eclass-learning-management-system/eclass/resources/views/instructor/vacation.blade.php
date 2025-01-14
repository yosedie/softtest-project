@extends('admin.layouts.master')
@section('title', 'Vacation - Instructor')
@section('maincontent')
<?php
$data['heading'] = 'Vacation';
$data['title'] = 'Vacation';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
  @if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
<div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Update Vacation Dates') }}</h5>
          <div>
            <div class="widgetbar">
                <a href="{{ route('vacation.reset') }}" class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>{{ __("Reset")}}</a>
            </div>                        
          </div>
        </div>
        <div class="card-body">
          
      <form action="{{ action('VacationController@update') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
          <div class="row">
            <div class="form-group col-md-6">
              
            <label for="icon">{{ __('Start Time') }}<sup class="redstar">*</sup></label>
            <div class="input-group">
              <input name="vacation_start" type="text" id="default-date" class="form-control" value="{{ isset(Auth::user()['vacation_start']) ? date('Y-m-d',strtotime(Auth::user()['vacation_start'])) : "" }}" aria-describedby="basic-addon5" />
              <div class="input-group-append">
                <span class="input-group-text" id="basic-addon5"><i class="feather icon-calendar"></i></span>
              </div>
            </div>
             
              
            </div>
            <div class="form-group col-md-6">
                <label for="currency">{{ __('End Time') }}<sup class="redstar">*</sup></label>
               <div class="input-group">
                <input name="vacation_end" type="text" id="default-date1" class="form-control" value="{{ isset(Auth::user()['vacation_end']) ? date('Y-m-d',strtotime(Auth::user()['vacation_end'])) : "" }}" aria-describedby="basic-addon5" />
                <div class="input-group-append">
                  <span class="input-group-text" id="basic-addon5"><i class="feather icon-calendar"></i></span>
                </div>
              </div>
            </div>

            
          </div>
          <div class="form-group">
            <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
            {{ __("Update")}}</button>
          </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

