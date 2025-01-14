<div class="form-group{{ $errors->has('css') ? ' has-error' : '' }}">
    <form action="{{ route('css.store') }}" method="POST">
      {{ csrf_field() }}
        <label class="text-dark" for="css">{{ __('Custom CSS') }} :</label>
        <small class="text-danger">{{ $errors->first('css','CSS Cannot be blank !') }}</small>
        <textarea class="form-control" name="css" id="inputTextarea" rows="3" placeholder="a {
          color:red;
        }">{{ $css }}</textarea>
    	<br>
      <div class="form-group">
        <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
        <button type="submit" class="btn btn-primary-rgba" title="{{ __('Save')}}"><i class="fa fa-check-circle"></i>
        {{ __("Save")}}</button>
      </div>
    </form>
</div>
<br>
<div class="form-group{{ $errors->has('js') ? ' has-error' : '' }}">
    <form action="{{ route('js.store') }}" method="POST">
      {{ csrf_field() }}
        <label class="text-dark" for="js">{{ __('Custom JS') }} :</label>
        <small class="text-danger">{{ $errors->first('js','Javascript Cannot be blank !') }}</small>
        <textarea class="form-control" name="js" id="inputTextarea" rows="3" placeholder="$(document).ready(function{
          //code
        });">{{ $js }}</textarea>
    	<br>
     
        <div class="form-group">
          <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset')}}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
          <button type="submit" class="btn btn-primary-rgba" title="{{ __('Save')}}"><i class="fa fa-check-circle"></i>
          {{ __("Save")}}</button>
        </div>
    </form>
</div>