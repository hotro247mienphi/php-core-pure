<?php

namespace App\Http\Controller;

use App\Console\DemoCommand;
use App\Core\CommandInline;
use App\Service\HomeService;

/**
 * Class HomeController
 * @package App\Http\Controller
 */
class HomeController extends Controller
{

    /**
     * @return false|string
     */
    public function index()
    {
        $this->setTitle('Home index');

        $homeService = new HomeService();

        $shared = $homeService->indexAction();

        // CommandInline::run(DemoCommand::class);

        return $this->render('home.index', $shared);
    }

}