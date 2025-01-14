@extends('admin.layouts.master')
@section('title', 'Addon Manager')
@section('maincontent')
<?php
$data['heading'] = 'Addon Manager';
$data['title'] = 'Addon Manager';
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
                    <h5 class="card-box">{{ __('Addon Manager') }}</h5>
                </div> 
                <div>
                  <div class="widgetbar">
                  <a href="{{url('admin/add/addon')}}" class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-plus mr-2"></i>{{ __('Add Addon') }}</a>
                    </div>
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
                            <th>{{ __('Addon') }}</th>
                            <th>{{ __('Version') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </thead>

                        <tbody>
                        <?php $i=0;?>
                          @foreach($modules as $module)
                            <?php $i++;?>
                            @php
                              $path = base_path().'/Modules/'.$module.'/'.'module.json'; 
                              $json = json_decode(file_get_contents($path), true);
                            @endphp
                            <tr>
                            <td>{{ $i }}</td>
                            <td>{{$json['name']}}</td>

                            <td>
                              @if(isset($json['version']))
                              {{$json['version']}}
                              @else
                              -
                              @endif
                            </td>
                            <td>
                                
                            <button type="button" class="btn btn-rounded {{ $module->isStatus(1) ? 'btn-success-rgba' : 'btn-danger-rgba' }}" data-toggle="modal" data-target="#myModal-{{$json['name']}}" title="{{ __('Status') }}">
                                @if( $module->isStatus(1))
                                  {{ __('Active') }}
                                  @else
                                  {{ __('Deactivate') }}
                                  @endif 
                            </button>


                            <div class="modal fade" id="myModal-{{$json['name']}}" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="myModal">{{ __('Verify') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}"><span
                                        aria-hidden="true">&times;</span></button>

                                  </div>
                                  <div class="modal-body">
                                      <form action="{{ route('status.addon',$module) }}" method="POST">
                                        {{ csrf_field() }}


                                        <div class="row">
                                          <div class="col-md-12">
                                            <label for="code">{{ __('Purchase Code') }}:<sup class="redstar">*</sup></label>
                                            <input placeholder="" type="text" class="form-control" name="code"
                                              required>
                                          </div>
                                        </div>
                                        <br>
                                        <button  type="Submit" class="btn btn-rounded {{ $module->isStatus(1) ? 'btn-success-rgba' : 'btn-danger-rgba' }}">
                                          @if( $module->isStatus(1))
                                          {{ __('Active') }}
                                          @else
                                          {{ __('Deactivate') }}
                                          @endif
                                        </button>
                                      </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                              
                            </td>

                                <td>
                                  @can('addon.delete')

                                    <div class="dropdown">
                                        <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings') }}"><i class="feather icon-more-vertical-"></i></button>
                                        <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                            <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{$module}}" title="{{ __('Delete') }}">
                                                <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                            </a>
                                        </div>
                                    </div>
                                    @endcan

                                    <!-- delete Modal start -->
                                    <div class="modal fade bd-example-modal-sm" id="delete{{$module}}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleSmallModalLabel">Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                        <h4>{{ __('Are You Sure ?')}}</h4>
                                                        <p>{{ __('Do you really want to delete')}} <b>{{ $json['name'] }}</b> ? {{ __('This process cannot be undone.')}}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="post" action="{{url('admin/addon/delete/'.$module)}}" class="pull-right">
                                                        {{ csrf_field() }}
                                                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{__('No')}}</button>
                                                        <button type="submit" class="btn btn-primary">{{__('Yes')}}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- delete Model ended -->

                                </td>
                                
                            </tr> 
                          @endforeach 
                          
                        </tbody>
                        </table>                  
                        <!-- table to display FAQ data end -->                
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
<!-- script to change status start -->
<script>
  $(function() {
    $('.custom_toggle').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        
        var id = $(this).data('id'); 
        
        
        $.ajax({
            type: "GET",
            dataType: "json",
            url: 'addon-status',
            data: {'status': status, 'id': id},
            success: function(data){
              console.log(id)
            }
        });
    });
  });
</script>

<!-- script to change status end -->
@endsection
<!-- This section will contain javacsript end -->