@extends('admin.layouts.master')
@section('title', 'Instructor Revenue Reports')
@section('maincontent')
<?php
$data['heading'] = 'Instructor Revenue Reports';
$data['title'] = 'Reports';
$data['title1'] = 'Instructor Revenue Reports';
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
                    <h5 class="card-box">{{ __('Instructor Revenue Reports') }}</h5>
                    <div>
                        <div class="widgetbar">
                        <button type="button" class="float-right btn btn-danger-rgba mr-2" data-toggle="modal" data-target="#bulk_delete" title="{{ __('Delete Selected') }}"><i
                                  class="feather icon-trash mr-2"></i> {{__('Delete Selected')}}</button>
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
                                <label for="checkboxAll" class="material-checkbox"></label>   # 
                            </th>
                            <th>{{ __('Enrolled Courses') }}</th>
                            <th>{{ __('Instructor') }}</th>
                            <th>{{ __('Total Amount') }}</th>
                            <th>{{ __('Instructor Revenue') }}</th>
                            <th>{{ __('Enrolled Date') }}</th>
                        </thead>

                        <tbody>
                            <?php $i=0;?>
                            @foreach($revenue as $rev)
                            <?php $i++;?>
                            <tr>
                            <td>
                                                     
                                    <input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input'
                                        name='checked[]' value={{ $rev->id }} id='checkbox{{ $rev->id }}'>
                                    <label for='checkbox{{ $rev->id }}' class='material-checkbox'></label>
                                    <?php echo $i; ?>
                                <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" title="{{ __('Close') }}">&times;</button>
                                                <div class="delete-icon"></div>
                                            </div>
                                            <div class="modal-body text-center">
                                                <h4 class="modal-heading">{{__('Are You Sure ?')}}</h4>
                                                <p>{{__('Do you really want to delete selected item ? This process
                                                    cannot be undone.')}}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form id="bulk_delete_form" method="post"
                                                    action="{{ route('instructor.revenue.bulk_delete') }}">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="reset" class="btn btn-gray translate-y-3"
                                                        data-dismiss="modal">{{__('No')}}</button>
                                                    <button type="submit" class="btn btn-danger">{{__('Yes')}}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </td>
                              <td>{{ $rev->courses->title }}</td>
                              <td>{{ $rev->courses->user->fname }}</td>
                              <td>
                              @if($gsetting['currency_swipe'] == 1)
                                  <i class="fa {{ $rev['currency_icon'] }}"></i> {{ $rev->total_amount }} 
                              @else
                                  {{ $rev->total_amount }} <i class="fa {{ $rev['currency_icon'] }}"></i>
                              @endif
                              </td>
                              <td>
                              @if($gsetting['currency_swipe'] == 1)
                                  <i class="fa {{ $rev['currency_icon'] }}"></i> {{ $rev->instructor_revenue }}
                              @else
                                  {{ $rev->instructor_revenue }} <i class="fa {{ $rev['currency_icon'] }}"></i>
                              @endif
                              </td>
                              <td>{{  date('d-m-Y', strtotime($rev->created_at)) }}</td>

                            </tr> 
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
    <br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain javacsript start -->
@section('script')
<script>
    $("#checkboxAll").on('click', function () {
$('input.check').not(this).prop('checked', this.checked);
});
</script>
@endsection
<!-- This section will contain javacsript end -->