# PHP core pure

* put data to env
```php
if (file_exists($envPath = '.env')) {
    foreach (explode(PHP_EOL, file_get_contents($envPath)) as $param):
        if (preg_match('#(.*)=(.*)#', trim($param))) {
            putenv($param);
        }
    endforeach;
}
```