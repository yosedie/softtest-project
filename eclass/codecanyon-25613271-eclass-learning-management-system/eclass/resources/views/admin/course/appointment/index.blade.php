<div class="row">
      
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-header">
                <h5 class="card-box">{{__('All Appointment')}}</h5>
                  <div class="widgetbar">
                      <button type="button" class="btn btn-danger-rgba mr-2 " data-toggle="modal" data-target="#bulk_delete11"><i class="feather icon-trash mr-2"></i> {{__('Delete Selected')}}</button>
                  </div>
            </div>

             <div id="bulk_delete11" class="delete-modal modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <div class="delete-icon"></div>
                        </div>
                        <div class="modal-body text-center">
                            <h4 class="modal-heading">{{__('Are You Sure ?')}}</h4>
                            <p>{{__('Do you really want to delete selected item ? This process
                                cannot be undone.')}}</p>
                        </div>
                        <div class="modal-footer">
                            <form id="bulk_delete_form11" method="post"
                                action="{{ route('appointment.bulk_delete') }}">
                                @csrf
                                @method('POST')
                                <button type="reset" class="btn btn-gray translate-y-3"
                                    data-dismiss="modal">{{__('No')}}</button>
                                <button type="submit" class="btn btn-danger">{{__('Yes')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
  
            <div class="card-body">
            
                <div class="table-responsive">
                    <table id="" class="displaytable table table-striped table-bordered w-100">
                        <thead>
                        <tr>
                          <th> 
                            <input id="checkboxAll11" type="checkbox" class="filled-in" name="checked[]" value="all" />
                            <label for="checkboxAll" class="material-checkbox"></label> #
                          </th>
  
                          <th>{{ __('User') }}</th>
                          <th>{{ __('Course') }}</th>
                          <th>{{ __('Instructor') }}</th>
                          <th>{{ __('Title') }}</th>
                          <th>{{ __('Accepted') }}</th>
                          <th>{{ __('Action') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0;?>
                        @foreach($appointment as $appoint)
                          <tr>
                            <?php $i++;?>
                            <td>
                               <input type="checkbox" form="bulk_delete_form11" class="filled-in material-checkbox-input11" name="checked[]" value="{{$appoint->id}}" id="checkbox{{$appoint->id}}">
                              <label for="checkbox{{$appoint->id}}" class="material-checkbox"></label> <?php echo $i;?>
                            </td>
                            
                            <td>@if(isset($appoint->user)) {{$appoint->user->fname}} @endif</td>
                            <td>@if(isset($appoint->courses)) {{$appoint->courses->title}} @endif</td>
                            <td>@if(isset($appoint->instructor)) {{$appoint->instructor->fname}} @endif</td>
                            <td>{{ $appoint->title }}</td>
                             <!-- ================================== -->
                              <td>
                                  <label class="switch">
                                  <input class="slider" type="checkbox"  data-id="{{$appoint->id}}" name="accept" {{ $appoint->accept ==1 ? 'checked' : ''}} onchange="appointment('{{$appoint->id}}')" />
                                  <span class="knob"></span>
                                  </label>
                              </td>
                              <!-- ================================== -->
                            <td>
                              <div class="dropdown">
                                  <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                  <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                      @can('appointment.manage')
                                      <a class="dropdown-item" href="{{url('appointment/'.$appoint->id)}}"><i class="feather icon-edit mr-2"></i>{{__('Edit')}}</a>
                                      <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#deleteap{{ $appoint->id}}" >
                                          <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                      </a>
                                      @endcan
                                  </div>
                              </div>
  
                              <!-- delete Modal start -->
                              <div class="modal fade bd-example-modal-sm" id="deleteap{{$appoint->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-sm">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="exampleSmallModalLabel">{{__('Delete')}}</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                                  <h4>{{ __('Are You Sure ?')}}</h4>
                                                  <p>{{ __('Do you really want to delete')}} @if(isset($appoint->courses)) <b>{{$appoint->courses->title}}</b> @endif ? {{ __('This process cannot be undone.')}}</p>
                                          </div>
                                          <div class="modal-footer">
                                              <form method="post" action="{{url('appointment/'.$appoint->id)}}" class="pull-right">
                                                  {{csrf_field()}}
                                                  {{method_field("DELETE")}}
                                                  <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{__('No')}}</button>
                                                  <button type="submit" class="btn btn-primary">{{__('Yes')}}</button>
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
  
  <!-- script to change status start -->
  <script>
    function  appointment(id){
      
      var accept = $(this).prop('checked') == true ? 1 : 0; 
      
          $.ajax({
              type: "GET",
              dataType: "json",
              url: "{{url('/appointment/status/')}}/" + id,
              data: {'accept': accept, 'id': id},
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
  
  
  
  