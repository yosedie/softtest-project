@extends('admin.layouts.master')
@section('title', 'Feature - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Feature';
$data['title'] = 'Front Settings';
$data['title1'] = 'Feature';
?>
@include('admin.layouts.topbar',$data)
 <div class="contentbar">   
    @if ($errors->any())  
    <div class="alert alert-danger" role="alert">
    @foreach($errors->all() as $error)     
    <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close')}}">
    <span aria-hidden="true" style="color:red;">&times;</span></button></p>
        @endforeach  
    </div>
    @endif             
    <!-- Start row -->
    <div class="row">
      <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Feature')}}</h5>
                    <div>
                      <div class="widgetbar">
                          <a href="{{url('feature/create')}}" class="btn btn-primary-rgba" title="{{ __('Add Feature')}}"><i class="feather icon-plus mr-2"></i>{{ __("Add Feature")}}</a>
                      </div>                        
                    </div>
                </div>
                <div class="card-body">
                 
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                              
                            <th>
                              <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" id="checkboxAll">
                              <label for="checkboxAll" class="material-checkbox"></label>
                               #
                           </th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Feature') }}</th>
                            <th>{{ __('Detail') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                           
                            </tr>
                            </thead>
                            <tbody>
                              <?php $i=0;?>
                              @foreach($feature as $data)
                              <?php $i++;?>
                              <tr>
                                  <td> 
                                  <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$data->id}}" id="checkbox{{$data->id}}">
                                  <label for="checkbox{{$data->id}}" class="material-checkbox"></label>
                                   <?php echo $i;?> 
                                   </td> 
                                <td>
                                  <img src="{{ asset('images/feature/'.$data->image) }}" class="img-responsive img-circle" alt="{{ __('Image')}}" >
                                </td>
                                <td>{{$data->title}}</td>
                                <td>{{$data->detail}}</td> 
                               <td>
                                @if( $data->status == 1)
                                <button type="button" class="btn btn-rounded btn-success-rgba" data-toggle="modal" data-target="#myModal">
                                    {{ __('Active') }}
                                </button>
                                    @else
                                    {{ __('Deactivate') }}
                                  </button>
                                    @endif 
                               </td>
                                <td>
                                <div class="dropdown">
                                    <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings')}}"><i class="feather icon-more-vertical-"></i></button>
                                    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                        <a class="dropdown-item"   href="{{ route('feature.edit',$data->id) }}" title="{{ __('Edit')}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
                                        <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-sm{{$data->id}}" title="{{ __('Delete')}}"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
                                      </div>
                                    </div>
                                  </td>
                                        <div class="modal fade bd-example-modal-sm{{$data->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                          <div class="modal-dialog modal-sm">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close')}}">
                                                      <span aria-hidden="true">&times;</span>
                                                      </button>
                                                  </div>
                                                  <div class="modal-body">
                                                      <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <form  method="post" action="{{url('feature/'.$data->id)}}
                                                      "data-parsley-validate class="form-horizontal form-label-left">
                                                      {{ csrf_field() }}
                                                      {{ method_field('DELETE') }}
                                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("No")}}</button>
                                                      <button type="submit" class="btn btn-danger">{{ __("Yes")}}</button>
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
