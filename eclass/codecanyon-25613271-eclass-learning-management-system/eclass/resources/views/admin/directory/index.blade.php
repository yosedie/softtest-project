@extends('admin.layouts.master')
@section('title', 'SEO Directory  - Admin')
@section('maincontent')
<?php
$data['heading'] = 'SEO Directory';
$data['title'] = 'Front Settings';
$data['title1'] = 'SEO Directory';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">                
    <!-- Start row -->
    <div class="row">
      <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('SEO Directory')}}</h5>
                    <div>
                      <div class="widgetbar">
                        @can('front-settings.seo-directory.create')
                          <a href="{{url('directory/create')}}" class="btn btn-primary-rgba" title="{{ __('Add Directory')}}"><i class="feather icon-plus mr-2"></i>{{ __("Add Directory")}}</a>
                          @endcan
                          @can('front-settings.seo-directory.delete')
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
                                        <form method="post" action="{{ action('BulkdeleteController@seodirectorydeleteAll') }}
                                          " id="bulk_delete_form" data-parsley-validate class="form-horizontal form-label-left">
                                          {{ csrf_field() }}                                        
                                          <button type="button" class="btn btn-secondary-rgba" data-dismiss="modal">{{ __("No")}}</button>
                                          <button type="submit" class="btn btn-danger-rgba">{{ __("Yes")}}</button>
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
                              <th>{{ __('City') }}</th>
                              <th>{{ __('Details') }}</th>
                              <th>{{ __('Status') }}</th>
                              <th>{{ __('Action') }}</th>
                           
                            </tr>
                            </thead>
                            <tbody>
                              <?php $i=0;?>                 
                                @foreach($directory as $dir)
                                  <?php $i++;?>
                                  <tr>
                                    <td> <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$dir->id}}" id="checkbox{{$dir->id}}">
                                        <label for="checkbox{{$dir->id}}" class="material-checkbox"></label>
                                        <?php echo $i;?></td>
                                    <td>{{ $dir->city }}</td>
                                    <td>{!! $dir->detail !!}</td>
                                    <td>
                                      <label class="switch">
                                        <input class="directory" type="checkbox"  data-id="{{$dir->id}}" name="status" {{ $dir->status == '1' ? 'checked' : '' }}>
                                        <span class="knob"></span>
                                      </label>
                                    </td>                                   
                                    <td>
                                      <div class="dropdown">
                                          <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings')}}"><i class="feather icon-more-vertical-"></i></button>
                                          <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                            @can('front-settings.seo-directory.edit')
                                              <a class="dropdown-item" href="{{ route('directory.show',$dir->id) }}" title="{{ __('Edit')}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
                                              @endcan
                                              @can('front-settings.seo-directory.delete')
                                              <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-sm" title="{{ __('Delete')}}"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
                                              @endcan
                                              @can('front-settings.seo-directory.view')
                                              <a class="dropdown-item"   href="{{ route('directory.view',['id' => $dir->id, 'city' => str_slug(str_replace('-','&',$dir->city))]) }}" title="{{ __('View')}}"><i class="feather icon-eye mr-2"></i>{{ __("View")}}</a>
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
                                              <form  method="post" action="{{url('directory/'.$dir->id)}}
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
@section('script')
<script>
  "use Strict";
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
 
  $(document).on("change",".directory",function() { 
    $.ajax({
        type: "POST",
        dataType: "json",
        url: '{{url("quickupdate/directory")}}',
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
