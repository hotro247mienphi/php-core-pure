<?php

namespace App\Http\Controller;

use App\Core\Layout;

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
     */
    public function __construct()
    {
        $this->layout = new Layout();
        $this->layout->controller = $this->getControllerName();
    }

    /**
     * @param $title
     */
    public function setTitle($title)
    {
        $this->layout->title = $title;
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
     * @param $data
     * @return false|string
     */
    protected function json($data)
    {
        header('Content-Type: application/json');

        return json_encode($data);
    }

    /**
     * @return string|string[]|null
     */
    protected function getControllerName()
    {
        $section = explode(DIRECTORY_SEPARATOR, get_class($this));
        return preg_replace('/^(.*)Controller$/', '${1}', end($section));
    }

}