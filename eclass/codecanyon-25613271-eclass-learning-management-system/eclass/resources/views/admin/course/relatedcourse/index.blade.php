<div class="row">
  <div class="col-lg-12">
    <div class="card m-b-30">
      <div class="card-header">
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        @can('related-courses.delete')
        <button type="button" class="btn btn-danger-rgba mr-2" data-toggle="modal" data-target="#bulk_delete5">
          <i
            class="feather icon-trash mr-2"></i>{{ __(' Delete Selected') }}
        </button>
        @endcan
        @can('related-courses.create')
        <a data-toggle="modal" data-target="#myModalabc" href="#" class="btn btn-primary-rgba">
          <i class="feather icon-plus mr-2"></i>{{ __('Add Related Course') }}</a>
          @endcan
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="" class="displaytable table table-striped table-bordered w-100">
            <thead>
              <tr>
                <th>
                  <input id="checkboxAll5" type="checkbox" class="filled-in" name="checked[]"
                  value="all" />
              <label for="checkboxAll" class="material-checkbox"></label>   # 
              </th>
                <th>{{ __('RelatedCourse') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Action') }}</th>
            </thead>
            <tbody>
              <?php $i=0;?>
              @foreach($relatedcourse as $cat)
              <tr>
                <?php $i++;?>
                
                   <td>                                  
                    <input type="checkbox" form="bulk_delete_form5" class="filled-in material-checkbox-input5" name="checked[]" value="{{$cat->id}}" id="checkbox{{$cat->id}}">
                    <label for="checkbox{{$cat->id}}" class="material-checkbox"></label> <?php echo $i; ?>
                    <div id="bulk_delete5" class="delete-modal modal fade" role="dialog">
                        <div class="modal-dialog modal-sm">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <div class="delete-icon"></div>
                                </div>
                                <div class="modal-body text-center">
                                    <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                                    <p>{{ __('Do you really want to delete selected item ? This process
                                        cannot be undone') }}.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="bulk_delete_form5" method="post"
                                        action="{{ route('relatedcourse.bulk_delete') }}">
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


                <td>
                  @if($cat->courses)
                  {{$cat->courses->title}}
                  @endif
                </td>
                 <!-- ================================== -->
                 <td>
                    <label class="switch">
                      <input class="slider" type="checkbox"  data-id="{{$cat->id}}" name="status" {{ $cat->status ==1 ? 'checked' : ''}} onchange="relatedcource('{{$cat->id}}')" />
                      <span class="knob"></span>
                    </label>
                </td>
                <!-- ================================== -->
                <td>

                  <div class="dropdown">
                    <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                        class="feather icon-more-vertical-"></i></button>
                    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                      @can('related-courses.edit')
                      <a class="dropdown-item" href="{{url('relatedcourse/'.$cat->id)}}"><i
                          class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                          @endcan
                          @can('related-courses.delete')
                      <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $cat->id}}">
                        <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                      </a>
                      @endcan
                    </div>
                  </div>

                  <div class="modal fade bd-example-modal-sm" id="delete{{ $cat->id }}" tabindex="-1" role="dialog"
                    aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <h4>{{ __('Are You Sure ?')}}</h4>
                          <p>{{ __('Do you really want to delete')}} @if($cat->courses) <b>{{$cat->courses->title}}</b> @endif ? {{ __('This process cannot be undone.')}}</p>
                        </div>
                        <div class="modal-footer">
                          <form method="post" action="{{url('relatedcourse/'.$cat->id)}}" class="pull-right">
                            {{csrf_field()}}
                            {{method_field("DELETE")}}
                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>

              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="myModalabc" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="my-modal-title">
          <b>{{ __('Add Related Course') }}</b>
      </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
      </div>
      <div class="box box-primary">
        <div class="panel panel-sum">
          <div class="modal-body">
            <form id="demo-form2" method="post" action="{{ route('relatedcourse.store') }}" data-parsley-validate
              class="form-horizontal form-label-left">
              {{ csrf_field() }}

              
            <select class="d-none" name="user_id" class="form-control select2">
                <option value="{{ $cor->user_id }}"></option>
              </select>
              <div class="row display-none">
                <div class="col-md-12">
                  <label for="exampleInputSlug">{{ __('Course') }}</label>
                  <select name="main_course_id" class="form-control select2">
                    <option value="{{ $cor->id }}">{{ $cor->title }}</option>
                  </select>
                </div>
              </div>

              <br>
              <div class="row">
                <div class="col-md-12">
                  <label for="exampleInputDetails">{{ __('RelatedCourse') }}:<sup
                      class="redstar">*</sup></label>
                  @php
                  $courses = App\Course::all();
                  @endphp
                  <select style="width: 100%" name="course_id" class="form-control select2">
                    @foreach($courses as $course)
                    @if($course->id !== $cor->id)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endif
                    @endforeach
                  </select><br>
                  <small> {{ __('Select') }} {{ __('RelatedCourse') }}</small>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <label for="exampleInputDetails">{{ __('Status') }} :</label><br>
                    <label class="switch">
                      <input class="slider" type="checkbox" name="status" checked />
                      <span class="knob"></span>
                    </label>
                </div>
              </div>
              <br>

              <div class="form-group">
                <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{ __('Reset') }}</button>
                <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                  {{ __('Create') }}</button>
              </div>

              <div class="clear-both"></div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- script to change status start -->
<script>
  function  relatedcource(id){
    var status = $(this).prop('checked') == true ? 1 : 0; 
   
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('/quickupdate-relatedcourse/status/')}}/" + id,
        data: {'status': status, 'id': id},
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

    };
 
</script>
<!-- script to change status end -->


