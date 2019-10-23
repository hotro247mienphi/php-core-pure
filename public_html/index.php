<?php

/** (0) Định nghĩa biến CONST cơ bản và set timezone */
{
    date_default_timezone_set('Asia/Ho_Chi_Minh');

    define('ROOT_PATH', __DIR__ . './../');
    define('LOG_PATH', ROOT_PATH . '/logs');
    define('VIEWS_PATH', ROOT_PATH . '/views');
    define('PUBLIC_PATH', ROOT_PATH . '/public_html');
    define('THREAD_START', microtime(true));
    define('THREAD_RAM', memory_get_usage(true));

    $today = date('Y-m-d');
    define('ERROR_FILE', LOG_PATH . '/error-' . $today . '.log');
    define('LOG_FILE', LOG_PATH . '/log-' . $today . '.log');
    unset($today);
}

/** (1) put giá trị từ file .env vào chương trình */
{
    if (file_exists($envPath = ROOT_PATH . '/.env')) {
        foreach (explode(PHP_EOL, file_get_contents($envPath)) as $param):
            if (preg_match('#(.*)=(.*)#', trim($param))) {
                putenv($param);
            }
        endforeach;
        unset($envPath);
    }
}

/** (2) Cấu hình timezone và file ghi log */
{

    # Chế độ PRODUCTION thì không hiển thị lỗi
    if (getenv('APP_ENV') === 'PROD') {
        ini_set('display_errors', false);
    } else {
        ini_set('display_errors', true);
    }

    ini_set("log_errors", true);
    ini_set("error_log", ERROR_FILE);
}

/**  (3) Thêm thư viện autoload & khởi chạy ứng dụng */
{
    include ROOT_PATH . "/vendor/autoload.php";

    $app = new App\Core\Application();
    $app->run();

    register_shutdown_function('shutdown');
}
