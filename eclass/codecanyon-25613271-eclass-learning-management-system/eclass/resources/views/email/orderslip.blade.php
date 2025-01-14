@component('mail::message')
# Order Confirmed
Hi {{ $order->user->fname }} !!
<br>
You are successfully enrolled in a course.
<br>
You can see invoice below.



@component('mail::button', ['url' => route('invoice.show', $order_id)])
Invoice
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
