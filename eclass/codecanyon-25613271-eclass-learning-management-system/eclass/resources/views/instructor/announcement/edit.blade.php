@extends('admin.layouts.master')
@section('title','Edit Announcement')
@section('maincontent')
<?php
$data['heading'] = 'Edit Announcement';
$data['title'] = 'Edit Announcement';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
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
        <div class="card-header">
          <h5 class="box-title">{{ __('Edit') }} {{ __('Announcement') }}</h5>
        </div>
        <div class="card-body ml-2">
          <form id="demo-form" method="post" action="{{url('instructor/announcement/'.$announs->id)}}" data-parsley-validate class="form-horizontal form-label-left">
            {{ csrf_field() }}
            {{ method_field('PUT') }}


            <input type="hidden" name="instructor_id" class="form-control" value="{{ Auth::User()->id }}"  />
            
                 
            <div class="row">
              <div class="col-md-12 mb-4">
                <label for="exampleInputTit1e">{{ __('Announcement') }}:<span class="redstar">*</span></label>
                <textarea name="announsment" rows="3" class="form-control" placeholder="Enter Question">{{$announs->announsment}}</textarea>
              </div>
            
              <div class="col-md-12">
                <label for="exampleInputTit1e">{{ __('Status') }}:</label>
                <input type="checkbox" id="cb77" class="custom_toggle" name="status"
                    {{ $announs->status == '1' ? 'checked' : '' }} />
                  
                  <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="cb77"></label>
                
                <input type="hidden" name="status" value="{{ $announs->status }}" id="jp">
              </div>
            </div> 
            <br>
              
            <div class="col-md-6">
              <div class="form-group">
                               <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
                                 {{__('Reset')}}</button>
                               <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                                 {{__('Update')}}</button>
                             </div>
             
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection