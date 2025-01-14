@extends('admin.layouts.master')
@section('title', 'Support Admin ')
@section('maincontent')
<?php
$data['heading'] = 'Support Admin ';
$data['title'] = 'Support Admin';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    <div class="row">
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $error)
            <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close"
                    title="{{ __('Close') }}">
                    <span aria-hidden="true" style="color:red;">&times;</span></button></p>
            @endforeach
        </div>
        @endif
        <!-- row started -->
        <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Support Admin') }}</h5>
                    <div>
                        <div class="widgetbar">
                            @can('blogs.delete')
                            <button type="button" class="float-right btn btn-danger-rgba mr-2" data-toggle="modal"
                                data-target="#bulk_delete" title="{{ __('Delete Selected') }}"><i
                                    class="feather icon-trash mr-2"></i> {{ __('Delete Selected') }}</button>
                            @endcan
                            @can('blogs.create')
                            <a href="{{route('supportadmin.create')}}" class="float-right btn btn-primary-rgba mr-2"
                                title="{{ __('Support ') }}"><i class="feather icon-plus mr-2"></i>{{ __('Support
                                ')
                                }}</a>
                            @endcan
                        </div>
                    </div>
                </div>

                <!-- card body started -->
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- table to display blog start -->
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                                <th>
                                    <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                                        value="all" />
                                    <label for="checkboxAll" class="material-checkbox"></label>
                                </th>

                                <th>{{ __('#') }}</th>
                                <th>{{ __('User Details') }}</th>
                                <th>{{ __('Issue') }}</th>
                                <th>{{ __('Subject') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Reply') }}</th>
                                <th>{{ __('Action') }}</th>
                            </thead>
                            <tbody>
                                @if ($supports)
                                @foreach ($supports as $data)
                                <tr>
                                    <td>
                                        <input type='checkbox' form='bulk_delete_form'
                                            class='check filled-in material-checkbox-input' name='checked[]'
                                            value="{{ $data->id }}" id='checkbox{{ $data->id }}'>
                                        <label for='checkbox{{ $data->id }}' class='material-checkbox'></label>
                                    </td>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <ul>
                                            <li><strong>{{ __('Name:') }}</strong> {{ $data->user->fname }} {{ $data->user->lname }}</li>
                                            <li><strong>{{ __('Email:') }}</strong>
                                                <a href="mailto:{{ $data->user->email }}" title="{{ $data->user->fname . ' '. $data->user->lname }}" class="email-tag">{{
                                                    $data->user->email }}</a>
                                            </li>
                                            <li><strong>{{ __('Ticket Id:') }}</strong> {{ $data->ticket_id }}</li>
                                        </ul>
                                    </td>
                                    <td>{{ $data->SupportType->name}}</td>
                                    <td>{{ $data->subject }}</td>
                                    <td>
                                        @if($data->status == 0)
                                        <span class="badge text-bg-warning">{{ __('Pending')}}</span>
                                        @else
                                        <span class="badge text-bg-success">{{ __('Close')}}</span>
                                        @endif
                                    </td>
                                    ​<td>
                                        @if($data->status != 1)
                                        <a data-toggle="modal" data-target="#replyModal{{ $data->id }}" title="{{ __('Reply') }}">
                                            <span class="badge text-bg-primary reply-badge">{{ __('Reply') }}</span>
                                        </a>
                                        @else
                                            <span class="badge text-bg-danger">{{ __('Close Support')}}</span>
                                    @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-round btn-outline-primary" type="button"
                                                id="CustomdropdownMenuButton1" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"
                                                title="{{ __('Settings') }}"><i
                                                    class="feather icon-more-vertical-"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                                
                                                @can('pages.delete')
                                                <a class="dropdown-item btn btn-link" data-toggle="modal"
                                                    data-target="#delete{{ $data->id }}" title="{{ __('Delete') }}">
                                                    <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                                </a>
                                                @endcan
                                            </div>
                                        </div>
                                        ​
                                        <!-- delete Modal start -->
                                        <div class="modal fade bd-example-modal-sm" id="delete{{ $data->id }}"
                                            tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleSmallModalLabel">{{
                                                            __('Delete') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close" title="{{ __('Close') }}">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4>{{ __('Are You Sure ?')}}</h4>
                                                        <p>{{ __('Do you really want to delete')}}
                                                            <b>{{$data->title}}</b>
                                                            ? {{ __('This process cannot be undone.')}}
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="post"
                                                            action="{{url('/support_admin/'.$data->id . '/delete')}}"
                                                            class="pull-right">
                                                            {{csrf_field()}}
                                                            {{method_field("DELETE")}}
                                                            <button type="reset" class="btn btn-secondary"
                                                                data-dismiss="modal">{{ __('No') }}</button>
                                                            <button type="submit" class="btn btn-primary">{{ __('Yes')
                                                                }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- delete Model ended -->
                                        ​ <div class="modal fade contact-view-modal" id="replyModal{{ $data->id }}"
                                            tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleSmallModalLabel">
                                                            {{ __('Reply Issue') }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ url('support_reply/' . $data->id) }}" method="post"
                                                        enctype="multipart/form-data">
                                                        @method('put')
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <label for="Title" class="form-label">{{ __('Support
                                                                            Type') }}</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-lg" id="Name"
                                                                            value="{{ $data->SupportType->name }}" readonly>
                                                                    </div>
                                                                </div>
    
                                                                <div class="col-lg-6 col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <label for="Title" class="form-label">{{
                                                                            __('Subject')
                                                                            }}</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-lg" id="Name"
                                                                            value="{{ $data->subject }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="form-group mb-3">
                                                                        <label for="Title" class="form-label">{{
                                                                            __('Message')
                                                                            }}</label>
                                                                        <textarea class="form-control" id="" cols="30" readonly
                                                                            rows="4">{{ $data->message }}</textarea>
                                                                    </div>
                                                                </div>
    
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="form-group mb-3">
                                                                        <label for="Title" class="form-label">{{ __('Issue
                                                                            Image')
                                                                            }}</label>
                                                                        <div class="table-img">
                                                                            <img src="{{ asset('/images/support_issue/' . $data->image) }}"
                                                                                class="img-fluid img-circle">
                                                                        </div>
                                                                    </div>
                                                                </div>
    
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="form-group mb-3">
                                                                        <label for="Title" class="form-label">{{ __('Reply')
                                                                            }}</label>
                                                                        <textarea class="form-control" name="reply" id=""
                                                                            cols="30" rows="2">{{ $data->reply }}</textarea>
                                                                    </div>
                                                                </div>
    
    
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary"><i
                                                                    class="flaticon-upload-1"></i>
                                                                {{ __('Submit') }}</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">{{ __('Close') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                                @endif
                            </tbody>

                        </table>
                        <!-- table to display blog data end -->
                    </div><!-- table-responsive div end -->
                </div><!-- card body end -->

            </div><!-- col end -->
        </div>
    </div>
    <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" title="{{ __('Close') }}">&times;</button>
                    <div class="delete-icon"></div>
                </div>
                <div class="modal-body text-center">
                    <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                    <p>{{ __('Do you really want to delete selected item ? This
                        process
                        cannot be undone') }}.</p>
                </div>
                <div class="modal-footer">
                    <form id="bulk_delete_form" method="post" action="{{ route('support_admin.bulk_delete') }}">
                        @csrf
                        @method('POST')
                        <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __('No')
                            }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Yes')
                            }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- row end -->
<br><br>
@endsection