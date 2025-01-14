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
        @can('what-learn.delete')
        <button type="button" class=" btn btn-danger-rgba mr-2 " data-toggle="modal" data-target="#bulk_delete1"><i
            class="feather icon-trash mr-2"></i>{{ __('Delete Selected') }}</button>
            @endcan
            @can('what-learn.create')
        <a data-toggle="modal" data-target="#myModaljj" href="#" class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>{{ __('Add What Learn') }}</a>
      @endcan
      </div>
      <div class="card-body">

        <div class="table-responsive">
          <table id="" class="displaytable table table-striped table-bordered w-100">
            <thead>
              <tr>
                <th>
                      <input id="checkboxAll2" type="checkbox" class="filled-in" name="checked[]" value="all">
                      <label for="checkboxAll" class="material-checkbox"></label>
                      #
                </th>
                <th>{{ __('Detail') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Action') }}</th>

              </tr>
            </thead>
            <tbody>
              <?php $i=0;?>
              @foreach($whatlearns as $cat)
              <tr>
                <?php $i++;?>

                <td>
                 
                    <input type="checkbox" form="bulk_delete_form1" class="filled-in material-checkbox-input2" name="checked[]" value="{{$cat->id}}" id="checkbox{{$cat->id}}">
                    <label for="checkbox{{$cat->id}}" class="material-checkbox"></label>
               
                  <?php echo $i; ?>
                  <div id="bulk_delete1" class="delete-modal modal fade" role="dialog">
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
                          <form id="bulk_delete_form1" method="post" action="{{ route('learnsbulk.bulk_delete') }}">
                            @csrf
                            @method('POST')
                            <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __('No') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
                <td>{{ strip_tags($cat->detail) }}</td>
                <!-- ================================== -->
                <td>
                    <label class="switch">
                      <input class="slider whatlearn" type="checkbox"  data-id="{{$cat->id}}" name="status" {{ $cat->status == '1' ? 'checked' : '' }} />
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
                      @can('what-learn.edit')
                      <a class="dropdown-item" href="{{url('whatlearns/'.$cat->id)}}"><i
                          class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                          @endcan
                          @can(' what-learn.delete')
                      <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete1{{ $cat->id}}">
                        <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                      </a>
                      @endcan
                    </div>
                  </div>
                  <div class="modal fade bd-example-modal-sm" id="delete1{{$cat->id}}" tabindex="-1" role="dialog"
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
                          <form method="post" action="{{url('whatlearns/'.$cat->id)}}" class="pull-right">
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

            </tbody>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- End col -->
</div>
<!--Model start-->
<div class="modal fade" id="myModaljj" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="my-modal-title">
          <b>Add What-learn</b>
      </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
      </div>
      <div class="box box-primary">
        <div class="panel panel-sum">
          <div class="modal-body">
            <form id="demo-form2" method="post" action="{{ route('whatlearns.store') }}" data-parsley-validate
              class="form-horizontal form-label-left">
              {{ csrf_field() }}

              <select class="d-none" name="course_id" class="form-control select2">
                <option value="{{ $cor->id }}">{{ $cor->title }}</option>
              </select>

              <div class="row">
                <div class="col-md-10">
                  <label for="exampleInputDetails">{{ __('Detail') }}:<sup
                      class="redstar">*</sup></label>
                  <textarea rows="1" name="detail" class="form-control" placeholder="Enter Your Detail"></textarea>
                </div>
                <br>
                <br>
                <div class="col-md-2">
                  <label for="exampleInputDetails">{{ __('Status') }}:</label><br>
                    <label class="switch">
                      <input class="slider" type="checkbox" name="status" checked />
                      <span class="knob"></span>
                    </label>
                </div>
              </div>
              <br>
              <div class="form-group">
                <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{__('Reset')}}</button>
                <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                  {{__('Create')}}</button>
              </div>

              <div class="clear-both"></div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


@section('script')
<!-- script to change status start -->
<script>
  $(function() {
    $('.whatlearn').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        
        var id = $(this).data('id'); 
        
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('/quickupdate-what/status')}}/" + id,
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
    });
  });
</script>
<!-- script to change status end -->
<script>
  $(function(){
    $('#checkboxAll2').on('change', function(){

      if($(this).prop("checked") == true){
        $('.material-checkbox-input2').attr('checked', true);
      }
      else if($(this).prop("checked") == false){
        $('.material-checkbox-input2').attr('checked', false);
      }
    });
  });
</script>
@endsection

<!--Model close -->