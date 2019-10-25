<?php

namespace App\Core;

/**
 * Class Application
 * @package App\Core
 *
 */
class Application
{

    /**
     * Application constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->initial();
    }

    /**
     * override method request
     */
    protected function overrideMethod()
    {
        $method = strtoupper(arr_get($_POST, '_method', 'GET'));

        if (in_array($method, ['HEAD', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'PATCH', 'PURGE', 'TRACE'])) {
            $_SERVER['REQUEST_METHOD'] = $method;
            $_SERVER['X-HTTP-METHOD-OVERRIDE'] = true;
            unset($_POST['_method']);
        }
    }

    /**
     * initial all seting application
     *
     * @throws \Exception
     */
    protected function initial()
    {
        $this->overrideMethod();

        Request::load();

        Config::load([
            ROOT_PATH . '/config/config.php'
        ]);

        Route::load([
            ROOT_PATH . '/routes/web.php',
            ROOT_PATH . '/routes/api.php'
        ]);

        date_default_timezone_set(Config::get('timezone', 'Asia/Ho_Chi_Minh'));
    }

    /**
     * Start application
     */
    public function run()
    {
        $actionParams = [];
        $controllerName = Config::get('errorController');
        $action = Config::get('errorAction');

        if ($match = Route::getRouteMatch()) {
            $actionParams = $match['params'];
            list($controllerName, $action) = explode('#', $match['target']);
        }

        $controller = sprintf('%s\%s', Config::get('namespaceController'), $controllerName);

        if (!class_exists($controller)) {
            throw new \Error(sprintf('Controller [%s] not found', $controllerName));
        }

        $controller = new $controller(new Layout());

        if (!method_exists($controller, $action)) {
            throw new \Error(sprintf('Method [%s] not found in controller [%s].', $action, $controllerName));
        }

        echo call_user_func_array([$controller, $action], $actionParams);
    }

}