<?php

namespace App\Core;

/**
 * Class Csrf
 * @package App\Core
 */
class Csrf
{

    public static function generate()
    {
        $csrf = password_hash(time(), PASSWORD_DEFAULT);
        $_SESSION['_csrf'] = $csrf;
        return $csrf;
    }

    public static function verify($input = '')
    {
        return password_verify($input, self::get());
    }

    public static function get()
    {
        return arr_get($_SESSION, '_csrf');
    }
}