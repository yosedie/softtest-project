@extends('admin/layouts.master')
@section('title', 'Advertisements - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Advertisements';
$data['title'] = 'Front Setting';
$data['title1'] = 'Advertisements';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">                
  <!-- Start row -->
  <div class="row">
     <div class="col-lg-12">
          <div class="card dashboard-card m-b-30">
              <div class="card-header">
                  <h5 class="box-title">{{ __('Advertisements')}}</h5>
                  <div>
                    <div class="widgetbar">
                      @can('front-settings.advertisement.create')
                        <a href="{{url('advertisement/create')}}" class="btn btn-primary-rgba" title="{{ __('Add Advertisement')}}"><i class="feather icon-plus mr-2"></i>{{ __("Add Advertisement")}}</a>
                        @endcan
                        @can('front-settings.advertisement.delete')
                        <a href="page-product-detail.html" class="btn btn-danger-rgba"  data-toggle="modal" data-target=".bd-example-modal-sm1" title="{{ __('Delete Selected')}}"><i class="feather icon-trash mr-2"></i>{{ __('Delete Selected') }}</a>
                        @endcan                         
                        <div class="modal fade bd-example-modal-sm1" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close')}}">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                    </div>
                                    <div class="modal-footer">
                                      <form method="post" action="{{ action('BulkdeleteController@advertismentdeleteAll') }}
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
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Position') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>                    
                          </tr>
                          </thead>
                          <tbody>
                            <?php $i=0;?>
                            @foreach($advertisement as $adv)
                            <?php $i++;?>
                            <tr>
                              <td> 
                                <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$adv->id}}" id="checkbox{{$adv->id}}">
                                <label for="checkbox{{$adv->id}}" class="material-checkbox"></label>
                                <?php echo $i;?>
                            </td>
                              <td>
                                <img src="{{ asset('images/advertisement/'.$adv->image1) }}" class="img-responsive img-circle">
                              </td>
                              <td>{{$adv->position}}</td>
                              <td>
                                <label class="switch">
                                  <input class="advertisment" type="checkbox"  data-id="{{$adv->id}}" name="status" {{ $adv->status == '1' ? 'checked' : '' }}>
                                  <span class="knob"></span>
                                </label>
                              </td>                            
                              <td>
                                <div class="dropdown">
                                  <button class="btn btn-round btn-outline-primary" type="button"
                                      id="CustomdropdownMenuButton1" data-toggle="dropdown"
                                      aria-haspopup="true" aria-expanded="false" title="{{ __('Settings')}}"><i
                                          class="feather icon-more-vertical-"></i></button>
                                  <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                    @can('front-settings.advertisement.edit')
                                      <a class="dropdown-item" href="{{url('advertisement/'.$adv->id)}}" title="{{ __('Edit')}}"><i
                                              class="feather icon-edit mr-2"></i>{{ __('Edit')}}</a>
                                              @endcan
                                              @can('front-settings.advertisement.delete')
                                      <a class="dropdown-item btn btn-link" data-toggle="modal"
                                      data-target=".bd-example-modal-sm" title="{{ __('Delete')}}">
                                          <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                          @endcan
                                      </a>
                                     </div>
                              </div>                               
                              </td>
                              <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
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
                                            <form  method="post" action="{{url('advertisement/'.$adv->id)}}
                                              "data-parsley-validate class="form-horizontal form-label-left">
                                              {{ csrf_field() }}
                                              {{ method_field('DELETE') }}
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal" title="{{ __('Close')}}">{{ __("Close")}}</button>
                                              <button type="submit" class="btn btn-primary" title="{{ __('Delete')}}">{{ __("Delete")}}</button>
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
@section('script')
 <script>
        "use Strict";
$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
}); 
$(document).on("change",".advertisment",function() {
  $.ajax({
      type: "POST",
      dataType: "json",
      url: "{{url('quickupdate/advertisement')}}",
      data: {'status': $(this).is(':checked') ? 1 : 0, 'id': $(this).data('id')},
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
})
</script>
@endsection       