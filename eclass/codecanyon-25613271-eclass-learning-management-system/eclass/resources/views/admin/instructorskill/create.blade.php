@extends('admin.layouts.master')
@section('title', 'Add Instructorskill - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Instructorskill';
$data['title'] = 'Instructorskill';
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
                    <h5 class="card-box"> {{ __('Add') }} {{ __('Instructorskill') }}</h5>
                    <div>
                        <div class="widgetbar">
                            <a href="{{url('instructor/skills')}}" class="btn btn-primary-rgba"><i
                                    class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                        </div>
                    </div>
                </div>

                <!-- card body started -->
                <div class="card-body">

                    <!-- form start -->
                    <form action="{{action('InstructorskillController@store')}}" class="form" method="POST" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            
                                                    <!-- Title -->
                                                    <div class="form-group col-md-12">
                                                        <label>{{__("Select Instructor:")}} <span
                                                                class="text-danger">*</span></label>
                                                        <select required="" class="form-control select2"
                                                            name="instructor_id">
                                                            @foreach($data as $datas)
                                                            <option value="{{$datas->id }}">{{ $datas->fname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Description -->

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Skills') }}: <span
                                                                    class="text-danger">*</span></label>
                                                            <textarea id="detail" name="skills"
                                                                class="@error('skills') is-invalid @enderror"
                                                                placeholder="Please Enter Skills"
                                                                required="">{{ old('skills') }}</textarea>
                                                            @error('skills')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <!-- create and close button -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="reset" class="btn btn-danger-rgba mr-1"><i
                                                                    class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                            <button type="submit" class="btn btn-primary-rgba"><i
                                                                    class="fa fa-check-circle"></i>
                                                                {{ __("Create")}}</button>
                                                        </div>
                                                    </div>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection