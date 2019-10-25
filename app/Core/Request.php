<?php

namespace App\Core;

/**
 * Class Request
 * @package App\Core
 *
 */
class Request
{
    /** @var ParameterBag $_get  */
    protected static $_get;
    /** @var ParameterBag $_post  */
    protected static $_post;
    /** @var ParameterBag $_request  */
    protected static $_request;

    public static function load(){
        self::$_get = new ParameterBag($_GET);
        self::$_post = new ParameterBag($_POST);
        self::$_request = new ParameterBag($_REQUEST);
    }

    protected static function _server($key = '', $default = null){
        return arr_get($_SERVER, $key, $default);
    }

    public static function referer(){
        return self::_server('HTTP_REFERER');
    }

    public static function method()
    {
        return strtoupper(self::_server('REQUEST_METHOD', 'GET'));
    }

    public static function queryString()
    {
        return self::_server('QUERY_STRING');
    }

    public static function queryStringArr()
    {
        return parse_str(self::queryString());
    }

    public static function ip($default = 'unknown')
    {
        $keys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];

        foreach ($keys as $key):
            if ($result = self::_server($key)) {
                return $result;
                break;
            }
            if ($result = getenv($key)) {
                return $result;
                break;
            }
        endforeach;

        return $default;
    }

    public static function uri()
    {
        return self::_server('REQUEST_URI');
    }

    public static function isSecure()
    {
        return strtolower(self::_server('REQUEST_URI')) === 'on';
    }

    public static function protocol()
    {
        return self::isSecure() ? 'https' : 'http';
    }

    public static function hostname()
    {
        return self::_server('HTTP_HOST');
    }

    public static function domain()
    {
        return sprintf('%s://%s', self::protocol(), self::hostname());
    }

    public static function fullUrl()
    {
        return self::domain() . (self::uri() === '/' ? '' : self::uri());
    }

    public static function get($key, $default = null)
    {
        if ($result = self::$_get->get($key, $default)) {
            return $result;
        }

        if ($result = self::$_post->get($key, $default)) {
            return $result;
        }

        if ($result = self::$_request->get($key, $default)) {
            return $result;
        }

        return $default;
    }

    public static function all()
    {
        if (self::$_get->count() && $result = self::$_get->all()) {
            return $result;
        }

        if ($result = self::$_post->all()) {
            return $result;
        }

        if ($result = self::$_request->all()) {
            return $result;
        }

        return [];
    }

}