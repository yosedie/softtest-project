@extends('admin.layouts.master')
@section('title','All Roles And Permissions')
@section('maincontent')
<?php
$data['heading'] = 'Role & permission';
$data['title'] = 'Role & permission';
$data['title1'] = 'Role';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">   
    <div class="row">
        <div class="col-lg-12">
          <div class="card dashboard-card m-b-30">
              <div class="card-header">
               <h5 class="card-title"> {{__("Roles")}}</h5>
                </div>
              <div class="widgetbar">
                @can('role.create')
                    <a href="{{route('roles.create')}}" class="float-right btn btn-primary-rgba mr-2"><i
                            class="feather icon-plus mr-2"></i>{{ __('Create a new role') }} </a>
                @endcan
            </div>
              <div class="card-body">
               
                  <div class="table-responsive">
                    <table id="roletable" class="table table-borderd responsive " style="width: 100%">

                        <thead>
                            <th>
                                #
                            </th>
                            <th>
                                {{__("Role Name")}}
                            </th>
                            <th>
                                {{__('Action')}}
                            </th>
                        </thead>
                    
                        <tbody>
                    
                        </tbody>
                    
                    
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End col -->
</div>

@endsection     
                        
@section('script')
    <script>
       $(document).ready(function () {
        var table = $('#roletable').DataTable({
            lengthChange: false,
            responsive: true,
            serverSide: true,
            autoWidth: true,
            ajax: '{{ route('roles.index') }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'name',
                    name: 'roles.name'
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable : false
                }
            ],
            dom: 'lBfrtip',
            buttons: [
                'copy',
                'excel',
                'csv',
                'pdf',
                'print'
            ],
            order: [
                [1, 'ASC']
            ]
        });

    });
    </script>
@endsection    
            