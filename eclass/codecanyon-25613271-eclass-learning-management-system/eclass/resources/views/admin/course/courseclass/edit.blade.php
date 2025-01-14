@extends('admin.layouts.master')
@section('title','Edit Course-class')
@section('maincontent')
<?php
$data['heading'] = 'Edit Course-class';
$data['title'] = 'Edit Course-class';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar bardashboard-card">
  <div class="row">
    @if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
    <div class="col-lg-7">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('Edit') }} {{ __('Course Class') }}</h5>
          <div>
            <div class="widgetbar">
                <a href="{{ url('course/create/'. $cate->courses->id) }}" class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
            
                <a href="http://www.webdesign-flash.ro/vs/" target="_blank" class="float-right btn btn-primary-rgba mr-2" ><i class="feather icon-navigation mr-2"></i>{{ __('Encrypt Link') }}</a>
            </div>
            </div>
            
        </div>
        <div class="card-body ml-2">
          <form enctype="multipart/form-data" id="demo-form" method="post" action="{{url('courseclass/'.$cate->id)}}"data-parsley-validate class="form-horizontal form-label-left">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
                      
            <select class="d-none" name="coursechapter" class="form-control select2">
              @php
               $coursechapters = App\CourseChapter::all();
              @endphp  
              @foreach($coursechapters as $cat)
                  <option {{ $cate->coursechapter_id == $cat->id ? 'selected' : "" }} value="{{ $cat->id }}">{{ $cat->chapter_name }}</option>
              @endforeach
            </select>


            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputDetails">{{ __('Title') }}:<sup class="redstar">*</sup></label>
                <input type="text" class="form-control " name="title" id="exampleInputTitle"  value="{{$cate->title}}" required>                  
              </div>
            </div>
            <br>


            <div class="row">
              <div class="col-md-12">
                <label for="type">{{ __('CourseChapter') }}:</label>

                <select name="coursechapter_id" id="chapters" class="form-control select2">
                  @foreach($coursechapt as $chapters)
                  <option value="{{ $chapters->id }}" {{ $cate->coursechapter_id==$chapters->id ? 'selected' : '' }}>{{ $chapters->chapter_name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputDetails">{{ __('Detail') }}:</label>
                <textarea id="details" name="detail" rows="5"  class="form-control" placeholder="Enter Your Details">{{ $cate->detail }}</textarea>
              </div>
            </div>
            <br>
            
            <div class="row">
              <div class="col-md-12">
                <label for="type">{{ __('Type') }}:</label>
                <select name="type" id="filetype" class="form-control">
                  <option value="{{ $cate->type }}">{{ $cate->type }}</option>
                </select>
              </div>
            </div>
            <br>
            @if($cate->type =="video")
              <div class="row">
                <div class="col-md-12" id="videotype">
                  <input type="radio" name="checkVideo" id="ch1" value="url" {{ $cate->url !="" ? 'checked' : "" }}>&nbsp;{{ __('URL') }}&emsp;
                  <input type="radio" name="checkVideo" id="ch2" value="uploadvideo" {{ $cate->video !="" ? 'checked' : "" }}>&nbsp;{{ __('UploadVideo') }}&emsp;
                  <input type="radio" name="checkVideo" id="ch9" value="iframeurl" {{ $cate->iframe_url !="" ? 'checked' : "" }}>&nbsp;{{ __('IframeURL') }}&emsp;
                  <input type="radio" name="checkVideo" id="ch10" value="liveurl" {{ $cate->date_time !="" ? 'checked' : "" }}>&nbsp;{{ __('LiveClass') }}&emsp;
                  @if($gsetting->aws_enable == 1)
                  <input type="radio" name="checkVideo" id="ch13" value="aws_upload" {{ $cate->aws_upload !="" ? 'checked' : "" }}>&nbsp;{{ __('AWSUpload') }}
                  @endif

                  @if($gsetting->youtube_enable == 1)
                  <input type="radio" name="checkVideo" id="youtubeurl" value="youtube">&nbsp;{{ __('Youtube API') }}
                  &emsp;
                  @endif

                  @if($gsetting->vimeo_enable == 1)
                  <input type="radio" name="checkVideo" id="vimeourl" value="vimeo">&nbsp;{{ __('Vimeo API') }}
                  &emsp;
                  @endif
                  <br>
                </div>
              </div>
              


              <!-- aws edit -->
              @if($gsetting->aws_enable == 1)
              <div class="row">
                <div class="col-md-12">
                  <div id="awsUpload" @if($cate->video != NULL || $cate->iframe_url !=NULL || $cate->url) class="display-none" @endif >
                    <label for="">{{ __('AWSUpload') }}: </label>
                    <!-- =========== -->
                  <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="aws_upload" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                        </div>
                      </div>
                      <!-- =========== -->
                    
                    @if($cate->aws_upload !="")
                      <label for="">{{ __('AWSFileName') }}:</label>
                      <input disabled value="{{ $cate->aws_upload }}" class="form-control">
                    @endif
                  </div>
                </div>
              </div>
              @endif

              <div class="row">
                <div class="col-md-12">
                  <div id="videoURL" @if($cate->video !=NULL || $cate->iframe_url !=NULL || $cate->aws_upload !=NULL) style="display:none" @endif >
                    <label for="">{{ __('URL') }}: </label>
                    <input type="text" id="apiUrl" value="{{ $cate->url }}" name="vidurl" class="form-control">
                  </div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-12">
                  <div id="videoUpload" @if($cate->url !=NULL || $cate->iframe_url !=NULL || $cate->aws_upload !=NULL) style="display:none" @endif >
                    <label for="">{{ __('UploadVideo') }}: </label>
                      <!-- =========== -->
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="video_upld" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" />
                            <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                        </div>
                      </div>
                      <!-- =========== -->
                    
                    @if($cate->video !="")
                      <video src="{{ asset('video/class/'.$cate->video) }}" controls>
                      </video>
                    @endif
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div id="iframeURLBox" @if($cate->url !=NULL || $cate->video !=NULL || $cate->aws_upload !=NULL) style="display:none" @endif >
                    <label for="">{{ __('IframeURL') }}: </label>
                    <input type="text" value="{{ $cate->iframe_url }}" name="iframe_url" class="form-control">
                  </div>
                </div>
              </div>

            

              <div class="row">
                <div class="col-md-12">
                  <div id="liveURLBox" @if($cate->iframe_url !=NULL || $cate->video !=NULL || $cate->aws_upload !=NULL || $cate->url !=NULL) style="display:none" @endif >
                    <label for="appt">{{ __('Select a Date & Time') }}:</label>
                    
                    <input type="datetime-local" id="date_time" name="date_time" value="{{ $live_date }}" class="form-control">
                  </div>
                </div>
              </div>


              
              <div class="row">
                <div  class="col-md-12" id="duration">
                  <label for="">{{ __('Duration') }} :</label>
                  <input type="text" name="duration" value="{{ $cate->duration }}" class="form-control" placeholder="Enter class duration in (mins) Eg:160">
                </div>
              </div>
              <br>
            @endif

            @if($cate->type =="audio")
                
                <div class="form-group">
                  <div class="col-md-12">
                    <input type="radio" name="checkAudio" id="ch11" value="audiourl" {{ $cate->url !="" ? 'checked' : "" }}> {{ __('URL') }}
                    <input type="radio" name="checkAudio" id="ch12"  {{ $cate->audio !="" ? 'checked' : "" }} value="uploadaudio"> {{ __('UploadAudio') }}
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="col-md-12">
                    <div id="audioURL" @if($cate->audio != "") style="display:none" @endif >
                      <label for="">{{ __('URL') }}: </label>
                      <input type="text" value="{{ $cate->url }}" name="audiourl" class="form-control">
                    </div>
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="col-md-12">
                    <div id="audioUpload" @if($cate->url !="") style="display:none" @endif >
                    <label for="">{{ __('UploadAudio') }}:</label>
                    <!-- =========== -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="audio" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" >
                            <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                        </div>
                      </div>
                      <!-- =========== -->
                    <!-- <input type="file" name="audio" class="form-control"> -->
                    <br>
                    @if($cate->audio !="")
                    <label for="">{{ __('AudioFileName') }}:</label>
                    <input disabled value="{{ $cate->audio }}" class="form-control">

                    @endif
                  </div>
                  </div>
                </div>
                
                <div class="form-group">
                  <div  class="col-md-12" id="duration">
                    <label for="">{{ __('Duration') }} :</label>
                    <input type="text" name="duration" value="{{ $cate->duration }}" class="form-control" placeholder="Enter class duration in (mins) Eg:160">
                  </div>
                </div>
            @endif

            @if($cate->type =="image")
             
              <div class="col-md-7" id="imagetype">
                <input type="radio" name="checkImage" id="ch3" value="url" {{ $cate->url !="" ? 'checked' : "" }}> {{ __('URL') }}
                <input type="radio" name="checkImage" id="ch4"  {{ $cate->image !="" ? 'checked' : "" }} value="uploadimage"> {{ __('UploadImage') }}
              </div>

              <div class="form-group">
                <div class="col-md-12">
                  <div id="imageURL" @if($cate->image !="") class="display-none" @endif >
                    <label for="">{{ __('URL') }}: </label>
                    <input type="text" value="{{ $cate->url }}" name="imgurl" class="form-control">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-12">
                  <div id="imageUpload" @if($cate->url !="") class="display-none" @endif >
                    <label for="">{{ __('UploadImage') }}:</label>
                    <div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
										</div>
										<div class="custom-file">
											<input accept="image/*" type="file" class="custom-file-input" id="inputGroupFile01" name="image" aria-describedby="inputGroupFileAddon01">
											<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
										</div>
										</div>
                   
                    <br>
                    @if($cate->image !="")
                    <img src="{{ asset('images/class/'.$cate->image) }}" width="200" height="150" autoplay="no"> 
                    </img>

                    @endif
                  </div>
                </div>
              </div>
              <br>

              <div class="form-group">
                 <div  class="col-md-12" id="size">
                  <label for="">{{ __('Size') }}:</label>
                  <input type="text" name="size" value="{{ $cate->size }}" class="form-control">
                </div>
              </div>
            @endif

            @if($cate->type =="zip")
              <div class="form-group">
                <div class="col-md-12" id="ziptype">
                  <input type="radio" name="checkZip" id="ch5" value="url" {{ $cate->url !="" ? 'checked' : "" }}> {{ __('URL') }}
                  <input type="radio" name="checkZip" id="ch6"  {{ $cate->zip !="" ? 'checked' : "" }} value="uploadzip"> {{ __('UploadZip') }}
                </div>
              </div>
              
              <div class="form-group">
                <div class="col-md-12">
                  <div id="zipURL" @if($cate->zip !="") class="display-none" @endif >
                    <label for=""> {{ __('URL') }}: </label>
                    <input type="text" value="{{ $cate->url }}" name="zipurl" class="form-control">
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                <div class="col-md-12">
                  <div id="zipUpload" @if($cate->url !="") class="d-none" @endif>
                    <label for="">{{ __('UploadZip') }}:</label>
                     <!-- =========== -->
                  <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="zip" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                        </div>
                      </div>
                      <!-- =========== -->
                    <!-- <input type="file" name="zip" class="form-control"> -->
                    <br>
                    @if($cate->zip !="")
                    <label for="">{{ __('ZipFileName') }}:</label>
                    <input disabled value="{{ $cate->zip }}" class="form-control">
                    @endif
                  </div>
                </div>
              </div>
              <br>
            
              <div class="col-md-12" id="size">
                <label for=""> {{ __('Size') }}:</label>
                <input type="text" name="size" value="{{ $cate->size }}" class="form-control">
              </div>
            @endif

            @if($cate->type =="pdf")
              <div class="col-md-12" id="pdftype">
                <input type="radio" name="checkPdf" id="ch8" value="url" {{ $cate->url !="" ? 'checked' : "" }}> {{ __('URL') }}
                <input type="radio" name="checkPdf" id="ch9"  {{ $cate->pdf !="" ? 'checked' : "" }} value="uploadpdf"> {{ __('UploadPdf') }}
              </div>


              <div class="form-group">
                <div class="col-md-12" id="pdfURL" @if($cate->pdf !="") class="display-none" @endif >
                  <div id="pdfURL" @if($cate->pdf !="") class="display-none" @endif >
                    <label for=""> {{ __('URL') }}: </label>
                    <input type="text" value="{{ $cate->url }}" name="pdfurl" class="form-control">
                  </div>
                </div>
              </div>

              <div class="col-md-7" id="pdfUpload" @if($cate->url !="") class="display-none" @endif >
                <label for=""> {{ __('UploadPdf') }}:</label>
                <!-- =========== -->
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                  </div>
                  <div class="custom-file">
                      <input type="file" class="custom-file-input" name="pdf" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" >
                      <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                  </div>
                </div>
                <!-- =========== -->
                <!-- <input type="file" name="pdf" class="form-control"> -->
                <br>
                @if($cate->pdf !="")
                <label for="">{{ __('PdfFileName') }}:</label>
                <input disabled value="{{ $cate->pdf }}" class="form-control">
                @endif
              </div>
              <br>
              <br>

               <div  class="col-md-12" id="size">
                <label for="">{{ __('Size') }}:</label>
                <input type="text" name="size" value="{{ $cate->size }}" class="form-control">
              </div>
            @endif


            <!-- preview video -->
            @if($cate->type =="video")
            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputDetails">{{ __('PreviewVideo') }}:</label><br>
                <!-- ============== -->
                <label class="switch">
                    <input class="slider" type="checkbox"  data-id="{{$cat->id}}" name="preview_type" />
                    <span class="knob"></span>
                </label>
                <!-- ============== -->  
               

                <div @if($cate->preview_type =="url" ) class="display-none" @endif id="document11">
                  <label for="exampleInputSlug">{{ __('Preview') }} {{ __('UploadVideo') }}: <sup class="redstar">*</sup></label>
                   <!-- =========== -->
                   <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" value="{{ $cate->video }}" name="video" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" />
                            <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                        </div>
                      </div>
                      <!-- =========== -->
                  <!-- <input type="file" class="form-control" name="video" id="video" value="{{ $cate->video }}"> -->
                  @if($cate->preview_video !="")
                    <video src="{{ asset('video/class/preview/'.$cate->preview_video) }}" width="200" height="150" autoplay="no">
                    </video>
                  @endif 
                </div>

                <div @if($cate->preview_type =="video") class="display-none" @endif id="document22">
                 
                  <label for="exampleInputSlug">{{ __('Preview') }} {{ __('URL') }}: <sup class="redstar">*</sup></label>
                  <input  class="form-control" placeholder="Enter Your URL" name="preview_url" id="url" value="{{ $cate->preview_url }}">
                </div>
              </div>
            </div>
            <br>
            @endif


            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputDetails">{{ __('LearningMaterial') }}</label> - <p class="inline info">{{__('eg: zip or pdf files')}}</p>
                  <!-- =========== -->
                  <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input {{ $errors->has('file') ? ' is-invalid' : '' }}" value="{{ $cate->file }}" name="file" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                        </div>
                      </div>
                      <!-- =========== -->
               

                @if($cate->file != NULL)
                  <input disabled class="form-control" value="{{$cate->file}}">
                @endif
                
              </div>
            </div>
            <br>

            <!-- end preview video -->
           
            <div class="row">
              <div class="col-md-4"> 
                <label for="exampleInputTit1e">{{ __('Status') }} :</label><br>
                <!-- ============== -->
                <label class="switch">
                    <input class="slider" type="checkbox"  data-id="{{$cat->id}}" name="status" {{ $cate->status == '1' ? 'checked' : '' }} />
                    <span class="knob"></span>
                </label>
                <!-- ============== -->
            
                <br>
              </div>
              <div class="col-md-4"> 
                <label for="exampleInputTit1e">{{ __('Featured') }} :</label><br>
                <!-- ============== -->
                <label class="switch">
                    <input class="slider" type="checkbox"  data-id="{{$cat->id}}" name="featured" {{ $cate->featured == '1' ? 'checked' : '' }} />
                    <span class="knob"></span>
                </label>
                <!-- ============== -->
               
                <br>
              </div>
            </div>

            <br>

            @if($cate->courses->drip_enable == 1)
              <hr>
              
              <div class="row"> 
                <div class="col-md-6">
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
                  <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('When section should be unlock') }}.</small>

                </div>

                <div class="col-md-6" @if($cate->drip_type == 'date' || $cate->drip_type == NULL) style="display: none;" @endif id="dripdays">
                  <label>{{ __('Days After Enrollment') }} :</label>
                  <input type="number" min="1" class="form-control" name="drip_days" value="{{ optional($cate)->drip_days}}">
                  <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Enter days') }}.</small>
                </div>
              </div>
              <br>

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

    @if($cate->type =="video")
    <div class="col-lg-5">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('Subtitle') }}</h5>
        </div>
        <div class="card-body ml-2">
          <a data-toggle="modal" data-target="#myModalSubtitle" href="#" class="btn btn-info btn-sm">+  {{ __('Add') }} {{ __('Subtitle') }}</a>

          <!--Model start-->
          <div class="modal fade" id="myModalSubtitle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel"> </h4>
                </div>
                <div class="box box-primary">
                <div class="panel panel-sum">
                  <div  class="modal-body">
                    <form enctype="multipart/form-data" id="demo-form2" method="post" action="{{ route('add.subtitle',$cate->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                      {{ csrf_field() }}

                      <div id="subtitle">

                        <label>{{ __('Subtitle') }}:</label>
                        <table class="table table-bordered" id="dynamic_field">  
                          <tr> 
                              <td>
                                 <div class="{{ $errors->has('sub_t') ? ' has-error' : '' }} input-file-block">
                                  <input type="file" name="sub_t[]"/>
                                  <p class="info">{{ __('Choose subtitle file ex. subtitle.srt, or. txt') }}</p>
                                  <small class="text-danger">{{ $errors->first('sub_t') }}</small>
                                </div>
                              </td>

                              <td>
                                <input type="text" name="sub_lang[]" placeholder="Subtitle Language" class="form-control name_list" />
                              </td>  
                              <td><button type="button" name="add" id="add" class="btn btn-xs btn-success">
                                <i class="fa fa-plus"></i>
                              </button></td>  
                          </tr>  
                        </table>
                       
                      </div>
                      <div class="box-footer">
                        <button type="submit" class="btn btn-lg col-md-3 btn-primary">{{ __('Submit') }}</button>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
           <table class="displaytable table table-striped table-bordered w-100">
            <thead>
              <br>
              <br>
              <tr>
                <th>#</th>
                <th>{{ __('SubtitleLanguage') }} </th>
                <th>{{ __('Delete') }}</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=0;?>
              @foreach($subtitles as $subtitle)
                <?php $i++;?>
                <tr>
                  <td><?php echo $i;?></td>
                  <td>{{$subtitle->sub_lang}}</td>
                  <td>
                    <form  method="post" action="{{ route('del.subtitle',$subtitle->id) }}"
                          data-parsley-validate class="form-horizontal form-label-left">
                      {{ csrf_field() }}

                      <button type="submit" class="btn btn-danger display-inline">
                        <i class="fa fa-fw fa-trash-o"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach 
            </tbody> 
          </table>
        </div>
      </div>
    </div>
    @endif

  </div>
</div>

@endsection
<div id="myyoutubeModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!--youtube API Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title">{{ __('Search From Youtube API') }}</h1>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        @if(is_null(env('YOUTUBE_API_KEY')))
        <p>{{ __('Make Sure You Have Added Youtube API Key in') }} <a href="{{url('admin/api-settings')}}">{{ __('API Settings') }}</a></p>
        @endif
       
        <div id="hyv-page-container" style="clear:both;">
          <div class="hyv-content-alignment">
            <div id="hyv-page-content" class="" style="overflow:hidden;">
              <div class="container-4">
                <div class="row">
                  <div class="col-lg-9">
                    <form action="" method="post" name="hyv-yt-search" id="hyv-yt-search">
                        <input type="search" name="hyv-search" id="hyv-search" placeholder="Search..." class="ui-autocomplete-input" autocomplete="off">
                        <button class="icon" id="hyv-searchBtn"></button>
                    </form>
                  </div>
                  <div class="col-lg-3 text-right">
                    <div>
                      <input type="hidden" id="pageToken" value="">
                      <div class="btn-group" role="group" aria-label="...">
                        <button type="button" id="pageTokenPrev" value="" class="btn btn-default">{{ __('Prev') }}</button>
                        <button type="button" id="pageTokenNext" value="" class="btn btn-default">{{ __('Next') }}</button>
                      </div>
                    </div>
                    <div id="hyv-watch-content" class="hyv-watch-main-col hyv-card hyv-card-has-padding">
                      <ul id="hyv-watch-related" class="hyv-video-list">
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Back') }}</button>
      </div>
    </div>

  </div>
</div> 


<!--vimeo API Modal -->
<div id="myvimeoModal" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">

  <!--vimeo API Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title">{{ __('Search From Vimeo API') }}</h1>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
      @if(is_null(env('VIMEO_ACCESS')))
      <p>{{ __('Make Sure You Have Added Vimeo API Key in') }} <a href="{{url('admin/api-settings')}}">{{ __('API Settings') }}</a></p>
      @endif
     
      <div id="vimeo-page-container" style="clear:both;">
        <div class="vimeo-content-alignment">
          <div id="vimeo-page-content" class="" style="overflow:hidden;">
            <div class="container-4">
              <div class="row">
                <div class="col-lg-9">
                  <form action="" method="post" name="vimeo-yt-search" id="vimeo-yt-search">
                      <input type="search" name="vimeo-search" id="vimeo-search" placeholder="Search..." class="ui-autocomplete-input" autocomplete="off">
                      <button class="icon" id="vimeo-searchBtn"></button>
                  </form>
                </div>
                <div class="col-lg-3 text-right">
                  <div>
                    <input type="hidden" id="vpageToken" value="">
                    <div class="btn-group" role="group" aria-label="...">
                      <button type="button" id="vpageTokenPrev" value="" class="btn btn-default">{{ __('Prev') }}</button>
                      <button type="button" id="vpageTokenNext" value="" class="btn btn-default">{{ __('Next') }}</button>
                    </div>
                  </div>
                  <div id="vimeo-watch-content" class="vimeo-watch-main-col vimeo-card vimeo-card-has-padding">
                      <ul id="vimeo-watch-related" class="vimeo-video-list">
                      </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
    </div>
  </div>

</div>
</div>
@section('script')


<script>

   $('#youtubeurl').click(function(){
   
    $('#myyoutubeModal').modal("show"); //Open Modal
    $('#videoURL').show();
      $('#videoUpload').hide();
      $('#iframeURLBox').hide();
      $('#duration_video').show();
      $('#liveclassBox').hide();
      $('#awsBox').hide();
     
  });
</script>

<script>

   $('#vimeourl').click(function(){
   
    $('#myvimeoModal').modal("show"); //Open Modal
    $('#videoURL').show();
      $('#videoUpload').hide();
      $('#iframeURLBox').hide();
      $('#duration_video').show();
      $('#liveclassBox').hide();
      $('#awsBox').hide();
     
  });
</script>

<script>


  function setVideoURl(videourls){
    console.log(videourls);
  $('#apiUrl').val(videourls); 
    $('#myyoutubeModal').modal("hide"); //add youtube URL
  }

</script>

<script>

  function setVideovimeoURl(videourls){
    console.log(videourls);
  $('#apiUrl').val(videourls); 
    $('#myvimeoModal').modal("hide"); // add vimeo URL
  }
</script>

  

<script>
   $('#previewvide').on('change',function(){

    if($('#previewvide').is(':checked')){
      $('#document11').show('fast');
      $('#document22').hide('fast');
    }else{
      $('#document22').show('fast');
      $('#document11').hide('fast');
    }

  });
</script>

 @if($cate->type =="video")
  <script>
    (function($) {
    "use strict";
   
     $('#ch1').click(function(){
       $('#videoURL').show();
       $('#videoUpload').hide();
       $('#iframeURLBox').hide();
       $('#liveURLBox').hide();
       $('#awsUpload').hide();
     });
    
    $('#ch2').click(function(){
       $('#videoURL').hide();
       $('#videoUpload').show();
       $('#iframeURLBox').hide();
       $('#liveURLBox').hide();
       $('#awsUpload').hide();
     });

    $('#ch9').click(function(){
       $('#iframeURLBox').show();
       $('#videoURL').hide();
       $('#videoUpload').hide();
       $('#liveURLBox').hide();
       $('#awsUpload').hide();
     });

    $('#ch10').click(function(){
       $('#iframeURLBox').hide();
       $('#videoURL').show();
       $('#videoUpload').hide();
       $('#liveURLBox').show();
       $('#awsUpload').hide();
     });


    //aws checkbox
    $('#ch13').click(function(){
       $('#awsUpload').show();
       $('#iframeURLBox').hide();
       $('#videoURL').hide();
       $('#videoUpload').hide();
       $('#liveURLBox').hide();
     });

    })(jQuery);
   
  </script>
 @endif

 @if($cate->type =="audio")
  <script>
    (function($) {
    "use strict";
   
     $('#ch11').click(function(){
       $('#audioURL').show();
       $('#audioUpload').hide();
     });
    
    $('#ch12').click(function(){
       $('#audioURL').hide();
       $('#audioUpload').show();

     });

  })(jQuery);
  </script>
 @endif

 @if($cate->type =="image")
  <script>
    (function($) {
    "use strict";
   
     $('#ch3').click(function(){
       $('#imageURL').show();
       $('#imageUpload').hide();
     });
    
    $('#ch4').click(function(){
       $('#imageURL').hide();
       $('#imageUpload').show();

     });

  })(jQuery);
  </script>
 @endif

 @if($cate->type =="zip")
  <script>
    (function($) {
    "use strict";
   
     $('#ch5').click(function(){
       $('#zipURL').show();
       $('#zipUpload').hide();
     });
    
    $('#ch6').click(function(){
       $('#zipURL').hide();
       $('#zipUpload').show();
     });

  })(jQuery);
   
  </script>
  
 @endif



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


@section('stylesheets')

<style type="text/css">
.modal {
  overflow-y:auto;
}


 body{
      background-color: #efefef;
  }
  .container-4 input#hyv-search {
      width: 500px;
      height: 30px;
      border: 1px solid #c6c6c6;
      font-size: 10pt;
      float: left;
      padding-left: 15px;
      -webkit-border-top-left-radius: 5px;
      -webkit-border-bottom-left-radius: 5px;
      -moz-border-top-left-radius: 5px;
      -moz-border-bottom-left-radius: 5px;
      border-top-left-radius: 5px;
      border-bottom-left-radius: 5px;
  }
    .container-4 input#vimeo-search {
      width: 500px;
      height: 30px;
      border: 1px solid #c6c6c6;
      font-size: 10pt;
      float: left;
      padding-left: 15px;
      -webkit-border-top-left-radius: 5px;
      -webkit-border-bottom-left-radius: 5px;
      -moz-border-top-left-radius: 5px;
      -moz-border-bottom-left-radius: 5px;
      border-top-left-radius: 5px;
      border-bottom-left-radius: 5px;
  }
  .container-4 button.icon {
      height: 34px;
      background: #F0F0EF url(../../images/icons/searchicon.png) 10px 1px no-repeat;
      background-size: 24px;
      -webkit-border-top-right-radius: 5px;
      -webkit-border-bottom-right-radius: 5px;
      -moz-border-radius-topright: 5px;
      -moz-border-radius-bottomright: 5px;
      border-top-right-radius: 5px;
      border-bottom-right-radius: 5px;
      border: 1px solid #c6c6c6;
      width: 50px;
      margin-left: -44px;
      color: #4f5b66;
      font-size: 10pt;
  }

  button#pageTokenNext {
    margin-left: 5px;
    border-radius: 3px;
    margin-bottom: 20px;
  }

  button#vpageTokenNext {
    margin-left: 5px;
    border-radius: 3px;
    margin-bottom: 20px;
  }



</style>



@endsection