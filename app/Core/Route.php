<?php

namespace App\Core;

class Route
{

    /** @var \AltoRouter $altRoute */
    protected static $altRoute;

    /** @var array $_routerMatch */
    protected static $_routerMatch;

    /**
     * @param array $routes
     * @throws \Exception
     */
    public static function load(array $routes)
    {
        self::$altRoute = new \AltoRouter();
        foreach ($routes as $router):
            self::$altRoute->map(
                $router['method'],
                $router['path'],
                $router['controller'] . '#' . $router['action'],
                $router['name']
            );
        endforeach;

        self::$_routerMatch = self::$altRoute->match();
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