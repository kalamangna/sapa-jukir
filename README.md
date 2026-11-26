# SAPA JUKIR Sinjai

SAPA JUKIR adalah aplikasi web berbasis Laravel untuk pengelolaan operasional parkir, penugasan petugas, pencatatan serta verifikasi setoran, dan pelaporan retribusi daerah pada Dinas Perhubungan Kabupaten Sinjai.

## Prasyarat Sistem

- PHP 8.2 atau lebih baru
- Composer
- Node.js dan NPM
- Basis data MySQL atau SQLite

## Langkah Instalasi

1. Pasang dependensi PHP:
   ```bash
   composer install
   ```
2. Salin berkas konfigurasi lingkungan dan buat kunci aplikasi:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. Sesuaikan koneksi basis data pada berkas `.env`, lalu jalankan migrasi:
   ```bash
   php artisan migrate
   ```

   Login memakai username. Akun dibatasi satu per role: `admin`, `operator`, dan `pimpinan`.4. Buat tautan penyimpanan publik:
   ```bash
   php artisan storage:link
   ```
5. Pasang dependensi frontend dan kompilasi aset:
   ```bash
   npm install && npm run build
   ```

## Konfigurasi Lingkungan Penting

- `APP_URL`: URL dasar aplikasi
- `DB_CONNECTION`: Driver basis data seperti `mysql` atau `sqlite`
- `DB_DATABASE`: Nama basis data atau lokasi berkas SQLite
- `DB_USERNAME`: Nama pengguna basis data
- `DB_PASSWORD`: Kata sandi basis data
- `FILESYSTEM_DISK`: Disk penyimpanan berkas, gunakan `public` untuk unggahan media

## Perintah Operasional Utama

- Menjalankan server pengembangan lokal:
  ```bash
  php artisan serve
  ```
- Menghitung ulang potensi pendapatan harian dan bulanan dari parameter aktif:
  ```bash
  php artisan potensi:refresh
  ```
- Menyinkronkan peringatan capaian bulanan di bawah 80 persen:
  ```bash
  php artisan capaian:refresh-warnings
  ```
- Menjalankan pengujian otomatis:
  ```bash
  php artisan test
  ```
