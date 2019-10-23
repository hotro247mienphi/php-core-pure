<?php

namespace App\Http\Controller;


/**
 * Class HomeController
 * @package App\Http\Controller
 */
class ErrorController extends Controller
{

    /**
     * @return false|string
     */
    public function error()
    {
        $this->setTitle('Error - Page Not Found');

        return $this->render('error.404');
    }
}