# Backend TemuKan

Backend belum dibuat. Folder ini disiapkan sebagai batas terpisah untuk API server.

Rancangan awal yang disarankan:

- `src/routes/`: endpoint, misalnya `/api/items` dan `/api/claims`.
- `src/controllers/`: validasi request dan penyusunan response.
- `src/services/`: aturan bisnis Lost and Found.
- `src/models/`: akses data.
- `src/middleware/`: autentikasi, validasi, dan error handling.
- `src/config/`: konfigurasi aplikasi dan database.

Pilih stack (misalnya PHP prosedural untuk tugas kuliah, atau Node.js/Express untuk API terpisah) sebelum menambahkan implementasi. Jangan menyimpan secret di Git; gunakan `.env` lokal dan commit contoh variabel tanpa nilainya.
