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
     * @throws \Exception
     */
    public function index()
    {
        $this->setTitle('Home index');

        $homeService = new HomeService();

        $shared = $homeService->dataIndexAction();

        dump($shared);

        return $this->render('home.index', $shared);
    }

    /**
     * @param $id
     * @return false|string
     */
    public function info($id)
    {
        $this->setTitle('Info page');

        CommandInline::run(DemoCommand::class);

        return $this->render('home.info', ['id' => $id]);
    }

}