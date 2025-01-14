
@extends('admin.layouts.master')
@section('title','Player Customizations')
@section('maincontent')
<?php
$data['heading'] = 'Player Customizations';
$data['title'] = 'Player Settings';
$data['title1'] = 'Player Customizations';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  @if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
  @endforeach  
  </div>
  @endif
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __("Player Customizations")}} </h5>
        </div>
        <div class="card-body">
          
          <form action="{{ route('player.update') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
          
            <div class="row">
              <div class="form-group col-md-3">
                  <label for="exampleInputDetails">{{ __('Logo Enable') }}:</label><br>
                  <input  class="custom_toggle"   type="checkbox" name="logo_enable"  {{ optional($ps)->logo_enable == '1' ? 'checked' : '' }} />
                  <input type="hidden" name="free" value="0" for="cb4" id="cb4"> 
                </div>
                <div class="form-group col-md-3">
                  <label class="text-dark" for="exampleInputSlug">{{ __('Image') }}: </label>
                  <small class="text-muted"><i class="fa fa-question-circle"></i>
                    {{ __('Recommended size') }}{{__(' 104 x 36px')}}</small>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                      </div>
                      <div class="custom-file">
                        <input accept="image/*" type="file" name="logo"  class="custom-file-input" id="user_img_one" value="{{ optional($ps)['logo'] }}" id="logo" class="{{ $errors->has('logo') ? ' is-invalid' : '' }} aria-describedby="inputGroupFileAddon01" onchange="readURL(this);">
                        <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose File') }}</label>
                      </div>
                    </div>
                    <div class="thumbnail-img-block mb-3">
                      @if(optional($ps)['logo'] !="")
                
                      <div class="logo-settings">
                        <img src="{{ url('/content/minimal_skin_dark/'.$ps['logo']) }}" alt="{{ optional($ps)['logo'] }}" id="logo" class="img-responsive image_size">
                    </div>
                    @else
                      <div class="alert alert-danger">
                        {{ __('No logo found') }}
                      </div> 
                      @endif          
                    </div>   
                </div>
              <div class="form-group col-md-3">
                <label for="exampleInputDetails">{{ __('Share Enable') }}:</label><br>
                <input  class="custom_toggle"   type="checkbox" name="share_enable" {{ optional($ps)['share_enable'] == '1' ? 'checked' : '' }}/>
                <input type="hidden"  name="free" value="0" for="cb3" id="cb3"> 
              </div>
              <div class="form-group col-md-3">
                <label for="exampleInputDetails">{{ __('Auto Play') }}:</label><br>
                <input  class="custom_toggle"   type="checkbox" name="autoplay"  {{ optional($ps)['autoplay'] == '1' ? 'checked' : '' }}/>
                <input type="hidden"  name="free" value="0" for="cb6" id="cb6"> 
                <br>
                <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('If autoplay is enable audio is automatically mute') }}.</small>
              </div>
              <div class="form-group col-md-3">
                <label for="exampleInputDetails">{{ __("Video Download Enable:")}}</label><br>
                <input  class="custom_toggle"   type="checkbox" name="download" {{ optional($ps)['download'] == '1' ? 'checked' : '' }}/>
                <input type="hidden"  name="free" value="0" for="cb7" id="cb7"> 
              </div>
            
              <div class="form-group col-md-3">
                <div class="form-group">
                    <label class="text-dark" >{{ __('Subtitle Font Size') }} : </label>
                    <input min="1" name="subtitle_font_size" class="form-control" type="number" value="{{ optional($ps)['subtitle_font_size'] }}"/>
                </div>
              </div>

              <div class="form-group col-md-2">
                <div class="form-group">
                  <label class="text-dark" for="subtitle_color">{{ __('Subtitles Color') }}:</label>
                  <input name="subtitle_color" class="form-control" type="color" value="{{ optional($ps)['subtitle_color'] }}"/>
                  
                </div>
              </div>
              <div class="form-group col-md-4">
                <div class="form-group">
                  <label for="player_google_analytics_id">{{ __('Google Analytics ID')}}
                  <input type="text" name="player_google_analytics_id" id="player_google_analytics_id" class='form-control'  placeholder ='Enter Google Analytics ID'> 
                  <small class="text-danger">{{ $errors->first('player_google_analytics_id') }}</small>
                </div>
              </div>
              
              <div class="form-group col-md-3">
                <label for="exampleInputDetails">{{ __('Embedded Enable') }}:</label><br>
                <input  class="custom_toggle"   type="checkbox" name="embedded_enable" {{ optional($ps)['embedded_enable'] == '1' ? 'checked' : '' }}/>
                <input type="hidden"  name="free" value="0" for="cb3" id="cb3"> 
              </div>

              <div class="form-group col-md-3">
                <label for="exampleInputDetails">{{ __('Loop Video') }}:</label><br>
                <input  class="custom_toggle"   type="checkbox" name="loop_video" {{ optional($ps)['loop_video'] == '1' ? 'checked' : '' }}/>
              </div>

              <div class="form-group col-md-3">
                <label for="chrome_cast">{{ __('Chrome Cast') }}:</label><br>
                <input  class="custom_toggle" type="checkbox" id="chrome_cast" name="chrome_cast" {{ optional($ps)['chrome_cast'] == '1' ? 'checked' : '' }}/>
              </div>

              <div class="col-lg-4 col-md-6">
                <label for="skin">{{ __('Choose Skin') }}:</label><br>
                <div class="form-group text-dark{{ $errors->has('skin') ? ' has-error' : '' }}">
                  <select class="select2" name="skin" id="skin">
                    <option value="minimal_skin_dark" {{isset($ps->skin) && $ps->skin == 'minimal_skin_dark' ? 'selected' : ''}}>{{__('Minimal Dark')}}</option>
                    @if($ps->skin=='minimal_skin_white')
                    <option value="minimal_skin_white" selected="true">{{__('Minimal White')}}</option>
                    @else
                      <option value="minimal_skin_white">{{__('Minimal White')}}</option>
                    @endif
                    @if($ps->skin=='classic_skin_dark')
                    <option value="classic_skin_dark" selected="true">{{__('Classic Dark')}}</option>
                    @else
                    <option value="classic_skin_dark">{{__('Classic Dark')}}</option>
                    @endif
                    @if($ps->skin=='classic_skin_white')
                    <option value="classic_skin_white" selected="true">{{__('Classic White')}}</option>
                    @else
                    <option value="classic_skin_white">{{__('Classic White')}}</option>
                    @endif
                    @if($ps->skin=='modern_skin_dark')
                    <option value="modern_skin_dark" selected="true">{{__('Modern Dark')}}</option>
                    @else
                      <option value="modern_skin_dark">{{__('Modern Dark')}}</option>
                    @endif
                    @if($ps->skin=='modern_skin_white')
                    <option value="modern_skin_white" selected="true">{{__('Modern White')}}</option>
                    @else
                      <option value="modern_skin_white" >{{__('Modern White')}}</option>
                    @endif
                  </select>
                </div>
              </div>
            
            </div>
         
          <div class="form-group">
            <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
            <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update') }}"><i class="fa fa-check-circle"></i>
            {{ __("Update")}}</button>
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
@endsection