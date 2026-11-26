# Catatan Perubahan

Seluruh perubahan penting pada proyek SAPA JUKIR Sinjai dicatat dalam berkas ini.
Format mengacu pada [Keep a Changelog](https://keepachangelog.com/id-ID/1.1.0/).

## [1.6.0] - 2026-11-26

### Ditambahkan
- Rate limiting berbasis kombinasi `username` dan IP (maksimal 5 percobaan gagal per menit) serta pencatatan log kegagalan login pada `LoginController`.
- Proteksi anti-bot (*honeypot* dan token waktu pengisian minimal 3 detik) pada `PengaduanController` dan `pengaduan.blade.php`.
- Migrasi `2026_11_26_153500_widen_nik_column_on_pengaduans_table` untuk memperlebar kolom `nik` guna mendukung enkripsi at-rest pada model `Pengaduan`.
- Pengujian otomatis keamanan form login dan pengaduan pada `tests/Feature/SecurityHardeningTest.php`.

### Diubah
- Rate limit route `POST /login` disesuaikan menjadi `throttle:15,1` sebagai lapisan luar NAT, dan `POST /pengaduan` diperketat menjadi `throttle:3,5`.
- Validasi panjang maksimum `username` (`50`) dan `password` (`128`) pada `LoginController`, serta validasi format nomor telepon pada `PengaduanController`.
- Penonaktifan tombol kirim saat proses berlangsung pada `auth/login.blade.php` dan `pengaduan.blade.php` untuk mencegah klik ganda.

## [1.5.0] - 2026-11-26

### Ditambahkan
- Middleware `SecurityHeaders` pada `bootstrap/app.php` untuk menyisipkan `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy`, `Content-Security-Policy`, dan `Strict-Transport-Security` pada koneksi HTTPS.
- Endpoint khusus admin `admin.jukir.document` dan `admin.pengaduan.photo` untuk menyajikan berkas KTP jukir, dokumen pendukung jukir, dan foto aduan masyarakat dari disk privat `local`.
- Pengujian otomatis keamanan pada `tests/Feature/SecurityHardeningTest.php`.

### Diubah
- Penyimpanan `foto_ktp`, `dokumen_pendukung` jukir, dan `foto` pengaduan dipindahkan dari disk `public` ke disk privat `local` dengan fallback kompatibilitas berkas lama.
- Route verifikasi setoran (`admin.setoran.verifikasi`) dan tombol verifikasi pada `admin/setoran/show.blade.php` dibatasi khusus untuk role `admin`.
- Validasi `location_url` dan `whatsapp_url` pada `SiteSettingController` diperketat ke `url:http,https`, validasi `background_color` pada `SambutanController` diperketat ke format hex 6 digit, dan kata sandi pengguna pada `StoreUserRequest` serta `UpdateUserRequest` diwajibkan memuat huruf dan angka.

### Diperbaiki
- Mitigasi Stored XSS dan DOM XSS pada popup peta Leaflet di `welcome.blade.php` serta `public/titik-parkir/show.blade.php`, dan pratinjau unggahan galeri di `admin/gallery/form.blade.php`.
- Mitigasi CSV dan Excel Formula Injection pada ekspor laporan analisis pendapatan di `LaporanController`.
- Pencegahan *race condition* pembayaran tagihan melalui transaksi basis data dan `lockForUpdate()` di `TagihanController::bayar`.
- Penambahan atribut `rel="noopener noreferrer"` pada seluruh tautan `target="_blank"` di halaman admin.

## [1.4.0] - 2026-11-26

### Ditambahkan
- Dukungan banyak pengguna per role dengan menghapus indeks unik `role` melalui migrasi `drop_unique_role_from_users_table`.
- Fitur tambah dan hapus pengguna pada `UserController`, `StoreUserRequest`, route `admin.users`, serta tampilan `create.blade.php` dan `index.blade.php`.
- Tautan menu Manajemen Pengguna pada sidebar admin di `layouts/admin.blade.php`.
- Pengujian akses multi-akun per role, larangan hapus akun sendiri, dan pembaruan akun sendiri di `AccessControlTest`.

### Diperbaiki
- Validasi `UpdateUserRequest` saat admin memperbarui akunnya sendiri tanpa mengirim field `role` dan `status` yang dinonaktifkan di form.
- Penguncian `role` dan `status` akun sendiri pada `UserController::update` serta pencegahan penghapusan akun yang sedang login pada `UserController::destroy`.

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
