@extends('admin.layouts.master')
@section('title', 'Services - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Services';
$data['title'] = 'Front Settings';
$data['title1'] = 'Services';
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
                    <h5 class="card-title">{{ __('Services')}}</h5>
                    <div>
                      <div class="widgetbar">
                          <a href="{{url('admin/services/create')}}" class="btn btn-primary-rgba" title="{{ __('Add Service')}}"><i class="feather icon-plus mr-2"></i>{{ __("Add Service")}}</a>
                      </div>                        
                    </div>
                  </div>
                <div class="card-body">                 
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                              
                            
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                           
                            </tr>
                            </thead>
                            <tbody>
                              @foreach ($services as $service)
                                  <tr>
                                      <td>{{ $service->name }}</td>
                                      <td>  @if( $service->status == 1)
                                        <button type="button" class="btn btn-rounded btn-success-rgba" data-toggle="modal" data-target="#myModal">
                                          {{ __('Active') }}
                                        </button>   
                                            @else
                                            <button type="button" class="btn btn-rounded btn-danger-rgba" data-toggle="modal" data-target="#myModal">
        
                                            {{ __('Deactive') }}
                                          </button>
                                            @endif</td>
                                      <td>
                                          <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                          <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" style="display: inline;">
                                              @csrf
                                              @method('DELETE')
                                              <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this service?')">Delete</button>
                                          </form>
                                      </td>
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
