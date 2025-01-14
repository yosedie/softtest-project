<div class="col-md-6">
    <div class="form-group">
        <label class="text-dark"
            for="promo_text">{{ __('Facebook Chat Bubble') }}:</label>
        <input form="settingsform" value="{{ $setting->chat_bubble }}" name="chat_bubble"
            placeholder="https://app.respond.io/facebook/chat/plugin/XXXX/XXXXXXXXXX" type="url"
            class="{{ $errors->has('chat_bubble') ? ' is-invalid' : '' }} form-control">
        <small>{{ __('Facebook Bubble Chat will not work on localhost (eg. xampp & wampp)') }}</small>
        <br>
        <small><a target="__blank"
            href="https://app.respond.io/" title="{{ __('Get URL For Facebook Messenger Chat Bubble')}}">{{ __('Get URL For Facebook Messenger Chat Bubble') }}</a></small>
    </div>
    <div class="form-group">
        <button type="reset" form="settingsform" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i>
            {{ __("Reset")}}</button>
        <button type="submit" form="settingsform" class="btn btn-primary-rgba" title="{{ __('Save')}}"><i class="fa fa-check-circle"></i>
            {{ __("Save")}}</button>
    </div>
</div>