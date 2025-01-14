@extends('admin.layouts.master')
@section('title', 'Apply Course - Instructor')
@section('maincontent')
<?php
$data['heading'] = 'Apply Course';
$data['title'] = 'Apply Course';
?>
@include('admin.layouts.topbar',$data) 
<div class="contentbar">                
    <!-- Start row -->
    <div class="row">
      <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('Apply Course')}}</h5>
                </div>
                <div class="card-body">
                 
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                              <th>#</th>
                              <th>{{ __('Image') }}</th>
                              <th>{{ __('Title') }}</th>
                              <th>{{ __('Instructor') }}</th>
                              <th>{{ __('Status') }}</th>
                             <th>{{ __('Edit') }}</th>
                           
                            </tr>
                            </thead>
                            <tbody>
                              <?php $i=0;?>
                               
                                  @foreach($involve_requests as $cat)
                                    <?php $i++;?>
                                    <tr>
                                      <td><?php echo $i;?></td>
                                      <td>
                                        @if($cat->course['preview_image'] != NULL && $cat->course['preview_image'] != '')
                                            <img src="{{ url('/images/course/'.$cat->course['preview_image']) }}" class="img-responsive img-circle" >
                                        @else
                                            <img src="{{ Avatar::create($cat->course->title)->toBase64() }}" class="img-responsive img-circle" >
                                        @endif
                                      </td>
                                      <td>{{$cat->course->title}}</td>
                                      <td>{{ $cat->user['fname'] }}</td>
                                      <td>
                                        <label class="switch">
                                          <input class="applycourse" type="checkbox"  data-id="{{$cat->id}}" name="status" {{ $cat->status == '1' ? 'checked' : '' }}>
                                          <span class="knob"></span>
                                        </label>
                                      </td>
                                      
                                     
                                      <td>
                                        <a class="btn  btn-sm" href="{{ route('course.show',$cat->course_id) }}">
                                          <i class="feather icon-edit mr-2"></i></a>
                                      </td>
            
                                      
                                    </tr>
                                  @endforeach
                             
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
  "use Strict";

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

 
  $(function() {
    $('.applycourse').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        
        var id = $(this).data('id'); 
        
        
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{url('quickupdate/coursestatus')}}",
            data: {'status': status, 'id': id},
            success: function(data){
              console.log(data)
            }
        });
    })
  })
</script>


@endsection
              
                       
                                    
                                     
                                      
                                    
                                   
                              
                               
                                
    
              
                               
                              
                
                               
                              
