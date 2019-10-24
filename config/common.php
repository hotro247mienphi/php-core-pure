<?php

if (!function_exists('shutdown')) {
    /**
     * function callback when shutdown
     */
    function shutdown()
    {

        # phần thời gian sẽ được tự động thêm vào phần đầu
        $message = sprintf(
                '[%s]: IP [%s] %s [%s] Duration: %s second(s) Mode [%s]',
                date('Y-m-d H:i:s e'),
                get_client_ip(),
                get_request_method(),
                get_full_url(),
                number_format(microtime(true) - THREAD_START, 4),
                env('APP_ENV', 'UNKNOW')
            ) . PHP_EOL;

        // $pathFile = LOG_PATH . '/log-' . date('Y-m-d') . '.log';

        /*if (!file_exists($pathFile)) {
            file_put_contents($pathFile, '', FILE_APPEND);
        }*/

        if (!empty($queryString = get_query_string())) {
            $message .= var_export($queryString, true) . PHP_EOL;
        }

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
        $queryString = $_SERVER['QUERY_STRING'];
        parse_str($queryString, $params);
        return $params;
    }
}

if (!function_exists('get_request_method')) {
    /**
     * @return string
     */
    function get_request_method()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }
}

if (!function_exists('get_client_ip')) {
    /**
     * @param string $defVal
     * @return array|false|string
     */
    function get_client_ip($defVal = '')
    {
        $keys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];

        foreach ($keys as $key):
            if ($result = getenv($key)) {
                return $result;
                break;
            }
        endforeach;

        return $defVal;
    }
}

if (!function_exists('get_uri')) {
    /**
     * @return string
     */
    function get_uri()
    {
        return $_SERVER['REQUEST_URI'];
    }
}

if (!function_exists('get_full_url')) {
    /**
     * @return string
     */
    function get_full_url()
    {
        if(get_uri() !== '/'){
            return get_domain_url() . get_uri();
        }
        return get_domain_url();
    }
}

if (!function_exists('get_hostname')) {
    /**
     * @return string
     */
    function get_hostname()
    {
        return $_SERVER['HTTP_HOST'];
    }
}

if (!function_exists('get_domain_url')) {
    /**
     * @return string
     */
    function get_domain_url()
    {
        return get_protocol() . "://" . get_hostname();
    }
}

if (!function_exists('get_protocol')) {
    /**
     * @return string
     */
    function get_protocol()
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
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