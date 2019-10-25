<?php

namespace App\Core;

/**
 * Class Config
 * @package App\Core
 */
class Config
{

    protected static $configs = [];

    /**
     * @param array $files
     */
    public static function load($files = [])
    {
        $data = [];
        foreach ($files as $file):
            $data = array_merge($data, require "$file");
        endforeach;
        self::$configs = $data;
    }

    /**
     * @param string $key
     * @param string $default
     * @return mixed|null
     */
    public static function get($key = '', $default = '')
    {
        return arr_get(self::$configs, $key, $default);
    }

    /**
     * @return array
     */
    public static function all()
    {
        return self::$configs;
    }

}