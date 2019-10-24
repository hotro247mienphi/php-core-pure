<?php

return [
    'timezone' => 'Asia/Ho_Chi_Minh',
    'errorController'=> 'ErrorController',
    'errorAction'=> 'error',
    'namespaceController'=> 'App\Http\Controller',
    'db'=> [
        'host'=> env('DB_HOST', 'localhost'),
        'user'=> env('DB_USERNAME', 'root'),
        'pass'=> env('DB_PASSWORD', ''),
        'name'=> env('DB_DATABASE', 'test'),
        'charset'=> env('DB_CHARSET', 'utf8'),
    ]
];
