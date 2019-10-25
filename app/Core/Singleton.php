<?php


namespace App\Core;


class Singleton
{
    public static $instance;

    public static function getInstance()
    {
        if (self::$instance) {
            return self::$instance;
        }
    }

    public static function setInstance($instance)
    {
        self::$instance = $instance;
    }
}