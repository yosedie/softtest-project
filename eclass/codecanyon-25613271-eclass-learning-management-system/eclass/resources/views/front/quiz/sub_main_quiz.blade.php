@extends('theme.master')
@section('title',"Start Quiz")
@section('content')
<section id="quiz-nav-bar" class="quiz-nav-bar-block">
  <div class="nav-bar">
      <div class="container-xl">
        <div class="row">
          <div class="col-md-6">
            <div class="navbar-header">
              <!-- Branding Image -->
              
              @if($topic)
                <h4 class="heading">{{$topic->title}}</h4>
              
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
              <ul class="nav navbar-nav navbar-right">
                <li></li>               
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
 <section class="quiz-main-block quiz-main-block-two">
   <div class="container-xl">

   
  

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
           
       <form action="{{route('sub.start.quiz.store',$topic->id) }}" method="POST" id="question-form">
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

                   <textarea required name="txt_answer[{{$count}}]" rows="2" class="form-control" placeholder="Enter your answer">{{ $que[0]['txt_answer'] }}</textarea>
               
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
                  {{-- <label class="radio">
                     <input type="radio" required name="answer[{{$count}}]" value="A">{{ $equestion['a'] }}
                  </label> --}}

                  <textarea required name="txt_answer[{{$count}}]" rows="2" class="form-control" placeholder="{{ __('Enter your answer')}}">{{ $equestion['txt_answer'] }}</textarea>
                 
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
                          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{ __('Image')}}</a>
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

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                          <img src="{{ asset('images/quiz/'.$equestion['question_img']) }}" class=" img-fluid" alt="{{ __('question_img')}}">
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
              <button title="{{ __('Finish the quiz')}}" type="submit" class="btn btn-md btn-primary">{{ __('Finish') }}</button>
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


@endsection
