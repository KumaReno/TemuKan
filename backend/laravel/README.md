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

Untuk JWT, isi `.env` dengan `JWT_SECRET` acak minimal 32 karakter, `JWT_TTL_MINUTES=60`, serta `JWT_TEST_USER_EMAIL` dan `JWT_TEST_USER_PASSWORD` untuk akun uji lokal. Jangan commit `.env`. Seeder akun JWT hanya berjalan saat `APP_ENV=local`.

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

Login adalah endpoint publik. Endpoint laporan membutuhkan header `Authorization: Bearer <access_token>` yang didapat dari login.

| Method | Endpoint | Respons sukses |
| --- | --- | --- |
| `POST` | `/api/login` | `200`, access token dan data pengguna |
| `GET` | `/api/reports` | `200`, daftar berpaginasi; perlu token |
| `POST` | `/api/reports` | `201`, laporan yang dibuat; perlu token |
| `GET` | `/api/reports/{report}` | `200`, detail laporan; perlu token |
| `PUT` / `PATCH` | `/api/reports/{report}` | `200`, laporan yang diperbarui; perlu token |
| `DELETE` | `/api/reports/{report}` | `200`, pesan penghapusan; perlu token |

Contoh body untuk login memakai akun lokal dari `.env`:

```json
{
  "email": "email-uji-dari-env",
  "password": "password-uji-dari-env"
}
```

Login berhasil mengembalikan `access_token`, `token_type` (`Bearer`), `expires_in`, dan data pengguna. Untuk request laporan, pasang token melalui tab **Authorization → Bearer Token** di Postman. Token berlaku sesuai `JWT_TTL_MINUTES`.

Tanpa token, token keliru, atau token kedaluwarsa, API laporan mengembalikan `401`. Token valid dapat memakai endpoint CRUD seperti biasa.

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
