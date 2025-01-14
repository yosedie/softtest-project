<div class="row">
        <div class="col-md-12">
            <!-- card started -->
            <div class="card">
              <!-- ========= -->
                <!-- to show add button start -->
                <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-7">
                    <!-- <div class="card-header">
                        <h5 class="card-title">{{ __('Language') }}</h5>
                    </div>  -->
                    </div> 
              
                </div>
                </div>
                <!-- to show add button end -->
                <!-- card body started -->
                <div class="card-body">
                <div class="table-responsive">

                        <!-- table to display language start -->
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <th>
                                <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                                value="all" />
                                <label for="checkboxAll" class="material-checkbox"></label>   # 
                            </th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Local') }}</th>
                            <th>{{ __('Default') }}</th>
                            <th>{{ __('Action') }}</th>
                        </thead>
                        @if ($languages)
                        <tbody>
                          @foreach ($languages as $key => $language)
                            <tr>
                            <td>                                                     
                                <input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input'
                                    name='checked[]' value="{{ $language->id }}" id='checkbox{{ $language->id }}'>
                                <label for='checkbox{{ $language->id }}' class='material-checkbox'></label>
                                <?php echo $key+1; ?>
                            <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
                                <div class="modal-dialog modal-sm">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" title="{{ __('Close')}}">&times;</button>
                                            <div class="delete-icon"></div>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                                            <p>{{ __('Do you really want to delete selected item ? This process
                                                cannot be undone') }}.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form id="bulk_delete_form" method="post"
                                                action="{{ route('admin.lang.bulk_delete') }}">
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
                            <td>{{$language->name}}</td>
                            <td>{{$language->local}}</td>
                            <td align="left">
                              @if($language->def ==1)
                                <i class="text-success fa fa-check"></i>
                              @else
                                <i class="text-danger fa fa-times"></i>
                              @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                        @can('site-settings.language.edit')
                                        <a class="dropdown-item" href="{{route('languages.edit', $language->id)}}" title="{{ __('Edit')}}"><i class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                                        @endcan
                                      @can('site-settings.language.delete')
                                        <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $language->id }}" title="{{ __('Delete')}}">
                                            <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}
                                        </a>
                                        @endcan
                                    </div>
                                </div>
                                <!-- delete Modal start -->
                                <div class="modal fade bd-example-modal-sm" id="delete{{ $language->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close')}}">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                    <h4>{{ __('Are You Sure ?')}}</h4>
                                                    <p>{{ __('Do you really want to delete')}} <b>{{$language->name}}</b> ? {{ __('This process cannot be undone.')}}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post" action="{{url('languages/'.$language->id)}}" class="pull-right">
                                                    {{csrf_field()}}
                                                    {{method_field("DELETE")}}
                                                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
                                                    <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
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
                        @endif
                        </table>                  
                        <!-- table to display language data end -->                
                    </div><!-- table-responsive div end -->
                </div><!-- card body end -->
            </div><!-- card end -->
        </div><!-- col end -->
    </div><!-- row end -->