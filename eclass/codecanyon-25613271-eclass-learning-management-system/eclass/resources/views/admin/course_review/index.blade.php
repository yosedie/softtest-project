@extends('admin.layouts.master')
@section('title','All Course review')
@section('maincontent')
<?php
$data['heading'] = 'Course Reviews';
$data['title'] = 'Courses';
$data['title1'] = 'Course Review';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar bardashboard-card"> 
        <div class="row">
            
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-box">{{ __('All Courses Reviews') }}</h5>
                    </div>
                    <div class="card-body">
                    
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th><input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                                      value="all" />
                                  <label for="checkboxAll" class="material-checkbox"></label> #</th>
                    <th>{{ __('Image') }}</th>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Instructor') }}</th>
                    <th>{{ __('Featured') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Action') }}</th>
                  </tr>
                </thead>

                <tbody>
                  <?php $i=0;?>

                    @foreach($course as $cat)
                    @if($cat->status == 0)
                      <?php $i++;?>
                      <tr>
                        <td>  <input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input'
                          name='checked[]' value="{{ $cat->id }}" id='checkbox{{ $cat->id }}'>
                      <label for='checkbox{{ $cat->id }}' class='material-checkbox'></label>
                      <?php echo $i; ?>
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
                                  <p{{ __('Do you really want to delete selected item names here? This process
                                      cannot be undone') }}>.</p>
                              </div>
                              <div class="modal-footer">
                                  <form id="bulk_delete_form" method="post"
                                      action="{{ route('coursereview.bulk_delete') }}">
                                      @csrf
                                      @method('POST')
                                      <button type="reset" class="btn btn-gray translate-y-3"
                                          data-dismiss="modal">{{ __('No') }}</button>
                                      <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div></td>
                        <td>
                          @if($cat['preview_image'] !== NULL && $cat['preview_image'] !== '')
                            <img src="images/course/<?php echo $cat['preview_image'];  ?>" class="img-responsive img-circle"  >
                          @else
                            <img src="{{ Avatar::create($cat->title)->toBase64() }}" class="img-responsive img-circle"  >
                          @endif
                        </td>
                        <td>{{$cat->title}}</td>
                        <td>{{ $cat->user->fname }}</td>
                        <td>
                          <label class="switch">
                            <input class="coursereviewfeaturedstatus" type="checkbox"  data-id="{{$cat->id}}" name="status"   {{ $cat->featured ==1 ? 'checked' : ''}}>
                            <span class="knob"></span>
                          </label>
                          </td>

                          <td>
                            <label class="switch">
                              <input class="coursereviewstatus" type="checkbox"  data-id="{{$cat->id}}" name="status"  {{ $cat->status == '1' ? 'checked' : '' }}>
                              <span class="knob"></span>
                            </label>
                            </td>
                            <td>
                          <div class="dropdown">
                              <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings') }}"><i class="feather icon-more-vertical-"></i></button>
                              <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                @can('course-reviews.edit')
                                  <a class="dropdown-item" href="{{ url('coursereview/'.$cat->id) }}" title="{{ __('Edit') }}"><i class="feather icon-eye

                                    mr-2"></i>{{ __('Edit') }}</a>
                                  
                                  </a>
                                  @endcan
                              </div>
                          </div>

                          <!-- delete Modal start -->
                         
                          <!-- delete Model ended -->

                      </td>
                      

                       
                      </tr>
                    @endif
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

<!-- script to change status start -->
<script>

"use Strict";

$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(document).on("change",".coursereviewfeaturedstatus",function() { 
      $.ajax({
          type: "POST",
          dataType: "json",
          url: "{{url('quickupdate/featured/course')}}",
          data: {'featured': $(this).is(':checked') ? 1 : 0, 'id': $(this).data('id')},
            success: function(data){
              console.log(data)
          }
        });
    })


   
      $(document).on("change",".coursereviewstatus",function() { 
        $.ajax({
          type: "POST",
          dataType: "json",
          url: "{{url('quickupdate/coursestatus')}}",
          data:   {'status': $(this).is(':checked') ? 1 : 0, 'id': $(this).data('id')},
            success: function(data){
            var warning = new PNotify( {
                title: 'success', text:'Status Update Successfully', type: 'success', desktop: {
                desktop: true, icon: 'feather icon-thumbs-down'
                }
              });
              warning.get().click(function() {
                warning.remove();
              });
          }
        });
    })
 
</script>
<!-- script to change featured status end -->
@endsection