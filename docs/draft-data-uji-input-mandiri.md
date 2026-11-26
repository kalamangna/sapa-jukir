# Draft Data Uji SIJUKIR
## Panduan Input Mandiri untuk Pengujian Sistem

Dokumen ini berisi data dummy untuk pengujian SIJUKIR. Semua kode memakai penanda `TEST` agar mudah dicari dan dihapus setelah pengujian.

> Data di dokumen ini tidak otomatis masuk ke database. Input dilakukan manual melalui menu admin.

## Urutan Input

1. Jenis Petugas
2. Data Petugas
3. Jenis Parkir
4. Tarif Parkir
5. Sumber Pendapatan
6. Titik Parkir
7. Wajib Pajak
8. Objek Pajak
9. Objek Tempat Usaha
10. Target Pendapatan
11. Penempatan Petugas
12. Setoran
13. Verifikasi Setoran
14. Unit Usaha
15. Aset Daerah dan Area
16. Pemanfaatan Aset
17. Tagihan dan Pembayaran
18. Okupansi Parkir
19. Capaian Bulanan
20. Sambutan, Galeri, dan Pengaduan
21. Akun Operator dan Pimpinan

## 1. Jenis Petugas

Menu: **Data Master > Jenis Petugas**

| Kode | Nama | Deskripsi | Status |
|---|---|---|---|
| JUKIR-TES-01 | Petugas Tetap Test | Petugas yang ditugaskan secara tetap pada lokasi parkir. | Aktif |
| JUKIR-TES-02 | Petugas Lapangan Test | Petugas berdasarkan kebutuhan operasional. | Aktif |
| JUKIR-TES-03 | Petugas Pengganti Test | Petugas pengganti sementara. | Aktif |

## 2. Data Petugas

Menu: **Data Master > Data Petugas**

### Petugas Ahmad

| Field | Nilai |
|---|---|
| Kode Jukir | JK-TEST-001 |
| NIK | 7307010101900001 |
| Nama | Ahmad Petugas Test |
| Jenis Petugas | Petugas Tetap Test |
| Tempat Lahir | Sinjai |
| Tanggal Lahir | 1990-01-01 |
| Jenis Kelamin | Laki-laki |
| Alamat | Jl. Persatuan, Sinjai |
| Kecamatan | Sinjai Utara |
| Kelurahan | Balangnipa |
| Nomor HP | 081234567801 |
| Status | Aktif |
| Keterangan | Data uji petugas tetap |

### Petugas Siti

| Field | Nilai |
|---|---|
| Kode Jukir | JK-TEST-002 |
| NIK | 7307010202920002 |
| Nama | Siti Petugas Test |
| Jenis Petugas | Petugas Lapangan Test |
| Tempat Lahir | Sinjai |
| Tanggal Lahir | 1992-02-02 |
| Jenis Kelamin | Perempuan |
| Alamat | Jl. Sultan Hasanuddin, Sinjai |
| Kecamatan | Sinjai Utara |
| Kelurahan | Biringere |
| Nomor HP | 081234567802 |
| Status | Aktif |
| Keterangan | Data uji petugas lapangan |

## 3. Jenis Parkir

Menu: **Data Master > Jenis Parkir**

| Kode | Nama | Deskripsi | Status |
|---|---|---|---|
| PJTU-TEST | Parkir Tepi Jalan Umum Test | Parkir pada ruas jalan umum. | Aktif |
| TKP-TEST | Tempat Khusus Parkir Test | Parkir pada lokasi khusus dengan kapasitas tertentu. | Aktif |
| USAHA-TEST | Parkir Kegiatan Usaha Test | Parkir yang berkaitan dengan kegiatan usaha. | Aktif |

## 4. Tarif Parkir

Menu: **Data Master > Tarif Parkir**

| Jenis Parkir | Jenis Kendaraan | Nominal | Berlaku Mulai | Status |
|---|---|---:|---|---|
| Parkir Tepi Jalan Umum Test | Motor | 2000 | 2026-01-01 | Aktif |
| Parkir Tepi Jalan Umum Test | Mobil Kecil | 5000 | 2026-01-01 | Aktif |
| Tempat Khusus Parkir Test | Motor | 3000 | 2026-01-01 | Aktif |
| Tempat Khusus Parkir Test | Mobil Besar | 10000 | 2026-01-01 | Aktif |

## 5. Sumber Pendapatan

Menu: **Data Master > Sumber Pendapatan**

Sumber berikut biasanya sudah tersedia dari migrasi. Jangan membuat duplikat jika sudah ada.

| Kode | Nama | Status |
|---|---|---|
| R-PJTU | Retribusi Parkir Tepi Jalan Umum | Aktif |
| R-TKU | Retribusi Penyediaan Tempat Kegiatan Usaha | Aktif |
| R-TKP | Retribusi Tempat Khusus Parkir | Aktif |
| R-JASA-USAHA | Retribusi Jasa Usaha / Pemanfaatan Aset Daerah | Aktif |
| P-PARKIR | Pajak Parkir | Aktif |

## 6. Titik Parkir

Menu: **Data Master > Titik / Objek Pendapatan**

### Titik Parkir Tepi Jalan Umum

| Field | Nilai |
|---|---|
| Kode Titik | TP-TEST-001 |
| Nama | Parkir Pasar Sentral Test |
| Alamat | Jl. Persatuan, Kabupaten Sinjai |
| Kecamatan | Sinjai Utara |
| Kelurahan | Balangnipa |
| Jenis Parkir | Parkir Tepi Jalan Umum Test |
| Sumber Pendapatan | R-PJTU |
| Status | Aktif |
| Latitude | -5.1245000 |
| Longitude | 120.2535000 |
| Kapasitas Motor | 80 |
| Kapasitas Mobil Kecil | 20 |
| Kapasitas Mobil Besar | 5 |
| Kapasitas Total | 105 |
| Potensi Harian | 750000 |
| Potensi Bulanan | 22500000 |
| Nama Penanggung Jawab | Ahmad Petugas Test |
| Nomor Telepon | 081234567801 |

### Titik Parkir Khusus

| Field | Nilai |
|---|---|
| Kode Titik | TP-TEST-002 |
| Nama | Area Parkir Terminal Test |
| Alamat | Kawasan Terminal Sinjai |
| Kecamatan | Sinjai Utara |
| Kelurahan | Biringere |
| Jenis Parkir | Tempat Khusus Parkir Test |
| Sumber Pendapatan | R-TKP |
| Status | Aktif |
| Latitude | -5.1155000 |
| Longitude | 120.2515000 |
| Kapasitas Motor | 100 |
| Kapasitas Mobil Kecil | 40 |
| Kapasitas Mobil Besar | 10 |
| Kapasitas Total | 150 |
| Potensi Harian | 1000000 |
| Potensi Bulanan | 30000000 |
| Nama Penanggung Jawab | Budi Pengelola Test |
| Nomor Telepon | 081234567803 |

Untuk parkir khusus, kapasitas total dan nama penanggung jawab wajib diisi.

## 7. Wajib Pajak

Menu: **Data Master > Wajib Pajak**

| Field | Nilai |
|---|---|
| Nama | PT Sinjai Parkir Test |
| NPWP | 123456789012345 |
| Nomor Identitas | WP-TEST-001 |
| Alamat | Jl. Persatuan No. 10, Sinjai |
| Nomor Telepon | 081234567804 |
| Email | pajak-test@example.com |
| Status | Aktif |

## 8. Objek Pajak Parkir

Menu: **Data Master > Pajak Parkir > Tambah Objek**

| Field | Nilai |
|---|---|
| Sumber Pendapatan | P-PARKIR |
| Kode | PAJAK-TEST-001 |
| Tipe | Objek Pajak |
| Nama Objek | Area Parkir Mall Sinjai Test |
| Alamat | Jl. Persatuan No. 20, Sinjai |
| Penanggung Jawab | PT Sinjai Parkir Test |
| Identitas | WP-TEST-001 |
| NPWP | 123456789012345 |
| NOP | NOP-730701-TEST-001 |
| Tarif Pajak | 10 |
| Potensi Harian | 500000 |
| Potensi Bulanan | 15000000 |
| Status | Aktif |

Pengujian validasi: coba simpan tanpa NPWP/NOP atau tanpa tarif pajak. Sistem seharusnya menolak.

## 9. Objek Tempat Usaha

Menu: **Data Master > Objek Pendapatan**

| Field | Nilai |
|---|---|
| Sumber Pendapatan | R-TKU |
| Kode | USAHA-TEST-001 |
| Tipe | Tempat Usaha |
| Nama Objek | Kios Terminal Test |
| Alamat | Area Terminal Sinjai |
| Penanggung Jawab | CV Usaha Sinjai Test |
| Jenis Usaha | Kios makanan |
| Tarif Sewa | 1500000 |
| Potensi Harian | 50000 |
| Potensi Bulanan | 1500000 |
| Status | Aktif |

## 10. Target Pendapatan

Menu: **Pendapatan & Monitoring > Target Pendapatan**

| Tahun | Bulan | Sumber | Lokasi/Objek | Target | Catatan |
|---:|---:|---|---|---:|---|
| 2026 | 8 | R-PJTU | Agregat sumber | 54000000 | Target uji Agustus |
| 2026 | 8 | R-TKP | Agregat sumber | 30000000 | Target parkir khusus |
| 2026 | 8 | R-TKU | Kios Terminal Test | 1500000 | Target sewa kios |
| 2026 | 8 | P-PARKIR | Area Parkir Mall Test | 15000000 | Target pajak parkir |

Jangan memasukkan target yang sama dua kali untuk sumber, periode, dan lokasi/objek yang sama.

## 11. Penempatan Petugas

Menu: **Penugasan & Transaksi > Penempatan Petugas**

| Petugas | Titik Parkir | Mulai | Selesai | Status | Keterangan |
|---|---|---|---|---|---|
| Ahmad Petugas Test | Parkir Pasar Sentral Test | 2026-08-01 | 2026-12-31 | Aktif | Penempatan uji PJTU |
| Siti Petugas Test | Area Parkir Terminal Test | 2026-08-01 | 2026-12-31 | Aktif | Penempatan uji parkir khusus |

Pengujian validasi: buat penempatan sama dua kali pada periode yang bertumpuk. Sistem seharusnya menolak.

## 12. Setoran Parkir

Menu: **Penugasan & Transaksi > Setoran**

### Setoran PJTU

| Field | Nilai |
|---|---|
| Sumber Pendapatan | R-PJTU |
| Petugas | Ahmad Petugas Test |
| Titik Parkir | Parkir Pasar Sentral Test |
| Tanggal | 2026-08-21 |
| Jumlah Motor | 100 |
| Jumlah Mobil Kecil | 25 |
| Pendapatan Bruto | 325000 |
| Jumlah Setoran | 300000 |
| Keterangan | Setoran uji parkir tepi jalan umum |

### Setoran Parkir Khusus

| Field | Nilai |
|---|---|
| Sumber Pendapatan | R-TKP |
| Petugas | Siti Petugas Test |
| Titik Parkir | Area Parkir Terminal Test |
| Tanggal | 2026-08-21 |
| Jumlah Motor | 80 |
| Jumlah Mobil Kecil | 30 |
| Pendapatan Bruto | 330000 |
| Jumlah Setoran | 320000 |
| Keterangan | Setoran uji parkir khusus |

Setelah menyimpan, periksa status `Belum Verifikasi`, lalu verifikasi dan cek Dashboard.

## 13. Setoran Non-Parkir

Gunakan untuk menguji bahwa sumber non-parkir tidak membutuhkan petugas dan titik parkir.

| Field | Nilai |
|---|---|
| Sumber Pendapatan | R-TKU |
| Objek Pendapatan | Kios Terminal Test |
| Tanggal | 2026-08-21 |
| Pendapatan Bruto | 1500000 |
| Jumlah Setoran | 1500000 |
| Keterangan | Setoran sewa tempat usaha test |

Petugas dan titik parkir dapat dikosongkan untuk R-TKU atau R-JASA-USAHA.

### Jika muncul error sumber tidak sama

Pesan seperti berikut:

```text
Objek pendapatan harus menggunakan sumber yang sama dengan setoran.
```

berarti sumber pada dropdown **Sumber Pemasukan** berbeda dengan sumber yang melekat pada objek yang dipilih.

Untuk objek `USAHA-TEST-001`, gunakan salah satu pasangan berikut secara konsisten:

| Sumber pada objek | Sumber pada setoran | Objek |
|---|---|---|
| R-TKU | R-TKU | USAHA-TEST-001 - Kios Terminal Test |
| R-JASA-USAHA | R-JASA-USAHA | USAHA-TEST-001 jika objek dibuat di bawah Pemanfaatan Aset |

Jangan memilih `R-TKU` pada sumber setoran jika teks objek menunjukkan `(Retribusi Jasa Usaha / Pemanfaatan Aset Daerah)`. Pilih `R-JASA-USAHA`, atau hapus dan buat ulang objek tersebut dengan sumber `R-TKU` jika objek itu dimaksudkan sebagai tempat kegiatan usaha.

## 14. Capaian Bulanan Manual

Menu: **Pendapatan & Monitoring > Capaian Bulanan**

| Tahun | Bulan | Target | Realisasi | Catatan |
|---:|---:|---:|---:|---|
| 2026 | 8 | 100000000 | 85000000 | Override capaian Agustus untuk pengujian |

Periksa halaman publik. Bulan Agustus seharusnya menampilkan badge `Manual`. Hapus data manual untuk mengembalikan perhitungan otomatis.

## 15. Unit Usaha

Menu: **Operasional > Unit Usaha**

| Field | Nilai |
|---|---|
| Objek Pendapatan | Kios Terminal Test |
| Kode Unit | UNIT-TEST-001 |
| Nama Unit | Kios Minuman Test |
| Penyewa | Siti Penyewa Test |
| Tarif Sewa | 1500000 |
| Status | Aktif |
| Keterangan | Unit usaha uji sistem |

Setelah itu ubah nama penyewa untuk menguji riwayat unit usaha.

## 16. Aset Daerah dan Area

Menu: **Data Master > Aset Daerah**

### Aset

| Field | Nilai |
|---|---|
| Kode Aset | ASET-TEST-001 |
| Nama Aset | Pelataran Terminal Sinjai Test |
| Jenis Aset | Tanah |
| Lokasi | Kawasan Terminal Sinjai |
| Nomor Register | REG-TEST-001 |
| Luas Total | 1000 |
| Status | Aktif |

### Area

| Field | Nilai |
|---|---|
| Kode Area | AREA-TEST-001 |
| Nama Area | Pelataran Utara Test |
| Luas | 300 |
| Tarif Sewa | 250000 |
| Status | Tersedia |
| Keterangan | Area uji pemanfaatan aset |

## 17. Pemanfaatan Aset

Menu: **Operasional > Pemanfaatan Aset**

| Field | Nilai |
|---|---|
| Area Aset | Pelataran Utara Test |
| Pihak Pemanfaat | CV Kegiatan Sinjai Test |
| Jenis Kegiatan | Bazar Akhir Pekan |
| Tanggal Mulai | 2026-08-22 |
| Tanggal Selesai | 2026-08-24 |
| Tarif Sewa | 250000 |
| Nilai Sewa | 750000 |
| Status | Aktif |
| Keterangan | Pemanfaatan area untuk pengujian |

Periksa status area berubah menjadi `Dimanfaatkan` dan tagihan otomatis dibuat.

## 18. Tagihan dan Pembayaran

Menu: **Operasional > Tagihan & Pembayaran**

### Tagihan

| Field | Nilai |
|---|---|
| Sumber Pendapatan | R-TKU |
| Objek Pendapatan | Kios Terminal Test |
| Nomor Tagihan | TAG-TEST-001 |
| Pihak Tertagih | CV Usaha Sinjai Test |
| Uraian | Sewa kios terminal bulan Agustus |
| Tanggal Terbit | 2026-08-01 |
| Jatuh Tempo | 2026-08-31 |
| Nilai Tagihan | 1500000 |
| Status | Terbit |

### Pembayaran sebagian

| Field | Nilai |
|---|---|
| Tanggal Bayar | 2026-08-15 |
| Jumlah Bayar | 750000 |
| Metode | Transfer |
| Referensi | TRX-TEST-001 |
| Catatan | Pembayaran sebagian |

Status tagihan seharusnya menjadi `Sebagian`.

### Pelunasan

| Field | Nilai |
|---|---|
| Tanggal Bayar | 2026-08-25 |
| Jumlah Bayar | 750000 |
| Metode | Tunai |
| Referensi | TRX-TEST-002 |
| Catatan | Pelunasan |

Status tagihan seharusnya menjadi `Lunas`.

## 19. Okupansi Parkir

Menu: **Operasional > Okupansi Parkir**

| Field | Nilai |
|---|---|
| Titik Parkir | Area Parkir Terminal Test |
| Tanggal | 2026-08-21 |
| Jumlah Motor | 70 |
| Jumlah Mobil | 25 |
| Catatan | Pencatatan okupansi uji |

Kapasitas total lokasi adalah 150 sehingga data ini seharusnya berhasil. Coba masukkan jumlah melebihi kapasitas untuk menguji penolakan validasi.

## 20. Sambutan Kepala Dinas

Menu: **Konten Publik > Sambutan Kepala Dinas**

| Field | Nilai |
|---|---|
| Nama Kepala Dinas | Akbar, S.Sos., M.Si. |
| Jabatan | Kepala Dinas Perhubungan Kabupaten Sinjai |
| Deskripsi | SIJUKIR hadir sebagai bagian dari upaya meningkatkan pengelolaan perparkiran dan pendapatan daerah Kabupaten Sinjai yang lebih tertib, transparan, dan akuntabel. Melalui sistem ini, data petugas, titik parkir, objek pendapatan, target, setoran, dan capaian dapat dikelola secara terintegrasi untuk mendukung peningkatan pelayanan publik serta pengambilan keputusan yang lebih tepat. |
| Status | Tampilkan pada halaman publik |

## 21. Galeri Publik

Menu: **Konten Publik > Galeri Publik**

Gunakan foto dummy yang tidak mengandung data pribadi.

| Judul | Kategori | Deskripsi | Status |
|---|---|---|---|
| Penataan Parkir Kabupaten Sinjai | Kegiatan | Dokumentasi kegiatan penataan dan pengelolaan parkir. | Aktif |
| Pelayanan Petugas Parkir | Pelayanan | Aktivitas pelayanan parkir kepada masyarakat. | Aktif |
| Pemanfaatan Area Terminal | Aset Daerah | Dokumentasi pemanfaatan area aset daerah. | Aktif |

## 22. Pengaduan Publik

Input dari halaman publik **Kirim Pengaduan**:

| Field | Nilai |
|---|---|
| Nama Lengkap | Warga Test |
| NIK Pelapor | 7307010101900001 |
| Nomor Telepon/WA | 081234567805 |
| Titik Parkir | Parkir Pasar Sentral Test |
| Lokasi Parkir | Jl. Persatuan |
| Jenis Pengaduan | Tarif parkir |
| Detail | Petugas uji memberikan pelayanan dengan baik. |
| Foto Aduan | Kosongkan untuk uji awal |

Setelah dikirim, ubah status dari `Baru` menjadi `Diproses`, lalu `Selesai`.

## 23. Akun Pengguna Uji

Menu: **Pengaturan > Manajemen Pengguna**

### Operator

| Field | Nilai |
|---|---|
| Nama | Operator Test |
| Email | operator.test@example.com |
| Password | OperatorTest123! |
| Role | Operator |
| Status | Aktif |

### Pimpinan

| Field | Nilai |
|---|---|
| Nama | Pimpinan Test |
| Email | pimpinan.test@example.com |
| Password | PimpinanTest123! |
| Role | Pimpinan |
| Status | Aktif |

## Skenario Pengujian Utama

### Alur parkir tepi jalan umum

1. Buat petugas.
2. Buat titik parkir.
3. Buat penempatan petugas.
4. Buat target.
5. Input setoran.
6. Verifikasi setoran.
7. Periksa Dashboard, capaian, dan laporan.

### Alur Pajak Parkir

1. Buat wajib pajak.
2. Buka menu Pajak Parkir.
3. Buat objek pajak.
4. Isi NPWP/NOP dan tarif pajak.
5. Buat target.
6. Input dan verifikasi setoran.
7. Periksa laporan.

### Alur tempat usaha

1. Buat objek tempat usaha.
2. Buat unit usaha.
3. Buat tagihan.
4. Catat pembayaran sebagian.
5. Catat pelunasan.
6. Periksa status tagihan dan laporan tunggakan.

### Alur pemanfaatan aset

1. Buat aset dan area.
2. Catat pemanfaatan.
3. Periksa perubahan status area.
4. Periksa tagihan otomatis.
5. Catat pembayaran.
6. Periksa indikator pemanfaatan aset pada Dashboard.

### Alur capaian manual

1. Input capaian manual bulan Agustus.
2. Periksa badge `Manual` di halaman publik.
3. Periksa Dashboard Admin.
4. Hapus capaian manual.
5. Pastikan perhitungan otomatis kembali digunakan.

## Pengujian Hak Akses

### Operator

- Dashboard: bisa
- Setoran: bisa
- Penempatan Petugas: bisa
- Target Pendapatan: tidak bisa
- Manajemen Pengguna: tidak bisa

### Pimpinan

- Dashboard: bisa
- Laporan: bisa
- Peringatan Capaian: bisa
- Data Master: tidak bisa
- Setoran: tidak bisa

## Catatan Keamanan

Jangan gunakan data asli untuk pengujian awal. Hindari memasukkan:

- NIK asli;
- NPWP asli;
- password pengguna sebenarnya;
- foto KTP;
- dokumen resmi; dan
- data wajib pajak sebenarnya.

Setelah pengujian selesai, hapus seluruh data yang memakai penanda `TEST`.
