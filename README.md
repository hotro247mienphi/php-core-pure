# PHP core pure
- Đây là bộ core đơn giản được xây dựng bằng mã nguồn PHP thuần túy.
- Mục đích dùng cho các dự án nhỏ mà có yêu cầu không sử dụng framework nào.

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