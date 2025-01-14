<form class="form" action="{{ action('WhatsappButtonController@update') }}" method="POST" novalidate enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('POST') }}
    <div class="row">
        <div class="col-md-3">            
            <div class="form-group">
                <label class="text-dark">{{ __('Header Title') }} : </label>
                <input name="wapp_title" autofocus="" type="text" class="form-control" placeholder="{{ __('Enter Header Title')}}"  value="{{ $setting['wapp_title'] }}">
                <div class="invalid-feedback">
                    {{ __('Please Enter Header Title !') }}.
                </div>
            </div>
        </div>
        <div class="col-md-4">            
            <div class="form-group">
                <label class="text-dark">{{ __('WhatsApp Phone No.') }} {{ __('(with country code)') }}:</label>
                <input name="wapp_phone" autofocus="" type="text" class="form-control" placeholder="{{ __('Please Enter WhatsApp Phone Number')}}" value="{{ $setting['wapp_phone'] }}">
                <div class="invalid-feedback">
                    {{ __('Please Enter WhatsApp Phone Number !') }}.
                </div>
            </div>
        </div>
        <div class="col-md-3">
        <div class="form-group">
                <label class="text-dark">{{ __('WhatsApp PopUp Msg') }} :</label>
                <input name="wapp_popup_msg" autofocus="" type="text" class="form-control" placeholder="{{ __('PopUp Message')}}"  value="{{ $setting['wapp_popup_msg'] }}">
                <div class="invalid-feedback">
                    {{ __('Please Enter WhatsApp PopUp Message !') }}.
                </div>
            </div>
        </div>
        <div class="col-md-2">            
            <div class="form-group">
                <label class="text-dark" for="number">{{ __('WhatsApp Color') }} :</label>
                <input name="wapp_color" autofocus="" type="color" class="form-control my-colorpicker1" placeholder="{{ __('Choose color')}}" value="{{ $setting['wapp_color'] }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="text-dark">{{ __('Button Position') }} ({{ __('Right/left') }}):</label><br>
                <input  class="custom_toggle"  type="checkbox" name="wapp_position"  {{ $setting['wapp_position'] == 'left' ? 'checked' : '' }} />
                <input type="hidden"  name="free" value="0" for="left" id="left">              
            </div>
        </div>
        <div class="form-group col-md-3">
            <label class="text-dark" for="exampleInputDetails">{{ __('Enable WhatsApp Chat Button') }} :</label><br>
            <input type="checkbox" class="custom_toggle" name="wapp_enable" {{ $setting['wapp_enable'] == '1' ? 'checked' : '' }} />
            <input type="hidden"  name="free" value="0" for="status" id="status">
        </div>
    </div>
    <div class="form-group">
        <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
        <button type="submit" class="btn btn-primary-rgba" title="{{ __('Save')}}"><i class="fa fa-check-circle"></i>
            {{ __("Save")}}</button>
    </div>
    
</form>