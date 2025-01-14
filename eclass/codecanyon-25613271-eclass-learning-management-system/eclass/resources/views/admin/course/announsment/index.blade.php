<div class="row">
  <div class="col-lg-12">
    <div class="card m-b-30">
      <div class="card-header">
        @can('announcement.delete')
      <button type="button" class="btn btn-danger-rgba mr-2" data-toggle="modal" data-target="#bulk_delete8"><i
          class="feather icon-trash mr-2"></i>{{ __('Delete Selected') }}</button>
          @endcan
          @can('announcement.create')
        <a data-toggle="modal" data-target="#myModalabcdef" href="#" class="btn btn-primary-rgba"><i
            class="feather icon-plus mr-2"></i>{{ __('Announcement') }}</a>
            @endcan
      </div>
      <div class="card-body">

        <div class="table-responsive">
          <table id="" class="displaytable table table-striped table-bordered w-100">
            <thead>
              <tr>
                <th><input id="checkboxAll8" type="checkbox" class="filled-in" name="checked[]"
                  value="all" />
              <label for="checkboxAll" class="material-checkbox"></label>#</th>
                <th>{{ __('Announcement') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Action') }}</th>
              
              </tr>
            </thead>
            <tbody>
              <?php $i=0;?>
              @foreach($cor->announsment as $an)
              <tr>
                <?php $i++;?>
                <td>
                  <input type="checkbox" form="bulk_delete_form8" class="filled-in material-checkbox-input8" name="checked[]" value="{{$an->id}}" id="checkbox{{$an->id}}">
                    <label for="checkbox{{$an->id}}" class="material-checkbox"></label> <?php echo $i; ?>
                      <!-- bulk delete modal end -->
                      <div id="bulk_delete8" class="delete-modal modal fade" role="dialog">
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
                                      <form id="bulk_delete_form8" method="post"
                                          action="{{ route('announcement.bulk_delete') }}">
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
                      <!-- bulk delete modal end -->
                </td>
                <td>{{ str_limit($an->announsment, $limit = 70, $end = '....')}}</td>
                <!-- ================================== -->
                <td>
                  @if($an->status=='1')
                    <button type="button" class="btn btn-rounded btn-success-rgba" data-toggle="modal" data-target="#myModal">
                      {{ __('Active') }}
                  </button>
                  @else
                  <button type="button" class="btn btn-rounded btn-danger-rgba" data-toggle="modal" data-target="#myModal">
                    {{ __('Deactive') }}
                  </button>
                  @endif
              </td>
                <!-- ================================== -->
                <td>
                  <div class="dropdown">
                    <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                      @can('announcement.edit')
                        <a class="dropdown-item" href="{{url('announsment/'.$an->id)}}"><i class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                        @endcan
                        @can('announcement.delete')
                        <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $an->id}}" >
                            <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                        </a>
                        @endcan
                    </div>
                </div>
                <div class="modal fade bd-example-modal-sm" id="delete{{$an->id}}" tabindex="-1" role="dialog" aria-hidden="true">
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
                                  <p>{{ __('Do you really want to delete')}} <b>{{$an->courses->title}}</b> ? {{ __('This process cannot be undone.')}}</p>
                          </div>
                          <div class="modal-footer">
                              <form method="post" action="{{url('announsment/'.$an->id)}}" class="pull-right">
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
  <!-- End col -->



<div class="modal fade" id="myModalabcdef" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="my-modal-title">
          <b>{{ __('Add Announsment') }}</b>
      </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
      </div>
      <div class="box box-primary">
        <div class="panel panel-sum">
          <div class="modal-body">
            <form id="demo-form2" method="post" action="{{ route('announsment.store') }}" data-parsley-validate
              class="form-horizontal form-label-left">
              {{ csrf_field() }}


              <select class="d-none" name="course_id" class="form-control select2">
                <option value="{{ $cor->id }}">{{ $cor->title }}</option>
              </select>
              
              <div class="row">
               <div class="col-md-12">
                  <label class="d-none" for="exampleInputTit1e">{{ __('Select a User :') }}</label>
                  <select class="d-none" name="user_id" class="form-control select2">
                    @php
                    $users = App\User::all();
                    @endphp

                    @foreach($users as $us)
                    <option value="{{$us->id}}" >{{$us->fname}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
             
                <div class="col-md-12">
                  <label for="exampleInputDetails">{{ __('Announcement') }}:<sup class="redstar">*</sup></label>

                  <textarea name="announsment" id="editor6" rows="2" class="form-control"
                    placeholder="Enter Your Announcement"></textarea>
                </div>
                <div class="col-md-12">
                  <label for="exampleInputDetails">{{ __('Status') }} :</label><br>
                  <label class="switch">
                      <input class="slider" type="checkbox" name="status" checked />
                      <span class="knob"></span>
                    </label>
                
                </div>
               
                <div class="form-group">
                  <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{ __('Reset') }}</button>
                  <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                   {{ __('Create') }} </button>
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


$(document).on("change",".announ",function() {
        
      $.ajax({
          type: "POST",
          dataType: "json",
          url: 'announcement/status',
          data: {'approved': $(this).is(':checked') ? 1 : 0, 'id': $(this).data('id')},
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
      })
  });

  (function ($) {
    "use strict";
    tinymce.init({
      selector: 'textarea#detail'
    });
  })(jQuery);

  $("#checkboxAll").on('click', function () {
$('input.check').not(this).prop('checked', this.checked);
});
</script>
