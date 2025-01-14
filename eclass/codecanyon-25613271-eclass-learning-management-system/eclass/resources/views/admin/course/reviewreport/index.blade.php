<div class="row">
  <div class="col-lg-12">
    <div class="card m-b-30">
      <div class="card-header">
        <h5 class="card-box">{{ __('All Report') }}</h5>
        <div class="widgetbar">
          @can('review-reports.manage')
          <button type="button" class="btn btn-danger-rgba mr-2" data-toggle="modal" data-target="#bulk_delete100"><i class="feather icon-trash mr-2"></i>{{ __('Delete Selected') }}</button>
          @endcan
        </div>
      </div>
      <div class="card-body">

        <div class="table-responsive">
          <table id="" class="displaytable table table-striped table-bordered w-100">
            <thead>
              <tr>
                <th>
                  <input id="checkboxAll100" type="checkbox" class="filled-in" name="checked[]" value="all">
                  <label for="checkboxAll" class="material-checkbox"></label>
                  #
                </th>
                <th>{{ __('User') }}</th>
                <th>{{ __('Course') }}</th>
                <th>{{ __('Title') }}</th>
                <th>{{ __('Email') }}</th>
                <th>{{ __('Detail') }}</th>
                <th>{{ __('Action') }}</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=0;?>
              @foreach($reports as $report)
              <tr>
                <?php $i++;?>
                <td>    
                    <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input100" name="checked[]" value="{{$report->id}}" id="checkbox{{$report->id}}">
                    <label for="checkbox{{$report->id}}" class="material-checkbox"></label> 

                    <?php echo $i; ?>
                    <div id="bulk_delete100" class="delete-modal modal fade" role="dialog">
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
                              <form id="bulk_delete_form11" method="post"
                                  action="{{ route('report.review.bulk_delete') }}">
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
                <td>{{$report->user['fname']}}</td>
                <td>{{$report->courses['title']}}</td>
                <td>{{$report->title}}</td>
                <td>{{$report->email}}</td>
                <td>{{$report->detail}}</td>
                <td>
                      <div class="dropdown">
                        <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                        <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                          @can('review-reports.manage')
                            <a class="dropdown-item" href="{{url('reports/'.$report->id)}}"><i class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                            <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#deleterreport{{ $report->id}}" >
                                <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                            </a>
                            @endcan
                        </div>
                    </div>
                    <div class="modal fade bd-example-modal-sm" id="deleterreport{{$report->id}}" tabindex="-1" role="dialog" aria-hidden="true">
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
                                      <p>{{ __('Do you really want to delete')}} <b>{{$report->courses['title']}}</b> ? {{ __('This process cannot be undone.')}}</p>
                              </div>
                              <div class="modal-footer">
                                  <form method="post" action="{{url('reports/'. $report->id)}}" class="pull-right">
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

