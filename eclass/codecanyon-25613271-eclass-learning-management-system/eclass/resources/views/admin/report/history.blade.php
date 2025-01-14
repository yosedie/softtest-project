@extends('admin.layouts.master')
@section('title',__('Device History'))
@section('maincontent')
<?php
$data['heading'] = 'Device History';
$data['title'] = 'Reports';
$data['title1'] = 'Device History';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
   <div class="row">
       <div class="col-md-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Device History') }}</h5>
                </div>
                <div class="card-body">
                   <table id="device_reports" class="text-dark w-100 table table-striped table-bordered">
                        <thead>
                            <th>{{ __("#") }}</th>
                            <th>{{ __("User name")}}</th>
                            <th>{{ __("IP Address") }}</th>
                            <th>{{ __("Platform") }}</th>
                            <th>{{ __("Browser") }}</th>
                            <th>{{ __("Logged in at") }}</th>
                            <th>{{ __("Logged out at") }}</th>
                        </thead>
                    </table>
                       
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    $(function () {
        "use strict";
        var table = $('#device_reports').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
            searchDelay: 450,
            ajax: '{{ route("device.logs") }}',
            language: {
                searchPlaceholder: "Search..."
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'username',
                    name: 'users.name'
                },
                {
                    data: 'ip_address',
                    name: 'auth_log.ip_address'
                },
                {
                    data: 'platform',
                    name: 'auth_log.platform'
                },
                {
                    data: 'browser',
                    name: 'auth_log.browser'
                },
                {
                    data: 'login_at',
                    name: 'auth_log.login_at'
                },
                {
                    data: 'logout_at',
                    name: 'auth_log.logout_at'
                }
            ],
            dom: 'lBfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print', 'colvis'
            ],
            order: [
                [0, 'DESC']
            ]
        });

    });
</script>
@endsection