@extends('theme.master')

@section('title',"Start Quiz")

@section('content')
@php
$gets = App\Breadcum::first();
@endphp
@if(isset($gets))
<section id="business-home" class="business-home-main-block">
    <div class="business-img">
        @if($gets['img'] !== NULL && $gets['img'] !== '')
        <img src="{{ url('/images/breadcum/'.$gets->img) }}" class="img-fluid" alt="{{$gets->text}}" />
        @else
        <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="{{ __('course')}}" class="img-fluid">
        @endif
    </div>
    <div class="overlay-bg"></div>
    <div class="container-xl">
        <div class="business-dtl">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bredcrumb-dtl">
  
                      @if($topic)
                      <h1 class="wishlist-home-heading">{{$topic->title}}</h1>
                      @endif 
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
 <section class="quiz-main-block quiz-main-block-two">
   <div class="container-xl">

    @if($topic->timer != NULL)
    <div class="text-center">


        <body onload="countdown();"> 
          <div style="border: none; font-size: 16px; font-weight: bold; color: black; background: transparent;"> 
              {{ __('Quiz Timer')}}
              <input id="minutes" type="text" style="width: 20px; border: none; font-size: 16px;  font-weight: bold; color: black; background: transparent;" >
                  <font size="5"> : </font> 
              
              <input id="seconds" type="text" style="width: 100px; border: none; font-size: 16px;  font-weight: bold; color: black; background: transparent;"> 

              </div>

             
          </div> 
      </body> 
    </div>
    @endif

   
  

    @if (Auth::check())
      <div class="container-xl">
        <?php 
        $users =  App\QuizAnswer::where('topic_id',$topic->id)->where('user_id',Auth::user()->id)->first();
        $que =  App\Quiz::where('topic_id',$topic->id)->get();
        $que_count =  App\Quiz::where('topic_id',$topic->id)->count();
        ?>

        @if($que->isEmpty())
        <div class="alert alert-danger">
          {{ __('No Questions in this quiz')}}
        </div>

        @else

      

         @if(!empty($users))
            <div class="alert alert-danger">
                {{ __('You have already Given the test ! Try to give other Quizes')}}
            </div>
         @else
        <div id="question_block" class="question-block">
          <div class="question"  id="question-div" >
           
       <form action="{{route('start.quiz.store',$topic->id) }}" method="POST" id="question-form">
            {{ csrf_field() }}
                <?php 
                  $count=1;
                  
                 ?>
                <div id="more_quiz0">
                 <span id="quizNumber">{{$count}}</span><span>/{{$que_count}}</span>

                 <div class="row">
                   <div class="col-lg-8">
                     <div class="jumbotron" id="quiz1" >
                  <h4 style="color:black;">Q{{$count}}.&emsp;{{ $que[0]['question'] }}</h4>
                  <input type="hidden" id="question_id[{{$count}}]" name="question_id[{{$count}}]" value="{{ $que[0]['id'] }}">
                  <input type="hidden" id="canswer[{{$count}}]" name="canswer[{{$count}}]" value="{{ $que[0]['answer'] }}">
                  @if($que[0]['data_type']=='True/False')
                  <label class="radio">
                     <input type="radio" class="q_answer" required name="answer[{{$count}}]" value="{{ $que[0]['first_option_ans'] }}">{{ $que[0]['first_option_ans'] }}
                  </label>
                  <label class="radio">
                     <input type="radio" class="q_answer" required name="answer[{{$count}}]" value="{{ $que[0]['second_option_ans'] }}">{{ $que[0]['second_option_ans'] }}
                  </label>
                  @else
                  <label class="radio">
                     <input type="radio" class="q_answer" required name="answer[{{$count}}]" value="A">{{ $que[0]['a'] }}
                  </label>
                  <label class="radio">
                     <input type="radio" class="q_answer" required name="answer[{{$count}}]" value="B">{{ $que[0]['b'] }}
                  </label>
                  <label class="radio">
                     <input type="radio" class="q_answer" required name="answer[{{$count}}]" value="C">{{ $que[0]['c'] }}
                  </label>
                  <label class="radio">
                     <input type="radio" class="q_answer" required name="answer[{{$count}}]" value="D">{{ $que[0]['d'] }}
                  </label>
                  @endif
                   <br>
                 </div> 
                     
                   </div>
                   <div class="col-lg-4">
                    
                    <div class="quiz-tabs">
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @if(isset($que[0]['question_video_link']))
                        <li class="nav-item">
                          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ __('Video')}}</a>
                        </li>
                        @endif
                         @if(isset($que[0]['question_img']))
                        <li class="nav-item">
                          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{ __('Image')}}</a>
                        </li>
                        @endif
                      </ul>
                      <div class="tab-content" id="myTabContent">

                        @if(isset($que[0]['question_video_link']))
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                          <div style="left: 0; width: 100%; height: 0; position: relative; padding-bottom: 95.25%;">
                            <iframe src="{{ $que[0]['question_video_link'].'?modestbranding=1' }}" style="border: 0; top: 0; left: 0; width: 100%; height: 100%; position: absolute;" allowfullscreen scrolling="no" allow="encrypted-media">
                            
                            </iframe>
                          </div>

                        </div>

                        @endif
                        @if(isset($que[0]['question_img']))
                        <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                          <img src="{{ asset('images/quiz/'.$que[0]['question_img']) }}" class=" img-fluid" alt="{{ __('question_img')}}">
                        </div>
                        @endif
                      </div>

                    </div>
                   </div>
                 </div>
                </div>

              @foreach($que as $key => $equestion)

              @if($key>0)
              <div style="display: none;" id="more_quiz{{ $key }}">
                <div>
               <span id="quizNumber">{{$count}}</span><span>/{{$que_count}}</span>
              </div>
               <div class="row">
                   <div class="col-lg-8">
              <div class="jumbotron" id="quiz{{ $key+1 }}" >
                  <h4 style="color:black;">Q{{$count}}.&emsp;{{ $equestion['question'] }}</h4>
                  <input type="hidden" id="question_id[{{$count}}]" name="question_id[{{$count}}]" value="{{ $equestion['id'] }}">
                  <input type="hidden" id="canswer[{{$count}}]" name="canswer[{{$count}}]" value="{{ $equestion['answer'] }}">
                  @if($equestion['data_type']=='True/False')
                  <label class="radio">
                     <input type="radio" class="q_answer" required name="answer[{{$count}}]" value="{{ $equestion['first_option_ans'] }}">{{ $equestion['first_option_ans'] }}
                  </label>
                  <label class="radio">
                     <input type="radio" class="q_answer" required name="answer[{{$count}}]" value="{{ $equestion['second_option_ans'] }}">{{ $equestion['second_option_ans'] }}
                  </label>
                  @else
                  <label class="radio">
                     <input type="radio" class="q_answer" required name="answer[{{$count}}]" value="A">{{ $equestion['a'] }}
                  </label>
                  <label class="radio">
                     <input type="radio" class="q_answer" required name="answer[{{$count}}]" value="B">{{ $equestion['b'] }}
                  </label>
                  <label class="radio">
                     <input type="radio" class="q_answer" required name="answer[{{$count}}]" value="C">{{ $equestion['c'] }}
                  </label>
                  <label class="radio">
                     <input type="radio" class="q_answer" required name="answer[{{$count}}]" value="D">{{ $equestion['d'] }}
                  </label>
                  @endif
                   <br>
                </div>
              </div>
              <div class="col-lg-4">
                 <div class="quiz-tabs">

                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @if(isset($equestion['question_video_link']))
                        <li class="nav-item">
                          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ __('Video')}}</a>
                        </li>
                        @endif

                        @if(isset($equestion['question_img']))
                        <li class="nav-item">
                          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile{{ $equestion->id }}" role="tab" aria-controls="profile" aria-selected="false">{{ __('Image')}}</a>
                        </li>

                        @endif

                      </ul>
                      <div class="tab-content" id="myTabContent">
                        @if(isset($equestion['question_video_link']))
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">


                          <div style="left: 0; width: 100%; height: 0; position: relative; padding-bottom: 95.25%;">
                            <iframe src="{{ $equestion['question_video_link'].'?modestbranding=1' }}" style="border: 0; top: 0; left: 0; width: 100%; height: 100%; position: absolute;" allowfullscreen scrolling="no" allow="encrypted-media">
                            
                            </iframe>
                          </div>

                        </div>
                        @endif


                        @if(isset($equestion['question_img']))

                        <div class="tab-pane fade" id="profile{{ $equestion->id }}" role="tabpanel" aria-labelledby="profile-tab">
                          <img src="{{ asset('images/quiz/'.$equestion['question_img']) }}" class=" img-fluid" alt="{{ __('Question_img')}}">
                        </div>

                        @endif

                     

                   </div>
                 </div>
              </div>
            </div>

                
              </div>





              @endif


              <?php $count++; ?>

                
             @endforeach
             
              <button style="display: none;" id="prev" title="{{ __('Click to see previous question')}}" class="btn btn-md btn-primary" value="1"><< {{ __('Prev') }}</button>
              @if($que_count>1)
              <button title="{{ __('Click to see next question')}}" id="next" class="pull-right btn btn-md btn-primary" value="0">{{ __('Next') }} >></button>
              @else
              <button title="Finish the quiz" type="submit" class="btn btn-md btn-primary">{{ __('Finish') }}</button>
              @endif
              
         </form>
          
     </div>
        </div>
        @endif
        
        @endif
      </div>
    @endif
  </div>
  
</section>
  <!-- jQuery 3 -->

@endsection

@section('custom-script')


  <script type="text/javascript">

    var totalques = 0;

    
    $(document).ready(function(){
        
         totalques = $('.jumbotron').length;

    });

     
    
     var i =1;

     $('#next').click(function(){

      var x = $('#next').val();
      var y = $('#prev').val();
      
      i++;

        $('#prev').show();

        x++ ;
        if(x<totalques){

          $('#more_quiz'+x).show('fast');
          var z = x-1;
          $('#more_quiz'+z).hide('fast');

          $('#next').val(x);
          $('#prev').val(x);

          if(i== totalques){
            $('#next').attr('type','submit');
            $('#next').text('Finish');
          }
          

        }else{
          
          //code
         
        }
          
          
    });

     $('#prev').click(function(){

      i--;

      var x = $('#next').val();
      var y = $('#prev').val();

      $('#next').removeAttr('type');
      $('#next').text('Next >>');


        $('#next').show();

        y--;
        
        if(y==0){
          $('#next').val(0);
          $('#prev').val(1);
          $('#prev').hide();
        }else{
          $('#next').val(y);
          $('#prev').val(y);
        }

        $('#more_quiz'+y).show('fast');
        $('#more_quiz'+x).hide();
                
          
    });


  </script>


  @if($topic->timer != NULL)

  <script> 
    //set minutes 
    var mins = {{ $topic->timer }}; 

    //calculate the seconds 
    var secs = mins * 60; 

    //countdown function is evoked when page is loaded 
    function countdown() { 
        setTimeout('Decrement()', 60); 
    } 

    //Decrement function decrement the value. 
    function Decrement() { 
    if (document.getElementById) { 
        minutes = document.getElementById("minutes"); 
        seconds = document.getElementById("seconds"); 

        //if less than a minute remaining 
        //Display only seconds value. 
        if (seconds < 59) { 
            seconds.value = secs; 
        } 

        //Display both minutes and seconds 
        //getminutes and getseconds is used to 
        //get minutes and seconds 
        else { 
            minutes.value = getminutes(); 
            seconds.value = getseconds(); 
        } 
        //if seconds becomes zero, 
        //then page alert time up 
        if (mins < 0) { 
            //alert('time up'); 

            let count = $('.q_answer:checked').length;

            if(count == 0){
              $('#question-form').hide();
              // alert('You have not attempted any question !');
              window.location.href='{{ route('course.content',['slug' => $topic->courses->slug ]) }}';
              // return false;
            }


            $('#question-form').submit();
            

            minutes.value = 0; 
            seconds.value = 0; 

            
        } 
        //if seconds > 0 then seconds is decremented 
        else { 
            secs--; 
            setTimeout('Decrement()', 1000); 
        } 
      } 
    } 

    function getminutes() { 
        //minutes is seconds divided by 60, rounded down 
        mins = Math.floor(secs / 60); 
        return mins; 
    } 

    function getseconds() { 
        //take minutes remaining (as seconds) away  
        //from total seconds remaining 
        return secs - Math.round(mins * 60); 
    } 
  </script>

@endif


@endsection