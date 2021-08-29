## How to Run
- jalankan perintah `composer install`
- copy `.env.example`kedalam file `.env`.
- jalankan perintah `php artisan key:generate --ansi`
- jalankan perintah `php artisan migrate` untuk schema database
- jalankan perintah `php artisan db:seed` untuk generate dummy user
- jalankan perintah  `php artisan serve` untuk menjalankan webserver dev dan buka localhost:8000 (default)
- selesai

## Halaman Login
- User : {{hostname}}/login/user
- Admin : {{hostname}}/login/admin
- Password Admin (default) : 12345678
