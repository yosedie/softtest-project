@extends('admin.layouts.master')
@section('title','All Assignment')
@section('maincontent')
<?php
$data['heading'] = 'View Course Assignments';
$data['title'] = 'Courses';
$data['title1'] = 'Assignments';
$data['title2'] = 'View Course Assignments';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card"> 
  <div class="row">
       <div class="col-lg-12">
          <div class="card dashboard-card m-b-30">
              <div class="card-header">

                  <h5 class="box-title">{{ __('View Course Assignments') }}</h5>
                  <div>
                    <div class="widgetbar">
                        @can('assignment.delete')
                        <a href="{{ url('/all/assignment') }}" class="float-right btn btn-primary mr-2" title="{{ __('Back') }}"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
                        <button type="button" class="float-right btn btn-danger-rgba mr-2 " data-toggle="modal" data-target="#bulk_delete" title="{{ __('Delete Selected') }}"><i
                            class="feather icon-trash mr-2"></i> {{ __('Delete Selected') }}</button>
                     @endcan
                    </div>                        
                </div>
              </div>
              <div class="card-body">
              
                  <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                          <tr>
                            <th>
                              <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                              value="all" />
                          <label for="checkboxAll" class="material-checkbox"></label>   # 
                          </th>
                          <th>{{ __('User') }}</th>
                          <th>{{ __('Course') }}</th>
                          <th>{{ __('Course Chapter') }}</th>
                          <th>{{ __('Assignment') }}</th>
                          <th>{{ __('Action') }}</th>
                         
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0;?>
                        @foreach($assignment as $assign)
                          <tr>
                            <?php $i++;?>
                            <td>
                                                     
                              <input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input'
                                  name='checked[]' value='{{ $assign->id }}' id='checkbox{{ $assign->id }}'>
                              <label for='checkbox{{ $assign->id }}' class='material-checkbox'></label>
                              <?php echo $i; ?>
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
                                              <p>{{ __('Do you really want to delete selected item names here? This process
                                                  cannot be undone') }}.</p>
                                          </div>
                                          <div class="modal-footer">
                                              <form id="bulk_delete_form" method="post"
                                                  action="{{ route('assignment.bulk_delete') }}">
                                                  @csrf
                                                  @method('POST')
                                                  <button type="reset" class="btn btn-gray translate-y-3"
                                                      data-dismiss="modal">{{ __('No') }}</button>
                                                  <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                                              </form>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                            </td>
                          <td>@if(isset($assign->user)) {{$assign->user->fname}} @endif</td>
                          <td>@if(isset($assign->courses)) {{$assign->courses->title}} @endif</td>
                          <td>@if(isset($assign->chapter)) {{$assign->chapter->chapter_name}} @endif</td>
                          <td>{{ $assign->title }}
                           <a href="{{ asset('files/assignment/'.$assign->assignment) }}" download="{{$assign->assignment}}" class="ml-2"> <i class="fa fa-download"></i></a>
                          </td>
                      <td><div class="dropdown">
                        <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings') }}"><i class="feather icon-more-vertical-"></i></button>
                        <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                            @can('assignment.view')
                           
                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#exampleStandardModal{{ $assign->id }}" title="{{ __('View') }}">
                              <i class="feather icon-eye mr-2"></i>{{__('View')}}
                            </button>
                            @endcan
                            <a class="dropdown-item" href="{{ asset('files/assignment/'.$assign->assignment) }}"  download="{{$assign->assignment}}" title="{{ __('Download') }}"><i class="feather icon-download mr-2"></i>{{ __('Download') }}</a>
                            @can('assignment.delete')

                            <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $assign->id }}" title="{{ __('Delete') }}">
                                <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                            </a>
                            @endcan
                        </div>
                    </div>


                    <div class="modal fade" id="exampleStandardModal{{ $assign->id}}" tabindex="-1"role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleStandardModalLabel">
                                  {{__('View Course Chapter Assignments')}}</h5>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close" title="{{ __('Close') }}">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                              <div class="card">
                                  <div class="card-body py-4">
                                    <div class="view-instructor">
                                      <div class="instructor-detail">
                                        <div class="instructor-detail-img text-center"> 
                                          @if($assign->user->user_img != null || $assign->user->user_img !='')
                                            <img src="{{ asset('images/user_img/'.$assign->user->user_img) }}" class="img-circle" alt="{{ $assign->user->fname }} {{ $assign->user->lname }}" />
                                          @else
                                            <img src="{{ asset('images/default/user.jpg')}}" class="img-circle" alt="{{ $assign->user->fname }} {{ $assign->user->lname }}">
                                          @endif
                                        </div>
                                        <div class="mt-3">
                                          <h4 class="text-center">{{ $assign->user->fname }} {{ $assign->user->lname }}</h4>
                                        </div>
                                        <br>
                                        <div class="table-responsive">
                                          <table class="table table-borderless mb-0 user-table">
                                            <tbody>
                                              <tr>
                                                <th scope="row" class="p-1">{{ __('Course') }} : </th>
                                                <td class="p-1"> {{ $assign->courses->title }}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row" class="p-1">{{ __('Course Chapter') }} : </th>
                                                <td class="p-1"> {{ $assign->chapter->chapter_name }}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row" class="p-1">{{ __('Assignment Title') }} : </th>
                                                <td class="p-1">{{ $assign->title }}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row" class="p-1">{{ __('Assignment') }} : </th>
                                                <td class="p-1"> <a href="{{ asset('files/assignment/'.$assign->assignment) }}" download="{{$assign->assignment}}" title="{{ __('Download') }}">{{ __('Download') }} <i class="fa fa-download"></i></a></td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </div>
                                        <br>
                                        <br>
                                        <form action="{{route('assignment.update',$assign->id)}}" method="POST" enctype="multipart/form-data">
                                          {{ csrf_field() }}
                                          {{ method_field('PUT') }}
                                          <input type="hidden" value="{{ $assign->user_id }}" name="user_id" class="form-control">
                                          <input type="hidden" value="{{ $assign->course_id }}" name="course_id" class="form-control">
                                          <div class="row">
                                            <div class="col-md-5">
                                              <label for="exampleInputTit1e">{{ __('Review Assignment') }}:</label>
                                              <br>
                                            </div>
                                            <div class="col-md-7">
                                              <input id="assign_accept" type="checkbox" class="custom_toggle" name="type"
                                              {{ $assign->type == 1 ? 'checked' : '' }} />
                                              <label class="tgl-btn" data-tg-off="Unchecked" data-tg-on="Checked" for="assign_accept"></label>
                                            </div>
                                          </div>
                                          <br>
                                          <div class="row" style="{{ $assign['type'] == '1' ? '' : 'display:none' }}" id="sec1_one">
                                            <div class="col-md-5">
                                              <label for="exampleInputDetails">{{ __('Give scores to assignment') }} (1 to 10):</label>
                                            </div>
                                            <div class="col-md-7">
                                              <input min="1" max="10" class="form-control" name="rating" type="number" id="rating" value="{{ $assign->rating }}" placeholder="Enter Duration in months">
                                            </div>
                                          </div>
                                          <br>
                                          <br>
                                          <div class="form-group">
                                            <button type="reset" class="btn btn-danger-rgba" title="{{ __('Reset') }}"><i class="fa fa-ban"></i>
                                              {{ __('Reset') }}</button>
                                            <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update') }}"><i class="fa fa-check-circle"></i>
                                              {{ __('Update') }}</button>
                                          </div>
                                          <div class="clear-both"></div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>

                    <!-- delete Modal start -->
                    <div class="modal fade bd-example-modal-sm" id="delete{{$assign->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <h4>{{ __('Are You Sure ?')}}</h4>
                                        <p>{{ __('Do you really want to delete')}} ? {{ __('This process cannot be undone.')}}</p>
                                </div>
                                <div class="modal-footer">
                                    <form method="post" action="{{url('assignment/'.$assign->id)}}" class="pull-right">
                                        {{csrf_field()}}
                                        {{method_field("DELETE")}}
                                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
                                        <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- delete Model ended -->

                </td>
                          
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End col -->
</div>
<!-- End row -->
</div>
@endsection


@section('script')
   <script type="text/javascript">
  $( function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  } );

   $("#sortable").sortable({
   update: function (e, u) {
    var data = $(this).sortable('serialize');
   
    $.ajax({
        url: "{{ route('slider_reposition') }}",
        type: 'get',
        data: data,
        dataType: 'json',
        success: function (result) {
          console.log(data);
        }
    });

  }

});
  </script>
   <script>
    $("#checkboxAll").on('click', function () {
$('input.check').not(this).prop('checked', this.checked);
});
</script>
<script>
  (function ($) {
    "use strict";

    $(function () {

      $('#assign_accept').change(function () {
        if ($('#assign_accept').is(':checked')) {
          $('#sec1_one').show('fast');
          $('#sec_one').hide('fast');
        } else {
          $('#sec1_one').hide('fast');
          $('#sec_one').show('fast');
        }

      });

    });
  })(jQuery);
</script>

@endsection
