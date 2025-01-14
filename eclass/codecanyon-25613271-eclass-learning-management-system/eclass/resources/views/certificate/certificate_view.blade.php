<div class="cirtificate-border-one text-center">
    <div class="cirtificate-border-two">
    <div class="cirtificate-heading" style=""> {{ __('Certificate of Completion') }}</div>
        @php
            $mytime = Carbon\Carbon::now();
            $courses = $course->title;
            
        @endphp
    <p class="cirtificate-detail" style="font-size:30px"> {{ __('This is to certify that') }}
            <b>&nbsp;{{ $progress->user['fname'] }}&nbsp;{{ $progress->user['lname'] }}</b>  
            {{ __('successfully completed') }} 
            <b>{{ $course['title'] }}</b> 
            {{ __('online course on') }} <br>
            <span style="font-size:25px">{{ date('jS F Y', strtotime($progress['updated_at'])) }}</span>
        </p>

    <span class="cirtificate-instructor">{{ ($course->user['fname']) }} {{ ($course->user['lname']) }}</span>
    <br>
    <span class="cirtificate-one">{{ ($course->user['fname']) }} {{ ($course->user['lname']) }}, {{ __('Instructor') }}</span>
    <br>
    <span>&</span>
        <div class="cirtificate-logo">
        @if($gsetting['logo_type'] == 'L')
            <img src="{{ asset('images/logo/'.$gsetting['logo']) }}" class="img-fluid" alt="{{ __('logo')}}">
        @else
            <a href="{{ url('/') }}"><b><div class="logotext">{{ $gsetting['project_title'] }}</div></b></a>
        @endif
        </div>
        

        <div class="cirtificate-serial">{{ __('Certificate no.')}} :{{ $serial_no }}</div>
        <div class="cirtificate-serial">{{ __('Certificate url.')}} :{{ url()->full() }}</div>
    
    </div>
</div>