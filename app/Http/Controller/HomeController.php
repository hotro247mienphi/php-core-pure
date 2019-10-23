<?php

namespace App\Http\Controller;

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

        $shared = $homeService->dataIndexAction();

        return $this->render('home.index', $shared);
    }

    /**
     * @param $id
     * @return false|string
     */
    public function info($id)
    {
        $this->setTitle('Info page');

        return $this->render('home.info', ['id' => $id]);
    }

}