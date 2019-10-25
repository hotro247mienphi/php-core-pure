# PHP core pure

## packages
- altorouter/altorouter
- symfony/console
- symfony/dotenv
- symfony/var-dumper

## flow code
- Sử dụng htaccess để điều hướng url
- Thư mục chạy là public_html
- File `public_html/index.php` sẽ thêm thư viện `autoload`, sau đó thêm biến môi trường `env` và cuối cùng là khởi tạo `application` và run app.
- Hệ thống tự động log lại `request` và `error`.