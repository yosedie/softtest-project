@extends('admin.layouts.master')
@section('title', 'Sliders - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Sliders';
$data['title'] = 'Front Settings';
$data['title1'] = 'Sliders';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar ">   
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
                    <h5 class="card-title">{{ __('Sliders')}}</h5>
                    <div>
                        <div class="widgetbar">
                          @can('front-settings.sliders.create')
                            <a href="{{url('slider/create')}}" class="btn btn-primary-rgba" title="{{ __('Add Slider')}}"><i class="feather icon-plus mr-2"></i>{{ __("Add Slider")}}</a>
                            @endcan
                            @can('front-settings.sliders.delete')
                            <a href="page-product-detail.html" class="btn btn-danger-rgba" data-toggle="modal" data-target=".bd-example-modal-sm1" title="{{ __('Delete Selected')}}"><i class="feather icon-trash mr-2"></i>{{ __('Delete Selected') }}</a>
                            @endcan                     
                            <div class="modal fade bd-example-modal-sm1" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5  class="modal-title">{{ __('Delete') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close')}}">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                        </div>
                                        <div class="modal-footer">   
                                            <form method="post" action="{{ action('BulkdeleteController@sliderdeleteAll') }}
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
                              <th>
                                <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" id="checkboxAll">
                                <label for="checkboxAll" class="material-checkbox"></label>
                                 #
                             </th>
                              <th>{{ __('Image') }}</th>
                              <th>{{ __('Heading') }}</th>
                              <th>{{ __('Sub Heading') }}</th>
                              <th>{{ __('Status') }}</th>
                              <th>{{ __('Action') }}</th>                           
                            </tr>
                            </thead>
                            <tbody>
                              <?php $i=0;?>
                              @foreach($sliders as $cat)
                              <?php $i++;?>
                              <tr>
                                  <td> 
                                  <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$cat->id}}" id="checkbox{{$cat->id}}">
                                  <label for="checkbox{{$cat->id}}" class="material-checkbox"></label>
                                   <?php echo $i;?> 
                                   </td> 
                                <td>
                                  <img src="{{ asset('images/slider/'.$cat->image) }}" class="img-responsive img-circle" >
                                </td>
                                <td>{{$cat->heading}}</td>
                                <td>{{$cat->sub_heading}}</td> 
                               <td>
                                @if( $cat->status == 1)
                                <button type="button" class="btn btn-rounded btn-success-rgba" data-toggle="modal" data-target="#myModal">
                                    {{ __('Active') }}
                                </button>
                                    @else
                                    <button type="button" class="btn btn-rounded btn-danger-rgba" data-toggle="modal" data-target="#myModal">
                                    {{ __('Deactivate') }}
                                  </button>
                                    @endif 
                               </td>  
                               <td>
                                <div class="dropdown">
                                    <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings')}}"><i class="feather icon-more-vertical-"></i></button>
                                    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                        @can('front-settings.sliders.edit')
                                        <a class="dropdown-item" href="{{url('slider/'.$cat->id)}}" title="{{ __('Edit')}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
                                        @endcan
                                        @can('front-settings.sliders.delete')
                                        <a class="dropdown-item" data-toggle="modal" data-target="#delete{{ $cat->id }}" title="{{ __('Delete')}}"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>                                        @endcan
                                      </div>
                                    </div>
                                  </td>
                                  <div class="modal fade bd-example-modal-sm" id="delete{{ $cat->id }}" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                    <form  method="post" action="{{url('slider/'.$cat->id)}}
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
  $(function() {
    $(document).on("change",".slider",function() {        
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '{{url('quickupdate/slider')}}',
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
  })
</script>
@endsection               
