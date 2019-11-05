<?php

namespace App\Http\Controller;

use App\Core\Layout;
use App\Core\Request;

/**
 * Class Controller
 * @package App\Http\Controller
 */
class Controller
{
    /** @var Layout $layout */
    protected $layout;

    /**
     * Controller constructor.
     * @param Layout $layout
     */
    public function __construct(Layout $layout)
    {
        $this->layout = $layout;
    }

    /**
     * @param $title
     */
    public function setTitle($title)
    {
        $this->layout->title = $title;
    }

    /**
     * @param string $layoutName
     */
    public function setLayout($layoutName = '')
    {
        $this->layout->layout = $layoutName;
    }

    /**
     * @param string $name
     * @param array $data
     * @return false|string
     */
    protected function render($name = '', $data = [])
    {
        $this->layout->setView($name);
        $this->layout->setData($data);

        return $this->layout->getLayout();
    }

    /**
     * back to url
     */
    protected function back()
    {
        redirect(Request::referer());
    }

    /**
     * @param $data
     * @return false|string
     */
    protected function json($data)
    {
        header('Content-Type: application/json');

        return json_encode($data);
    }

}