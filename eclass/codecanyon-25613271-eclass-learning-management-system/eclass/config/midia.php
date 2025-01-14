<?php
return [
    // DEFAULT Target directory
    'directory' => public_path().'/images',
    // For URL (e.g: http://base/media/filename.ext)
    'directory_name' => 'images',
    'url_prefix' => 'images',
    'prefix' => 'midia',
    // Multiple target directories
    'directories' => [
        // Examples:
        // ---------
        // 'home' => [
        //  'path' => storage_path('media/home'),
        //  'name' => 'media/home' // as url prefix
        // ],
        'blog' => [
            'path' => public_path().'/images/blog',
            'name' => 'blog' // as url prefix
        ],

        'course' => [
            'path' => public_path().'/images/course',
            'name' => 'course' // as url prefix
        ],

        'category' => [
            'path' => public_path().'/images/category',
            'name' => 'category' // as url prefix
        ],

        'slider' => [
            'path' => public_path().'/images/slider',
            'name' => 'slider' // as url prefix
        ],

        'logo' => [
            'path' => public_path().'/images/logo',
            'name' => 'logo' // as url prefix
        ],

        'favicon' => [
            'path' => public_path().'/images/favicon',
            'name' => 'favicon' // as url prefix
        ],

        'signature' => [
            'path' => public_path().'/images/signature',
            'name' => 'signature' // as url prefix
        ],
    ],

    // Thumbnail size will be generated
    'thumbs' => [100/*, 80, 100*/],
];