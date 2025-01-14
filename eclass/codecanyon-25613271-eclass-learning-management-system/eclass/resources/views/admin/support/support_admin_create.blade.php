@extends('admin.layouts.master')
@section('title', 'Support')
@section('maincontent')
<?php
$data['heading'] = 'Support';
$data['title'] = 'Support';
$data['title1'] = 'Create';

?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    <div class="row">
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $error)
            <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close"
                    title="{{ __('Close') }}">
                    <span aria-hidden="true" style="color:red;">&times;</span></button></p>
            @endforeach
        </div>
        @endif
        <!-- row started -->
        <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box"> {{ __('Add Support') }}</h5>
                    <div>
                        <div class="widgetbar">
                            <a href="{{route('support_admin.index')}}" class="btn btn-primary-rgba"
                                title="{{ __('Back') }}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                        </div>
                    </div>
                </div>
                <!-- card body started -->
                <div class="card-body">
                    <!-- form start -->
                    <form action="{{route('supportadmin.store')}}" class="form" method="POST" novalidate
                        enctype="multipart/form-data">
                        @csrf
                        <!-- row start -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- row start -->
                                <div class="row">
                                    <!-- Title -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-dark">{{ __('Users') }} <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control select2" name="user_id" required>
                                                <option disabled selected>{{__('Select User')}}</option>
                                                @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->fname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-dark">{{ __('Support Category') }} <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control select2" name="category" required>
                                                <option disabled selected>{{__('Select Support')}}</option>
                                                @foreach ($supporttype as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-dark">{{ __('Support Priority') }} <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control select2" name="priority" required>
                                                <option value="Low" selected>{{__('Low')}}</option>
                                                <option value="Normal">{{__('Normal')}}</option>
                                                <option value="High">{{__('High')}}</option>
                                                <option value="Critical">{{__('Critical')}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label class="text-dark">{{ __('Subject') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" value="{{ old('title') }}" autofocus=""
                                                class="form-control @error('title') is-invalid @enderror"
                                                placeholder="{{ __('Enter subject') }}" name="subject" required="">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-dark">{{ __('Issue Image') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" value="{{ old('title') }}" autofocus=""
                                                class="form-control @error('title') is-invalid @enderror"
                                                placeholder="{{ __('Enter subject') }}" name="image">
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{__('Message')}}</label>
                                            <textarea class="form-control" name="message" id="message" cols="30"
                                                rows="5" placeholder="{{__('Please enter your message')}}"
                                                required></textarea>
                                        </div>
                                    </div>

                                    <!-- create and close button -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="reset" class="btn btn-danger-rgba mr-1"
                                                title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{
                                                __("Reset")}}</button>
                                            <button type="submit" class="btn btn-primary-rgba"
                                                title="{{ __('Create') }}"><i class="fa fa-check-circle"></i>
                                                {{ __("Create")}}</button>
                                        </div>
                                    </div>
                                </div><!-- row end -->
                            </div><!-- col end -->
                        </div><!-- row end -->
                    </form>
                    <!-- form end -->
                </div><!-- card body end -->
            </div><!-- col end -->
        </div>
    </div>
</div><!-- row end -->
@endsection