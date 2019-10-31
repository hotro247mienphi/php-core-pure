<?php


namespace App\Core;


class Session
{
    protected static $_prefix = 'pure_php_';

    /**
     * @param $key
     * @return string
     */
    public static function buiKey($key)
    {
        return self::$_prefix . $key;
    }

    /**
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        $_SESSION[self::buiKey($key)] = json_encode($value);
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public static function get($key)
    {
        return json_decode(arr_get($_SESSION, self::buiKey($key)));
    }

    /**
     * clear
     */
    public static function clear()
    {
        foreach ($_SESSION as $key => $val):
            if (preg_match('#^' . self::buiKey('') . '#', $key)) {
                unset($_SESSION[$key]);
            }
        endforeach;
    }
}