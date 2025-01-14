@extends('admin.layouts.master')
@section('title','All Quiz Review')
@section('maincontent')
<?php
$data['heading'] = 'Quiz Review';
$data['title'] = 'Courses';
$data['title1'] = 'Quiz Review';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar bardashboard-card"> 
  <div class="row">
    <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                  <h5 class="box-title">{{ __('All Quiz Reviews') }}</h5>
              </div>
              <div class="card-body">
              
                  <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                          <tr>
                            <th>#</th>
                  <th>{{ __('Course') }}</th>
                  <th>{{ __('User Name') }}</th>
                  <th>{{ __('Topic') }}</th>
                  <th>{{ __('Question') }}</th>
                 <th>{{ __('Answer') }}</th>
                  <th>{{ __('View') }}</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=0;?>
                @foreach($answers as $answer)
                <?php $i++;?>

                @php

                    if(Auth::user()->role == "instructor") 
                    {
                      $check = $answer->courses->user_id == Auth::user()->id;
                    }
                    else{
                      $check = $answer->courses;
                    }

                  @endphp

                 

                  @if($check)

                  <tr>
                    <td><?php echo $i;?></td>
                    <td>{{$answer->courses->title}}</td>
                    @php
                      $user = app\User::where('id',$answer->user_id)->first();
                    @endphp
                   <td>{{ $user->fname }} {{ $user->lname }}</td>
                    <td>{{$answer->topic->title ?? '-'}}</td> 
                    @isset($answer->quiz->question)
                    <td>{!!$answer->quiz->question!!}</td>
                 @endisset
                 <td>-</td>
                    <td>{!! $answer->txt_answer !!}</td>
                    <td>
                      <label class="switch">
                        <input class="review" type="checkbox"  data-id="{{$answer->id}}" name="txt_approved" {{ $answer->txt_approved == "1" ? 'checked' : ''}}>
                        <span class="knob"></span>
                      </label>
                    </td>
                  </tr>

                  @endif

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
  "use Strict";

$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

  $(function() {
    $('.review').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        
        var id = $(this).data('id');
       
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url:"{{url('quizreview/approve')}}",
            data: {'status': status, 'id': id},
            success: function(data){
              console.log(data)
            }
        });
    })
  })
</script>


@endsection