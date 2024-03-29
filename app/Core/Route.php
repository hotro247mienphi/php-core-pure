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
        $instance = self::getInstance();
        try {
            $instance->map($method, $path, $controller . '#' . $action, $name);
        } catch (\Exception $exception) {
            $contentLog = sprintf('Router [%s %s %s#%s] map failure', $method, $path, $controller, $action);
            write_log($contentLog, ERROR_FILE);
        }
    }

    /**
     * @param string $name
     * @param array $param
     * @return string
     */
    public static function generate($name = '', $param = [])
    {
        try {
            return self::$altRoute->generate($name, $param);
        } catch (\Exception $exception) {
            $contentLog = sprintf('Router [%s] not found', $name);
            write_log($contentLog, ERROR_FILE);
        }
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