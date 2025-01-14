<form action="{{ route('user.quick',$id) }}" method="POST">
    {{ csrf_field() }}
    <label class="switch">
        <input class="user" type="checkbox" data-id="{{$id}}"
            name="status" {{ $status == '1' ? 'checked' : '' }}>
        <span class="knob"></span>
    </label>
</form>