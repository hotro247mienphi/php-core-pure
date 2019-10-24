<?php

namespace App\Core;

class Config
{

    protected static $configs = [];

    public static function load($data = [])
    {
        self::$configs = $data;
    }

    public static function get($key = '', $default = '')
    {
        return arr_get(self::$configs, $key, $default);
    }

    public static function all()
    {
        return self::$configs;
    }

}