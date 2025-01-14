<form action="{{ route('bbl.api.join') }}" method="POST">
	@csrf
<input type="text" name="name" value="" placeholder="Enter your name">
<input type="text" value="{{ $m->meetingid }}" readonly="">
<input type="hidden" name="meetingid" value="{{ $m->meetingid }}">
<input type="password" name="password">
<input type="submit" value="Join">
</form>