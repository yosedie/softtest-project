@extends('admin.layouts.master')
@section('title', 'Edit Service - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Edit Service';
$data['title'] = 'Front Settings';
$data['title1'] = 'Services';
$data['title2'] = 'Edit Service';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  @if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close')}}">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Edit Service') }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{url('admin/services')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
          
            </div>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ url('admin/services', $service->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
              <input type="hidden" name="id" id="id" class="form-control" value="{{ $service->id }}" required>
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" name="name" id="name" class="form-control" value="{{ $service->name }}" required>
                </div>
              </div>
              <div class="form-group col-md-2">
                <label class="text-dark" for="exampleInputDetails">{{ __('Status') }} :</label><br>
                <input type="checkbox" class="custom_toggle" name="status" {{ $service->status == '1' ? 'checked' : '' }} />
                
            </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection