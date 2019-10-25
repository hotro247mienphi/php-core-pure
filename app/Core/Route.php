<?php

namespace App\Core;

class Route
{

    /** @var \AltoRouter $altRoute */
    protected static $altRoute;

    /** @var array $_routerMatch */
    protected static $_routerMatch;

    public static function getInstance(){

        if(self::$altRoute instanceof \AltoRouter){
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
        $instance = self::getInstance();

        foreach ($routes as $router):
            $instance->map(
                $router['method'],
                $router['path'],
                $router['controller'] . '#' . $router['action'],
                $router['name']
            );
        endforeach;

        self::$_routerMatch = $instance->match();
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