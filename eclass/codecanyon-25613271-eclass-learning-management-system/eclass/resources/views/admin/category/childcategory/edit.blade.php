@extends('admin.layouts.master')
@section('title','Edit Child category')
@section('maincontent')

@component('components.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __('Admin') }}
@endslot

@slot('menu2')
{{ __(' Edit Childcategory') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <a href="{{ url('childcategory') }}" class="float-right btn btn-primary mr-2"><i
      class="feather icon-arrow-left mr-2"></i>{{__('Back')}}</a>
</div>
@endslot

@endcomponent
<div class="contentbar dashboard-card">
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-box">{{ __('Edit') }} {{ __('Child categories') }}</h5>
        </div>
        <div class="card-body ml-2">
          <form id="demo-form" method="post" action="{{url('childcategory/'.$cate->id)}}" data-parsley-validate class="form-horizontal form-label-left" autocomplete="off">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputSlug">{{ __('SelectCategory') }}</label>
                <select name="category_id" id="category_id" class="form-control select2">
                  @php
                    $category = App\Categories::all();
                  @endphp  
                  @foreach($category as $caat)
                    <option {{ $cate->category_id == $caat->id ? 'selected' : "" }} value="{{ $caat->id }}">{{ $caat->title }}</option>
                  @endforeach 
                </select>
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputSlug">{{ __('SelectSubCategory') }}<span class="redstar">*</span></label>
                <select name="subcategory_id" id="upload_id" class="form-control select2">
                  @php
                    $subcategory = App\SubCategory::all();
                  @endphp  
                  @foreach($subcategory as $caat)
                    <option {{ $cate->subcategory_id == $caat->id ? 'selected' : "" }} value="{{ $caat->id }}">{{ $caat->title }}</option>
                  @endforeach 
                </select>
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-md-12">
                <label for="title">{{ __('Title') }}:<span class="redstar">*</span></label>
                <input type="text" class="form-control" name="title" id="exampleInputTitle" value="{{$cate->title}}">
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-md-12">
                <label for="slug">{{ __('Slug') }}:<span class="redstar">*</span></label>
                <input pattern="[/^\S*$/]+" type="text" class="form-control" name="slug" id="exampleInputTitle" value="{{$cate->slug}}">
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-md-12">
                <label for="icon">{{ __('Icon') }}:</label>
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
              <div class="col-md-12">
                <label for="exampleInputDetails">{{ __('Status') }}:<sup
                  class="redstar text-danger">*</sup></label><br>
              <input id="status" type="checkbox" class="custom_toggle" name="status" {{ $cate->status == '1' ? 'checked' : '' }} />
              <input type="hidden" name="free" value="0" for="status" id="status">
                
              </div>
            </div>
            <br>

            
        <div class="form-group">
          <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
            {{__('Reset')}}</button>
          <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
            {{__('Update')}}</button>
        </div>
   
  <div class="clear-both"></div>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')

<script>
(function($) {
  "use strict";
  
  $(function() {
    var urlLike = '{{ url('admin/dropdown') }}';
    $('#category_id').change(function() {
      var up = $('#upload_id').empty();
      var cat_id = $(this).val();    
      if(cat_id){
        $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:"GET",
          url: urlLike,
          data: {catId: cat_id},
          success:function(data){   
            console.log(data);
            up.append('<option value="0">Please Choose</option>');
            $.each(data, function(id, title) {
              up.append($('<option>', {value:id, text:title}));
            });
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
          }
        });
      }
    });
  });

})(jQuery);
</script> 

@endsection
