@extends('admin.layouts.master')
@section('title','Create a new course')
@section('maincontent')
<?php
$data['heading'] = 'Course';
$data['title'] = 'Course';
$data['title1'] = 'Create a Course';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-tittle">{{ __('Add Course') }}</h5>
          <div>
            <div class="widgetbar">
              <a href="{{route('course.index')}}" class="float-right btn btn-primary-rgba mr-2" title="{{ __('Back') }}"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form action="{{url('course/')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-3">
                <label>{{ __('Category') }}:<span class="redstar">*</span></label>
                <select name="category_id" id="category_id" class="form-control select2">
                  <option value="0">{{ __('SelectanOption') }}</option>
                  @foreach($category as $cate)
                  <option value="{{$cate->id}}">{{$cate->title}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <label>{{ __('SubCategory') }}:<span class="redstar">*</span></label>
                <select name="subcategory_id" id="upload_id" class="form-control select2">
                </select>
              </div>
              <div class="col-md-3">
                <label>{{ __('ChildCategory') }}:</label>
                <select name="childcategory_id" id="grand" class="form-control select2"></select>
              </div>
              <div class="col-md-3">
                <label for="exampleInputTit1e">{{ __('Instructor') }}<span class="redstar">*</span></label>
                <select name="user_id" class="form-control js-example-basic-single col-md-7 col-xs-12">
                  @if(Auth::user()->role == 'admin')
                  <option value="{{Auth::user()->id}}">{{Auth::user()->fname}} {{Auth::user()->lname}}</option>
                  @foreach($users as $user)
                  <option value="{{$user->id}}">{{$user->fname}} {{$user->lname}}</option>
                  @endforeach
                  @else
                  <option value="{{Auth::user()->id}}">{{Auth::user()->fname}}</option>
                  @endif
                </select>
              </div>
              <br>
              <div class="col-md-12">
                <div class="form-group">
                  <label>{{ __("Also In Categories :") }}</label>
                  <select multiple="multiple" name="other_cats[]" id="other_cats" class="form-control select2">
                    @foreach($category as $category)
                    <option {{ old('other_cats') != '' && in_array($category->id,old('other_cats')) ? "selected" : "" }} value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                  </select>
                  <small class="text-primary">
                    <i class="feather icon-help-circle"></i> {{ __("If in list primary category is also present then it will auto remove from this after create product.") }}
                  </small>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <label>{{ __('Language') }}: <span class="redstar">*</span></label>
                <select name="language_id" class="form-control select2">
                  @php
                  $languages = App\CourseLanguage::all();
                  @endphp
                  @foreach($languages as $caat)
                  <option {{ $caat->language_id == $caat->id ? 'selected' : "" }} value="{{ $caat->id }}">{{ $caat->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-4">
                @php
                $ref_policy = App\RefundPolicy::all();
                @endphp
                <label for="exampleInputSlug">{{ __('Select Refund Policy') }} <span class="redstar">*</span></label>
                <select name="refund_policy_id" class="form-control select2">
                  <option value="none" selected disabled hidden>
                    {{ __('SelectanOption') }}
                  </option>
                  @foreach($ref_policy as $ref)
                  <option value="{{ $ref->id }}">{{ $ref->name }}</option>
                  @endforeach
                </select>

              </div>

              @if(Auth::User()->role == "admin")
              <div class="col-md-4">
                <label>{{ __('Institute') }}: <span class="redstar">*</span></label>
                <select name="institude_id" class="form-control select2">
                  @php
                  $institute = App\Institute::where('status' ,'1')->get();
                  @endphp
                  <option value="none" selected disabled hidden>
                    {{ __('SelectanOption') }}
                  </option>
                  @foreach($institute as $inst)
                  <option value="{{ $inst->id }}">{{ $inst->title }}</option>
                  @endforeach
                </select>
              </div>
              @endif

              @if(Auth::User()->role == "instructor")
              <div class="col-md-4">
                <label>{{ __('Institute') }}: <span class="redstar">*</span></label>
                <select name="institude_id" class="form-control select2">
                  @php
                  $institute = App\Institute::where('user_id',Auth::user()->id)->where('status' ,'1')->get();
                  @endphp
                  <option value="none" selected disabled hidden>
                    {{ __('SelectanOption') }}
                  </option>
                  @foreach($institute as $inst)
                  <option value="{{ $inst->id }}">{{ $inst->title }}</option>
                  @endforeach
                </select>
              </div>
              @endif


            </div>
            <br>



            <div class="row">
              <div class="col-md-6">
                <label for="exampleInputTit1e">{{ __('Course Name') }}: <sup class="redstar">*</sup></label>
                <input type="title" class="form-control" name="title" value ="{{ old('title') }}" id="title" placeholder="{{ __('Enter Course Name') }}" value="{{ (old('title')) }}" required>
              </div>
              <div class="col-md-6">
                <label for="exampleInputSlug">{{ __('Slug') }}: <sup class="redstar">*</sup></label>
                <input  type="text" class="form-control" name="slug" value ="{{ old('slug') }}" id="slug" placeholder="{{ __('Enter Slug') }}" value="{{ (old('slug')) }}" required>
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-md-6">
                <label for="exampleInputTit1e">{{ __('Short Detail') }}: <sup class="redstar">*</sup></label>
                <textarea name="short_detail" rows="3" class="form-control" placeholder="{{ __('Enter Short Detail') }}" required>{{ (old('short_detail')) }}</textarea>
              </div>
              <div class="col-md-6">
                <label for="exampleInputTit1e">{{ __('Requirements') }}: <sup class="redstar">*</sup></label>
                <textarea name="requirement" rows="3" class="form-control" placeholder="{{ __('Enter Requirements') }}" required>{{ (old('requirement')) }}</textarea>
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputTit1e">{{ __('Detail') }}: <sup class="redstar">*</sup></label>
                <textarea id="detail" name="detail" rows="3" class="form-control">{{ (old('detail')) }}</textarea>
              </div>
            </div>
            <br>

            <!-- country start -->
            <div class="row">
              <div class="col-md-4">

                <label>{{ __('Country') }}: </label>
                <select class="select2-multi-select form-control" name="country[]" multiple="multiple">
                  @foreach($countries as $country)
                  <option>{{ $country->name }}</option>
                  @endforeach
                </select>

                <small class="text-info"><i class="fa fa-question-circle"></i> ({{ __('Select those countries where you want to block course.')}} )</small>

              </div>
            <!-- country end -->

            @if(Auth::User()->role == "admin")
            
              <div class="col-md-4">
                <label for="exampleInputSlug">{{ __('Label') }}:</label>
                <select class="form-control js-example-basic-single" name="level_tags">
                  <option value="none" selected disabled hidden>
                    {{ __('Select an Option') }}
                  </option>
                  <option value="trending">{{ __('Trending') }}</option>
                  <option value="onsale">{{ __('On-sale') }}</option>
                  <option value="bestseller">{{ __('Best Seller') }}</option>
                  <option value="beginner">{{ __('Beginner') }}</option>
                  <option value="intermediate">{{ __('Intermediate') }}</option>
                  <option value="expert">{{ __('Expert') }}</option>
                </select>
              </div>            

            @endif            

           
              <div class="col-md-4">
                <label>{{ __('Course Tags') }}: <span class="redstar">*</span></label>
                <select class="select2-multi-select form-control" name="course_tags[]" multiple="multiple" size="5" row="1" >
                  <option></option>
                </select>

              </div>
            </div>
            <br>



            <div class="row">
              <div class="col-md-12 d-none">


                <label for="exampleInputSlug">{{ __('Return Available') }}</label>
                <select name="refund_enable" class="form-control js-example-basic-single col-md-7 col-xs-12">
                  <option value="none" selected disabled hidden>
                    {{ __('Select an Option') }}
                  </option>

                  <option value="1">{{ __('Return Available') }}</option>
                  <option value="0">{{ __('Return Not Available') }}</option>

                </select>

              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-3">
                <label for="exampleInputDetails">{{ __('Paid') }}:</label>
                <input type="checkbox" class="custom_toggle" id="cb111" name="type" />
                <label class="tgl-btn" data-tg-off="{{ __('Free') }}" data-tg-on="{{ __('Paid') }}" for="cb111"></label>

                <br>
                <div style="display: none;" id="pricebox">
                  <label for="exampleInputSlug">{{ __('Price') }}: <sup class="redstar">*</sup></label>
                  <input type="number" step="0.01" class="form-control" name="price" id="priceMain" placeholder="{{ __('Enter Course Price') }}" value="{{ (old('price')) }}">

                  <label for="exampleInputSlug">{{ __('Discounted Price') }}: </label>
                  <input type="number" step="0.01" class="form-control" name="discount_price" id="offerPrice" placeholder="{{ __('Enter Discounted Price') }}" value="{{ (old('discount_price')) }}">
                </div>
              </div>
              <div class="col-md-3 d-none">
                {{-- <label for="exampleInputDetails">{{ __('Money Back') }}:</label>
                <input type="checkbox" class="custom_toggle" id="cb01" name="type" checked />
                <label class="tgl-btn" data-tg-off="{{ __('No') }}" data-tg-on="{{ __('Yes') }}" for="cb01"></label> --}}
                {{-- <input type="hidden" name="free" value="0" id="cb10"> --}}
                <br>
                {{-- <div class="display-none" id="dooa">
        
                  <label for="exampleInputSlug">{{ __('Days') }}: <sup class="redstar">*</sup></label>
                <input type="number" min="1" class="form-control" name="day" id="exampleInputPassword1" placeholder="{{ __('Enter') }} {{ __('Days') }}" value="">

              </div> --}}
            </div>

            <div class="col-md-3">
              @if(Auth::User()->role == "admin")
              <label for="exampleInputDetails">{{ __('Featured') }}:</label>
              <input type="checkbox" class="custom_toggle" id="cb1" name="featured" checked />
              <label class="tgl-btn" data-tg-off="{{ __('OFF') }}" data-tg-on="{{ __('ON') }}" for="cb1"></label>
              {{-- <input type="hidden" name="featured" value="0" id="j"> --}}
              @endif
            </div>
            <div class="col-md-3">
              @if(Auth::User()->role == "admin")
              <label for="exampleInputDetails">{{ __('Status') }}:</label>
              <input type="checkbox" class="custom_toggle" name="status" id="cb3" checked />
              <label class="tgl-btn" data-tg-off="{{ __('Deactive') }}" data-tg-on="{{ __('Active') }}" for="cb3"></label>
              {{-- <input type="hidden" name="status" id="test"> --}}
              @endif
            </div>

            <div class="col-md-3">
              <label for="exampleInputDetails">{{ __('Involvement Request') }}:</label>
              <input name="involvement_request" type="checkbox" class="custom_toggle" id="involve" checked />
              <label class="tgl-btn" data-tg-off="{{ __('OFF') }}" data-tg-on="{{ __('ON') }}" for="involve"></label>

            </div>
        </div>
        <br>

        <div class="row">
          <div class="col-md-3">
            <label for="exampleInputDetails">{{ __('Preview Video') }}:</label>
            <input id="preview" type="checkbox" class="custom_toggle" name="preview_type" />
            <label class="tgl-btn" data-tg-off="{{ __('URL') }}" data-tg-on="{{ __('Upload') }}" for="preview"></label>

            <div style="display: none;" id="document1">
              <label for="exampleInputSlug">{{ __('Upload Video') }}:</label>
              <input type="file" name="video" id="video" value="" class="form-control">
            </div>
            <div id="document2">
              <label for="">{{ __('URL') }}: </label>
              <input type="url" name="url" id="url" placeholder="{{ __('Enter URL') }}" class="form-control" value="{{ (old('url')) }}">
            </div>
          </div>



          <div class="col-md-3">
            <label for="">{{ __('Duration') }}: </label>
            <input id="duration_type" type="checkbox" class="custom_toggle" name="duration_type" checked />
            <label class="tgl-btn" data-tg-off="{{ __('Days') }}" data-tg-on="{{ __('Month') }}" for="duration_type"></label>
            <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('If enabled duration can be in months') }},</small>
            <small class="text-muted"> {{ __('when Disabled duration can be in days') }}.</small>
            <br>
            <label for="exampleInputSlug">{{ __('Course Expire Duration') }}</label>
            <input min="1" class="form-control" name="duration" type="number" id="duration" placeholder="{{ __('Enter Course Expire Duration') }}" value="{{ (old('duration')) }}">
          </div>
        </div>

        <br>

        <div class="row">
          @if(Auth::user()->role == 'instructor')
          <div class="col-md-4">
            <label class="text-dark" for="exampleInputSlug">{{ __('Preview Image') }}: </label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="file">{{ __('Upload') }}</span>
              </div>
              <div class="custom-file">
                <input type="file" name="preview_image" class="custom-file-input" id="file" aria-describedby="inputGroupFileAddon01">
                <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
              </div>
            </div>
          </div>
          @endif

          @if(Auth::user()->role == 'admin')
          <div class="col-md-4">
            <label class="text-dark">{{ __('Image') }}:<span class="text-danger">*</span></label><br>
            <div class="input-group mb-3">
              <input type="text" class="form-control" readonly id="image" name="preview_image">
              <div class="input-group-append">
                <span data-input="image" class="midia-toggle btn-primary  input-group-text" id="basic-addon2">{{ __('Browse') }}</span>
              </div>
            </div>
          </div>
          @endif


          <div class="col-md-4">
            @if(Auth::User()->role == "admin")
            <label for="Revenue">{{ __('Instructor Revenue') }} %:</label>
            <div class="input-group">
              <input min="1" max="100" class="form-control" name="instructor_revenue" type="number" id="revenue" placeholder="{{ __('Enter Instructor Revenue') }} %" class="{{ $errors->has('instructor_revenue') ? ' is-invalid' : '' }} form-control" value="{{ (old('instructor_revenue')) }}">
              <span class="input-group-addon"><i class="fa fa-percent"></i></span>
            </div>
            @endif
          </div>
        </div>
        </br>
        <br>


        <div class="row">
          <div class="col-sm-3">

            <label for="exampleInputDetails">{{ __('Assignment') }}:</label>
            <input {{ old('assignment_enable') == "0" ? '' : "checked" }} id="frees" type="checkbox" class="custom_toggle" name="assignment_enable" checked />
            <label class="tgl-btn" data-tg-off="{{ __('No') }}" data-tg-on="{{ __('Yes') }}" for="frees"></label>

          </div>

          <div class="col-sm-3">

            <label for="exampleInputDetails">{{ __('Appointment') }}:</label>
            <input {{ old('appointment_enable') == "0" ? '' : "checked" }} id="frees1" type="checkbox" class="custom_toggle" name="appointment_enable" checked />
            <label class="tgl-btn" data-tg-off="{{ __('No') }}" data-tg-on="{{ __('Yes') }}" for="frees1"></label>

          </div>

          <div class="col-sm-3">
            <label for="exampleInputDetails">{{ __('Certificate Enable') }}:</label>
            <input {{ old('certificate_enable') == "0" ? '' : "checked" }} id="frees2" type="checkbox" class="custom_toggle" name="certificate_enable" checked />
            <label class="tgl-btn" data-tg-off="{{ __('No') }}" data-tg-on="{{ __('Yes') }}" for="frees2"></label>
          </div>

          <div class="col-sm-3">
            <label for="">{{ __('Drip Content') }}: </label>
            <input id="drip_enable" type="checkbox" class="custom_toggle" name="drip_enable" checked />
            <label class="tgl-btn" data-tg-off="Disable" data-tg-on="Enable" for="drip_enable"></label>
          </div>
        </div>
        <br>
        <br>
        <div class="form-group">
          <button type="reset" class="btn btn-danger-rgba" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __('Reset') }}</button>
          <button type="submit" class="btn btn-primary-rgba" title="{{ __('Create') }}"><i class="fa fa-check-circle"></i>
            {{ __('Create') }}</button>
        </div>

        <div class="clear-both"></div>
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
  (function($) {
    "use strict";

    $(function() {
      $('.js-example-basic-single').select2({
        tags: true,
        tokenSeparators: [',', ' ']
      });
    });

    $(function() {
      $('#cb1').change(function() {
        $('#j').val(+$(this).prop('checked'))
      })
    })

    $(function() {
      $('#cb3').change(function() {
        $('#test').val(+$(this).prop('checked'))
      })
    })

    $('#cb111').on('change', function() {

      if ($('#cb111').is(':checked')) {
        $('#pricebox').show('fast');

        $('#priceMain').prop('required', 'required');

      } else {
        $('#pricebox').hide('fast');

        $('#priceMain').removeAttr('required');
      }

    });

    $('#preview').on('change', function() {

      if ($('#preview').is(':checked')) {
        $('#document1').show('fast');
        $('#document2').hide('fast');
      } else {
        $('#document2').show('fast');
        $('#document1').hide('fast');
      }

    });

    $("#cb3").on('change', function() {
      if ($(this).is(':checked')) {
        $(this).attr('value', '1');
      } else {
        $(this).attr('value', '0');
      }
    });

    $(function() {

      $('#ms').change(function() {
        if ($('#ms').val() == 'yes') {
          $('#doabox').show();
        } else {
          $('#doabox').hide();
        }
      });

    });

    $(function() {

      $('#ms').change(function() {
        if ($('#ms').val() == 'yes') {
          $('#doaboxx').show();
        } else {
          $('#doaboxx').hide();
        }
      });

    });

    $(function() {

      $('#msd').change(function() {
        if ($('#msd').val() == 'yes') {
          $('#doa').show();
        } else {
          $('#doa').hide();
        }
      });

    });

    $(function() {
      var urlLike = '{{ url('admin/dropdown') }}';
      $('#category_id').change(function() {
        var up = $('#upload_id').empty();
        var cat_id = $(this).val();
        if (cat_id) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: urlLike,
            data: {
              catId: cat_id
            },
            success: function(data) {
              console.log(data);
              up.append('<option value="0">Please Choose</option>');
              $.each(data, function(id, title) {
                up.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
            }
          });
        }
      });
    });

    $(function() {
      var urlLike = '{{ url('admin/gcat') }}';
      $('#upload_id').change(function() {
        var up = $('#grand').empty();
        var cat_id = $(this).val();
        if (cat_id) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: urlLike,
            data: {
              catId: cat_id
            },
            success: function(data) {
              console.log(data);
              up.append('<option value="0">Please Choose</option>');
              $.each(data, function(id, title) {
                up.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
            }
          });
        }
      });
    });
  })(jQuery);
</script>


<script>
  $(".midia-toggle").midia({
    base_url: '{{ url('') }}',
    title: 'Choose Course Image',
    dropzone: {
      acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif'
    },
    directory_name: 'course'
  });
</script>


@endsection