<!-- This will show you edit action -->
<div class="dropdown">
    <button type="button" class="btn btn-rounded btn-success-rgba btn-sm" data-toggle="modal" data-target="#updateModal{{$id}}" title="{{ __('Update') }}">{{ __('Update') }} </button>
   <!-- Modal -->
    <div id="updateModal{{$id}}" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-white">{{ __('Update Currency')}}</h5>
                    <button type="button" class="close"
                        data-dismiss="modal" title="{{ __('Close') }}">&times;</button>
                    <div class="delete-icon"></div>
                </div>
                <div class="modal-body text-center">
                    <h4 class="modal-heading">{{ __('Update Currency')}}</h4>
                    <p>{{ __('It will also update currency rates & currency symbol')}}</p>
                
                
                    <form method="POST" action="{{route('currency.update',$code)}}">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group">
		                    <label for="exampleInputDetails">{{ __('Set Default') }}:</label><br>
		                    <label class="switch">
		                      <input class="slider" type="checkbox" name="default" {{ $default == '1' ? 'checked' : '' }}  />
		                      <span class="knob"></span>
		                    </label>
		              	</div>
                          <div class="form-group">
                            <label class="text-dark">{{__("Currency Position:")}} <span class="text-danger">*</span></label>
                            <br>
                            <select name="position" id="position" class="form-control">
                                <option value="">{{ __("Please select currency position") }}</option>
                                <option {{ $position== 'l' ? "selected" : "" }} value="l">{{ __("Left side currency icon") }}</option>
                                <option {{ $position == 'r' ? "selected" : "" }} value="r">{{ __("Right side currency icon") }}</option>
                            </select>
                          </div>
		              	<div class="modal-footer">
                        	<button type="reset" class="btn btn-danger-rgba translate-y-3" data-dismiss="modal">{{ __('No')}}</button>
                        	<button type="submit" class="btn btn-primary-rgba">{{ __('Yes')}}</button>
                        </div>
                    </form>
                </div>
                
            </div>
            <!-- Modal Content ended -->
        </div>
    </div>
    <!-- Model ended -->
</div>