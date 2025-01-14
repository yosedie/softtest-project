@extends('admin.layouts.master')
@section('title','Create a new subcategory')
@section('maincontent')
<?php
$data['heading'] = 'Subcategory';
$data['title'] = 'Subcategory';
?>
@include('admin.layouts.topbar',$data)
@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
<div class="contentbar dashboard-card">
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-tittle">{{ __('Add') }} {{ __('Subcategory') }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{ url('subcategory') }}" class="float-right btn btn-dark-rgba mr-2" title="{{ __('Back') }}"
><i
                class="feather icon-arrow-left mr-2"></i>{{__('Back')}}</a>
              </div>                        
          </div>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" action="{{url('subcategory/')}}" data-parsley-validate class="form-horizontal form-label-left" autocomplete="off">
            {{ csrf_field() }}
            <div class="box-body">
              <div class="form-group">
                <form id="demo-form2" method="post" action="{{url('subcategory/')}}" data-parsley-validate class="form-horizontal form-label-left" autocomplete="off">
                  {{ csrf_field() }}
    
                  <div class="row">
                    <div class="col-md-6">
                      <label for="exampleInputTit1e">{{ __('Category') }}</label>
                      <select name="category_id" class="form-control select2">
                        @foreach($category as $cate)
                        <option value="{{$cate->id}}">{{$cate->title}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label for="exampleInputTit1e">{{ __('Category') }}</label>
                      <br>
                      <button type="button" data-dismiss="modal" data-toggle="modal" data-target="#myModal9" title="AddCategory"  class="btn btn-md btn-primary col-md-5" title="{{ __('Add') }}">{{ __('Add') }}</button>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="exampleInputTit1e">{{ __('SubCategory') }}:<sup class="redstar">*</sup></label>
                      <input type="text" class="form-control" name="title" id="title"  placeholder="Enter Your subcategory" value="">
                    </div>
    
                     <div class="col-md-6">
                      <label for="exampleInputTit1e">{{ __('Slug') }}:<sup class="redstar">*</sup></label>
                      <input pattern="[/^\S*$/]+" type="text" id="slug" class="form-control" name="slug" placeholder="Enter slug" value="">
                    </div>
                    
                  </div>
                  <br>
    
                  <div class="row">
    
                    <div class="col-md-6">
                      <label for="exampleInputTit1e">{{ __('Icon') }}:</label>
                      <input type="text" class="form-control icp-auto icp" name="icon" id="exampleInputTitle" placeholder="Enter Your icon" value="">
                      
                      <div class="input-group">
                  <input type="text" class="form-control iconvalue" name="icon" value="Choose icon">
                  <span class="input-group-append">
                      <button  type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                  </span>
              </div>
                    </div>
    
                    <div class="col-md-6">
                      <label for="exampleInputDetails">{{ __('Status') }}:</label><br>
                    <input id="status_toggle" type="checkbox" class="custom_toggle" name="status" checked/>
                    <input type="hidden" name="free" value="0" for="status" id="status">
                     
                    </div>
                  </div>
                  <br>
             
                  <div class="form-group">
                    <button type="reset" class="btn btn-danger" title="{{ __('Reset') }}"
><i class="fa fa-ban"></i> {{__('Reset')}}</button>
                    <button type="submit" class="btn btn-primary" title="{{ __('Create') }}"
><i class="fa fa-check-circle"></i>
                        {{__('Create')}}</button>
                </div>
            
            <div class="clear-both"></div>
           
               
            </div>
          </form>
          

        </div>
      </div>
    </div>
  </div>
</div>
@include('admin.category.subcategory.cat') 

@endsection
@section('script')
@endsection


