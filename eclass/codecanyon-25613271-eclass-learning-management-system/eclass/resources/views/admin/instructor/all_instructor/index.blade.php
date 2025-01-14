@extends('admin.layouts.master')
@section('title', 'All Instructors - Admin')
@section('maincontent')
<?php
$data['heading'] = 'All Instructors';
$data['title'] = 'All Instructors';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">                
    <!-- Start row -->
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header all-user-card-header">
          <ul class="nav nav-pills" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="false" title="{{ __('All Instructors') }}">{{ __('All Instructors') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false" title="{{ __('Pending Instructors Request') }}">{{ __('Pending Instructors Request') }}</a>
            </li>
          </ul>
        </div>
        <div>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="all-user-menu">
              <div class="row">
                <div class="col-lg-4">
                    <h5 class="box-title">{{ __('All Instructors') }}</h5>
                </div>
                <div class="col-lg-8 text-right menus-button">
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
                          <form method="post" action="{{ action('BulkdeleteController@instructorrequestdeleteAll') }}" id="bulk_delete_form" data-parsley-validate class="form-horizontal form-label-left">
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
                      </th>
                      <th>{{ __('Instructor Pic') }}</th>
                      <th>{{ __('Instructor Detail') }}</th>
                      <th>{{ __('Status') }}</th>
                      <th>{{ __('Action') }}</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($items as $item)
                    <tr>
                      <td>
                        <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$item->id}}" id="checkbox{{$item->id}}">
                        <label for="checkbox{{$item->id}}" class="material-checkbox"></label>
                      </td>
                      <td>
                                      @if($image = @file_get_contents('../public/images/user_img/'.$item->user_img))
                    <img @error('photo') is-invalid @enderror
                        src="{{ url('images/user_img/'.$item->user_img) }}" alt="{{$item->fname}}"
                        class="img-responsive img-circle">
                @else
                <img @error('photo') is-invalid @enderror
                        src="{{ Avatar::create($item->fname)->toBase64() }}" alt="{{$item->fname}}"
                        class="img-responsive img-circle" 
                      >

                @endif
                      </td>
                      {{-- @if(isset($item->image))
                      <td><img src="{{ asset('images/user/'.$item->image)}}" class="img-responsive img-circle" alt="{{$item->fname}}"></td> 
                      @endif --}}
                      <td>
                        <ul class="user-dtl-name">
                          <li><span>Name:</span> {{$item->fname}}</li>
                          <li><span>Email:</span> <a href="mailto:{{$item->email}}">{{$item->email}}</a></li>
                          <li><span>Mobile:</span> <a href="tel:{{$item->mobile}}">{{$item->mobile}}</a></li>
                        </ul>
                      </td>
                      <td>
                        @if($item->status==1)
                          <span class="badge badge-pill badge-success"> {{ __('Approved') }}</span>
                            
                          @else
                          <span class="badge badge-pill badge-warning"> {{ __('Pending') }}</span>
                        @endif

                      </td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings') }}"><i class="feather icon-more-vertical-"></i></button>
                          <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                              <a class="dropdown-item" data-toggle="modal" data-target="#instructorviewModal{{ $item->id }}" title="{{ __('View') }}"><i class="feather icon-delete mr-2"></i>{{ __("View") }}</a>
                              <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-sm" title="{{ __('Delete') }}"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
                          </div>
                        </div>
                      
                        @php
                        $show = $item;
                        @endphp
                        @if(isset($show))
                        <div class="modal fade" id="instructorviewModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleStandardModalLabel">{{__('View Instructor Details') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="card m-b-30">
                                  <div class="card-body">
                                    <div class="form-group col-md-12">
                                      <div class="instructor-detail-img text-center">
                                        
                                      @if($image = @file_get_contents('../public/images/user_img/'.$show->user_img))
                                      <img @error('photo') is-invalid @enderror
                                          src="{{ url('images/user_img/'.$show->user_img) }}" alt="{{ $show->fname }} {{ $show['lname'] }}"
                                          class="img-responsive img-circle">
                                  @else
                                  <img @error('photo') is-invalid @enderror
                                          src="{{ Avatar::create($show->fname)->toBase64() }}" alt="{{ $show->fname }} {{ $show['lname'] }}"
                                          class="img-responsive img-circle" 
                                        >
                  
                                  @endif
                                      </div>
                                      <div class="mt-3">
                                        <h4 class="text-center">{{ $show->fname }} {{ $show['lname'] }}</h4>
                                      </div>
                                      <br>
                                      <div class="table-responsive">
                                        <table class="table table-borderless mb-0 user-table">
                                          <tbody>
                                            <tr>
                                              <th scope="row" class="p-1"><span class="text-color">{{ __('Role') }}:</span> </th>
                                              <td class="p-1"> {{ $show->role }}</td>
                                            </tr>
                                            <tr>
                                              <th scope="row" class="p-1"><span class="text-color">{{ __('Phone') }}:</span> </th>
                                              <td class="p-1"> <a href="tel:{{ $show->mobile }}">{{ $show->mobile }}</a></td>
                                            </tr>
                                            <tr>
                                              <th scope="row" class="p-1"><span class="text-color">{{ __('Email') }}:</span></th>
                                              <td class="p-1"> <a href="mailto:{{ $show->email }}">{{ $show->email }}</a></td>
                                            </tr>
                                            <tr>
                                              <th scope="row" class="p-1"><span class="text-color">{{ __('Detail') }}:</span></th>
                                              <td class="p-1"> {{ $show->detail }}</td>
                                            </tr>
                                            <tr>
                                              <th scope="row" class="p-1"><span class="text-color">{{ __('Resume') }}:</span> </th>
                                              <td class="p-1"> <a href="{{ asset('files/instructor/'.$show->file) }}" download="{{$show->file}}" title="{{ __('Download') }}">{{ __('Download') }} <i class="fa fa-download"></i></a></td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </div>
                                      <br>
                              
                                      <form action="{{route('requestinstructor.update',$show->id)}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <div class="form-group">
                                          <input type="hidden" value="{{ $show->user_id }}" name="user_id" class="form-control">
                                            <input type="hidden" value="{{ $show->role }}" name="role" class="form-control">
                                          <input type="hidden" value="{{ $show->mobile }}" name="mobile" class="form-control">
                                          <input type="hidden" value="{{ $show->detail }}" name="detail" class="form-control">
                                          <input type="hidden" value="{{ $show->image }}" name="image" class="form-control">
                                        </div>
                                        <div class="row">
                                          <div class="col-md-4">
                                            <label for="exampleInputTit1e">{{ __('Status') }}:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <input  type="checkbox" name="search_enable"  class="custom_toggle"   {{ $show->status==1 ? 'checked' : '' }} />
                                            <input type="hidden" name="status" value="{{ $show->status }}" id="c33">
                                          </div>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="form-group">
                                          <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                          <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update') }}"><i class="fa fa-check-circle"></i>
                                          {{ __("Update")}}</button>
                                        </div>
                                  
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        @endif
                      </td>
                      <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-sm">
                              <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                      <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                  </div>
                                  <div class="modal-footer">
                                    <form  method="post" action="{{url('requestinstructor/'.$item->id)}}
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
                      <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="col-lg-8 text-right">
                          @can(' instructor-pending-request.manage')
                          <a href="page-product-detail.html" class="btn btn-danger-rgba"  data-toggle="modal" data-target=".bd-example-modal-sm1"><i class="feather icon-trash mr-2"></i>{{ __('Delete Selected') }}</a>
                          @endcan                         
                          <div class="modal fade bd-example-modal-sm1" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-sm">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body text-center">
                                          <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                      </div>
                                      <div class="modal-footer">
                                        
                                        
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
                                          <button type="submit" class="btn btn-primary">{{ __("Delete")}}</button>
                                      </form>
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
                                      <th>{{ __('Image') }}</th>
                                      <th>{{ __('Name') }}</th>
                                      <th>{{ __('Email') }}</th>
                                      <th>{{ __('Detail') }}</th>
                                      <th>{{ __('Status') }}</th>
                                      <th>{{ __('Action') }}</th>
                                    
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($items as $item)
                                    <tr>
                                      @if($item->status == '0')
                                        <td><img src="{{ asset('images/instructor/'.$item->image)}}" class="img-circle"></td> 
                                        <td>{{$item->fname}}</td>
                                        <td>{{$item->email}}</td>
                                        <td>{{ str_limit($item->detail, $limit= 50, $end = '...')}}</td>
                                        <td>
                                          @if($item->status==1)
                                          <span class="badge badge-pill badge-success"> {{ __('Approved') }}</span>
                                          
                                          @else
                                          <span class="badge badge-pill badge-warning"> {{ __('Pending') }}</span>
                                          @endif
                                        </td>
                                    <td>
                                      <div class="dropdown">
                                          <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                          <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                              @can('instructorrequest.edit')
                                              <a class="dropdown-item"   href="{{route('requestinstructor.edit',$item->id)}}"><i class="feather icon-eye mr-2"></i>{{ __("View")}}</a>
                                              @endcan
                                              @can('instructorrequest.delete')
                                              <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
                                              @endcan
                                            
                                          </div>
                                      </div>
                                    </td>
      
                                    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                                </div>
                                                <div class="modal-footer">
                                                  <form  method="post" action="{{url('requestinstructor/'.$item->id)}}
                                                    "data-parsley-validate class="form-horizontal form-label-left">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
                                                    <button type="submit" class="btn btn-primary">{{ __("Delete")}}</button>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  
                                  </tr>   
                                  @endif  
                                    @endforeach
                                  
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                      </div>
                  </div>
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

 
        $(document).on("change",".all_instructor",function() { 
        
        $.ajax({
        
            type: "POST",
            dataType: "json",
            url: "{{url('quickupdate/instructorrequest')}}",
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