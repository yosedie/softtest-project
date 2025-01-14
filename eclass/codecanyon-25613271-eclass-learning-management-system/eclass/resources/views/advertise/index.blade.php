@extends('admin.layouts.master')
@section('title', 'Advertise - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Advertise';
$data['title'] = 'Dashboard';
$data['title1'] = 'Advertise';
?>
@include('admin.layouts.topbar',$data)
@php
$ads = App\Ads::all();
@endphp
  <div class="contentbar">                
    <!-- Start row -->
    <div class="row">
      <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('Advertise')}}</h5>
                </div>
                <div>
                  <div class="widgetbar">
                    @can('player-settings.advertise.create')
                      <a href="{{ route('ad.create') }}" class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>{{ __("Add Advertise")}}</a>
                      @endcan
                      @can('player-settings.advertise.delete')
                      <a href="page-product-detail.html" class="btn btn-danger-rgba"  data-toggle="modal" data-target=".bd-example-modal-sm1"><i class="feather icon-trash mr-2"></i>{{__('Delete Selected')}}</a>
                      @endcan                       
                      <div class="modal fade bd-example-modal-sm1" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-sm">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="exampleSmallModalLabel">{{__('Delete')}}</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body text-center">
                                      <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                  </div>
                                  <div class="modal-footer">
                                      <form method="post" action="{{ action('AdsController@bulk_delete') }}
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
                <div class="card-body">
                 
                  <div class="table-responsive">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                      
                        <th> <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" id="checkboxAll">
                          <label for="checkboxAll" class="material-checkbox"></label>
                          #</th>
                        <th>{{ __("Ad Type")}}</th>
                        <th>{{ __("Ad Location")}}</th>
                       
                        <th>{{ __("Action")}}</th>
                        </thead>
        
                            <tbody>
                              <tr>
                             
                                @php $i=0; @endphp
                                @foreach($ads as $ad)
                                @php $i++ @endphp
                  
                                  
                  
                                   <td> <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$ad->id}}" id="checkbox{{$ad->id}}">
                                    <label for="checkbox{{$ad->id}}" class="material-checkbox"></label>
                                    {{ $i }}</td>
                                   <td class="fl">{{ $ad->ad_type }}</td>
                                   <td class="fl">{{ $ad->ad_location }}</td>
                                   <td>
                                    <div class="dropdown">
                                        <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                        <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                            <a class="dropdown-item"   href="{{ route('ad.edit',$ad->id) }}"><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
                                            <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
                                          
                                        </div>
                                    </div>
                                  </td>
    
                              
                               

                               
                                
                                <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleSmallModalLabel">{{__('Delete')}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                            </div>
                                            <div class="modal-footer">
                                              <form action="{{ route('ad.delete',$ad->id) }}" method="POST">
                                                {{ csrf_field() }} 
                                                {{ method_field('DELETE')}}
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
    $(function(){
      $('#checkboxAll').on('change', function(){
        if($(this).prop("checked") == true){
          $('.material-checkbox-input').attr('checked', true);
        }
        else if($(this).prop("checked") == false){
          $('.material-checkbox-input').attr('checked', false);
        }
      });
    });
  </script>
@endsection
