@extends('admin.layouts.master')
@section('title', 'Front Theme Color Settings')
@section('maincontent')
<?php
$data['heading'] = 'Front Theme Color Settings';
$data['title'] = 'Front Theme Settings';
$data['title1'] = 'Front Theme Color Settings';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    <div class="row">
@if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
   <!-- row started -->
    <div class="col-lg-12">
        <div class="card dashboard-card m-b-30">
             <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Front Theme Color Settings') }}</h5>
                    <div>
                        <div class="widgetbar">                           
                            <a href="{{ route('coloroption.reset') }}" class="btn btn-danger-rgba" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __("Reset")}}</a>
                          
                                <a href="{{url('theme/settings')}}" class="btn btn-primary-rgba" title="{{ __('Back') }}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                            </div>                        
                      </div>
                </div> 
                <!-- card body started -->
                <div class="card-body">
                 <!-- form start -->
				  <form action="{{ url('admin/coloroption/update') }}" method="POST" enctype="multipart/form-data">
		                @csrf
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
                                                    
                                                    <!-- BlueBackground -->
													
												
                                                    <div class="col-md-3">
													
                                                        <div class="form-group">
															<label class="text-dark" for="blue_bg">{{ __('Blue Background') }}:</label>
															<input name="blue_bg" class="form-control" type="color" value="{{ optional($color)['blue_bg'] }}"/>
															
														
                                                        </div>
                                                    </div>

                                                    <!-- image 1 -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
															<img src="{{ url('images/screenshot/18.png') }}" class="img-thumbnail" width="400px" height="400px">
                                                        </div>
                                                    </div>

													<!-- RedBackground -->
													<div class="col-md-3">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Red Background') }} :</label>
															<input name="red_bg" class="form-control" type="color" value="{{ optional($color)['red_bg'] }}"/>
														
                                                        </div>
                                                    </div>

                                                    <!-- image 2 -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
															<img src="{{ url('images/screenshot/19.png') }}" class="img-thumbnail" width="400px" height="400px">
                                                        </div>
                                                    </div>

													<!-- Grey Background -->
													<div class="col-md-3">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Grey Background') }} :</label>
																<input name="grey_bg" class="form-control" type="color" value="{{ optional($color)['grey_bg'] }}"/>
															
                                                        </div>
                                                    </div>

                                                    <!-- image 3 -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
															<img src="{{ url('images/screenshot/15.png') }}" class="img-thumbnail" width="400px" height="400px">
                                                        </div>
                                                    </div>

													<!-- Light Grey Background -->
													<div class="col-md-3">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Light Grey Background') }} :</label>
															
																<input name="light_grey_bg" class="form-control" type="color" value="{{ optional($color)['light_grey_bg'] }}"/>
														
                                                        </div>
                                                    </div>

                                                    <!-- image 4 -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
															<img src="{{ url('images/screenshot/17.png') }}" class="img-thumbnail" width="400px" height="400px">
                                                        </div>
                                                    </div>

													<!-- Black Background -->
													<div class="col-md-3">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Black Background') }} :</label>
															
															<input name="black_bg" class="form-control" type="color" value="{{ optional($color)['black_bg'] }}"/>
															
														
                                                        </div>
                                                    </div>

                                                    <!-- image 5 -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
															<img src="{{ url('images/screenshot/16.png') }}" class="img-thumbnail" width="400px" height="400px">
                                                        </div>
                                                    </div>

													<!-- White Background -->
													<div class="col-md-3">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('White Background') }} :</label>
																<input name="white_bg" class="form-control" type="color" value="{{ optional($color)['white_bg'] }}"/>
																
														
                                                        </div>
                                                    </div>

                                                    <!-- image 6 -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
															
                                                        </div>
                                                    </div>

													<!-- Deep Red Background -->
													<div class="col-md-3">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Deep Red Background') }} :</label>
																<input name="dark_red_bg" class="form-control" type="color" value="{{ optional($color)['dark_red_bg'] }}"/>
																
															
                                                        </div>
                                                    </div>

                                                    <!-- image 7 -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
														<img src="{{ url('images/screenshot/14.png') }}" class="img-thumbnail" width="400px" height="400px">
                                                        </div>
                                                    </div>

                                                  </div><!-- row end -->
                                              </div><!-- col end -->
                                          </div>
										  <hr>
										  <!-- row end -->

										   <!-- row start -->
										   <div class="row">
                                              
                                              <div class="col-md-12">
                                                  <!-- row start -->
												  <div>
                                                  <h5 class="card-title">{{ __('Text Colors Settings') }}</h5>
												    </div>
                                                  <div class="row">
                                                    
													<!-- Text Color Background -->
													<div class="col-md-3">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Black Text') }} :</label>
																<input name="black_text" class="form-control" type="color" value="{{ optional($color)['black_text'] }}"/>
														
                                                        </div>
                                                    </div>

                                                    <!-- image 7 -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
														<img src="{{ url('images/screenshot/12.png') }}" class="img-thumbnail" width="400px" height="400px">
                                                        </div>
                                                    </div>

													<!-- Light Grey Text -->
													<div class="col-md-3">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Light Grey Text') }} :</label>
																<input name="light_grey_text" class="form-control" type="color" value="{{ optional($color)['black_text'] }}"/>
															
                                                        </div>
                                                    </div>

                                                    <!-- image 8 -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
														<img src="{{ url('images/screenshot/11.png') }}" class="img-thumbnail" width="400px" height="400px">
                                                        </div>
                                                    </div>

													<!-- Dark Grey Text -->
													<div class="col-md-3">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Dark Grey Text') }} :</label>
																<input name="dark_grey_text" class="form-control" type="color" value="{{ optional($color)['dark_grey_text'] }}"/>
															
                                                        </div>
                                                    </div>

                                                    <!-- image 9 -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
														<img src="{{ url('images/screenshot/10.png') }}" class="img-thumbnail" width="400px" height="400px">
                                                        </div>
                                                    </div>

													<!-- Red Text -->
													<div class="col-md-3">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Red Text') }} :</label>
															<input name="red_text" class="form-control" type="color" value="{{ optional($color)['red_text'] }}"/>
															
                                                        </div>
                                                    </div>

                                                    <!-- image 10 -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
														<img src="{{ url('images/screenshot/9.png') }}" class="img-thumbnail" width="400px" height="400px">
                                                        </div>
                                                    </div>

													<!-- Blue Text -->
													<div class="col-md-3">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Blue Text') }} :</label>
															<input name="blue_text" class="form-control" type="color" value="{{ optional($color)['blue_text'] }}"/>
															
                                                        </div>
                                                    </div>

                                                    <!-- image 11 -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
														<img src="{{ url('images/screenshot/8.png') }}" class="img-thumbnail" width="400px" height="400px">
                                                        </div>
                                                    </div>

													<!-- Dark Blue Text -->
													<div class="col-md-3">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Dark Blue Text') }} :</label>
															<input name="dark_blue_text" class="form-control" type="color" value="{{ optional($color)['dark_blue_text'] }}"/>
															
                                                        </div>
                                                    </div>

                                                    <!-- image 12 -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
														<img src="{{ url('images/screenshot/8.png') }}" class="img-thumbnail" width="400px" height="400px">
                                                        </div>
                                                    </div>

													<!-- White Text -->
													<div class="col-md-3">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('White Text') }} :</label>
																<input name="white_text" class="form-control" type="color" value="{{ optional($color)['white_text'] }}"/>
															
                                                        </div>
                                                    </div>

                                                    <!-- image 13 -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
														<img src="{{ url('images/screenshot/6.png') }}" class="img-thumbnail" width="400px" height="400px">
                                                        </div>
                                                    </div>
                                                    

                                                  </div><!-- row end -->
                                              </div><!-- col end -->
                                          </div>
										  <hr>
										  <!-- row end -->
											
										     <!-- row start -->
											 <div class="row">
                                              
                                              <div class="col-md-12">
                                                  <!-- row start -->
												    <div>
                                                    <h5 class="card-title">{{ __('Gradient Background Colors Settings') }}</h5>
													</div>
                                                  <div class="row">
                                                    
													<!-- Gradient Background Color -->
													<div class="col-md-4">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Gradient Background') }} :</label>
																<input name="linear_bg_one" class="form-control" type="color" value="{{ optional($color)['linear_bg_one'] }}"/>
															
                                                        </div>
                                                    </div>

													<!-- Gradient Background Color -->
													<div class="col-md-4">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Gradient Background') }} :</label>
															<input name="linear_bg_two" class="form-control" type="color" value="{{ optional($color)['linear_bg_two'] }}"/>
															
                                                        </div>
                                                    </div>

                                                    <!-- image 14 -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
														<img src="{{ url('images/screenshot/6.png') }}" class="img-thumbnail" width="400px" height="400px">
                                                        </div>
                                                    </div>
                                                                  
                                                  </div><!-- row end -->
                                              </div><!-- col end -->
                                          </div>
                                          <hr>
										  <!-- row end -->

                                            <!-- Reverse Background Gradient Color -->
                                            <!-- row start -->
											 <div class="row">
                                              
                                              <div class="col-md-12">
                                                  <!-- row start -->
												    <!-- <div>
                                                    <h5 class="card-title">{{ __('Reverse Background Gradient Color') }}</h5>
													</div> -->
                                                  <div class="row">
                                                    
													<!-- Gradient Background Color -->
													<div class="col-md-4">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Gradient Background') }} :</label>
																<input name="linear_reverse_bg_one" class="form-control" type="color" value="{{ optional($color)['linear_reverse_bg_one'] }}"/>
															
                                                        </div>
                                                    </div>

													<!-- Gradient Background Color -->
													<div class="col-md-4">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Gradient Background') }} :</label>
															<input name="linear_reverse_bg_two" class="form-control" type="color" value="{{ optional($color)['linear_reverse_bg_two'] }}"/>
															
                                                        </div>
                                                    </div>

                                                    <!-- image 15 -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
														<img src="{{ url('images/screenshot/2.png') }}" class="img-thumbnail" width="400px" height="400px">
                                                        </div>
                                                    </div>

                                                  </div><!-- row end -->
                                              </div><!-- col end -->
                                          </div>
                                          <hr>
										  <!-- row end -->

                                          <!-- About Gradient Background Color -->
                                            <!-- row start -->
											 <div class="row">
                                              
                                              <div class="col-md-12">
                                                  <!-- row start -->
												    <!-- <div>
                                                    <h5 class="card-title">{{ __('About Gradient Background Color') }}</h5>
													</div> -->
                                                  <div class="row">
                                                    
													<!-- Gradient Background Color -->
													<div class="col-md-4">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Gradient Background') }} :</label>
																<input name="linear_about_bg_one" class="form-control" type="color" value="{{ optional($color)['linear_about_bg_one'] }}"/>
															
                                                        </div>
                                                    </div>

													<!-- Gradient Background Color -->
													<div class="col-md-4">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Gradient Background') }} :</label>
															<input name="linear_about_bg_two" class="form-control" type="color" value="{{ optional($color)['linear_about_bg_two'] }}"/>
															
                                                        </div>
                                                    </div>

                                                    <!-- image 16 -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
														<img src="{{ url('images/screenshot/3.png') }}" class="img-thumbnail" width="400px" height="400px">
                                                        </div>
                                                    </div>

                                                  </div><!-- row end -->
                                              </div><!-- col end -->
                                          </div>
										  <!-- row end -->

                                            <!--About Gradient Background Color Two -->
                                            <!-- row start -->
											 <div class="row">
                                              
                                              <div class="col-md-12">
                                                  <!-- row start -->
												    <!-- <div>
                                                    <h5 class="card-title">{{ __('About Gradient Background Color Two') }}</h5>
													</div> -->
                                                  <div class="row">
                                                    
													<!-- Gradient Background Color -->
													<div class="col-md-4">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Gradient Background') }} :</label>
															<input name="linear_about_bluebg_one" class="form-control" type="color" value="{{ optional($color)['linear_about_bluebg_one'] }}"/>
															
                                                        </div>
                                                    </div>

													<!-- Gradient Background Color -->
													<div class="col-md-4">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Gradient Background') }} :</label>
																<input name="linear_about_bluebg_two" class="form-control" type="color" value="{{ optional($color)['linear_about_bluebg_two'] }}"/>
															
                                                        </div>
                                                    </div>

                                                    <!-- image 16 -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
														<img src="{{ url('images/screenshot/4.png') }}" class="img-thumbnail" width="400px" height="400px">
                                                        </div>
                                                    </div>

                                                  </div><!-- row end -->
                                              </div><!-- col end -->
                                          </div>
                                          <hr>
										  <!-- row end -->

                                           <!--Career Gradient Background Color -->
                                            <!-- row start -->
											 <div class="row">
                                              
                                              <div class="col-md-12">
                                                  <!-- row start -->
												    <!-- <div>
                                                    <h5 class="card-title">{{ __('Career Gradient Background Color') }}</h5>
													</div> -->
                                                  <div class="row">
                                                    
													<!-- Gradient Background Color -->
													<div class="col-md-4">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Gradient Background') }} :</label>
															<input name="linear_career_bg_one" class="form-control" type="color" value="{{ optional($color)['linear_career_bg_one'] }}"/>
															
                                                        </div>
                                                    </div>

													<!-- Gradient Background Color -->
													<div class="col-md-4">
                                                        <div class="form-group">
															<label class="text-dark" for="red_bg">{{ __('Gradient Background') }} :</label>
															<input name="linear_career_bg_two" class="form-control" type="color" value="{{ optional($color)['linear_career_bg_two'] }}"/>
															
                                                        </div>
                                                    </div>

                                                    <!-- image 16 -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
														<img src="{{ url('images/screenshot/5.png') }}" class="img-thumbnail" width="400px" height="400px">
                                                        </div>
                                                    </div>
                                                                  
                                                    <!-- update and reset button -->
                                                    <div class="col-md-12">
                                                        <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                        <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update') }}"><i class="fa fa-check-circle"></i>
                                                            {{ __("Update")}}</button>
                                                    </div>
                                                   

                                                  </div><!-- row end -->
                                              </div><!-- col end -->
                                          </div>
										  <!-- row end -->



                                    </div><!-- card body end -->
                                </div><!-- card end -->
                            </div><!-- col end -->
                        </div><!-- row end -->
                  </form>
                  <!-- form end -->
                </div><!-- card body end -->
            
        </div><!-- col end -->
    </div>
</div>
</div><!-- row end -->
    <br><br>
@endsection
<!-- main content section ended -->
