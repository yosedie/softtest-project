@component('mail::message')
# User Enrolled

{{ $order->user->fname }} {{ $order->user->lname }} Enrolled in {{ $order->courses->title }}

@component('mail::button', ['url' => route('view.order', $order_id)])
See Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent