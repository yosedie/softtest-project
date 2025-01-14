@extends('admin.layouts.master')
@section('title', 'Openai')
@section('maincontent')
<?php
$data['heading'] = 'Openai';
$data['title'] = 'Openai';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
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
                    <h5 class="card-box">{{ __('All Openai') }}</h5>
                    <div>
                        <div class="widgetbar">
                            <button type="button" class="float-right btn btn-danger-rgba mr-2" data-toggle="modal"
                                data-target="#bulk_delete" title="{{ __('Delete Selected') }}"><i
                                    class="feather icon-trash mr-2"></i> {{ __('Delete Selected') }}</button>
                        </div>
                    </div>
                </div>
                <!-- card body started -->
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- table to display faq start -->
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                                <th>
                                    <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                                        value="all" />
                                    <label for="checkboxAll" class="material-checkbox"></label> #
                                </th>
                                <th>{{ __('Genrate') }}</th>
                                <th>{{ __('Prompt') }}</th>
                                <th>{{ __('Response') }}</th>
                                <th>{{ __('Action') }}</th>
                            </thead>
                             <tbody>
                                @foreach($openai as $key => $test)
                                @if(isset($test))
                                <tr>
                                    <td>
                                        <input type='checkbox' form='bulk_delete_form'
                                            class='check filled-in material-checkbox-input' name='checked[]'
                                            value="{{ $test->id }}" id='checkbox{{ $test->id }}'>
                                        <label for='checkbox{{ $test->id }}' class='material-checkbox'></label>
                                        <?php echo $key+1; ?>
                                        <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
                                            <div class="modal-dialog modal-sm">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            title="{{ __('Close') }}">&times;</button>
                                                        <div class="delete-icon"></div>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                                                        <p>{{ __('Do you really want to delete selected item ? This process
                                                    cannot be undone') }}.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form id="bulk_delete_form" method="post"
                                                            action="{{ route('openai.bulk.delete') }}">
                                                            @csrf
                                                            @method('POST')
                                                            <button type="reset" class="btn btn-gray translate-y-3"
                                                                data-dismiss="modal">{{ __('No') }}</button>
                                                            <button type="submit"
                                                                class="btn btn-danger">{{ __('Yes') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $test->generate }}
                                    </td>
                                    <td>
                                        {{ $test->prompt }}
                                    </td>
                                    @if($test->generate == 'Image Generate')
                                    @if(!empty($test->response))
                                    <td>
                                        <div class="ai-generate-image">
                                            <img src="{{ $test->response }}" class="img-fluid img-circle" alt="{{ $test->response }}">
                                            <div class="img-output-icon">
                                                <ul>
                                                    <li><a href="{{ $test->response }}" title="Download" download><i class="feather icon-download"></i></a></li>
                                                    <li><a href="{{ $test->response }}" data-lightbox="homePortfolio" title="View" target="_blank"><i class="feather icon-eye"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    @endif                                     
                                    @else
                                     @php
                                        $jsonData = $test->response;
                                        $decodedData = json_decode($jsonData, true);
                                    @endphp
                                    <td>{{ $decodedData['content'] ?? ''}}</td>
                                     @endif
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-round btn-outline-primary" type="button"
                                                id="CustomdropdownMenuButton1" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"
                                                title="{{ __('Settings') }}"><i
                                                    class="feather icon-more-vertical-"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                                <a class="dropdown-item btn btn-link" data-toggle="modal"
                                                    data-target="#delete{{ $test->id }}" title="{{ __('Delete') }}">
                                                    <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                                </a>
                                            </div>
                                        </div>
                                        ​
                                        <!-- delete Modal start -->
                                        <div class="modal fade bd-example-modal-sm" id="delete{{ $test->id }}"
                                            tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleSmallModalLabel">
                                                            {{ __('Delete') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close" title="{{ __('Close') }}">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4>{{ __('Are You Sure ?')}}</h4>
                                                        <p>{{ __('Do you really want to delete')}} <b>{{$test->title}}</b>
                                                            ? {{ __('This process cannot be undone.')}}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="post" action="{{url('openai/delete/'.$test->id)}}"
                                                            class="pull-right">
                                                            {{csrf_field()}}
                                                            {{method_field("DELETE")}}
                                                            <button type="reset" class="btn btn-secondary"
                                                                data-dismiss="modal">{{ __('No') }}</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">{{ __('Yes') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- delete Model ended -->
                                        ​
                                    </td>

                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                        <!-- table to display faq data end -->
                    </div><!-- table-responsive div end -->
                </div><!-- card body end -->

            </div><!-- col end -->
        </div>
    </div>
</div>
<!-- row end -->
<br><br>
@endsection
<!-- main content section ended -->
@section('script')
<script src="{{ url('admin_assets/assets/js/lightbox-plus-jquery.min.js') }}"></script>
<script>
    $("#checkboxAll").on('click', function () {
$('input.check').not(this).prop('checked', this.checked);
});
</script>
@endsection