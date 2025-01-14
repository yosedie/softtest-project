@extends('admin.layouts.master')
@section('title','Edit Subcategories')
@section('maincontent')

@component('components.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __('Admin') }}
@endslot

@slot('menu2')
{{ __(' Edit Subcategories') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <a href="{{ url('subcategory') }}" class="float-right btn btn-primary mr-2" title="{{ __('Back') }}"
><i
      class="feather icon-arrow-left mr-2"></i>{{__('Back')}}</a>
</div>
@endslot

@endcomponent
<div class="contentbar dashboard-card">
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-box">{{ __('Edit') }} {{ __('Subcategories') }}</h5>
        </div>
        <div class="card-body ml-2">
          <form id="demo-form" method="post" action="{{url('subcategory/'.$cate->id)}}
            " data-parsley-validate class="form-horizontal form-label-left" autocomplete="off">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="row">

          <div class="col-md-6">
            <label for="exampleInputSlug">{{ __('SelectCategory') }}</label>
            <select name="category_id" class="form-control select2">
  
              @foreach($category as $cou)
               <option value="{{ $cou->id }}" {{$cate->category_id == $cou->id  ? 'selected' : ''}}>{{ $cou->title}}</option>
              @endforeach
            </select>
          </div>
        
          <div class="col-md-6">
            <label for="exampleInputTit1e">{{ __('SubCategory') }}:<span class="redstar">*</span></label>
            <input type="title" class="form-control" name="title" id="exampleInputTitle" value="{{$cate->title}}">
          </div>
        </div>
        <br>
        <div class="row">

          <div class="col-md-6">
          <label for="exampleInputTit1e">{{ __('Slug') }}:<sup class="redstar">*</sup></label>
          <input pattern="[/^\S*$/]+" type="text" class="form-control" name="slug" id="exampleInputTitle" placeholder="Enter slug" value="{{$cate->slug}}">
        </div>


          <div class="col-md-6">
            <label for="icon">{{ __('Icon') }}:<span class="redstar"></span></label>
            
            <div class="input-group">
                  <input type="text" class="form-control iconvalue" name="icon" value="{{$cate->icon}}">
                  <span class="input-group-append">
                      <button  type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                  </span>
              </div>
          </div>
          
          
         
        </div>
        <br>

         <div class="row">

          <div class="col-md-6">
            <label for="exampleInputDetails">{{ __('Status') }}:<sup
              class="redstar text-danger">*</sup></label><br>
          <input id="status" type="checkbox" class="custom_toggle" {{ $cate->status == '1' ? 'checked' : '' }} name="status" />
          
          </div>
        </div>
        <br>



        <div class="form-group">
          <button type="reset" class="btn btn-danger" title="{{ __('Reset') }}"
><i class="fa fa-ban"></i>
            {{__('Reset')}}</button>
          <button type="submit" class="btn btn-primary" title="{{ __('Update') }}"
><i class="fa fa-check-circle"></i>
            {{__('Update')}}</button>
        </div>
   
  <div class="clear-both"></div>
      </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
