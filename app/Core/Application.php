<?php

namespace App\Core;

/**
 * Class Application
 * @package App\Core
 *
 */
class Application
{

    public function __construct()
    {
        $this->initial();
    }

    protected function initial()
    {

        Request::load();

        Config::load(require ROOT_PATH . '/config/config.php');

        Route::load(array_merge(
            require ROOT_PATH . '/routes/web.php',
            require ROOT_PATH . '/routes/api.php'
        ));

        date_default_timezone_set(Config::get('timezone', 'Asia/Ho_Chi_Minh'));
    }

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
            throw new \Error('Controller not found');
        }

        $controller = new $controller(new Layout());

        if (!method_exists($controller, $action)) {
            throw new \Error('Method not found');
        }

        echo call_user_func_array([$controller, $action], $actionParams);
    }

}