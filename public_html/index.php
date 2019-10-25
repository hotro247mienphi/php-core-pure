<?php

include __DIR__ . "/../vendor/autoload.php";

define('ROOT_PATH', __DIR__ . './..');
define('LOG_PATH', ROOT_PATH . '/logs');
define('VIEWS_PATH', ROOT_PATH . '/views');
define('PUBLIC_PATH', ROOT_PATH . '/public_html');

define('THREAD_START', microtime(true));
define('THREAD_RAM', memory_get_usage(true));

define('ERROR_FILE', LOG_PATH . '/error-' . date('Y-m-d') . '.log');
define('LOG_FILE', LOG_PATH . '/log-' . date('Y-m-d') . '.log');

# load env params
$dotenv = new Symfony\Component\Dotenv\Dotenv();
$dotenv->load(ROOT_PATH . '/.env');

# switch mode display errors by enviroment
ini_set('display_errors', getenv('APP_ENV') !== 'PROD');
ini_set("log_errors", true);
ini_set("error_log", ERROR_FILE);

# new application and run
$app = new App\Core\Application();
$app->run();

# register shutdown function
register_shutdown_function('shutdown');