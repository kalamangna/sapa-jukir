# Catatan Perubahan

Seluruh perubahan penting pada proyek SAPA JUKIR Sinjai dicatat dalam berkas ini.
Format mengacu pada [Keep a Changelog](https://keepachangelog.com/id-ID/1.1.0/).

## [1.3.1] - 2026-11-26

### Diperbaiki
- Title beranda tidak lagi mengulang nama SAPA JUKIR ketika Judul Hero di Pengaturan Situs sudah memuatnya.

## [1.3.0] - 2026-11-26

### Ditambahkan
- Komponen `x-seo` untuk title, description, canonical, Open Graph, Twitter Card, favicon, dan robots pada seluruh halaman publik.
- Deskripsi dan gambar pratinjau tautan pada beranda dari Pengaturan Situs, serta pada detail berita dari ringkasan dan gambar beritanya.
- Berkas `public/favicon.png` dari logo SAPA JUKIR dan pengujian `SeoTest`.

### Diubah
- Halaman login dan seluruh halaman admin memuat `noindex, nofollow`.
- `robots.txt` melarang perayapan `/admin` dan `/login`. Berkas ini hanya berlaku jika berada di akar domain.
- Form pengaduan dan detail titik parkir kini memiliki meta description.

### Dihapus
- `public/favicon.ico` berukuran 0 byte.

## [1.2.0] - 2026-11-26

### Diubah
- Login dan pengelolaan pengguna memakai `username` sebagai pengganti email pada `LoginController`, `RoleMiddleware`, form login, dan layout admin.
- Manajemen pengguna dibatasi satu akun per role. Halaman pengguna hanya mengubah nama, username, password, dan status, tanpa tambah atau hapus pengguna.

### Dihapus
- Kolom `email` dan `email_verified_at` pada tabel `users`, serta `StoreUserRequest` dan halaman tambah pengguna.
- Migrasi `add_username_to_users_table` menghapus akun berlebih per role dan hanya mempertahankan akun dengan id terkecil. Cadangkan tabel `users` sebelum `php artisan migrate` di server.

## [1.1.0] - 2026-11-26

### Ditambahkan
- Pembatasan frekuensi permintaan pada endpoint login dan pengaduan publik melalui middleware `throttle`.
- Pengontrol `PublicController` untuk menangani seluruh halaman publik tanpa closure pada `routes/web.php` sehingga mendukung `route:cache`.
- Pengujian akses *read-only* untuk peran `pimpinan` pada modul operasional di `AccessControlTest`.
- Penyertaan aset frontend terkompilasi pada `public/build` untuk kebutuhan deployment pada server tanpa Node.js.

### Diubah
- Penetapan nilai bawaan `jumlah_koordinator` menjadi `1` pada `StoreTitikParkirRequest` agar titik retribusi non-parkir tetap lolos validasi.
- Pembatasan hak akses peran `pimpinan` pada route dan tampilan operasional menjadi *read-only*.
- Penyelarasan label brand pada `AccessControlTest` ke `SAPA JUKIR`.
- Perapian struktur `.gitignore`, pemindahan dokumen analisis dari root ke `docs/`, serta perapian copywriting pada opsi pengaduan dan subjudul tagihan.

### Diperbaiki
- Penghapusan tag `<a>` bersarang dan elemen `<img>` kosong pada header `welcome.blade.php`.

### Dihapus
- Penghapusan model di luar ruang lingkup Dishub `WajibPajak`, pemindahan berkas internal dari `public/images/` ke `docs/`, dan penghentian pelacakan Git terhadap dump SQL lokal `sijukir_sinjai.sql`.

## [1.0.0] - 2026-11-26

### Ditambahkan
- **Portal Publik**: Halaman beranda dengan statistik realisasi pendapatan, tren bulanan, peta interaktif titik parkir berbasis Leaflet, detail titik parkir publik beserta jadwal dan target petugas, galeri kegiatan, berita, tautan Survei Kepuasan Masyarakat, serta formulir pengaduan masyarakat.
- **Master Data Retribusi Dishub**: Pengelolaan wilayah kecamatan dan kelurahan, jenis parkir, titik parkir, tarif, jenis petugas, data juru parkir, sumber pemasukan resmi Dishub, objek pendapatan, target pendapatan, capaian bulanan manual, alokasi seri karcis, pengguna, pengaturan situs, dan sambutan pimpinan.
- **Operasional Parkir dan Pendapatan**: Penempatan petugas dengan dukungan 1 atau 2 koordinator per lokasi dan validasi anti-tumpang-tindih jadwal, pencatatan setoran beserta parser rentang seri karcis dan verifikasi setoran, pengelolaan tagihan dan pembayaran, unit usaha beserta riwayatnya, pemanfaatan aset daerah, serta okupansi parkir.
- **Pelaporan dan Otomasi**: Laporan analisis pendapatan, capaian realisasi, tunggakan, data jukir, titik parkir, penempatan petugas, tarif, dan setoran dengan dukungan ekspor PDF, Excel, dan CSV; perintah Artisan `potensi:refresh` dan `capaian:refresh-warnings`; serta pencatatan audit log otomatis untuk entitas penting.
- **Kontrol Akses Berbasis Peran**: Pembatasan hak akses pengguna melalui middleware peran untuk akun `admin`, `operator`, dan `pimpinan`.
