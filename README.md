# TemuKan

Aplikasi Lost and Found kampus. Frontend statis saat ini berada di `frontend/` dan masih memakai `localStorage` untuk laporan lokal serta JSONPlaceholder sebagai API latihan.

## Menjalankan

Buka `frontend/index.html` melalui Live Server atau server statis lokal. Tidak diperlukan build step. Tailwind Play CDN dan Google Fonts memerlukan koneksi internet.

## Struktur

- `frontend/`: halaman dan aset browser.
- `frontend/assets/images/`: gambar proyek.
- `backend/`: dokumentasi rancangan API; backend belum diimplementasikan.
- `database/`: lokasi migrasi skema ketika database dipilih.
- `docs/`: dokumentasi proyek.

## Langkah pengembangan backend

Tentukan stack backend dan database, rancang endpoint barang dan klaim, lalu ganti pemanggilan data demo di frontend dengan endpoint TemuKan. Foto sebaiknya disimpan di layanan penyimpanan berkas; database menyimpan URL foto.
