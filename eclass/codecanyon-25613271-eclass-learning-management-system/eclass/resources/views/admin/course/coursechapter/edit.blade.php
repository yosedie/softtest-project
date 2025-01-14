@extends('admin.layouts.master')
@section('title','Edit Coursechapter')
@section('maincontent')
<?php
$data['heading'] = 'Edit Coursechapter';
$data['title'] = 'Edit Coursechapter';
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
          <h5 class="card-title">{{ __('Edit') }} {{ __('Course Chapter') }}</h5>
          <div class="widgetbar">
            <a href="{{ url('course/create/'. $cate->courses->id) }}" class="float-right btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
          </div>
        </div>
        <div class="card-body ml-2">
          <form id="demo-form" method="post" action="{{url('coursechapter/'.$cate->id)}}"data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
              <div class="d-none">

            <label class="display-none" for="exampleInputSlug">{{ __('SelectCourse') }}</label>
            <select name="course_id" class="form-control select2">
              @foreach($courses as $cou)
                <option value="{{ $cou->id }}" {{$cate->courses->id == $cou->id  ? 'selected' : ''}}>{{ $cou->title}}</option>
              @endforeach
            </select>
          </div>

            <div class="row">
              <div class="col-md-6">
                <label for="exampleInputTit1e">{{ __('Name') }} :<span class="redstar">*</span></label>
                <input type="" class="form-control" name="chapter_name" id="exampleInputTitle" value="{{$cate->chapter_name}}">
                <br>
              </div>

              <div class="col-md-6">
                <label for="exampleInputDetails">{{ __('LearningMaterial') }} :</label> 
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="file">{{ __('Upload') }}</span>
                  </div>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                  </div>
                </div>
              </div>



            </div>
            <br>

            
              <hr>
              
              <div class="row"> 
              <div class="col-md-2">
                <label for="exampleInputTit1e">{{ __('Status') }} :</label><br>
                  <label class="switch">
                    <input class="slider" type="checkbox" name="status" {{ $cate->status == '1' ? 'checked' : '' }} />
                    <span class="knob"></span>
                  </label>
              </div>
              @if($cate->courses->drip_enable == 1)
                <div class="col-md-10">
                  <label  for="married_status">{{ __('Drip Content Type') }}: </label>
                  <select class="form-control js-example-basic-single" id="drip_type" name="drip_type">
                    <option value="" selected hidden> 
                      {{ __('Select an Option ') }}
                    </option>
                    <option value="date" {{ $cate->drip_type == 'date' ? 'selected' : ''}}>{{ __('Specific Date') }}</option>
                    <option value="days" {{ $cate->drip_type == 'days' ? 'selected' : ''}}>{{ __('Days After Enrollment') }}</option>
                  </select>
                  <br>
                </div>

                <div class="col-md-6" @if($cate->drip_type == 'days' || $cate->drip_type == NULL) style="display: none;" @endif id="dripdate">
                  <label>{{ __('Specific Date') }} :</label>
                

                  <div class="input-group" id='datetimepicker1'>
                  <input type="text"  name="drip_date"   id="time-format" class="form-control" placeholder="dd/mm/yyyy - hh:ii aa" aria-describedby="basic-addon5"  value="{{$cate->drip_date}}"/>
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon5"><i class="feather icon-calendar"></i></span>
                    </div>
                  </div>
                  
                </div>

                <div class="col-md-6" @if($cate->drip_type == 'date' || $cate->drip_type == NULL) style="display: none;" @endif id="dripdays">
                  <label>{{ __('Days After Enrollment') }} :</label>
                  <input type="number" min="1" class="form-control" name="drip_days" value="{{$cate->drip_days}}">
                  <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Enter days') }}.</small>
                </div>
              </div>
              

              @endif
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
@section('script')


<script>
  
  $('#drip_type').change(function() {
      
    if($(this).val() == 'date')
    {
      $('#dripdate').show();
      $("input[name='drip_date']").attr('required','required');
    }
    else
    {
      $('#dripdate').hide();
    }

    if($(this).val() == 'days')
    {
      $('#dripdays').show();
      $("input[name='drip_days']").attr('required','required');
    }
    else
    {
      $('#dripdays').hide();
    }


  });

</script>


@endsection 

