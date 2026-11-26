# SIJUKIR
## Ebook Panduan Penggunaan dan Presentasi Sistem Admin

**Sistem Informasi Petugas Kabupaten Sinjai**  
**Versi dokumentasi:** 21 Agustus 2026

---

## Daftar Isi

1. [Tentang SIJUKIR](#1-tentang-sijukir)
2. [Tujuan dan Manfaat Sistem](#2-tujuan-dan-manfaat-sistem)
3. [Istilah Penting](#3-istilah-penting)
4. [Peran Pengguna dan Hak Akses](#4-peran-pengguna-dan-hak-akses)
5. [Alur Kerja Utama](#5-alur-kerja-utama)
6. [Panduan Menu Admin](#6-panduan-menu-admin)
7. [Panduan Operasional Harian](#7-panduan-operasional-harian)
8. [Capaian, Peringatan, dan Laporan](#8-capaian-peringatan-dan-laporan)
9. [Skenario Presentasi Sistem](#9-skenario-presentasi-sistem)
10. [Praktik Penggunaan yang Disarankan](#10-praktik-penggunaan-yang-disarankan)
11. [Glosarium](#11-glosarium)

---

## 1. Tentang SIJUKIR

SIJUKIR adalah sistem informasi untuk membantu pengelolaan petugas, titik parkir, objek pendapatan, penerimaan, target pendapatan, pembayaran, okupansi, dan pelaporan di lingkungan Kabupaten Sinjai.

Sistem ini menghubungkan data operasional dengan data pendapatan. Dengan demikian, pengguna tidak hanya mencatat aktivitas, tetapi juga dapat melihat hubungan antara:

- potensi pendapatan;
- target yang ditetapkan;
- realisasi setoran;
- capaian terhadap target; dan
- laporan untuk pengawasan serta pengambilan keputusan.

Halaman publik menampilkan informasi umum seperti profil, statistik, galeri, peta lokasi, pengaduan, dan capaian. Area admin digunakan untuk mengelola data dan proses internal.

---

## 2. Tujuan dan Manfaat Sistem

### 2.1 Tujuan

SIJUKIR dibangun untuk:

1. menyediakan satu sumber data pengelolaan perparkiran dan pendapatan daerah;
2. mendata petugas dan penempatannya pada lokasi;
3. mencatat transaksi setoran dan proses verifikasinya;
4. mengelola target pendapatan berdasarkan sumber, titik, atau objek;
5. memantau capaian pendapatan secara berkala;
6. menyediakan laporan operasional dan analisis pendapatan; dan
7. menyediakan jejak audit atas perubahan data penting.

### 2.2 Manfaat bagi organisasi

- **Admin:** mengatur data dasar, akun pengguna, konfigurasi, dan pengawasan sistem.
- **Operator:** menjalankan pencatatan operasional seperti penempatan, setoran, tagihan, pembayaran, dan okupansi.
- **Pimpinan:** melihat dashboard, capaian, peringatan, dan laporan untuk evaluasi.
- **Masyarakat:** memperoleh informasi publik dan menyampaikan pengaduan.

---

## 3. Istilah Penting

| Istilah | Pengertian dalam sistem |
|---|---|
| Petugas/Jukir | Petugas parkir yang didata dalam master petugas. |
| Jenis Petugas | Kategori atau jenis petugas yang digunakan untuk mengelompokkan petugas. |
| Titik Parkir | Lokasi parkir yang memiliki identitas, alamat, kapasitas, potensi, dan status. |
| Objek Pendapatan | Objek non-lokasi atau objek pendapatan seperti tempat usaha, aset daerah, objek pajak, atau parkir khusus. |
| Sumber Pendapatan | Kategori asal pendapatan, misalnya retribusi tempat khusus parkir, retribusi parkir tepi jalan umum, pajak parkir, atau pemanfaatan aset. |
| Target Pendapatan | Nilai yang ingin dicapai untuk periode tertentu, baik pada tingkat sumber maupun lokasi/objek. |
| Setoran | Catatan penerimaan yang disetorkan dan diverifikasi melalui sistem. |
| Penempatan Petugas | Relasi antara petugas dan titik parkir pada periode tertentu. |
| Audit Trail | Riwayat perubahan data yang merekam tindakan pengguna pada objek tertentu. |
| Okupansi | Catatan jumlah kendaraan yang menggunakan kapasitas parkir pada waktu tertentu. |
| Penanggung Jawab Lokasi | Pihak yang bertanggung jawab atas suatu lokasi atau parkir khusus. Pihak ini berbeda dari petugas/jukir operasional. |
| Realisasi Terverifikasi | Nilai setoran yang sudah berstatus `terverifikasi` dan digunakan dalam perhitungan capaian. |

---

## 4. Peran Pengguna dan Hak Akses

### 4.1 Admin

Admin memiliki akses paling luas, meliputi:

- Dashboard;
- seluruh Data Master;
- pengelolaan pengguna;
- menu operasional;
- penempatan petugas dan setoran;
- peringatan capaian;
- audit trail; dan
- laporan.

Admin bertanggung jawab menjaga kualitas data dasar dan konfigurasi sistem.

### 4.2 Operator

Operator berfokus pada proses operasional. Operator dapat mengakses:

- Dashboard;
- tagihan dan pembayaran;
- unit usaha;
- pemanfaatan aset;
- okupansi parkir;
- penempatan petugas;
- setoran; dan
- proses verifikasi setoran.

Operator tidak mengelola seluruh master data atau akun pengguna.

### 4.3 Pimpinan

Pimpinan berfokus pada pemantauan dan evaluasi. Pimpinan dapat mengakses:

- Dashboard;
- peringatan capaian; dan
- laporan.

Pimpinan menggunakan data yang sudah tersedia untuk melihat kondisi pendapatan dan menentukan tindak lanjut.

### 4.4 Prinsip pembagian akses

Pembagian akses mengikuti prinsip berikut:

- **Admin mengatur data dasar.**
- **Operator mencatat kegiatan operasional.**
- **Pimpinan membaca hasil dan mengevaluasi.**

---

## 5. Alur Kerja Utama

Alur kerja SIJUKIR dapat dipresentasikan sebagai berikut:

```text
Data Master
    |
    v
Titik/Objek Pendapatan + Sumber Pendapatan + Tarif
    |
    v
Petugas dan Penempatan Petugas
    |
    v
Target Pendapatan
    |
    v
Setoran dan Verifikasi
    |
    v
Dashboard, Capaian, Peringatan, dan Laporan
```

### 5.1 Urutan implementasi data

1. Buat sumber pendapatan.
2. Buat jenis parkir dan tarif bila diperlukan.
3. Daftarkan petugas dan jenis petugas.
4. Daftarkan titik parkir atau objek pendapatan.
5. Atur target pendapatan.
6. Tempatkan petugas pada titik parkir.
7. Catat setoran dan lakukan verifikasi.
8. Catat tagihan, pembayaran, pemanfaatan aset, atau okupansi bila sesuai jenis pendapatan.
9. Pantau dashboard dan capaian.
10. Cetak atau ekspor laporan.

---

## 6. Panduan Menu Admin

## 6.1 Dashboard

**Tujuan:** memberikan ringkasan kondisi sistem dan pendapatan pada satu halaman.

**Informasi yang tersedia antara lain:**

- jumlah petugas dan petugas aktif;
- jumlah titik parkir dan titik aktif;
- jumlah penempatan;
- jumlah tarif dan tarif aktif;
- potensi harian dan bulanan;
- jumlah setoran;
- total pendapatan bruto;
- total jumlah setoran terverifikasi;
- total selisih;
- capaian petugas harian;
- pendapatan berdasarkan sumber;
- potensi, target, realisasi, capaian, dan potensi belum tergali per sumber;
- jumlah area aset yang dimanfaatkan dan persentase pemanfaatan aset;
- grafik tren bulanan potensi, target, realisasi terverifikasi, dan capaian;
- ranking kinerja sumber;
- lokasi yang perlu perhatian;
- objek yang perlu perhatian; dan
- ringkasan penerimaan.

**Cara menggunakan:**

1. Buka menu **Dashboard**.
2. Perhatikan periode yang digunakan oleh sistem, terutama bulan berjalan.
3. Bandingkan target dan realisasi.
4. Gunakan bagian ranking atau peringatan untuk menentukan data yang perlu ditindaklanjuti.

**Catatan:** capaian pendapatan menggunakan realisasi setoran yang berstatus terverifikasi.

## 6.2 Data Petugas

**Tujuan:** menyimpan data petugas/jukir yang menjalankan kegiatan parkir.

**Kegiatan utama:**

- melihat daftar petugas;
- menambah petugas;
- mengubah data petugas;
- melihat status aktif atau tidak aktif; dan
- menghapus data bila belum digunakan oleh transaksi atau relasi lain.

**Data yang umumnya dikelola:** identitas petugas, jenis petugas, kontak, dan status.

**Cara menggunakan:**

1. Buka **Data Petugas**.
2. Pilih **Tambah** untuk membuat data baru.
3. Isi identitas sesuai dokumen resmi.
4. Tentukan jenis dan status petugas.
5. Simpan.
6. Perbarui data jika terjadi perubahan penugasan atau identitas.

Data petugas menjadi dasar untuk proses **Penempatan Petugas** dan pencatatan setoran.

## 6.3 Jenis Petugas

**Tujuan:** mengelompokkan petugas berdasarkan jenis atau kategori yang berlaku di organisasi.

**Kegiatan utama:** menambah, mengubah, mengaktifkan, menonaktifkan, dan menghapus jenis petugas yang belum digunakan.

**Praktik yang disarankan:** gunakan nama kategori yang konsisten dan hindari membuat dua kategori dengan arti yang sama.

## 6.4 Titik / Objek Pendapatan

Menu ini menjadi pintu masuk utama untuk mendata lokasi parkir dan informasi pendapatan berbasis lokasi.

### Titik parkir

Titik parkir memuat:

- kode dan nama titik;
- alamat;
- kecamatan dan kelurahan;
- jenis parkir;
- sumber pendapatan;
- koordinat peta;
- status;
- kapasitas motor;
- kapasitas mobil kecil dan mobil besar;
- kapasitas total;
- potensi harian dan bulanan;
- dokumentasi; dan
- penanggung jawab lokasi.

**Catatan penting:** penanggung jawab lokasi berbeda dari master petugas. Petugas adalah pelaksana operasional, sedangkan penanggung jawab lokasi adalah pihak yang bertanggung jawab atas lokasi atau parkir khusus. Nomor telepon penanggung jawab bersifat opsional.

### Objek pendapatan

Objek pendapatan digunakan untuk data seperti:

- tempat usaha;
- aset daerah;
- objek pajak; dan
- parkir khusus yang dimodelkan sebagai objek pendapatan.

Data yang dapat dikelola meliputi sumber pendapatan, kode, nama, alamat, penanggung jawab, identitas, data pajak, data aset/usaha, luas, tarif sewa, kontrak, potensi, dan status.

**Cara menggunakan:**

1. Tentukan apakah data yang akan dicatat merupakan titik parkir atau objek pendapatan.
2. Pilih sumber pendapatan yang sesuai.
3. Lengkapi identitas dan lokasi.
4. Isi kapasitas dan potensi bila data tersebut relevan.
5. Isi penanggung jawab untuk objek atau parkir khusus bila diperlukan.
6. Simpan.

## 6.5 Gallery Publik

**Tujuan:** mengelola gambar yang tampil pada halaman publik.

**Kegiatan utama:**

- menambah gambar;
- memberi judul atau keterangan;
- mengatur urutan tampil; dan
- mengaktifkan atau menonaktifkan publikasi gambar.

**Alur:** siapkan gambar yang relevan, unggah, isi informasi pendukung, atur status aktif, lalu periksa halaman publik.

## 6.6 Pengaduan Publik

**Tujuan:** menerima dan menindaklanjuti masukan atau laporan dari masyarakat.

**Kegiatan utama:**

- melihat daftar pengaduan;
- membuka detail pengaduan;
- menandai atau memperbarui status tindak lanjut; dan
- menghapus pengaduan sesuai kebijakan.

Pengaduan baru juga muncul pada notifikasi di bagian atas halaman admin. Gunakan menu ini sebagai sumber informasi lapangan dan bahan perbaikan layanan.

## 6.7 Sambutan Kepala Dinas

**Tujuan:** mengelola sambutan atau pesan pimpinan yang ditampilkan pada halaman publik.

**Kegiatan utama:** mengisi nama, jabatan, foto, deskripsi sambutan, dan status aktif.

**Praktik yang disarankan:** gunakan teks singkat, resmi, dan sesuai periode publikasi. Pastikan hanya satu sambutan yang menjadi konten utama pada halaman publik.

## 6.8 Jenis Parkir

**Tujuan:** menyimpan kategori parkir yang digunakan oleh titik parkir dan tarif.

**Contoh penggunaan:** membedakan tempat khusus parkir, parkir tepi jalan umum, atau kategori lain yang berlaku dalam sistem.

**Urutan penggunaan:** buat jenis parkir terlebih dahulu, kemudian pilih jenis tersebut saat membuat atau mengubah titik parkir.

## 6.9 Tarif Parkir

**Tujuan:** menyimpan tarif parkir berdasarkan jenis parkir dan ketentuan yang berlaku.

**Kegiatan utama:** membuat tarif, menentukan nominal atau parameter tarif, mengatur masa berlaku/status, lalu memperbarui ketika ada perubahan kebijakan.

**Catatan:** jangan membuat tarif baru hanya karena perubahan data transaksi. Tarif adalah data kebijakan; transaksi adalah data realisasi.

## 6.10 Target Pendapatan

**Tujuan:** menetapkan target yang akan dibandingkan dengan realisasi.

Target dapat digunakan pada beberapa lingkup:

- agregat sumber pendapatan;
- titik parkir; atau
- objek pendapatan.

**Cara menggunakan:**

1. Pilih tahun dan bulan.
2. Pilih sumber pendapatan.
3. Tentukan apakah target bersifat agregat atau terkait titik/objek tertentu.
4. Isi nominal target.
5. Simpan.

Sistem menggunakan target ini untuk menghitung capaian, selisih, ranking, peringatan, dan laporan analisis.

## 6.11 Sumber Pendapatan

**Tujuan:** mendefinisikan asal atau kategori pendapatan.

**Contoh kategori:**

- Retribusi Tempat Khusus Parkir;
- Retribusi Parkir Tepi Jalan Umum;
- Pajak Parkir; dan
- Retribusi Jasa Usaha atau pemanfaatan aset daerah.

**Kegiatan utama:** menambah, mengubah deskripsi, mengatur status aktif, dan menonaktifkan sumber yang tidak lagi digunakan.

**Catatan:** sumber pendapatan menjadi penghubung antara titik/objek, target, setoran, tagihan, dan laporan.

## 6.12 Objek Pendapatan

**Tujuan:** mendata objek pendapatan selain atau di luar titik parkir.

**Field penting:**

- sumber pendapatan;
- kode dan nama objek;
- tipe objek;
- alamat;
- data pengelola atau penanggung jawab;
- data wajib pajak;
- NPWP/NOP dan tarif pajak;
- data usaha atau aset;
- luas dan tarif sewa;
- data kontrak;
- potensi harian dan bulanan; serta
- status.

**Pemilihan tipe:**

- **Tempat usaha:** gunakan data usaha dan tarif sewa.
- **Aset daerah:** gunakan data aset, luas, kontrak, dan tarif sewa.
- **Objek pajak:** lengkapi NPWP atau NOP serta tarif pajak.
- **Parkir khusus:** gunakan data yang relevan dengan objek parkir.

Untuk objek bertipe `objek_pajak`, admin juga dapat menggunakan menu khusus **Pajak Parkir**. Menu ini menampilkan data pajak saja dengan proses CRUD yang sama, sehingga pajak terlihat sebagai kelompok tersendiri tanpa menduplikasi data objek pendapatan.

## 6.13 Wajib Pajak

**Tujuan:** menyimpan data pihak yang memiliki kewajiban pajak dan menghubungkannya dengan objek pajak.

**Kegiatan utama:** menambah, mengubah, mengaktifkan, menonaktifkan, dan mengaitkan wajib pajak dengan objek pendapatan.

Data ini membantu menjaga agar informasi pajak tidak diketik berulang pada setiap objek.

## 6.14 Aset Daerah

**Tujuan:** mendata aset daerah dan area yang terkait dengan pemanfaatan aset.

**Kegiatan utama:** mengelola data aset dan menambahkan area aset melalui fitur area.

Menu ini menjadi dasar untuk proses **Pemanfaatan Aset**, termasuk pencatatan penggunaan, masa pemanfaatan, dan nilai terkait.

## 6.15 Manajemen Pengguna

**Tujuan:** mengelola akun yang dapat masuk ke area admin.

**Kegiatan utama:** membuat akun, memperbarui nama atau email, mengatur role, mengaktifkan atau menonaktifkan akun, dan menghapus akun sesuai kebijakan.

**Praktik keamanan:**

- gunakan akun pribadi, bukan akun bersama;
- berikan role paling rendah yang cukup untuk pekerjaan;
- nonaktifkan akun yang tidak lagi digunakan; dan
- jangan membagikan kata sandi.

## 6.16 Capaian Bulanan

**Tujuan:** memasukkan nilai target dan realisasi manual untuk bulan tertentu ketika diperlukan sebagai override resmi.

**Cara menggunakan:**

1. Buka **Capaian Bulanan** pada Data Master.
2. Pilih tahun dan bulan.
3. Isi target, realisasi, dan catatan pendukung.
4. Simpan.

Data manual akan menggantikan perhitungan otomatis untuk bulan yang sama pada capaian halaman publik. Jika data manual dihapus, bulan tersebut kembali menggunakan perhitungan otomatis dari target dan setoran terverifikasi.

Perubahan capaian manual juga tercatat di **Audit Trail**.

## 6.17 Peringatan Capaian

**Tujuan:** memantau sumber, lokasi, atau objek yang capaian pendapatannya berada di bawah ambang perhatian.

**Kegiatan utama:** memfilter status peringatan, membaca target dan realisasi, menulis catatan tindak lanjut, serta mengubah status menjadi ditindaklanjuti atau selesai.

Menu ini digunakan setelah data target dan setoran tersedia.

## 6.18 Audit Trail

**Tujuan:** menyediakan riwayat perubahan data untuk pengawasan dan akuntabilitas.

Audit trail membantu menjawab:

- siapa yang mengubah data;
- objek apa yang berubah;
- kapan perubahan dilakukan; dan
- nilai sebelum serta sesudah perubahan, bila tersedia.

Gunakan menu ini saat melakukan pemeriksaan data, menelusuri koreksi, atau menyiapkan bahan audit.

## 6.19 Tagihan & Pembayaran

**Tujuan:** mengelola tagihan pendapatan dan pencatatan pembayarannya.

**Alur:**

1. Buat tagihan berdasarkan sumber dan objek yang sesuai.
2. Periksa nilai serta periode tagihan.
3. Catat pembayaran yang diterima.
4. Pantau status terbit, sebagian, atau lunas.
5. Gunakan laporan tunggakan untuk tindak lanjut.

## 6.20 Unit Usaha

**Tujuan:** mendata unit usaha yang berkaitan dengan objek atau sumber pendapatan.

**Kegiatan utama:** menambah, mengubah, menonaktifkan, dan melihat riwayat unit usaha.

Riwayat membantu melihat perubahan informasi unit usaha dari waktu ke waktu tanpa kehilangan konteks data sebelumnya.

## 6.21 Pemanfaatan Aset

**Tujuan:** mencatat penggunaan atau pemanfaatan aset daerah.

**Data yang perlu diperhatikan:** aset, pihak pemanfaat, periode, nilai atau tarif, status, dan informasi pendukung lainnya.

Menu ini membantu menghubungkan aset daerah dengan potensi dan realisasi pendapatan.

## 6.22 Okupansi Parkir

**Tujuan:** mencatat tingkat pemakaian kapasitas parkir khusus.

**Cara menggunakan:**

1. Pilih titik parkir khusus.
2. Pilih tanggal pencatatan.
3. Isi jumlah kendaraan motor.
4. Isi jumlah kendaraan mobil.
5. Tambahkan catatan bila diperlukan.
6. Simpan.

Data okupansi dapat dibandingkan dengan kapasitas total titik parkir untuk melihat pemanfaatan lokasi.

## 6.23 Penempatan Petugas

**Tujuan:** menetapkan petugas pada titik parkir tertentu.

**Data penting:** petugas, titik parkir, periode penempatan, status, dan catatan.

**Cara menggunakan:**

1. Pastikan master petugas dan titik parkir sudah tersedia.
2. Buat penempatan baru.
3. Pilih petugas dan titik parkir.
4. Isi periode dan status aktif.
5. Simpan.
6. Nonaktifkan penempatan yang sudah selesai agar data operasional tetap akurat.

Penempatan aktif digunakan dalam pemantauan capaian harian petugas.

## 6.24 Setoran

**Tujuan:** mencatat penerimaan yang berasal dari kegiatan operasional.

**Data penting:** tanggal, sumber pendapatan, titik atau objek, petugas bila relevan, pendapatan bruto, jumlah setoran, selisih, dan status.

**Alur:**

1. Pilih sumber pendapatan.
2. Pilih titik parkir atau objek pendapatan bila transaksi terkait lokasi/objek.
3. Pilih petugas bila transaksi berasal dari petugas.
4. Isi tanggal dan nominal penerimaan.
5. Simpan sebagai catatan setoran.
6. Periksa kembali data.
7. Lakukan verifikasi.

Hanya setoran berstatus **terverifikasi** yang menjadi dasar utama perhitungan realisasi capaian pada dashboard, halaman publik, dan analisis pendapatan.

## 6.25 Laporan

**Tujuan:** menyajikan data sistem dalam bentuk ringkasan, analisis, atau cetakan.

Jenis laporan yang tersedia meliputi:

- laporan utama;
- analisis pendapatan;
- analisis berdasarkan sumber;
- analisis berdasarkan titik/lokasi;
- analisis berdasarkan objek pendapatan;
- laporan tunggakan;
- laporan petugas;
- laporan titik parkir;
- laporan penempatan petugas;
- laporan tarif; dan
- laporan setoran.

Laporan tertentu menyediakan tampilan cetak, PDF, Excel, XLSX, atau CSV sesuai fitur yang tersedia.

---

## 7. Panduan Operasional Harian

### 7.1 Awal hari

1. Buka Dashboard.
2. Periksa petugas aktif dan penempatan aktif.
3. Periksa lokasi yang memiliki target.
4. Periksa peringatan capaian atau data yang belum lengkap.
5. Pastikan tarif dan sumber pendapatan yang dipakai masih aktif.

### 7.2 Saat kegiatan berlangsung

1. Pastikan petugas bertugas pada titik yang benar.
2. Catat transaksi atau setoran secara berkala.
3. Catat okupansi parkir khusus bila diperlukan.
4. Catat tagihan atau pembayaran untuk pendapatan berbasis tagihan.
5. Gunakan catatan untuk menjelaskan koreksi atau kondisi khusus.

### 7.3 Akhir hari

1. Periksa kelengkapan setoran.
2. Verifikasi setoran yang sudah diperiksa.
3. Bandingkan realisasi dengan target harian.
4. Tindak lanjuti selisih yang tidak wajar.
5. Gunakan laporan setoran sebagai rekap harian.

### 7.4 Akhir bulan

1. Pastikan seluruh setoran periode sudah diverifikasi.
2. Periksa target bulan berjalan.
3. Buka analisis pendapatan.
4. Tinjau sumber, lokasi, dan objek dengan capaian rendah.
5. Periksa tunggakan dan pembayaran.
6. Ekspor laporan sebagai bahan rapat atau arsip.

---

## 8. Capaian, Peringatan, dan Laporan

### 8.1 Cara membaca capaian

Secara umum:

$$
\text{Persentase Capaian} = \frac{\text{Realisasi Terverifikasi}}{\text{Target}} \times 100\%
$$

Sistem membandingkan target dengan realisasi pada lingkup yang sesuai, yaitu sumber pendapatan, titik parkir, objek pendapatan, atau total periode.

### 8.2 Mengapa verifikasi penting

Setoran yang belum diverifikasi belum dianggap sebagai realisasi final. Jika operator memasukkan setoran tetapi belum melakukan verifikasi, angka dashboard dan analisis dapat tetap menunjukkan realisasi yang lebih rendah.

### 8.3 Membaca selisih

- Selisih positif berarti target belum tercapai sebesar nilai tersebut.
- Selisih nol berarti realisasi sama dengan target.
- Selisih negatif berarti realisasi melampaui target, apabila tampilan atau laporan menampilkan nilai tersebut.

### 8.4 Menangani peringatan

1. Buka **Peringatan Capaian**.
2. Filter berdasarkan status.
3. Baca sumber atau objek yang perlu perhatian.
4. Periksa data target dan setoran terkait.
5. Tambahkan catatan tindak lanjut.
6. Ubah status sesuai progres.

---

## 9. Skenario Presentasi Sistem

Bagian ini dapat digunakan sebagai naskah demo sekitar 10-15 menit.

### 9.1 Pembukaan

> SIJUKIR adalah sistem informasi yang menghubungkan pendataan petugas dan lokasi dengan pencatatan pendapatan. Sistem ini membantu organisasi mengelola data dari tahap potensi dan target sampai realisasi, capaian, dan laporan.

### 9.2 Tampilkan Dashboard

Jelaskan bahwa Dashboard adalah ringkasan kondisi terkini. Tunjukkan jumlah petugas, titik parkir, potensi, setoran, pendapatan terverifikasi, dan bagian yang perlu perhatian.

### 9.3 Tunjukkan Data Master

Buka **Data Petugas** dan jelaskan bahwa data ini menjadi dasar penempatan. Buka **Titik / Objek Pendapatan** dan jelaskan perbedaan antara titik parkir dan objek pendapatan.

Tekankan bahwa:

- petugas adalah pelaksana operasional;
- penanggung jawab lokasi adalah pihak yang bertanggung jawab atas lokasi; dan
- sumber pendapatan menghubungkan lokasi/objek dengan target dan transaksi.

### 9.4 Tunjukkan Penempatan

Buka **Penempatan Petugas**. Demonstrasikan bagaimana petugas dikaitkan dengan titik parkir dan bagaimana status aktif memengaruhi pemantauan operasional.

### 9.5 Tunjukkan Target

Buka **Target Pendapatan**. Jelaskan bahwa target dapat ditetapkan secara agregat pada sumber atau secara spesifik pada titik/objek.

### 9.6 Tunjukkan Setoran dan Verifikasi

Buka **Setoran**, buat atau tampilkan catatan setoran, lalu tunjukkan proses verifikasi. Tekankan bahwa realisasi capaian memakai setoran yang sudah terverifikasi.

### 9.7 Tunjukkan Capaian dan Laporan

Kembali ke Dashboard atau buka **Peringatan Capaian** dan **Laporan**. Tunjukkan perbandingan target dan realisasi, sumber yang memiliki capaian rendah, serta pilihan cetak atau ekspor laporan.

### 9.8 Penutup

> Dengan alur ini, SIJUKIR membantu memastikan data pendapatan tidak berdiri sendiri. Setiap capaian dapat ditelusuri kembali ke sumber, lokasi atau objek, target, setoran, dan proses verifikasinya.

---

## 10. Praktik Penggunaan yang Disarankan

### Kualitas data

- Gunakan kode yang unik dan konsisten.
- Hindari memasukkan data yang sama lebih dari satu kali.
- Bedakan titik parkir dengan objek pendapatan.
- Pastikan kecamatan dan kelurahan sesuai.
- Gunakan status aktif/nonaktif sesuai kondisi sebenarnya.

### Target dan realisasi

- Tetapkan target sebelum periode pelaporan dimulai.
- Pastikan target tidak tercatat ganda pada lingkup yang sama.
- Verifikasi setoran setelah pemeriksaan.
- Jangan mengubah data target untuk menyesuaikan realisasi tanpa dasar kebijakan.

### Keamanan

- Gunakan akun sesuai role.
- Jangan berbagi akun.
- Periksa kembali data sebelum menghapus.
- Gunakan Audit Trail untuk menelusuri perubahan.
- Lakukan ekspor laporan secara teratur sebagai arsip organisasi.

### Presentasi

- Mulai dari masalah dan tujuan, bukan dari daftar menu.
- Gunakan satu contoh data dari master sampai laporan.
- Jelaskan perbedaan target, setoran, verifikasi, dan capaian.
- Tunjukkan manfaat untuk admin, operator, pimpinan, dan masyarakat.
- Tutup dengan alur data yang dapat ditelusuri.

---

## 11. Glosarium

**Agregat sumber**  
Target atau realisasi yang dihitung pada tingkat sumber pendapatan tanpa mengunci pada satu titik atau objek.

**Capaian**  
Persentase realisasi terhadap target.

**Dashboard**  
Halaman ringkasan indikator utama dan kondisi operasional.

**Master data**  
Data dasar yang menjadi referensi bagi proses transaksi dan laporan.

**Objek pendapatan**  
Entitas pendapatan yang dapat berupa tempat usaha, aset daerah, objek pajak, atau parkir khusus.

**Penempatan aktif**  
Penempatan petugas yang masih berlaku dan digunakan dalam pemantauan.

**Potensi**  
Perkiraan kemampuan pendapatan berdasarkan lokasi atau objek.

**Realisasi terverifikasi**  
Jumlah setoran yang sudah diperiksa dan berstatus terverifikasi.

**Setoran**  
Catatan uang yang diterima atau disetorkan dari kegiatan pendapatan.

**Sumber pendapatan**  
Kategori asal penerimaan yang dipakai lintas modul.

**Titik parkir**  
Lokasi parkir yang memiliki identitas, koordinat, kapasitas, dan potensi.

---

## Ringkasan Satu Halaman

```text
1. Siapkan sumber pendapatan, jenis parkir, tarif, petugas, dan lokasi/objek.
2. Hubungkan petugas dengan lokasi melalui Penempatan Petugas.
3. Tetapkan target berdasarkan periode dan lingkup yang sesuai.
4. Catat setoran, tagihan, pembayaran, atau okupansi sesuai proses pendapatan.
5. Verifikasi setoran agar masuk ke realisasi.
6. Pantau Dashboard dan Peringatan Capaian.
7. Gunakan Laporan untuk evaluasi, rapat, arsip, dan pengambilan keputusan.
```

**Pesan utama:** SIJUKIR mengubah data operasional menjadi informasi pendapatan yang dapat dipantau, diverifikasi, dan dipertanggungjawabkan.
