@extends('admin.layouts.master')
@section('title', 'Trusted Sliders - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Trusted Sliders';
$data['title'] = 'Front Settings';
$data['title1'] = 'Trusted Sliders';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">                
  <!-- Start row -->
  <div class="row">
    <div class="col-lg-12">
          <div class="card dashboard-card m-b-30">
              <div class="card-header">
                  <h5 class="box-title">{{ __('Trusted Sliders')}}</h5>
                  <div>
                    <div class="widgetbar">
                        @can('front-settings.trusted-sliders.create')
                        <a href="{{url('trusted/create')}}" class="btn btn-primary-rgba" title="{{ __('Add Trusted Slide')}}"><i class="feather icon-plus mr-2"></i>{{ __("Add Trusted Slide")}}</a>
                        @endcan
                        @can('front-settings.trusted-sliders.delete')
                    <a href="page-product-detail.html" class="btn btn-danger-rgba" data-toggle="modal" data-target=".bd-example-modal-sm1" title="{{ __('Delete Selected')}}"><i class="feather icon-trash mr-2"></i>{{ __('Delete Selected') }}</a>
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
                                  <form method="post" action="{{ action('BulkdeleteController@trustsliderdeleteAll') }}
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
                            <th> <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" id="checkboxAll">
                                <label for="checkboxAll" class="material-checkbox"></label> 
                            #</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('URL') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>                          
                          </tr>
                          </thead>
                          <tbody>
                            <?php $i=0;?>
                            @foreach($trusted as $trusted)
                            <?php $i++;?>
                            <tr>
                              <td> <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$trusted->id}}" id="checkbox{{$trusted->id}}">
                                <label for="checkbox{{$trusted->id}}" class="material-checkbox"></label> 
                                <?php echo $i;?></td>
                              <td>
                                <img src="images/trusted/<?php echo $trusted['image'];  ?>" class="img-circle">
                              </td>
                              <td>{{$trusted->url}}</td>
                              <td>
                                <label class="switch">
                                  <input class="trustedslider" type="checkbox"  data-id="{{$trusted->id}}" name="status" {{ $trusted->status == '1' ? 'checked' : '' }}>
                                  <span class="knob"></span>
                                </label>
                              </td>    
                              <td>
                                <div class="dropdown">
                                    <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings')}}"><i class="feather icon-more-vertical-"></i></button>
                                    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                        @can('front-settings.trusted-sliders.edit')
                                        <a class="dropdown-item"  href="{{url('trusted/'.$trusted->id)}}" title="{{ __('Edit')}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
                                        @endcan
                                        @can('front-settings.trusted-sliders.delete')
                                        <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-sm" title="{{ __('Delete')}}"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
                                      @endcan
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
                                              <form  method="post" action="{{url('trusted/'.$trusted->id)}}
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
@section('script')
<script>
  "use Strict";

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(document).on("change",".trustedslider",function() {          
    $.ajax({
        type: "POST",
        dataType: "json",
        url: '{{url("quickupdate/truested")}}',
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
              