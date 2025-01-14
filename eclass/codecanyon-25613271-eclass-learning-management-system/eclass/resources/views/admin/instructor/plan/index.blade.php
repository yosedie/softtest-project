@extends('admin.layouts.master')
@section('title', 'Instructor Plan - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Instructors Plan';
$data['title'] = 'Instructors Plan';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
            <h5 class="box-title">{{ __('Instructors Plan')}}</h5>
            <div>
              <div class="widgetbar">
                @can('instructor-plan-subscription.create')
                <a href="{{url('subscription/plan/create')}}" class="btn btn-primary-rgba" title="{{ __('Add Instructors Plan')}}"><i class="feather icon-plus mr-2"></i>{{ __('Add Instructors Plan')}}</a>
                @endcan
              </div>
            </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>{{ __('Image') }}</th>
                  <th>{{ __('Plan Name') }}</th>
                  <th>{{ __('Status') }}</th>
                  <th>{{ __('Action') }}</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=0;?>
                 
                    @foreach($plans as $plan)
                      <?php $i++;?>
                      <tr>
                        <td><?php echo $i;?></td>
                        <td class="plan-img">
                          @if($plan['preview_image'] !== NULL && $plan['preview_image'] !== '')
                              <img src="{{ asset('images/plan/'.$plan['preview_image']) }}" class="img-responsive" >
                          @else
                              <img src="{{ Avatar::create($plan->title)->toBase64() }}" class="img-responsive" >
                          @endif
                        </td>
                        <td>{{$plan->title}}</td>   
                        <td>
                              @if($plan->status ==1)
                                {{ __('Active') }}
                              @else
                                {{ __('Deactive') }}
                              @endif
                        </td>
                        <td>
                          <div class="dropdown">
                              <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings') }}"><i class="feather icon-more-vertical-"></i></button>
                              <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                @can('instructor-plan-subscription.edit')
                                  <a class="dropdown-item" href="{{url('subscription/plan/'.$plan->id. '/edit')}}" title="{{ __('Edit') }}"><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
                                  @endcan
                                  @can('instructor-plan-subscription.delete')

                                  <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-sm" title="{{ __('Delete') }}"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
                                  @endcan
                                
                              </div>
                          </div>
                        </td>


                        <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                    </div>
                                    <div class="modal-footer">
                                      <form  method="post" action="{{url('subscription/plan/'.$plan->id)}}
                                        "data-parsley-validate class="form-horizontal form-label-left">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("No")}}</button>
                                        <button type="submit" class="btn btn-danger">{{ __("Yes")}}</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>                       
                      </tr>
                    @endforeach
                  
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>


</div>

@endsection
