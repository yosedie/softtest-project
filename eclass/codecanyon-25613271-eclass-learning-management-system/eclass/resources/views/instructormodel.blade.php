<div class="modal fade" data-backdrop="" style="z-index: 99999999999999999;" id="myModalinstructor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">{{ __('Become An Instructor') }}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="box box-primary">
        <div class="panel panel-sum">
          <div class="modal-body">
            @if(Auth::check())
            @php
              $users = App\Instructor::where('user_id', Auth::user()->id)->first();
            @endphp
            @if($users != NULL)
                <div class="alert alert-danger" role="alert">
                  {{ __('Already Request') }} 
                </div>   
                <form  method="post" action="{{url('requestinstructor/'.$users->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <div class="cancel-button" style="text-align:center">
                    <button type="submit" class="btn btn-primary"> {{ __('Cancel') }} {{ __('Request') }} </button>
                  </div>
                </form>
            @else
              <form id="demo-form2" method="post" action="{{ route('apply.instructor') }}" data-parsley-validate 
                class="form-horizontal form-label-left" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="fname">{{ __('First Name') }}:<sup class="redstar">*</sup></label>
                        <input type="text" class="form-control" name="fname" id="title" placeholder="  {{ __('Enter First Name') }}" value="{{Auth::User()->fname}}" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="lname">{{ __('Last Name') }}:<sup class="redstar">*</sup></label>
                        <input type="text" class="form-control" name="lname" id="title" placeholder="  {{ __('Enter Last Name') }}" value="{{Auth::User()->lname}}" required>
                      </div>
                    </div>
                  </div>                    
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="email">{{ __('Email') }}:<sup class="redstar">*</sup></label>
                        <input type="email" value="{{Auth::User()->email}}" class="form-control" name="email" id="title" placeholder="{{('Enter Email')}}" value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="contact">{{ __('Mobile') }}:<sup class="redstar">*</sup></label>
                        <input type="text" class="form-control" name="mobile" id="contact" placeholder="{{ __('Enter Mobile No') }}" value="" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="detail">{{ __('Details') }}:<sup class="redstar">*</sup></label>
                        <textarea name="detail" rows="5"  class="form-control" placeholder="" required></textarea>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="file">{{ __('Upload Resume') }}:<sup class="redstar">*</sup></label>
                        <input type="file" class="form-control" name="file" id="file" value="" required>
                      </div>
                       <div class="form-group">
                        <label for="image">{{ __('Upload Image') }}:<sup class="redstar">*</sup></label>
                        <input type="file" class="form-control" name="image"  id="image" required>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="box-footer">
                   <button type="submit" class="btn btn-lg col-md-3 btn-primary">{{ __('Submit') }}</button>
                  </div>
              </form>
            @endif
            @else
              <div class="box-footer">
                <button type="submit" onclick="window.location.href = '{{ route('login') }}';" class="btn btn-lg col-md-3 btn-primary">{{ __('Submit') }}</button>
              </div>
            @endif  
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
