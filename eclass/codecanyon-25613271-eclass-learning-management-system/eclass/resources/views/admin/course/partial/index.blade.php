@extends('admin.layouts.master')
@section('title','All Course')
@section('maincontent')
<?php
$data['heading'] = 'All Course';
$data['title'] = 'Courses';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  <!-- Start row -->
  <!--=========master check box fro bulk delete start ==============================================-->
  <!--=========master check box fro bulk delete start ==============================================-->
  <div class="card dashboard-card m-b-30">
    <!-- Card header will display you the heading -->
    <div class="row p-4">
      <div class="col-lg-4 col-md-12">
        <form class="navbar-form" role="search">
          <div class="input-group ">
            <form method="get" action="">
              <input value="{{ app('request')->input('title') ?? '' }}" type="text" name="searchTerm" cllass="form-control float-left text-center" placeholder="{{__('Search Courses')}}">
              <button type="submit" class="search-button"><i class="fa fa-search"></i></button>
            </form>
            @if(app('request')->input('searchTerm') != '')
            <a role="button" title="Back" href="{{ url('course') }}" name="clear" value="search" id="clear_id"
                class="btn btn-warning-rgba btn-xs" title="{{ __('Clear Search') }}">
                {{ __('Clear Search') }}
            </a>
            @endif
         
          </div>
        </form>
      </div>
      <div class="col-lg-8 col-md-12 menus-button text-right mb-2">
        <a href="{{url('course/create')}}" class="btn btn-primary-rgba mr-2" title="{{ __('Add Course') }}"
><i
              class="feather icon-plus mr-2"></i>{{ __('Add Course') }}</a>
      
          @if(Auth::User()->role == "admin" )
            <button type="button" class="btn btn-danger-rgba mr-2" data-toggle="modal" data-target="#bulk_delete" title="{{ __('Delete Selected') }}"
><i
              class="feather icon-trash mr-2"></i> {{ __('Delete Selected') }}</button>
              <button type="button" class="btn btn-success-rgba mr-2" title="{{ __('Select All') }}"
>
                <div class="select-all-checkbox">
        
                  <div>
                    <input id="checkboxAll" type="checkbox" class="filled-in width-15 height-15 t-3 position-relative"
                      name="checked[]" value="all" />
                    <label for="checkboxAll" class="material-checkbox"></label> {{ __('Select All') }}
                  </div>                  
          
                </div>
          
              </button>
          @endif
          
        
          <li class="list-inline-item">
            <div class="settingbar">
              <a href="javascript:void(0)" id="infobar-settings-open" class="btn btn-warning-rgba" title="{{ __('Filter') }}"
>
                <i class="feather icon-filter mr-2"></i>{{ __('Filter') }}
              </a>
            </div>
          </li>
          <form action="" method="get" class="filterForm">
            <div id="infobar-settings-sidebar" class="infobar-settings-sidebar">
              <div class="infobar-settings-sidebar-head d-flex w-100 justify-content-between">
                <h4>{{ __('Filtered') }}</h4>
                <a href="javascript:void(0)" id="infobar-settings-close" class="btn btn-primary close" title="{{ __('Close') }}"
>
                  <img src="admin_assets/assets/images/svg-icon/close.svg" class="img-fluid menu-hamburger-close" alt="close">
                </a>
              </div>
              <div class="infobar-settings-sidebar-body">
                <div class="custom-mode-setting">
                  <div class="row align-items-center">
                    <div class="col-8">
                      <h6 class="mb-0 filter">{{ __('Price') }}</h6>
                    </div>
                   
                    <div class="col-4 text-right">
                      <div class="form-group">
                        <div class="update-password1">
                          <input type="checkbox" id="myCheck1" name="type" class="custom_toggle" onclick="myFunction()" checked>
                        </div>
                      </div>
                    </div>
                    <div style="display: none" id="update-password1">
                      <div class="form-group text-right col-md-12">
                        <select required="" name="type" id="myCheck1" class="form-control select2">
                          <option value="paid">{{ __('Paid') }}</option>
                          <option value="free">{{ __('Free') }}</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="custom-mode-setting">
                  <div class="row align-items-center pb-3">
                    <div class="col-8">
                      <h6 class="mb-0 filter">{{ __('Status') }}</h6>
                    </div>
                    <div class="col-4 text-right"><input type="checkbox" name="status" class="custom_toggle" checked/></div>
                  </div>
      
                </div>
                <div class="custom-mode-setting">
                  <div class="row align-items-center pb-3">
                    <div class="col-8">
                      <h6 class="mb-0 filter">{{ __('Featured') }}</h6>
                    </div>
                    <div class="col-4 text-right"><input type="checkbox" name="featured" class="custom_toggle" checked/></div>
                  </div>
      
                </div>
                <div class="custom-mode-setting">
                  <div class="row align-items-center pb-3">
                    <div class="col-8">
                      <h6 class="mb-0 filter">{{__('A-Z')}}</h6>
                    </div>
                    <div class="col-4 text-right"><input type="checkbox" name="asc" class="custom_toggle"  checked/></div>
                  </div>
      
                </div>
                <div class="custom-mode-setting">
                  <div class="row align-items-center pb-3">
                    <div class="col-8">
                      <h6 class="mb-0 filter">{{__('Z-A')}}</h6>
                    </div>
                    <div class="col-4 text-right"><input type="checkbox" name="desc" class="custom_toggle"  checked/></div>
                  </div>
      
                </div>
                <div class="infobar-settings-sidebar-body">
                  <div class="custom-mode-setting">
                    <div class="row align-items-center pb-3">
                      <div class="col-8">
                        <h6 class="mb-0 filter">{{ __('Category') }}</h6>
                      </div>
                      
                        <div class="col-4 text-right">
                          <div class="form-group">
                            <div class="update-password">
                              <input type="checkbox" id="myCheck" name="category_id" class="custom_toggle" onclick="myFunction()" checked>
                            </div>
                          </div>
                        </div>
                        <div style="display: none" id="update-password">
                            <div class="form-group text-right col-md-12">
                              <select autofocus="" class="form-control select2" name="category_id">
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach($categorys as $category)
            
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                              </select>            
                            </div>
                        </div>              
                    </div>        
                  </div>
                </div>
              </div>
              <div class="form-group col-md-12 text-center">
                <button type="reset" class="btn btn-danger reset-btn" title="{{ __('Reset Filter') }}"
                ><i class="fa fa-ban"></i> {{ __('Reset Filter') }}</button>
                                <button type="submit" class="btn btn-primary" title="{{ __('Apply Filter') }}"
                ><i class="fa fa-check-circle"></i>
                  {{ __('Apply Filter') }}</button>
              </div>
            </div>
          </form>
      </div>
    </div>
  </div>
  
  <div class="partial-course-main-block">
    <div class="row">
      <div class="col-lg-3 col-md-6">
        <div class="card partial-course-block">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-6">
                  <h4>{{ $active }}</h4>
                  <p class="font-14 mb-0">{{__('Active Course')}}</p>
              </div> 
              <div class="col-6 text-right">
                <i class="text-info feather icon-book-open icondashboard"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="card partial-course-block">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-6">
                  <h4>{{ $deactive }}</h4>
                  <p class="font-14 mb-0">{{__('Pending Course')}}</p>
              </div> 
              <div class="col-6 text-right">
                <i class="text-danger feather icon-link icondashboard"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="card partial-course-block">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-6">
                  <h4>{{ $free }}</h4>
                  <p class="font-14 mb-0">{{__('Free Course')}}</p>
              </div> 
              <div class="col-6 text-right">
                <i class="text-success feather icon-file-text icondashboard"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="card partial-course-block-one">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-6">
                  <h4>{{ $paid }}</h4>
                  <p class="font-14 mb-0">{{__('Paid Course')}}</p>
              </div> 
              <div class="col-6 text-right">
                <i class="text-warning feather icon-dollar-sign icondashboard"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 mt-3 text-center">
      @if(request()->get('searchTerm'))
          <h5 class="">{{ __("Showing") }} {{ filter_var($course->count()) }} {{ __("of") }} {{ filter_var($course->total()) }} {{ __("results for ") }} "<span class="text-primary">{{  Request::get('searchTerm') }}</span>"</h5>
          <div class="clearfix"></div>
        @endif
    </div>
  
    @forelse($course as $cat)
      
      <div class="col-lg-4 mb-4">
        <input type='checkbox' form='bulk_delete_form'
          class='form-card-input check filled-in material-checkbox-input position-absolute width-25 height-25 l-30 t-13'
          name='checked[]' value="{{ $cat->id }}" id='checkbox{{ $cat->id }}'>
        <label for='checkbox{{ $cat->id }}' class='material-checkbox'></label>
        <div class="card partial-course-img">
          @if($cat['preview_image'] !== NULL && $cat['preview_image'] !== '' && @file_get_contents('images/course/'.$cat['preview_image']))
          <img class="card-img-top" src="{{ url('images/course/'.$cat['preview_image']) }}" alt="{{ $cat->title }}">
          <div class="overlay-bg"></div>
          @else
          <img class="card-img-top" src="{{ Avatar::create($cat->title)->toBase64() }}" alt="{{ $cat->title }}">
          <div class="overlay-bg"></div>
          @endif
          <div class="card-img-block">
            <a href="{{ route('user.course.show',['slug' => $cat->slug ]) }}" target="_blank" title="{{ $cat->title }}"><h4 class="mt-3 card-title" style="color:white;">{{ $cat->title }}</h4></a>
            <p class="card-sub-title" style="color:white;">@if(isset($cat->user)) {{ $cat->user['fname'] }} @endif</p>
          </div>
          <div class="card-user-img">
            @if($image = @file_get_contents('../public/images/user_img/'.$cat->user->user_img))

              <img @error('photo') is-invalid @enderror src="{{ url('images/user_img/'.$cat->user->user_img) }}" alt="{{ $cat->user['fname'] }}" class="img-fluid" data-toggle="modal" data-target="#exampleStandardModal{{ $cat->user->id }}">

            @else

              <img @error('photo') is-invalid @enderror src="{{ Avatar::create($cat->user->fname)->toBase64() }}" alt="{{ $cat->user['fname'] }}" class="img-fluid w-h-100" data-toggle="modal" data-target="#exampleStandardModal{{ $cat->user->id }}">

            
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
                <a href="#" style="color:black">{{ __('Featured') }}
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
                          {{ __('Deactive') }}
                        @endif
                  </span>
                </a>
          
              </li>
              @endif
            </ul>

          </div>
          <div class="card-footer">
            <div class="row mt-3 mb-3">
              <div class="col-1"></div>
              <div class="col-2">
                <a href="{{ route('course.show',$cat->id) }}" title="{{ __('Edit') }}"
>

                  <i title="Edit" class="feather icon-edit"></i></a>
              </div>
              <div class="col-2">
                <a data-toggle="modal" data-target="#delete{{ $cat->id }}" title="{{ __('Delete') }}"
>
                  <i title="Delete" class="text-primary feather icon-trash"></i></a>

                <div class="modal fade bd-example-modal-sm" id="delete{{$cat->id}}" tabindex="-1" role="dialog"
                  aria-hidden="true">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}"
>
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <h4>{{ __('Are You Sure ?')}}</h4>
                        <p>{{ __('Do you really want to delete')}} ? {{ __('This process cannot be undone.')}}</p>
                      </div>
                      <div class="modal-footer">
                        <form method="post" action="{{url('course/'.$cat->id)}}" class="pull-right">
                          {{csrf_field()}}
                          {{method_field("DELETE")}}
                          <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
                          <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-2">
                <a href="{{ route('user.course.show',['slug' => $cat->slug ]) }}" target="_blank"
                  title="{{ __('View Course') }}">

                  <i class="feather icon-eye"></i></a>
              </div>

            

              <!--==================bulk delete start========================================-->

              <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" title="{{ __('Close') }}"
>&times;</button>
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

              <!--=================== bulk delete end =======================================--->
              <div class="modal fade" id="exampleStandardModal{{$cat->user->id}}" tabindex="-1"
                role="dialog" aria-labelledby="exampleStandardModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleStandardModalLabel">
                                {{ $cat->user->fname }}</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close" title="{{ __('Close') }}"
>
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-lg-12">
                                <div class="card m-b-30">
                                    <div class="card-body py-5">
                                        <div class="row">
                                            <div class="user-modal">
                                                @if($image =
                                                @file_get_contents('../public/images/user_img/'.$cat->user->user_img))
                                                <img @error('photo') is-invalid @enderror
                                                    src="{{ url('images/user_img/'.$cat->user->user_img) }}"
                                                    alt="{{ $cat->user->fname }} {{ $cat->user->lname }}"
                                                    class="img-responsive img-circle">
                                                @else
                                                <img @error('photo') is-invalid @enderror
                                                    src="{{ Avatar::create($cat->user->fname)->toBase64() }}"
                                                    alt="{{ $cat->user->fname }} {{ $cat->user->lname }}"
                                                    class="img-responsive img-circle">
                                                @endif
                                            </div>
                                            <div class="col-lg-12">
                                                <h4 class="text-center">
                                                    {{ $cat->user->fname }} {{ $cat->user->lname }}
                                                </h4>
                                                <div class="button-list mt-4 mb-3">
                                                    <a href="mailto:{{ $cat->user->email }}" class="btn btn-primary-rgba" title="{{ $cat->user->email }}"><i class="feather icon-email mr-2"></i>{{ $cat->user->email }}</a>
                                                    <a href="tel:{{ $cat->user->mobile }}" 
                                                        class="btn btn-success-rgba" title="{{ $cat->user->mobile }}"><i
                                                            class="feather icon-phone mr-2"></i>{{ $cat->user->mobile }}</a>
                                                </div>
                                                <div class="table-responsive">
                                                    <table
                                                        class="table table-borderless mb-0 user-table">
                                                        <tbody>
                                                          
                                                            @isset($cat->user->address )

                                                            <tr>
                                                                <th scope="row" class="p-1">
                                                                    {{__('Address :')}}</th>
                                                                <td class="p-1">
                                                                    {{ $cat->user->address}}</td>
                                                            </tr>
                                                            @endisset                                        

                                                            @isset($cat->user->role )

                                                            <tr>
                                                              <th scope="row" class="p-1">
                                                              {{__('Role :')}}</th>
                                                              <td class="p-1">
                                                                  {{ $cat->user->role}}</td>
                                                          </tr>
                                                          @endisset

                                                        

                                                          <tr>
                                                            <th scope="row" class="p-1">
                                                            {{__('Country State City')}}</th>
                                                            <td class="p-1">
                                                                {{ optional($cat->user->country)->name}}-{{ optional($cat->user->state)->name}}-{{ optional($cat->user->city)->name}}</td>
                                                        </tr>
                                                    

                                                        @isset($cat->user->youtube_url )

                                                        <tr>
                                                            <th scope="row" class="p-1">
                                                            {{__('YouTube URL')}}</th>
                                                            <td class="p-1">
                                                                <a href="{{$cat->user->youtube_url}}" target="_blank" title="{{str_limit($cat->user->youtube_url)}}">{{str_limit($cat->user->youtube_url, '30')}}</a></td>
                                                        </tr>
                                                        @endisset

                                                        @isset($cat->user->fb_url )

                                                        <tr>
                                                            <th scope="row" class="p-1">
                                                                {{__('Facebook URL')}}</th>
                                                            <td class="p-1">
                                                                <a href="{{$cat->user->fb_url}}" target="_blank" title="{{str_limit($cat->user->fb_url)}}">{{str_limit($cat->user->fb_url, '30')}}</a></td>
                                                        </tr>
                                                        @endisset

                                                        @isset($cat->user->twitter_url )

                                                        <tr>
                                                            <th scope="row" class="p-1">
                                                                {{__('Twitter URL')}}</th>
                                                            <td class="p-1">
                                                                <a href="{{$cat->user->twitter_url}}" target="_blank" title="{{str_limit($cat->user->twitter_url, '30')}}">{{str_limit($cat->user->twitter_url)}}</a></td>
                                                        </tr>
                                                        @endisset

                                                        @isset($cat->user->linkedin_url )

                                                        <tr>
                                                            <th scope="row" class="p-1">
                                                                {{__('Linkedin URL')}}</th>
                                                            <td class="p-1">
                                                                <a href="{{$cat->user->linkedin_url}}" target="_blank" title="{{str_limit($cat->user->linkedin_url, '30')}}">{{str_limit($cat->user->linkedin_url)}}</a></td>
                                                            </td>
                                                        </tr>
                                                        @endisset


                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

              @if(Module::has('Homework') && Module::find('Homework')->isEnabled())
              <div class="col-2">
                @include('homework::admin.icon')
              </div>
              @endif

              <div class="col-2 duplicate">


                <a href="#" title="{{ __('Duplicate Course')}}">
                  <form action="{{ route('course.duplicate',$cat->id) }}" method="POST">
                    {{ csrf_field() }}
                    <button type="Submit" class="btn mr-3">
                      <i class="text-primary feather icon-copy"></i>
                    </button>
                  </form>
                </a>


              </div>
              <div class="col-1"></div>
            </div>
          </div>



        </div>
      </div>
      @empty
      <h3 class="col-md-12 mt-5 text-center">
        <i class="fa fa-frown-o text-warning"></i> {{ __("No Course Found !") }}
      </h3>
    @endforelse
  </div>
  <div class="row">
    <div class="col-md-12 my-5">
        <div class="pull-right">
          {!! $course->render() !!}
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