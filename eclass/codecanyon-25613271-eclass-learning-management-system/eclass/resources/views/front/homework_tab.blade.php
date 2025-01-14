<!-- homework tab start--> 
<div class="tab-pane fade" id="nav-homework" role="tabpanel" aria-labelledby="nav-homework-tab">
  <div class="assignment-main-block">
     <!-- row start --> 
    <div class="row">
        <div class="col-md-12">
          <div class="accordion" id="accordionExample" class="w-100 mt-2">
            @php
            
            $homeworks = Modules\Homework\Models\Homework::where('course_id',$course->id)
                                                          ->where('status',1)->get();
            @endphp
            @forelse($homeworks as $homework)
              
              <div id="headingOne{{ filter_var($homework->id) }}" class="mb-2">
                <button class="w-100 btn btn-link text-left border" type="button" data-toggle="collapse" data-target="#collapseOne_{{ filter_var($homework->id) }}" aria-expanded="true" aria-controls="collapseOne">
                  <div class="row mt-2 mb-2 ml-2 mr-2">
                    <div class="col-md-2">
                    <h5>{{ filter_var($homework->title) }}</h5>
                    </div>
                    <!-- homework description--> 
                    <div class="col-md-3 text-justify">
                     <p>{{ filter_var($homework->description) }}</p>
                    </div>
                    <!-- homework pdf/zip file--> 
                    <div class="col-md-1 mt-2">
                      <a  href="{{route('homework.download',["id" =>$homework->id])}}" > <i class="fa fa-download"></i></a>
                    </div>
                     <!-- homework submission date-->
                    <div class="col-md-2">
                     <small>{{ filter_var($homework->endtime) }} <br> {{ __("(Submission Date)") }}</small> 
                    </div>
                    <!-- homework compulsory-->
                    <div class="col-md-1">
                      <small>{{ filter_var($homework->compulsory) ? 'Compulsory' :'' }}</small>
                      
                    </div>
                    @php
                      $current_date = Carbon\Carbon::now();
                    @endphp
                    <!-- homework  Submit button -->
                    <div class="col-md-3">
                      @php
                      $submithomework = Modules\Homework\Models\SubmitHomework::where('course_id',$course->id)
                                                        ->where('user_id',Auth::User()->id)
                                                        ->where('homework_id',$homework->id)->get();
                      @endphp
                      
                      @if($submithomework->count() < 1 )
                      @if($current_date < $homework->endtime)
                      <input  type="button" class="btn btn-danger btm-sm float-right" data-toggle="modal" data-target="#homework{{ filter_var($homework->id) }}" value="{{ __('Submit Homework')}}">
                      @else
                      <input  type="button" class="btn btn-warning rounded btm-sm float-right" value="{{ __('Submission date end')}}">
                      @endif
                       @else
                      <input  type="button" class="btn btn-warning btn-md float-right" value="{{ __('Submitted succesfully')}}">
                      @endif
                    </div>
                  </div>
                </button>
                 <!-- submithomework data show --> 
              <div id="collapseOne_{{ filter_var($homework->id) }}" class="collapse" aria-labelledby="headingOne{{ filter_var($homework->id) }}" data-parent="#accordionExample">
               
                @foreach($submithomework as  $submithomework)
                <div class="assignment-tab-block bg-white">
                      <div class="categories-block">
                        <div class="row">
                          <!-- Submit homework detail -->
                          <div class="col-md-3">
                            <p class="font-weight-bold"> {{ filter_var($submithomework->detail) }}</p> 
                          </div>
                           <!-- Submit homework pdf -->
                          <div class="col-md-1">
                            <a  href="{{route('submithomework.download',["id" =>$submithomework->id])}}" > <i class="fa fa-download"></i></a>
                          </div>
                           <!-- Submit homework marks -->
                          <div class="col-md-3">
                            <span  class="font-weight-bold"> {{ __("Marks(Out of ") }}{{ filter_var($homework->marks) }})</span>
                         <br>{{ !filter_var($submithomework->marks) ? "progress" : "$submithomework->marks"}}
                          </div>
                          <!-- Submit homework remark -->
                          <div class="col-md-3">
                            <span  class="font-weight-bold">{{ __("Remark") }}</span>
                             <br>{{ filter_var($submithomework->remark)}}
                          </div>
                        
                        </div>
                      </div>
                    </div> 
                
                @endforeach
              </div>
              </div>
              <!-- Submit Homework Model start-->
              <div class="modal fade" id="homework{{ filter_var($homework->id) }}" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="myModalLabel">{{ __('Submit Homework') }}</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="box box-primary">
                      <div class="panel panel-sum">
                        <div class="modal-body">
                            <form id="demo-form2" method="post" data-parsley-validate class="form-horizontal form-label-left"   action="{{ route('homework.submit', $course->id) }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                  <!-- user id -->
                                <input type="hidden" name="user_id"  value="{{ Auth::user()->id }}" />
                                 <!-- homework id -->
                                <input type="hidden" name="homework_id"  value="{{ filter_var($homework->id) }}" />
                                 <!-- course id -->
                                <input type="hidden" name="instructor_id"  value="{{ filter_var($course->user_id) }}" />
                                <div class="row">
                                  <div class="col-md-12">
                                    <!-- description -->
                                    <div class="form-group">
                                        <label for="title">{{ __('Description') }}:<sup class="redstar">*</sup></label>
                                        <input type="text" class="form-control" name="detail" placeholder="Please Enter Description">
                                    </div>
                                        
                                    <div class="form-group">
                                        <!-- Upload pdf/zip -->
                                        <div class="wrapper">
                                          <label for="detail">{{ __('Upload') }}:<sup class="redstar">*</sup></label> 
                                          <div class="file-upload">
                                            <input type="file" name="homework" class="form-control" />
                                            <i class="fa fa-arrow-up"></i>
                                          </div>
                                        </div>
                                    </div> 
                                  </div>
                                </div>
                                <!-- Upload Submit button -->
                                <div class="box-footer text-center">
                                <button type="submit" class="btn btn-sm btn-primary">{{ __('frontstaticword.Submit') }}</button>
                                </div>
                            </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Submit Homework Model end-->
            @empty
                <h4 class="text-center">{{ __("No homework available !") }}</h4>
            @endforelse
          </div> 
        </div>
    </div>
    <!-- row end --> 
  </div> 
</div>
<!-- homework tab  end-->