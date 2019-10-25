<?php

return [

    ['method' => 'GET', 'path' => '/', 'controller' => 'HomeController', 'action' => 'index', 'name' => 'home.index'],

    // TODO: // ---------------------- USER GROUP  ---------------------- //

    ['method' => 'GET', 'path' => '/users', 'controller' => 'UserController', 'action' => 'index', 'name' => 'users.index'],

    ['method' => 'GET', 'path' => '/users/[i:id]', 'controller' => 'UserController', 'action' => 'show', 'name' => 'users.show'],

    ['method' => 'GET', 'path' => '/users/create', 'controller' => 'UserController', 'action' => 'create', 'name' => 'users.create'],

    ['method' => 'POST', 'path' => '/users/store', 'controller' => 'UserController', 'action' => 'store', 'name' => 'users.store'],

    ['method' => 'GET', 'path' => '/users/[i:id]/edit', 'controller' => 'UserController', 'action' => 'edit', 'name' => 'users.edit'],

    ['method' => 'PUT|PATCH', 'path' => '/users/[i:id]', 'controller' => 'UserController', 'action' => 'update', 'name' => 'users.update'],

    ['method' => 'DELETE', 'path' => '/users/[i:id]', 'controller' => 'UserController', 'action' => 'delete', 'name' => 'users.delete'],

    // TODO: // ---------------------- OTHER GROUP  ---------------------- //

    ['method' => 'GET', 'path' => '/items', 'controller' => 'ItemController', 'action' => 'index', 'name' => 'items.index'],

    ['method' => 'GET', 'path' => '/items/[i:id]', 'controller' => 'ItemController', 'action' => 'show', 'name' => 'items.show'],

    ['method' => 'GET', 'path' => '/items/create', 'controller' => 'ItemController', 'action' => 'create', 'name' => 'items.create'],

    ['method' => 'POST', 'path' => '/items/store', 'controller' => 'ItemController', 'action' => 'store', 'name' => 'items.store'],

    ['method' => 'GET', 'path' => '/items/[i:id]/edit', 'controller' => 'ItemController', 'action' => 'edit', 'name' => 'items.edit'],

    ['method' => 'PUT|PATCH', 'path' => '/items/[i:id]', 'controller' => 'ItemController', 'action' => 'update', 'name' => 'items.update'],

    ['method' => 'DELETE', 'path' => '/items/[i:id]', 'controller' => 'ItemController', 'action' => 'delete', 'name' => 'items.delete'],

];