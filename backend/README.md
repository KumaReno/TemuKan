# Backend TemuKan

Server-side rendering TemuKan berada di sini.

- `public/index.php`: entry point beranda SSR.
- `router.php`: mengarahkan `/` ke entry point PHP dan mengembalikan permintaan aset statis ke PHP built-in server.
- `src/controllers/HomeController.php`: menangani alur request beranda, meminta data, dan meneruskannya ke view.
- `src/models/Item.php`: model barang dengan property privat, constructor, getter, dan method perilaku.
- `src/models/ItemRepository.php`: mengambil kumpulan data barang untuk controller.
- `src/data/items.php`: kumpulan object `Item` untuk data contoh.
- `src/views/home.php`: halaman beranda yang membentuk HTML.
- `src/views/item-cards.php`: partial yang merender kartu melalui method object `Item`.

Alur beranda adalah `router.php` → `public/index.php` → `HomeController` → `ItemRepository` → `home.php`. Form laporan masih menyimpan data di localStorage browser. Belum ada database atau API multi-pengguna.

## Aplikasi Laravel

Aplikasi Laravel terpisah berada di `laravel/`. Jalankan dengan `cd backend/laravel` lalu `php artisan serve`. Route beranda memakai `ReportController@index`, mengambil laporan dari SQLite melalui model Eloquent, lalu menampilkannya pada `resources/views/reports/index.blade.php`. Migration tambahan menaruh field TemuKan pada tabel `categories` dan `reports`; data demo diisi melalui `php artisan db:seed --class=TemuKanSeeder`.
