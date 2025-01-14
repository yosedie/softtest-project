@extends('admin.layouts.master')
@section('title',' Countries')
@section('maincontent')
<?php
$data['heading'] = 'Countries';
$data['title'] = 'Countries';
?>
@include('admin.layouts.topbar',$data)
  <div class="contentbar dashboard-card">                
    <!-- Start row -->
    <div class="row">
      <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('Countries')}}</h5>
					<div>
						<div class="widgetbar">
						  @can('locations.country.delete')
							<a  href=" {{url('admin/country/create')}}" class="btn btn-primary-rgba" title="{{ __('Add Country') }}"><i class="feather icon-plus mr-2"></i>{{ __("Add Country")}}</a>
              <button type="button" class="btn btn-danger-rgba mr-2 " data-toggle="modal"
                data-target="#bulk_delete" title="{{ __('Delete Selected') }}"><i class="feather icon-trash mr-2"></i> {{ __('Delete Selected') }} </button>
							@endcan
						  
						</div>                        
					  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                              <th>
                                <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                                    value="all" />
                                <label for="checkboxAll" class="material-checkbox"></label> 
                            </th>
                           
                              <th></th>
                              <th>{{ __("Country Name")}} </th>
                              <th>{{ __("ISO Code 2")}}</th>
                              <th>{{ __("ISO Code 3")}}</th>
                              <th>{{ __("Action")}}</th>
                      
                            </tr>
                            </thead>
                            <tbody>
                              <?php $i=0;?> 
                              @foreach ($countries as $country)
                              <tr>
                                <td>  <input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input'
                                  name='checked[]' value='{{ $country->id }}' id='checkbox{{ $country->id }}'>
                              <label for='checkbox{{ $country->id }}' class='material-checkbox'></label>
                              <?php $i++;?>
                              <?php echo $i;?>
                              </td>
                                  <td>
                                    <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
                                      <div class="modal-dialog modal-sm">
                                          <!-- Modal content-->
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <button type="button" class="close"
                                                      data-dismiss="modal" title="{{ __('Close') }}">&times;</button>
                                                  <div class="delete-icon"></div>
                                              </div>
                                              <div class="modal-body text-center">
                                                  <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                                                  <p>{{ __('Do you really want to delete selected item names here? This process
                                                              cannot be undone') }}.</p>
                                              </div>
                                              <div class="modal-footer">
                                                  <form id="bulk_delete_form" method="post"
                                                      action="{{ route('country.bulk_delete') }}">
                                                      @csrf
                                                      @method('POST')
                                                      <button type="reset" class="btn btn-gray translate-y-3"
                                                          data-dismiss="modal">{{ __('No') }}</button>
                                                      <button type="submit"
                                                          class="btn btn-danger">{{ __('Yes') }}</button>
                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  </td>
                                  <td>{{ $country->nicename }}</td>
                                  <td>{{ $country->iso }}</td>
                                  <td>{{ $country->iso3 }}</td>
                               <td>
                                
                                  <div class="dropdown">
                                      <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings') }}"><i class="feather icon-more-vertical-"></i></button>
                                      <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                        @can('locations.country.edit')
                                          <a class="dropdown-item"   href="{{url('admin/country/'.$country->id. '/edit')}}" title="{{ __('Edit') }}"><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
                                          @endcan
                                          @can('locations.country.delete')
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
                                              <form  method="post" action="{{url('admin/country/'.$country->id)}}
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
                              </tr>
                              
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
