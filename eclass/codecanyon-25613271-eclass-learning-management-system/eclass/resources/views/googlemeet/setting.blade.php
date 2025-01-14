
@extends('admin.layouts.master')
@section('title', 'Setting - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Google Meetings Settings';
$data['title'] = 'Meetings';
$data['title1'] = 'Google Meetings';
$data['title2'] = 'Google Meetings Settings';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Google Meetings Settings') }}</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <form action="{{ route('googlemeet.updatefile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <div class="eyeCy">
                    <label>{{ __('Choose JSON File') }} {{__('clientsecret.json')}}:</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                      </div>
                      <div class="custom-file">
                        <input type="file"  name="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose File') }}</label>
                      </div>
                    </div>
                    
                  </div>
                </div>
    
                @php
    
                $auth_email = Auth::user()->email;
                $path = 'files/googlemeet'.'/'.$auth_email;    
                @endphp
                <div class="form-group">
                    <label>{{__('My Credentials')}}:</label>
                    @if(file_exists(public_path().'/'.$path.'/'.'client_secret.json'))                 
                    <a href="{{ asset('files/googlemeet'.'/'.$auth_email.'/'.'client_secret.json') }}" download="client_secret.json" class="btn btn-info-rgba" style="width:100%" title="{{ __('Download') }}"><i class="fa fa-download"></i> {{ __('Download') }}</a>
                    <br>
                    <br>
                  @else
                    <div class="btn btn-primary" style="width:100%">
                      {{ __('No File Found') }}
                      
                    </div>
                  @endif
                </div>    
                <div class="form-group">
                  <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                  <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update') }}"><i class="fa fa-check-circle"></i>
                  {{ __("Update")}}</button>
                </div>
    
              </form>
            </div>
    
            <div class="col-md-6">
              <h4 style="color: black"><i class="fa fa-question-circle"></i> {{ __('How to get Google Meet clientsecret.json file') }} : </h4>
              <hr>
              <div class="panel panel-default">
                <div class="panel-body">
                  <ul>
                    <li> {{ __('Use the link to create or select a project in the google developers console and automatically turn on the APi. Click continue then') }} <b>{{ __('go to credential') }}</b>. : <a href="https://console.cloud.google.com/flows/enableapi?apiid=calendar" target="_blank">{{ __('Google Cloud Platform') }}</a></li>
                     <li>{{ __('On the') }} <b>{{ __('Add credentials to your project') }}</b> {{ __('click the') }} <b>{{ __('Cancel') }}</b> {{ __('button') }}.</li>
                     <li>{{ __('At the top of the page, select the') }} <b>{{ __('Oauth consent screen') }}</b>{{ __('tab. Select an') }} <b>{{ __('Email Address') }}</b>, {{ __('Enter product name if not already set and click the') }} <b>{{ __('Save') }}</b> {{ __('button') }}.</li>
                     <li>{{ __('Select the') }} <b>{{ __('Credentials') }}</b> {{ __('tab, click the') }} <b>{{ __('Create Credentials') }}</b> {{ __('button and select') }} <b>{{ __('Oauth client id') }}</b>.</li>    
                     <li>{{ __('Use this URL as Redirect URL') }} <b>{{ url('oauth') }}</b> </li>    
                     <li>{{ __('Select the application type') }} <b>{{ __('Other') }}</b>, {{ __('enter the name "googlemeet". and click the') }} <b>{{ __('Create') }}</b> {{ __('button') }}.</li> 
                     <li>{{ __('Click') }} <b>Ok</b> {{ __('to dismiss the resulting dialog') }}.</li>
                     <li>{{ __('Click the') }} <b>{{ __('download json') }}</b> {{ __('button to the right of the client id') }}.</li>
                     <li>{{ __('Upload your') }} <b>{{ __('(Downloaded json)') }}</b> {{ __('file') }}.</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 @endsection
 @section('script')
  <script>
     $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
      });
  </script>
@endsection


