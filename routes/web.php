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
        'path' => '/view/[i:categoryId]/[i:postId]',
        'controller' => 'PostController',
        'action' => 'view',
        'name' => 'post.view'
    ], [
        'method' => 'GET',
        'path' => '/users/create',
        'controller' => 'UserController',
        'action' => 'create',
        'name' => 'users.create'
    ], [
        'method' => 'POST',
        'path' => '/users/store',
        'controller' => 'UserController',
        'action' => 'store',
        'name' => 'users.store'
    ],[
        'method' => 'GET',
        'path' => '/users/[i:id]',
        'controller' => 'UserController',
        'action' => 'edit',
        'name' => 'users.edit'
    ],[
        'method' => 'PUT',
        'path' => '/users/[i:id]',
        'controller' => 'UserController',
        'action' => 'update',
        'name' => 'users.update'
    ],
];