@extends('admin.layouts.master')
@section('title', 'Create Menu')
@section('maincontent')
<?php
$data['heading'] = 'Create Menu';
$data['title'] = 'Front Setting';
$data['title1'] = 'Menus';
$data['title2'] = 'Create Menu';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    <div class="row">
@if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close')}}">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
  <!-- row started -->
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Create Menu') }}</h5>
                    <div>
                      <div class="widgetbar">
                      <a href="{{url('admin/menu')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                      </div>
                    </div>
                </div>               
                <!-- card body started -->
                <div class="card-body">
                 <!-- form start -->
                 <form id="demo-form2" method="post" action="{{action('MenuController@store')}}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                          <!-- Local -->
                          <div class="form-group col-md-3">
                            <label>{{__("Menu:")}} <span class="text-danger">*</span></label>
                            <input name="title" type="text" class="form-control" required placeholder="{{ __('Enter menu name') }}">
                          </div>                          
                          <div class="form-group col-md-3">
                            <label>{{__("Link By:")}} <span class="text-danger">*</span></label>
                            <select required class="form-control select2" name="link_by" id="link_by">
                              <option value="page">{{ __("Pages") }}</option>
                              <option value="url">{{ __('URL') }}</option>
                            </select>
                          </div>  
                          <div class="form-group col-md-3" id="pagebox">
                            <label>{{__("Select pages:")}} <span class="text-danger">*</span></label>
                            <select required="" class="form-control select2" name="page_id" id="page_id">
                              @foreach($pages as $page)
                              <option value="{{$page->id }}">{{ $page->title }}</option>
                              @endforeach
                            </select>
                          </div>  
                          <div id="urlbox" class="form-group col-md-3" style="display: none;">
                            <label>{{__("URL:")}} <span class="text-danger">*</span></label>
                            <input class="form-control" type="url" placeholder="{{ __('Enter custom URL') }}" name="url"
                              id="inputurl">
                          </div>
                          <div class="form-group col-md-3">
                            <label>{{__("Position:")}} <span class="text-danger">*</span></label>
                            <select required class="form-control select2" name="position_menu" id="position">
                              <option value="top">{{ __('Top') }}</option>
                              <option value="footer">{{ __("Footer") }}</option>
                            </select>
                          </div>
                          <div class="form-group col-md-3" id="footerbox" style="display: none;">
                            <label>{{__("Select footer position:")}} <span class="text-danger">*</span></label>
                            <select required="" class="form-control select2" name="footer" id="footer_id">
                              <option value="widget2">{{ __("Widget 2") }}</option>
                              <option value="widget3">{{ __('Widget 3') }}</option>
                              <option value="widget4">{{ __('Widget 4') }}</option>
                            </select>
                          </div>
                          <div class="form-group col-md-3">
                            <label>{{ __('Status:') }}</label>
                            <br>
                            <label class="switch">
                              <input type="checkbox" name="status" checked>
                              <span class="knob"></span>
                            </label>
                          </div>
                          <div class="form-group col-md-12">
                            <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                            <button type="submit" class="btn btn-primary-rgba" title="{{ __('Create')}}"><i class="fa fa-check-circle"></i>
                            {{ __("Create")}}</button>
                        </div>
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
<script src="{{ url('js/footermenu.js') }}"></script>

@endsection
<!-- This section will contain javacsript end -->