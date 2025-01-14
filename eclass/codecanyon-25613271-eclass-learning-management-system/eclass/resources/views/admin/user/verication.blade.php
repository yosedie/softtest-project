@extends('admin.layouts.master')
@section('title', 'Users Verification - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Users Verification';
$data['title'] = 'Users Verification';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
    <div class="row">
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $error)
            <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
                    <span aria-hidden="true" style="color:red;">&times;</span></button></p>
            @endforeach
        </div>
        @endif

        <!-- row started -->
        <div class="col-lg-12">

            <div class="card dashboard-card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Users Verification') }}</h5>
                </div>

                <!-- card body started -->
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- table to display faq start -->
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                                <th>
                                    #
                                </th>
                                <th>{{ __('User Name') }}</th>
                                <th>{{ __('Role') }}</th>
                                <th>{{ __('Verified') }}</th>
                                <th>{{ __('Blocked') }}</th>
                                <th>{{ __('Action') }}</th>
                            </thead>

                            <tbody>
                                @foreach($users as $key=>$user)
                                <td>
                                    <?php echo $key+1; ?>
                                </td>
                                <td data-toggle="modal" data-target="#exampleModal"><p>{{$user->fname}} {{$user->lname}}</p></td>
                                <td>{{$user->role}}</td>
                                <td>
                                    @if( $user->is_verify == 1)
                                    <button  class="btn btn-rounded btn-success-rgba pointer-remove" data-toggle="modal" data-target="#myModal" title="{{ __('Verified') }}">
                                          {{ __('Verified') }}
                                    </button>
                                    @else
                                          <button type="button" class="btn btn-rounded btn-danger-rgba pointer-remove" data-toggle="modal" data-target="#myModal" title="{{ __('Not Verified') }}">
                                          {{ __('Not Verified') }}
                                          </button>
                                    @endif 
                                </td>
                                <td>
                                    @if( $user->is_blocked == 1)
                                    <button type="button" class="btn btn-rounded btn-danger-rgba pointer-remove" data-toggle="modal" data-target="#myModal" title="{{ __('Blocked') }}">
                                          {{ __('Blocked') }}
                                    </button>
                                          @else
                                          <button type="button" class="btn btn-rounded btn-success-rgba pointer-remove" data-toggle="modal" data-target="#myModal" title="{{ __('Not Blocked') }}">
                                          {{ __('Not Blocked') }}
                                          </button>
                                          @endif 
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$user->id}}" title="{{ __('View') }}">{{ __('View') }}</button>

                                </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{$user->fname}} {{$user->lname}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-4">{{ __('Email') }} :</div><div class="col-lg-8"><a href="mailto:{{$user->email}}">{{$user->email}}</a></div>
                                                <div class="col-lg-4">{{ __('Mobile') }} :</div><div class="col-lg-8"><a href="tel:{{$user->mobile}}">{{$user->mobile}}</a></div>
                                                <div class="col-lg-4">{{ __('User Role') }} :</div><div class="col-lg-8">{{$user->role}}</div>
                                                @if($user->document_detail)
                                                    @if(isset($user->document_detail))
                                                    <div class="col-lg-4">{{ __('Document Details') }} :</div><div class="col-lg-4">{{$user->document_detail}}</div><div class="col-lg-4"><a href="{{ url('images/user_img/'.$user->document_file) }}" target="_blank"><i class="fa fa-file" aria-hidden="true"></i></a></div>
                                                    @endif
                                                @else
                                                <div class="col-lg-12 text-center mt-2">{{ __('No Document') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                            <button type="button" class="btn btn-info"  data-toggle="modal" data-target="#blockedModal{{$user->id}}" title="{{ __('Block') }}">{{ __('Block') }}</button>
                                            <button type="button" class="btn btn-success" title="{{ __('Verify') }}"><a class="text-white" href="{{ url('images/user_img/'.$user->document_file) }}" download="document.png" onclick="verify({{$user->id}})">{{ __('Verify') }}</a></button>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="blockedModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="blockedModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="blockedModalLabel">{{$user->fname}} {{$user->lname}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('user_blocked') }}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="form-group col-lg-12">
                                                        <label for="exampleFormControlTextarea1">{{ __('Block Note') }}</label>
                                                        <textarea class="form-control" name="block_note" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                        <input type="hidden" name="id" value="{{$user->id}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" title="{{ __('Close') }}">{{ __('Close') }}</button>
                                                <button type="submit" class="btn btn-primary" title="{{ __('Save') }}">{{ __('Save') }}</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                                                        
                                @endforeach
                            </tbody>
                        </table>
                        <!-- table to display faq data end -->
                    </div><!-- table-responsive div end -->
                </div><!-- card body end -->

            </div><!-- col end -->
        </div>
    </div>
</div><!-- row end -->
@endsection
@section('script')
<script>
function verify(id) {
    $.ajax({
        url: "{{ route('verifed_user') }}",
        type: 'GET',
        data: {id:id},
        dataType: 'JSON',
        success: function (data) { 
            console.log(data)
            window.location.reload();
        }
    }); 
}
</script>
@endsection