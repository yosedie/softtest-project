<?php

use Tzsk\Payu\Gateway\Gateway;
use Tzsk\Payu\Gateway\PayuBiz;
use Tzsk\Payu\Gateway\PayuMoney;
use Tzsk\Payu\Models\PayuTransaction;

return [
    'default' => env('PAYU_DEFAULT', 'money'),

    'gateways' => [
        'money' => new PayuMoney([
            'mode' => env('PAYU_METHOD', Gateway::TEST_MODE),
            'key' => env('PAYU_MERCHANT_KEY'),
            'salt' => env('PAYU_MERCHANT_SALT'),
            'auth' => env('PAYU_AUTH_HEADER'),
        ]),

        'biz' => new PayuBiz([
            'mode' => env('PAYU_METHOD', Gateway::TEST_MODE),
            'key' => env('PAYU_MERCHANT_KEY'),
            'salt' => env('PAYU_MERCHANT_SALT'),
        ]),
    ],

    'verify' => [
        PayuTransaction::STATUS_PENDING,
    ],
];