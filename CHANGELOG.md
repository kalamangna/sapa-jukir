# Catatan Perubahan

Seluruh perubahan penting pada proyek SAPA JUKIR Sinjai dicatat dalam berkas ini.
Format mengacu pada [Keep a Changelog](https://keepachangelog.com/id-ID/1.1.0/).

## [1.0.0] - 2026-11-26

### Ditambahkan
- **Portal Publik**: Halaman beranda dengan statistik realisasi pendapatan, tren bulanan, peta interaktif titik parkir berbasis Leaflet, detail titik parkir publik beserta jadwal dan target petugas, galeri kegiatan, berita, tautan Survei Kepuasan Masyarakat, serta formulir pengaduan masyarakat.
- **Master Data Retribusi Dishub**: Pengelolaan wilayah kecamatan dan kelurahan, jenis parkir, titik parkir, tarif, jenis petugas, data juru parkir, sumber pemasukan resmi Dishub, objek pendapatan, target pendapatan, capaian bulanan manual, alokasi seri karcis, pengguna, pengaturan situs, dan sambutan pimpinan.
- **Operasional Parkir dan Pendapatan**: Penempatan petugas dengan dukungan 1 atau 2 koordinator per lokasi dan validasi anti-tumpang-tindih jadwal, pencatatan setoran beserta parser rentang seri karcis dan verifikasi setoran, pengelolaan tagihan dan pembayaran, unit usaha beserta riwayatnya, pemanfaatan aset daerah, serta okupansi parkir.
- **Pelaporan dan Otomasi**: Laporan analisis pendapatan, capaian realisasi, tunggakan, data jukir, titik parkir, penempatan petugas, tarif, dan setoran dengan dukungan ekspor PDF, Excel, dan CSV; perintah Artisan `potensi:refresh` dan `capaian:refresh-warnings`; serta pencatatan audit log otomatis untuk entitas penting.
- **Kontrol Akses Berbasis Peran**: Pembatasan hak akses pengguna melalui middleware peran untuk akun `admin`, `operator`, dan `pimpinan`.
