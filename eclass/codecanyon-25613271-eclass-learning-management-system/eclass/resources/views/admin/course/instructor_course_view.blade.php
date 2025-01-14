@extends('admin.layouts.master')
@section('title','All Course')
@section('maincontent')
<?php
$data['heading'] = 'Course Review';
$data['title'] = 'Modified Courses Review';
$data['title1'] = 'Course Review';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar bardashboard-card">
  <!-- Start row -->
  <div class="row">
  <!--=========master check box fro bulk delete start ==============================================-->
  <!--=========master check box fro bulk delete start ==============================================-->
    <div class="col-lg-12 mt-3 text-center">
      @if(request()->get('searchTerm'))
        <h5 class="">{{ __("Showing") }} {{ filter_var($course->count()) }} {{ __("of") }} {{ filter_var($course->total()) }} {{ __("results for ") }} "<span class="text-primary">{{  Request::get('searchTerm') }}</span>"</h5>
        <div class="clearfix"></div>
      @endif
    </div>
    <div class="col-lg-12 m-b-50 pb-4">
      <div class="card partial-course-img">
          @if($cat['preview_image'] !== NULL && $cat['preview_image'] !== '' && @file_get_contents('images/course/'.$cat['preview_image']))
          <img class="card-img-top" src="{{ url('images/course/'.$cat['preview_image']) }}" alt="{{ $cat->title }}">
          <div class="overlay-bg"></div>
          @else
          <img class="card-img-top" src="{{ Avatar::create($cat->title)->toBase64() }}" alt=">{{ $cat->title }}">
          <div class="overlay-bg"></div>
          @endif
          <div class="card-img-block">
            <h4 class="mt-3 card-title" style="color:white;">{{ $cat->title }}</h4>
            <p class="card-sub-title" style="color:white;">@if(isset($cat->user)) {{ $cat->user['fname'] }} @endif</p>
          </div>
          <div class="card-user-img instructor-view-card-user-img">
            @if($image = @file_get_contents('../public/images/user_img/'.$cat->user->user_img))

              <img @error('photo') is-invalid @enderror src="{{ url('images/user_img/'.$cat->user->user_img) }}" alt="{{ $cat->user['fname'] }}" class="img-fluid" data-toggle="modal" data-target="#exampleStandardModal{{ $cat->user->id }}">

            @else

              <img @error('photo') is-invalid @enderror src="{{ Avatar::create($cat->user->fname)->toBase64() }}" alt="{{ $cat->user['fname'] }}" class="img-fluid w-h-100" data-toggle="modal" data-target="#exampleStandardModal{{ $cat->user->id }}"  >
            
            @endif
            
          </div>
          <div class="card-body">
              <div class="row">
                  <div class="col-lg-6">
                      <ul class="partial-course-status">
                          <li style="list-style-type: none;" class="mt-4">
                          <a href="#" style="color:black">{{ __('Type') }} 
                              <span class="button-align">
                              @if($cat->type == '1')
                                  {{__('paid')}}
                                  @else
                                  {{__('Free')}}
                              @endif
                              </span>
                          </a>
                          </li>
                          @if(Auth::user()->role == 'admin')
                          <li style="list-style-type: none;" class="mt-3"> 
                          <a href="#" style="color:black">{{ __('Features') }}<span class="button-align">
                          <input type="checkbox"  class="custom_toggle status1" name="featured" {{ $cat->featured == 1 ? 'checked' : ''}} />
                          </span>
                          </a>
                          
                          </li>
                          @else
                          <li style="list-style-type: none;" class="mt-3"> 
                          <a href="#" style="color:black">{{ __('Features') }}
                              <span class="button-align">
                          @if($cat->featured ==1)
                                  {{ __('Yes') }}
                                  @else
                                  {{ __('No') }}
                                  @endif
                          </span>
                          </a>
                          
                          </li>
                          @endif

                          @if(Auth::user()->role == 'admin')
                          <li style="list-style-type: none;" class="mt-3">
                          <a href="#" style="color:black">{{ __('Status') }}
                              <span class="button-align">
                              <input  data-id="{{$cat->id}}" type="checkbox"  class="custom_toggle status2" name="status" {{ $cat->status == 1 ? 'checked' : ''}} />
                              </span>
                          </a>
                      
                          </li>
                          @else
                          <li style="list-style-type: none;" class="mt-3">
                          <a href="#" style="color:black">{{ __('Status') }}
                              <span class="button-align">
                              @if($cat->status ==1)
                                      {{ __('Active') }}
                                  @else
                                      {{ __('Deactivate') }}
                                  @endif
                              </span>
                          </a>
                      
                          </li>
                          @endif                         
                          <li style="list-style-type: none;" class="mt-4">
                            <a href="#" style="color:black">{{__('Discounted Price')}}
                                <span class="button-align">
                                {{$cat->discount_price}}
                                </span>
                            </a>
                        </li>
                        
                      </ul>
                  </div>
                  <div class="col-lg-6">
                      <ul class="pl-0">
                          <li style="list-style-type: none;" class="mt-4">
                              <a href="#" style="color:black">{{__('Category')}}
                                  <span class="button-align">
                                  {{$cat->category_id?$cat->category->title:''}}
                                  </span>
                              </a>
                          </li>
                          <li style="list-style-type: none;" class="mt-4">
                              <a href="#" style="color:black">{{__('Sub Category')}}
                                  <span class="button-align">
                                  {{$cat->subcategory_id?$cat->sub_category->title:''}}
                                  </span>
                              </a>
                          </li>
                          <li style="list-style-type: none;" class="mt-4">
                              <a href="#" style="color:black">{{__('Language')}}
                                  <span class="button-align">
                                  {{$cat->language_id?$cat->language->name:''}}
                                  </span>
                              </a>
                          </li>
                          <li style="list-style-type: none;" class="mt-4">
                              <a href="#" style="color:black">{{__('Price')}}
                                  <span class="button-align">
                                  {{$cat->price}}
                                  </span>
                              </a>
                          </li>
                          <li style="list-style-type: none;" class="mt-4">
                            <a href="#" style="color:black">{{__('Duration')}}
                                <span class="button-align">
                                {{$cat->duration}} {{$cat->duration_type}}
                                </span>
                            </a>
                        </li>
                      </ul>
                  </div>
              </div>

          </div>
          <div class="card-footer course-review-btn mt-3 mb-3">
            <ul>
              <li>
                <a href="{{ route('instructor.course.verify',['id' => $cat->id, 'slug' => $cat->slug ]) }}"><button class="btn btn-outline-success" title="{{__('Verify')}}">{{__('Verify')}}</button></a>
              </li>
              <li>
                <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                 {{__(' Not Verified')}}
                </a>
              </li>
            </ul>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Not Verified')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="{{ route('instructor.course.notverify',['id' => $cat->id, 'slug' => $cat->slug ])}}" method="post" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label for="exampleInputEmail1">{{__('Reason')}}</label>
                        <input type="hidden" name ="course_id" value={{ $cat->id }}>
                        <input type="text" name ="reason" class="form-control" placeholder="Please Enter reason to reject this course">
                        <small id="emailHelp" class="form-text text-muted">{{__('Please Enter a reason')}}</small>
                      </div>
                      <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!--==================bulk delete start========================================-->

            <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
              <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" title="{{ __('Close') }}">&times;</button>
                    <div class="delete-icon"></div>
                  </div>
                  <div class="modal-body text-center">
                    <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                    <p>{{ __('Do you really want to delete selected item ? This process
                      cannot be undone') }}.</p>
                  </div>
                  <div class="modal-footer">
                    <form id="bulk_delete_form" method="post" action="{{ route('cource.bulk.delete') }}">
                      @csrf
                      @method('POST')
                      <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __('No') }}</button>
                      <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>



        </div>
      </div>
    </div>
  </div>
  <!-- End row -->
</div>

@endsection
@section('script')


<!-- script to change featured-status end -->
<!-- script to change status start -->

<script>
  (function($) {
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
  })(jQuery);
  </script>
<script>
  (function($) {
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
  })(jQuery);
  </script>
<script>
  $(document).ready(function () {
    $(".reset-btn").click(function () {
      var uri = window.location.toString();

      if (uri.indexOf("?") > 0) {

        var clean_uri = uri.substring(0, uri.indexOf("?"));

        window.history.replaceState({}, document.title, clean_uri);

      }

      location.reload();
    });
  });
</script>
<!-- script to change status end -->

<script>
    $('#search').on('change', function () {
        var v = $(this).val();
        if (v == 'search') {
            $('#clear_id').show();
            $('#clear').attr('required', '');
        } else {
            $('#clear_id').hide();
        }
    });
</script>
@endsection