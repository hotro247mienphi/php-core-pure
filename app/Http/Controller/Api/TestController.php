<?php

namespace App\Http\Controller\Api;

use App\Http\Controller\Controller;
use App\Service\UserService;

class TestController extends Controller
{
    public function index()
    {
        $userService = new UserService();
        $shared = $userService->indexAction();

        return $this->json($shared);
    }
}