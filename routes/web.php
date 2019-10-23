<?php
return [
    [
        'method' => 'GET',
        'path' => '/',
        'controller' => 'HomeController',
        'action' => 'index',
        'name' => 'home.index'
    ], [
        'method' => 'GET',
        'path' => '/info/[i:id]',
        'controller' => 'HomeController',
        'action' => 'info',
        'name' => 'home.info'
    ], [
        'method' => 'GET',
        'path' => '/view/[i:categoryId]/[i:postId]',
        'controller' => 'PostController',
        'action' => 'view',
        'name' => 'post.view'
    ],
];