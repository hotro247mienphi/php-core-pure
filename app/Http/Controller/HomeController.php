<?php

namespace App\Http\Controller;

use App\Console\DemoCommand;
use App\Core\Console;

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

        $this->setLayout('custom-layout');

        Console::run(DemoCommand::class, ['name' => 'thuannd']);

        return $this->render('home.index');
    }

}