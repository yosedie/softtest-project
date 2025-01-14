<form action="" method="POST">
    @csrf
    <label for="name">{{__('Bulk Permission Name:')}}</label>
    <input type="name" name="name" placeholder="{{__('Bulk Permission Name:')}}">
    <input type="submit" value="Create">
</form>