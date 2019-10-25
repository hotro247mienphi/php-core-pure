<?php

use App\Core\Route;

Route::add('GET', '/api/json', 'Api\TestController', 'index', 'api.json');
