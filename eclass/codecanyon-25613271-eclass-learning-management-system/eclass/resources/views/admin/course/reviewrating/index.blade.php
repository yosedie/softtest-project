<div class="row">
      
  <div class="col-lg-12">
      <div class="card m-b-30">
          <div class="card-header">
            @can('review-rating.manage')
            <button type="button" class="btn btn-danger-rgba mr-2" data-toggle="modal" data-target="#bulk_deletereviewrating"><i
              class="feather icon-trash mr-2"></i>{{ __('Delete Selected') }}</button>
              @endcan
             
          </div>
          <div class="card-body">
          
              <div class="table-responsive">
                  <table id="" class="displaytable table table-striped table-bordered">
                      <thead>
                      <tr>

                        <th><input id="checkboxAllrerating" type="checkbox" class="filled-in" name="checked[]" value="all" />
                        <label for="checkboxAll" class="material-checkbox"></label> #
                        </th>
                        <th>{{ __('Course') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Review') }}</th>
                        <th>{{ __('Learn') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Value') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Approved') }}</th>
                        <th>{{ __('Featured') }}</th>
                        <th>{{ __('Action') }}</th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=0;?>
                      @foreach($cor->review as $jp)
                        <tr>
                          <?php $i++;?>
                        <td>
                                      
                         <input type="checkbox" form="bulk_delete_formr7" class="filled-in material-checkbox-input check" name="checked[]" value="{{$jp->id}}" id="checkbox{{$jp->id}}">
                          <label for="checkbox{{$jp->id}}" class="material-checkbox"></label> <?php echo $i; ?>
                            <div id="bulk_deletereviewrating" class="delete-modal modal fade" role="dialog">
                                <div class="modal-dialog modal-sm">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <div class="delete-icon"></div>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                                            <p>{{ __('Do you really want to delete selected item ? This process
                                                cannot be undone') }}.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form id="bulk_delete_formr7" method="post"
                                                action="{{ route('reviewrating.bulk_delete') }}">
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
                          <td>{{$jp->courses->title}}</td>
                          <td>
                          {{ $jp->user['fname'] }} {{ $jp->user['lname'] }}
                          </td>
                          <td>{{str_limit($jp->review, $limit = 50, $end = '...')}}</td>
                          <td>{{$jp->learn}}</td>
                          <td>{{$jp->price}}</td>
                          <td>{{$jp->value}}</td> 
                          <td>
                              <label class="switch">
                                <input class="slider" type="checkbox"  data-id="{{$jp->id}}" name="status" {{ $jp->status ==1 ? 'checked' : ''}} onchange="reviewratingstatus('{{$jp->id}}')" />
                                <span class="knob"></span>
                              </label>
                          </td>
                          <td>
                              <label class="switch">
                                <input class="slider" type="checkbox"  data-id="{{$jp->id}}" name="approved" {{ $jp->approved ==1 ? 'checked' : ''}} onchange="reviewratingapproved('{{$jp->id}}')" />
                                <span class="knob"></span>
                              </label>
                          </td>
                          <td>
                              <label class="switch">
                                <input class="slider" type="checkbox"  data-id="{{$jp->id}}" name="featured" {{ $jp->featured ==1 ? 'checked' : ''}} onchange="reviewratingfeatured('{{$jp->id}}')" />
                                <span class="knob"></span>
                              </label>
                          </td>
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                              <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                @can('review-rating.manage')
                                  <a class="dropdown-item" href="{{url('reviewrating/'.$jp->id)}}"><i class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                                  <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#deletereviewrating{{ $jp->id}}" >
                                      <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                  </a>
                                  @endcan
                              </div>
                          </div>
      
                          <!-- delete Modal start -->
                          <div class="modal fade bd-example-modal-sm" id="deletereviewrating{{$jp->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-sm">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                              <h4>{{ __('Are You Sure ?')}}</h4>
                                              <p>{{ __('Do you really want to delete')}} <b>{{$jp->courses->title}}</b> ? {{ __('This process cannot be undone.')}}</p>
                                      </div>
                                      <div class="modal-footer">
                                          <form method="post" action="{{url('reviewrating/'.$jp->id)}}" class="pull-right">
                                              {{csrf_field()}}
                                              {{method_field("DELETE")}}
                                              <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
                                              <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                          </div> 
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
<!-- script to change status start -->
<script>
  function reviewratingstatus(id){
    
    var status = $(this).prop('checked') == true ? 1 : 0; 
    
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('/Review-rating/status/')}}/" + id,
            data: {'status': status, 'id': id},
            success: function(data){
              console.log(id)
            }
        });
    };


    function reviewratingapproved(id){
    
    var approved = $(this).prop('checked') == true ? 1 : 0; 
    
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('/Review-rating/approved/')}}/" + id,
            data: {'approved': approved, 'id': id},
            success: function(data){
              console.log(id)
            }
        });
    };

    function reviewratingfeatured(id){
    
    var featured = $(this).prop('checked') == true ? 1 : 0; 
    
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('/Review-rating/featured/')}}/" + id,
            data: {'featured': featured, 'id': id},
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
    };
 
</script>
<script>
  $("#checkboxAllrerating").on('click', function () {
    $('input.check').not(this).prop('checked', this.checked);
});
</script>



