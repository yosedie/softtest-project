@component('mail::message')
# Gift Course

{{ $x }}

{{ $order->user->fname }} {{ $order->user->lname }} Enrolled in {{ $order->courses->title }}

Email: {{ optional($order->user)->email }} <br>
Password: 123456

@component('mail::button', ['url' => route('view.order', $order_id)])
See Gift
@endcomponent

Thanks,<br>
{{ $course->user->email }} <br>
{{ config('app.name') }}
@endcomponent
