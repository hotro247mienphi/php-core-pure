<?php

namespace App\Core;
/**
 * Class Request
 * @package App\Core
 *
 */
class Request
{
    protected $_get = [];
    protected $_post = [];
    protected $_request = [];

    public function __construct()
    {
        $this->_get = new ParameterBag($_GET);
        $this->_post = new ParameterBag($_POST);
        $this->_request = new ParameterBag($_REQUEST);
    }

    public function method()
    {
        return strtoupper(arr_get($_SERVER, 'REQUEST_METHOD', 'GET'));
    }

    public function queryString()
    {
        return arr_get($_SERVER, 'QUERY_STRING', '');
    }

    public function queryStringArr()
    {
        return parse_str($this->queryString());
    }

    public function ip($default = 'unknow')
    {
        $keys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];

        foreach ($keys as $key):
            if ($result = arr_get($_SERVER, $key)) {
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


    public function uri()
    {
        return arr_get($_SERVER, 'REQUEST_URI', '');
    }

    public function isSecure()
    {
        return arr_get($_SERVER, 'HTTPS') === 'on';
    }

    public function protocol()
    {
        return $this->isSecure() ? 'https' : 'http';
    }

    public function hostname()
    {
        return arr_get($_SERVER, 'HTTP_HOST', '');
    }

    public function domain()
    {
        return sprintf('%s://%s', $this->protocol(), $this->hostname());
    }

    public function fullUrl()
    {
        return $this->domain() . ($this->uri() === '/' ? '' : $this->uri());
    }

    public function get($key, $default = null)
    {
        if ($result = $this->_get->get($key, $default)) {
            return $result;
        }

        if ($result = $this->_post->get($key, $default)) {
            return $result;
        }

        if ($result = $this->_request->get($key, $default)) {
            return $result;
        }

        return $default;
    }

    public function all()
    {

        if ($result = $this->_get->all()) {
            return $result;
        }

        if ($result = $this->_post->all()) {
            return $result;
        }

        if ($result = $this->_request->all()) {
            return $result;
        }

        return [];
    }

}