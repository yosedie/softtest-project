@extends('admin.layouts.master')
@section('title', 'Whatsapp Button Settings - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Whatsapp Button Settings';
$data['title'] = 'Whatsapp Button Settings';
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
  <!-- row started -->
    <div class="col-lg-12">
        <div class="card dashboard-card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Whatsapp Chat Button Setting') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                <form class="form" action="{{ action('WhatsappButtonController@update') }}" method="POST" novalidate enctype="multipart/form-data">
						{{ csrf_field() }}
		                {{ method_field('POST') }}

                        <div class="row">
                            <div class="col-md-6">            
                                <div class="form-group">
                                    <label class="text-dark">{{ __('HeaderTitle') }} : </label>
                                    <input name="wapp_title" autofocus="" type="text" class="form-control" placeholder="Header Title"  value="{{ $setting['wapp_title'] }}">
                                    <div class="invalid-feedback">
                                        {{ __('Please Enter Header Title !') }}.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">            
                                <div class="form-group">
                                    <label class="text-dark">{{ __('WhatasppPhoneNo') }} {{ __('(with country code)') }}:</label>
                                    <input name="wapp_phone" autofocus="" type="text" class="form-control" placeholder="Please Enter Whatsapp Phone Number" value="{{ $setting['wapp_phone'] }}">
                                    <div class="invalid-feedback">
                                        {{ __('Please Enter Whatsapp Phone Number !') }}.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group">
                                    <label class="text-dark">{{ __('WhatasppPopUpMsg') }} :</label>
                                    <input name="wapp_popup_msg" autofocus="" type="text" class="form-control" placeholder="PopUp Message"  value="{{ $setting['wapp_popup_msg'] }}">
                                    <div class="invalid-feedback">
                                        {{ __('Please Enter Whataspp PopUp Message !') }}.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">            
                                <div class="form-group">
			                        <label class="text-dark" for="number">{{ __('whatsappcolor') }} :</label>
			                        <input name="wapp_color" autofocus="" type="color" class="form-control my-colorpicker1" placeholder="Choose color" value="{{ $setting['wapp_color'] }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">{{ __('ButtonPosition') }} ({{ __('Right/left') }}):</label><br>
                                    <input  class="custom_toggle"  type="checkbox" name="wapp_position"  {{ $setting['wapp_position'] == 'left' ? 'checked' : '' }} />
                                    <input type="hidden"  name="free" value="0" for="left" id="left">
                                  
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-dark" for="exampleInputDetails">{{ __('EnableWhatsappChatButton') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" name="wapp_enable" {{ $setting['wapp_enable'] == '1' ? 'checked' : '' }} />
                                <input type="hidden"  name="free" value="0" for="status" id="status">
                            </div>

                        </div>

                        <div class="form-group">
                            <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                {{ __("Save")}}</button>
                        </div>
                        
                    </form>

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