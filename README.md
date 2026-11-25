# TemuKan

Aplikasi Lost and Found kampus dengan dua tahap backend: PHP MVC manual sebagai latihan OOP/MVC, dan aplikasi Laravel 12 untuk pengelolaan data melalui SQLite.

## Menjalankan Laravel

Jalankan dari root proyek:

```powershell
cd backend/laravel
php artisan serve
```

Buka alamat yang ditampilkan Artisan, biasanya `http://127.0.0.1:8000`. Halaman beranda Laravel menampilkan laporan dari database SQLite. Migration dijalankan dengan `php artisan migrate`; data contoh dapat diisi dengan `php artisan db:seed --class=TemuKanSeeder`.

## Menjalankan PHP MVC manual

Dari root proyek, jalankan:

```powershell
php -S localhost:8000 -t frontend backend/router.php
```

Buka `http://localhost:8000/`. Backend ini menggunakan data contoh di PHP, sedangkan formulir laporan frontend masih menyimpan data pada `localStorage`. Live Server tidak menjalankan PHP.

## Struktur

- `frontend/`: halaman statis dan aset browser.
- `backend/public/`: entry point aplikasi PHP.
- `backend/src/controllers/`: controller yang mengatur alur permintaan beranda.
- `backend/src/models/`: model `Item` dan repository untuk data barang.
- `backend/src/data/`: kumpulan object barang contoh.
- `backend/src/views/`: halaman dan partial yang menghasilkan HTML.
- `backend/router.php`: router untuk server PHP lokal.
- `backend/laravel/`: aplikasi Laravel, migration, Eloquent model, controller, dan view.
- `database/`: lokasi migrasi skema database.
- `docs/`: dokumentasi teknis.

Beranda Laravel mengikuti alur route → controller → model → view. Saat ini fiturnya berfokus pada daftar laporan; form laporan belum terhubung ke penyimpanan Laravel.
