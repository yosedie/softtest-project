<form action="" method="POST">
    @csrf
    <label for="name">{{__('Permission Name:')}}</label>
    <input type="name" name="name" placeholder="{{__('permission Name')}}">
    <input type="submit" value="Create">
</form>