@extends('admin.layouts.master')
@section('title','Quiz Report View')
@section('maincontent')
<?php
$data['heading'] = 'Quiz Reports';
$data['title'] = 'Reports';
$data['title1'] = 'Quiz Reports';
$data['title1'] = 'Quiz Report View';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar"> 
  <div class="row">
    <div class="col-lg-12">
          <div class="card dashboard-card m-b-30">
              <div class="card-header">
                  <h5 class="card-title">{{ __('Quiz Report View') }}</h5>
                  <div>
                        <div class="widgetbar">
                            <a href="{{url('show/quiz/report')}}" class="btn btn-primary-rgba" title="{{ __('Back') }}"><i
                                    class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                        </div>
                    </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>{{ __('User') }}</th>
                              <th>{{ __('Email') }}</th>          
                              <th>{{ __('Quiz') }} </th>
                              <th>{{ __('Marks Get') }}</th>
                              <th>{{ __('Total Marks') }}</th>
                              </tr>
                          </thead>
                          <tbody>
                           @foreach($quiz as $q)
                            @php
                            
                            $course = App\Course::where('id',$q['course_id'])->first();
                            $user = App\User::where('email',$q['useremail'])->first();
                            $ans = App\QuizAnswer::where('topic_id',$q['topicid'])->where('user_id',$user->id)->get();
                            
                            if(isset($course)){
                                if(Auth::user()->role == "instructor")
                              {
                                $check = $course->user_id == Auth::user()->id;
                              }
                              else{
                                $check = $ans;

                              }
                            }
                            
                            
                            @endphp
                           
                            @if(isset($check))
                           
                             <tr>
                              <td>{{ $q['fname'] }} {{$q['lname']}}</td>
                              <td>{{ $q['useremail'] }}</td>
                              <td>{{ $q['topictitle'] }}</td>
                              <td>
                                @php
                                $mark=0;
                                $correct = collect();
                                  foreach($ans as $answer){
                                    if($answer->type != 1){
                                      if($answer->user_answer == $answer->answer){
                                        $mark++;
                                      }
                                    }else{
                                      if($answer->txt_approved == 1){
                                        $mark++;
                                      }
                                    }
                                  }
                                  $correct = $mark*$q['per_q_mark'];
                                @endphp
                                {{$correct}}
                              </td>
                              <td>{{ $q['quizquestion_count'] * $q['per_q_mark'] }}</td>
                              </tr> 

                             @endif 
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

