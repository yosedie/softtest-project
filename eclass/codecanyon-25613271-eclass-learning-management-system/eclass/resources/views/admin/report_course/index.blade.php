@extends('admin.layouts.master')
@section('title', 'Report Course - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Reported Courses';
$data['title'] = 'Courses';
$data['title1'] = 'Reported Courses';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">                
    <!-- Start row -->
    <div class="row">
      <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('Reported Courses')}}</h5>
                    <div>
                      <div class="widgetbar">
                        
                          <a href="page-product-detail.html" class="btn btn-danger-rgba"  data-toggle="modal" data-target=".bd-example-modal-sm1" title="{{ __('Delete Selected') }}"><i class="feather icon-trash mr-2"></i>{{ __('Delete Selected') }}</a>
                                                    
                          <div class="modal fade bd-example-modal-sm1" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-sm">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body text-center">
                                          <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                      </div>
                                      <div class="modal-footer">
                                        <form method="post" action="{{ action('BulkdeleteController@reportedcoursedeleteAll') }}
                                          " id="bulk_delete_form" data-parsley-validate class="form-horizontal form-label-left">
                                          {{ csrf_field() }}
                                        
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("No")}}</button>
                                          <button type="submit" class="btn btn-primary">{{ __("Yes")}}</button>
                                      </form>
                                      </div>
                                  </div>
                              </div>
                          </div>
                                        
                      </div>                        
                    </div>
                  </div>
                <div class="card-body">
                 
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>

                            <tr>
                              <th> <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" id="checkboxAll">
                                <label for="checkboxAll" class="material-checkbox"></label> 
                                #</th>
                              <th>{{ __('User') }}</th>
                              <th>{{ __('Issue') }}</th>
                              <th>{{ __('Email') }}</th>
                              <th>{{ __('Details') }}</th>
                              <th>{{ __('Course') }}</th>
                              <th>{{ __('Action') }}</th>
                            
                            </tr>
                            </thead>
                            <tbody>
                              <?php $i=0;?>
                              @foreach($items as $item)
                                <?php $i++;?>
                                <tr>
                              <td> <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$item->id}}" id="checkbox{{$item->id}}">
                                <label for="checkbox{{$item->id}}" class="material-checkbox"></label>
                                <?php echo $i;?></td>
                              <td>{{$item->user['fname']}}</td>
                              
                              <td>{{$item->title}}</td>
                              <td>{{$item->email}}</td>
                              <td>{{ str_limit($item->detail, $limit=50, $end="...")}}</td>
                              <td>{{$item->courses['title']}}</td>
                              <td>
                                <div class="dropdown">
                                    <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings') }}"><i class="feather icon-more-vertical-"></i></button>
                                    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                        @can('reported-course.edit')
                                        <a class="dropdown-item"   href="{{url('admin/report/view/'.$item->id)}}" title="{{ __('Edit') }}"><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
                                        @endcan
                                        @can('reported-course.delete')
                                        <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-sm" title="{{ __('Delete') }}"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
                                        @endcan
                                    </div>
                                </div>
                              </td>
                               <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-sm">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                                              <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                              <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                          </div>
                                          <div class="modal-footer">
                                            <form  method="post" action="{{url('admin/report/view/'. $item->id)}}
                                                "data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal" title="{{ __('Close') }}">{{ __("Close")}}</button>
                                              <button type="submit" class="btn btn-primary" title="{{ __('Delete') }}">{{ __("Delete")}}</button>
                                          </form>
                                          </div>
                                      </div>
                                  </div>
                              </div>
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
                                
                        
                      