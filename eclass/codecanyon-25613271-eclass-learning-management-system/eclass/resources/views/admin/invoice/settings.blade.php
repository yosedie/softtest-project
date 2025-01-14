@extends('admin.layouts.master')
@section('title','Invoice Design - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Invoice Design';
$data['title'] = 'Invoice Design';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  @if ($errors->any())  
    <div class="alert alert-danger" role="alert">
      @foreach($errors->all() as $error)     
        <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
    </div>
  @endif
<div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __("Invoice Design")}} </h5>
        </div>
        <div class="card-body">
          
          <form action="{{ route('invoice.update') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
          
            <div class="row">
         
            
              <div class="form-group col-md-6">
                <label for="exampleInputDetails">{{ __('Logo Enable') }}:</label><br>
                <input  class="custom_toggle"   type="checkbox" name="logo_enable" @if(isset($settings->logo_enable)) {{ $settings->logo_enable == '1' ? 'checked' : '' }} @endif/>
                 
                  <input type="hidden" name="free" value="0" for="cb4" id="cb4">
              </div>

              <div class="form-group col-md-6">
                <label for="exampleInputDetails">{{ __('Border Enable') }}:</label><br>
                <input  class="custom_toggle"   type="checkbox" name="border_enable"  @if(isset($settings->border_enable)){{ $settings['border_enable'] == '1' ? 'checked' : '' }} @endif/>
                <input type="hidden"  name="free" value="0" for="cb3" id="cb3"> 
              </div>

              <div class="form-group col-md-6">
                <label class="text-dark" for="border_radius">{{ __('Border Radius') }} </label>
                <input min="1" class="form-control" name="border_radius" type="number" value="{{ optional($settings)->border_radius }}" id="duration"  placeholder="" class="{{ $errors->has('border_radius') ? ' is-invalid' : '' }} form-control">
              </div>
                          
              <div class="form-group col-md-6">
                <label class="text-dark" for="blue_bg">{{ __('Border Color') }}:</label>
                <input name="border_color" class="form-control" type="color" value="{{ optional($settings)['border_color'] }}"/>
              </div>

              <div class="form-group col-md-6"> 
                <label for="exampleInputSlug">{{ __('Border Style') }}</label>
                <select class="form-control select2" name="border_style">
                  <option value="none" selected> 
                    {{ __('SelectanOption') }}
                  </option>

                  <option {{ optional($settings)->border_style == 'dashed' ? 'selected' : ''}} value="dashed">{{ __('Dashed') }}</option>

                  <option {{ optional($settings)->border_style == 'solid' ? 'selected' : ''}} value="solid">{{ __('Solid') }}</option>

                  <option {{ optional($settings)->border_style == 'groove' ? 'selected' : ''}} value="groove">{{ __('groove') }}</option>

                  <option {{ optional($settings)->border_style == 'double' ? 'selected' : ''}} value="double">{{ __('double') }}</option>
                  
                </select>

              </div>

              <div class="form-group col-md-6"> 
                <label for="exampleInputSlug">{{ __('Date format') }}</label>
                <select class="form-control select2" name="date_format">
                  <option value="none" selected> 
                    {{ __('SelectanOption') }}
                  </option>

                  <option {{ optional($settings)->date_format == 'd-m-Y' ? 'selected' : ''}} value="d-m-Y">{{ __('d-m-Y') }}</option>

                  <option {{ optional($settings)->date_format == 'd/m/Y' ? 'selected' : ''}} value="d/m/Y">{{ __('d/m/Y') }}</option>

                  <option {{ optional($settings)->date_format == 'Y-m-d' ? 'selected' : ''}} value="Y-m-d">{{ __('Y-m-d') }}</option>

                  <option {{ optional($settings)->date_format == 'jS F Y' ? 'selected' : ''}} value="jS F Y">{{ __('jS F Y') }}</option>

                  <option {{ optional($settings)->date_format == 'jS F Y' ? 'selected' : ''}} value="jS F Y">{{ __('jS F Y') }}</option>

                  <option {{ optional($settings)->date_format == 'jS F Y' ? 'selected' : ''}} value="jS F Y">{{ __('jS F Y') }}</option>
                  
                  <option {{ optional($settings)->border_style == 'jS F Y' ? 'selected' : ''}} value="jS F Y">{{ __('jS F Y') }}</option>

                  
                </select>

              </div>

           
              <div class="form-group col-md-6">
                  <label class="text-dark">{{ __('Signature') }} :</label>
                  <div class="input-group">
                    <input required readonly id="image" for="signature" name="signature" type="text" class="form-control">
                      <div class="input-group-append">
                          <span data-input="image"
                              class="bg-primary text-light midia-toggle input-group-text">{{ __('Browse') }}</span>
                      </div>
                  </div>
              </div>
        <div class="col-md-6">
                  @if(isset($settings->signature) && $settings->signature != null)
                    <img src="{{ url('/images/signature/'.$settings->signature) }}" class="image_size" />
                  @endif
              </div>
            </div>

              <div class="mt-3 col-md-12">
                <div class="form-group">
                  <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                  <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                {{ __("Update")}}</button>
                </div>
              </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>    

@endsection


@section('script')
	<script>
		$(function() {
	      $('#logo_chk').change(function() {
	        $('#status').val(+ $(this).prop('checked'))
	        var st = $('#status').val();
	        if(st==1)
	        {
	        	$('#logo_upl').show();
            $('#logo_pre').show();
	        }
	        else
	        {
	        	$('#logo_upl').hide();
            $('#logo_pre').hide();
	        }
	      })
	    })

	    $(function() {
	      $('#share_chk').change(function() {
	        $('#share_opt').val(+ $(this).prop('checked'))
	      })
	    })
</script>
<script>
  $(".midia-toggle").midia({
      base_url: '{{ url('') }}',
      directory_name: 'signature'
  });
</script>
@endsection
