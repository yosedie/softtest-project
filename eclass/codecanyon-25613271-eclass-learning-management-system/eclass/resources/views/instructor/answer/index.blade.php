@extends('admin.layouts.master')
@section('title','All Answer')
@section('maincontent')
<?php
$data['heading'] = 'All Answer';
$data['title'] = 'Answer';
$data['title1'] = 'All Answer';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar"> 
  <div class="row">
      <div class="col-lg-12">
          <div class="card dashboard-card m-b-30">
              <div class="card-header">
                  <h5 class="box-title">{{__('All Answer')}}</h5>
                  <div>
                    <div class="widgetbar">
                        <button type="button" class="float-right btn btn-danger-rgba mr-2 " data-toggle="modal" data-target="#bulk_delete"><i
                            class="feather icon-trash mr-2"></i> {{__('Delete Selected')}}</button>
                            <a href="{{ url('/instructoranswer/create') }}"  class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-plus mr-2"></i>{{__('Add Answer')}}</a>
                
                      </div>                        
                </div>
              </div>
              <div class="card-body">
              
                  <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                          <tr>
                              <th>
                                  <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                                  value="all" />
                              <label for="checkboxAll" class="material-checkbox"></label>   # 
                              </th>
                              <th>{{ __('Answer') }}</th>
                              <th>{{ __('Question') }}</th>
                              <th>{{ __('Course') }}</th>
                              <th>{{ __('Status') }}</th>
                              <th>{{ __('Action') }}</th>
                             
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=0;?>
                            @foreach($answers as $ans)
                            <tr>
                              <?php $i++;?>
                              <td>
                                   <input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input'
                                    name='checked[]' value={{ $ans->id }} id='checkbox{{ $ans->id }}'>
                                <label for='checkbox{{ $ans->id }}' class='material-checkbox'></label>
                                <?php echo $i; ?>
                            <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
                                <div class="modal-dialog modal-sm">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <div class="delete-icon"></div>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h4 class="modal-heading">{{__('Are You Sure ?')}}</h4>
                                            <p>{{__('Do you really want to delete selected item names here? This process
                                                cannot be undone.')}}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form id="bulk_delete_form" method="post"
                                                action="{{ route('answerbulk.bulk_delete') }}">
                                                @csrf
                                                @method('POST')
                                                <button type="reset" class="btn btn-gray translate-y-3"
                                                    data-dismiss="modal">{{__('No')}}</button>
                                                <button type="submit" class="btn btn-danger">{{__('Yes')}}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div></td>
                            <td>{{ strip_tags($ans->answer)}}</td>
                            <td>{{strip_tags($ans->question->question)}}</td>
                            <td>{{$ans->courses->title}}</td> 
                          <td>

                            <label class="switch">
                                <input class="user" type="checkbox"  data-id="{{$ans->id}}" name="status" {{ $ans->status == '1' ? 'checked' : '' }}>
                                <span class="knob"></span>
                              </label>            
                          </td>
                          <td>
                            <div class="dropdown">
                                <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                    <a class="dropdown-item" href="{{url('instructoranswer/'.$ans->id)}}"><i class="feather icon-edit mr-2"></i>{{__('Edit')}}</a>
                                    <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $ans->id }}" >
                                        <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                    </a>
                                </div>
                            </div>

                            <!-- delete Modal start -->
                            <div class="modal fade bd-example-modal-sm" id="delete{{$ans->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleSmallModalLabel">{{__('Delete')}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                                <h4>{{ __('Are You Sure ?')}}</h4>
                                                <p>{{ __('Do you really want to delete')}} ? {{ __('This process cannot be undone.')}}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form method="post" action="{{url('instructoranswer/'.$ans->id)}}" class="pull-right">
                                                {{csrf_field()}}
                                                {{method_field("DELETE")}}
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
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
    @endsection
    @section('script')
    <script>
      $(function() {
        $('.custom_toggle').change(function() {
            var status = $(this).prop('checked') == true ? 1 : 0; 
          var id = $(this).data('id'); 
            $.ajax({
                type: "GET",
                dataType: "json",
                url: 'user/status',
                data: {'answerstatus': status, 'id': id},
                success: function(data){
                  console.log(id)
                }
            });
        })
      })
    </script>
  <script>
          $("#checkboxAll").on('click', function () {
      $('input.check').not(this).prop('checked', this.checked);
    });
    </script>
    @endsection            

