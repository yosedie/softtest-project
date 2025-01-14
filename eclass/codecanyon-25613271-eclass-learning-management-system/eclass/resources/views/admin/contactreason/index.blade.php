@extends('admin.layouts.master')
@section('title', 'Reasons')
@section('maincontent')
<?php
$data['heading'] = 'Reasons';
$data['title'] = 'Contact Form Messages';
$data['title1'] = 'Reasons';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
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
                    <h5 class="card-box">{{ __('All Contact Form Reasons') }}</h5>
                    <div>
                        <div class="widgetbar">
                            <a href="{{url('contactreason/create')}}" class="btn btn-primary-rgba mr-2"><i class="feather icon-plus mr-2"></i>{{ __('Add Reason') }}</a>
                            <a href="{{url('usermessage')}}" class="float-right btn btn-primary-rgba" title="{{ __('Back') }}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                      
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
                            <th>{{ __('Reason') }}</th>
                             <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </thead>
                        <tbody>
                            @foreach($contactreason as $key=>$p)
                                <tr>
                                <td>
                                     <?php echo $key+1; ?>
                                </td>
                                <td>{{ $p->reason}}</td>
                                <td>
                                        @if( $p->status == '1')
                                        <button type="button" class="btn btn-rounded btn-success-rgba" data-toggle="modal" data-target="#myModal" title="{{ __('Active') }}">
                                          {{ __('Active') }}
                                          @else
                                          <button type="button" class="btn btn-rounded btn-danger-rgba" data-toggle="modal" data-target="#myModal" title="{{ __('Deactivate') }}">
                                          {{ __('Deactivate') }}
                                          @endif 
                                    </button>
                                </td>
​
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings') }}"><i class="feather icon-more-vertical-"></i></button>
                                        <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                            <a class="dropdown-item" href="{{url('contactreason/'.$p->id.'/edit')}}" title="{{ __('Edit') }}"><i class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                                            <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $p->id }}" title="{{ __('Delete') }}">
                                                <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                            </a>
                                        </div>
                                    </div>
​
                                    <!-- delete Modal start -->
                                    <div class="modal fade bd-example-modal-sm" id="delete{{ $p->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                        <h4>{{ __('Are You Sure ?')}}</h4>
                                                        <p>{{ __('Do you really want to delete')}} <b>{{$p->title}}</b> ? {{ __('This process cannot be undone.')}}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="post" action="{{url('contactreason/'.$p->id)}}" class="pull-right">
                                                        {{csrf_field()}}
                                                        {{method_field("DELETE")}}
                                                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
                                                        <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- delete Model ended -->
​
                                </td>
                                
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

<!-- This section will contain javacsript end -->