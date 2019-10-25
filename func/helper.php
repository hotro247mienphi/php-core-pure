<?php

use App\Core\Route;
use App\Core\Request;

if (!function_exists('arr_get')) {
    /**
     * @param array $arr
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    function arr_get($arr = [], $key = '', $default = null)
    {
        if (array_key_exists($key, $arr) || isset($arr[$key])) {
            return $arr[$key];
        }

        return $default;
    }
}

if (!function_exists('shutdown')) {
    /**
     * function callback when shutdown
     */
    function shutdown()
    {
        $message = sprintf(
                '[%s]: IP [%s] %s [%s] Duration: %s second(s) Mode [%s]',
                date('Y-m-d H:i:s e'),
                get_client_ip(),
                get_request_method(),
                get_full_url(),
                number_format(microtime(true) - THREAD_START, 4),
                env('APP_ENV', 'UNKNOW')
            ) . PHP_EOL;

        # 3: ghi vao file
        error_log($message, 3, LOG_FILE);
    }
}

if (!function_exists('env')) {

    /**
     * @param string $key
     * @param null $def
     * @return string
     */
    function env($key = '', $def = null)
    {
        if ($value = getenv($key)) {
            return $value;
        }
        return $def;
    }
}

if (!function_exists('get_server_memory_usage')) {
    /**
     * @return int
     */
    function get_server_memory_usage()
    {
        $tmp = memory_get_usage(true);
        return $tmp - THREAD_RAM;
    }
}

if (!function_exists('get_query_string')) {
    /**
     * @return mixed
     */
    function get_query_string()
    {
        return Request::queryString();
    }
}

if (!function_exists('get_request_method')) {
    /**
     * @return string
     */
    function get_request_method()
    {
        return Request::method();
    }
}

if (!function_exists('get_client_ip')) {
    /**
     * @param string $defVal
     * @return array|false|string
     */
    function get_client_ip($defVal = '')
    {
        return Request::ip($defVal);
    }
}

if (!function_exists('get_uri')) {
    /**
     * @return string
     */
    function get_uri()
    {
        return Request::uri();
    }
}

if (!function_exists('get_uri_without_query')) {
    /**
     * @return string
     */
    function get_uri_without_query()
    {
        $uri = Request::uri();
        $arr = explode('?', $uri);
        return $arr[0];
    }
}

if (!function_exists('get_full_url')) {
    /**
     * @return string
     */
    function get_full_url()
    {
        return Request::fullUrl();
    }
}

if (!function_exists('get_hostname')) {
    /**
     * @return string
     */
    function get_hostname()
    {
        return Request::hostname();
    }
}

if (!function_exists('get_domain_url')) {
    /**
     * @return string
     */
    function get_domain_url()
    {
        return Request::domain();
    }
}

if (!function_exists('is_secure')) {
    /**
     * @return bool
     */
    function is_secure()
    {
        return Request::isSecure();
    }
}

if (!function_exists('get_protocol')) {
    /**
     * @return string
     */
    function get_protocol()
    {
        return Request::protocol();
    }
}

if (!function_exists('public_html')) {

    /**
     * @param string $path
     * @return string
     */
    function public_html($path = '')
    {
        return get_domain_url() . '/' . $path;
    }
}

if (!function_exists('asset_path')) {

    /**
     * @param string $path
     * @return string
     */
    function asset_path($path = '')
    {
        return get_domain_url() . '/assets/' . $path;
    }
}

if (!function_exists('route')) {

    /**
     * @param string $name
     * @param array $params
     * @return string
     */
    function route($name = '', $params = [])
    {
        return Route::generate($name, $params);
    }
}

if (!function_exists('write_log')) {

    /**
     * @param string $file
     * @param string $content
     */
    function write_log($file = '', $content = '')
    {
        error_log($content, 3, $file);
    }
}

if (!function_exists('is_url')) {

    /**
     * @param string $path
     * @return bool
     */
    function is_url($path = '')
    {
        return $path === get_uri_without_query();
    }
}