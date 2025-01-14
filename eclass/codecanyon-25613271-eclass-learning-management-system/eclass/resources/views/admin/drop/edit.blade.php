@extends('admin.layouts.master')
@section('title', 'Edit All Dropdown Settings - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Create All Dropdown Settings';
$data['title'] = 'Site Setting';
$data['title1'] = 'All Dropdown Settings';
$data['title2'] = 'Edit All Dropdown Settings';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar bardashboard-card">
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)
        <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close')}}">
                <span aria-hidden="true" class="text-danger">&times;</span></button></p>
        @endforeach
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Dropdown Settings') }}</h5>
                    <div>
                        <div class="widgetbar">
                        <a href="{{url('dropdown')}}" class="btn btn-primary-rgba" title="{{ __('Back') }}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('dropdown.update',$dsetting->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @method("PUT")
                        @csrf
                        <div class="row">
                        <div class="form-group col-md-6">
                            <label class="text-dark" for="city_id">{{ __('Select User Role') }}: </label>
                            <select  class="form-control select2" name="role_id">
                              <option value="none" selected disabled hidden>
                                {{ __('Please Select an Option') }}
                              </option>
                              @foreach ($roles as $role)
                              <option value="{{ $role->id }}" {{ $dsetting->role_id == $role->role_id ? 'selected' : ''}}>{{ $role->name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label class="text-dark">{{ __('My Courses') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" id="customSwitch1" name="my_courses"
                                    {{ $dsetting->my_courses == 1 ? 'checked' : '' }} />
                            </div>
                            <div class="form-group col-md-2">
                                <label class="text-dark">{{ __('My Wishlist ') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" id="customSwitch2" name="my_wishlist"
                                    {{ $dsetting->my_wishlist == 1 ? 'checked' : '' }} />
                            </div>
                            <div class="form-group col-md-2">
                                <label class="text-dark">{{ __('Purchased History') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" id="customSwitch3" name="purchased_history"
                                    {{ $dsetting->purchased_history == 1 ? 'checked' : '' }} />
                            </div>
                            <div class="form-group col-md-2">
                                <label class="text-dark">{{ __('My Profile') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" id="customSwitch4" name="my_profile"
                                    {{ $dsetting->my_profile == 1 ? 'checked' : '' }} />
                            </div>
                            <div class="form-group col-md-2">
                                <label class="text-dark">{{ __('Flash Deal ') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" id="customSwitch5" name="flash_deal"
                                    {{ $dsetting->flash_deal == 1 ? 'checked' : '' }} />
                            </div>
                            <div class="form-group col-md-2">
                                <label class="text-dark">{{ __('Donation') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" id="customSwitch6" name="donation"
                                    {{ $dsetting->donation == 1 ? 'checked' : '' }} />
                            </div>
                            <div class="form-group col-md-2">
                                <label class="text-dark">{{ __('My Wallet') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" id="customSwitch7" name="my_wallet"
                                    {{ $dsetting->my_wallet == 1 ? 'checked' : '' }} />
                            </div>
                            <div class="form-group col-md-2">
                                <label class="text-dark">{{ __('Affiliate') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" id="customSwitch8" name="affilate"
                                    {{ $dsetting->affilate == 1 ? 'checked' : '' }} />
                            </div>
                            <div class="form-group col-md-2">
                                <label class="text-dark">{{ __('Compare') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" id="customSwitch9" name="compare"
                                    {{ $dsetting->compare == 1 ? 'checked' : '' }} />
                            </div>
                            <div class="form-group col-md-2">
                                <label class="text-dark">{{ __('Search Job') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" id="customSwitch10" name="search_job"
                                    {{ $dsetting->search_job == 1 ? 'checked' : '' }} />
                            </div>
                            <div class="form-group col-md-2">
                                <label class="text-dark">{{ __('Job Portal') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" id="customSwitch11" name="job_portal"
                                    {{ $dsetting->job_portal == 1 ? 'checked' : '' }} />
                            </div>
                            <div class="form-group col-md-2">
                                <label class="text-dark">{{ __('Forum and discussion') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" id="customSwitch12" name="form_enable"
                                    {{ $dsetting->form_enable == 1 ? 'checked' : '' }} />
                            </div>
                            <div class="form-group col-md-2">
                                <label class="text-dark">{{ __('My Leadership') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" id="customSwitch13" name="my_leadership"
                                    {{ $dsetting->my_leadership == 1 ? 'checked' : '' }} />
                            </div>
                            <div class="form-group col-md-2">
                                <label class="text-dark">{{ __('Affiliate Dashboard') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" id="customSwitch14" name="affilate_dashboard"
                                    {{ $dsetting->affilate_dashboard == 1 ? 'checked' : '' }} />
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i>
                                {{ __("Reset")}}</button>
                            <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update')}}"><i class="fa fa-check-circle"></i>
                                {{ __("Update")}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection