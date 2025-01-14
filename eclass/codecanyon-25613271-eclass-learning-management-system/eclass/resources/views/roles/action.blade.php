<div class="dropdown">
  <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
  <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
    
    @if(!in_array($id,['1','2','3']))
      <a class="dropdown-item" href="{{ route('roles.edit',$id) }}"><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
    @else 
    <p class="dropdown-item" >
      <b class="text-danger">{{__("System reserved role")}}</b>
    </p>
  @endif
  @if(!in_array($id,['1','2','3']))
      <a class="dropdown-item" @if(env('DEMO_LOCK')==0) data-toggle="modal" data-target="#delete{{ $id }}" @else
      disabled="disabled" title="This operation is disabled in Demo !" @endif><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
    @endif
  </div>
</div>


<div id="delete{{ $id }}" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal-heading">
          {{__('Are You Sure ?')}}
        </h4>
        <p>{{__('Do you really want to delete this role')}} <b>{{ $name }}</b> ? <b> {{__("By Clicking YES IF any user attach to this role will be unroled !</b> This process cannot be undone")}}.</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="{{ route('roles.destroy',$id) }}" class="pull-right">
          {{csrf_field()}}
          {{method_field("DELETE")}}

          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">
            {{__('No')}}
          </button>
          <button type="submit" class="btn btn-danger">
            {{__('Yes')}}
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
