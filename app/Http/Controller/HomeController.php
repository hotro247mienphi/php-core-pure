<?php

namespace App\Http\Controller;

use App\Console\DemoCommand;
use App\Core\CommandInline;

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

        // CommandInline::run(DemoCommand::class);

        return $this->render('home.index');
    }

}