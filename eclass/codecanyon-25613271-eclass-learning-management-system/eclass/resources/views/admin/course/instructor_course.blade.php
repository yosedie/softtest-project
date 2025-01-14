@extends('admin.layouts.master')
@section('title','All Course')
@section('maincontent')
<?php
$data['heading'] = 'Modified Courses Review';
$data['title'] = 'Modified Courses Review';
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
  
    @forelse($course as $cat)
      
      <div class="col-lg-4 m-b-50 pb-4">
        
        <div class="card partial-course-img">
          @if($cat['preview_image'] !== NULL && $cat['preview_image'] !== '' && @file_get_contents('images/course/'.$cat['preview_image']))
          <img class="card-img-top" src="{{ url('images/course/'.$cat['preview_image']) }}" alt="{{ $cat->title }}">
          <div class="overlay-bg"></div>
          @else
          <img class="card-img-top" src="{{ Avatar::create($cat->title)->toBase64() }}" alt="{{ $cat->title }}">
          <div class="overlay-bg"></div>
          @endif
          <div class="card-img-block">
            <h4 class="mt-3 card-title" style="color:white;">{{ $cat->title }}</h4>
            <p class="card-sub-title" style="color:white;">@if(isset($cat->user)) {{ $cat->user['fname'] }} @endif</p>
          </div>
          <div class="card-user-img">
            @if($image = @file_get_contents('../public/images/user_img/'.$cat->user->user_img))

              <img @error('photo') is-invalid @enderror src="{{ url('images/user_img/'.$cat->user->user_img) }}" alt="{{ $cat->user['fname'] }}" class="img-fluid" data-toggle="modal" data-target="#exampleStandardModal{{ $cat->user->id }}">
            @else

              <img @error('photo') is-invalid @enderror src="{{ Avatar::create($cat->user->fname)->toBase64() }}" alt="{{ $cat->user['fname'] }}" class="img-fluid w-h-100" data-toggle="modal" data-target="#exampleStandardModal{{ $cat->user->id }}"  >

            
            @endif
            
          </div>
          <div class="card-body">
            <ul class="partial-course-status">
              <li style="list-style-type: none;" class="mt-4">
                <a href="#" style="color:black">{{ __('Type') }} 
                  <span class="button-align">
                    @if($cat->type == '1')
                      paid
                      @else
                      Free
                    @endif
                  </span>
                </a>
              </li>
              @if(Auth::user()->role == 'admin')
              <li style="list-style-type: none;" class="mt-3"> 
                <a href="#" style="color:black">{{ __('Features') }}<span class="button-align">
                <input  data-id="{{$cat->id}}" type="checkbox"  class="custom_toggle status1" name="featured" {{ $cat->featured == 1 ? 'checked' : ''}} />
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
            </ul>

          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-lg-12 text-right">
                <a href="{{ route('instructor.course.show',['id' => $cat->id, 'slug' => $cat->slug ]) }}" title="{{ __('Review') }}" type="button" class="btn btn-primary">{{ __('Review') }}
                </a>
              </div>

            

              <!--==================bulk delete start========================================-->

              <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" title="{{ __('close') }}">&times;</button>
                      <div class="delete-icon"></div>
                    </div>
                    <div class="modal-body text-center">
                      <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                      <p>{{ __('Do you really want to delete selected item ? This process
                        cannot be undone') }}.</p>
                    </div>
                    <div class="modal-footer">
                      <form id="bulk_delete_form" method="post" action="{{ route('instructor.cource.delete') }}">
                        @csrf
                        @method('POST')
                        <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __('No') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>


            
              <div class="col-1"></div>
            </div>
          </div>



        </div>
      </div>
      <br>
      <br>
      @empty
      <h3 class="col-md-12 mt-5 text-center">
        <i class="fa fa-frown-o text-warning"></i> {{ __("No Course Found !") }}
      </h3>
    @endforelse

    <br>


    <div class="form-group col-md-6 mt-5">
      <div class="col-xs-12">

        <div class="pull-right">
          {!! $course->render() !!}
        </div>
      </div>
    </div>
  </div>
  <!-- End row -->
</div>

@endsection
@section('script')

<script>
  $(function () {
    $('.status1').change(function () {
      var featured = $(this).prop('checked') == true ? 1 : 0;

      var id = $(this).data('id');


      $.ajax({
        type: "GET",
        dataType: "json",
        url: 'cource-featured-status',
        data: {
          'featured': featured,
          'id': id
        },
        success: function (data) {
          console.log(id)
        }
      });
    });
  });
</script>
<!-- script to change featured-status end -->
<!-- script to change status start -->
<script>
  $(function () {
    $('.status2').change(function () {
      var status = $(this).prop('checked') == true ? 1 : 0;

      var id = $(this).data('id');


      $.ajax({
        type: "GET",
        dataType: "json",
        url: 'cource-status',
        data: {
          'status': status,
          'id': id
        },
        success: function (data) {
          console.log(id)
        }
      });
    });
  });
</script>
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