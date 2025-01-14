@extends('admin.layouts.master')
@section('title', 'Homepage Setting - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Homepage Setting';
$data['title'] = 'Homepage Setting';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)
        <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" class="text-danger">&times;</span></button></p>
        @endforeach
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Homepage Setting') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form" action="{{ route('homepage.update') }}" method="POST" novalidate
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Fact Setting') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch1" name="fact_enable" {{ $hsetting->fact_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Discounted Courses') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch2" name="discount_enable"  {{ $hsetting->discount_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Purchased Courses') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                         <input type="checkbox" class="custom_toggle" id="customSwitch3" name="purchase_enable" {{ $hsetting->purchase_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Recently Added') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch4" name="recentcourse_enable" {{ $hsetting->recentcourse_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Featured Courses') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch5" name="featured_enable" {{ $hsetting->featured_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Bundle Courses') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch6" name="bundle_enable" {{ $hsetting->bundle_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Best Selling Courses') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch7" name="bestselling_enable" {{ $hsetting->bestselling_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Featured Instructor') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch8" name="batch_enable" {{ $hsetting->batch_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Live Meetings') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch9" name="livemeetings_enable" {{ $hsetting->livemeetings_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Blogs') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch10" name="blog_enable" {{ $hsetting->blog_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Became an Instructor') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch11" name="became_enable" {{ $hsetting->became_enable == 1 ? 'checked' : '' }} />\
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Featured Categories') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch12" name="featuredcategories_enable" {{ $hsetting->featuredcategories_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Testimonial') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch13" name="testimonial_enable" {{ $hsetting->testimonial_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Video Setting') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch14" name="video_enable" {{ $hsetting->video_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Instructor') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch15" name="instructor_enable" {{ $hsetting->instructor_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Trusted by Companies') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch16" name="trusted_enable" {{ $hsetting->trusted_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('newsletter') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch17" name="newsletter_enable" {{ $hsetting->newsletter_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Discount Badges') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch18" name="discount_badget_enable" {{ $hsetting->discount_badget_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "row">
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Institute') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch18" name="institute_enable" {{ $hsetting->institute_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Get Started') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch18" name="get_enable" {{ $hsetting->get_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Service Enable') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch18" name="service_enable" {{ $hsetting->service_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-dark">{{ __('Feature Enable') }} :</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="checkbox" class="custom_toggle" id="customSwitch18" name="feature_enable" {{ $hsetting->feature_enable == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="form-group">
                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i>
                        {{ __("Reset")}}</button>
                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                        {{ __("Update")}}</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection