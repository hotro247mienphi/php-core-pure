<?php

namespace App\Http\Controller\Api;

use App\Http\Controller\Controller;
use App\Service\Api\UserService;

class UserController extends Controller
{
    public function index()
    {
        $userService = new UserService();
        $shared = $userService->dataIndexAction();

        return $this->json($shared);
    }
}