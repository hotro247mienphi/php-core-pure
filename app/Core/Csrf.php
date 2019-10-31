<?php

namespace App\Core;

/**
 * Class Csrf
 * @package App\Core
 */
class Csrf
{
    /**
     * generate
     */
    public static function generate()
    {
        $csrf = password_hash(time(), PASSWORD_DEFAULT);
        $_SESSION['_csrf'] = $csrf;
    }

    /**
     * @param string $input
     * @return bool
     */
    public static function verify($input = '')
    {
        return $input === self::get();
    }

    /**
     * @return mixed|null
     */
    public static function get()
    {
        return arr_get($_SESSION, '_csrf');
    }
}