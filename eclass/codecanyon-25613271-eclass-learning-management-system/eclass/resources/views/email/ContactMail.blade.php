@component('mail::message')
# Receive user message
{{ $contact->fname }}, {{ $contact->email }} !!
<br>
mobile: {{ $contact->mobile }}
<br>
Sends you message.
<br>
{{ $contact->message }} 
Thanks,<br>
{{ config('app.name') }}
@endcomponent
