<?php


namespace App\Core;


class Route
{

    /** @var \AltoRouter $altRoute */
    protected static $altRoute;

    protected static $_routerMatch;

    public static function load($routes)
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

    public static function generate($name = '', $param = [])
    {
        return self::$altRoute->generate($name, $param);
    }

    public static function getRoute(){
        return self::$altRoute->getRoutes();
    }

    public static function getRouteMatch()
    {
        return self::$altRoute->match();
    }
}