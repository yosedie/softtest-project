@extends('theme.master')
@section('title',"Show Report")
@section('content')
 <section class="main-wrapper finish-main-block">
   <div class="container-xl">
    <br/>
  @if ($auth)
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="">
          <div class="question-block">
           

          @if($topics->show_ans==1)
        
          <div class="question-block">
            <h3 class="text-center main-block-heading">{{ __('Answer Report') }}</h3>
            <br/>
            <div class="table-responsive">
              <table class="table table-bordered result-table">
                <thead>
                  <tr>
                    <th>{{ __('Question') }}</th> 
                    <th style="color: red;">{{ __('Your Answer') }}</th>
                    <th style="color: #48A3C6;">{{ __('Correct Answer') }}</th>
                  </tr>
                </thead>
                <tbody>
                  
                  @php
                  $x = $count_questions;               
                  $y = 1;
                  @endphp
                  @foreach($ans as $key=> $a)
                      <tr>
                        <td>{{ $a->quiz->question }}</td>
                         <td>{{ $a->user_answer }}</td>
                        <td>{{ $a->answer }}</td>
                       
                      
                      </tr>
                      @php                
                        $y++;
                        if($y > $x){                 
                          break;
                        }
                      @endphp
                   
                  @endforeach              
                 
                </tbody>
              </table>
            </div>
            
          </div>

          @endif


          <div id="printableArea">

           <h3 class="text-center main-block-heading">{{ __('score card') }} </h3>
            <br/>
            <div class="table-responsive">
              <table class="table table-bordered result-table">
                <thead>
                  <tr>
                    <th>{{ __('Total Question') }}</th>
                    <th>{{ __('Correct Questions') }}</th>
                    <th>{{ __('Per Question Mark') }}</th>
                    <th>{{ __('Total Marks') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{$count_questions}}</td>
                    <td>
                      @php
                        $mark = 0;
                        $ca=0;
                        $correct = collect();
                      @endphp
                      @foreach ($ans as $answer)
                        @if ($answer->answer == $answer->user_answer)
                        
                          @php
                            $mark++;
                            $ca++;
                          @endphp
                        @endif
                      @endforeach
                      {{$ca}}
                    </td>
                    <td>{{$topics->per_q_mark}}</td>
                      @php
                          $correct = $mark*$topics->per_q_mark;
                      @endphp
                    <td>{{$correct}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <br/>
            <h2 class="text-center">{{ __('Thank You') }}</h2>
          </div>

          

            <div class="finish-btn text-center">
              
              <input type="button" class="btn btn-primary"  onclick="printDiv('printableArea')" value="Print" />

              @if($topics->quiz_again == '1')
              <a href="{{route('tryagain',$topics->id)}}" class="btn btn-primary">{{ __('Try Again') }} </a>
              @endif
              <a href="{{ route('course.content',['slug' => $topics->courses->slug ]) }}" class="btn btn-secondary">{{ __('Back') }} </a>

              


            </div>

          </div>
        </div>
      </div>
    </div>
  @endif
</div>
</section>
<br/>
@endsection


@section('custom-script')

<script>
    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
   }
</script>
@endsection

