# Hướng Dẫn Chạy Chương Trình

## Các bước thực hiện

1. Chạy lệnh: `composer install`
2. Đổi tên file: `.env.xample` thành `.env`
3. Chạy lệnh: `php artisan key:generate`
4. Chạy lệnh: `php artisan migrate`
5. Chạy lệnh: `php artisan db:seed`

## Ghi chú

- Đảm bảo bạn đã cài đặt các công cụ sau trước khi thực hiện:
  - **PHP**
  - **Laravel**
  - **XAMPP**: [Tải tại đây](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.2.12/xampp-windows-x64-8.2.12-0-VS16-installer.exe/download)
  - **Composer**: [Tải tại đây](https://getcomposer.org/Composer-Setup.exe)

- Kiểm tra kết nối cơ sở dữ liệu trong file `.env` trước khi chạy lệnh `migrate` và `db:seed`.