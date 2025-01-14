@component('mail::message')
# Welcome, {{$user['fname']}} !!

You are receiving this email because we received a signup request for your this mail account.


@component('mail::button', ['url' => config('app.url')])
Click Here
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
