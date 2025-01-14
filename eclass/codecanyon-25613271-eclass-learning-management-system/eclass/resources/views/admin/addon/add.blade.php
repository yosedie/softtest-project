@extends('admin.layouts.master')
@section('title', 'Add Addon')
@section('maincontent')
<?php
$data['heading'] = 'Add Addon';
$data['title'] = 'Addon Manager';
$data['title1'] = 'Add Addon';
?>
@include('admin.layouts.topbar',$data)
<!-- row started -->
<div class="contentbar">
    <div class="col-lg-12">
        <div class="card dashboard-card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Add Addon') }}</h5>
                </div> 
                <div>
                    <div class="widgetbar">
                    <a href="{{url('admin/addon')}}" class="btn btn-primary-rgba" title="{{ __('Back') }}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                    </div>
                  </div>
                <!-- card body started -->
                <div class="card-body">
                 <!-- form start -->
                 <form action="{{ action('AddonController@installaddon') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                        <!-- row start -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- card start -->
                                <div class="card">
                                    <!-- card body start -->
                                    <div class="card-body">
                                        <!-- row start -->
                                          <div class="row">
                                              
                                              <div class="col-md-12">
                                                  <!-- row start -->
                                                  <div class="row">
                                                    
                                                    <!-- Purchase Code -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Purchase Code :') }}<span class="text-danger">*</span></label>
                                                            <input id="pass_log_id6" type="password" placeholder="Please enter valid purchase code" class="form-control"  name="code" value=""  required>
                                                            <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password6"></span>
                                                        </div>
                                                    </div>

                                                   <!-- UPLOAD ADDON FILE -->
                                                   <div class="col-md-4">
                                                    <label class="text-dark">{{ __('UPLOAD ADDON FILE (.ZIP FILE) :') }}</label><br>
                                                    <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" required class="custom-file-input" name="addon_file" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                        <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    <div class="custom-control custom-checkbox">
                                                        <input  type="checkbox" class="custom-control-input coupon_question" id="customCheck2" name="eula2" checked="checked" required onchange="valueChanged()"/>
                                                        <label class="custom-control-label" for="customCheck2"><b>I agree <a href ="http://mediacity.co.in/privacy-policy">{{__('Privacy Policy')}}</a></b></label>
                                                      </div>           
                                                    <!-- Install Addon button -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban" title="{{ __('Reset') }}"></i> {{ __("Reset")}}</button>
                                                            <button type="submit" class="btn btn-primary-rgba answer" title="{{ __('Install Addon') }}"><i class="fa fa-check-circle"></i>
                                                            {{ __("Install Addon !")}}</button>
                                                        </div>
                                                    </div>
                                                  
                                                  </div><!-- row end -->
                                              </div><!-- col end -->
                                          </div><!-- row end -->

                                    </div><!-- card body end -->
                                </div><!-- card end -->
                            </div><!-- col end -->
                        </div><!-- row end -->
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
<style>
.field_icon {
  float: right;
  margin-left: -25px;
  margin-top: -25px;
  position: relative;
  z-index: 2;
}
</style>
<script>
$(document).on('click', '.toggle-password6', function() {
$(this).toggleClass("fa-eye fa-eye-slash");
var input = $("#pass_log_id6");
input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});
</script>
<script type="text/javascript">
    function valueChanged()
    {
      // $(".answer").hide();
      var x = $('.coupon_question').is(":checked");
      
      
        if(x == true)   
        $(':submit').prop('disabled', false);
            // $(".answer").show();
        else
        $(':submit').prop('disabled', true);
            // $(".answer").hide();
    }
</script>

@endsection
<!-- This section will contain javacsript end -->