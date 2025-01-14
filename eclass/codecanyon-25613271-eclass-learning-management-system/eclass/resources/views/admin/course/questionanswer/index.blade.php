<div class="row">
  <div class="col-lg-12">
    <div class="card dashboard-card m-b-30">
      <div class="card-header">
        @can('question.delete')
        <button type="button" class="btn btn-danger-rgba mr-2 " data-toggle="modal" data-target="#bulk_delete6"><i
          class="feather icon-trash mr-2"></i>{{ __('Delete Selected') }}</button>
          @endcan
          @can('question.create')
          <a data-toggle="modal" data-target="#myModalabcde" href="#" class="btn btn-primary-rgba"><i
            class="feather icon-plus "></i>{{ __('Add Question Answer') }}</a>
          @endcan
          </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="" class="displaytable table table-striped table-bordered w-100">
            <thead>
              <tr>
                <th> <input id="checkboxAll6" type="checkbox" class="filled-in" name="checked[]"
                  value="all" />
              <label for="checkboxAll" class="material-checkbox"></label> #</th>
                <th>{{ __('Question') }}</th>
                <th>{{ __('Status') }}</th>

                <th>{{ __('Action') }}</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=0;?>
              @foreach($questions as $que)
              <tr>
                <?php $i++;?>

                  <td>
                    <input type="checkbox" form="bulk_delete_form6" class="filled-in material-checkbox-input6" name="checked[]" value="{{$que->id}}" id="checkbox{{$que->id}}">
                    <label for="checkbox{{$que->id}}" class="material-checkbox"></label> {{ $i }}

                    <div id="bulk_delete6" class="delete-modal modal fade" role="dialog">
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
                                    <form id="bulk_delete_form6" method="post"
                                        action="{{ route('questionanswer.bulk_delete') }}">
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
                <td>{{strip_tags(str_limit($que->question, $limit = 10, $end = '..'))}}</td>
                 <!-- ================================== -->
                 <td>
                    <label class="switch">
                      <input class="slider" type="checkbox"  data-id="{{$que->id}}" name="status" {{ $que->status ==1 ? 'checked' : ''}} onchange="questans('{{$que->id}}')" />
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
                      @can('question.edit')
                      <a class="dropdown-item" href="{{url('questionanswer/'.$que->id)}}"><i
                          class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                          @endcan
                          @can('question.delete')
                     
                      <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $que->id}}">
                        <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                        @endcan
                        <a class="dropdown-item" href="{{url('courseanswer/'.$que->id)}}"><i
                          class="feather icon-file-plus mr-2"></i>{{ __('Add Answer') }}</a>
                      </a>
                    </div>
                  </div>
                  <div class="modal fade bd-example-modal-sm" id="delete{{$que->id}}" tabindex="-1" role="dialog"
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
                          <p>{{ __('Do you really want to delete')}} ? {{ __('This process cannot be undone.')}}</p>
                        </div>
                        <div class="modal-footer">
                          <form method="post" action="{{url('questionanswer/'.$que->id)}}" class="pull-right">
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

<script>
$("#checkboxAll").on('click', function () {
$('input.check').not(this).prop('checked', this.checked);
});
</script>

  <div class="modal fade" id="myModalabcde" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="my-modal-title">
            <b>{{ __('Add Question Answer') }}</b>
        </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
        </div>
        <div class="box box-primary">
          <div class="panel panel-sum">
            <div class="modal-body">
              <form id="demo-form2" method="post" action="{{ route('questionanswer.store') }}" data-parsley-validate
                class="form-horizontal form-label-left">
                {{ csrf_field() }}

                <input type="hidden" name="instructor_id" class="form-control select2"
                  value="{{ Auth::User()->id }}" />
                  <label class="d-none" for="exampleInputSlug"> {{ __('Course') }}<span class="redstar">*</span></label>
                <select style="display: none" name="course_id" class="form-control select2">
                  <option value="{{ $cor->id }}" >{{ $cor->title }}</option>
                </select>

                <div class="row">
                  <div class="col-md-12">
                    <label for="exampleInputTit1e">{{ __('User') }} :</label>
                    <select name="user_id" class="select2-single form-control">

                      <option value="{{ Auth::user()->id }}">{{ Auth::user()->fname }}</option>
                    </select>
                  </div>
                </div>
                <br>

                <div class="row">
                  <div class="col-md-12">
                    <label for="exampleInputDetails">{{ __('Question') }} :<sup
                        class="redstar">*</sup></label>
                    <textarea name="question" rows="3" class="form-control "
                      placeholder="Enter Your Question"></textarea>
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
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- script to change status start -->
<script>
  function  questans(id){
    var status = $(this).prop('checked') == true ? 1 : 0; 
   
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('/quickupdate-questionanswer/status/')}}/" + id,
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