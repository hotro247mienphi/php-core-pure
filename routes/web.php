<?php

use App\Core\Route;

Route::add('GET', '/', 'HomeController', 'index', 'home.index');

// TODO: -------------------------- ROUTES GROUP USERS  -------------------------- //
Route::add('GET', '/users', 'UserController', 'index', 'users.index');
Route::add('GET', '/users/[i:id]', 'UserController', 'show', 'users.show');
Route::add('GET', '/users/create', 'UserController', 'create', 'users.create');
Route::add('POST', '/users/store', 'UserController', 'store', 'users.store');
Route::add('GET', '/users/[i:id]/edit', 'UserController', 'edit', 'users.edit');
Route::add('PUT|PATCH', '/users/[i:id]', 'UserController', 'update', 'users.update');
Route::add('DELETE', '/users/[i:id]', 'UserController', 'delete', 'users.delete');