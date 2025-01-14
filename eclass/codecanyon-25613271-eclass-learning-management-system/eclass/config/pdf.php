<?php

return [
    'tempDir' => public_path('temp'),
    'mode'                  => '',
    'format'                => 'A4',
    'default_font_size'     => '12',
    'default_font'          => 'sans-serif',
    'margin_left'           => 10,
    'margin_right'          => 10,
    'margin_top'            => 10,
    'margin_bottom'         => 10,
    'margin_header'         => 0,
    'margin_footer'         => 0,
    'orientation'           => 'P',
    'title'                 => 'Laravel mPDF',
    'author'                => '',
    'watermark'             => '',
    'show_watermark'        => false,
    'watermark_font'        => 'sans-serif',
    'display_mode'          => 'fullpage',
    'watermark_text_alpha'  => 0.1,
    'custom_font_path'      => base_path('/resources/fonts/'),
    'custom_font_data' => [
        'XM-Yekan' => [
            'R' => 'XM Yekan.ttf',
            'I' => 'XMYekanBd.ttf',
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ],
        'XM Yagut' => [
            'R' => 'XB Yagut.ttf',
            'I' => 'XB YagutBd.ttf',
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ],
        
    ],
];