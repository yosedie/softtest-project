@extends('admin.layouts.master')
@section('title','Edit Notice Board')
@section('maincontent')
<?php
$data['heading'] = 'Edit Notice Board';
$data['title'] = 'Edit Notice Board';
?>
@include('admin.layouts.topbar',$data)
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="contentbar dashboard-card">
    <div class="row">
        <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Edit') }} {{ __('Notice Board') }}</h5>
                    <div class="widgetbar">
                        <a href="{{ url('course/create/'. $notice->course->id) }}"
                            class="float-right btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{
                            __('Back') }}</a>
                    </div>
                </div>
                <div class="card-body ml-2">
                    <form id="demo-form" method="post" action="{{ route('noticeboard.update', $notice->id) }}"
                        data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                
                        <div class="d-none">
                            <label class="display-none" for="exampleInputSlug">{{ __('SelectCourse') }}</label>
                            <select name="course_id" class="form-control select2">
                                @foreach($courses as $cou)
                                <option value="{{ $cou->id }}" {{ $notice->course_id == $cou->id ? 'selected' : '' }}>{{ $cou->title }}</option>
                                @endforeach
                            </select>
                        </div>
                
                        <div class="row">
                            <div class="col-md-6">
                                <label for="exampleInputTit1e">{{ __('Title') }} :<span class="redstar">*</span></label>
                                <input type="text" class="form-control" name="title" id="exampleInputTitle"
                                    value="{{ old('title', $notice->title) }}">
                                <br>
                            </div>
                            <div class="col-md-12">
                                <label for="exampleInputTit1e">{{ __('Detail') }}: <sup class="redstar">*</sup></label>
                                <textarea id="detail" name="content" rows="3" class="form-control">{{ old('content', $notice->content) }}</textarea>
                            </div>
                        </div>
                
                        <br>
                        <hr>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="exampleInputTit1e">{{ __('Status') }} :</label><br>
                                <label class="switch">
                                    <input class="slider" type="checkbox" name="status" value="1" {{ $notice->status == '1' ? 'checked' : '' }}>
                                    <span class="knob"></span>
                                </label>
                            </div>
                        </div>
                
                        <br>
                        <div class="form-group">
                            <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
                                {{ __('Reset') }}</button>
                            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                {{ __('Update') }}</button>
                        </div>
                        <div class="clear-both"></div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection