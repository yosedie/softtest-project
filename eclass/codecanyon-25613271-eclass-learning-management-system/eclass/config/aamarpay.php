<?php

return [
    'store_id' => env('AAMARPAY_STORE_ID',''),
    'signature_key' => env('AAMARPAY_KEY',''),
    'sandbox' => env('AAMARPAY_SANDBOX', true),
    'redirect_url' => [
        'success' => [
            'url' => 'payment/success' // payment.success
        ],
        'cancel' => [
            'url' => 'payment/cancel' // payment/cancel or you can use route also
        ],
        'failed' => [
            'url' => 'payment/failed' // payment/cancel or you can use route also
        ]
    ]
];
