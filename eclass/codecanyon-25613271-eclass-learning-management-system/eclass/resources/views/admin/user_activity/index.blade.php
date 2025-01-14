@extends('admin.layouts.master')
@section('title','Users Activity Logs')
@section('maincontent')
<?php
$data['heading'] = 'Users Activity Logs';
$data['title'] =   'Users Activity Logs';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card"> 
  <div class="row">
      <div class="col-lg-12">
          <div class="card dashboard-card m-b-30">
              <div class="card-header">
                  <h5 class="box-title">{{ __('All Users Activity Logs') }}</h5>
                  <div>
                    <div class="widgetbar">                      
                      <a href="page-product-detail.html" class="btn btn-danger-rgba"  data-toggle="modal" data-target=".bd-example-modal-sm1" title="{{ __('Delete Selected') }}"><i class="feather icon-trash mr-2"></i>{{__('Delete Selected')}}</a>
                        <div class="modal fade bd-example-modal-sm1" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-sm">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5  class="modal-title">{{__('Delete')}}</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                                      <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body text-center">
                                      <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                  </div>
                                  <div class="modal-footer">
                                    <form method="post" action="{{ action('UserActivityController@bulk_delete') }}
                                      " id="bulk_delete_form" data-parsley-validate class="form-horizontal form-label-left">
                                      {{ csrf_field() }}
                                    
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("No")}}</button>
                                      <button type="submit" class="btn btn-danger">{{ __("Yes")}}</button>
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
                                <th><input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" />
                                    <label for="checkboxAll" class="material-checkbox"></label> #</th>
                                <th>{{ __('User') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Action') }}</th>
                                <th>{{ __('Time') }}</th>
                                <th>{{ __('Delete') }}</th>
                              </thead> 
                              <tbody>
                                <?php $i=0;?>
                                 @foreach ($lastActivity as $user)
                                 @php
                                      $users = App\User::where('id', $user->causer_id)->first();
                                    @endphp
                                    <?php $i++;?>
                                    <tr>
                                        <td>  <input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input'
                                            name='checked[]' value='{{ $user->id }}' id='checkbox{{ $user->id }}'>
                                        <label for='checkbox{{ $user->id }}' class='material-checkbox'></label>
                                        <?php echo $i; ?>
                                        </td>                                      
                                      <td>@if(isset($users)) {{ $users->fname }} @endif</td>
                                      <td>@if(isset($users)) {{ $users->email }} @endif</td>
                                      <td>{{ $user->description }}</td>
                                      <td>{{ $user->created_at->diffForHumans() }}</td>
                                      <td>
                                        <div class="dropdown">
                                            <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings') }}"><i class="feather icon-more-vertical-"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                                <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $user->id }}" title="{{ __('Delete') }}">
                                                    <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                                </a>
                                            </div>
                                        </div>
    
                                        <!-- delete Modal start -->
                                        <div class="modal fade bd-example-modal-sm" id="delete{{$user->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                            <h4>{{ __('Are You Sure ?')}}</h4>
                                                            <p>{{ __('Do you really want to delete')}} <b>{{$user->fname}}</b>? {{ __('This process cannot be undone.')}}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="post" action="{{ route('activity.delete',$user->id) }}" class="pull-right">
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
                      </table>
                  </div>
              </div>
          </div>
      </div>
      
@endsection

