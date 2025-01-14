<div class="row">
  <div class="col-lg-12">
    <div class="card m-b-30">
      <div class="card-header">
        @can('course-includes.delete')
        <button type="button" class="btn btn-danger-rgba mr-2" data-toggle="modal" data-target="#bulk_delete"><i
          class="feather icon-trash mr-2"></i>{{ __('Delete Selected') }}</button>
          @endcan
          @can('course-includes.create')
        <a data-toggle="modal" data-target="#myModalJ" href="#" class="btn btn-primary-rgba"><i
            class="feather icon-plus mr-2"></i>{{ __('Add Course Include') }}</a>
            @endcan
      </div>
      <div class="card-body">

        <div class="table-responsive">
          <table id="" class="displaytable table table-striped table-bordered w-100" >
            <thead>
              <tr>
                <th><input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                  value="all" />
              <label for="checkboxAll" class="material-checkbox"></label>#</th>
                <th>{{ __('Icon') }}</th>
                <th>{{ __('Detail') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Action') }}</th>

              </tr>
            </thead>

            <tbody>
                <?php $i=0;?>
                @foreach($courseinclude as $cat)
                <?php $i++;?>
              <tr>
                <td>    

               <input type="checkbox" form="bulk_delete_form1" class="filled-in material-checkbox-input" name="checked[]" value="{{$cat->id}}" id="checkbox{{$cat->id}}">
                    <label for="checkbox{{$cat->id}}" class="material-checkbox"></label>

              <?php echo $i; ?>

          <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
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
                          <form id="bulk_delete_form1" method="post"
                              action="{{ route('courseinclude.bulk_delete') }}">
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
                <td><i class="fa {{$cat->icon}}"></i></td>
                <td>{{ strip_tags($cat->detail) }}</td>
                <!-- ================================== -->
                <td>
                    <label class="switch">
                      <input class="slider" type="checkbox"  data-id="{{$cat->id}}" name="status" {{ $cat->status == '1' ? 'checked' : '' }} onchange="courceinclude('{{$cat->id}}')" />
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
                      @can('course-includes.edit')
                      <a class="dropdown-item" href="{{url('courseinclude/'.$cat->id)}}"><i
                          class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                          @endcan
                          @can('course-includes.delete')
                      <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $cat->id}}">
                        <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                      </a>
                      @endcan
                    </div>
                  </div>
                  <div class="modal fade bd-example-modal-sm" id="delete{{$cat->id}}" role="dialog"
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
                          <p>{{ __('Do you really want to delete')}} {{$cat->courses->title}} ? {{ __('This process cannot be undone.')}}</p>
                        </div>
                        <div class="modal-footer">
                          <form method="post" action="{{url('courseinclude/'.$cat->id)}}" class="pull-right">
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

<div class="modal fade" id="myModalJ" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="my-modal-title">
          <b>{{ __('Add Course Include') }}</b>
      </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
      </div>
      <div class="box box-primary">
        <div class="panel panel-sum">
          <div class="modal-body">
            <form id="demo-form2" method="post" action="{{ route('courseinclude.store') }}" data-parsley-validate
              class="form-horizontal form-label-left">
              {{ csrf_field() }}
              <select class="d-none" name="course_id" class="form-control select2">
                <option value="{{ $cor->id }}">{{ $cor->title }}</option>
              </select>

              <div class="row">
                <div class="col-md-6">
                  <label for="">{{ __('Icon') }}:<sup class="redstar">*</sup></label>
                  <div class="input-group">
                  <input type="text" class="form-control iconvalue" name="icon" value="Choose icon">
                  <span class="input-group-append">
                      <button  type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                  </span>
              </div>
                 
                </div>
                <div class="col-md-6">
                  <label for="exampleInputDetails">{{ __('Detail') }}:<sup
                      class="redstar">*</sup></label>
                  <textarea rows="1" name="detail" class="form-control" placeholder="Enter Your Detail"></textarea>
                </div>
              </div>
              <br>

              <div class="col-md-6">
                    <label for="exampleInputDetails">{{ __('Status') }}:</label><br>
                    <label class="switch">
                      <input class="slider" type="checkbox" name="status" checked />
                      <span class="knob"></span>
                    </label>
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
  function  courceinclude(id){
    
    var status = $(this).prop('checked') == true ? 1 : 0; 
    
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('/quickupdate-courceinclude/status/')}}/" + id,
            data: {'status': status, 'id': id},
            success: function(data){
              console.log(id)
            }
        });
    };
 
</script>
<!-- script to change status end -->

<script>
    $("#checkboxAll").on('click', function () {
$('input.check').not(this).prop('checked', this.checked);
});
</script>
  