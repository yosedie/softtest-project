@extends('admin.layouts.master')
@section('title', 'Services - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Support';
$data['title'] = 'Support';
$data['title1'] = 'Support';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)
        <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close"
                title="{{ __('Close')}}">
                <span aria-hidden="true" style="color:red;">&times;</span></button></p>
        @endforeach
    </div>
    @endif
    <div class="row">
        <div class="col-lg-3 col-md-4">
            <!--form code start-->
            <form action="{{ route('support_users.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="client-detail-block">
                    <h5 class="block-heading"></h5>
                    <div class="form-group">
                        <label for="hedaing" class="form-label">{{ __('User') }}<span class="required">*</span></label>
                        <select class="form-select" aria-label=" " name="user_id">
                            <option selected disabled>{{ __('Select Users ') }}</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-control-icon"><i class="flaticon-user"></i></div>
                    </div>
                    <div class="form-group">
                        <label for="hedaing" class="form-label">{{ __('Priority') }}<span
                                class="required">*</span></label>
                        <select class="form-select" aria-label=" " name="priority">
                            <option selected disabled>{{ __('Select Priority ') }}</option>
                            <option value="L">Lower</option>
                            <option value="M">Mid</option>
                            <option value="H">High</option>
                            <option value="C">critical</option>
                        </select>
                        <div class="form-control-icon"><i class="flaticon-task"></i></div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">{{ __('Support Type') }}<span
                                class="required">*</span></label>
                        <select class="form-select" aria-label=" " name="support_id">
                            <option selected disabled>{{ __('Select support Type ') }}</option>
                            @isset($supportstypes)
                            @foreach ($supportstypes as $supportstype)
                            <option value="{{ $supportstype->id }}">{{ $supportstype->name }}</option>
                            @endforeach
                            @endisset
                        </select>
                        <div class="form-control-icon"><i class="flaticon-title"></i></div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-8">
                                <label for="image" class="form-label">{{ __('Image') }}</label>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="suggestion-icon float-end">
                                    <div class="tooltip-icon">
                                        <div class="tooltip">
                                            <div class="credit-block">
                                                <small class="recommended-font-size">{{ __('Recommended Size :
                                                    720x900') }}</small>
                                            </div>
                                        </div>
                                        <span class="float-end"><i class="flaticon-info"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input class="form-control" type="file" name="image" id="image" accept="image/*">
                        <div class="form-control-icon"><i class="flaticon-upload-2"></i></div>
                    </div>
                    <div class="form-group">
                        <label for="slug" class="form-label">{{ __('Message ') }}<span class="required">*</span></label>
                        <textarea class="form-control form-control-padding_15" name="message" id="msg" cols="30"
                            rows="5" placeholder="{{__('Please enter your message')}}" required></textarea>
                    </div>
                    <div class="form-group-btn">
                        <button type="submit" class="btn btn-primary"><i class="flaticon-upload-1"></i> {{
                            __('Submit') }}</button>
                    </div>
                </div>
            </form>
            <!-- form code end -->
        </div>
        <div class="col-lg-9 col-md-8">
            <div class="client-detail-block support-admin-block">
                <div class="table-responsive table-remove-export">
                    <!-- table code start -->
                    <table class="table data-table table-borderless" id="example">
                        <thead>
                            <tr>
                                <th><input class="form-check-input" type="checkbox" id="checkboxAll"></th>
                                <th>{{ __('Users Details') }}</th>
                                <th>{{ __('Message') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Reply') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <!-- loop Print data show start -->
                        <tbody id="sortable-table">
                            @if ($supports)
                            @foreach ($supports as $data)
                            @if (Auth::check() && Auth::user()->role == 'A' && Auth::user()->id != $data->id)
                            <tr>
                                <td>
                                    <input type="checkbox" form="bulk_delete_form"
                                        class="check filled-in material-checkbox-input form-check-input"
                                        name="checked[]" value="{{ $data->id }}" id="checkbox{{ $data->id }}">
                                </td>
                                <td>
                                    <ul>
                                        <li><strong>{{ __('Name:') }}</strong> {{ $data->Users->name }}</li>
                                        <li><strong>{{ __('Email:') }}</strong>
                                            <a href="mailto:{{ $data->Users->email }}" title="{{ $data->Users->name }}" class="email-tag">{{
                                                $data->Users->email }}</a>
                                        </li>
                                        <li><strong>{{ __('Ticket Id:') }}</strong> {{ $data->ticket_id }}</li>
                                    </ul>
                                </td>
                                <td>
                                    {{ $data->message }}
                                </td>

                                <td>
                                    @if($data->status == 0)
                                    <span class="badge text-bg-warning">{{ __('Pending')}}</span>
                                    @else
                                    <span class="badge text-bg-success">{{ __('Close')}}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($data->status != 1)
                                    <a data-bs-toggle="modal" data-bs-target="#viewModal{{ $data->id }}"
                                        title="{{ __('Reply') }}"><span class="badge text-bg-primary">{{ __('Reply')
                                            }}</span></a>
                                    @else
                                    <span class="badge text-bg-danger">{{ __('Close Support')}}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown action-dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="flaticon-dots"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @can('support.manage')
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{ $data->id }}"
                                                    title="{{ __('Delete') }}"><i class="flaticon-delete"></i>
                                                    {{ __('Delete') }}</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            {{-- -------------model Start ------------------- --}}
                            <div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                {{ __('Are You Sure ?') }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{ __('Do you really want to delete') }} ?
                                                {{ __('This process cannot be undone.') }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form method="post"
                                                action="{{ url('admin/support_admin/' . $data->id . '/delete') }}"
                                                class="pull-right">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">{{ __('No') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ __('Yes')
                                                    }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ------------- model end ------------------------- --}}
                            <div class="modal fade contact-view-modal" id="viewModal{{ $data->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleSmallModalLabel">
                                                {{ __('Reply Issue') }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ url('admin/support_reply/' . $data->id) }}" method="post"
                                            enctype="multipart/form-data">
                                            @method('put')
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4">
                                                        <div class="form-group mb-3">
                                                            <label for="Title" class="form-label">{{ __('Support Type')
                                                                }}</label>
                                                            <input type="text" class="form-control form-control-lg"
                                                                id="Name"
                                                                value="@if ($data->priority == 'L') Lower @elseif($data->priority == 'M') Mid @elseif($data->priority == 'H') High @else critical @endif"
                                                                readonly>
                                                            <div class="form-control-icon"><i
                                                                    class="flaticon-title"></i></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4">
                                                        <div class="form-group mb-3">
                                                            <label for="Title" class="form-label">{{ __('Support Type')
                                                                }}</label>
                                                            <input type="text" class="form-control form-control-lg"
                                                                id="Name"
                                                                value="{{ isset($data->SupportType->name) ? $data->SupportType->name : '' }}"
                                                                readonly>
                                                            <div class="form-control-icon"><i
                                                                    class="flaticon-select"></i></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-md-4">
                                                        <div class="form-group mb-3">
                                                            <label for="Title" class="form-label">{{ __('Message')
                                                                }}</label>
                                                            <input type="text" class="form-control form-control-lg"
                                                                id="Name" value="{{ $data->message }}" readonly>
                                                            <div class="form-control-icon"><i
                                                                    class="flaticon-chat-2"></i></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group mb-3">
                                                            <label for="Title" class="form-label">{{ __('Reply')
                                                                }}</label>
                                                            <textarea class="form-control" name="reply" id="" cols="30"
                                                                rows="2">{{ $data->reply }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4">
                                                        <div class="form-group mb-3">
                                                            <label for="Title" class="form-label">{{ __('Image')
                                                                }}</label>
                                                            <div class="support-img">
                                                                <img src="{{ asset('/images/support_issue/' . $data->image) }}"
                                                                    class="img-fluid" alt="user img">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary"><i
                                                        class="flaticon-upload-1"></i>
                                                    {{ __('Submit') }}</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal"><i class="flaticon-close"></i>
                                                    {{ __('close') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
        @endforeach
        <!-- loop  Print data show end----------------------------->
        @endif
        </tbody>
        </table>
        <!-- table code end -->
        <div class="d-flex justify-content-end">
            <div class="pagination pagination-circle mb-3">
            </div>
        </div>
    </div>
</div>
<!-- Bulk Delete Modal start -->
<div class="modal fade" id="bulk_delete" tabindex="-1" aria-labelledby="bulkDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="bulkDeleteLabel">{{ __('Delete Selected Records') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Do you really want to delete the selected records? This action cannot be undone.') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('No') }}</button>
                <form id="bulk_delete_form" method="post" action="{{ route('support_admin.bulk_delete') }}">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Bulk Delete Modal end -->
@endsection