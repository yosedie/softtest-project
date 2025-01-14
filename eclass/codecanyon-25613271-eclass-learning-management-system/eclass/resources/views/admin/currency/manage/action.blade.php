<!-- This will show you edit and delete action -->
<div class="dropdown">
    <button type="button" class="btn btn-rounded btn-danger-rgba btn-sm" data-toggle="modal" data-target="#deleteModal{{$id}}" title="{{ __('Delete') }}">{{ __('Delete') }} </button>
   
    
    <!-- Modal -->
    <div id="deleteModal{{$id}}" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                        data-dismiss="modal" title="{{ __('Close') }}">&times;</button>
                    <div class="delete-icon"></div>
                </div>
                <div class="modal-body text-center">
                    <h4 class="modal-heading">{{ __('Are You Sure ?')}}</h4>
                    <p>{{ __('Do you really want to delete this currency? This process cannot be undone.')}}</p>
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{route('currency.destroy',$code)}}">
                        @csrf
                        @method("DELETE")
                        <button type="reset" class="btn btn-gray-rgba translate-y-3" data-dismiss="modal">{{ __('No')}}</button>
                        <button type="submit" class="btn btn-danger-rgba">{{ __('Yes')}}</button>
                    </form>
                </div>
            </div>
            <!-- Modal Content ended -->
        </div>
    </div>
    <!-- Model ended -->
</div>