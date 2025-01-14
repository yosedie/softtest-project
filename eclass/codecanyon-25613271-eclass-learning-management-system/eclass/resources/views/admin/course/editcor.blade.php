<div class="row">
  <div class="col-lg-12">
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="card m-b-30">
      <div class="card-header">
        <h5 class="card-box">{{ __('Edit') }} {{ __('Course') }}</h5>
      </div>
      <div class="card-body ml-2">
        <form action="{{route('course.update',$cor->id)}}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          {{ method_field('PUT') }}

          <div class="row">
            <div class="col-md-3">
              <label>{{ __('Category') }}<span class="redstar">*</span></label>
              <select name="category_id" id="category_id" class="form-control js-example-basic-single" required>
                <option value="0">{{ __('SelectanOption') }}</option>
                @php
                $category = App\Categories::all();
                @endphp

                @foreach($category as $caat)
                <option {{ $cor->category_id == $caat->id ? 'selected' : "" }} value="{{ $caat->id }}">{{ $caat->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label>{{ __('SubCategory') }}:<span class="redstar">*</span></label>
              <select name="subcategory_id" id="upload_id" class="form-control js-example-basic-single">
                @php
                $subcategory =App\SubCategory::where('category_id', $cor->category_id)->get();
                @endphp
                <option value="none" selected disabled hidden>
                  {{ __('SelectanOption') }}
                </option>
                @if(!empty($subcategory))
                @foreach($subcategory as $caat)
                <option {{ $cor->subcategory_id == $caat->id ? 'selected' : "" }} value="{{ $caat->id }}">{{ $caat->title }}</option>
                @endforeach
                @endif
              </select>
            </div>
            <div class="col-md-3">
              <label>{{ __('ChildCategory') }}:</label>
              <select name="childcategory_id" id="grand" class="form-control js-example-basic-single">
                @php
                $childcategory = App\ChildCategory::where('subcategory_id', $cor->subcategory_id)->get();
                @endphp
                <option value="none" selected disabled hidden>
                  {{ __('SelectanOption') }}
                </option>
                @if(!empty($childcategory))
                @foreach($childcategory as $caat)
                <option {{ $cor->childcategory_id == $caat->id ? 'selected' : "" }} value="{{ $caat->id }}">{{ $caat->title }}</option>
                @endforeach
                @endif
              </select>
            </div>
            <div class="col-md-3">
              <label for="exampleInputSlug">{{ __('SelectUser') }}</label>
              <select name="user_id" class="form-control js-example-basic-single col-md-7 col-xs-12">
                @if(Auth::user()->role == 'admin')
                @foreach($users as $user)
                <option {{ $cor->user_id == $user->id ? 'selected' : "" }} value="{{ $user->id }}">{{ $user->fname }}</option>
                @endforeach
                @else
                <option value="{{ Auth::user()->id }}">{{ Auth::user()->fname }}</option>
                @endif
              </select>
            </div>
          </div>
          <br>

          @php
          $category = App\Categories::all();
          @endphp


          <div class="col-md-12">
            <div class="form-group">
              <label>{{ __("Also in :") }}</label>
              <select multiple="multiple" name="other_cats[]" id="other_cats" class="form-control select2">
                @php
                $category = App\Categories::all();
                @endphp

                @foreach($category as $caat)
                <option value="{{ $caat->id }}">{{ $caat->title }}</option>
                <!-- <option {{ $cor->category_id == $caat->id ? 'selected' : "" }} value="{{ $caat->id }}">{{ $caat->title }}</option> -->
                @endforeach
              </select>

              <small class="text-primary">
                <i class="feather icon-help-circle"></i> {{ __("If in list primary category is also present then it will auto remove from this after create product.") }}
              </small>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              @php
              $languages = App\CourseLanguage::all();
              @endphp
              <label for="exampleInputSlug">{{ __('SelectLanguage') }}: <span class="redstar">*</span></label>
              <select name="language_id" class="form-control js-example-basic-single col-md-7 col-xs-12">
                <option value="none" selected disabled hidden>
                  {{ __('SelectanOption') }}
                </option>
                @foreach($languages as $cat)
                <option {{ $cor->language_id == $cat->id ? 'selected' : "" }} value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>


            <div class="col-md-4">

              @php
              $ref_policy = App\RefundPolicy::all();
              @endphp
              <label for="exampleInputSlug">{{ __('SelectRefundPolicy') }}</label>
              <select name="refund_policy_id" class="form-control js-example-basic-single col-md-7 col-xs-12">
                <option value="none" selected disabled hidden>
                  {{ __('SelectanOption') }}
                </option>
                @foreach($ref_policy as $ref)
                <option {{ $cor->refund_policy_id == $ref->id ? 'selected' : "" }} value="{{ $ref->id }}">{{ $ref->name }}</option>
                @endforeach
              </select>
            </div>

            @if(Auth::User()->role == "admin")
            <div class="col-md-4">
              <label>{{ __('Institute') }}: <span class="redstar">*</span></label>
              <select name="institude_id" class="form-control select2">
                @php
                $institute = App\Institute::all();
                @endphp
                <option value="0" disabled hidden>
                  {{ __('SelectanOption') }}
                </option>
                @foreach($institute as $inst)
                <option value="{{ $inst->id }}" {{$inst->id  == $cor->institude_id ? 'selected' : ''}}>{{ $inst->title }}</option>
                @endforeach
              </select>
            </div>
            @endif
            @if(Auth::User()->role == "instructor")
            <div class="col-md-4">
              <label>{{ __('Institute') }}: <span class="redstar">*</span></label>
              <select name="institude_id" class="form-control select2">
                @php
                $institute = App\Institute::where('user_id',Auth::user()->id)->get();
                @endphp
                <option value="0" disabled hidden>
                  {{ __('SelectanOption') }}
                </option>
                @foreach($institute as $inst)
                <option value="{{ $inst->id }}" {{$inst->id  == $cor->institude_id ? 'selected' : ''}}>{{ $inst->title }}</option>
                @endforeach
              </select>
            </div>
            @endif
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="exampleInputTit1e">{{ __('Title') }}:<sup class="redstar">*</sup></label>
              <input type="text" class="form-control" name="title" id="title" value="{{ $cor->title }}">
            </div>

            <div class="col-md-6">
              <label for="exampleInputSlug">{{ __('Slug') }}: <sup class="redstar">*</sup></label>
              <input id="slug" type="text" class="form-control" name="slug" value="{{ $cor->slug}}" required>
            </div>
          </div>
          <br>

          <div class="row">
            <div class="col-md-6">
              <label for="exampleInputDetails">{{ __('ShortDetail') }}:<sup class="redstar">*</sup></label>
              <textarea name="short_detail" rows="3" class="form-control">{!! $cor->short_detail !!}</textarea>
            </div>
            <div class="col-md-6">
              <label for="exampleInputDetails">{{ __('Requirements') }}:<sup class="redstar">*</sup></label>
              <textarea name="requirement" rows="3" class="form-control" required>{!! $cor->requirement !!}</textarea>
            </div>
          </div>
          <br>


          <br>
          @if(Auth::User()->role == "admin")

          <div class="row">
            <div class="col-md-6">
              <label for="exampleInputSlug">{{ __('Level/Type Tags') }}</label>
              <select class="form-control js-example-basic-single" name="level_tags">
                <option value="0" disabled hidden>
                  {{ __('SelectanOption') }}
                </option>

                <option {{ $cor->level_tags == 'trending' ? 'selected' : ''}} value="trending">{{ __('Trending') }}</option>

                <option {{ $cor->level_tags == 'onsale' ? 'selected' : ''}} value="onsale">{{ __('Onsale') }}</option>

                <option {{ $cor->level_tags == 'bestseller' ? 'selected' : ''}} value="bestseller">{{ __('Bestseller') }}</option>

                <option {{ $cor->level_tags == 'beginner' ? 'selected' : ''}} value="beginner">{{ __('Beginner') }}</option>

                <option {{ $cor->level_tags == 'intermediate' ? 'selected' : ''}} value="intermediate">{{ __('Intermediate') }}</option>

                <option {{ $cor->level_tags == 'expert' ? 'selected' : ''}} value="expert">{{ __('Expert') }}</option>

              </select>

            </div>




            <div class="col-md-6">
              <label for="exampleInputSlug">{{ __('CourseTags') }}</label>
              <select class="select2-multi-select form-control" name="course_tags[]" multiple="multiple" size="5">


                @if(is_array($cor['course_tags']) || is_object($cor['course_tags']))

                @foreach($cor['course_tags'] as $cat)

                <option value="{{ $cat }}" {{in_array($cat, $cor['course_tags'] ?: []) ? "selected": ""}}>{{ $cat }}
                </option>


                @endforeach
                @endif

              </select>
            </div>

          </div>
          <br>
          <br>

          @endif



          <div class="row">
            <div class="col-md-12">
              <label for="exampleInputDetails">{{ __('Detail') }}:<sup class="redstar">*</sup></label>
              <textarea id="detail" name="detail" rows="3" class="form-control">{!! $cor->detail !!}</textarea>
            </div>
          </div>
          <br>


          <!-- country start -->
          <div class="row">
            <div class="col-md-12">

              <label>{{ __('Country') }}: <span></span></label>
              <select class="select2-multi-select form-control" name="country[]" multiple="multiple">
                @foreach($countries as $country)
                <option {{in_array($country->name, $cor->country ?: []) ? "selected": ""}} value="{{ $country->name }}">{{ $country->name }}</option>
                @endforeach
              </select>

              <small class="text-info"><i class="fa fa-question-circle"></i> ({{ __('Select those countries where you want to block courses')}} )</small>

            </div>
          </div>
          <br>
          <!-- country end -->

          <div class="row">
            {{-- <div class="col-md-3 display-none">
                  <label for="exampleInputDetails">{{ __('MoneyBack') }}:</label><br>
            <label class="switch">
              <input class="slider" type="checkbox" id="customSwitch1" name="money" {{ $cor->day != '' ? 'checked' : '' }} />
              <span class="knob"></span>
            </label>

            <br>

            <div style="{{ $cor->day == 1 ? '' : 'display:none' }}" id="jeet">
              <label for="exampleInputSlug">{{ __('Days') }}:<sup class="redstar">*</sup></label>
              <input type="number" min="1" class="form-control" name="day" id="exampleInputPassword1" placeholder="{{ __('Enter') }} day" value="{{ $cor->day }}">
            </div>
          </div> --}}
          <div class="col-md-3">
            <label for="exampleInputDetails">{{ __('Paid') }}:</label><br>
            <label class="switch">
              <input class="slider" type="checkbox" id="customSwitch2" name="type" {{ $cor->type == '1' ? 'checked' : '' }} />
              <span class="knob"></span>
            </label>

            <br>

            <div style="{{ $cor->type == 1 ? '' : 'display:none' }}" id="doabox">
              <label for="exampleInputSlug">{{ __('Price') }}: <sup class="redstar">*</sup></label>
              <input step="0.01" type="text" inputmode="numeric" pattern="[-+]?[0-9]*[.,]?[0-9]+" class="form-control" name="price" id="priceMain" placeholder="{{ __('Enter') }} {{ __('Price') }}" value="{{ $cor->price }}">

              <br>
              <label for="exampleInputSlug">{{ __('DiscountPrice') }}: <sup class="redstar">*</sup></label>
              <input step="0.01" type="text" inputmode="numeric" pattern="[-+]?[0-9]*[.,]?[0-9]+" class="form-control" name="discount_price" id="exampleInputPassword1" placeholder="{{ __('Enter') }} {{ __('DiscountPrice') }}" value="{{ $cor->discount_price }}">
            </div>
          </div>

          <div class="col-md-3">
            @if(Auth::User()->role == "admin")
            <label for="exampleInputTit1e">{{ __('Featured') }}:</label><br>
            <label class="switch">
              <input class="slider" type="checkbox" id="customSwitch6" name="featured" {{ $cor->featured==1 ? 'checked' : '' }} />
              <span class="knob"></span>
            </label>

            @endif
          </div>
          <div class="col-md-3">
            @if(Auth::User()->role == "admin")
            <label for="exampleInputTit1e">{{ __('Status') }}:</label><br>
            <label class="switch">
              <input class="slider" type="checkbox" id="customSwitch6" name="status" {{ $cor->status==1 ? 'checked' : '' }} />
              <span class="knob"></span>
            </label>


            @endif
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="exampleInputDetails">{{ __('Instructor InvolvementRequest') }}:</label><br>
              <label class="switch">
                <input class="slider" type="checkbox" id="customSwitch6" name="involvement_request" {{ $cor->involvement_request==1 ? 'checked' : '' }} />
                <span class="knob"></span>
              </label>


            </div>
          </div>
          <br>


          <div class="col-md-4">
            <label for="exampleInputDetails">{{ __('PreviewVideo') }}:</label><br>
            <label class="switch">
              <input class="slider" type="checkbox" id="customSwitch61" name="preview_type" {{ $cor->preview_type=="video" ? 'checked' : '' }} />


              <span class="knob"></span>
            </label>




            <div style="{{ $cor->preview_type == 'url' ? 'display:none' : '' }}" id="document1">
              <br>
              <label for="exampleInputSlug">{{ __('UploadVideo') }}: <sup class="redstar">*</sup></label>
              <!-- -------------- -->
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                </div>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="inputGroupFile01" name="video" value="{{ $cor->video }}" aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                </div>
              </div>
              @if($cor->video !="")
              <video src="{{ asset('video/preview/'.$cor->video) }}" width="200" height="150" controls>
              </video>
              @endif
              <!-- -------------- -->
            </div>

            <div @if($cor->preview_type =="video") class="display-none" @endif id="document2">
              <br>
              <label for="exampleInputSlug">{{ __('URL') }}: <sup class="redstar">*</sup></label>
              <input type="url" class="form-control" placeholder="{{ __('Enter') }} URL" name="url" id="url" value="{{ $cor->url }}">
            </div>
          </div>

          <div class="col-md-4">
            <label for="">{{ __('Duration') }}: </label><br>
            <label class="switch">
              <input class="slider" type="checkbox" name="duration_type" {{ $cor->duration_type == "m" ? 'checked' : '' }} />
              <span class="knob"></span>
            </label>
            <br>
            <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('If enabled duration can be in months') }}.</small><br>
            <small class="text-info"> {{ __('when Disabled duration can be in days') }}.</small>

            <br>
            <label for="exampleInputSlug">{{ __('Course Expire Duration') }}</label>
            <input min="1" class="form-control" name="duration" type="number" id="duration" value="{{ $cor->duration }}" placeholder="{{ __('Enter') }} {{ __('Duration') }}">
          </div>
      </div>
      <br>

      <div class="row">

        @if(Auth::user()->role == 'instructor')
        <div class="col-md-6">
          <label>{{ __('PreviewImage') }}{{__(':size: 270x200')}}</label>
          <br>
          <!-- ====================== -->
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
            </div>
            <div class="custom-file">
              <input type="text" class="custom-file-input" id="inputGroupFile01" name="preview_image" value="{{ $cor->preview_image }}">
              <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
            </div>
          </div>
          @if($cor['preview_image'] !== NULL && $cor['preview_image'] !== '')
          <img src="{{ url('/images/course/'.$cor->preview_image) }}" height="70px;" width="70px;" />
          @else
          <img src="{{ Avatar::create($cor->title)->toBase64() }}" alt="course" class="img-fluid">
          @endif
          <!-- ====================== -->
          <br>
        </div>

        @endif

        @if(Auth::user()->role == 'admin')

        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label" for="first-name">{{ __('Image') }} <span class="required">*</span> </label>

            <div class="input-group">

              <input required readonly id="image" name="preview_image" type="text" class="form-control" value="{{$cor['preview_image'] != NULL ? $cor['preview_image'] : '' }}">
              <div class="input-group-append">
                <span data-input="image" class="bg-primary text-light midia-toggle input-group-text">{{ __('Browse') }}</span>
              </div>
            </div>

            <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{ __('Choose Image for 
                          post') }})</small>
            <br>

            @if($cor['preview_image'] !== NULL && $cor['preview_image'] !== '')
            <img src="{{ url('/images/course/'.$cor->preview_image) }}" height="70px;" width="70px;" />
            @else
            <img src="{{ Avatar::create($cor->title)->toBase64() }}" alt="course" class="img-fluid">
            @endif
          </div>
        </div>

        @endif




        <div class="col-md-6">
          @if(Auth::User()->role == "admin")
          <label for="Revenue">{{ __('Instructor Revenue') }}:</label>

          <div class="input-group">

            <input min="1" max="100" class="form-control" name="instructor_revenue" type="number" value="{{ $cor['instructor_revenue'] }}" id="revenue" placeholder="Enter revenue percentage" class="{{ $errors->has('instructor_revenue') ? ' is-invalid' : '' }} form-control">
            <span class="input-group-addon"><i class="fa fa-percent"></i></span>
          </div>
          @endif
        </div>
      </div>
      <br>

      <div class="row">
        <div class="col-sm-3">

          <label for="exampleInputDetails">{{ __('Assignment') }}:</label><br>
          <label class="switch">
            <input class="slider" type="checkbox" name="assignment_enable" {{ $cor['assignment_enable']=="1" ? 'checked' : '' }} />
            <span class="knob"></span>
          </label>
          <br>
          <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('To enable assignment on portal') }}
          </small>

        </div>

        <div class="col-sm-3">

          <label for="exampleInputDetails">{{ __('Appointment') }}:</label><br>
          <label class="switch">
            <input class="slider" type="checkbox" name="appointment_enable" {{ $cor['appointment_enable']=="1" ? 'checked' : '' }} />
            <span class="knob"></span>
          </label>

        </div>

        <div class="col-sm-3">

          <label for="exampleInputDetails">{{ __('CertificateEnable') }}:</label><br>
          <!--  -->
          <label class="switch">
            <input class="slider" type="checkbox" name="certificate_enable" id="customSwitch10" {{ $cor['certificate_enable'] == "1" ? 'checked' : '' }} />
            <span class="knob"></span>
          </label>

        </div>

        <div class="col-sm-3">

          <label for="">{{ __('DripContent') }}: </label><br>
          <label class="switch">
            <input class="slider" type="checkbox" name="drip_enable" {{ $cor['drip_enable'] == 1 ? 'checked' : '' }} />
            <span class="knob"></span>
          </label>
          <br>
          <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('To release content on chapter & classes by a specific date or amount of days after enrollment') }}.
          </small>
        </div>
      </div>
      <br>
      <br>
      <br>

      <div class="box-footer">
        <button type="submit" class="btn btn-lg col-md-3 btn-primary-rgba">{{ __('Save') }}</button>
      </div>

      </form>
    </div>
  </div>
</div>
</div>
<!-- edit media Modal start -->

<!-- edit media Model ended -->
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
        $('#f').val(+$(this).prop('checked'))
      })
    })

    $(function() {
      $('#cb3').change(function() {
        $('#test').val(+$(this).prop('checked'))
      })
    })

    $(function() {

      $('#murl').change(function() {
        if ($('#murl').val() == 'yes') {
          $('#doab').show();
        } else {
          $('#doab').hide();
        }
      });

    });

    $(function() {

      $('#murll').change(function() {
        if ($('#murll').val() == 'yes') {
          $('#doabb').show();
        } else {
          $('#doab').hide();
        }
      });

    });

    $('#customSwitch2').change(function() {
      if ($('#customSwitch2').is(':checked')) {
        $('#doabox').show('fast');

        $('#priceMain').prop('required', 'required');

      } else {
        $('#doabox').hide('fast');

        $('#priceMain').removeAttr('required');
      }

    });

    $('#customSwitch61').on('change', function() {

      if ($('#customSwitch61').is(':checked')) {
        $('#document1').show('fast');
        $('#document2').hide('fast');

      } else {
        $('#document2').show('fast');
        $('#document1').hide('fast');
      }

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