@extends('admin.layouts.master')
@section('title', 'Edit Instructor Plan- Admin')
@section('maincontent')
<?php
$data['heading'] = 'Edit Instructors Plan';
$data['title'] = 'Edit Instructors Plan';
$data['title1'] = 'Edit Instructors Plan Edit';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    <div class="row">
        <div class="col-lg-12">
          <div class="card dashboard-card m-b-30">
            <div class="card-header">
              <h5 class="card-title">{{ __('Edit Instructors Plan Edit') }}</h5>
              <div>
                <div class="widgetbar">
                  <a href="{{url('subscription/plan')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back')}}</a>
                    </div>                        
              </div>
            </div>
            <div class="card-body">
          
                <div class="form-group">
                    <form action="{{ url('subscription/plan', $plans->id) }}" method="post"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <label for="exampleInputTit1e">{{ __('Plan Name') }}:<sup
                                        class="redstar">*</sup></label>
                                <input type="text" class="form-control" name="title" id="exampleInputTitle"
                                    value="{{ $plans->title }}">
                            </div>    
                            <div class="col-lg-3 col-md-6">                          
                                <label for="exampleInputSlug">{{ __('Image') }}:<sup class="redstar">*</sup></label><br>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                  </div>
                                  <div class="custom-file">
                                    <input accept="image/*" type="file" name="preview_image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                                  </div>
                                
                                </div>
                            </div>
                            <div class="col-md-2">
                                @if ($plans['preview_image'] !== null && $plans['preview_image'] !== '')
                                    <img src="{{ url('/images/plan/'.$plans->preview_image) }}" class="img-responsive image_size" />
                                @else
                                    <img src="{{ Avatar::create($plans->title)->toBase64() }}" alt="course"
                                        class="img-fluid">
                                @endif
                                
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label for="exampleInputSlug">{{ __('No. Courses Allowed to create in plan') }}:</label>
                                <input min="1" class="form-control" name="courses_allowed" type="number" id="courses_allowed"  placeholder="" value="{{ $plans->courses_allowed }}">
                            </div>                          
                        </div>



                        <div class="row">

                            <div class="col-md-12">
                                <label for="exampleInputDetails">{{ __('Plan Details') }}:<sup class="redstar">*</sup></label>
                                <textarea id="detail" name="detail" rows="3" class="form-control"
                                    required>{!!  $plans->detail !!}</textarea>
                            </div>
                        </div>
                        <br>

                        <div class="row">

                            <div class="col-md-4">
                                <label for="exampleInputDetails">{{ __('Paid') }}:</label><br>  
                                  <label class="switch">
                                    <input class="slider" type="checkbox" id="customSwitch2" name="type" {{ $plans->type == '1' ? 'checked' : '' }} />
                                    <span class="knob"></span>
                                  </label>
                                 
                                  <br>     

                                  <div style="{{ $plans->type == 1 ? '' : 'display:none' }}" id="doabox">
                                    <label for="exampleInputSlug">{{ __('Price') }}: <sup class="redstar">*</sup></label>
                                    <input step="0.01" type="text" inputmode="numeric" pattern="[-+]?[0-9]*[.,]?[0-9]+"  class="form-control" name="price" id="exampleInputPassword1" placeholder="{{ __('Enter') }} {{ __('Price') }}" value="{{ $plans->price }}">
                                 
                                  <br>
                                    <label for="exampleInputSlug">{{ __('Discount Price') }}: <sup class="redstar">*</sup></label>
                                    <input step="0.01" type="text" inputmode="numeric" pattern="[-+]?[0-9]*[.,]?[0-9]+" class="form-control" name="discount_price" id="exampleInputPassword1" placeholder="{{ __('Enter') }} {{ __('DiscountPrice') }}" value="{{ $plans->discount_price }}">
                                  </div>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="exampleInputDetails">{{ __('Status') }}:</label><br>
                
              
                                <input id="status_toggle" type="checkbox" class="custom_toggle" name="status" {{ $plans->status == '1' ? 'checked' : '' }} />
                                <input type="hidden"  name="free" value="0" for="status" id="status">
                            </div>

                           
                       
                            <div class="col-md-4">
                                <label for="">{{ __('Duration') }}: </label><br>
                                <label class="switch">
                                    <input class="slider" type="checkbox" name="duration_type" {{ $plans->duration_type == "m" ? 'checked' : '' }} />
                                    <span class="knob"></span>
                                </label>
                                <br>
                                <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('If enabled duration can be in months') }}.</small><br>
                                <small class="text-info"> {{ __('when Disabled duration can be in days') }}.</small>
                                  
                                <br>
                                <label for="exampleInputSlug">{{ __('Plan Expire Duration') }}</label>
                                <input min="1" class="form-control" name="duration" type="number" id="duration" value="{{ $plans->duration }}" placeholder="{{ __('Enter') }} {{ __('Duration') }}">


                             
                            </div>
                        </div>

                        <br>

                        <!--Stripe Subscription-->
                        <div class="row">
                          
                          
                            
                        </div>

                        <br>
                        <!--Stripe Subscription-->
                        <div class="box-footer">
                            <button type="submit"
                                class="btn btn-lg col-md-3 btn-primary-rgba">{{ __('Save') }}</button>
                        </div>

                    </form>
                </div>
            </div>
            <!-- /.box -->
          </div>
        </div>
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
</div>

@endsection




@section('script')

    <script>
        (function($) {
            "use strict";

            $('#customSwitch2').change(function(){
                if($('#customSwitch2').is(':checked')){
                  $('#doabox').show('fast');
                }else{
                  $('#doabox').hide('fast');
                }

              });


            $(function() {
                $('.js-example-basic-single').select2();
            });

            $(function() {
                $('#cb1').change(function() {
                    $('#f').val(+$(this).prop('checked'))
                })
            })

            $(function() {
                $('#cb3').change(function() {
                    $('#test').val(+$(this).prop('checked'))
                })
            })

            $(function() {

                $('#murl').change(function() {
                    if ($('#murl').val() == 'yes') {
                        $('#doab').show();
                    } else {
                        $('#doab').hide();
                    }
                });

            });

            $(function() {

                $('#murll').change(function() {
                    if ($('#murll').val() == 'yes') {
                        $('#doabb').show();
                    } else {
                        $('#doab').hide();
                    }
                });

            });

            $('#preview').on('change', function() {

                if ($('#preview').is(':checked')) {
                    $('#document1').show('fast');
                    $('#document2').hide('fast');

                } else {
                    $('#document2').show('fast');
                    $('#document1').hide('fast');
                }

            });

        })(jQuery);

    </script>

@endsection
