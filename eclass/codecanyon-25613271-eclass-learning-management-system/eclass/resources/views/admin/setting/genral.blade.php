<form id="settingsform" class="form" action="{{ route('setting.store') }}" method="POST" novalidate
    enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="text-dark" for="status">{{ __('Text Logo') }} :</label><br>
                <input type="checkbox" class="custom_toggle" id="customSwitch1" name="{{ __('project_logo')}}"
                    {{ $gsetting->logo_type == 'L' ? 'checked' : '' }} />
                <input type="hidden" name="free" value="0" for="customSwitch1" id="customSwitch1">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="text-dark">{{ __('Project Title') }}:</label>
                <input name="project_title" autofocus="" type="text"
                    class="{{ $errors->has('project_title') ? ' is-invalid' : '' }} form-control"
                    placeholder="{{ __('Enter project title')}}" value="{{ $setting->project_title }}" required="">
                <div class="invalid-feedback">
                    {{ __('Please enter Project Title !') }}.
                </div>
            </div>
        </div>
        <!-- ============ Project Title end =========================-->
        <!-- ============ APP URL start =============================-->
        <div class="col-md-3">
            <div class="form-group">
                <label class="text-dark">{{ __('APP URL') }}:</label>
                <input name="APP_URL" autofocus="" type="text"
                    class="{{ $errors->has('APP_URL') ? ' is-invalid' : '' }} form-control"
                    placeholder="http://localhost/" value="{{ $env_files['APP_URL'] }}" required="">
                <div class="invalid-feedback">
                    {{ __('Please Enter APP URL !') }}.
                </div>
            </div>
        </div>
        <!-- ============ APP URL end =============================-->
        <!-- ============ email start =============================-->
        <div class="col-md-3">
            <div class="form-group">
                <label class="text-dark" for="wel_email">{{ __('Email') }} : <span
                        class="text-danger">*</span></label>
                <input value="{{ $setting->wel_email }}" name="wel_email" placeholder="{{ __('Enter your email')}}" type="text"
                    class="{{ $errors->has('wel_email') ? ' is-invalid' : '' }} form-control" required>
                <div class="invalid-feedback">
                    {{ __('Please Enter Email !') }}.
                </div>
            </div>
        </div>
        <!-- ============ email end =============================-->
        <!-- ============ Contact start =============================-->
        <div class="col-md-3">
            <div class="form-group">
                <label class="text-dark" for="phone">{{ __('Contact') }} : <span
                        class="text-danger">*</span></label>
                <input value="{{ $setting->default_phone }}" name="default_phone" placeholder="{{ __('Enter contact No.')}}"
                    type="text" class="{{ $errors->has('default_phone') ? ' is-invalid' : '' }} form-control" required>
                <div class="invalid-feedback">
                    {{ __('Please Enter Contact !') }}.
                </div>
            </div>
        </div>
        <!-- ============ Contact end =============================-->        
        <!-- ============ Copyright Text start ==================-->
        <div class="col-md-3">
            <div class="form-group">
                <label class="text-dark" for="cpy_txt">{{ __('Copyright Text') }} : <span
                        class="text-danger">*</span></label>
                <input value="{{ $setting->cpy_txt }}" name="cpy_txt" placeholder="Enter Copyright Text" type="text"
                    required class="{{ $errors->has('cpy_txt') ? ' is-invalid' : '' }} form-control">
                <div class="invalid-feedback">
                    {{ __('Please Enter Copyright Text !') }}.
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="text-dark" for="feature_amount">{{ __('Amount to feature a course') }} </label>
                <input min="1" class="form-control" name="feature_amount" type="number"
                    value="{{ $setting->feature_amount }}" id="duration"
                    placeholder="{{ __('Enter amount to feature course')}} ex: 100"
                    class="{{ $errors->has('feature_amount') ? ' is-invalid' : '' }} form-control">
                <small>{{ __('(Instructor can feature its course, by paying this amount)') }}</small>
            </div>
        </div>
        <!-- ============ Address start =========-->
        <div class="col-md-3">
            <div class="form-group">
                <label class="text-dark" for="exampleInputDetails">{{ __('Address') }} : <span
                        class="text-danger">*</span></label>
                <textarea name="default_address" rows="2" class="form-control" placeholder="{{ __('Enter your address')}}"
                    required>{{ $setting->default_address }}</textarea>
            </div>
        </div>
        <!-- ============ Address end =========-->
        <!-- ============ MapCoordinates start =========-->
        <div class="bg-info-rgba col-md-12 mb-3">
            <h4 class="mt-3 mb-3"><i class="feather icon-map-pin" aria-hidden="true"></i>{{ __(' Map Coordinates Settings') }}</h4>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="text-dark" for="map_lat">{{ __('Map Enable') }}:</label><br>
                    <input type="checkbox" class="custom_toggle" id="customSwitch2" name="map_enable"
                        {{ $gsetting->map_enable == 'map' ? 'checked' : '' }} />
                    <input type="hidden" name="free" value="0" for="customSwitch2" id="customSwitch2">
                    <div>
                        <small>{{ __('(Enable Map on contact page)') }}</small>
                    </div>
                </div>
            </div>
            <!-- ============ MapCoordinates end =========-->
            <!-- contact page start -->
            <div class="col-md-12">
                <div class="row" style="{{ $setting['map_enable'] == 'image' ? '' : 'display:none' }}" id="sec_one">
                    <div class="col-md-12">
                        <label class="text-dark">{{ __('ContactPageImage') }} :</label>
                        <small>{{ __('(Note - Recommended Size : 300x90PX)') }}</small>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" name="contact_image"
                                    aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                            </div>
                        </div>
                        @if($image = @file_get_contents('../public/images/contact/'.$setting->contact_image))
                        <img src="{{ url('/images/contact/'.$setting->contact_image) }}" class="image_size" alt="{ __('Contact') }}" />
                        @endif
                    </div>
                </div>
            </div>
            <!-- contact page end -->
            <div class="col-md-12">
                <div class="row" style="{{ $setting['map_enable'] == 'map' ? '' : 'display:none' }}" id="sec1_one">
                    <div class="col-md-4">
                        <label class="text-dark" for="map_url">{{ __('Iframe URL') }}:</label>
                        <input value="{{ $setting->map_url }}" name="map_url" placeholder="{{ __('Enter the iframe URL')}}" type="text"
                            class="{{ $errors->has('map_url') ? ' is-invalid' : '' }} form-control">
                    </div>
                    {{-- <div class="col-md-4">
                        <label class="text-dark" for="map_long">{{ __('Map Longitude') }}:</label>
                        <input value="{{ $setting->map_long }}" name="map_long" placeholder="{{ __('Enter Longitude')}}"
                            type="text" class="{{ $errors->has('map_long') ? ' is-invalid' : '' }} form-control">
                    </div> --}}
                    <div class="col-md-4">
                        <label class="text-dark" for="map_api">{{ __('Map Api Key') }}:</label>
                        <input value="{{ $setting->map_api }}" name="map_api" placeholder="{{ __('Enter Map Api')}}" type="text"
                            class="{{ $errors->has('map_api') ? ' is-invalid' : '' }} form-control">
                    </div>
                </div>
            </div>
            <br>
        </div>
        <div class="bg-info-rgba col-md-12 mb-3">

            <h4 class="mt-3 mb-3"><i class="feather icon-server"
                    aria-hidden="true"></i> {{ __('Promo Bar') }}</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="text-dark" for="promo_enable">{{ __('Promo Enable') }}
                            :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch3" name="promo_enable"
                            {{ $gsetting->promo_enable == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch3" id="customSwitch3">
                        <div>
                            <small>{{ __('(Enable Promo Bar on site)') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================ -->
            <div class="row" style="{{ $setting['promo_enable'] == 1 ? '' : 'display:none' }}" id="sec2_one">
                <div class="col-md-6">
                    <label for="promo_text">{{ __('Promo Text') }}:</label>
                    <input value="{{ $setting->promo_text }}" name="promo_text" placeholder="{{ __('Enter Promo Text')}}"
                        type="text" class="{{ $errors->has('promo_text') ? ' is-invalid' : '' }} form-control">
                </div>
                <div class="col-md-6">
                    <label for="promo_link">{{ __('Promo Link') }}:</label>
                    <input value="{{ $setting->promo_link }}" name="promo_link" placeholder="{{ __('Enter Promo Text Link')}}"
                        type="text" class="{{ $errors->has('promo_link') ? ' is-invalid' : '' }} form-control">
                </div>
            </div>
            <br>
        </div>

        <div class="bg-info-rgba col-md-12 mb-3">
            <h4 class="mt-3 mb-3"><i class="feather icon-smartphone" aria-hidden="true"></i> {{__('APP Settings')}}</h4>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="text-dark" for="status">{{ __('APP Store') }}</label>
                        <br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch4" name="app_download"
                            {{ $gsetting->app_download == '1' ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch4" id="customSwitch4">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Link:') }}</label>
                        <input name="app_link" autofocus="" type="text"
                            class="{{ $errors->has('app_link') ? ' is-invalid' : '' }} form-control"
                            placeholder="{{ __('Please Enter APP Store Link')}}" value="{{ $setting->app_link }}">
                        <div class="invalid-feedback">
                            {{ __('Please Enter APP Store Link !') }}.
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Play Store') }}</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch5" name="play_download"
                            {{ $setting->play_download == '1' ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch5" id="customSwitch5">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Link:') }}</label>
                        <input name="play_link" autofocus="" type="text" class="form-control"
                            placeholder="{{ __('Please Enter Play Store Link')}}" value="{{ $setting->play_link }}">
                        <div class="invalid-feedback">
                            {{ __('Please Enter Play Store Link !') }}.
                        </div>
                    </div>
                </div>
            </div>
            <!-- ======= Donation link start ========== -->
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Donation Link') }}: </label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch6" name="donation_enable"
                            {{ $setting->donation_enable == '1' ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch6" id="customSwitch6">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Link') }} :</label>
                        <input name="donation_link" autofocus="" type="text" class="form-control"
                            placeholder="{{ __('Please Enter PayPal.me Link')}}" value="{{ $setting->donation_link }}">
                        <small>{{ __('Get Donation link by register on ') }}<a target="__blank"
                                href="https://www.paypal.com/in/webapps/mpp/paypal-me"> {{__('PayPal.me')}}</a></small>
                        <div class="invalid-feedback">
                            {{ __('Please Enter PayPal.me Link !') }}.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-info-rgba col-md-12 mb-3">
            <h4 class="mt-3 mb-3"><i class="feather icon-loader" aria-hidden="true"></i> {{ __('Miscellaneous Settings')}}
            </h4>
            <!-- ======= Donation link end ========== -->
            <!-- ======= section 1 start ========== -->
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Right Click') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch7" name="rightclick"
                            {{ $gsetting->rightclick == '0' ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch7" id="customSwitch7">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Inspect Element') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch8" name="inspect"
                            {{ $setting->inspect == '0' ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch8" id="customSwitch8">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Preloader Enable') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch9" name="preloader_enable"
                            {{ $gsetting->preloader_enable == '1' ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch9" id="customSwitch9">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('APP Debug') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch10" name="APP_DEBUG"
                            {{ env('APP_DEBUG') == true ? "checked" : "" }} />
                        <input type="hidden" name="free" value="0" for="customSwitch10" id="customSwitch10">
                    </div>
                </div>
            </div>
            <!-- ======= section 1 end ========== -->
            <!-- ======= section 2 start ========== -->
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Welcome Email') }} : </label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch11" name="w_email_enable"
                            {{ $gsetting->w_email_enable == '1' ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch11" id="customSwitch11">
                        <div>
                            <small>{{ __('(If you enable it, a welcome email will be sent to user\'s register email id,<br> make sure you updated your mail setting in Site Setting >> Mail Settings before enable it.)') }}</small>
                            <small class="text-danger">{{ $errors->first('color') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Verify Email') }} : </label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch12" name="verify_enable"
                            {{ $gsetting->verify_enable == '1' ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch12" id="customSwitch12">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Become An Instructor') }}: </label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch13" name="instructor_enable"
                            {{ $gsetting->instructor_enable == '1' ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch13" id="customSwitch13">
                        <div>
                            <small>{{ __('(Enable Become an instructor option for users)') }}</small>
                            <small class="text-danger">{{ $errors->first('color') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Categories For Instructor') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch14" name="cat_enable"
                            {{ $gsetting->cat_enable == '1' ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch14" id="customSwitch14">
                        <div>
                            <small>{{ __('(If you enable it, Instructor Able to Add Categories)') }}</small>
                            <small class="text-danger">{{ $errors->first('color') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ======= section 2 end ========== -->
            <!-- ======= section 3 start ========== -->
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Mobile No. on SignUp') }} : </label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch15" name="mobile_enable"
                            {{ $gsetting->mobile_enable == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch15" id="customSwitch15">
                        <div>
                            <small>{{ __('(Enable ask mobile no. on SignUp page)') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Device Control') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch16" name="device_enable"
                            {{ $gsetting->device_control == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch16" id="customSwitch16">
                        <div>
                            <small>{{ __('(Enable Device Control)') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Cookie Notice') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch17" name="cookie_enable"
                            {{ $gsetting->cookie_enable == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch17" id="customSwitch17">
                        <div>
                            <small>{{ __('(Enable Cookie Notice on Site)') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('IP Block') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch18" name="ipblock_enable"
                            {{ $gsetting->ipblock_enable == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch18" id="customSwitch18">
                        <div>
                            <small>{{ __('(Enable IP block on portal)') }}</small>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ======= section 3 end ========== -->
            <!-- ======= section 4 start ========== -->
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Activity Log') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch19" name="activity_enable"
                            {{ $gsetting->activity_enable == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch19" id="customSwitch19">
                        <div>
                            <small>{{ __('(Enable Users Activity Logs for Login/Register)') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Assignments') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch20" name="assignment_enable"
                            {{ $gsetting->assignment_enable == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch20" id="customSwitch20">
                        <div>
                            <small>{{ __('(Enable Assignments on Course)') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Appointments') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch21" name="appointment_enable"
                            {{ $gsetting->appointment_enable == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch21" id="customSwitch21">
                        <div>
                            <small>{{ __('(Enable Appointments on Course)') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Certificates ') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch22" name="certificate_enable"
                            {{ $gsetting->certificate_enable == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch22" id="customSwitch22">
                        <div>
                            <small>{{ __('(Enable Certificates on Course)') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ======= section 4 end ========== -->
            <!-- ======= section 5 start ========== -->
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Hide Identity') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch23" name="hide_identity"
                            {{ $gsetting->hide_identity == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch23" id="customSwitch23">
                        <div>
                            <small>{{ __('(Hide Users Identity from Instructors)') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Course Hover') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch24" name="course_hover"
                            {{ $gsetting->course_hover == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch24" id="customSwitch24">
                        <div>
                            <small>{{ __('(Enable/Disable Hover from home page sliders)') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-none">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Currency Swipe') }} : </label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch25" name="currency_swipe"
                            {{ $gsetting->currency_swipe == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch25" id="customSwitch25">
                        <div>
                            <small>{{ __('(Swipe currency before/after icon)') }}</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Attendance') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch26" name="attandance_enable"
                            {{ $gsetting->attandance_enable == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch26" id="customSwitch26">
                        <div>
                            <small>{{ __('(Enable Attendance on Courses)') }}</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Guest Checkout') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch26" name="guest_enable"
                            {{ $gsetting->guest_enable == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch26" id="customSwitch26">
                        <div>
                            <small>{{ __('(Enable Guest checkout)') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ======= section 5 end ========== -->
            <!-- ======= section 6 start ========== -->
        </div>
        <div class="bg-info-rgba col-md-12 mb-3">
            <h4 class="mt-3 mb-3"><i class="feather icon-video" aria-hidden="true"></i> {{__('Meetings Settings')}}
            </h4>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Enable Zoom On Portal') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch27" name="zoom_enable"
                            {{ $gsetting->zoom_enable == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch27" id="customSwitch27">
                        <div>
                            <small>{{ __('( Enable Live zoom meetings on portal )') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Enable BigBlueButton Meetings') }} : </label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch28" name="bbl_enable"
                            {{ $gsetting->bbl_enable == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch28" id="customSwitch28">
                        <div>
                            <small>{{ __('(Enable BigBlueButton meetings on portal)') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Google Meet') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch29" name="googlemeet_enable"
                            {{ $gsetting->googlemeet_enable == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch29" id="customSwitch29">
                        <div>
                            <small>{{ __('(Enable Google Meet on portal)') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Jitsi Meeting') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch30" name="jitsimeet_enable"
                            {{ $gsetting->jitsimeet_enable == 1 ? 'checked' : '' }} />
                        <input type="hidden" name="free" value="0" for="customSwitch30" id="customSwitch30">
                        <div>
                            <small>{{ __('(Enable Jitsi Meeting on Portal)') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============ Social Links start =========-->
        <div class="bg-info-rgba col-md-12 mb-3">
            <h4 class="mt-3 mb-3"><i class="feather icon-toggle-right" aria-hidden="true"></i> {{ __('Social Login URLs') }}</h4>
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="instagram_url" class="text-dark">{{ __('Instagram URL')}}</label>
                        <input type="url" name="instagram_url" id="instagram_url" class="form-control" value="{{ $gsetting->instagram_url}}">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="facebook_url" class="text-dark">{{ __('Facebook URL')}}</label>
                        <input type="url" name="facebook_url" id="facebook_url" class="form-control" value="{{ $gsetting->facebook_url}}">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="youtube_url" class="text-dark">{{ __('You Tube URL')}}</label>
                        <input type="url" name="youtube_url" id="youtube_url" class="form-control" value="{{ $gsetting->youtube_url}}">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="twitter_url" class="text-dark">{{ __('Twitter URL')}}</label>
                        <input type="url" name="twitter_url" id="twitter_url" class="form-control" value="{{ $gsetting->twitter_url}}">
                    </div>
                </div>
            </div>
        </div>
        <!-- ============ Social Links end =========-->
        <div class="bg-info-rgba col-md-12 mb-3">
            <h4 class="mt-3 mb-3"><i class="feather icon-toggle-right" aria-hidden="true"></i> {{ __('Slider On/Off') }}
            </h4>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Category Slider') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="customSwitch50" name="category_enable"
                            {{ $gsetting->category_enable == 1 ? 'checked' : '' }} />
                        <div>
                            <small>{{ __('( Enable for Category Slider)') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <label>
                        {{ __('Enable Price with comma notation')}} :
                      </label>
                      <br>
                      <label class="switch">
                        <input type="checkbox" class="custom_toggle" id="customSwitch51"{{env('PRICE_DISPLAY_FORMAT') == 'comma' ? 'checked' : ''}}  name="PRICE_DISPLAY_FORMAT">
                      </label>
                      <br>
                      <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('By toggling it price will display on front end with comma')}} eg : 1000.12 {{ __('will show')}} <b>1 000,50</b>.</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Watch Video') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="myCheck" name="watch_enable"
                            {{ $gsetting->watch_enable == 1 ? 'checked' : '' }} onclick="myFunction()"/>
                        <div>
                            <small>{{ __('( Enable for watching a video for times)') }}</small>
                        </div>
                    </div>
                    <div style="{{$gsetting->watch_enable == 1 ? '' : 'display: none' }}" id="update-password">
                        <div class="form-group">
                          <label>{{ __('Times a Video') }}</label>
                          <input type="number" name="" value="" class="form-control"
                            placeholder="{{ __('Please Enter times for watching a video')}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Enable for OpenAI Chatgpt Integration') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="myCheck1" name="api_enable"
                            {{ $gsetting->api_enable == 1 ? 'checked' : '' }} onclick="myFunction()"/>
                        <div>
                            <small>{{ __('( Enable for Api Integration then please Update your Key.)') }}</small>
                        </div>
                    </div>
                    <div style="{{$gsetting->api_enable == 1 ? '' : 'display: none' }}" id="update-password1">
                        <div class="form-group openai-form-group">
                          <label>{{ __('OpenAi Api Key') }}</label>
                          <input type="password"  name="api_key" value="{{ $gsetting->api_key }}" class="form-control"
                            placeholder="{{ __('Please Enter Api Key')}}">
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="text-dark">{{ __('OTP Login ') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="otp_enable" name="otp_enable"
                            {{ $gsetting->otp_enable == 1 ? 'checked' : '' }} />
                        <div>
                            <small>{{ __('(Enable Twilio Keys to activate this login feature)') }}</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Screenshot Enable') }} :</label><br>
                        <input type="checkbox" class="custom_toggle" id="screenshot_enable" name="screenshot_enable"
                            {{ $gsetting->screenshot_enable == 1 ? 'checked' : '' }} />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-9">
                    <label class="text-dark">{{ __('Logo') }} :</label>
                    <small>{{ __('(Note - Recommended Size : 300x90PX)') }}</small>
                    <div class="input-group">
                        <input required readonly id="image" for="logo" name="logo" type="text" class="form-control">
                        <div class="input-group-append">
                            <span data-input="image"
                                class="bg-primary text-light midia-toggle input-group-text">{{ __('Browse') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 p-3 bg-primary-rgba">
                    <img src="{{ url('/images/logo/'.$setting->logo) }}" class="img-fluid" alt="{{ __('Logo') }}"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row mb-4">
                <div class="col-md-9">
                    <label class="text-dark">{{ __('Footer Logo') }} :</label>
                    <small>{{ __('(Note - Recommended Size : 300x90PX)') }}</small>
                    <div class="input-group">
                        <input required readonly id="footer_logo" for="footer_logo" name="footer_logo" type="text"
                            class="form-control">
                        <div class="input-group-append">
                            <span data-input="footer_logo"
                                class="bg-primary text-light midia-toggle input-group-text">{{ __('Browse') }}</span>
                        </div>
                    </div>
                </div>
                <div class="bg-primary-rgba p-3 col-md-3">
                    @if($image = @file_get_contents(public_path().'/images/favicon/'.$setting->favicon))
                    <img src="{{ url('/images/favicon/'.$setting->favicon) }}"
                        class="logo_img img-fluid" alt="{{ __('Footer Logo')}}"/>
                    @endif
                </div>
            </div>
        </div>
        <!-- ============ Preloader logo start =========================== -->
        <div class="form-group col-md-6">          
            <div class="row">
                <div class="col-md-9">
                    <label class="text-dark">{{ __('Preloader logo') }} :</label>
                    <small>{{ __('(Note - Recommended Size : 300x90PX)') }}</small>
                    <div class="input-group">
                        <input required readonly id="preloader_logo" for="preloader_logo" name="preloader_logo"
                            type="text" class="form-control">
                        <div class="input-group-append">
                            <span data-input="preloader_logo"
                                class="bg-primary text-light midia-toggle input-group-text">{{ __('Browse') }}</span>
                        </div>
                    </div>
                </div>             
            </div>            
        </div>
        <div class="form-group col-md-6">
            <div class="row">
                <div class="col-md-9">
                    <label class="text-dark">{{ __('Favicon') }} :</label>
                    <small>{{ __('(Note - Recommended Size : 35x35PX)') }}</small>
                    <div class="input-group">
                        <input required readonly id="favicon" for="favicon" name="favicon" type="text"
                            class="form-control">
                        <div class="input-group-append">
                            <span data-input="favicon"
                                class="bg-primary text-light midia-toggle2 input-group-text">{{ __('Browse') }}</span>
                        </div>
                    </div>
                </div>
                <div class="bg-primary-rgba p-3 col-md-3">
                    @if($image = @file_get_contents('../public/images/favicon/'.$setting->favicon))
                    <img src="{{ url('/images/favicon/'.$setting->favicon) }}" class="logo_img img-fluid" alt="{{ __('Favicon')}}"/>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-12 form-group">            
            <div class="form-group">
                <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i>
                    {{ __("Reset")}}</button>
                <button type="submit" class="btn btn-primary-rgba" title="{{ __('Save')}}"><i class="fa fa-check-circle"></i>
                    {{ __("Save")}}</button>
            </div>
        </div>
    </div>
</form>
<style>
    .image_size {
        height: 80px;
        width: 200px;
    }
</style>
@section('scripts')
<script>
    "use strict";
    $(function(){
      $('#myCheck').change(function(){
        if($('#myCheck').is(':checked')){
          $('#update-password').show('fast');
        }else{
          $('#update-password').hide('fast');
        }
      });
      
    });
   
</script>
<script>
    "use strict";
    $(function(){
      $('#myCheck1').change(function(){
        if($('#myCheck1').is(':checked')){
          $('#update-password1').show('fast');
        }else{
          $('#update-password1').hide('fast');
        }
      });
      
    });
   
</script>


@endsection 