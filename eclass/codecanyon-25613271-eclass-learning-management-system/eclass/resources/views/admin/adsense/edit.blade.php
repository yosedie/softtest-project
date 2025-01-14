@extends('admin.layouts.master')
@section('title', 'Adsense Settings - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Adsense Settings';
$data['title'] = 'Site Setting';
$data['title1'] = 'Adsense Settings';
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
                    <h5 class="card-box">{{ __('Adsense Settings') }}</h5>
                </div>                
                <!-- card body started -->
                <div class="card-body">
                <!-- form start -->
				<form action="{{ action('AdsenseController@update') }}" method="POST" enctype="multipart/form-data">
		                {{ csrf_field() }}
		                {{ method_field('PUT') }}
		                <div class="form-group">
			                <label class="text-dark" for="policy">{{ __('Enter Your Adsense Script') }} :<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="code" id="inputTextarea" rows="3" placeholder="{{ __('Enter Your Adsense Script')}}">{{ optional($ad)->code }}</textarea>
			            </div>
			            <br>
			            <div class="row">                              						
                            <div class="form-group col-md-2">
                                <label class="text-dark" for="exampleInputDetails">{{ __('Visible on Home') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" name="ishome"  {{ optional($ad)->ishome == 1 ? 'checked' : '' }} />
                                <input type="hidden"  name="free" value="0" for="status" id="status">
                            </div>    						
                            <div class="form-group col-md-2">
                                <label class="text-dark" for="exampleInputDetails">{{ __('Visible on Cart') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" name="iscart"  {{ optional($ad)->iscart == 1 ? 'checked' : '' }} />
                                <input type="hidden"  name="free" value="0" for="status" id="status">
                            </div>    						
                            <div class="form-group col-md-2">
                                <label class="text-dark" for="exampleInputDetails">{{ __('Visible on Wishlist') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" name="iswishlist"  {{ optional($ad)->iswishlist == 1 ? 'checked' : '' }} />
                                <input type="hidden"  name="free" value="0" for="status" id="status">
                            </div>    						
                            <div class="form-group col-md-2">
                                <label class="text-dark" for="exampleInputDetails">{{ __('Visible on Detail') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" name="isdetail"  {{ optional($ad)->isdetail == 1 ? 'checked' : '' }} />
                                <input type="hidden"  name="free" value="0" for="status" id="status">
                            </div>    						
                            <div class="form-group col-md-2">
                                <label class="text-dark" for="exampleInputDetails">{{ __('Visible on All') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" name="isviewall"  {{ optional($ad)->isviewall == 1 ? 'checked' : '' }} />
                                <input type="hidden"  name="free" value="0" for="status" id="status">
                            </div>    				
                            <div class="form-group col-md-2">
                                <label class="text-dark" for="exampleInputDetails">{{ __('Status') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" name="status" {{ optional($ad)->status == 1 ? 'checked' : '' }} />
                                <input type="hidden"  name="free" value="0" for="status" id="status">
                            </div>  	
    					</div>
						<div class="form-group">
                            <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                            <button type="submit" class="btn btn-primary-rgba" title="{{ __('Save')}}"><i class="fa fa-check-circle"></i>
                                {{ __("Save")}}</button>
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

@endsection
<!-- This section will contain javacsript end -->