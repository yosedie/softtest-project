@extends('admin.layouts.master')
@section('title','Create a new announcement')
@section('maincontent')
<?php
$data['heading'] = 'Announcement';
$data['title'] = 'Announcement';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
  @if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="box-tittle">{{ __('Add') }} {{ __('Announcement') }}</h5>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" action="{{ url('instructor/announcement/') }}" data-parsley-validate class="form-horizontal form-label-left">
            {{ csrf_field() }}
            

            <input type="hidden" name="instructor_id" class="form-control" value="{{ Auth::User()->id }}"  />

            <div class="row"> 
              <div class="col-md-12">
                <label for="exampleInputSlug">{{ __('Course') }}<span class="redstar">*</span></label>
                <select name="course_id" class="form-control select2" required="">
                  <option value="none" selected disabled hidden> 
                     {{ __('SelectanOption') }}
                  </option>
                  @foreach($course as $cor)
                      <option required value="{{ $cor->id }}">{{ $cor->title }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row"> 
              <div class="col-md-12">
                <select name="user_id" class="form-control d-none">
                  <option  value="{{ Auth::user()->id }}">{{ Auth::user()->fname }}</option>
                </select>
              </div>
            </div>
            <br>
            
            <div class="row">  
              <div class="col-md-12">
                <label for="exampleInputDetails">{{ __('Announcement') }}:<sup class="redstar">*</sup></label>
                <textarea name="announsment" rows="3" class="form-control" placeholder="Enter Question"></textarea>
              </div>
            </div>
            <br>
            
            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputDetails">{{ __('Status') }}:</label>               
                <input id="c2222" type="checkbox" class="custom_toggle" name="status" checked />
      
                 
                  <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="c2222"></label>
               
                <input type="hidden" name="status" value="0" id="t2222">
              </div>
            </div>
            <br>
          
            <div class="form-group">
              <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i> {{__('Reset')}}</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                {{__('Create')}}</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
