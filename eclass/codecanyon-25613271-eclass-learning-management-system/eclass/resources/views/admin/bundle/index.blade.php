@extends('admin.layouts.master')
@section('title','All Bundle')
@section('maincontent')
<?php
$data['heading'] = 'All Bundle';
$data['title'] = 'Courses';
$data['title1'] = 'Bundle';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-box">{{ __('All Bundles') }}</h5>
          <div >
            <div class="widgetbar">
              @can('bundle-courses.delete')
              <button type="button" class="float-right btn btn-danger-rgba mr-2 " data-toggle="modal"
                data-target="#bulk_delete" title="{{ __('Delete Selected') }}"><i class="feather icon-trash mr-2"></i> {{ __('Delete Selected') }}</button>
                @endcan
                @can('bundle-courses.create')
              <a href="{{url('bundle/create')}}" class="float-right btn btn-primary-rgba mr-2" title="{{ __('Add Bundle') }}"><i
                  class="feather icon-plus mr-2"></i>{{ __('Add Bundle') }}</a>
              @endcan
            </div>
          </div>
        </div>
        <div class="card-body">

          <div class="table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th> <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" />
                    <label for="checkboxAll" class="material-checkbox"></label>#</th>
                  <th>{{ __('Image') }}</th>
                  <th>{{ __('Bundle Name') }}</th>
                  <th>{{ __('Instructor') }}</th>
                  <th>{{ __('Slug') }}</th>
                  <th>{{ __('Featured') }}</th>                  
                  <th>{{ __('Status') }}</th>
                  <th>{{ __('Subscription') }}</th>
                  <th>{{ __('Action') }}</th>
                </tr>
              </thead>

              <tbody>
                <?php $i=0;?>
                @if(Auth::User()->role == "admin")
                @foreach($course as $cat)
                <?php $i++;?>
                <tr>
                  <td> <input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input'
                      name='checked[]' value='{{ $cat->id }}' id='checkbox{{ $cat->id }}'>
                    <label for='checkbox{{ $cat->id }}' class='material-checkbox'></label>
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
                            <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                            <p>{{ __('Do you really want to delete selected item names here? This process
                                cannot be undone') }}.</p>
                          </div>
                          <div class="modal-footer">
                            <form id="bulk_delete_form" method="post" action="{{ route('bundlecourse.bulk_delete') }}">
                              @csrf
                              @method('POST')
                              <button type="reset" class="btn btn-gray translate-y-3"
                                data-dismiss="modal">{{ __('No') }}</button>
                              <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td>
                    @if($cat['preview_image'] !== NULL && $cat['preview_image'] !== '')
                    <img src="images/bundle/<?php echo $cat['preview_image'];  ?>" class="img-responsive img-circle"
                      width="150px" height="100px">
                    @else
                    <img src="{{ Avatar::create($cat->title)->toBase64() }}" class="img-responsive img-circle">
                    @endif
                  </td>
                  <td>{{$cat->title}}</td>
                  <td>{{ $cat->user['fname'] }}</td>
                  <td>{{$cat->slug}}</td>
                  <td>
                    <label class="switch">
                      <input class="featuredstatus" type="checkbox" data-id="{{$cat->id}}" name="status"
                        {{ $cat->featured == '1' ? 'checked' : '' }}>
                      <span class="knob"></span>
                    </label>
                  </td>                  
                  <td>
                    <label class="switch">
                      <input class="bundlestatus" type="checkbox" data-id="{{$cat->id}}" name="status"
                        {{ $cat->status == '1' ? 'checked' : '' }}>
                      <span class="knob"></span>
                    </label>

                  </td>

                  {{-- <td>
                    <label class="switch">
                      <input class="subscriptionstatus" type="checkbox" data-id="{{$cat->id}}" name="status"
                        {{ $cat->is_subscription_enabled== '1' ? 'checked' : '' }}>
                      <span class="knob"></span>
                    </label>
                  </td> --}}

                  <td>

                    <div class="btn btn-rounded pointer-remove {{ $cat->is_subscription_enabled== '1' ? 'btn-success-rgba' : 'btn-danger-rgba' }}" >
                        @if( $cat->is_subscription_enabled== '1')
                          {{ __('Active') }}
                          @else
                          {{ __('Deactivate') }}
                          @endif 
                    </div>
                    
                  </td>

                  <td>
                    <div class="dropdown">
                      <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings') }}"><i
                          class="feather icon-more-vertical-"></i></button>
                      <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                        @can('bundle-courses.edit')

                        <a class="dropdown-item" href="{{ route('bundle.show',$cat->id) }}" title="{{ __('Edit') }}"><i
                            class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                            @endcan
                            @can('bundle-courses.delete')
                        <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $cat->id}}" title="{{ __('Delete') }}">
                          <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                        </a>
                        @endcan
                        @can('bundle-courses.view')
                        <button type="button" class="dropdown-item" data-toggle="modal"
                          data-target="#exampleStandardModal{{ $cat->id }}" title="{{ __('View') }}">
                          <i class="feather icon-eye mr-2"></i>{{__('View')}}
                        </button>
                        @endcan
                      </div>
                    </div>
                    <div class="modal fade bd-example-modal-sm" id="delete{{$cat->id}}" tabindex="-1" role="dialog"
                      aria-hidden="true">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p class="text-muted">{{ __('Do you really want to delete this Bundle ? This process cannot be
                              undone') }}.</p>
                          </div>
                          <div class="modal-footer">
                            <form method="post" action="{{url('bundle/'.$cat->id)}}" class="pull-right">
                              {{csrf_field()}}
                              {{method_field("DELETE")}}

                              <button type="reset" class="btn btn-gray translate-y-3"
                                data-dismiss="modal">{{ __('No') }}</button>
                              <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal fade" id="exampleStandardModal{{$cat->id}}" tabindex="-1" role="dialog"
                      aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleStandardModalLabel">
                              {{ $cat->title }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                              <span aria-hidden="true">&times;</span>
                            </button>
                           </div>
                          <div class="modal-body">
                            <h5>Courses Include</h5>
                            @foreach ($cat['course_id'] as $crew)
                            @php
                            $name = App\Course::where('id',$crew)->value('title');
                            @endphp
                            <span class="badge badge-success">{{ucfirst($name)}}</span>
                            @endforeach
                          </div>
                        </div>
                      </div>
                    </div>

                  </td>
                </tr>
                @endforeach
                @else

                @php
                $cors = App\Course::where('user_id', Auth::User()->id)->get();
                @endphp
                @foreach($cors as $cor)
                <?php $i++;?>
                <tr>
                  <td><?php echo $i;?></td>
                  <td>
                    @if($cor['preview_image'] !== NULL && $cor['preview_image'] !== '')
                    <img src="images/course/<?php echo $cor['preview_image'];  ?>" class="img-responsive">
                    @else
                    <img src="{{ Avatar::create($cor->title)->toBase64() }}" class="img-responsive">
                    @endif
                  </td>
                  <td>{{$cor->title}}</td>
                  <td>{{ $cor->user['fname'] }}</td>
                  <td>{{$cor->slug}}</td>
                  <td>

                    @if($cor->featured ==1)
                    {{ __('Yes') }}
                    @else
                    {{ __('No') }}
                    @endif

                  </td>

                  <td>

                    @if($cor->status ==1)
                    {{ __('Active') }}
                    @else
                    {{ __('Deactive') }}
                    @endif

                  </td>
                  <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('bundle.show',$cor->id) }}">
                      <i class="glyphicon glyphicon-pencil"></i></a>
                  </td>

                  <td>
                    <form method="post" action="{{url('bundle/'.$cor->id)}}
                                      " data-parsley-validate class="form-horizontal form-label-left">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <button onclick="return confirm('Are you sure you want to delete?')" type="submit"
                        class="btn btn-danger"><i class="fa fa-fw fa-trash-o"></i></button>
                    </form>
                  </td>
                </tr>
                @endforeach
                @endif
              </tbody>
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
@section('script')
<script>
  $(document).on("change", ".bundlestatus", function () {


    $.ajax({
      type: "GET",
      dataType: "json",
      url: 'bundlecourse/status',
      data: {
        'status': $(this).is(':checked') ? 1 : 0,
        'id': $(this).data('id')
      },
      success: function (data) {
        console.log(id)
      }
    });

  });


  $(document).on("change", ".subscriptionstatus", function () {

    $.ajax({
      type: "GET",
      dataType: "json",
      url: 'bundlecourse/subscription/status',
      data: {
        'is_subscription_enabled': $(this).is(':checked') ? 1 : 0,
        'id': $(this).data('id')
      },
      success: function (data) {
        console.log(id)
      }
    });

  });



  $(document).on("change", ".featuredstatus", function () {

    $.ajax({
      type: "GET",
      dataType: "json",
      url: 'bundlecourse/featured/status',
      data: {
        'featured': $(this).is(':checked') ? 1 : 0,
        'id': $(this).data('id')
      },
      success: function(data){
            var warning = new PNotify( {
                title: 'success', text:'Status Update Successfully', type: 'success', desktop: {
                desktop: true, icon: 'feather icon-thumbs-down'
                }
              });
              warning.get().click(function() {
                warning.remove();
              });
          }
    });

  });
</script>
@endsection