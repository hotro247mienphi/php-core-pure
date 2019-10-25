<?php

namespace App\Core;

/**
 * Class Route
 * @package App\Core
 */
class Route
{

    /** @var \AltoRouter $altRoute */
    protected static $altRoute;

    /** @var array $_routerMatch */
    protected static $_routerMatch;

    /**
     * @return \AltoRouter
     */
    public static function getInstance()
    {
        if (self::$altRoute instanceof \AltoRouter) {
            return self::$altRoute;
        }

        self::$altRoute = new \AltoRouter();

        return self::$altRoute;
    }

    /**
     * @param array $routes
     * @throws \Exception
     */
    public static function load(array $routes)
    {
        foreach ($routes as $router):
            include "$router";
        endforeach;

        $instance = self::getInstance();

        self::$_routerMatch = $instance->match();
    }

    /**
     * @param $method
     * @param $path
     * @param $controller
     * @param $action
     * @param $name
     */
    public static function add($method, $path, $controller, $action, $name)
    {
        try {
            $instance = self::getInstance();

            $instance->map($method, $path, $controller . '#' . $action, $name);

        } catch (\Exception $exception) {
            error_log(sprintf('Router [%s %s %s#%s] map failure', $method, $path, $controller, $action), 3, ERROR_FILE);
        }
    }

    /**
     * @param string $name
     * @param array $param
     * @return string
     * @throws \Exception
     */
    public static function generate($name = '', $param = [])
    {
        return self::$altRoute->generate($name, $param);
    }

    /**
     * @return array
     */
    public static function getRoute()
    {
        return self::$altRoute->getRoutes();
    }

    /**
     * @return array|bool
     */
    public static function getRouteMatch()
    {
        return self::$altRoute->match();
    }
}