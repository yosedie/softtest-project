@extends('admin.layouts.master')
@section('title', 'Blizzard Settings - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])

@slot('heading')
   {{ __('Blizzard Settings') }}
@endslot

@slot('menu1')
{{ __('Blizzard Settings') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    <a href="{{ route('themesettings.index')}}" class="btn btn-primary-rgba" title="{{ __('Back')}}">
        <i class="feather icon-arrow-left mr-2"></i>
        {{ __("Back")}}
    </a>
  </div>
</div>
@endslot

@endcomponent
<div class="contentbar">
    <div class="row">
    <!-- row started -->
    <div class="col-lg-12">        
        @if ($errors->any()) 
            <div class="alert alert-danger" role="alert">
                @foreach($errors->all() as $error)     
                <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button></p>
                    @endforeach  
            </div>
        @endif    
        <div class="card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Blizzard Settings') }}</h5>
                </div>                
                <!-- card body started -->
                <div class="card-body">
                <!-- form start -->
				<form action="{{ route('configuration.update','Blizzard') }}" method="POST" enctype="multipart/form-data">
		               @csrf
                       <div class="row">
                            <!-- Mix Theme Folder -->
                           <div class="col-md-6">
                                <div class="form-group">
                                <span class="float-right">
                                        <a 
                                        href="https://mediacitydocs.gitbook.io/skillify-eclass-lms-vue-theme/installation/domain-configuration"
                                        target="_blank">
                                            <i class="feather icon-alert-octagon"></i>
                                            {{ __('For more information click here')}}
                                        </a>
                                    </span>
                                    
                                <label for="mix_theme">
                                    {{ __('Mix Theme Folder')}}
                                </label>
                                <input value="{{ env('MIX_THEME_FOLDER') }}" type="text" class="form-control" placeholder="Please enter value according to your domain configuration" name="mix_theme" required>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="form-group col-md-6">
                                <label class="text-dark" for="exampleInputDetails">{{ __('Status') }} :</label>
                                <br>
                                <input type="checkbox" class="custom_toggle" name="status" {{$module->isStatus(1) ? 'checked' : ''}} />
                            </div>
                        
                            <!-- Client Secret KEY -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">{{ __('Client Secret KEY :') }}</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></span>
                                        </div>
                                        <input readonly value="{{ $key ? $key->secret_key : "" }}" type="text" name="apikey" class="form-control keyupdate" placeholder="{{ __('API KEY For Blizzard Theme') }}" aria-label="Username" aria-describedby="basic-addon1">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-primary re-gen-key" type="button">
                                                <i class="re_icon fa fa-refresh"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="alert alert-danger">
                                        <i class="feather icon-alert-triangle mr-2"></i>
                                        <b>{{__('Important')}}:</b>
                                        <a href="{{ url('/getsecretkey') }}" class="text-danger" target="_blank" title="{{ __('Please generate API key first.') }}">
                                            <u> {{ __('Please generate API key first.') }}</u>
                                        </a>
                                    </span>
                                    
                                </div>
                            </div>                            
                            <!-- Purcahse Code -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">{{ __('Purchase Code :') }}</label>
                                    <input id="pass_log_id6" type="password" placeholder="Please enter valid purchase code" class="form-control"  name="purchase_code" value="{{ old('purchase_code') }}" >
                                    <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password6"></span>
                                    <small class="text-muted">
                                        <i class="fa fa-question-circle"></i> 
                                        {{ __('Enter envato purchase code.')}}
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- row end -->
						<!-- Update Button -->
                        <div class="form-group">
                            <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                            <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update')}}"><i class="fa fa-check-circle"></i>
                                {{ __("Update")}}
                            </button>
                        </div>
		          	</form>
                  <!-- form end -->
                </div>
				<!-- card body end -->            
        </div><!-- col end -->
    </div>
</div>
</div><!-- row end -->
    <br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain JavaScript start -->
@section('script')
    <script>
        "use Strict";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click', '.toggle-password6', function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $("#pass_log_id6");
            input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
        });
        $('.re-gen-key').on('click',function(){
            $.ajax({
                method : 'POST',
                datatype : 'json',
                url    : @json(route('regen.key')),
                beforeSend : function(){
                    $('.re_icon').addClass('fa-spin fa-fw');
                },
                success : function(data){
                    $('.re_icon').removeClass('fa-spin fa-fw');
                
                    if(data.status != 'success'){
                        alert(data.msg);
                        return false;
                    }else{

                        $('.keyupdate').val(data.key);

                    }
                },
                error : function(jqXHR, err){
                    alert(err);
                    $('.re_icon').removeClass('fa-spin fa-fw');
                    return false;
                }
                })
        });
    </script>
@endsection
<!-- This section will contain JavaScript end -->
