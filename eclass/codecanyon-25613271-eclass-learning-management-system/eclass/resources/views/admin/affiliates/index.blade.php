@extends('admin.layouts.master')
@section('title','Affiliate Settings')
@section('maincontent')
<?php
$data['heading'] = 'Affiliate Settings';
$data['title'] = 'Affiliate Settings';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    @if ($errors->any())  
    <div class="alert alert-danger" role="alert">
    @foreach($errors->all() as $error)     
      <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
      <span class="text-red" aria-hidden="true">&times;</span></button></p>
          @endforeach  
      </div>
    @endif
      <div class="row">
      <div class="col-lg-12">
        <div class="card dashboard-card m-b-30">
          <div class="card-header">
            <h5 class="card-title">{{ __('Affiliate Settings') }}</h5>
          </div>
          <div class="card-body">
            
            <form class="form" action="{{ route('affiliates.update') }}" method="POST" novalidate enctype="multipart/form-data">
                @csrf
              <div class="row">
              <div class="form-group col-md-3">
                <label class="text-dark">{{ __('Referral Code Length:') }}</label>
            
                  <input  name="ref_length" autofocus="" type="number" min="4" max="100" class="form-control" placeholder="{{ __('Please enter Refferal code Length') }}" required="" value="{{ $affilates ? strip_tags($affilates->ref_length) : "" }}">
                
              </div>

              <div class="form-group col-md-3">
                <label class="text-dark">{{ __('Point per referral:') }}</label>
                <input  name="point_per_referral" autofocus="" type="number" min="0" step="any"  class="form-control" placeholder="{{ __('Enter Point for per Referral') }}" value="{{ $affilates ? strip_tags($affilates->point_per_referral) : "" }}">
 
              </div>
              <div class="form-group col-md-12">
                <h4 class="box-title">{{ __('Front Settings') }}</h4>
              </div>
  
             
              <div  class="form-group col-md-3">
                <label for="image">{{ __('Image') }}:<sup class="redstar">*</sup></label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroupFileAddon01">{{ __("Upload") }}</span>
                    </div>
                    <div class="custom-file">
                      <input type="file" name="image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                      <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }}</label>
                    </div>
                  </div>
                 
                @if(isset($affilates->image) && $affilates->image != null && $affilates->image !='' && @file_get_contents('images/affiliate/'.$affilates->image))
                <img src="{{ url('/images/affiliate/'.optional($affilates)['image']) }}" class="img-responsive image_size"/>
                @endif
              </div>
              <div class="form-group col-md-12">
                <label class="text-dark">{{ __('Affiliate Details') }}:</label>
                <textarea name="text" id="detail" rows="3" class="form-control" >{!! $affilates ? $affilates->text : "" !!}</textarea>
              </div>
              <div class="form-group col-md-12">
                    <label for="exampleInputDetails">{{ __('Status') }}:</label><br>
                    <input  type="checkbox" name="status" class="custom_toggle" {{ optional($affilates)['status'] == '1' ? 'checked' : '' }}/>
                </div>
            
             
            </div>
            <div class="form-group">
              <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
              <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update') }}"><i class="fa fa-check-circle"></i>
              {{ __("Update")}}</button>
            </div>
  
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  
@endsection