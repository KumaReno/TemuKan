# TemuKan Laravel

Aplikasi papan informasi barang hilang dan ditemukan di lingkungan kampus. Versi Laravel ini memakai SQLite, Eloquent, Blade, validasi request, dan REST API.

## Menjalankan aplikasi

Dari folder `backend/laravel`:

```bash
composer install
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Buka alamat yang dicetak oleh `php artisan serve`. Pastikan `.env` sudah menunjuk ke database yang benar. Database SQLite lokal berada di `database/database.sqlite`.

## Fitur web

| Method | URL | Fungsi |
| --- | --- | --- |
| `GET` | `/reports` | Melihat daftar laporan |
| `GET` | `/reports/create` | Membuka formulir laporan |
| `POST` | `/reports` | Menyimpan laporan baru |
| `GET` | `/reports/{report}/edit` | Membuka formulir edit |
| `PUT` | `/reports/{report}` | Memperbarui laporan |
| `DELETE` | `/reports/{report}` | Menghapus laporan |

Alamat `/` mengarahkan pengguna ke `/reports`.

## REST API

Semua endpoint API menggunakan awalan `/api`. Kirim header `Accept: application/json` agar respons validasi dan error dikembalikan sebagai JSON.

| Method | Endpoint | Respons sukses |
| --- | --- | --- |
| `GET` | `/api/reports` | `200`, daftar berpaginasi |
| `POST` | `/api/reports` | `201`, laporan yang dibuat |
| `GET` | `/api/reports/{report}` | `200`, detail laporan |
| `PUT` / `PATCH` | `/api/reports/{report}` | `200`, laporan yang diperbarui |
| `DELETE` | `/api/reports/{report}` | `200`, pesan penghapusan |

### Field laporan

| Field | Aturan |
| --- | --- |
| `category_id` | Wajib, kategori harus tersedia |
| `name` | Wajib, 3–100 karakter |
| `status` | Wajib, `hilang` atau `ditemukan` |
| `description` | Wajib, 8–2000 karakter |
| `location` | Wajib, 2–150 karakter |
| `event_date` | Wajib, tanggal hari ini atau sebelumnya (`YYYY-MM-DD`) |
| `reporter_name` | Wajib, 2–100 karakter |
| `contact` | Opsional, maksimal 255 karakter |
| `image` | Opsional, JPG/PNG/WebP maksimal 2 MB |
| `remove_image` | Opsional untuk update, boolean |

Contoh body JSON untuk membuat laporan:

```json
{
  "category_id": 1,
  "name": "Dompet kulit cokelat",
  "status": "hilang",
  "description": "Dompet kulit cokelat tertinggal di sekitar perpustakaan.",
  "location": "Perpustakaan pusat",
  "event_date": "2026-11-25",
  "reporter_name": "Aulia R.",
  "contact": "aulia@example.com"
}
```

Contoh pengujian dengan `curl`:

```bash
curl -H "Accept: application/json" http://127.0.0.1:8000/api/reports
```

Validasi yang gagal mengembalikan status `422`, ID yang tidak ditemukan mengembalikan `404`, dan upload gambar API dapat dikirim memakai `multipart/form-data`. Gambar disimpan pada disk `public`; jalankan `php artisan storage:link` agar bisa ditampilkan.
