@extends('admin.layouts.master')
@section('title','Edit QuestionAnswer')
@section('maincontent')
<?php
$data['heading'] = 'Edit QuestionAnswer';
$data['title'] = 'Edit QuestionAnswer';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
 <div class="row">
    <div class="col-lg-12">
     <div class="card dashboard-card m-b-30">
      <div class="card-header">
          <h5 class="card-box">{{__('All Answers')}}</h5>
          <div>
            @can('answer.create')
            <a data-toggle="modal" data-target="#myModalanswer" class="float-right btn btn-primary-rgba"> <i class="feather icon-plus mr-2"></i>{{__('Add Answers')}}</a>
            @endcan
          </div>
        </div>
      <div class="card-body">

      <div class="table-responsive">
        <table id="datatable-buttons" class="table table-striped table-bordered">

          <thead>
          
            <th>#</th>
            <th>{{ __('Question') }}</th>
            <th>{{ __('Answer') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Action') }}</th>
          </tr>
          </thead>
          <tbody>
          <?php $i=0;?>
          @foreach($answers as $ans)
          <tr>
          	<?php $i++;?>
          	<td><?php echo $i;?></td>
            	<td>{{strip_tags($ans->question['question'])}}</td>
            	<td>{{strip_tags($ans->answer)}}</td> 
            <td>
                @if($ans->status==1)
                  {{ __('Active') }}
                @else
                  {{ __('Deactivate') }}
                @endif	                    
            </td>
            <td>
               <div class="dropdown">
                <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                    class="feather icon-more-vertical-"></i></button>
                <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                  @can('answer.edit')
                  <a class="dropdown-item" href="{{route('courseanswer.edit',$ans->id)}}"><i class="feather icon-edit mr-2"></i>{{__('Edit')}}</a>
                  @endcan
                  @can('answer.delete')

                  <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{$ans->id}}">
                    <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                  </a>
                  @endcan
                </div>
              </div>
            </td>

            <div class="modal fade bd-example-modal-sm" id="delete{{$ans->id}}" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleSmallModalLabel">{{__('Delete')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p class="text-muted">{{__('Do you really want to delete this Bundle ? This process cannot be
                      undone.')}}</p>
                  </div>
                  <div class="modal-footer">
                    <form method="post" action="{{url('courseanswer/'.$ans->id)}}" data-parsley-validate
                      class="form-horizontal form-label-left">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}

                      <button type="reset" class="btn btn-gray translate-y-3"
                        data-dismiss="modal">{{ __('No') }}</button>
                      <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            
            
          </tr>
          @endforeach
          
          </tbody>
        </table>
      </div>

    </div>
  </div>
  


  <div class="modal fade" id="myModalanswer" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
        </div>

        <div class="box box-primary">
          <div class="panel panel-sum">
            <div class="modal-body">
              <form id="demo-form2" method="post" action="{{url('courseanswer/')}}" data-parsley-validate class="form-horizontal form-label-left">
                {{ csrf_field() }}
               
                <input type="hidden" name="instructor_id" class="form-control" value="{{ Auth::User()->id }}"  />
                <input type="hidden" name="ans_user_id" value="{{Auth::user()->id}}" />
           
                <div class="row">
                  <div class="col-md-12">
                    <label  for="exampleInputTit1e">{{ __('SelectQuestion') }}:<sup class="redstar">*</sup></label>
                    <br>
                    <select  name="question_id" required class="form-control select2">
                      <option value="none" selected disabled hidden> 
                       {{ __('SelectanOption') }}
                      </option>
                      @foreach($questions as $ques)
                        <option value="{{ $ques->id }}">{{ $ques->question}}</option>
                      @endforeach
                    </select>
                  </div>
                  @foreach($questions as $ques)
                  <input type="hidden" name="ques_user_id"  value="{{$ques->user_id}}" />
                  <input type="hidden" name="course_id"  value="{{$ques->course_id}}" />
                  @endforeach
                </div>
                <br>

                <div class="row">
                  <div class="col-md-12">
                    <label for="exampleInput">{{ __('Answer') }}:<sup class="redstar">*</sup></label>
                    <textarea name="answer" rows="4" class="form-control" placeholder="Please Enter Your Answer"></textarea>
                  </div>
                </div>
                <br>

                <div class="col-md-12">
                    <label for="exampleInputDetails">{{ __('Status') }}:</label><br>
                    <label class="switch">
                      <input class="slider" type="checkbox" name="status" checked />
                      <span class="knob"></span>
                    </label>
                </div>
                <br>
        
                <div class="box-footer">
                  <button type="submit" value="Add Answer" class="btn btn-md col-md-3 btn-primary">+  {{ __('Save') }}</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--Model close -->  
  </div>  

  </div>
  <!-- /.row -->

  </div>
    <!-- /.col -->
</div>
@endsection