@extends('admin.layouts.master')
@section('title','Edit Course')
@section('maincontent')

@component('components.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __('Admin') }}
@endslot

@slot('menu2')
{{ __(' Edit Course') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <a href="{{ url('category') }}" class="float-right btn btn-primary mr-2"><i class="feather icon-arrow-left mr-2"></i>{{__('Back')}}</a>
</div>
@endslot
@endcomponent
<div class="contentbar dashboard-card">
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-box">{{ __('Edit') }} {{ __('Categories') }}</h5>
        </div>
        <div class="card-body ml-2">
          <form id="demo-form" method="post" action="{{url('category/'.$cate->id)}}
            " data-parsley-validate class="form-horizontal form-label-left" autocomplete="off"
            enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="exampleInputTit1e">{{ __('Category') }}:<sup
                      class="redstar">*</sup></label>
                  <input type="text" class="form-control" name="title" id="exampleInputTitle" value="{{$cate->title}}">
                </div>

                <div class="form-group">
                  <label for="slug">{{ __('Slug') }}:<sup class="redstar">*</sup></label>
                  <input pattern="[/^\S*$/]+" placeholder="Enter slug" type="text" class="form-control" name="slug"
                    required value="{{$cate->slug}}">
                </div>
                <div class="form-group">
                  <label for="exampleInputTit1e">{{ __('Icon') }}:<sup class="redstar"></sup></label>
                 <div class="input-group">
                  <input type="text" class="form-control iconvalue" name="icon" value="{{$cate->icon}}">
                  <span class="input-group-append">
                      <button  type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                  </span>
              </div>
                  
               
             
                </div>
                
                <div class="row">
                <div class="form-group col-md-6">
                  <label for="exampleInputDetails">{{ __('Status') }}:<sup
                      class="redstar text-danger">*</sup></label><br>
                  <input id="status" type="checkbox" class="custom_toggle" {{ $cate->status == '1' ? 'checked' : '' }}  name="status" />
                
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputDetails">{{ __('Featured') }}:<sup
                      class="redstar text-danger">*</sup></label><br>
                  <input id="featured" type="checkbox" class="custom_toggle" {{ $cate->featured == '1' ? 'checked' : '' }} name="featured" />
                
                </div>
              </div>

                <div class="form-group">
                  <label>{{ __('PreviewImage') }}:</label> - <p class="inline info">{{__('size: 255x200')}}</p>
                  <br>
                     <label>{{ __('Image') }}:<sup class="redstar"></sup></label>
                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Recommended size') }} (1375 x 409px)</small>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupFileAddon01">{{__('Upload')}}</span>
                      </div>
                      <div class="custom-file">
                        <input accept="image/*" type="file" class="custom-file-input" id="inputGroupFile01" name="image" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="inputGroupFile01">{{__('Choose file')}}</label>
                      </div>
                    </div>
                   
                      @if(isset($cate['cat_image']))
                      <img src="{{ url('/images/category/'.$cate['cat_image']) }}" class="image_size" />
                      @endif 
                    </div>
                </div>
                 
               
                <div class="form-group">
                  <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
                    {{__('Reset')}}</button>
                  <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                    {{__('Update')}}</button>

                </div>
                <div class="clear-both"></div>
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