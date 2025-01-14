@extends('admin.layouts.master')
@section('title','All Menus')
@section('maincontent')
<?php
$data['heading'] = 'All Menus';
$data['title'] = 'Front Setting';
$data['title1'] = 'Menus';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
    <div class="row">

        <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('All Menus') }} </h5>
                    <div>
                        <div class="widgetbar">
                            <a href="{{url('admin/menu/create')}}" class="float-right btn btn-primary-rgba mr-2" title="{{ __('Add Menu')}}"><i
                                    class="feather icon-plus mr-2"></i>{{ __('Add Menu') }} </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th>{{ __('Menu') }}</th>
                                    <th>{{ __('Info') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($menu as $key=>$policy)
                                <tr>
                                    <td>
                                        {{ $key+1 }}
                                    </td>
                                    <td>{{ $policy->title }}</td>
                                    <td>
                                        <p>
                                            @if($policy->link_by == 'page')
                                            <b>{{ __("Linked to:") }}</b> {{__("Page")}}
                                            @else
                                            <b>{{ __("Linked to:") }}</b> {{__('URL')}}
                                            @endif
                                        </p>
                                        <p> <b>{{ __('Status:') }} </b>
                                            @if($policy->status == '1')
                                            <span class="badge badge-success">{{ __("Active") }}</span>
                                            @else
                                            <span class="badge badge-danger">
                                                {{__("Deactive")}}
                                            </span>
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-round btn-outline-primary" type="button"
                                                id="CustomdropdownMenuButton1" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false" title="{{ __('Settings')}}"><i
                                                    class="feather icon-more-vertical-"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                                <a class="dropdown-item"
                                                    href="{{url('admin/menu/'.$policy->id.'/edit')}}" title="{{ __('Edit')}}"><i
                                                        class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                                                <a class="dropdown-item btn btn-link" data-toggle="modal"
                                                    data-target="#delete{{ $policy->id }}" title="{{ __('Delete')}}">
                                                    <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- delete Modal start -->                                       
                                    </td>
                                    <div class="modal fade bd-example-modal-sm" id="delete{{$policy->id}}"
                                        tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleSmallModalLabel">
                                                        {{ __('Delete') }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close" title="{{ __('Close')}}">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h4>{{ __('Are You Sure ?')}}</h4>
                                                    <p>{{ __('Do you really want to delete')}} ?
                                                        {{ __('This process cannot be undone.')}}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="post" action="{{url('admin/menu/'.$policy->id)}}"
                                                        class="pull-right">
                                                        {{csrf_field()}}
                                                        {{method_field("DELETE")}}
                                                        <button type="reset" class="btn btn-secondary"
                                                            data-dismiss="modal">{{ __('No') }}</button>
                                                        <button type="submit"
                                                            class="btn btn-danger">{{ __('Yes') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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