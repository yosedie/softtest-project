<form action="{{ route('adminsetting.update') }}" method="POST">
    {{ csrf_field() }}
    <div class="row">
        <div class="shadow-sm border card col-md-6" style="width: 18rem;">
            <h4 class="card-text">{{ __('New Sidebar for Admin') }}</h4>
            <img src="{{ url('images/sidebar/admin.png') }}" class="card-img-top" alt="{{ __('Side Bar Admin')}}">
            <div class="card-body">                
                <div class="custom-radio-button mt-3">
                    <div class="form-check-inline radio-primary">
                        <input type="checkbox" class="custom_toggle" id="customSwitch19" name="sidebar_enable"
                            {{ $gsetting->sidebar_enable == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch19" id="customSwitch19">
                    </div>
                </div>
            </div>
        </div>
        <div class="shadow-sm border card col-md-6" style="width: 18rem;">
            <h4 class="card-text">{{ __('New Sidebar for Instructor') }}</h4>
            <img src="{{ url('images/sidebar/instructor.png') }}" class="card-img-top" alt="{{ __('Side Bar Instructor')}}">
            <div class="card-body">                
                <div class="custom-radio-button mt-3">
                    <div class="form-check-inline radio-primary">
                        <input type="checkbox" class="custom_toggle" id="customSwitch20" name="instructor_sidebar"
                            {{ $gsetting->instructor_sidebar == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch20" id="customSwitch20">
                    </div>
                </div>
            </div>
        </div>
        <!-- Apply theme button -->
        <div class="mt-3 col-md-12">
            <div class="form-group">
                <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update')}}"><i class="fa fa-check-circle"></i>
                    {{ __("Save")}}</button>
            </div>
        </div>    
    </div>
</form>