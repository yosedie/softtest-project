@extends('admin.layouts.master')
@section('title', 'Alumini  - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Edit Alumni';
$data['title'] = 'Alumni';
$data['title1'] = 'Edit Alumni';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)
        <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
                <span aria-hidden="true" class="text-danger">&times;</span></button></p>
        @endforeach
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Edit Alumni') }}</h5>
                    <div>
                        <div class="widgetbar">
                          <a href="{{url('alumini')}}" class="btn btn-primary-rgba" title="{{ __('Back') }}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                      
                        </div>
                      </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card-body">
                            <form action="{{ route('alumini.update',$data->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @method("PUT")
                                @csrf
                                <div class="form-group">
                                    <label class="text-dark" for="city_id">{{ __('Select Alumni') }}: </label>
                                    <select  class="form-control select2" name="user_id">
                                      <option value="none" selected disabled hidden>
                                        {{ __('Please Select an Option') }}
                                      </option>
                                      @foreach ($users as $user)
                                      <option value="{{ $user->id }}" {{ $data->user_id == $user->id ? 'selected' : ''}}>{{ $user->fname }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                <div class="form-group">
                                    <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i>
                                        {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update') }}"><i class="fa fa-check-circle"></i>
                                        {{ __("Update")}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection