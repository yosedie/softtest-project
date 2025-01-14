@extends('admin.layouts.master')
@section('title', 'Add City')
@section('maincontent')
<?php
$data['heading'] = 'Add City';
$data['title'] = 'Cities';
$data['title1'] = 'Add City';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  @if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
  @endforeach  
  </div>
  @endif
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-title"> {{ __('Add City') }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{url('admin/city')}}" class="btn btn-primary-rgba" title="{{ __('Back') }}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
          
            </div>
          </div>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/city')}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            <div class="row">
              <div class="form-group col-md-4">
                <label for="exampleInputTit1e">{{ __('State') }}<sup class="redstar">*</sup></label>
                    <select class="select2-single form-control" name="state_id" required>
                      <option value="">{{ __('Choose State') }}:</option>
                      @foreach ($states as $state)
                      <option value="{{ $state->state_id }}">{{ $state->name }}</option>
                      @endforeach
                  </select>
                  </div>
                </div>
                <div class="form-group">
                  <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                  <button type="submit" class="btn btn-primary-rgba" title="{{ __('Create') }}"><i class="fa fa-check-circle"></i>
                  {{ __("Create")}}</button>
                </div>
    
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
    
@endsection
                  

              


