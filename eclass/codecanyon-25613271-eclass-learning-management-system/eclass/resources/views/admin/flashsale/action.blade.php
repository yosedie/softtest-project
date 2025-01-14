<div class="dropdown">
	<button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings') }}"><i class="feather icon-more-vertical-"></i></button>
	<div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
	
		<a  title="Edit" class="dropdown-item" href="{{route("flash-sales.edit",$id)}}" title="{{ __('Edit') }}"><i class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
	
		
		<a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#deal_{{ $id }}" title="{{ __('Delete') }}">
			<i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
		</a>
	</div>
</div>

<div id="deal_{{$id}}" class="delete-modal modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" title="{{ __('Close') }}">&times;</button>
          <div class="delete-icon"></div>
        </div>
        <div class="modal-body text-center">
          <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
          <p>{{ __('Do you really want to delete this deal? This process cannot be undone') }}.</p>
        </div>
        <div class="modal-footer">
  
          <form method="post" action="{{ route("flash-sales.destroy",$id) }}" class="pull-right">
            {{csrf_field()}}
            {{method_field("DELETE")}}
  
            <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __('No') }}</button>
            <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
          </form>
        </div>
      </div>
    </div>
  </div>