@if($class->status == 1)
    <div class="card-body">
        <table class="table">  
            <tbody>
                <tr>
                    <td class="class-type">
                        @if($class->type =='video' && $class->video )
                          <a href="{{ route('watchcourseclass',$class->id) }}" title="Course" class="@if($z == 0)iframe @endif"><i class="fa fa-play-circle"></i>&nbsp;{{ __('class') }}</a>
                        @endif

                        @if($class->type =='video' && $class->aws_upload )
                          <a href="{{ route('watchcourseclass',$class->id) }}" title="Course" class="@if($z == 0)iframe @endif"><i class="fa fa-play-circle"></i>&nbsp;{{ __('class') }}</a>
                        @endif
                        
                        @php
                            $url = Crypt::encrypt($class->iframe_url);
                        @endphp
                        @if($class->type =='video' && $class->iframe_url )
                        <a href="{{ route('watchinframe',[$url, 'course_id' => $course->id]) }}" title="Course"><i class="fa fa-play-circle"></i>&nbsp;{{ __('class') }}</a>
                        @endif

                        @if($class->type =='audio' && $class->audio)
                        <a href="{{ route('audiocourseclass',$class->id) }}" title="class" class="@if($z == 0)iframe @endif"><i class="fa fa-play-circle"></i>&nbsp;{{ __('class') }}</a>
                        @endif
                        @if($class->type =='image' && $class->image )
                        <a href="{{ asset('images/class/'.$class->image) }}" download="{{$class->image}}" title="Course"><i class="fas fa-image"></i>&nbsp;{{ __('save') }}</a>
                        @endif
                        @if($class->type =='pdf' && $class->pdf )
                        <a href="{{route('downloadPdf',$class->id)}}" title="Course" class="iframe"><i class="fas fa-file-pdf"></i>&nbsp;{{ __('View') }}</a>

                        @endif

                        @if($class->type =='zip' && $class->zip )
                        <a href="{{ asset('files/zip/'.$class->zip) }}" download="{{$class->zip}}" title="Course"><i class="far fa-file-archive"></i>&nbsp;{{ __('save') }}</a>
                        @endif

                        @if($class->url)
                            @if($class->type =='video')
                            @if($mytime >= $class->date_time)
                            <a href="{{ route('watchcourseclass',$class->id) }}" title="Course" class="@if($z == 0)iframe @endif"><i class="fa fa-play-circle"></i>&nbsp;{{ __('class') }}</a>
                            @else
                            <a href="" title="Course"><i class="fa fa-play-circle"></i>&nbsp;{{ __('class') }}</a>
                            @endif
                            @endif
                            @if($class->type =='image' || $class->type =='pdf' || $class->type =='zip' || $class->type =='audio')
                            <a href="{{ $class->url }}" title="Course"><i class="fas fa-image"></i>&nbsp;{{ __('link') }}</a>
                            @endif
                        @endif 
                    </td>

                    <td class="class-name">

                        <div class="koh-tab-content">
                          <div class="koh-tab-content-body">
                            <div class="koh-faq">
                              <div class="koh-faq-question">

                                <span class="koh-faq-question-span"> {{ $class['title'] }} </span>

                                @if($class->date_time != NULL)
                                   <div class="live-class">{{ __('Live at')}}: {{ $class->date_time }}</div>
                                @endif
                                @if($class->detail != NULL)
                                    <i class="fa fa-sort-down" aria-hidden="true"></i>
                                @endif
                              </div>
                              <div class="koh-faq-answer">
                                {!! $class->detail !!}
                              </div>
                            </div>
                          </div>
                        </div>
                    </td>

                    <td class="class-size txt-rgt">
                        @if($class->type =='video' || $class->type =='audio')
                            {{ $class->duration }} {{ __('min') }}
                        @endif
                        @if($class->type =='image' || $class->type =='pdf' || $class->type =='zip' )
                            {{ $class->size }} Mb
                        @endif

                        @if($class->file != NULL)
                        <a href="{{ asset('files/class/material/'.$class->file) }}" download="{{$class->file}}" title="{{ __('Learning Material')}}"><i class="fa fa-download"></i></a>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endif