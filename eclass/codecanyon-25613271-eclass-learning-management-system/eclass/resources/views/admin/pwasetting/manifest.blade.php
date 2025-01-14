<!-- form start -->
<form action="{{ route('manifest.update') }}" method="POST">
  @csrf
      <!-- row start -->
      <div class="row">
          <div class="col-md-12">
              <!-- card start -->
              <div class="card">
                  <!-- card body start -->
                  <div class="card-body">
                      <!-- row start -->
                        <div class="row">                            
                            <div class="col-md-12">
                                <!-- row start -->
                                <div class="row">                                  
                                  <!-- AppName -->
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="text-dark">{{ __('App Name') }}: </label>
                                          <input disabled class="form-control" type="text" name="app_name" value="{{ config("app.name")}}"/>
                                      </div>
                                  </div>
                                  <!-- ThemeColorforheader -->
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label class="text-dark" >{{ __('Theme Color for Header') }} : </label>
                                          <input name="pwa_theme" class="form-control" type="color" value="{{ $env_files['PWA_THEME_COLOR'] }}"/>
                                      </div>
                                  </div>
                                  <!-- BackgroundColor -->
                                  <div class="col-md-3">
                                    <div class="form-group">
                                    <label class="text-dark" for="">{{ __('Background Color') }} :</label>
                                    <input name="pwa_bg" class="form-control" type="color" value="{{ $env_files['PWA_BG_COLOR'] }}"/>
                                    </div>
                                </div>
                                <!-- pwa_enable -->
                                <div class="form-group col-md-6">
                                    <label class="text-dark" for="exampleInputDetails">{{ __('PWA Enable') }} :</label><br>
                                    <input type="checkbox" class="custom_toggle" name="pwa_enable" {{ $env_files['PWA_ENABLE'] == '1' ? 'checked' : '' }} />
                                    <input type="hidden"  name="free" value="0" for="status" id="status">
                                </div>
                                <!-- create and close button -->
                                  <div class="col-md-12">
                                      <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                      <button type="submit" class="btn btn-primary-rgba" title="{{ __('Save')}}"><i class="fa fa-check-circle"></i>
                                      {{ __("Save")}}</button>
                                  </div>

                                </div><!-- row end -->
                            </div><!-- col end -->
                        </div><!-- row end -->

                  </div><!-- card body end -->
              </div><!-- card end -->
          </div><!-- col end -->
      </div><!-- row end -->
</form>
                 

