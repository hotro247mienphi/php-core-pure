<?php

namespace App\Core;

/**
 * Class Application
 * @package App\Core
 *
 * @property array $_routes
 * @property array $_routerMatch
 * @property string $_controller
 * @property string $_action
 * @property array $_params
 * @property array $_config
 */
class Application
{
    protected $_routes;
    protected $_routerMatch;

    protected $_controller = 'ErrorController';
    protected $_action = 'error';
    protected $_params = [];
    protected $_config;

    /**
     * @return string
     */
    public function getController()
    {
        return 'App\Http\Controller\\' . $this->_controller;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->_action;
    }

    protected function getRouter()
    {

        /** đăng ký các route cho ứng dụng */
        $altoRoute = new \AltoRouter();
        foreach ($this->_routes as $router):
            $altoRoute->map(
                $router['method'],
                $router['path'],
                $router['controller'] . '#' . $router['action'],
                $router['name']
            );
        endforeach;

        /** kiểm tra url hiện tại có khớp với 1 trong những urls đã đăng ký hay không */
        if ($match = $altoRoute->match()) {
            $this->_routerMatch = $match;
            $this->_params = $match['params'];
            list($controller, $action) = explode('#', $match['target']);
            $this->_controller = $controller;
            $this->_action = $action;
        }
    }

    /**
     * initial
     */
    protected function initial(){
        $this->_routes = array_merge(
            require ROOT_PATH . '/routes/web.php',
            require ROOT_PATH . '/routes/api.php'
        );
        $this->_config = require ROOT_PATH . '/config/config.php';
    }

    /**
     * application run
     */
    public function run()
    {
        $this->initial();
        $this->getRouter();

        $controllerName = $this->getController();
        $action = $this->getAction();

        if (!class_exists($controllerName)) {
            throw new \Error('Controller not found');
        }

        $controller = new $controllerName;

        if (!method_exists($controller, $action)) {
            throw new \Error('Method not found');
        }

        echo call_user_func_array([$controller, $action], $this->_params);
    }

}