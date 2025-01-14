<?php
/**
 * LaraSkrill Configuration
 * Author: Md. Obydullah <obydul@makpie.com>.
 * Author URL: https://obydul.me
 */

return [
    'merchant_email' => env('SKRILL_MERCHANT_EMAIL'),
    'api_password' => env('SKRILL_API_PASSWORD'), // required for refund option only.
    'return_url' => config('app.url').'/payviaskrill/success',
    'cancel_url' =>'/',
    'status_url' => '', // url or email
    'status_url2' => '', // url or email (you can keep this blank)
    'refund_status_url' => '', // url or email (only for refund, you can keep this blank)
    'logo_url' => env('SKRILL_LOGO_URL'),
];
